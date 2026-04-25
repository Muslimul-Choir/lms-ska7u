<?php

namespace App\Http\Requests\Bagian;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBagianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_bagian' => trim($this->nama_bagian),
            'deskripsi'   => $this->deskripsi ? trim($this->deskripsi) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_bagian' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bagian', 'nama_bagian')
                    ->whereNull('deleted_at'),
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_bagian' => 'Nama Bagian',
            'deskripsi'   => 'Deskripsi',
        ];
    }
}