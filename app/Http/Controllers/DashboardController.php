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

    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'guru' && $user->guru) {
            $guru = $user->guru;
            $myClassIds = GuruMapel::where('id_guru', $guru->id)->pluck('id_kelas')->unique();
            $myGuruMapelIds = GuruMapel::where('id_guru', $guru->id)->pluck('id');
            $myJadwalIds = JadwalBelajar::whereIn('id_guru_mapel', $myGuruMapelIds)->pluck('id');
            $myPertemuanIds = Pertemuan::whereIn('id_jadwal', $myJadwalIds)->pluck('id');
            $myTugasIds = Tugas::whereIn('id_guru_mapel', $myGuruMapelIds)->pluck('id');
            $myPengumpulanIds = PengumpulanTugas::whereIn('id_tugas', $myTugasIds)->pluck('id');

            $counts = [
                'users' => 1,
                'bagian' => 0,
                'jurusan' => 0,
                'semester' => Semester::count(),
                'tahun_ajaran' => TahunAjaran::count(),
                'tingkatan' => Tingkatan::count(),
                'mapel' => GuruMapel::where('id_guru', $guru->id)->pluck('id_mapel')->unique()->count(),
                'jam_belajar' => JamBelajar::count(),
                'guru' => 1,
                'kelas' => $myClassIds->count(),
                'siswa' => Siswa::whereIn('id_kelas', $myClassIds)->count(),
                'materi' => Materi::whereIn('id_guru_mapel', $myGuruMapelIds)->count(),
                'pertemuan' => $myPertemuanIds->count(),
                'tugas' => $myTugasIds->count(),
                'pengumpulan_tugas' => $myPengumpulanIds->count(),
                'penilaian' => Penilaian::whereIn('id_pengumpulan_tugas', $myPengumpulanIds)->count(),
                'absensi' => Absensi::whereIn('id_pertemuan', $myPertemuanIds)->count(),
                'guru_mapel' => $myGuruMapelIds->count(),
                'jadwalbelajar' => $myJadwalIds->count(),
            ];
        } else {
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
                'jadwalbelajar' => JadwalBelajar::count(),
            ];
        }

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
