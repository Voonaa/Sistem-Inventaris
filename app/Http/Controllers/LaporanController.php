<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\RiwayatBarang;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    /**
     * Constructor - Apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,operator');
    }
    
    /**
     * Display the main reports index page.
     */
    public function index()
    {
        // Count data for dashboard stats
        $totalBarang = Barang::count();
        $totalPeminjaman = Peminjaman::count();
        $totalRiwayatBarang = RiwayatBarang::count();
        
        // Get recent activities
        $recentPeminjaman = Peminjaman::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $recentRiwayat = RiwayatBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('laporan.index', compact(
            'totalBarang',
            'totalPeminjaman',
            'totalRiwayatBarang',
            'recentPeminjaman',
            'recentRiwayat'
        ));
    }
    
    /**
     * Generate inventaris (inventory) report.
     */
    public function inventaris(Request $request)
    {
        // Redirect to barang report since inventaris view doesn't exist
        return redirect()->route('laporan.barang')
            ->with('info', 'Laporan inventaris dialihkan ke laporan barang');
    }
    
    /**
     * Generate barang (item) report.
     */
    public function barang(Request $request)
    {
        $barang = Barang::all();
        
        return view('laporan.barang', compact('barang'));
    }
    
    /**
     * Generate perpustakaan (library) report.
     */
    public function perpustakaan(Request $request)
    {
        // Get general library items (barang with kategori=perpustakaan)
        $barangPerpustakaan = Barang::where('kategori', 'perpustakaan')->get();
        
        return view('laporan.perpustakaan', compact('barangPerpustakaan'));
    }
    
    /**
     * Generate peminjaman (borrowing) report.
     */
    public function peminjaman(Request $request)
    {
        // Filter options
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $status = $request->input('status');
        
        // Query with date filter
        $query = Peminjaman::with(['user', 'barang'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
            
        // Add status filter if specified
        if ($status) {
            $query->where('status', $status);
        }
        
        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->get();
        
        return view('laporan.peminjaman', compact('peminjamans', 'startDate', 'endDate', 'status'));
    }
    
    /**
     * Generate pergerakan (item movement) report.
     */
    public function pergerakan(Request $request)
    {
        // Filter options
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $jenis = $request->input('jenis_aktivitas');
        
        // Query with date filter
        $query = RiwayatBarang::with(['user', 'barang'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            
        // Add activity type filter if specified
        if ($jenis) {
            $query->where('jenis_aktivitas', $jenis);
        }
        
        $riwayats = $query->orderBy('created_at', 'desc')->get();
        
        // Get all activity types for filter dropdown
        $jenisAktivitas = RiwayatBarang::distinct()->pluck('jenis_aktivitas')->toArray();
        
        return view('laporan.pergerakan', compact('riwayats', 'startDate', 'endDate', 'jenis', 'jenisAktivitas'));
    }
    
    /**
     * Generate riwayat barang (item history) report.
     */
    public function riwayatBarang(Request $request)
    {
        $riwayat = RiwayatBarang::with(['user', 'barang'])->get();
        
        return view('laporan.riwayat-barang', compact('riwayat'));
    }
    
    /**
     * Export report to CSV
     */
    public function export(Request $request, $type)
    {
        $fileName = $type . '_report_' . date('Y-m-d_H-i-s');
        
        switch ($type) {
            case 'inventaris':
                // Redirect to barang export as inventaris export doesn't exist
                return redirect()->route('laporan.export', ['type' => 'barang'])
                    ->with('info', 'Export inventaris dialihkan ke export barang');
                break;
                
            case 'barang':
                $barangs = Barang::all();
                
                return $this->exportToCSV($fileName, function($handle) use ($barangs) {
                    // Add headers
                    fputcsv($handle, [
                        'Kode Barang',
                        'Nama Barang',
                        'Kategori',
                        'Sub Kategori',
                        'Stok',
                        'Kondisi',
                        'Lokasi',
                        'Harga Perolehan',
                        'Sumber Dana'
                    ]);
                    
                    // Add data rows
                    foreach ($barangs as $barang) {
                        fputcsv($handle, [
                            $barang->kode_barang,
                            $barang->nama_barang,
                            $barang->kategori_label,
                            $barang->sub_kategori_label ?? '-',
                            $barang->stok,
                            $barang->kondisi,
                            $barang->lokasi ?? '-',
                            $barang->harga_perolehan ?? '-',
                            $barang->sumber_dana ?? '-'
                        ]);
                    }
                });
                break;
                
            case 'perpustakaan':
                // Get general library items (barang with kategori=perpustakaan)
                $barangPerpustakaan = Barang::where('kategori', 'perpustakaan')->get();
                
                return $this->exportToCSV($fileName, function($handle) use ($barangPerpustakaan) {
                    // Add headers
                    fputcsv($handle, [
                        'Kode Barang',
                        'Nama Barang',
                        'Sub Kategori',
                        'Stok',
                        'Kondisi',
                        'Lokasi'
                    ]);
                    
                    // Add data rows
                    foreach ($barangPerpustakaan as $barang) {
                        fputcsv($handle, [
                            $barang->kode_barang,
                            $barang->nama_barang,
                            $barang->sub_kategori_label ?? '-',
                            $barang->stok,
                            $barang->kondisi,
                            $barang->lokasi ?? '-'
                        ]);
                    }
                });
                break;
                
            case 'peminjaman':
                // Filter options
                $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
                $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
                $status = $request->input('status');
                
                // Query with date filter
                $query = Peminjaman::with(['user', 'barang'])
                    ->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
                    
                // Add status filter if specified
                if ($status) {
                    $query->where('status', $status);
                }
                
                $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->get();
                
                return $this->exportToCSV($fileName, function($handle) use ($peminjamans) {
                    // Add headers
                    fputcsv($handle, [
                        'Tanggal Pinjam',
                        'Tanggal Kembali',
                        'Nama Peminjam',
                        'Barang',
                        'Jumlah',
                        'Status',
                        'Catatan'
                    ]);
                    
                    // Add data rows
                    foreach ($peminjamans as $peminjaman) {
                        fputcsv($handle, [
                            $peminjaman->tanggal_pinjam,
                            $peminjaman->tanggal_kembali ?? '-',
                            $peminjaman->user->name ?? '-',
                            $peminjaman->barang->nama_barang ?? '-',
                            $peminjaman->jumlah,
                            $peminjaman->status,
                            $peminjaman->catatan ?? '-'
                        ]);
                    }
                });
                break;
                
            case 'pergerakan':
                // Filter options
                $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
                $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
                $jenis = $request->input('jenis_aktivitas');
                
                // Query with date filter
                $query = RiwayatBarang::with(['user', 'barang'])
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                    
                // Add activity type filter if specified
                if ($jenis) {
                    $query->where('jenis_aktivitas', $jenis);
                }
                
                $riwayats = $query->orderBy('created_at', 'desc')->get();
                
                return $this->exportToCSV($fileName, function($handle) use ($riwayats) {
                    // Add headers
                    fputcsv($handle, [
                        'Tanggal',
                        'Pengguna',
                        'Jenis Aktivitas',
                        'Barang',
                        'Jumlah',
                        'Keterangan'
                    ]);
                    
                    // Add data rows
                    foreach ($riwayats as $riwayat) {
                        fputcsv($handle, [
                            $riwayat->created_at,
                            $riwayat->user->name ?? '-',
                            $riwayat->jenis_aktivitas,
                            $riwayat->barang->nama_barang ?? '-',
                            $riwayat->jumlah,
                            $riwayat->keterangan ?? '-'
                        ]);
                    }
                });
                break;
                
            case 'pengguna':
                // Get all users
                $users = User::all();
                
                return $this->exportToCSV($fileName, function($handle) use ($users) {
                    // Add headers
                    fputcsv($handle, [
                        'ID',
                        'Nama',
                        'Email',
                        'Role',
                        'Terdaftar Pada'
                    ]);
                    
                    // Add data rows
                    foreach ($users as $user) {
                        fputcsv($handle, [
                            $user->id,
                            $user->name,
                            $user->email,
                            $user->role,
                            $user->created_at
                        ]);
                    }
                });
                break;
                
            case 'riwayat':
                // Filter options
                $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
                $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
                
                // Get histories
                $histories = RiwayatBarang::with(['user', 'barang'])
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                return $this->exportToCSV($fileName, function($handle) use ($histories) {
                    // Add headers
                    fputcsv($handle, [
                        'Tanggal',
                        'Pengguna',
                        'Jenis Aktivitas',
                        'Barang',
                        'Jumlah',
                        'Keterangan'
                    ]);
                    
                    // Add data rows
                    foreach ($histories as $history) {
                        fputcsv($handle, [
                            $history->created_at,
                            $history->user->name ?? '-',
                            $history->jenis_aktivitas,
                            $history->barang->nama_barang ?? '-',
                            $history->jumlah,
                            $history->keterangan ?? '-'
                        ]);
                    }
                });
                break;
                
            default:
                return back()->with('error', 'Jenis laporan tidak valid');
        }
    }

    /**
     * Export data to CSV
     * 
     * @param string $fileName The file name without extension
     * @param \Closure $callback Function to write data to the CSV file
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function exportToCSV($fileName, \Closure $callback)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '.csv"',
        ];

        return new StreamedResponse(function() use ($callback) {
            $handle = fopen('php://output', 'w');
            
            // Use UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            $callback($handle);
            
            fclose($handle);
        }, 200, $headers);
    }
} 