<?php

namespace App\Http\Requests\Jurusan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJurusanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_jurusan' => ucwords(strtolower(trim($this->nama_jurusan))),
            'keterangan'   => $this->keterangan ? trim($this->keterangan) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_jurusan' => [
                'required',
                'string',
                'max:100',
                Rule::unique('jurusan', 'nama_jurusan')
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
            'nama_jurusan' => 'Nama Jurusan',
            'keterangan'   => 'Keterangan',
        ];
    }
}