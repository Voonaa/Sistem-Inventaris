<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RiwayatBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RiwayatBarang::with(['user', 'buku', 'barang']);
        
        // Filter by item type
        if ($request->has('type') && $request->type === 'buku') {
            $query->whereNotNull('buku_id')->whereNull('barang_id');
        } elseif ($request->has('type') && $request->type === 'barang') {
            $query->whereNotNull('barang_id')->whereNull('buku_id');
        }
        
        // Filter by specific item
        if ($request->has('buku_id')) {
            $query->where('buku_id', $request->buku_id);
        }
        
        if ($request->has('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }
        
        // Filter by activity type
        if ($request->has('jenis_aktivitas')) {
            $query->where('jenis_aktivitas', $request->jenis_aktivitas);
        }
        
        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        
        return $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    /**
     * Display the specified resource.
     */
    public function show(RiwayatBarang $riwayatBarang)
    {
        return response()->json($riwayatBarang->load(['user', 'buku', 'barang']));
    }
    
    /**
     * Get summary statistics for item history.
     */
    public function getSummary()
    {
        $totalRecords = RiwayatBarang::count();
        
        $activityCounts = RiwayatBarang::select('jenis_aktivitas')
            ->selectRaw('count(*) as count')
            ->groupBy('jenis_aktivitas')
            ->get()
            ->pluck('count', 'jenis_aktivitas')
            ->toArray();
            
        $bookRecords = RiwayatBarang::whereNotNull('buku_id')->count();
        $itemRecords = RiwayatBarang::whereNotNull('barang_id')->count();
        
        $recentActivity = RiwayatBarang::with(['user', 'buku', 'barang'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return response()->json([
            'total_records' => $totalRecords,
            'activity_counts' => $activityCounts,
            'book_records' => $bookRecords,
            'item_records' => $itemRecords,
            'recent_activity' => $recentActivity,
        ]);
    }
    
    /**
     * Get history for specific item or book
     */
    public function getItemHistory(Request $request)
    {
        if (!$request->has('buku_id') && !$request->has('barang_id')) {
            return response()->json([
                'message' => 'Either buku_id or barang_id must be provided'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $query = RiwayatBarang::with('user');
        
        if ($request->has('buku_id')) {
            $query->where('buku_id', $request->buku_id);
        }
        
        if ($request->has('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }
        
        $history = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json($history);
    }
} 