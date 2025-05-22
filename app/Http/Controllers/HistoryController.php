<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatBarang;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    /**
     * Display activity logs.
     */
    public function index()
    {
        // Get riwayat barang (item history) with pagination
        $histories = RiwayatBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('history.index', compact('histories'));
    }
    
    /**
     * Display filtered activity logs.
     */
    public function filter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $userId = $request->input('user_id');
        $barangId = $request->input('barang_id');
        
        // Query for riwayat barang (item history)
        $historiesQuery = RiwayatBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc');
            
        // Apply date filters if provided
        if ($startDate && $endDate) {
            $historiesQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        // Apply user filter if provided
        if ($userId) {
            $historiesQuery->where('user_id', $userId);
        }
        
        // Apply barang filter if provided
        if ($barangId) {
            $historiesQuery->where('barang_id', $barangId);
        }
        
        // Get final results with pagination
        $histories = $historiesQuery->paginate(20);
        
        return view('history.index', compact('histories', 'startDate', 'endDate', 'userId', 'barangId'));
    }
    
    /**
     * Generate report based on history data.
     */
    public function generateReport()
    {
        // Monthly statistics for barang
        $barangStats = RiwayatBarang::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total'),
            'jenis_aktivitas'
        )
        ->groupBy('year', 'month', 'jenis_aktivitas')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get()
        ->groupBy(['year', 'month']);
        
        return view('history.report', compact('barangStats'));
    }
} 