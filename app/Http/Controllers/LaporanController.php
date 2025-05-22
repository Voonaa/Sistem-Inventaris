<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\RiwayatBarang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use App\Exports\PeminjamanExport;
use App\Exports\RiwayatBarangExport;

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
        $totalBuku = Buku::count();
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
            'totalBuku',
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
        $barangs = Barang::with('kategori', 'subKategori')->get();
        
        return view('laporan.inventaris', compact('barangs'));
    }
    
    /**
     * Generate barang (item) report.
     */
    public function barang(Request $request)
    {
        $barang = Barang::with('kategori', 'subKategori')->get();
        
        return view('laporan.barang', compact('barang'));
    }
    
    /**
     * Generate buku (book) report.
     */
    public function buku(Request $request)
    {
        $buku = Buku::all();
        
        return view('laporan.buku', compact('buku'));
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
     * Export report to PDF or Excel
     */
    public function export(Request $request, $type)
    {
        $format = $request->input('format', 'pdf');
        $fileName = $type . '_report_' . date('Y-m-d_H-i-s');
        
        switch ($type) {
            case 'inventaris':
                $barangs = Barang::with('kategori', 'subKategori')->get();
                
                if ($format === 'pdf') {
                    $pdf = PDF::loadView('laporan.exports.inventaris_pdf', compact('barangs'));
                    return $pdf->download($fileName . '.pdf');
                } else {
                    return Excel::download(new BarangExport($barangs), $fileName . '.xlsx');
                }
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
                
                if ($format === 'pdf') {
                    $pdf = PDF::loadView('laporan.exports.peminjaman_pdf', compact('peminjamans', 'startDate', 'endDate'));
                    return $pdf->download($fileName . '.pdf');
                } else {
                    return Excel::download(new PeminjamanExport($peminjamans), $fileName . '.xlsx');
                }
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
                
                if ($format === 'pdf') {
                    $pdf = PDF::loadView('laporan.exports.pergerakan_pdf', compact('riwayats', 'startDate', 'endDate'));
                    return $pdf->download($fileName . '.pdf');
                } else {
                    return Excel::download(new RiwayatBarangExport($riwayats), $fileName . '.xlsx');
                }
                break;
                
            default:
                return back()->with('error', 'Jenis laporan tidak valid');
        }
    }
} 