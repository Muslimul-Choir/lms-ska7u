<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Pertemuan;
use App\Models\Materi;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Kuis;
use App\Models\PengumpulanTugas;
use App\Models\HasilKuis;
use App\Services\AttendanceGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaMateriController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceGatewayService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display a listing of subjects for the student's class.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get subjects taught in the student's class through JadwalBelajar
        // Filter juga berdasarkan agama siswa untuk mapel agama
        $mapels = Mapel::whereHas('GuruMapel.JadwalBelajar', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })
        ->forAgama($siswa->agama)
        ->get();

        // Count pending tugas (published, released, not expired, not yet submitted)
        // FILTER BARU: Hanya hitung tugas dari pertemuan yang tanggalnya sudah lewat atau hari ini
        $tugasBelumCount = Tugas::whereHas('guruMapel.JadwalBelajar', function ($q) use ($siswa) {
                $q->where('id_kelas', $siswa->id_kelas);
            })
            ->whereHas('Mapel', fn($q) => $q->forAgama($siswa->agama))
            ->whereHas('Pertemuan', function ($q) {
                $q->where(function($query) {
                    $query->whereNull('tanggal')
                          ->orWhere('tanggal', '<=', now()->toDateString());
                });
            })
            ->where('status', 'published')
            ->where(function($q) {
                $q->whereNull('waktu_rilis')
                  ->orWhere('waktu_rilis', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('batas_waktu')
                  ->orWhere('batas_waktu', '>', now());
            })
            ->whereNotIn('id', PengumpulanTugas::where('id_siswa', $siswa->id)->pluck('id_tugas'))
            ->count();

        // Count available kuis (published, within time range, not yet taken)
        // FILTER BARU: Hanya hitung kuis dari pertemuan yang tanggalnya sudah lewat atau hari ini
        $kuisTersediaCount = Kuis::whereHas('guruMapel.JadwalBelajar', function ($q) use ($siswa) {
                $q->where('id_kelas', $siswa->id_kelas);
            })
            ->whereHas('GuruMapel.Mapel', fn($q) => $q->forAgama($siswa->agama))
            ->whereHas('Pertemuan', function ($q) {
                $q->where(function($query) {
                    $query->whereNull('tanggal')
                          ->orWhere('tanggal', '<=', now()->toDateString());
                });
            })
            ->where('status', 'published')
            ->where('batas_mulai', '<=', now())
            ->where('batas_selesai', '>=', now())
            ->whereNotIn('id', HasilKuis::where('id_siswa', $siswa->id)->pluck('id_kuis'))
            ->count();

        return view('siswa.materi.index', compact('siswa', 'mapels', 'tugasBelumCount', 'kuisTersediaCount'));
    }

    /**
     * Display meetings and content under a specific subject.
     */
    public function showMapel($id_mapel)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $mapel = Mapel::findOrFail($id_mapel);

        // Fetch meetings for this subject in the student's class
        $pertemuans = Pertemuan::whereHas('JadwalBelajar', function ($query) use ($siswa, $id_mapel) {
            $query->where('id_kelas', $siswa->id_kelas)
                ->where(function ($sub) use ($id_mapel) {
                    $sub->where('id_mapel', $id_mapel)
                        ->orWhereHas('GuruMapel', function ($gm) use ($id_mapel) {
                            $gm->where('id_mapel', $id_mapel);
                        });
                });
        })
        // FILTER: Hanya tampilkan pertemuan yang tanggalnya sudah lewat atau hari ini
        ->where(function($query) {
            $query->whereNull('tanggal') // Jika tanggal tidak diset, tampilkan (backward compatibility)
                  ->orWhere('tanggal', '<=', now()->toDateString()); // Atau tanggal pertemuan sudah lewat/hari ini
        })
        ->with([
            'materis' => function ($q) {
                $q->where('status', 'published')
                  ->orderBy('waktu_rilis', 'asc');
            },
            'tugas' => function ($q) {
                $q->where('status', 'published')
                  ->where(function($query) {
                      $query->whereNull('waktu_rilis')
                            ->orWhere('waktu_rilis', '<=', now());
                  })
                  ->orderBy('waktu_rilis', 'asc');
            },
            'kuis' => function ($q) use ($siswa) {
                $q->where('status', 'published')
                  ->where(function($query) {
                      $query->whereNull('waktu_rilis')
                            ->orWhere('waktu_rilis', '<=', now());
                  })
                  ->with(['HasilKuis' => function ($hq) use ($siswa) {
                      $hq->where('id_siswa', $siswa->id);
                  }])
                  ->orderBy('waktu_rilis', 'asc');
            },
            'absensis' => function ($q) use ($siswa) {
                $q->where('id_siswa', $siswa->id)->whereNull('tipe_konten');
            }
        ])
        ->orderBy('nomor_pertemuan')
        ->paginate(5)
        ->withQueryString();

        return view('siswa.materi.show_mapel', compact('siswa', 'mapel', 'pertemuans'));
    }

    /**
     * Show a specific material content.
     * Checks pertemuan-level attendance first; if not done, redirects to attendance modal.
     */
    public function showMateri($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $materi = Materi::with(['Pertemuan', 'guruMapel'])->findOrFail($id);

        // Validate access through JadwalBelajar
        if ($materi->guruMapel) {
            $hasAccess = $materi->guruMapel->JadwalBelajar()
                ->where('id_kelas', $siswa->id_kelas)
                ->exists();

            if (!$hasAccess) {
                abort(403, 'Anda tidak memiliki akses ke materi ini.');
            }
        }

        // Check pertemuan-level attendance (shared with tugas & kuis of same pertemuan)
        $pertemuan = $materi->Pertemuan;
        if ($pertemuan) {
            $alreadyAbsen = $this->attendanceService->hasMarkedAttendanceForPertemuan($siswa->id, $pertemuan->id);

            if (!$alreadyAbsen) {
                // Get attendance deadline
                $batasAbsensi = $this->attendanceService->getPertemuanAttendanceDeadline($pertemuan);

                // Only gate if deadline hasn't passed (or no deadline — always require)
                $deadlinePassed = $batasAbsensi && now()->gt($batasAbsensi);

                if (!$deadlinePassed) {
                    $params = http_build_query([
                        'tipe_konten' => 'materi',
                        'id_konten'   => $materi->id,
                        'redirect_to' => route('siswa.materi.show', $materi->id),
                    ]);
                    return redirect(route('siswa.attendance.modal', $pertemuan->id) . '?' . $params);
                }
            }
        }

        return view('siswa.materi.show', compact('siswa', 'materi'));
    }
}
