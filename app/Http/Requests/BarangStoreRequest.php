<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BarangStoreRequest extends FormRequest
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
            'kode_barang' => 'required|string|max:30|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'merek' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'nomor_seri' => 'nullable|string|max:50',
            'tahun_perolehan' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kondisi' => 'required|in:Baik,Kurang Baik,Rusak',
            'status' => ['required', Rule::in(['tersedia', 'dipinjam', 'dalam_perbaikan', 'dihapuskan'])],
            'lokasi' => 'nullable|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'stok' => 'required|integer|lte:jumlah',
            'harga_perolehan' => 'nullable|numeric|min:0',
            'sumber_dana' => 'nullable|string|max:50',
            'is_buku' => 'boolean',
            'buku_id' => 'nullable|exists:bukus,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
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
            'kode_barang.required' => 'Kode barang wajib diisi',
            'kode_barang.unique' => 'Kode barang sudah ada dalam sistem',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid',
            'sub_kategori_id.exists' => 'Sub-kategori yang dipilih tidak valid',
            'kondisi.required' => 'Kondisi barang wajib dipilih',
            'kondisi.in' => 'Kondisi yang dipilih tidak valid',
            'status.required' => 'Status barang wajib dipilih',
            'status.in' => 'Status yang dipilih tidak valid',
            'jumlah.required' => 'Jumlah barang wajib diisi',
            'jumlah.min' => 'Jumlah barang minimal 0',
            'stok.required' => 'Stok wajib diisi',
            'stok.lte' => 'Stok tidak boleh lebih dari jumlah total',
            'harga_perolehan.numeric' => 'Harga perolehan harus berupa angka',
            'harga_perolehan.min' => 'Harga perolehan tidak boleh kurang dari 0',
            'buku_id.exists' => 'Buku yang dipilih tidak valid',
            'gambar.image' => 'File yang diunggah harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
} 