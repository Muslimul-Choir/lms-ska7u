<?php

namespace App\Http\Requests\PengumpulanTugas;

use App\Models\Tugas;
use Illuminate\Foundation\Http\FormRequest;

class StorePengumpulanTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tugas = Tugas::find($this->route('id'));
        $tipeFile = $tugas?->tipe_file ?? 'tanpa';

        $rules = ['catatan' => 'nullable|string|max:1000'];

        // Cek apakah ini update (sudah ada pengumpulan sebelumnya)
        $isUpdate = \App\Models\PengumpulanTugas::where('id_tugas', $this->route('id'))
            ->where('id_siswa', auth()->user()->siswa?->id)
            ->exists();

        if ($tipeFile === 'link') {
            // Link selalu required karena tidak bisa kosong
            $rules['file_url'] = 'required|url|max:2048';
        } elseif ($tipeFile === 'dokumen') {
            // Untuk update, file tidak wajib (optional)
            $rules['file_upload'] = ($isUpdate ? 'nullable' : 'required') . '|file|mimes:pdf,doc,docx,zip,rar|max:51200';
        } elseif ($tipeFile === 'gambar') {
            // Untuk update, file tidak wajib (optional)
            $rules['file_upload'] = ($isUpdate ? 'nullable' : 'required') . '|file|mimes:png,jpg,jpeg,gif,webp|max:51200';
        } elseif ($tipeFile === 'video') {
            // Untuk update, file tidak wajib (optional)
            $rules['file_upload'] = ($isUpdate ? 'nullable' : 'required') . '|file|mimes:mp4,webm,ogg|max:51200';
        }
        // 'tanpa' → no file rules

        return $rules;
    }

    public function messages(): array
    {
        return [
            'file_upload.required' => 'File wajib diunggah.',
            'file_upload.file'     => 'Upload harus berupa file.',
            'file_upload.mimes'    => 'Format file tidak diizinkan.',
            'file_upload.max'      => 'Ukuran file tidak boleh melebihi 50 MB.',
            'file_url.required'    => 'Tautan wajib diisi.',
            'file_url.url'         => 'Format tautan tidak valid.',
            'catatan.max'          => 'Catatan maksimal 1000 karakter.',
        ];
    }
}
