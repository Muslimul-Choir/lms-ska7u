<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BagianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Ambil ID bagian jika sedang update (route model binding)
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

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_bagian' => 'Nama Bagian',
            'deskripsi'  => 'deskripsi',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_bagian.required' => ':attribute wajib diisi.',
            'nama_bagian.string'   => ':attribute harus berupa teks.',
            'nama_bagian.max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'nama_bagian.unique'   => ':attribute sudah digunakan, gunakan nama lain.',
            'deskripsi.string'    => ':attribute harus berupa teks.',
            'deskripsi.max'       => ':attribute tidak boleh lebih dari :max karakter.',
        ];
    }
}