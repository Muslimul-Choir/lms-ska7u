<?php

namespace App\Http\Requests\Mapel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'kode_mapel' => $this->cleanString($this->kode_mapel),
            'nama_mapel' => $this->cleanString($this->nama_mapel),
            'deskripsi'  => $this->cleanString($this->deskripsi),
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
        return [
            'kode_mapel' => [
                'required',
                'string',
                'max:50',
                Rule::unique('mapel', 'kode_mapel')
                    ->whereNull('deleted_at'),
            ],
            'nama_mapel' => [
                'required',
                'string',
                'max:100',
                Rule::unique('mapel', 'nama_mapel')
                    ->whereNull('deleted_at'),
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:255',
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_mapel' => 'Kode Mapel',
            'nama_mapel' => 'Nama Mapel',
            'deskripsi'  => 'Deskripsi',
            'foto'       => 'Foto',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_mapel.required' => ':attribute wajib diisi.',
            'kode_mapel.string'   => ':attribute harus berupa teks.',
            'kode_mapel.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'kode_mapel.unique'   => ':attribute sudah digunakan, gunakan kode lain.',

            'nama_mapel.required' => ':attribute wajib diisi.',
            'nama_mapel.string'   => ':attribute harus berupa teks.',
            'nama_mapel.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'nama_mapel.unique'   => ':attribute sudah digunakan, gunakan nama lain.',

            'deskripsi.string'    => ':attribute harus berupa teks.',
            'deskripsi.max'       => ':attribute tidak boleh lebih dari :max karakter.',

            'foto.image'          => ':attribute harus berupa gambar.',
            'foto.mimes'          => ':attribute harus berformat jpeg, png, jpg, atau gif.',
            'foto.max'            => ':attribute tidak boleh lebih dari 2MB.',
        ];
    }
}