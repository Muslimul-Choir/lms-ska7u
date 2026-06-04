<?php

namespace App\Http\Requests\JamBelajar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJamBelajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_tingkatan' => [
                'required',
                'exists:tingkatan,id',
            ],

            'jam_mulai' => [
                'required',
                'date_format:H:i',
            ],

            'jam_selesai' => [
                'required',
                'date_format:H:i',
                'after:jam_mulai',

                Rule::unique('jam_belajar')
                    ->where(function ($query) {
                        return $query
                            ->where('id_tingkatan', $this->id_tingkatan)
                            ->where('jam_mulai', $this->jam_mulai);
                    }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_tingkatan.required' => 'Tingkatan wajib dipilih.',
            'id_tingkatan.exists'   => 'Tingkatan tidak valid.',

            'jam_mulai.required'    => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',

            'jam_selesai.required'    => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after'       => 'Jam selesai harus setelah jam mulai.',

            'jam_selesai.unique' => 'Jam belajar dengan tingkatan dan waktu yang sama sudah tersedia.',
        ];
    }
}