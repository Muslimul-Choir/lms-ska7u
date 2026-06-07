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
        $guruMapelId = $this->route('guru_mapel')->id;

        return [
            'id_mapel' => [
                'required',
                'exists:mapel,id',
                Rule::unique('guru_mapel')
                    ->ignore($guruMapelId)
                    ->where(function ($query) {
                        return $query
                            ->where('id_guru', $this->id_guru)
                            ->where('id_semester', $this->id_semester);
                    }),
            ],

            'id_guru' => [
                'required',
                'exists:guru,id',
            ],

            'id_semester' => [
                'required',
                'exists:semester,id',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        //
    }

    public function messages(): array
    {
        return [
            'id_mapel.required' => 'Mapel wajib dipilih.',
            'id_mapel.exists'   => 'Mapel tidak valid.',
            'id_mapel.unique'   => 'Data guru mapel dengan kombinasi guru, mapel, dan semester tersebut sudah terdaftar.',

            'id_guru.required' => 'Guru wajib dipilih.',
            'id_guru.exists'   => 'Guru tidak valid.',

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