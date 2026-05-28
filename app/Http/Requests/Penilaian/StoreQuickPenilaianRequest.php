<?php

namespace App\Http\Requests\Penilaian;

use App\Models\PengumpulanTugas;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuickPenilaianRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // Get nilai_maksimal from the related tugas
        $pengumpulan = PengumpulanTugas::with('Tugas')->find($this->input('id_pengumpulan_tugas'));
        $nilaiMaksimal = $pengumpulan?->Tugas?->nilai_maksimal ?? 100;

        return [
            'id_pengumpulan_tugas' => 'required|exists:pengumpulan_tugas,id',
            'nilai'                => "required|numeric|min:0|max:{$nilaiMaksimal}",
            'catatan_guru'         => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        $pengumpulan = PengumpulanTugas::with('Tugas')->find($this->input('id_pengumpulan_tugas'));
        $nilaiMaksimal = $pengumpulan?->Tugas?->nilai_maksimal ?? 100;

        return [
            'id_pengumpulan_tugas.required' => 'Pengumpulan tugas wajib dipilih.',
            'id_pengumpulan_tugas.exists'   => 'Pengumpulan tugas tidak valid.',
            'nilai.required'                => 'Nilai wajib diisi.',
            'nilai.numeric'                 => 'Nilai harus berupa angka.',
            'nilai.min'                     => 'Nilai tidak boleh kurang dari 0.',
            'nilai.max'                     => "Nilai harus antara 0 dan {$nilaiMaksimal}.",
            'catatan_guru.max'              => 'Catatan maksimal 1000 karakter.',
        ];
    }
}
