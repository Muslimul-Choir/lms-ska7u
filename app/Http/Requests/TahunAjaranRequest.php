<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TahunAjaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tahunAjaranId = $this->route('tahunajaran')?->id;

        return [
            'nama_tahun' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tahun_ajaran', 'nama_tahun')
                    ->ignore($tahunAjaranId)
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_tahun' => 'Nama Tahun Ajaran',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_tahun.required' => ':attribute wajib diisi.',
            'nama_tahun.string'   => ':attribute harus berupa teks.',
            'nama_tahun.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'nama_tahun.unique'   => ':attribute sudah digunakan, gunakan nama lain.',
        ];
    }
}