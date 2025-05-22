<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatBarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect root URL to login page
Route::redirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Books - All users can view books
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
    
    // Admin & Operator routes - Using auth middleware only, role check is in controllers
    Route::middleware(['auth'])->group(function () {
        // Barang - Main route for filtered views
        Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
        Route::get('/barang/manage', [BarangController::class, 'manage'])->name('barang.manage');
        Route::post('/barang/bulk-destroy', [BarangController::class, 'bulkDestroy'])->name('barang.bulk-destroy');
        Route::resource('barang', BarangController::class)->except(['index']);
        
        // Buku management
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
        
        // Peminjaman
        Route::resource('peminjaman', PeminjamanController::class);
        Route::get('/peminjaman-overdue', [PeminjamanController::class, 'getOverdue'])->name('peminjaman.overdue');
        
        // RiwayatBarang
        Route::get('/riwayat-barang', [RiwayatBarangController::class, 'index'])->name('riwayat-barang.index');
        Route::get('/riwayat-barang/{riwayatBarang}', [RiwayatBarangController::class, 'show'])->name('riwayat-barang.show');
        Route::get('/riwayat-barang-summary', [RiwayatBarangController::class, 'getSummary'])->name('riwayat-barang.summary');
        Route::get('/riwayat-item', [RiwayatBarangController::class, 'getItemHistory'])->name('riwayat-barang.item');
        
        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/barang', [LaporanController::class, 'barang'])->name('laporan.barang');
        Route::get('/laporan/buku', [LaporanController::class, 'buku'])->name('laporan.buku');
        Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
        Route::get('/laporan/riwayat-barang', [LaporanController::class, 'riwayatBarang'])->name('laporan.riwayat-barang');
        Route::get('/laporan/export/{type}', [LaporanController::class, 'export'])->name('laporan.export');
        
        // Pengguna (User Management)
        Route::resource('pengguna', PenggunaController::class);
        
        // History (Activity Logs)
        Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
        Route::get('/history/filter', [HistoryController::class, 'filter'])->name('history.filter');
        Route::get('/history/report', [HistoryController::class, 'generateReport'])->name('history.report');
    });

    // Return item route
    Route::patch('/peminjaman/{peminjaman}/return', [PeminjamanController::class, 'returnItem'])->name('peminjaman.return');
});

// For debugging
Route::get('/test-login', function() {
    if (Auth::attempt(['email' => 'test@example.com', 'password' => 'password'])) {
        return "Login successful! User ID: " . Auth::id();
    } else {
        return "Login failed!";
    }
});

require __DIR__.'/auth.php';
