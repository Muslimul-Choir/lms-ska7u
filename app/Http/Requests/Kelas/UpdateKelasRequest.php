<?php

namespace App\Http\Requests\Kelas;

// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kelasId = $this->route('kelas')?->id ?? $this->route('kelas');
 
        return [
            'id_tingkatan'    => ['required', 'integer', 'exists:tingkatan,id'],
            'id_jurusan'      => ['required', 'integer', 'exists:jurusan,id'],
            'id_tahun_ajaran' => ['required', 'integer', 'exists:tahun_ajaran,id'],
            'id_wali_kelas'   => ['required', 'integer', 'exists:guru,id'],
 
            // Unik kecuali record yang sedang diedit
            'id_bagian' => [
                'required',
                'integer',
                'exists:bagian,id',
                Rule::unique('kelas')->where(function ($query) {
                    return $query
                        ->where('id_tingkatan', $this->id_tingkatan)
                        ->where('id_jurusan', $this->id_jurusan)
                        ->where('id_tahun_ajaran', $this->id_tahun_ajaran)
                        ->whereNull('deleted_at');
                })->ignore($kelasId),
            ],
        ];
    }
 
    public function messages(): array
    {
        return [
            'id_tingkatan.required'    => 'Tingkatan wajib dipilih.',
            'id_tingkatan.exists'      => 'Tingkatan yang dipilih tidak valid.',
            
            'id_jurusan.required'      => 'Jurusan wajib dipilih.',
            'id_jurusan.exists'        => 'Jurusan yang dipilih tidak valid.',
            
            'id_bagian.required'       => 'Bagian/Rombel wajib dipilih.',
            'id_bagian.exists'         => 'Bagian yang dipilih tidak valid.',
            'id_bagian.unique'         => 'Kombinasi kelas sudah ada.',
            
            'id_tahun_ajaran.required' => 'Tahun ajaran wajib dipilih.',
            'id_tahun_ajaran.exists'   => 'Tahun ajaran yang dipilih tidak valid.',
            
            'id_wali_kelas.required'   => 'Wali kelas wajib dipilih.',
            'id_wali_kelas.exists'     => 'Guru yang dipilih tidak valid.',
        ];
    }
 
}
