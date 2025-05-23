<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\PeminjamanController as ApiPeminjamanController;
use App\Models\Barang;
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
        $barangs = Barang::where('jumlah', '>', 0)
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
        
        if ($barang->jumlah < $validated['jumlah']) {
            return back()
                ->withInput()
                ->with('error', 'Jumlah barang tidak mencukupi. Tersedia: ' . $barang->jumlah);
        }

        try {
            DB::beginTransaction();

            // Create the peminjaman
            $peminjaman = new Peminjaman();
            $peminjaman->user_id = Auth::id();
            $peminjaman->barang_id = $validated['barang_id'];
            $peminjaman->peminjam = $validated['peminjam'];
            $peminjaman->jenis = $validated['jenis'];
            $peminjaman->kelas = $validated['kelas'];
            $peminjaman->jumlah = $validated['jumlah'];
            $peminjaman->tanggal_pinjam = $validated['tanggal_pinjam'];
            $peminjaman->tanggal_kembali = $validated['tanggal_kembali'];
            $peminjaman->status = 'dipinjam';
            
            if (!$peminjaman->save()) {
                throw new \Exception('Gagal menyimpan data peminjaman');
            }

            // Update stock on the item
            $jumlahSebelum = $barang->jumlah;
            $barang->jumlah -= $validated['jumlah'];
            
            if ($barang->jumlah == 0) {
                $barang->status = 'dipinjam';
            }
            
            $barang->save();

            // Log to RiwayatBarang
            $riwayat = new RiwayatBarang([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'pinjam',
                'jumlah' => $validated['jumlah'],
                'jumlah_sebelum' => $jumlahSebelum,
                'jumlah_sesudah' => $barang->jumlah,
                'keterangan' => 'Peminjaman oleh ' . $validated['peminjam'] . ' (' . $validated['jenis'] . ' - ' . $validated['kelas'] . ')',
                'user_id' => Auth::id(),
            ]);
            
            if (!$riwayat->save()) {
                throw new \Exception('Gagal mencatat riwayat peminjaman');
            }

            DB::commit();
            
            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error for debugging
            \Log::error('Error in PeminjamanController@store: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan peminjaman: ' . $e->getMessage());
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
        $barangs = Barang::orderBy('nama_barang', 'asc')->get();
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
        ]);

        try {
            DB::beginTransaction();

            $oldBarangId = $peminjaman->barang_id;
            $oldJumlah = $peminjaman->jumlah;
            $oldStatus = $peminjaman->status;
            
            // If changing quantity or barang, check stock availability
            if ($validated['barang_id'] != $oldBarangId || $validated['jumlah'] != $oldJumlah) {
                $barang = Barang::findOrFail($validated['barang_id']);
                $availableStock = $barang->jumlah;
                if ($validated['barang_id'] == $oldBarangId) {
                    $availableStock += $oldJumlah;
                }
                
                if ($availableStock < $validated['jumlah']) {
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Jumlah barang tidak mencukupi. Tersedia: ' . $availableStock);
                }
                
                // If changing barang, restore old barang's stock
                if ($validated['barang_id'] != $oldBarangId) {
                    $oldBarang = Barang::findOrFail($oldBarangId);
                    $oldBarang->jumlah += $oldJumlah;
                    if ($oldBarang->jumlah > 0) {
                        $oldBarang->status = 'tersedia';
                    }
                    $oldBarang->save();
                    
                    // Create history for old barang
                    RiwayatBarang::create([
                        'barang_id' => $oldBarang->id,
                        'jenis_aktivitas' => 'kembali',
                        'jumlah' => $oldJumlah,
                        'jumlah_sebelum' => $oldBarang->jumlah - $oldJumlah,
                        'jumlah_sesudah' => $oldBarang->jumlah,
                        'keterangan' => 'Pengembalian dari peminjaman (perubahan barang)',
                        'user_id' => Auth::id(),
                    ]);
                }
                
                // Update new barang's stock
                $jumlahSebelum = $barang->jumlah;
                $barang->jumlah -= $validated['jumlah'];
                if ($barang->jumlah == 0) {
                    $barang->status = 'dipinjam';
                }
                $barang->save();
                
                // Create history for new barang
                RiwayatBarang::create([
                    'barang_id' => $barang->id,
                    'jenis_aktivitas' => 'pinjam',
                    'jumlah' => $validated['jumlah'],
                    'jumlah_sebelum' => $jumlahSebelum,
                    'jumlah_sesudah' => $barang->jumlah,
                    'keterangan' => 'Peminjaman oleh ' . $validated['peminjam'] . ' (' . $validated['jenis'] . ' - ' . $validated['kelas'] . ')',
                    'user_id' => Auth::id(),
                ]);
            }
            
            // Update peminjaman record
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
            $jumlahSebelum = $barang->jumlah;
            $barang->jumlah += $peminjaman->jumlah;
            
            if ($barang->jumlah > 0) {
                $barang->status = 'tersedia';
            }
            
            $barang->save();
            
            // Update peminjaman record
            $peminjaman->status = 'dikembalikan';
            $peminjaman->tanggal_dikembalikan = now();
            $peminjaman->save();
            
            // Log to RiwayatBarang
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'kembali',
                'jumlah' => $peminjaman->jumlah,
                'jumlah_sebelum' => $jumlahSebelum,
                'jumlah_sesudah' => $barang->jumlah,
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
                    $jumlahSebelum = $barang->jumlah;
                    $barang->jumlah += $peminjaman->jumlah;
                    
                    if ($barang->jumlah > 0) {
                        $barang->status = 'tersedia';
                    }
                    
                    $barang->save();
                    
                    // Log to RiwayatBarang
                    RiwayatBarang::create([
                        'barang_id' => $barang->id,
                        'jenis_aktivitas' => 'kembali',
                        'jumlah' => $peminjaman->jumlah,
                        'jumlah_sebelum' => $jumlahSebelum,
                        'jumlah_sesudah' => $barang->jumlah,
                        'keterangan' => 'Pengembalian dari peminjaman yang dihapus',
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