<?php

namespace App\Http\Requests\Kuis;

use App\Models\SoalKuis;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateKuisRequest extends FormRequest
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
            'status'         => 'required|in:draft,published,closed',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('status') === 'published') {
                $kuisId = $this->route('kuis')?->id ?? $this->route('kuis');
                $count = SoalKuis::where('id_kuis', $kuisId)->count();
                if ($count < 1) {
                    $validator->errors()->add('status', 'Kuis harus memiliki minimal 1 soal sebelum dipublikasikan.');
                }
            }
        });
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
            'batas_selesai.required'  => 'Batas selesai wajib diisi.',
            'batas_selesai.after'     => 'Batas selesai harus setelah batas mulai.',
            'status.required'         => 'Status wajib dipilih.',
            'status.in'               => 'Status tidak valid.',
        ];
    }
}
