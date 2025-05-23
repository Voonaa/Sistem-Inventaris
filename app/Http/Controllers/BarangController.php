<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BarangController as ApiBarangController;
use App\Models\Barang;
use App\Models\RiwayatBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    protected $apiBarangController;

    public function __construct()
    {
        // Only use auth middleware, handle role checking in methods
        $this->middleware('auth');
        $this->apiBarangController = App::make(ApiBarangController::class);
    }

    /**
     * Check if the current user has the required role
     */
    protected function checkRole()
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'operator'])) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Display a listing of the items.
     */
    public function index(Request $request)
    {
        $this->checkRole();

        $query = Barang::query();
        $activeKategori = $request->kategori;
        $activeSub = $request->sub;

        // Apply kategori filter if provided
        if ($activeKategori) {
            $query->where('kategori', $activeKategori);

            // Apply sub-kategori filter if provided and kategori is perpustakaan
            if ($activeKategori === 'perpustakaan' && $activeSub) {
                $query->where('sub_kategori', $activeSub);
            }
        }
        
        $barangs = $query->orderBy('nama_barang', 'asc')->paginate(10);

        // Get the categories from config
        $categories = config('categories');
            
        return view('barang.index', compact('barangs', 'categories', 'activeKategori', 'activeSub'));
    }

    /**
     * Display a page for deleting items
     */
    public function manage(Request $request)
    {
        $this->checkRole();

        $query = Barang::query();
        $activeKategori = $request->kategori;
        $activeSub = $request->sub;

        // Apply filters if provided
        if ($activeKategori) {
            $query->where('kategori', $activeKategori);

            if ($activeKategori === 'perpustakaan' && $activeSub) {
                $query->where('sub_kategori', $activeSub);
            }
        }
        
        $barangs = $query->orderBy('nama_barang', 'asc')->paginate(10);
        $categories = config('categories');
        
        return view('barang.manage', compact('barangs', 'categories', 'activeKategori', 'activeSub'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        $this->checkRole();
        
        // Get the categories from config
        $categories = config('categories');
            
        return view('barang.create', compact('categories'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $this->checkRole();
        
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'sub_kategori' => 'nullable|string|required_if:kategori,perpustakaan',
            'kondisi' => 'required|string|in:Baik,Kurang Baik,Rusak',
            'jumlah' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Set stok equal to jumlah initially
        $validated['stok'] = $validated['jumlah'];
        
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $path;
        }
        
        $validated['created_by'] = Auth::id();
        
        $barang = Barang::create($validated);
        
        // Create history entry for item addition
        RiwayatBarang::create([
            'barang_id' => $barang->id,
            'jenis_aktivitas' => 'tambah',
            'jumlah' => $validated['jumlah'],
            'stok_sebelum' => 0,
            'stok_sesudah' => $validated['jumlah'],
            'keterangan' => 'Penambahan barang baru',
            'user_id' => Auth::id(),
        ]);
        
        // Check if request is from manage page
        if ($request->has('from_manage')) {
            return redirect()->route('barang.manage')
                ->with('success', 'Barang berhasil ditambahkan.');
        }
        
        return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified item.
     */
    public function show(Barang $barang)
    {
        $this->checkRole();
        
        $barang->load(['riwayatBarangs']);

        // Get category and subcategory labels
        $categories = config('categories');
        $kategoriLabel = $this->getCategoryLabel($barang->kategori, $categories);
        $subKategoriLabel = $this->getSubCategoryLabel($barang->kategori, $barang->sub_kategori, $categories);

        return view('barang.show', compact('barang', 'kategoriLabel', 'subKategoriLabel'));
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Barang $barang)
    {
        $this->checkRole();
        
        // Get the categories from config
        $categories = config('categories');
            
        return view('barang.edit', compact('barang', 'categories'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $this->checkRole();
        
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'sub_kategori' => 'nullable|string|required_if:kategori,perpustakaan',
            'kondisi' => 'required|string|in:Baik,Kurang Baik,Rusak',
            'jumlah' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Calculate the difference in jumlah
        $originalJumlah = $barang->jumlah;
        $newJumlah = $validated['jumlah'];
        $jumlahDiff = $newJumlah - $originalJumlah;
        
        // If jumlah increased, also increase stok proportionally
        if ($jumlahDiff > 0) {
            $validated['stok'] = $barang->stok + $jumlahDiff;
        } elseif ($jumlahDiff < 0 && abs($jumlahDiff) > ($originalJumlah - $barang->stok)) {
            // If decreasing jumlah would make stok > jumlah, adjust stok 
            $validated['stok'] = max(0, $newJumlah - ($originalJumlah - $barang->stok));
        }
        
        if ($request->hasFile('gambar')) {
            // Delete old image if it exists
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $path;
        }
        
        $validated['updated_by'] = Auth::id();
        
        $barang->update($validated);
        
        return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Barang $barang)
    {
        $this->checkRole();
        
        // Log the deletion first
        RiwayatBarang::create([
            'barang_id' => $barang->id,
            'jenis_aktivitas' => 'hapus',
            'jumlah' => $barang->jumlah,
            'stok_sebelum' => $barang->stok,
            'stok_sesudah' => 0,
            'keterangan' => 'Penghapusan barang',
            'user_id' => Auth::id(),
        ]);
        
        // Delete image if exists
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }
        
        $barang->delete();
        
        // Redirect back to the referrer page
        if (url()->previous() === route('barang.manage')) {
            return redirect()->route('barang.manage')
                ->with('success', 'Barang berhasil dihapus.');
        }
        
        return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Remove multiple items from storage
     */
    public function bulkDestroy(Request $request)
    {
        $this->checkRole();
        
        // Log the request data for debugging
        \Illuminate\Support\Facades\Log::info('Bulk destroy request details', [
            'method' => $request->method(),
            'has_barang_ids' => $request->has('barang_ids'),
            'barang_ids_type' => gettype($request->input('barang_ids')),
            'content_type' => $request->header('Content-Type')
        ]);
        
        // Get IDs - handle if no IDs are selected
        if (!$request->has('barang_ids') || empty($request->input('barang_ids'))) {
            return redirect()->route('barang.manage')
                ->with('error', 'Silakan pilih setidaknya satu barang untuk dihapus.');
        }
        
        // Get array of IDs
        $barangIds = $request->input('barang_ids');
        
        // Convert to array if string
        if (is_string($barangIds)) {
            $barangIds = explode(',', $barangIds);
        }
        
        // Process each item
        $count = 0;
        $errors = [];
        
        foreach ($barangIds as $barangId) {
            // Skip if not a valid ID
            if (!is_numeric($barangId)) {
                $errors[] = "ID tidak valid: {$barangId}";
                continue;
            }
            
            $barang = Barang::find($barangId);
            if (!$barang) {
                $errors[] = "Barang dengan ID {$barangId} tidak ditemukan";
                continue;
            }
            
            try {
                // Log the deletion
                RiwayatBarang::create([
                    'barang_id' => $barang->id,
                    'jenis_aktivitas' => 'hapus',
                    'jumlah' => $barang->jumlah,
                    'stok_sebelum' => $barang->stok,
                    'stok_sesudah' => 0,
                    'keterangan' => 'Penghapusan barang',
                    'user_id' => Auth::id(),
                ]);
                
                // Delete image if exists
                if ($barang->gambar) {
                    Storage::disk('public')->delete($barang->gambar);
                }
                
                // Delete the item
                $barang->delete();
                $count++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error deleting item', [
                    'barang_id' => $barangId,
                    'error' => $e->getMessage()
                ]);
                $errors[] = "Error menghapus ID {$barangId}: " . $e->getMessage();
            }
        }
        
        // Redirect with appropriate message
        if (!empty($errors)) {
            \Illuminate\Support\Facades\Log::warning('Bulk delete completed with errors', [
                'errors' => $errors,
                'deleted_count' => $count
            ]);
            
            return redirect()->route('barang.manage')
                ->with('warning', "{$count} barang berhasil dihapus. Error: " . implode('; ', $errors));
        }
        
        return redirect()->route('barang.manage')
            ->with('success', "{$count} barang berhasil dihapus.");
    }

    /**
     * Remove multiple items from storage (GET method version)
     */
    public function bulkDestroyGet(Request $request)
    {
        $this->checkRole();
        
        // Log the request
        \Illuminate\Support\Facades\Log::info('Bulk destroy GET method accessed', [
            'url' => $request->fullUrl(),
            'get_params' => $request->query()
        ]);
        
        // Get IDs from the query string
        $ids = $request->query('ids');
        
        if (empty($ids)) {
            return redirect()->route('barang.manage')
                ->with('error', 'Tidak ada barang yang dipilih untuk dihapus.');
        }
        
        // Convert comma-separated string to array
        $barangIds = explode(',', $ids);
        
        // Process each item
        $count = 0;
        $errors = [];
        
        foreach ($barangIds as $barangId) {
            if (!is_numeric($barangId)) {
                continue;
            }
            
            $barang = Barang::find($barangId);
            if (!$barang) {
                continue;
            }
            
            try {
                // Log the deletion
                RiwayatBarang::create([
                    'barang_id' => $barang->id,
                    'jenis_aktivitas' => 'hapus',
                    'jumlah' => $barang->jumlah,
                    'stok_sebelum' => $barang->stok,
                    'stok_sesudah' => 0,
                    'keterangan' => 'Penghapusan barang',
                    'user_id' => Auth::id(),
                ]);
                
                // Delete image if exists
                if ($barang->gambar) {
                    Storage::disk('public')->delete($barang->gambar);
                }
                
                $barang->delete();
                $count++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error in bulk delete GET', [
                    'id' => $barangId,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return redirect()->route('barang.manage')
            ->with('success', "{$count} barang berhasil dihapus.");
    }

    /**
     * Get the display label for a category
     */
    protected function getCategoryLabel($categoryKey, $categories)
    {
        if (isset($categories[$categoryKey])) {
            if (is_array($categories[$categoryKey]) && isset($categories[$categoryKey]['label'])) {
                return $categories[$categoryKey]['label'];
            } elseif (is_string($categories[$categoryKey])) {
                return $categories[$categoryKey];
            }
        }
        
        return Str::title(str_replace('_', ' ', $categoryKey));
    }

    /**
     * Get the display label for a sub-category
     */
    protected function getSubCategoryLabel($categoryKey, $subCategoryKey, $categories)
    {
        if ($categoryKey === 'perpustakaan' && isset($categories[$categoryKey]['sub'][$subCategoryKey])) {
            return $categories[$categoryKey]['sub'][$subCategoryKey];
        }
        
        return Str::title(str_replace('_', ' ', $subCategoryKey));
    }
} 