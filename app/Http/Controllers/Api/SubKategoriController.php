<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubKategoriRequest;
use App\Http\Requests\UpdateSubKategoriRequest;
use App\Models\SubKategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $perPage = $request->per_page ?? 10;
        $kategoriId = $request->kategori_id;
        
        $query = SubKategori::with('kategori')
            ->where('nama', 'like', "%{$search}%");
            
        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }
        
        return $query->withCount('barangs')
            ->orderBy('nama')
            ->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubKategoriRequest $request)
    {
        $validated = $request->validated();
        
        $subKategori = SubKategori::create($validated);
        
        return response()->json([
            'message' => 'Sub Kategori berhasil ditambahkan',
            'data' => $subKategori->load('kategori')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubKategori $subKategori)
    {
        return $subKategori->load(['kategori', 'barangs']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubKategoriRequest $request, SubKategori $subKategori)
    {
        $validated = $request->validated();
        
        $subKategori->update($validated);
        
        return response()->json([
            'message' => 'Sub Kategori berhasil diperbarui',
            'data' => $subKategori->load('kategori')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKategori $subKategori)
    {
        // Check if subKategori has barangs
        if ($subKategori->barangs()->count() > 0) {
            return response()->json([
                'message' => 'Sub Kategori tidak dapat dihapus karena memiliki barang'
            ], 422);
        }
        
        $subKategori->delete();
        
        return response()->json([
            'message' => 'Sub Kategori berhasil dihapus'
        ]);
    }
} 