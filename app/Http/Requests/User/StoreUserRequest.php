<?php

namespace App\Http\Requests\User;

// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:super_admin,admin'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'name.string'       => 'Nama harus berupa huruf.',
            'name.max'          => 'Nama tidak boleh lebih dari 255 karakter.',

            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.max'         => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique'      => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.string'   => 'Password harus berupa huruf.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Role tidak valid. Pilih antara Super Admin atau Admin.',
        ];
    }
}
