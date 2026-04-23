<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TingkatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_tingkatan' => $this->cleanString($this->nama_tingkatan),
            'keterangan'     => $this->cleanString($this->keterangan),
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
        $tingkatanId = $this->route('tingkatan')?->id;

        return [
            'nama_tingkatan' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tingkatan', 'nama_tingkatan')
                    ->ignore($tingkatanId)
                    ->whereNull('deleted_at'),
            ],
            'keterangan' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_tingkatan' => 'Nama Tingkatan',
            'keterangan'     => 'Keterangan',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_tingkatan.required' => ':attribute wajib diisi.',
            'nama_tingkatan.string'   => ':attribute harus berupa teks.',
            'nama_tingkatan.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'nama_tingkatan.unique'   => ':attribute sudah digunakan, gunakan nama lain.',
            'keterangan.string'       => ':attribute harus berupa teks.',
        ];
    }
}