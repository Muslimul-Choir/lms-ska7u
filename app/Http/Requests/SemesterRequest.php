<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_semester' => $this->cleanString($this->nama_semester),
        ]);
    }

    // helper sanitasi
    private function cleanString($value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return trim(
            preg_replace('/\s+/', ' ', strip_tags($value))
        );
    }

    public function rules(): array
    {
        $semesterId = $this->route('semester')?->id;

        return [
            'nama_semester' => [
                'required',
                'string',
                'max:50',
                Rule::unique('semester', 'nama_semester')
                    ->ignore($semesterId)
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_semester' => 'Nama Semester',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_semester.required' => ':attribute wajib diisi.',
            'nama_semester.string'   => ':attribute harus berupa teks.',
            'nama_semester.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'nama_semester.unique'   => ':attribute sudah digunakan, gunakan nama lain.',
        ];
    }
}