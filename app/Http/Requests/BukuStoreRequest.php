<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20|unique:bukus,isbn',
            'jumlah_halaman' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'lokasi_rak' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'dipinjam' => 'required|integer|min:0|lte:stok',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul buku wajib diisi',
            'pengarang.required' => 'Nama pengarang wajib diisi',
            'penerbit.required' => 'Nama penerbit wajib diisi',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka',
            'tahun_terbit.min' => 'Tahun terbit tidak valid',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang',
            'isbn.unique' => 'ISBN sudah terdaftar di sistem',
            'jumlah_halaman.integer' => 'Jumlah halaman harus berupa angka',
            'jumlah_halaman.min' => 'Jumlah halaman minimal 1',
            'kategori.required' => 'Kategori buku wajib diisi',
            'lokasi_rak.required' => 'Lokasi rak wajib diisi',
            'stok.required' => 'Stok buku wajib diisi',
            'stok.min' => 'Stok buku minimal 0',
            'dipinjam.required' => 'Jumlah buku dipinjam wajib diisi',
            'dipinjam.min' => 'Jumlah buku dipinjam minimal 0',
            'dipinjam.lte' => 'Jumlah buku dipinjam tidak boleh melebihi stok',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
} 