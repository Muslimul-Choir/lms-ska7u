<?php

namespace App\Http\Requests\Kuis;

use Illuminate\Foundation\Http\FormRequest;

class StoreKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'          => 'required|string|max:200',
            'id_pertemuan'   => 'required|exists:pertemuan,id',
            'id_guru_mapel'  => 'required|exists:guru_mapel,id',
            'deskripsi'      => 'nullable|string',
            'durasi'         => 'required|integer|min:1',
            'nilai_maksimal' => 'required|numeric|min:1|max:100',
            'batas_mulai'    => 'required|date',
            'batas_selesai'  => 'required|date|after:batas_mulai',
            
            // Scheduled release fields
            'auto_release'   => 'sometimes|boolean',
            'waktu_rilis'    => 'nullable|date|required_if:auto_release,false',
            'batas_absensi'  => 'nullable|date|after_or_equal:waktu_rilis',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'          => 'Judul kuis wajib diisi.',
            'judul.max'               => 'Judul kuis maksimal 200 karakter.',
            'id_pertemuan.required'   => 'Pertemuan wajib dipilih.',
            'id_pertemuan.exists'     => 'Pertemuan tidak valid.',
            'id_guru_mapel.required'  => 'Mata pelajaran wajib dipilih.',
            'id_guru_mapel.exists'    => 'Mata pelajaran tidak valid.',
            'durasi.required'         => 'Durasi wajib diisi.',
            'durasi.integer'          => 'Durasi harus berupa angka bulat.',
            'durasi.min'              => 'Durasi harus berupa angka positif dalam menit.',
            'nilai_maksimal.required' => 'Nilai maksimal wajib diisi.',
            'nilai_maksimal.min'      => 'Nilai maksimal minimal 1.',
            'batas_mulai.required'    => 'Batas mulai wajib diisi.',
            'batas_mulai.date'        => 'Format batas mulai tidak valid.',
            'batas_selesai.required'  => 'Batas selesai wajib diisi.',
            'batas_selesai.date'      => 'Format batas selesai tidak valid.',
            'batas_selesai.after'     => 'Batas selesai harus setelah batas mulai.',
            
            // Scheduled release messages
            'auto_release.boolean'         => 'Format auto release tidak valid.',
            'waktu_rilis.required_if'      => 'Waktu rilis wajib diisi untuk rilis manual.',
            'waktu_rilis.date'             => 'Format waktu rilis tidak valid.',
            'batas_absensi.date'           => 'Format batas absensi tidak valid.',
            'batas_absensi.after_or_equal' => 'Batas absensi harus setelah atau sama dengan waktu rilis.',
        ];
    }
}
