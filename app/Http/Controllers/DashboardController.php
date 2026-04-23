<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bagian;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Penilaian;
use App\Models\Pertemuan;
use App\Models\PengumpulanTugas;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\Tugas;
use App\Models\Tingkatan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with comprehensive statistics
     */
    public function index()
    {
        // Collect all data counts for dashboard
        $counts = [
            'users' => User::count(),
            'bagian' => Bagian::count(),
            'jurusan' => Jurusan::count(),
            'semester' => Semester::count(),
            'tahun_ajaran' => TahunAjaran::count(),
            'tingkatan' => Tingkatan::count(),
            'mapel' => Mapel::count(),
            'jam_belajar' => JamBelajar::count(),
            'guru' => Guru::count(),
            'kelas' => Kelas::count(),
            'siswa' => Siswa::count(),
            'materi' => Materi::count(),
            'pertemuan' => Pertemuan::count(),
            'tugas' => Tugas::count(),
            'pengumpulan_tugas' => PengumpulanTugas::count(),
            'penilaian' => Penilaian::count(),
            'absensi' => Absensi::count(),
            'guru_mapel' => GuruMapel::count(),
            'jadwal_belajar' => JadwalBelajar::count(),
        ];

        // Calculate additional metrics
        $metrics = [
            'total_users_and_students' => $counts['users'] + $counts['siswa'],
            'total_classes_and_subjects' => $counts['kelas'] + $counts['mapel'],
            'learning_activities' => $counts['materi'] + $counts['tugas'],
            'class_ratio' => $counts['kelas'] > 0 ? round($counts['siswa'] / $counts['kelas']) : 0,
            'assessment_ratio' => $counts['pengumpulan_tugas'] > 0 ? round(($counts['penilaian'] / $counts['pengumpulan_tugas']) * 100) : 0,
            'total_data' => array_sum($counts),
            'total_categories' => count($counts),
        ];

        return view('dashboard', compact('counts', 'metrics'));
    }
}
