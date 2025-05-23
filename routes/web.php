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
        
        // Standard bulk destroy route
        Route::post('/barang/bulk-destroy', [BarangController::class, 'bulkDestroy'])->name('barang.bulk-destroy');
        
        // Alternative GET route for bulk destroy (for environments where POST doesn't work properly)
        Route::get('/hapus-barang-terpilih', [BarangController::class, 'bulkDestroyGet'])->name('barang.bulk-destroy-get');
        
        // Register all other resource routes EXCEPT 'index' which is defined above
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
        Route::get('/laporan/perpustakaan', [LaporanController::class, 'perpustakaan'])->name('laporan.perpustakaan');
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

// Debug route paths
Route::get('/debug-routes', function() {
    $routes = collect(Route::getRoutes())->map(function($route) {
        return [
            'uri' => $route->uri(),
            'methods' => implode('|', $route->methods()),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    });
    
    return response()->json($routes);
});

// Test bulk delete route
Route::get('/test-bulk-delete', function() {
    return '<form action="' . route('barang.bulk-destroy') . '" method="POST">
        ' . csrf_field() . '
        <input type="hidden" name="barang_ids[]" value="1">
        <button type="submit">Test Delete Item #1</button>
    </form>';
});

// Standalone bulk delete page - a simplified version for troubleshooting
Route::get('/simple-bulk-delete', function() {
    $barangs = \App\Models\Barang::orderBy('nama_barang')->get();
    
    $html = '<h1>Simple Bulk Delete</h1>';
    $html .= '<form action="' . url('/bulk-delete-items') . '" method="POST">';
    $html .= csrf_field();
    $html .= '<input type="hidden" name="_method" value="POST">';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<tr><th>Select</th><th>ID</th><th>Nama Barang</th><th>Kode</th></tr>';
    
    foreach ($barangs as $barang) {
        $html .= '<tr>';
        $html .= '<td><input type="checkbox" name="barang_ids[]" value="' . $barang->id . '"></td>';
        $html .= '<td>' . $barang->id . '</td>';
        $html .= '<td>' . $barang->nama_barang . '</td>';
        $html .= '<td>' . $barang->kode_barang . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    $html .= '<br><input type="submit" value="Delete Selected Items" onclick="return confirm(\'Are you sure?\')">';
    $html .= '</form>';
    
    $html .= '<hr><h2>Alternative Direct Form</h2>';
    $html .= '<form action="' . url('/barang/bulk-destroy') . '" method="POST">';
    $html .= csrf_field();
    $html .= '<input type="hidden" name="_method" value="POST">';
    $html .= '<p>This form uses the original endpoint:</p>';
    $html .= '<select name="barang_ids[]" multiple style="width: 300px; height: 200px;">';
    
    foreach ($barangs as $barang) {
        $html .= '<option value="' . $barang->id . '">' . $barang->nama_barang . ' (' . $barang->kode_barang . ')</option>';
    }
    
    $html .= '</select>';
    $html .= '<p><small>Hold Ctrl to select multiple items</small></p>';
    $html .= '<br><input type="submit" value="Delete Selected Items (Alt Method)" onclick="return confirm(\'Are you sure?\')">';
    $html .= '</form>';
    
    return $html;
});

// Direct bulk delete - emergency bypass
Route::get('/direct-bulk-delete/{id}', function($id) {
    if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'operator'])) {
        return redirect()->route('login');
    }
    
    $barang = \App\Models\Barang::find($id);
    if (!$barang) {
        return "Barang tidak ditemukan";
    }
    
    try {
        // Log the deletion first
        \App\Models\RiwayatBarang::create([
            'barang_id' => $barang->id,
            'jenis_aktivitas' => 'hapus',
            'jumlah' => $barang->jumlah,
            'stok_sebelum' => $barang->stok,
            'stok_sesudah' => 0,
            'keterangan' => 'Penghapusan barang (emergency)',
            'user_id' => Auth::id(),
        ]);
        
        $barang->delete();
        return redirect()->route('barang.manage')
            ->with('success', 'Barang berhasil dihapus menggunakan metode darurat.');
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// Super simple post-only form
Route::get('/basic-delete-form', function() {
    $barangs = \App\Models\Barang::orderBy('nama_barang')->get();
    
    return view('basic-delete-form', ['barangs' => $barangs]);
});

// GET-based bulk delete handler (emergency solution that bypasses method conversion)
Route::get('/direct-bulk-delete-process', function(\Illuminate\Http\Request $request) {
    // Check auth
    if (!\Illuminate\Support\Facades\Auth::check() || 
        !in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'operator'])) {
        return redirect()->route('login');
    }
    
    // Get IDs from textarea input
    $idsText = $request->input('ids');
    if (empty($idsText)) {
        return redirect()->route('barang.manage')
            ->with('error', 'No IDs were provided');
    }
    
    // Process IDs - split by newline, remove empty lines, trim whitespace
    $idArray = array_filter(array_map('trim', explode("\n", $idsText)));
    
    // Log what we're about to do
    \Illuminate\Support\Facades\Log::info('Direct GET-based bulk delete accessed');
    \Illuminate\Support\Facades\Log::info('IDs to delete: ' . implode(', ', $idArray));
    
    $count = 0;
    $errors = [];
    
    foreach ($idArray as $id) {
        if (!is_numeric($id)) {
            $errors[] = "Invalid ID: {$id}";
            continue;
        }
        
        $barang = \App\Models\Barang::find($id);
        if (!$barang) {
            $errors[] = "Item not found: {$id}";
            continue;
        }
        
        try {
            // Log the deletion
            \App\Models\RiwayatBarang::create([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'hapus',
                'jumlah' => $barang->jumlah,
                'stok_sebelum' => $barang->stok,
                'stok_sesudah' => 0,
                'keterangan' => 'Penghapusan barang (via direct GET)',
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
            ]);
            
            // Delete image if exists
            if ($barang->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($barang->gambar);
            }
            
            $barang->delete();
            $count++;
        } catch (\Exception $e) {
            $errors[] = "Error deleting ID {$id}: " . $e->getMessage();
        }
    }
    
    // Redirect with appropriate message
    if (!empty($errors)) {
        return redirect()->route('barang.manage')
            ->with('warning', "{$count} items deleted successfully. Errors: " . implode('; ', $errors));
    }
    
    return redirect()->route('barang.manage')
        ->with('success', "{$count} items deleted successfully");
});

// Dedicated POST-only bulk delete handler (kept for backward compatibility)
Route::post('/post-only-bulk-delete', function(\Illuminate\Http\Request $request) {
    // Check auth
    if (!\Illuminate\Support\Facades\Auth::check() || 
        !in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'operator'])) {
        return redirect()->route('login');
    }
    
    // Log the request
    \Illuminate\Support\Facades\Log::info('POST-only bulk delete accessed');
    \Illuminate\Support\Facades\Log::info('Request method: ' . $request->method());
    \Illuminate\Support\Facades\Log::info('Request data: ' . json_encode($request->all()));
    
    // Validate
    $validated = $request->validate([
        'barang_ids' => 'required|array',
        'barang_ids.*' => 'exists:barangs,id',
    ]);
    
    $count = 0;
    $ids = $validated['barang_ids'];
    
    foreach ($ids as $id) {
        $barang = \App\Models\Barang::find($id);
        if ($barang) {
            // Log the deletion
            \App\Models\RiwayatBarang::create([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'hapus',
                'jumlah' => $barang->jumlah,
                'stok_sebelum' => $barang->stok,
                'stok_sesudah' => 0,
                'keterangan' => 'Penghapusan barang (via POST-only)',
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
            ]);
            
            // Delete image if exists
            if ($barang->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($barang->gambar);
            }
            
            $barang->delete();
            $count++;
        }
    }
    
    // Redirect with success message
    return redirect()->route('barang.manage')
        ->with('success', $count . ' barang berhasil dihapus via direct-POST.');
});

// Test bulk delete route - with form submission
Route::get('/test-bulk-delete-form', function() {
    $barangs = \App\Models\Barang::orderBy('nama_barang')->limit(10)->get();
    
    return view('test-bulk-delete-form', [
        'barangs' => $barangs
    ]);
});

// Create a simple view for testing
Route::view('/test-delete-view', 'test-bulk-delete-form');

// GET-based bulk delete handler (emergency workaround)
Route::get('/barang/bulk-delete', function(\Illuminate\Http\Request $request) {
    // Check auth
    if (!\Illuminate\Support\Facades\Auth::check() || 
        !in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'operator'])) {
        return redirect()->route('login');
    }
    
    // Get IDs from URL params
    $ids = $request->input('ids', '');
    if (empty($ids)) {
        return redirect()->route('barang.manage')
            ->with('error', 'No IDs were provided');
    }
    
    // Process IDs - convert to array if it's a string
    $idArray = is_array($ids) ? $ids : explode(',', $ids);
    
    // Log what we're about to do
    \Illuminate\Support\Facades\Log::info('GET-based bulk delete accessed');
    \Illuminate\Support\Facades\Log::info('IDs to delete: ' . implode(', ', $idArray));
    
    $count = 0;
    $errors = [];
    
    foreach ($idArray as $id) {
        if (!is_numeric($id)) {
            $errors[] = "Invalid ID: {$id}";
            continue;
        }
        
        $barang = \App\Models\Barang::find($id);
        if (!$barang) {
            $errors[] = "Item not found: {$id}";
            continue;
        }
        
        try {
            // Log the deletion
            \App\Models\RiwayatBarang::create([
                'barang_id' => $barang->id,
                'jenis_aktivitas' => 'hapus',
                'jumlah' => $barang->jumlah,
                'stok_sebelum' => $barang->stok,
                'stok_sesudah' => 0,
                'keterangan' => 'Penghapusan barang (via GET)',
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
            ]);
            
            // Delete image if exists
            if ($barang->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($barang->gambar);
            }
            
            $barang->delete();
            $count++;
        } catch (\Exception $e) {
            $errors[] = "Error deleting ID {$id}: " . $e->getMessage();
        }
    }
    
    // Redirect with appropriate message
    if (!empty($errors)) {
        return redirect()->route('barang.manage')
            ->with('warning', "{$count} items deleted successfully. Errors: " . implode('; ', $errors));
    }
    
    return redirect()->route('barang.manage')
        ->with('success', "{$count} barang berhasil dihapus.");
});

require __DIR__.'/auth.php';

