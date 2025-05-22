<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BukuController as ApiBukuController;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    protected $apiBukuController;

    public function __construct(ApiBukuController $apiBukuController)
    {
        $this->apiBukuController = $apiBukuController;
        $this->middleware('auth');
        // Only admin and operator can create, update, delete
        $this->middleware('role:admin,operator')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the books.
     */
    public function index()
    {
        $bukus = Buku::orderBy('judul', 'asc')->get();
        return view('buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $kategoris = $this->apiBukuController->getKategori()->getData()->data;
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $response = $this->apiBukuController->store($request);
        
        if ($response->getStatusCode() === 201) {
            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil ditambahkan.');
        }
        
        return back()->withInput()->with('error', 'Gagal menambahkan buku.');
    }

    /**
     * Display the specified book.
     */
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Buku $buku)
    {
        $kategoris = $this->apiBukuController->getKategori()->getData()->data;
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $apiRequest = Request::create('', 'PUT', $request->all());
        $response = $this->apiBukuController->update($apiRequest, $buku);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil diperbarui.');
        }
        
        return back()->withInput()->with('error', 'Gagal memperbarui buku.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Buku $buku)
    {
        $response = $this->apiBukuController->destroy($buku);
        
        if ($response->getStatusCode() === 200) {
            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil dihapus.');
        }
        
        return back()->with('error', 'Gagal menghapus buku.');
    }
} 