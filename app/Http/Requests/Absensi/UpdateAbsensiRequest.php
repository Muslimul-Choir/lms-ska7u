<?php

namespace App\Http\Requests\Absensi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAbsensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_pertemuan' => 'sometimes|required|exists:pertemuan,id',
            'id_siswa'     => 'sometimes|required|exists:siswa,id',
            'status'       => 'sometimes|required|in:hadir,izin,sakit,alpha',
            'keterangan'   => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'id_pertemuan.required' => 'Pertemuan wajib dipilih.',
            'id_pertemuan.exists'   => 'Pertemuan tidak valid.',

            'id_siswa.required'     => 'Siswa wajib dipilih.',
            'id_siswa.exists'       => 'Siswa tidak valid.',

            'status.required'       => 'Status tidak boleh kosong.',
            'status.in'             => 'Status tidak valid.',

            'keterangan.max'        => 'Keterangan maksimal 500 karakter.',
        ];
    }
}