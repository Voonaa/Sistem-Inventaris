<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\RiwayatBarangController;
use App\Http\Controllers\Api\SubKategoriController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Models\SubKategori;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public auth routes - No middleware needed for these
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Simple status check endpoint with CORS headers
Route::get('/status-check', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'API is online and healthy',
        'server_time' => now(),
        'auth_routes_available' => ['/api/login', '/api/register']
    ])->header('Access-Control-Allow-Origin', '*')
      ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
      ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});

// Test connection endpoint
Route::get('/test-connection', function() {
    return response()->json([
        'status' => 'connected',
        'message' => 'Successfully connected to the API',
        'timestamp' => now()->toDateTimeString()
    ])->header('Access-Control-Allow-Origin', '*')
      ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
      ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});

// Fix for CSRF token issues - explicitly exclude these routes
Route::middleware(['throttle:api'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Dashboard (accessible to all authenticated users)
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Book catalog (accessible to all authenticated users)
    Route::get('/bukus', [BukuController::class, 'index']);
    Route::get('/bukus/{buku}', [BukuController::class, 'show']);
    Route::get('/buku-kategori', [BukuController::class, 'getKategori']);
    
    // Admin & Operator routes
    Route::middleware('role:admin,operator')->group(function () {
        // Kategori
        Route::apiResource('kategoris', KategoriController::class);
        
        // SubKategori
        Route::apiResource('sub-kategoris', SubKategoriController::class);
        
        // Barang - Full CRUD access
        Route::apiResource('barangs', BarangController::class);
        
        // Buku - Management (create, update, delete)
        Route::post('/bukus', [BukuController::class, 'store']);
        Route::put('/bukus/{buku}', [BukuController::class, 'update']);
        Route::delete('/bukus/{buku}', [BukuController::class, 'destroy']);
        
        // Peminjaman - Full CRUD
        Route::apiResource('peminjaman-api', PeminjamanController::class);
        Route::get('/peminjaman-overdue', [PeminjamanController::class, 'getOverdue']);
        
        // RiwayatBarang
        Route::get('/riwayat-barang', [RiwayatBarangController::class, 'index']);
        Route::get('/riwayat-barang/{riwayatBarang}', [RiwayatBarangController::class, 'show']);
        Route::get('/riwayat-barang-summary', [RiwayatBarangController::class, 'getSummary']);
        Route::get('/riwayat-item', [RiwayatBarangController::class, 'getItemHistory']);
    });
    
    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        // Legacy endpoints (kept for backwards compatibility)
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('items', ItemController::class);
        Route::apiResource('transactions', TransactionController::class);
        
        // Add future admin-only routes here
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Untuk dropdown dependent subkategori - public route
Route::get('/sub-kategoris', function (Request $request) {
    $kategoriId = $request->query('kategori_id');
    return SubKategori::where('kategori_id', $kategoriId)
        ->orderBy('nama', 'asc')
        ->get();
}); 