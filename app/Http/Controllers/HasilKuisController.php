<?php

namespace App\Http\Controllers;

use App\Models\HasilKuis;
use App\Models\Kuis;
use Illuminate\Support\Facades\Auth;

class HasilKuisController extends Controller
{
    /**
     * Display detailed answers for a specific student's quiz result.
     * Shows each question with student's answer vs correct answer.
     */
    public function show(Kuis $kuis, HasilKuis $hasil)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat hasil kuis ini.');
        }

        // Verify hasil belongs to kuis
        if ($hasil->id_kuis !== $kuis->id) {
            abort(404, 'Hasil kuis tidak ditemukan.');
        }

        $hasil->load('Siswa');
        $soalList = $kuis->SoalKuis()->orderBy('nomor_soal')->get();
        $jawaban = $hasil->jawaban ?? [];

        // Calculate wrong answers
        $jumlahSalah = $soalList->count() - $hasil->jumlah_benar;

        return view('hasil_kuis.show', compact('kuis', 'hasil', 'soalList', 'jawaban', 'jumlahSalah'));
    }
}
