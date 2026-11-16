<?php

namespace Modules\Laporan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Laporan\Models\Laporan;

class LaporanRequest extends FormRequest
{
    // Tambah: semua yang login. Ubah: hanya pemilik laporan.
    public function authorize(): bool
    {
        $user = $this->user();
        if (! $user) {
            return false;
        }

        $laporan = $this->route('laporan');

        return ! $laporan || $laporan->user_id === $user->id;
    }

    public function rules(): array
    {
        return [
            'titik_drainase_id' => ['required', 'integer', 'exists:titik_drainases,id'],
            'tinggi_air_cm' => ['required', 'integer', 'min:0'],
            'status_kondisi' => ['required', Rule::in(Laporan::STATUS)],
            'deskripsi' => ['required', 'string'],
            'foto_bukti' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'titik_drainase_id.required' => 'Titik drainase wajib dipilih.',
            'titik_drainase_id.exists' => 'Titik drainase tidak terdaftar.',
            'tinggi_air_cm.required' => 'Tinggi air wajib diisi.',
            'tinggi_air_cm.integer' => 'Tinggi air harus berupa bilangan bulat.',
            'tinggi_air_cm.min' => 'Tinggi air minimal 0 cm.',
            'status_kondisi.required' => 'Status kondisi wajib dipilih.',
            'status_kondisi.in' => 'Status harus Normal, Tersumbat, atau Meluap.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'foto_bukti.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto_bukti.max' => 'Ukuran foto maksimal 2 MB.',
            'foto_bukti.uploaded' => 'Foto gagal diunggah (maksimal 2 MB).',
        ];
    }
}
