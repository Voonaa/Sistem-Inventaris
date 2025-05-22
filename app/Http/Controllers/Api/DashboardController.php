<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get summary statistics for the dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Count total items
        $totalBarang = Barang::count();
        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();
        
        // Count active loans
        $activePeminjaman = Peminjaman::where('status', 'dipinjam')->count();
        $overdueLoans = Peminjaman::where('status', 'terlambat')->count();
        
        // Count users by role
        $usersByRole = User::select('role')
            ->selectRaw('count(*) as count')
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();
        
        // Calculate statistics for items
        $barangStats = [
            'total' => $totalBarang,
            'available' => Barang::where('status', 'tersedia')->count(),
            'borrowed' => Barang::where('status', 'dipinjam')->count(),
            'maintenance' => Barang::where('status', 'dalam_perbaikan')->count(),
        ];
        
        // Calculate statistics for books
        $bukuStats = [
            'total' => $totalBuku,
            'totalCopies' => Buku::sum('stok'),
            'borrowed' => Buku::sum('dipinjam'),
            'available' => Buku::sum(DB::raw('stok - dipinjam')),
        ];
        
        // Calculate recent activity (loans in the last 30 days)
        $recentLoans = Peminjaman::where('tanggal_pinjam', '>=', now()->subDays(30))
            ->count();
        $recentReturns = Peminjaman::where('tanggal_dikembalikan', '>=', now()->subDays(30))
            ->count();
        
        // Get stock per category
        $stokPerKategori = Barang::select('kategoris.nama as kategori', DB::raw('COUNT(*) as jumlah'))
            ->join('sub_kategoris', 'barangs.sub_kategori_id', '=', 'sub_kategoris.id')
            ->join('kategoris', 'sub_kategoris.kategori_id', '=', 'kategoris.id')
            ->groupBy('kategoris.id', 'kategoris.nama')
            ->get()
            ->pluck('jumlah', 'kategori')
            ->toArray();
            
        // Get stock per condition
        $stokPerKondisi = Barang::select('kondisi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('kondisi')
            ->get()
            ->pluck('jumlah', 'kondisi')
            ->toArray();
            
        // Get loans per study program (prodi)
        $peminjamanPerProdi = Peminjaman::select('jenis as prodi', DB::raw('COUNT(*) as jumlah'))
            ->where('status', 'dipinjam')
            ->groupBy('jenis')
            ->get()
            ->pluck('jumlah', 'prodi')
            ->toArray();
        
        return response()->json([
            'barang' => $barangStats,
            'buku' => $bukuStats,
            'peminjaman' => [
                'active' => $activePeminjaman,
                'overdue' => $overdueLoans,
                'recentLoans' => $recentLoans,
                'recentReturns' => $recentReturns,
            ],
            'users' => $usersByRole,
            'total_kategori' => $totalKategori,
            
            // New requested fields
            'total_barang' => $totalBarang,
            'stok_per_kategori' => $stokPerKategori,
            'stok_per_kondisi' => $stokPerKondisi,
            'peminjaman_aktif' => $activePeminjaman,
            'peminjaman_per_prodi' => $peminjamanPerProdi,
        ], Response::HTTP_OK);
    }
} 