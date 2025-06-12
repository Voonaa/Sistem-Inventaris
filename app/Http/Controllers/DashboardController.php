<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\RiwayatBarang;

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
    public function index()
    {
        // Basic statistics
        $totalBarang = Barang::count();
        $totalKategori = count(config('categories'));
        $totalUsers = User::count();
        $peminjamanAktif = Peminjaman::count();
        
        // Get recent activities
        $recentActivities = RiwayatBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // System status indicators
        $barangKurangBaik = Barang::where('kondisi', 'rusak')
            ->orWhere('kondisi', 'rusak_ringan')
            ->count();

        $peminjamanTerlambat = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now())
            ->count();
        
        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalUsers',
            'peminjamanAktif',
            'recentActivities',
            'barangKurangBaik',
            'peminjamanTerlambat'
        ));
    }
} 