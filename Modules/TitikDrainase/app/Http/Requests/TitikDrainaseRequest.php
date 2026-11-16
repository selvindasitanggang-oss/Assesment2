<?php

namespace Modules\TitikDrainase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TitikDrainaseRequest extends FormRequest
{
    // Pemeriksaan akses sebelum mutasi: hanya admin.
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return [
            'nama_titik' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kedalaman_cm' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_titik.required' => 'Nama titik drainase wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kedalaman_cm.integer' => 'Kedalaman harus berupa bilangan bulat.',
            'kedalaman_cm.min' => 'Kedalaman minimal 0 cm.',
        ];
    }
}
