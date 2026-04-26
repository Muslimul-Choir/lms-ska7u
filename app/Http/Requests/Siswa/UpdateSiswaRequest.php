<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
 
    public function rules(): array
    {
        $siswa = $this->route('siswa'); 
 
        return [
            'nama_lengkap'  => ['required', 'string', 'max:150'],
            'email'         => [
                'required', 'email', 'max:150',
                Rule::unique('siswa', 'email')->ignore($siswa->id),
                Rule::unique('users', 'email')->ignore($siswa->id_user),
            ],
            'agama'         => ['required', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'],
            'id_kelas'      => ['required', 'exists:kelas,id'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'agama.required'        => 'Agama wajib dipilih.',
            'agama.in'              => 'Agama tidak valid.',
            'id_kelas.required'     => 'Kelas wajib dipilih.',
            'id_kelas.exists'       => 'Kelas tidak ditemukan.',
        ];
    }
}
