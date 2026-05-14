<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap'  => ['required', 'string', 'max:150'],
            'email'         => ['required', 'email', 'max:150', 'unique:siswa,email', 'unique:users,email'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'agama'         => ['required', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'],
            'id_kelas'      => ['required', 'exists:kelas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required'  => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max'       => 'Nama lengkap tidak boleh lebih dari 150 karakter.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'   => 'Tanggal lahir harus sebelum hari ini.',
            'agama.required'         => 'Agama wajib dipilih.',
            'agama.in'               => 'Agama tidak valid.',
            'id_kelas.required'      => 'Kelas wajib dipilih.',
            'id_kelas.exists'        => 'Kelas tidak ditemukan.',
        ];
    }
}
