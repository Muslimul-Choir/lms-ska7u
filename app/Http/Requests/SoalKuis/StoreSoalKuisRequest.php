<?php

namespace App\Http\Requests\SoalKuis;

use Illuminate\Foundation\Http\FormRequest;

class StoreSoalKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor_soal'    => 'required|integer|min:1',
            'pertanyaan'    => 'required|string',
            'gambar_soal'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pilihan_a'     => 'required|string',
            'pilihan_b'     => 'required|string',
            'pilihan_c'     => 'required|string',
            'pilihan_d'     => 'required|string',
            'kunci_jawaban' => 'required|in:A,B,C,D',
        ];
    }

    public function messages(): array
    {
        return [
            'nomor_soal.required'    => 'Nomor soal wajib diisi.',
            'nomor_soal.integer'     => 'Nomor soal harus berupa angka.',
            'nomor_soal.min'         => 'Nomor soal minimal 1.',
            'pertanyaan.required'    => 'Pertanyaan wajib diisi.',
            'gambar_soal.image'      => 'File harus berupa gambar.',
            'gambar_soal.mimes'      => 'Gambar harus berformat JPEG, PNG, atau JPG.',
            'gambar_soal.max'        => 'Ukuran gambar maksimal 2MB.',
            'pilihan_a.required'     => 'Semua pilihan jawaban (A, B, C, D) wajib diisi.',
            'pilihan_b.required'     => 'Semua pilihan jawaban (A, B, C, D) wajib diisi.',
            'pilihan_c.required'     => 'Semua pilihan jawaban (A, B, C, D) wajib diisi.',
            'pilihan_d.required'     => 'Semua pilihan jawaban (A, B, C, D) wajib diisi.',
            'kunci_jawaban.required' => 'Kunci jawaban wajib dipilih.',
            'kunci_jawaban.in'       => 'Kunci jawaban harus A, B, C, atau D.',
        ];
    }
}
