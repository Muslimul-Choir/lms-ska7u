<?php

namespace App\Http\Requests\Bagian;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBagianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_bagian' => strtoupper(trim($this->nama_bagian)),
            'deskripsi'   => $this->deskripsi ? trim($this->deskripsi) : null,
        ]);
    }

    public function rules(): array
    {
        $bagianId = $this->route('bagian')?->id;

        return [
            'nama_bagian' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bagian', 'nama_bagian')
                    ->ignore($bagianId)
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