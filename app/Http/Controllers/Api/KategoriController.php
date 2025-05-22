<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $perPage = $request->per_page ?? 10;
        
        $query = Kategori::where('nama', 'like', "%{$search}%");
        
        return $query->withCount('subKategoris')
            ->orderBy('nama')
            ->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request)
    {
        $validated = $request->validated();
        
        $kategori = Kategori::create($validated);
        
        return response()->json([
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return $kategori->load('subKategoris');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        $validated = $request->validated();
        
        $kategori->update($validated);
        
        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'data' => $kategori
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // Check if kategori has subKategoris
        if ($kategori->subKategoris()->count() > 0) {
            return response()->json([
                'message' => 'Kategori tidak dapat dihapus karena memiliki sub kategori'
            ], 422);
        }
        
        $kategori->delete();
        
        return response()->json([
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
} 