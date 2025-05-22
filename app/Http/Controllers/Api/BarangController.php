<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $perPage = $request->per_page ?? 10;
        $sortBy = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        
        $query = Barang::with(['subKategori.kategori'])
            ->where('nama', 'like', "%{$search}%")
            ->orWhere('kode', 'like', "%{$search}%")
            ->orWhere('merk', 'like', "%{$search}%");
            
        return $query->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        $validated = $request->validated();
        
        // Handle file upload if present
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $path;
        }
        
        $barang = Barang::create($validated);
        
        // Create initial history record
        $barang->riwayat()->create([
            'jumlah' => $validated['jumlah'],
            'keterangan' => 'Penambahan barang baru',
            'tipe' => 'masuk',
        ]);
        
        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang->load('subKategori.kategori')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return $barang->load(['subKategori.kategori', 'riwayat']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $validated = $request->validated();
        
        // Handle file upload if present
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $path;
        }
        
        // Check if quantity has changed
        if (isset($validated['jumlah']) && $validated['jumlah'] != $barang->jumlah) {
            $selisih = $validated['jumlah'] - $barang->jumlah;
            $tipe = $selisih > 0 ? 'masuk' : 'keluar';
            
            // Create history record for quantity change
            $barang->riwayat()->create([
                'jumlah' => abs($selisih),
                'keterangan' => $tipe == 'masuk' ? 'Penambahan stok' : 'Pengurangan stok',
                'tipe' => $tipe,
            ]);
        }
        
        $barang->update($validated);
        
        return response()->json([
            'message' => 'Barang berhasil diperbarui',
            'data' => $barang->load('subKategori.kategori')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        // Delete image if exists
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }
        
        $barang->delete();
        
        return response()->json([
            'message' => 'Barang berhasil dihapus'
        ]);
    }
} 