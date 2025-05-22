<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\SubKategoriController as ApiSubKategoriController;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SubKategoriController extends Controller
{
    protected $apiSubKategoriController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,operator');
        $this->apiSubKategoriController = App::make(ApiSubKategoriController::class);
    }

    /**
     * Display a listing of the subcategories.
     */
    public function index()
    {
        $subKategoris = SubKategori::with('kategori')->orderBy('nama', 'asc')->get();
        return view('subkategori.index', compact('subKategoris'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama', 'asc')->get();
        return view('subkategori.create', compact('kategoris'));
    }

    /**
     * Store a newly created subcategory in storage.
     */
    public function store(Request $request)
    {
        $response = $this->apiSubKategoriController->store($request);
        
        if ($response->getStatusCode() === 201) {
            return redirect()->route('subkategori.index')
                ->with('success', 'Sub Kategori berhasil ditambahkan.');
        }
        
        return back()->withInput()->with('error', 'Gagal menambahkan sub kategori.');
    }

    /**
     * Display the specified subcategory.
     */
    public function show(SubKategori $subkategori)
    {
        return view('subkategori.show', compact('subkategori'));
    }

    /**
     * Show the form for editing the specified subcategory.
     */
    public function edit(SubKategori $subkategori)
    {
        $kategoris = Kategori::orderBy('nama', 'asc')->get();
        return view('subkategori.edit', compact('subkategori', 'kategoris'));
    }

    /**
     * Update the specified subcategory in storage.
     */
    public function update(Request $request, SubKategori $subkategori)
    {
        $apiRequest = Request::create('', 'PUT', $request->all());
        $response = $this->apiSubKategoriController->update($apiRequest, $subkategori);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('subkategori.index')
                ->with('success', 'Sub Kategori berhasil diperbarui.');
        }
        
        return back()->withInput()->with('error', 'Gagal memperbarui sub kategori.');
    }

    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy(SubKategori $subkategori)
    {
        $response = $this->apiSubKategoriController->destroy($subkategori);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('subkategori.index')
                ->with('success', 'Sub Kategori berhasil dihapus.');
        }
        
        return back()->with('error', 'Gagal menghapus sub kategori.');
    }
} 