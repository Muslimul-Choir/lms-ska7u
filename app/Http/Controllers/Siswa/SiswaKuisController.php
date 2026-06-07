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
     * 
     * FIXED: Proper timezone-aware time calculation
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

        // 🔧 FIX: Calculate remaining time properly
        // Convert waktu_mulai to Carbon if it's not already (ensure timezone awareness)
        $waktuMulai = \Carbon\Carbon::parse($hasilKuis->waktu_mulai);
        $waktuSekarang = now();
        
        // Total duration in seconds
        $durasiDetik = $kuis->durasi * 60;
        
        // Elapsed time: how much time has passed since quiz started
        $elapsedDetik = $waktuSekarang->diffInSeconds($waktuMulai, false);
        
        // If negative (shouldn't happen), make it 0
        if ($elapsedDetik < 0) {
            \Log::warning("Quiz #{$kuis->id} has negative elapsed time for student #{$siswa->id}. waktu_mulai: {$waktuMulai}, now: {$waktuSekarang}");
            $elapsedDetik = 0;
        }
        
        // Remaining time
        $sisaDetik = (int) max(0, $durasiDetik - $elapsedDetik);
        
        // Debug logging to trace timer issues
        \Log::info("Quiz Timer Debug - Quiz #{$kuis->id}, Student #{$siswa->id}:", [
            'waktu_mulai' => $waktuMulai->toDateTimeString(),
            'waktu_sekarang' => $waktuSekarang->toDateTimeString(),
            'durasi_menit' => $kuis->durasi,
            'durasi_detik' => $durasiDetik,
            'elapsed_detik' => $elapsedDetik,
            'sisa_detik' => $sisaDetik,
            'timezone' => config('app.timezone'),
        ]);

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
     * 
     * FIXED: Race condition + Time validation
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

        try {
            DB::beginTransaction();

            // 🔒 FIX: Lock row to prevent race condition
            $hasilKuis = HasilKuis::where('id_kuis', $kuis->id)
                ->where('id_siswa', $siswa->id)
                ->lockForUpdate()
                ->first();

            if (!$hasilKuis) {
                DB::rollBack();
                return redirect()->route('siswa.kuis.show', $kuis)
                    ->with('error', 'Anda belum memulai kuis ini.');
            }

            // Check if already submitted (inside transaction now)
            if ($hasilKuis->waktu_selesai) {
                DB::rollBack();
                return redirect()->route('siswa.kuis.hasil', $kuis)
                    ->with('info', 'Anda sudah mengumpulkan kuis ini.');
            }

            // ⏰ FIX: Server-side time validation
            $durasiDetik = $kuis->durasi * 60;
            $elapsedDetik = now()->diffInSeconds($hasilKuis->waktu_mulai);
            $timeExpired = $elapsedDetik > $durasiDetik;

            if ($timeExpired) {
                \Log::info("Quiz #{$kuis->id} time expired for student #{$siswa->id}. Elapsed: {$elapsedDetik}s, Limit: {$durasiDetik}s");
            }

            // Calculate score
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

            $message = $timeExpired 
                ? '⏰ Waktu habis! Kuis telah dikumpulkan otomatis dengan jawaban yang tersedia.' 
                : '✅ Kuis berhasil dikumpulkan!';

            return redirect()->route('siswa.kuis.hasil', $kuis)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Quiz submission error for student #'.$siswa->id.' quiz #'.$kuis->id.': ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan hasil kuis. Silakan coba lagi.');
        }
    }

    /**
     * Display quiz result: score, correct/wrong count, answer key per question (Req 8.8)
     * 
     * FIXED: Verify waktu_selesai is set
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

        // 🔒 FIX: Verify quiz is completed
        if (!$hasilKuis->waktu_selesai) {
            return redirect()->route('siswa.kuis.kerjakan', $kuis)
                ->with('info', 'Kuis belum selesai. Silakan selesaikan terlebih dahulu.');
        }

        // Load all questions with answer keys
        $soalList = $kuis->SoalKuis()->orderBy('nomor_soal')->get();
        $jawaban = $hasilKuis->jawaban ?? [];

        // Calculate wrong answers
        $jumlahSalah = $soalList->count() - $hasilKuis->jumlah_benar;

        return view('siswa.kuis.hasil', compact('siswa', 'kuis', 'hasilKuis', 'soalList', 'jawaban', 'jumlahSalah'));
    }
}
