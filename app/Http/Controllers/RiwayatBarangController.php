<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\RiwayatBarangController as ApiRiwayatBarangController;
use App\Models\Barang;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RiwayatBarangController extends Controller
{
    protected $apiRiwayatBarangController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,operator');
        $this->apiRiwayatBarangController = App::make(ApiRiwayatBarangController::class);
    }

    /**
     * Display a listing of the item history.
     */
    public function index()
    {
        $riwayatBarangs = RiwayatBarang::with(['barang', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('riwayat-barang.index', compact('riwayatBarangs'));
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