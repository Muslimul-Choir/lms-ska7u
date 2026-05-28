<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kuis\SubmitKuisRequest;
use App\Models\HasilKuis;
use App\Models\Kuis;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaKuisController extends Controller
{
    /**
     * Display a listing of quizzes for the student's class.
     * Shows status: "Tersedia", "Sudah Dikerjakan", or "Ditutup"
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Fetch all published quizzes for the student's class
        $kuisList = Kuis::whereHas('guruMapel', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })
        ->where('status', 'published')
        ->with(['Pertemuan', 'GuruMapel.Mapel'])
        ->latest()
        ->get();

        $tersedia = [];
        $sudahDikerjakan = [];
        $ditutup = [];

        $now = now();

        foreach ($kuisList as $kuis) {
            // Check if student has already taken this quiz
            $hasilKuis = HasilKuis::where('id_kuis', $kuis->id)
                ->where('id_siswa', $siswa->id)
                ->first();

            $item = [
                'kuis' => $kuis,
                'hasil' => $hasilKuis
            ];

            if ($hasilKuis) {
                $sudahDikerjakan[] = $item;
            } elseif ($now->lt($kuis->batas_mulai) || $now->gt($kuis->batas_selesai)) {
                $ditutup[] = $item;
            } else {
                $tersedia[] = $item;
            }
        }

        return view('siswa.kuis.index', compact('siswa', 'tersedia', 'sudahDikerjakan', 'ditutup'));
    }

    /**
     * Show confirmation page before starting the quiz.
     * Guards:
     * - Redirect to hasil if already taken (Req 8.9)
     * - Show message if outside time range (Req 8.10)
     * - Show message if draft/closed (Req 8.11)
     */
    public function show(Kuis $kuis)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        // Verify class access
        if ($kuis->guruMapel && $kuis->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        // Guard: Check if draft or closed (Req 8.11)
        if ($kuis->status === 'draft' || $kuis->status === 'closed') {
            return redirect()->route('siswa.kuis.index')
                ->with('error', 'Kuis tidak tersedia.');
        }

        // Guard: Check if already taken (Req 8.9)
        $hasilKuis = HasilKuis::where('id_kuis', $kuis->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        if ($hasilKuis) {
            return redirect()->route('siswa.kuis.hasil', $kuis)
                ->with('info', 'Anda sudah mengerjakan kuis ini.');
        }

        // Guard: Check time range (Req 8.10)
        $now = now();
        if ($now->lt($kuis->batas_mulai)) {
            return redirect()->route('siswa.kuis.index')
                ->with('error', 'Kuis belum dibuka.');
        }

        if ($now->gt($kuis->batas_selesai)) {
            return redirect()->route('siswa.kuis.index')
                ->with('error', 'Kuis sudah ditutup.');
        }

        // Load soal count
        $jumlahSoal = $kuis->SoalKuis()->count();

        return view('siswa.kuis.show', compact('siswa', 'kuis', 'jumlahSoal'));
    }

    /**
     * Start the quiz: create HasilKuis with waktu_mulai = now()
     * Redirect to kerjakan page
     */
    public function mulai(Kuis $kuis)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        // Verify class access
        if ($kuis->guruMapel && $kuis->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        // Check if already taken
        $existing = HasilKuis::where('id_kuis', $kuis->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        if ($existing) {
            return redirect()->route('siswa.kuis.hasil', $kuis)
                ->with('info', 'Anda sudah mengerjakan kuis ini.');
        }

        // Check status and time range
        if ($kuis->status !== 'published') {
            return redirect()->route('siswa.kuis.index')
                ->with('error', 'Kuis tidak tersedia.');
        }

        $now = now();
        if ($now->lt($kuis->batas_mulai) || $now->gt($kuis->batas_selesai)) {
            return redirect()->route('siswa.kuis.index')
                ->with('error', 'Kuis tidak dapat dimulai di luar rentang waktu yang ditentukan.');
        }

        // Create HasilKuis record
        HasilKuis::create([
            'id_kuis' => $kuis->id,
            'id_siswa' => $siswa->id,
            'waktu_mulai' => now(),
        ]);

        return redirect()->route('siswa.kuis.kerjakan', $kuis);
    }

    /**
     * Display all questions and calculate remaining time.
     * Redirect to hasil if time is up.
     */
    public function kerjakan(Kuis $kuis)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        // Verify class access
        if ($kuis->guruMapel && $kuis->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        // Get HasilKuis
        $hasilKuis = HasilKuis::where('id_kuis', $kuis->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        if (!$hasilKuis) {
            return redirect()->route('siswa.kuis.show', $kuis)
                ->with('error', 'Anda belum memulai kuis ini.');
        }

        // If already submitted, redirect to hasil
        if ($hasilKuis->waktu_selesai) {
            return redirect()->route('siswa.kuis.hasil', $kuis);
        }

        // Calculate remaining time in seconds
        $durasiDetik = $kuis->durasi * 60;
        $elapsedDetik = now()->diffInSeconds($hasilKuis->waktu_mulai);
        $sisaDetik = max(0, $durasiDetik - $elapsedDetik);

        // If time is up, redirect to hasil
        if ($sisaDetik <= 0) {
            return redirect()->route('siswa.kuis.hasil', $kuis)
                ->with('info', 'Waktu kuis telah habis.');
        }

        // Load all questions
        $soalList = $kuis->SoalKuis()->orderBy('nomor_soal')->get();

        return view('siswa.kuis.kerjakan', compact('siswa', 'kuis', 'soalList', 'sisaDetik', 'hasilKuis'));
    }

    /**
     * Submit quiz answers, calculate score, save in DB::transaction()
     * Redirect to hasil page (Req 8.7)
     */
    public function submit(SubmitKuisRequest $request, Kuis $kuis)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        // Verify class access
        if ($kuis->guruMapel && $kuis->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        // Get HasilKuis
        $hasilKuis = HasilKuis::where('id_kuis', $kuis->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        if (!$hasilKuis) {
            return redirect()->route('siswa.kuis.show', $kuis)
                ->with('error', 'Anda belum memulai kuis ini.');
        }

        // If already submitted, redirect to hasil
        if ($hasilKuis->waktu_selesai) {
            return redirect()->route('siswa.kuis.hasil', $kuis)
                ->with('info', 'Anda sudah mengumpulkan kuis ini.');
        }

        try {
            DB::beginTransaction();

            // Get all questions with answer keys
            $soalList = $kuis->SoalKuis()->get()->keyBy('nomor_soal');
            $jawaban = $request->input('jawaban', []); // ['1' => 'A', '2' => 'C', ...]
            $benar = 0;

            // Calculate correct answers
            foreach ($soalList as $nomor => $soal) {
                if (isset($jawaban[$nomor]) && $jawaban[$nomor] === $soal->kunci_jawaban) {
                    $benar++;
                }
            }

            $total = $soalList->count();
            $nilai = $total > 0 ? round(($benar / $total) * $kuis->nilai_maksimal, 2) : 0;

            // Update HasilKuis
            $hasilKuis->update([
                'jawaban' => $jawaban,
                'nilai' => $nilai,
                'jumlah_benar' => $benar,
                'waktu_selesai' => now(),
            ]);

            DB::commit();

            return redirect()->route('siswa.kuis.hasil', $kuis)
                ->with('success', 'Kuis berhasil dikumpulkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan hasil kuis. Silakan coba lagi.');
        }
    }

    /**
     * Display quiz result: score, correct/wrong count, answer key per question (Req 8.8)
     */
    public function hasil(Kuis $kuis)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        // Verify class access
        if ($kuis->guruMapel && $kuis->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        // Get HasilKuis
        $hasilKuis = HasilKuis::where('id_kuis', $kuis->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        if (!$hasilKuis) {
            return redirect()->route('siswa.kuis.show', $kuis)
                ->with('error', 'Anda belum mengerjakan kuis ini.');
        }

        // Load all questions with answer keys
        $soalList = $kuis->SoalKuis()->orderBy('nomor_soal')->get();
        $jawaban = $hasilKuis->jawaban ?? [];

        // Calculate wrong answers
        $jumlahSalah = $soalList->count() - $hasilKuis->jumlah_benar;

        return view('siswa.kuis.hasil', compact('siswa', 'kuis', 'hasilKuis', 'soalList', 'jawaban', 'jumlahSalah'));
    }
}
