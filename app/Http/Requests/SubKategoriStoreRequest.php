<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubKategoriStoreRequest extends FormRequest
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
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:100|unique:sub_kategoris,nama,NULL,id,kategori_id,' . $this->kategori_id,
            'kode' => 'required|string|max:20|unique:sub_kategoris,kode',
            'deskripsi' => 'nullable|string',
            'active' => 'boolean',
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
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid',
            'nama.required' => 'Nama sub-kategori wajib diisi',
            'nama.unique' => 'Nama sub-kategori sudah ada dalam kategori ini',
            'kode.required' => 'Kode sub-kategori wajib diisi',
            'kode.unique' => 'Kode sub-kategori sudah ada dalam sistem',
        ];
    }
} 