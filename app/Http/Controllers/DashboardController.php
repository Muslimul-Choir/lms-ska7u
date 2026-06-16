<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bagian;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\HasilKuis;
use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\PengumpulanTugas;
use App\Models\Penilaian;
use App\Models\Pertemuan;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\Tingkatan;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ── ADMIN / SUPER ADMIN ──────────────────────────────────────────
        if (in_array($user->role, ['admin', 'super_admin'])) {
            $counts  = $this->buildAdminCounts();
            $metrics = $this->buildAdminMetrics($counts);
            return view('dashboard', compact('counts', 'metrics'));
        }

        // ── GURU ─────────────────────────────────────────────────────────
        if ($user->role === 'guru' && $user->guru) {
            $guru   = $user->guru;
            $status = $guru->status_pengajar; // pengajar | walikelas | keduanya

            // Scope data guru sebagai pengajar
            $myGuruMapelIds   = GuruMapel::where('id_guru', $guru->id)->pluck('id');
            $myJadwalIds      = JadwalBelajar::whereIn('id_guru_mapel', $myGuruMapelIds)->pluck('id');
            $myClassIds       = JadwalBelajar::whereIn('id_guru_mapel', $myGuruMapelIds)->pluck('id_kelas')->filter()->unique();
            $myPertemuanIds   = Pertemuan::whereIn('id_jadwal', $myJadwalIds)->pluck('id');
            $myTugasIds       = Tugas::whereIn('id_guru_mapel', $myGuruMapelIds)->pluck('id');
            $myPengumpulanIds = PengumpulanTugas::whereIn('id_tugas', $myTugasIds)->pluck('id');

            $counts = [
                'users'             => 1,
                'bagian'            => 0,
                'jurusan'           => 0,
                'semester'          => Semester::count(),
                'tahun_ajaran'      => TahunAjaran::count(),
                'tingkatan'         => Tingkatan::count(),
                'mapel'             => $myGuruMapelIds->isNotEmpty()
                    ? GuruMapel::whereIn('id', $myGuruMapelIds)->pluck('id_mapel')->unique()->count()
                    : 0,
                'jam_belajar'       => JamBelajar::count(),
                'guru'              => 1,
                'kelas'             => $myClassIds->count(),
                'siswa'             => Siswa::whereIn('id_kelas', $myClassIds)->count(),
                'materi'            => Materi::whereIn('id_guru_mapel', $myGuruMapelIds)->count(),
                'pertemuan'         => $myPertemuanIds->count(),
                'tugas'             => $myTugasIds->count(),
                'pengumpulan_tugas' => $myPengumpulanIds->count(),
                'penilaian'         => Penilaian::whereIn('id_pengumpulan_tugas', $myPengumpulanIds)->count(),
                'absensi'           => Absensi::whereIn('id_pertemuan', $myPertemuanIds)->count(),
                'guru_mapel'        => $myGuruMapelIds->count(),
                'jadwalbelajar'     => $myJadwalIds->count(),
            ];

            $metrics       = $this->buildMetrics($counts);
            $pengajarData  = null;
            $waliKelasData = null;

            // Data untuk dashboard pengajar (pengajar & keduanya)
            if (in_array($status, ['pengajar', 'keduanya'])) {
                $pengajarData = $this->buildPengajarData(
                    $guru,
                    $myGuruMapelIds,
                    $myClassIds,
                    $myTugasIds,
                    $myPengumpulanIds
                );
            }

            // Data untuk dashboard walikelas (walikelas & keduanya)
            if (in_array($status, ['walikelas', 'keduanya'])) {
                $waliKelasData = $this->buildWaliKelasData($guru);
            }

            $isWaliKelas = in_array($status, ['walikelas', 'keduanya']);
            $isPengajar  = in_array($status, ['pengajar', 'keduanya']);
            $isKeduanya  = $status === 'keduanya';

            return view('dashboard', compact(
                'counts',
                'metrics',
                'pengajarData',
                'waliKelasData',
                'isWaliKelas',
                'isPengajar',
                'isKeduanya'
            ));
        }

        return redirect()->route('login');
    }

    // ─────────────────────────────────────────────────────────────────────
    // Admin counts
    // ─────────────────────────────────────────────────────────────────────
    private function buildAdminCounts(): array
    {
        return [
            'users'        => User::count(),
            'guru'         => Guru::count(),
            'siswa'        => Siswa::count(),
            'kelas'        => Kelas::count(),
            'mapel'        => Mapel::count(),
            'guru_mapel'   => GuruMapel::count(),
            'jadwalbelajar' => JadwalBelajar::count(),
            'jurusan'      => Jurusan::count(),
            'tingkatan'    => Tingkatan::count(),
            'bagian'       => Bagian::count(),
            'semester'     => Semester::count(),
            'tahun_ajaran' => TahunAjaran::count(),
            'jam_belajar'  => JamBelajar::count(),
        ];
    }

    private function buildAdminMetrics(array $counts): array
    {
        return [
            'total_civitas' => $counts['guru'] + $counts['siswa'],
            'rasio_kelas'   => $counts['kelas'] > 0
                ? round($counts['siswa'] / $counts['kelas']) : 0,
            'total_data'    => array_sum($counts),
            'total_kategori' => count($counts),
        ];
    }

    // ─────────────────────────────────────────────────────────────────────
    // Metrics dari counts
    // ─────────────────────────────────────────────────────────────────────
    private function buildMetrics(array $counts): array
    {
        return [
            'total_users_and_students'   => $counts['users'] + $counts['siswa'],
            'total_classes_and_subjects' => $counts['kelas'] + $counts['mapel'],
            'learning_activities'        => $counts['materi'] + $counts['tugas'],
            'class_ratio'                => $counts['kelas'] > 0
                ? round($counts['siswa'] / $counts['kelas']) : 0,
            'assessment_ratio'           => $counts['pengumpulan_tugas'] > 0
                ? round(($counts['penilaian'] / $counts['pengumpulan_tugas']) * 100) : 0,
            'total_data'                 => array_sum($counts),
            'total_categories'           => count($counts),
        ];
    }

    // ─────────────────────────────────────────────────────────────────────
    // Data dashboard pengajar
    // ─────────────────────────────────────────────────────────────────────
    private function buildPengajarData(
        Guru $guru,
        $myGuruMapelIds,
        $myClassIds,
        $myTugasIds,
        $myPengumpulanIds
    ): array {
        $now     = Carbon::now();
        $in7days = Carbon::now()->addDays(7);

        // Summary cards
        $tugasAktif = Tugas::whereIn('id', $myTugasIds)
            ->where('status', 'published')
            ->where(function ($q) use ($now) {
                $q->whereNull('batas_waktu')->orWhere('batas_waktu', '>=', $now);
            })->count();

        $belumDinilai = PengumpulanTugas::whereIn('id', $myPengumpulanIds)
            ->whereDoesntHave('Penilaian')
            ->count();

        // Tugas mendekati deadline (7 hari ke depan)
        $tugasDeadline = Tugas::whereIn('id', $myTugasIds)
            ->where('status', 'published')
            ->whereBetween('batas_waktu', [$now, $in7days])
            ->with(['Mapel', 'GuruMapel', 'Pertemuan.JadwalBelajar.Kelas'])
            ->orderBy('batas_waktu')
            ->get()
            ->map(function ($tugas) use ($now) {
                $tugas->sisa_hari = (int) $now->diffInDays($tugas->batas_waktu, false);
                return $tugas;
            });

        // Kuis mendekati deadline (7 hari ke depan)
        $myKuisIds = Kuis::whereIn('id_guru_mapel', $myGuruMapelIds)->pluck('id');
        $kuisDeadline = Kuis::whereIn('id', $myKuisIds)
            ->where('status', 'published')
            ->whereBetween('batas_selesai', [$now, $in7days])
            ->with(['GuruMapel.Mapel', 'Pertemuan.JadwalBelajar.Kelas'])
            ->orderBy('batas_selesai')
            ->get()
            ->map(function ($kuis) use ($now) {
                $kuis->sisa_hari = (int) $now->diffInDays($kuis->batas_selesai, false);
                return $kuis;
            });

        // Pengumpulan belum dinilai (terlama menunggu)
        $pengumpulanBelumDinilai = PengumpulanTugas::whereIn('id', $myPengumpulanIds)
            ->whereDoesntHave('Penilaian')
            ->with(['Tugas.Mapel', 'Siswa'])
            ->orderBy('created_at')
            ->take(10)
            ->get();

        // Daftar siswa per kelas dengan statistik
        $siswaPerKelas = [];
        foreach ($myClassIds as $kelasId) {
            $kelas = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->find($kelasId);
            if (!$kelas) continue;

            $siswaList = Siswa::where('id_kelas', $kelasId)->orderBy('nama_lengkap')->get();
            
            // Statistik per siswa
            $siswaStats = [];
            foreach ($siswaList as $siswa) {
                // Tugas untuk kelas ini
                $tugasKelas = Tugas::whereIn('id_guru_mapel', $myGuruMapelIds)
                    ->whereHas('Pertemuan.JadwalBelajar', function($q) use ($kelasId) {
                        $q->where('id_kelas', $kelasId);
                    })
                    ->where('status', 'published')
                    ->pluck('id');
                
                $totalTugas = $tugasKelas->count();
                
                // Pengumpulan siswa ini
                $pengumpulan = PengumpulanTugas::whereIn('id_tugas', $tugasKelas)
                    ->where('id_siswa', $siswa->id)
                    ->get();
                
                $sudahKumpul = $pengumpulan->count();
                $belumKumpul = $totalTugas - $sudahKumpul;
                
                // Terlambat
                $terlambat = $pengumpulan->filter(function($p) {
                    return $p->Tugas && $p->Tugas->batas_waktu && 
                           $p->created_at > $p->Tugas->batas_waktu;
                })->count();
                
                // Sudah dinilai
                $sudahDinilai = $pengumpulan->filter(function($p) {
                    return $p->Penilaian()->exists();
                })->count();
                
                // Rata-rata nilai
                $nilaiList = Penilaian::whereHas('PengumpulanTugas', function($q) use ($siswa, $tugasKelas) {
                    $q->where('id_siswa', $siswa->id)
                      ->whereIn('id_tugas', $tugasKelas);
                })->pluck('nilai');
                
                $rataRata = $nilaiList->isNotEmpty() ? round($nilaiList->avg(), 1) : 0;
                
                $siswaStats[] = [
                    'siswa' => $siswa,
                    'total_tugas' => $totalTugas,
                    'sudah_kumpul' => $sudahKumpul,
                    'belum_kumpul' => $belumKumpul,
                    'terlambat' => $terlambat,
                    'sudah_dinilai' => $sudahDinilai,
                    'rata_rata' => $rataRata,
                ];
            }
            
            $siswaPerKelas[] = [
                'kelas' => $kelas,
                'siswa_stats' => $siswaStats,
                'total_siswa' => $siswaList->count(),
            ];
        }

        // Jadwal minggu ini
        $hariIni       = $now->locale('id')->dayName; // nama hari dalam bahasa Indonesia
        $hariEnum      = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $hariCarbonMap = [
            'Senin'   => Carbon::MONDAY,
            'Selasa'  => Carbon::TUESDAY,
            'Rabu'    => Carbon::WEDNESDAY,
            'Kamis'   => Carbon::THURSDAY,
            'Jumat'   => Carbon::FRIDAY,
            'Sabtu'   => Carbon::SATURDAY,
            'Minggu'  => Carbon::SUNDAY,
        ];

        // Nama hari Carbon ke Indonesia
        $carbonHariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $hariIniId = $carbonHariMap[$now->englishDayOfWeek] ?? '';

        $jadwalMingguIni = JadwalBelajar::whereIn('id_guru_mapel', $myGuruMapelIds)
            ->with(['Mapel', 'Kelas', 'JamBelajar'])
            ->get()
            ->groupBy('hari');

        // Susun per hari urut Senin–Minggu
        $jadwalPerHari = [];
        foreach ($hariEnum as $hari) {
            $jadwalPerHari[$hari] = [
                'hari'     => $hari,
                'aktif'    => $hari === $hariIniId,
                'jadwal'   => $jadwalMingguIni->get($hari, collect())->sortBy(fn($j) => $j->JamBelajar?->jam_mulai),
            ];
        }

        return [
            'summary' => [
                'total_kelas'    => $myClassIds->count(),
                'total_siswa'    => Siswa::whereIn('id_kelas', $myClassIds)->count(),
                'tugas_aktif'    => $tugasAktif,
                'belum_dinilai'  => $belumDinilai,
            ],
            'tugas_deadline'          => $tugasDeadline,
            'kuis_deadline'           => $kuisDeadline,
            'pengumpulan_belum_dinilai' => $pengumpulanBelumDinilai,
            'jadwal_per_hari'         => $jadwalPerHari,
            'hari_ini'                => $hariIniId,
            'siswa_per_kelas'         => $siswaPerKelas,
        ];
    }

    // ─────────────────────────────────────────────────────────────────────
    // Data dashboard walikelas
    // ─────────────────────────────────────────────────────────────────────
    private function buildWaliKelasData(Guru $guru): ?array
    {
        $kelas = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian', 'TahunAjaran'])
            ->where('id_wali_kelas', $guru->id)
            ->first();

        if (!$kelas) return null;

        $siswaList = Siswa::where('id_kelas', $kelas->id)->orderBy('nama_lengkap')->get();
        $siswaIds  = $siswaList->pluck('id');

        // Jadwal belajar untuk kelas ini (bridge utama pengganti guru_mapel.id_kelas)
        $jadwalList   = JadwalBelajar::where('id_kelas', $kelas->id)->get();
        $jadwalIds    = $jadwalList->pluck('id');
        $guruMapelIds = $jadwalList->pluck('id_guru_mapel')->filter()->unique();

        // Semua guru_mapel yang mengajar di kelas ini (via jadwal_belajar)
        $guruMapelList = GuruMapel::with(['Mapel', 'Guru'])
            ->whereIn('id', $guruMapelIds)
            ->get();

        // Semua pertemuan, dikelompokkan per guru_mapel
        $pertemuanList = Pertemuan::whereIn('id_jadwal', $jadwalIds)
            ->with(['JadwalBelajar.GuruMapel.Mapel'])
            ->orderBy('nomor_pertemuan')
            ->get();

        // Semua tugas & kuis (semua status, bukan hanya published)
        $tugasList = Tugas::whereIn('id_guru_mapel', $guruMapelIds)
            ->with(['Mapel', 'Guru', 'Pertemuan'])
            ->get();

        $kuisList = Kuis::whereIn('id_guru_mapel', $guruMapelIds)
            ->with(['GuruMapel.Mapel', 'Guru', 'Pertemuan'])
            ->get();

        // Rekap pengumpulan & hasil kuis
        $pengumpulanMap = PengumpulanTugas::whereIn('id_tugas', $tugasList->pluck('id'))
            ->whereIn('id_siswa', $siswaIds)
            ->with('Penilaian')
            ->get()
            ->groupBy(fn($p) => $p->id_tugas . '_' . $p->id_siswa);

        $hasilMap = HasilKuis::whereIn('id_kuis', $kuisList->pluck('id'))
            ->whereIn('id_siswa', $siswaIds)
            ->get()
            ->groupBy(fn($h) => $h->id_kuis . '_' . $h->id_siswa);

        // Rekap absensi per siswa per pertemuan
        $absensiList = Absensi::whereIn('id_pertemuan', $jadwalIds->isEmpty() ? [] :
            Pertemuan::whereIn('id_jadwal', $jadwalIds)->pluck('id'))
            ->whereIn('id_siswa', $siswaIds)
            ->get()
            ->groupBy(fn($a) => $a->id_pertemuan . '_' . $a->id_siswa);

        // Semua pertemuan kelas ini (untuk tabel absensi), urut tanggal
        $pertemuanAbsensi = Pertemuan::whereIn('id_jadwal', $jadwalIds)
            ->orderBy('tanggal')
            ->orderBy('nomor_pertemuan')
            ->get();

        // Kelompokkan per mapel → per pertemuan
        $mapelData = [];
        foreach ($guruMapelList as $gm) {
            $mapelId   = $gm->id_mapel;
            $mapelNama = $gm->Mapel?->nama_mapel ?? 'Mapel';

            if (!isset($mapelData[$mapelId])) {
                $mapelData[$mapelId] = [
                    'id_mapel'    => $mapelId,
                    'id_guru_mapel' => $gm->id,
                    'nama_mapel'  => $mapelNama,
                    'guru_nama'   => $gm->Guru?->nama_lengkap ?? '-',
                    'pertemuan'   => [],
                ];
            }

            // Jadwal untuk guru_mapel ini
            $jadwalGmIds = JadwalBelajar::where('id_guru_mapel', $gm->id)->pluck('id');

            // Pertemuan untuk guru_mapel ini, urut nomor_pertemuan
            $pertemuanGm = $pertemuanList
                ->whereIn('id_jadwal', $jadwalGmIds->toArray())
                ->sortBy('nomor_pertemuan')
                ->values();

            foreach ($pertemuanGm as $pertemuan) {
                $tugasPertemuan = $tugasList
                    ->where('id_guru_mapel', $gm->id)
                    ->where('id_pertemuan', $pertemuan->id)
                    ->values();

                $kuisPertemuan = $kuisList
                    ->where('id_guru_mapel', $gm->id)
                    ->where('id_pertemuan', $pertemuan->id)
                    ->values();

                $mapelData[$mapelId]['pertemuan'][] = [
                    'id'             => $pertemuan->id,
                    'nomor'          => $pertemuan->nomor_pertemuan,
                    'nama_pertemuan' => 'Pertemuan ' . $pertemuan->nomor_pertemuan,
                    'tanggal'        => $pertemuan->tanggal,
                    'tugas'          => $tugasPertemuan,
                    'kuis'           => $kuisPertemuan,
                    'ada_konten'     => $tugasPertemuan->isNotEmpty() || $kuisPertemuan->isNotEmpty(),
                ];
            }

            // Jika guru_mapel ini tidak punya pertemuan sama sekali
            if (empty($mapelData[$mapelId]['pertemuan'])) {
                $mapelData[$mapelId]['pertemuan'][] = [
                    'id'             => null,
                    'nomor'          => null,
                    'nama_pertemuan' => 'Belum ada pertemuan',
                    'tanggal'        => null,
                    'tugas'          => collect(),
                    'kuis'           => collect(),
                    'ada_konten'     => false,
                ];
            }
        }

        return [
            'kelas'          => $kelas,
            'siswa_list'     => $siswaList,
            'mapel_data'     => array_values($mapelData),
            'pengumpulan_by_tugas_siswa' => $pengumpulanMap,
            'hasil_by_kuis_siswa'        => $hasilMap,
            'absensi_map'       => $absensiList,
            'pertemuan_absensi' => $pertemuanAbsensi,
            'summary' => [
                'total_siswa' => $siswaList->count(),
                'total_mapel' => count($mapelData),
                'total_tugas' => $tugasList->count(),
                'total_kuis'  => $kuisList->count(),
            ],
        ];
    }
}
