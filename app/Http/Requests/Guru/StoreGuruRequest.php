<?php

namespace App\Http\Requests\Guru;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGuruRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap'    => ['required', 'string', 'max:150'],
            'email'           => [
                'required',
                'email',
                'max:150',
                Rule::unique('guru', 'email')->whereNull('deleted_at'),
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'status_pengajar' => ['required', 'in:pengajar,walikelas,keduanya'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'nama_lengkap.required'    => 'Nama lengkap wajib diisi.',

            'email.required'           => 'Email wajib diisi.',
            'email.email'              => 'Format email tidak valid.',
            'email.unique'             => 'Email sudah terdaftar.',
            
            'status_pengajar.required' => 'Status pengajar wajib dipilih.',
            'status_pengajar.in'       => 'Status pengajar tidak valid.',
        ];
    }
}
