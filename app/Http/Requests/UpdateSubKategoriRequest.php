<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubKategoriRequest extends FormRequest
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
            'nama' => 'sometimes|required|string|max:255',
            'keterangan' => 'nullable|string',
            'kategori_id' => 'sometimes|required|exists:kategoris,id',
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
            'nama.required' => 'Nama sub kategori wajib diisi',
            'nama.max' => 'Nama sub kategori maksimal 255 karakter',
            'kategori_id.required' => 'Kategori wajib diisi',
            'kategori_id.exists' => 'Kategori tidak ditemukan',
        ];
    }
} 