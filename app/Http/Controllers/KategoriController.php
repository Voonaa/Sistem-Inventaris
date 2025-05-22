<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\KategoriController as ApiKategoriController;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class KategoriController extends Controller
{
    protected $apiKategoriController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,operator');
        $this->apiKategoriController = App::make(ApiKategoriController::class);
    }

    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('nama', 'asc')->get();
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $response = $this->apiKategoriController->store($request);
        
        if ($response->getStatusCode() === 201) {
            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil ditambahkan.');
        }
        
        return back()->withInput()->with('error', 'Gagal menambahkan kategori.');
    }

    /**
     * Display the specified category.
     */
    public function show(Kategori $kategori)
    {
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $apiRequest = Request::create('', 'PUT', $request->all());
        $response = $this->apiKategoriController->update($apiRequest, $kategori);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil diperbarui.');
        }
        
        return back()->withInput()->with('error', 'Gagal memperbarui kategori.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $response = $this->apiKategoriController->destroy($kategori);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil dihapus.');
        }
        
        return back()->with('error', 'Gagal menghapus kategori.');
    }
} 