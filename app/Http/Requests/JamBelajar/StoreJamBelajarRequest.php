<?php

namespace App\Http\Requests\JamBelajar;

use Illuminate\Foundation\Http\FormRequest;

class StoreJamBelajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // 🔥 Sanitasi input
    protected function prepareForValidation(): void
    {
        $this->merge([
            'jam_mulai'  => $this->cleanString($this->jam_mulai),
            'jam_selesai'=> $this->cleanString($this->jam_selesai),
        ]);
    }

    private function cleanString($value): ?string
    {
        if (is_null($value)) return null;

        return trim(preg_replace('/\s+/', ' ', strip_tags($value)));
    }

    public function rules(): array
    {
        return [
            'jam_mulai' => ['required', 'string', 'max:10'],
            'jam_selesai' => ['required', 'string', 'max:10'],
        ];
    }

    public function attributes(): array
    {
        return [
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
        ];
    }

    public function messages(): array
    {
        return [
            'jam_mulai.required' => ':attribute wajib diisi.',
            'jam_selesai.required' => ':attribute wajib diisi.',
        ];
    }
}