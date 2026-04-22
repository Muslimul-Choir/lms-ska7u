<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BagianRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'nama_bagian.required' => ':attribute wajib diisi.',
            'nama_bagian.string'   => ':attribute harus berupa teks.',
            'nama_bagian.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'nama_bagian.unique'   => ':attribute sudah digunakan, gunakan nama lain.',

            'deskripsi.string'     => ':attribute harus berupa teks.',
            'deskripsi.max'        => ':attribute tidak boleh lebih dari :max karakter.',
        ];
    }
}