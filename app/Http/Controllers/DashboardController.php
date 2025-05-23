<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Quick Stats
        $stats = [
            'total_barang' => Barang::count(),
            'total_kategori' => DB::table('barangs')->whereNotNull('kategori')->distinct('kategori')->count('kategori'),
            'total_users' => User::count(),
            'peminjaman_aktif' => Peminjaman::where('status', 'dipinjam')->count(),
        ];

        // Barang dengan stok menipis (kurang dari 5)
        $barangMenipis = Barang::where('stok', '<', 5)
            ->where('status', 'tersedia')
            ->select('kode_barang', 'nama_barang', 'stok')
            ->limit(5)
            ->get();

        // Peminjaman terlambat
        $peminjamanTerlambat = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now())
            ->whereNotNull('barang_id')
            ->with(['user:id,name', 'barang'])
            ->limit(5)
            ->get();

        // Riwayat peminjaman terakhir
        $riwayatPeminjaman = Peminjaman::whereNotNull('barang_id')
            ->with(['user:id,name', 'barang'])
            ->latest()
            ->limit(10)
            ->get();

        // Data untuk grafik peminjaman per hari (7 hari terakhir)
        $peminjamanChart = Peminjaman::select(
            DB::raw('DATE(tanggal_pinjam) as date'),
            DB::raw('count(*) as total')
        )
            ->whereNotNull('barang_id')
            ->where('tanggal_pinjam', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d/m'),
                    'total' => $item->total
                ];
            });

        // Data untuk grafik status barang
        $statusBarang = Barang::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('dashboard', compact(
            'stats',
            'barangMenipis',
            'peminjamanTerlambat',
            'riwayatPeminjaman',
            'peminjamanChart',
            'statusBarang'
        ));
    }
} 