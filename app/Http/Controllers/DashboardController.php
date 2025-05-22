<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the dashboard with summary data.
     */
    public function index(Request $request)
    {
        // Get counts for barang by condition
        $totalBarang = Barang::count();
        $stokBaik = Barang::where('kondisi', 'Baik')->count();
        $stokKurang = Barang::where('kondisi', 'Kurang Baik')->count();
        $stokRusak = Barang::where('kondisi', 'Rusak')->count();
        
        // Get active loans count
        $activeLoans = Peminjaman::where('status', 'dipinjam')->count();
        
        // Get items with low stock
        $lowStock = Barang::where('stok', '<', 5)->get();
        
        // Get recent activity history
        $recentHistory = RiwayatBarang::with(['barang', 'user'])
            ->latest()
            ->take(5)
            ->get();
            
        return view('dashboard', compact(
            'totalBarang',
            'stokBaik',
            'stokKurang',
            'stokRusak',
            'activeLoans',
            'lowStock',
            'recentHistory'
        ));
    }
} 