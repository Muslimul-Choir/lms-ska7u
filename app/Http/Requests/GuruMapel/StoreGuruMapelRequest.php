<?php

namespace App\Http\Requests\GuruMapel;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruMapelRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_mapel' => 'required|exists:mapel,id',
            'id_guru' => 'required|exists:guru,id',
            'id_kelas' => 'required|exists:kelas,id',
            'id_semester' => 'required|exists:semester,id',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize input if needed
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id_mapel.required' => 'Mapel wajib dipilih.',
            'id_mapel.exists' => 'Mapel tidak valid.',
            'id_guru.required' => 'Guru wajib dipilih.',
            'id_guru.exists' => 'Guru tidak valid.',
            'id_kelas.required' => 'Kelas wajib dipilih.',
            'id_kelas.exists' => 'Kelas tidak valid.',
            'id_semester.required' => 'Semester wajib dipilih.',
            'id_semester.exists' => 'Semester tidak valid.',
        ];
    }
}