<?php

namespace App\Http\Requests\Kuis;

use Illuminate\Foundation\Http\FormRequest;

class SubmitKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jawaban'   => 'nullable|array',
            'jawaban.*' => 'in:A,B,C,D',
        ];
    }

    public function messages(): array
    {
        return [
            'jawaban.array'   => 'Format jawaban tidak valid.',
            'jawaban.*.in'    => 'Pilihan jawaban harus A, B, C, atau D.',
        ];
    }
}
