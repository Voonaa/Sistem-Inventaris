<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BarangController as ApiBarangController;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        $this->checkRole();
        
        $barangs = Barang::with(['kategori', 'subKategori'])
            ->orderBy('nama_barang', 'asc')
            ->paginate(10);
            
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        $this->checkRole();
        
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::where('kategori_id', old('kategori_id'))->get();
            
        return view('barang.create', compact('kategoris', 'subKategoris'));
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
            'kategori_id' => 'required|exists:kategoris,id',
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'kondisi' => 'required|in:Baik,Kurang Baik,Rusak',
            'jumlah' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0|lte:jumlah',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $path;
        }
        
        $validated['created_by'] = Auth::id();
        
        Barang::create($validated);
        
        return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified item.
     */
    public function show(Barang $barang)
    {
        $this->checkRole();
        
        $barang->load(['subKategori.kategori', 'riwayatBarangs']);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Barang $barang)
    {
        $this->checkRole();
        
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::where('kategori_id', $barang->kategori_id ?? old('kategori_id'))->get();
            
        return view('barang.edit', compact('barang', 'kategoris', 'subKategoris'));
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
            'kategori_id' => 'required|exists:kategoris,id',
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'kondisi' => 'required|in:Baik,Kurang Baik,Rusak',
            'jumlah' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0|lte:jumlah',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
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
        
        // Delete image if exists
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }
        
        $barang->delete();
        
        return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil dihapus.');
    }
} 