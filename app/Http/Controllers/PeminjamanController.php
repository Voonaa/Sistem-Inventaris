<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\PeminjamanController as ApiPeminjamanController;
use App\Models\Barang;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\RiwayatBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    protected $apiPeminjamanController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,operator');
        $this->apiPeminjamanController = App::make(ApiPeminjamanController::class);
    }

    /**
     * Display a listing of the loans.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'barang']);
        
        // Filter by status if provided
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status === 'terlambat') {
                $query->whereNull('tanggal_dikembalikan')
                    ->where('tanggal_kembali', '<', now())
                    ->where('status', 'dipinjam');
            } else {
                $query->where('status', $status);
            }
        }
        
        $peminjamans = $query->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * Display a listing of the overdue loans.
     */
    public function getOverdue()
    {
        $overduePeminjamans = Peminjaman::with(['user', 'barang'])
            ->whereNull('tanggal_dikembalikan')
            ->where('tanggal_kembali', '<', now())
            ->where('status', 'dipinjam')
            ->paginate(10);
        
        return view('peminjaman.overdue', compact('overduePeminjamans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)
            ->orderBy('nama_barang', 'asc')
            ->get();
        
        return view('peminjaman.create', compact('barangs'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjam' => 'required|string|max:255',
            'jenis' => 'required|in:siswa,guru',
            'kelas' => 'required|string|max:50',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Check if there's enough stock
        $barang = Barang::findOrFail($validated['barang_id']);
        
        if ($barang->stok < $validated['jumlah']) {
            return back()->withInput()->with('error', 'Stok barang tidak mencukupi. Tersedia: ' . $barang->stok);
        }

        try {
            DB::beginTransaction();

            // Create the peminjaman
            $peminjaman = Peminjaman::create([
                'user_id' => Auth::id(), // User yang menginput peminjaman (petugas)
                'barang_id' => $validated['barang_id'],
                'peminjam' => $validated['peminjam'],
                'jenis' => $validated['jenis'],
                'kelas' => $validated['kelas'], 
                'jumlah' => $validated['jumlah'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'dipinjam',
            ]);

            // Update stock on the item
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum - $validated['jumlah'];
            
            $barang->stok = $stokSesudah;
            $barang->save();

            // Log to RiwayatBarang
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'peminjaman',
                'jumlah' => $validated['jumlah'],
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan' => 'Dipinjam oleh ' . $validated['peminjam'] . ' (' . $validated['jenis'] . ' - ' . $validated['kelas'] . ')',
                'user_id' => Auth::id(),
            ]);

            DB::commit();
            
            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified loan.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'barang']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function edit(Peminjaman $peminjaman)
    {
        $barangs = Barang::where('stok', '>', 0)
            ->orWhere('id', $peminjaman->barang_id) // Include currently assigned item
            ->orderBy('nama_barang', 'asc')
            ->get();
            
        return view('peminjaman.edit', compact('peminjaman', 'barangs'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'peminjam' => 'required|string|max:255',
            'jenis' => 'required|in:siswa,guru',
            'kelas' => 'required|string|max:50',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        try {
            DB::beginTransaction();

            $oldBarangId = $peminjaman->barang_id;
            $oldJumlah = $peminjaman->jumlah;
            $oldStatus = $peminjaman->status;
            
            // If returning item or changing item/quantity, adjust inventory
            if (($oldStatus === 'dipinjam' && $validated['status'] === 'dikembalikan') || 
                $oldBarangId !== $validated['barang_id'] ||
                $oldJumlah !== $validated['jumlah']) {
                
                // If returning or changing barang, return stock to the old barang
                if ($oldStatus === 'dipinjam' && ($validated['status'] === 'dikembalikan' || $oldBarangId !== $validated['barang_id'])) {
                    $oldBarang = Barang::findOrFail($oldBarangId);
                    $oldStokBefore = $oldBarang->stok;
                    $oldBarang->stok += $oldJumlah;
                    $oldBarang->save();
                    
                    // Log return to the old item
                    RiwayatBarang::create([
                        'barang_id' => $oldBarangId,
                        'jenis_aktivitas' => 'pengembalian',
                        'jumlah' => $oldJumlah,
                        'stok_sebelum' => $oldStokBefore,
                        'stok_sesudah' => $oldBarang->stok,
                        'keterangan' => 'Dikembalikan oleh ' . $validated['peminjam'] . ' (' . $validated['jenis'] . ' - ' . $validated['kelas'] . ')',
                        'user_id' => Auth::id(),
                    ]);
                }
                
                // If status is still 'dipinjam' and changing item or borrowing new item
                if ($validated['status'] === 'dipinjam') {
                    // If changing item or changing quantity, adjust inventory for the new item
                    if ($oldBarangId !== $validated['barang_id'] || $oldJumlah !== $validated['jumlah']) {
                        $newBarang = Barang::findOrFail($validated['barang_id']);
                        
                        // Make sure there's enough stock
                        if ($newBarang->stok < $validated['jumlah']) {
                            DB::rollBack();
                            return back()->withInput()->with('error', 'Stok barang tidak mencukupi. Tersedia: ' . $newBarang->stok);
                        }
                        
                        $newStokBefore = $newBarang->stok;
                        $newBarang->stok -= $validated['jumlah'];
                        $newBarang->save();
                        
                        // Log borrowing for the new item
                        RiwayatBarang::create([
                            'barang_id' => $validated['barang_id'],
                            'jenis_aktivitas' => 'peminjaman',
                            'jumlah' => $validated['jumlah'],
                            'stok_sebelum' => $newStokBefore,
                            'stok_sesudah' => $newBarang->stok,
                            'keterangan' => 'Dipinjam oleh ' . $validated['peminjam'] . ' (' . $validated['jenis'] . ' - ' . $validated['kelas'] . ')',
                            'user_id' => Auth::id(),
                        ]);
                    }
                }
            }
            
            // Update peminjaman record
            if ($validated['status'] === 'dikembalikan' && !$peminjaman->tanggal_dikembalikan) {
                $validated['tanggal_dikembalikan'] = now();
            }
            
            $peminjaman->update($validated);
            
            DB::commit();
            
            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Return borrowed item.
     */
    public function returnItem(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Item sudah dikembalikan sebelumnya.');
        }
        
        try {
            DB::beginTransaction();
            
            // Update barang stock
            $barang = $peminjaman->barang;
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum + $peminjaman->jumlah;
            
            $barang->stok = $stokSesudah;
            $barang->save();
            
            // Update peminjaman record
            $peminjaman->status = 'dikembalikan';
            $peminjaman->tanggal_dikembalikan = now();
            $peminjaman->save();
            
            // Log to RiwayatBarang
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'pengembalian',
                'jumlah' => $peminjaman->jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan' => 'Dikembalikan oleh ' . $peminjaman->peminjam . ' (' . $peminjaman->jenis . ' - ' . $peminjaman->kelas . ')',
                'user_id' => Auth::id(),
            ]);
            
            DB::commit();
            
            return redirect()->route('peminjaman.index')
                ->with('success', 'Barang berhasil dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengembalikan barang: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        try {
            DB::beginTransaction();
            
            // If the item was borrowed and not returned, restore the stock
            if ($peminjaman->status === 'dipinjam' && !$peminjaman->tanggal_dikembalikan) {
                $barang = $peminjaman->barang;
                if ($barang) {
                    $stokSebelum = $barang->stok;
                    $stokSesudah = $stokSebelum + $peminjaman->jumlah;
                    
                    $barang->stok = $stokSesudah;
                    $barang->save();
                    
                    // Log to RiwayatBarang
                    RiwayatBarang::create([
                        'barang_id' => $barang->id,
                        'jenis_aktivitas' => 'penyesuaian',
                        'jumlah' => $peminjaman->jumlah,
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $stokSesudah,
                        'keterangan' => 'Pembatalan peminjaman: ' . $peminjaman->peminjam . ' (' . $peminjaman->jenis . ' - ' . $peminjaman->kelas . ')',
                        'user_id' => Auth::id(),
                    ]);
                }
            }
            
            $peminjaman->delete();
            
            DB::commit();
            
            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus peminjaman: ' . $e->getMessage());
        }
    }
} 