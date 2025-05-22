<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBarangRequest extends FormRequest
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
            'kode' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('barangs', 'kode')->ignore($this->barang),
            ],
            'nama' => 'sometimes|required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'spesifikasi' => 'nullable|string',
            'jumlah' => 'sometimes|required|integer|min:0',
            'satuan' => 'sometimes|required|string|max:50',
            'kondisi' => 'sometimes|required|string|in:baik,rusak ringan,rusak berat',
            'harga' => 'sometimes|required|numeric|min:0',
            'tanggal_perolehan' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|in:tersedia,dipinjam,pemeliharaan,dihapuskan',
            'lokasi' => 'sometimes|required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
            'keterangan' => 'nullable|string',
            'sub_kategori_id' => 'sometimes|required|exists:sub_kategoris,id',
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
            'kode.required' => 'Kode barang wajib diisi',
            'kode.unique' => 'Kode barang sudah digunakan',
            'nama.required' => 'Nama barang wajib diisi',
            'jumlah.required' => 'Jumlah barang wajib diisi',
            'jumlah.min' => 'Jumlah barang minimal 0',
            'satuan.required' => 'Satuan barang wajib diisi',
            'kondisi.required' => 'Kondisi barang wajib diisi',
            'kondisi.in' => 'Kondisi barang tidak valid',
            'harga.required' => 'Harga barang wajib diisi',
            'harga.numeric' => 'Harga barang harus berupa angka',
            'harga.min' => 'Harga barang minimal 0',
            'tanggal_perolehan.required' => 'Tanggal perolehan wajib diisi',
            'tanggal_perolehan.date' => 'Format tanggal perolehan tidak valid',
            'status.required' => 'Status barang wajib diisi',
            'status.in' => 'Status barang tidak valid',
            'lokasi.required' => 'Lokasi barang wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
            'sub_kategori_id.required' => 'Sub kategori wajib diisi',
            'sub_kategori_id.exists' => 'Sub kategori tidak ditemukan',
        ];
    }
} 