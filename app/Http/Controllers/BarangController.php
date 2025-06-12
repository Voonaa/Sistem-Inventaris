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

        // Filter by kategori if provided
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
            if ($request->has('sub')) {
                $query->where('sub_kategori', $request->sub);
            }
        }

        $barangs = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('barang.index', compact('barangs'));
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
        
        \Log::info('Storing new barang', [
            'has_file' => $request->hasFile('gambar'),
            'all_data' => $request->all()
        ]);
        
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'sub_kategori' => 'nullable|string|required_if:kategori,perpustakaan',
            'kondisi' => 'required|string|in:baik,kurang_baik,rusak',
            'jumlah' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['foto'] = $path;
            \Log::info('Image stored', ['path' => $path]);
        }
        
        $validated['created_by'] = Auth::id();
        $validated['stok'] = $validated['jumlah'];
        
        $barang = Barang::create($validated);
        \Log::info('Barang created', ['barang' => $barang->toArray()]);
        
        // Catat riwayat penambahan barang
        RiwayatBarangController::tambahRiwayat(
            $barang->id,
            'tambah',
            $validated['jumlah'],
            'Penambahan barang baru'
        );
        
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
            'kondisi' => 'required|string|in:baik,kurang_baik,rusak',
            'jumlah' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('gambar')) {
            // Delete old image if it exists
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['foto'] = $path;
        }
        
        // Ensure stok is updated with the new jumlah
        $validated['stok'] = $validated['jumlah'];

        // Calculate the difference in jumlah
        $jumlahDiff = $validated['jumlah'] - $barang->jumlah;
        
        $barang->update($validated);
        
        // Catat riwayat perubahan jumlah
        if ($jumlahDiff != 0) {
            RiwayatBarangController::tambahRiwayat(
                $barang->id,
                $jumlahDiff > 0 ? 'tambah' : 'kurang',
                abs($jumlahDiff),
                'Perubahan jumlah barang'
            );
        }
        
        return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Barang $barang)
    {
        $this->checkRole();
        
        // Catat riwayat penghapusan
        RiwayatBarangController::tambahRiwayat(
            $barang->id,
            'hapus',
            $barang->jumlah,
            'Penghapusan barang'
        );
        
        // Delete image if exists
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
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
        
        if (!$request->has('barang_ids') || empty($request->input('barang_ids'))) {
            return redirect()->route('barang.manage')
                ->with('error', 'Silakan pilih setidaknya satu barang untuk dihapus.');
        }
        
        $barangIds = $request->input('barang_ids');
        if (is_string($barangIds)) {
            $barangIds = explode(',', $barangIds);
        }
        
        $count = 0;
        $errors = [];
        
        foreach ($barangIds as $barangId) {
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
                // Catat riwayat penghapusan
                RiwayatBarangController::tambahRiwayat(
                    $barang->id,
                    'hapus',
                    $barang->jumlah,
                    'Penghapusan barang'
                );
                
                // Delete image if exists
                if ($barang->foto) {
                    Storage::disk('public')->delete($barang->foto);
                }
                
                $barang->delete();
                $count++;
            } catch (\Exception $e) {
                $errors[] = "Error menghapus ID {$barangId}: " . $e->getMessage();
            }
        }
        
        if (!empty($errors)) {
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
        
        $ids = $request->query('ids');
        
        if (empty($ids)) {
            return redirect()->route('barang.manage')
                ->with('error', 'Tidak ada barang yang dipilih untuk dihapus.');
        }
        
        $barangIds = explode(',', $ids);
        $count = 0;
        
        foreach ($barangIds as $barangId) {
            if (!is_numeric($barangId)) {
                continue;
            }
            
            $barang = Barang::find($barangId);
            if (!$barang) {
                continue;
            }
            
            try {
                // Catat riwayat penghapusan
                RiwayatBarangController::tambahRiwayat(
                    $barang->id,
                    'hapus',
                    $barang->jumlah,
                    'Penghapusan barang'
                );
                
                // Delete image if exists
                if ($barang->foto) {
                    Storage::disk('public')->delete($barang->foto);
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