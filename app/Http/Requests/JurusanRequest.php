<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JurusanRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jurusanId = $this->route('jurusan')?->id;

        return [
            'nama_jurusan' => [
                'required',
                'string',
                'max:100',
                Rule::unique('jurusan', 'nama_jurusan')
                    ->ignore($jurusanId)
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

    public function messages(): array
    {
        return [
            'nama_jurusan.required' => ':attribute wajib diisi.',
            'nama_jurusan.string'   => ':attribute harus berupa teks.',
            'nama_jurusan.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'nama_jurusan.unique'   => ':attribute sudah digunakan, gunakan nama lain.',
            'keterangan.string'     => ':attribute harus berupa teks.',
        ];
    }
}