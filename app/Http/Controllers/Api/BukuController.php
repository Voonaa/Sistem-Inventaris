<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BukuStoreRequest;
use App\Http\Requests\BukuUpdateRequest;
use App\Models\Buku;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $perPage = $request->per_page ?? 10;
        $sortBy = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $kategori = $request->kategori ?? '';
        
        $query = Buku::query();
        
        // Apply search filters
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        // Filter by kategori if provided
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        // Apply sorting
        $query->orderBy($sortBy, $sortDirection);
        
        return $query->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BukuStoreRequest $request)
    {
        $validated = $request->validated();
        
        // Handle file upload if present
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('buku', 'public');
            $validated['gambar'] = $path;
        }
        
        $buku = Buku::create($validated);
        
        // Create initial history record
        RiwayatBarang::create([
            'buku_id' => $buku->id,
            'jenis_aktivitas' => 'tambah',
            'jumlah' => $validated['stok'],
            'stok_sebelum' => 0,
            'stok_sesudah' => $validated['stok'],
            'keterangan' => 'Penambahan buku baru',
            'user_id' => Auth::id(),
        ]);
        
        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $buku
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        return $buku->load('riwayatBarang');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BukuUpdateRequest $request, Buku $buku)
    {
        $validated = $request->validated();
        
        // Handle file upload if present
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
            
            $path = $request->file('gambar')->store('buku', 'public');
            $validated['gambar'] = $path;
        }
        
        // Check if stock has changed
        if (isset($validated['stok']) && $validated['stok'] != $buku->stok) {
            $selisih = $validated['stok'] - $buku->stok;
            $jenisAktivitas = $selisih > 0 ? 'tambah' : 'kurang';
            
            // Create history record for stock change
            RiwayatBarang::create([
                'buku_id' => $buku->id,
                'jenis_aktivitas' => $jenisAktivitas == 'tambah' ? 'tambah' : 'kurang',
                'jumlah' => abs($selisih),
                'stok_sebelum' => $buku->stok,
                'stok_sesudah' => $validated['stok'],
                'keterangan' => $jenisAktivitas == 'tambah' ? 'Penambahan stok buku' : 'Pengurangan stok buku',
                'user_id' => Auth::id(),
            ]);
        }
        
        $buku->update($validated);
        
        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data' => $buku
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        // Check if buku is being borrowed
        if ($buku->dipinjam > 0) {
            return response()->json([
                'message' => 'Buku tidak dapat dihapus karena sedang dipinjam'
            ], 422);
        }
        
        // Check if buku has associated barang
        if ($buku->barang()->exists()) {
            return response()->json([
                'message' => 'Buku tidak dapat dihapus karena terkait dengan data barang'
            ], 422);
        }
        
        // Delete image if exists
        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }
        
        $buku->delete();
        
        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ]);
    }
    
    /**
     * Get all book categories.
     */
    public function getKategori()
    {
        $categories = Buku::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');
            
        return response()->json($categories);
    }
} 