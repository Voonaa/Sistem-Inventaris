<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\RiwayatBarangController as ApiRiwayatBarangController;
use App\Models\Barang;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class RiwayatBarangController extends Controller
{
    protected $apiRiwayatBarangController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,operator');
        $this->apiRiwayatBarangController = App::make(ApiRiwayatBarangController::class);
    }

    public static function tambahRiwayat($barang_id, $jenis_aktivitas, $jumlah, $keterangan = null)
    {
        $barang = Barang::findOrFail($barang_id);
        $jumlah_sebelum = $barang->jumlah;
        
        // Hitung jumlah sesudah berdasarkan jenis aktivitas
        $jumlah_sesudah = $jumlah_sebelum;
        switch ($jenis_aktivitas) {
            case 'tambah':
                $jumlah_sesudah = $jumlah_sebelum + $jumlah;
                break;
            case 'kurang':
            case 'pinjam':
                $jumlah_sesudah = $jumlah_sebelum - $jumlah;
                break;
            case 'kembali':
                $jumlah_sesudah = $jumlah_sebelum + $jumlah;
                break;
            case 'hapus':
                $jumlah_sesudah = 0;
                break;
        }

        // Buat riwayat
        RiwayatBarang::create([
            'barang_id' => $barang_id,
            'jenis_aktivitas' => $jenis_aktivitas,
            'jumlah' => $jumlah,
            'jumlah_sebelum' => $jumlah_sebelum,
            'jumlah_sesudah' => $jumlah_sesudah,
            'keterangan' => $keterangan,
            'user_id' => Auth::id()
        ]);

        // Update jumlah barang
        if ($jenis_aktivitas != 'hapus') {
            $barang->jumlah = $jumlah_sesudah;
            $barang->save();
        }
    }

    /**
     * Display a listing of the item history.
     */
    public function index()
    {
        $riwayat = RiwayatBarang::with(['barang', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('riwayat-barang.index', compact('riwayat'));
    }

    /**
     * Display the specified item history.
     */
    public function show(RiwayatBarang $riwayatBarang)
    {
        $riwayatBarang->load(['barang', 'user']);
        return view('riwayat-barang.show', compact('riwayatBarang'));
    }

    /**
     * Display a summary of item history.
     */
    public function getSummary()
    {
        $response = $this->apiRiwayatBarangController->getSummary();
        $summary = $response->getData()->data;
        
        return view('riwayat-barang.summary', compact('summary'));
    }

    /**
     * Display history for a specific item.
     */
    public function getItemHistory(Request $request)
    {
        $barangId = $request->input('barang_id');
        
        if (!$barangId) {
            $barangs = Barang::orderBy('nama', 'asc')->get();
            return view('riwayat-barang.item-select', compact('barangs'));
        }
        
        $barang = Barang::findOrFail($barangId);
        $riwayat = RiwayatBarang::where('barang_id', $barangId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('riwayat-barang.item-history', compact('barang', 'riwayat'));
    }
} 