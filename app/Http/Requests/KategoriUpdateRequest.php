<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriUpdateRequest extends FormRequest
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
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategoris', 'nama')->ignore($this->route('kategori')),
            ],
            'kode' => [
                'required',
                'string',
                'max:20',
                Rule::unique('kategoris', 'kode')->ignore($this->route('kategori')),
            ],
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
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.unique' => 'Nama kategori sudah ada dalam sistem',
            'kode.required' => 'Kode kategori wajib diisi',
            'kode.unique' => 'Kode kategori sudah ada dalam sistem',
        ];
    }
} 