<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'barang']);
        
        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }
        
        // Filter by search term
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('barang', function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                });
            });
        }
        
        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        
        return $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'peminjam' => 'required|string|max:255',
            'jenis' => 'required|in:siswa,guru',
            'kelas' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try {
            DB::beginTransaction();
            
            // Check stock
            $barang = Barang::findOrFail($request->barang_id);
            if ($barang->stok < $request->jumlah) {
                return response()->json([
                    'message' => 'Insufficient stock',
                    'available' => $barang->stok,
                    'requested' => $request->jumlah
                ], 400);
            }
            
            // Create peminjaman
            $peminjaman = new Peminjaman();
            $peminjaman->user_id = $request->user_id;
            $peminjaman->barang_id = $request->barang_id;
            $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
            $peminjaman->tanggal_kembali = $request->tanggal_kembali;
            $peminjaman->peminjam = $request->peminjam;
            $peminjaman->jenis = $request->jenis;
            $peminjaman->kelas = $request->kelas;
            $peminjaman->jumlah = $request->jumlah;
            $peminjaman->status = 'dipinjam';
            $peminjaman->catatan = $request->catatan;
            
            // Decrement stock
            $stokSebelum = $barang->stok;
            $barang->stok -= $request->jumlah;
            $barang->save();
            
            // Create history record
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'peminjaman',
                'jumlah' => $request->jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $barang->stok,
                'keterangan' => 'Peminjaman barang oleh ' . $request->peminjam . ' (' . $request->jenis . ' - ' . $request->kelas . ')',
                'user_id' => auth()->id(),
            ]);
            
            $peminjaman->save();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Peminjaman berhasil dibuat',
                'data' => $peminjaman->load(['user', 'barang'])
            ], Response::HTTP_CREATED);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while creating the loan',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        return response()->json($peminjaman->load(['user', 'barang']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|required|in:dipinjam,dikembalikan,terlambat',
            'tanggal_dikembalikan' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'denda' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try {
            DB::beginTransaction();
            
            // If status is being changed to "returned"
            if ($request->status === 'dikembalikan' && $peminjaman->status !== 'dikembalikan') {
                $peminjaman->tanggal_dikembalikan = $request->tanggal_dikembalikan ?? now();
                
                // Return item to inventory
                $barang = $peminjaman->barang;
                $stokSebelum = $barang->stok;
                $barang->stok += $peminjaman->jumlah;
                $barang->save();
                
                // Create history record
                RiwayatBarang::create([
                    'barang_id' => $barang->id,
                    'jenis_aktivitas' => 'pengembalian',
                    'jumlah' => $peminjaman->jumlah,
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $barang->stok,
                    'keterangan' => 'Pengembalian barang oleh ' . $peminjaman->peminjam . ' (' . $peminjaman->jenis . ' - ' . $peminjaman->kelas . ')',
                    'user_id' => auth()->id(),
                ]);
            }
            
            if ($request->has('status')) {
                $peminjaman->status = $request->status;
            }
            
            if ($request->has('denda')) {
                $peminjaman->denda = $request->denda;
            }
            
            if ($request->has('catatan')) {
                $peminjaman->catatan = $request->catatan;
            }
            
            $peminjaman->save();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Peminjaman berhasil diperbarui',
                'data' => $peminjaman->load(['user', 'barang'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while updating the loan',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        // Only allow deletion if status is 'dikembalikan'
        if ($peminjaman->status !== 'dikembalikan') {
            return response()->json([
                'message' => 'Cannot delete an active loan. Return the item first.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $peminjaman->delete();
        
        return response()->json([
            'message' => 'Peminjaman berhasil dihapus'
        ]);
    }
    
    /**
     * Get overdue loans
     */
    public function getOverdue()
    {
        $overdueLoans = Peminjaman::with(['user', 'barang'])
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now())
            ->get();
            
        return response()->json($overdueLoans);
    }
} 