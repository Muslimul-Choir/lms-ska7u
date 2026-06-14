<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Absensi;
use App\Models\Penilaian;
use App\Models\PengumpulanTugas;
use App\Models\Pertemuan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard with their learning materials and assignments.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan. Silakan hubungi administrator.');
        }

        // Get class information
        $kelas = $siswa->Kelas;

        // Get materials for the student's class
        // Kelas diambil dari JadwalBelajar yang memiliki relasi ke GuruMapel
        // Filter juga berdasarkan agama siswa untuk mapel agama
        $materi = Materi::whereHas('guruMapel.JadwalBelajar', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })
        ->whereHas('Mapel', function ($query) use ($siswa) {
            $query->forAgama($siswa->agama);
        })
        ->latest()->get();

        // Get assignments for the student's class
        // Kelas diambil dari JadwalBelajar yang memiliki relasi ke GuruMapel
        // Filter juga berdasarkan agama siswa untuk mapel agama
        $tugas = Tugas::whereHas('guruMapel.JadwalBelajar', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })
            ->whereHas('Mapel', function ($query) use ($siswa) {
                $query->forAgama($siswa->agama);
            })
            ->where('status', 'published')
            ->latest()
            ->get();

        // Get submission status for each task
        $tugasProgress = [];
        foreach ($tugas as $t) {
            $submission = PengumpulanTugas::where('id_tugas', $t->id)
                ->where('id_siswa', $siswa->id)
                ->first();
            $penilaian = null;
            if ($submission) {
                $penilaian = Penilaian::where('id_pengumpulan_tugas', $submission->id)->first();
            }
            $tugasProgress[$t->id] = [
                'task' => $t,
                'submission' => $submission,
                'assessment' => $penilaian,
                'status' => $submission ? 'submitted' : 'not_submitted',
            ];
        }

        // Get attendance data for this month
        $absensi = Absensi::whereHas('Pertemuan.JadwalBelajar.GuruMapel', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })
            ->where('id_siswa', $siswa->id)
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->get();

        $absensiSummary = [
            'hadir' => $absensi->where('status', 'hadir')->count(),
            'izin' => $absensi->where('status', 'izin')->count(),
            'sakit' => $absensi->where('status', 'sakit')->count(),
            'alpha' => $absensi->where('status', 'alpha')->count(),
        ];

        // Get grades
        $penilaian = Penilaian::whereHas('PengumpulanTugas', function ($query) use ($siswa) {
            $query->where('id_siswa', $siswa->id);
        })->latest()->get();

        $nilaiStats = [
            'total_grades' => $penilaian->count(),
            'average_grade' => $penilaian->count() > 0 ? round($penilaian->avg('nilai'), 2) : 0,
            'highest_grade' => $penilaian->count() > 0 ? $penilaian->max('nilai') : 0,
            'lowest_grade' => $penilaian->count() > 0 ? $penilaian->min('nilai') : 0,
        ];

        return view('siswa.dashboard', compact(
            'user',
            'siswa',
            'kelas',
            'materi',
            'tugasProgress',
            'absensiSummary',
            'penilaian',
            'nilaiStats'
        ));
    }

    /**
     * Display a specific material for the student.
     */
    public function showMateri($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $materi = Materi::findOrFail($id);

        // Check if the material belongs to student's class through JadwalBelajar
        $hasAccess = $materi->guruMapel->JadwalBelajar()
            ->where('id_kelas', $siswa->id_kelas)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke materi ini.');
        }

        return view('siswa.materi.show', compact('siswa', 'materi'));
    }

    /**
     * Display a specific assignment for the student.
     */
    public function showTugas($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $tugas = Tugas::findOrFail($id);

        // Check if the assignment belongs to student's class through JadwalBelajar
        $hasAccess = $tugas->guruMapel->JadwalBelajar()
            ->where('id_kelas', $siswa->id_kelas)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        // Get student's submission
        $submission = PengumpulanTugas::where('id_tugas', $tugas->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        $assessment = null;
        if ($submission) {
            $assessment = Penilaian::where('id_pengumpulan_tugas', $submission->id)->first();
        }

        return view('siswa.tugas.show', compact('siswa', 'tugas', 'submission', 'assessment'));
    }
}
