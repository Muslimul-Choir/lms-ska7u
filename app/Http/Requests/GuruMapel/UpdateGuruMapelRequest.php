<?php

namespace App\Http\Requests\GuruMapel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruMapelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
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
                            ->where('id_kelas', $this->id_kelas)
                            ->where('id_semester', $this->id_semester);
                    }),
            ],

            'id_guru' => [
                'required',
                'exists:guru,id',
            ],

            'id_kelas' => [
                'required',
                'exists:kelas,id',
            ],

            'id_semester' => [
                'required',
                'exists:semester,id',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Tambahkan sanitasi jika diperlukan
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id_mapel.required' => 'Mapel wajib dipilih.',
            'id_mapel.exists'   => 'Mapel tidak valid.',
            'id_mapel.unique'   => 'Data guru mapel dengan kombinasi guru, mapel, kelas, dan semester tersebut sudah terdaftar.',

            'id_guru.required' => 'Guru wajib dipilih.',
            'id_guru.exists'   => 'Guru tidak valid.',

            'id_kelas.required' => 'Kelas wajib dipilih.',
            'id_kelas.exists'   => 'Kelas tidak valid.',

            'id_semester.required' => 'Semester wajib dipilih.',
            'id_semester.exists'   => 'Semester tidak valid.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'id_mapel'    => 'mapel',
            'id_guru'     => 'guru',
            'id_kelas'    => 'kelas',
            'id_semester' => 'semester',
        ];
    }
}