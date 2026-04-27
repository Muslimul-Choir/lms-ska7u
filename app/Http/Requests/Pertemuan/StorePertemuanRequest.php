<?php

namespace App\Http\Requests\Pertemuan;

use Illuminate\Foundation\Http\FormRequest;

class StorePertemuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_jadwal'       => 'required|exists:jadwal_belajar,id',
            'nomor_pertemuan' => 'required|integer|min:1|max:255',
            'tanggal'         => 'nullable|date',
            'status'          => 'required|in:dijadwalkan,berlangsung,selesai,dibatalkan',
        ];
    }

    public function messages(): array
    {
        return [
            'id_jadwal.required'       => 'Jadwal wajib dipilih.',
            'id_jadwal.exists'         => 'Jadwal tidak valid.',

            'nomor_pertemuan.required' => 'Nomor pertemuan wajib diisi.',
            'nomor_pertemuan.integer'  => 'Nomor pertemuan harus berupa angka.',
            'nomor_pertemuan.min'      => 'Minimal nomor pertemuan adalah 1.',
            'nomor_pertemuan.max'      => 'Maksimal nomor pertemuan adalah 255.',

            'tanggal.date'             => 'Format tanggal tidak valid.',

            'status.required'          => 'Status wajib dipilih.',
            'status.in'                => 'Status tidak valid.',
        ];
    }
}