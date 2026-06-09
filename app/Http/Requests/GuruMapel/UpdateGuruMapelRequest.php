<?php

namespace App\Http\Requests\GuruMapel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruMapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil id record yang sedang di-edit untuk di-ignore
        $guruMapelId = $this->route('guru_mapel')->id;

        return [
            'id_mapel' => [
                'required',
                'exists:mapel,id',
            ],

            'id_guru' => [
                'required',
                'exists:guru,id',
                // Ignore row ini sendiri agar tidak bentrok dengan data saat ini
                Rule::unique('guru_mapel', 'id_guru')
                    ->ignore($guruMapelId),
            ],

            'id_semester' => [
                'required',
                'exists:semester,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_mapel.required' => 'Mapel wajib dipilih.',
            'id_mapel.exists'   => 'Mapel tidak valid.',

            'id_guru.required' => 'Guru wajib dipilih.',
            'id_guru.exists'   => 'Guru tidak valid.',
            'id_guru.unique'   => 'Guru ini sudah ditugaskan ke mata pelajaran lain.',

            'id_semester.required' => 'Semester wajib dipilih.',
            'id_semester.exists'   => 'Semester tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_mapel'    => 'mapel',
            'id_guru'     => 'guru',
            'id_semester' => 'semester',
        ];
    }
}