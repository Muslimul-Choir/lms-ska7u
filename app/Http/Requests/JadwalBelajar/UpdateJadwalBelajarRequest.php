<?php

namespace App\Http\Requests\JadwalBelajar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJadwalBelajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jadwalId = $this->route('jadwalbelajar')?->id;

        return [
            'id_guru_mapel' => [
                'required',
                'integer',
                Rule::exists('guru_mapel', 'id')->whereNull('deleted_at'),
            ],
            'id_kelas' => [
                'required',
                'integer',
                Rule::exists('kelas', 'id')->whereNull('deleted_at'),
            ],
            'hari' => [
                'required',
                'string',
                Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']),
            ],
            'id_jam' => [
                'required',
                'integer',
                Rule::exists('jam_belajar', 'id')->whereNull('deleted_at'),
                Rule::unique('jadwal_belajar')
                    ->ignore($jadwalId)
                    ->where('id_kelas', $this->id_kelas)
                    ->where('hari', $this->hari)
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'id_guru_mapel' => 'Guru Mata Pelajaran',
            'id_jam'        => 'Jam Belajar',
            'id_kelas'      => 'Kelas',
            'hari'          => 'Hari',
        ];
    }

    public function messages(): array
    {
        return [
            'id_jam.unique' => 'Kelas ini sudah memiliki jadwal pada jam dan hari yang sama.',
        ];
    }
}