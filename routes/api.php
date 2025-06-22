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

// Semua route di file ini otomatis prefix /api (RouteServiceProvider)
// Middleware CORS aktif by default (lihat config/cors.php)

// Public auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Status check endpoint
Route::get('/status-check', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'API is online and healthy',
        'server_time' => now(),
        'auth_routes_available' => ['/api/login', '/api/register']
    ]);
});

// Test connection endpoint
Route::get('/test-connection', function() {
    return response()->json([
        'status' => 'connected',
        'message' => 'Successfully connected to the API',
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Throttle for login/register
Route::middleware(['throttle:api'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/bukus', [BukuController::class, 'index']);
    Route::get('/bukus/{buku}', [BukuController::class, 'show']);
    Route::get('/buku-kategori', [BukuController::class, 'getKategori']);
    Route::middleware('role:admin,operator')->group(function () {
        Route::apiResource('kategoris', KategoriController::class);
        Route::apiResource('sub-kategoris', SubKategoriController::class);
        Route::apiResource('barangs', BarangController::class);
        Route::post('/bukus', [BukuController::class, 'store']);
        Route::put('/bukus/{buku}', [BukuController::class, 'update']);
        Route::delete('/bukus/{buku}', [BukuController::class, 'destroy']);
        
        // Peminjaman - Full CRUD
        Route::apiResource('peminjaman-api', PeminjamanController::class);
        Route::get('/peminjaman-overdue', [PeminjamanController::class, 'getOverdue']);
        Route::get('/riwayat-barang', [RiwayatBarangController::class, 'index']);
        Route::get('/riwayat-barang/{riwayatBarang}', [RiwayatBarangController::class, 'show']);
        Route::get('/riwayat-barang-summary', [RiwayatBarangController::class, 'getSummary']);
        Route::get('/riwayat-item', [RiwayatBarangController::class, 'getItemHistory']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('items', ItemController::class);
        Route::apiResource('transactions', TransactionController::class);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public dependent dropdown
Route::get('/sub-kategoris', function (Request $request) {
    $kategoriId = $request->query('kategori_id');
    return SubKategori::where('kategori_id', $kategoriId)
        ->orderBy('nama', 'asc')
        ->get();
}); 