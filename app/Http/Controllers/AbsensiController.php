<?php

namespace App\Http\Controllers;

use App\Http\Requests\Absensi\StoreAbsensiRequest;
use App\Http\Requests\Absensi\UpdateAbsensiRequest;
use App\Models\Absensi;
use App\Models\GuruMapel;
use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Services\AttendanceGatewayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceGatewayService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(Request $request): View|JsonResponse
    {
        $user = Auth::user();
        $isGuru = $user->role === 'guru' && $user->guru;
        $guru   = $isGuru ? $user->guru : null;

        //  Cek status walikelas & kelas yang diampu 
        $isWaliKelas   = $guru && in_array($guru->status_pengajar, ['walikelas', 'keduanya']);
        $kelasWali     = $isWaliKelas ? $guru->kelas : null; // hasOne
        $belumAdaKelas = ($guru && $guru->status_pengajar === 'walikelas') && !$kelasWali;

        $search           = $request->get('search');
        $pertemuan_filter = $request->get('id_pertemuan');
        $status_filter    = $request->get('status');

        if ($belumAdaKelas) {
            $absensis   = Absensi::whereRaw('0 = 1')->paginate(10)->withQueryString();
            $pertemuans = collect();
            $siswas     = collect();
            $trashCount = 0;

            return view('absensi.index', compact(
                'absensis',
                'search',
                'pertemuans',
                'siswas',
                'pertemuan_filter',
                'status_filter',
                'trashCount',
                'belumAdaKelas'
            ));
        }

        $absensis = Absensi::whereNotNull('id_pertemuan')
            ->whereNull('tipe_konten')
            ->with(['pertemuan', 'siswa'])
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($pertemuan_filter, fn($q) => $q->where('id_pertemuan', $pertemuan_filter))
            ->when($status_filter,    fn($q) => $q->where('status', $status_filter))
            ->when($isGuru, function ($query) use ($guru, $isWaliKelas, $kelasWali) {
                $query->where(function ($q) use ($guru, $isWaliKelas, $kelasWali) {
                    if ($isWaliKelas && $kelasWali) {
                        $q->whereHas('siswa', fn($s) => $s->where('id_kelas', $kelasWali->id));
                    }
                    if (in_array($guru->status_pengajar, ['pengajar', 'keduanya'])) {
                        $method = ($isWaliKelas && $kelasWali) ? 'orWhereHas' : 'whereHas';
                        $q->$method(
                            'pertemuan.jadwalBelajar.guruMapel',
                            fn($gm) => $gm->where('id_guru', $guru->id)
                        );
                    }
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $trashCount = Absensi::onlyTrashed()
            ->whereNotNull('id_pertemuan')
            ->whereNull('tipe_konten')
            ->count();

        if ($request->ajax()) {
            return response()->json([
                'absensis'   => $absensis->items(),
                'pagination' => $absensis->links()->toHtml(),
                'total'      => $absensis->total(),
            ]);
        }

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery     = Siswa::query();

        if ($isGuru) {
            $myGuruMapelIds = GuruMapel::where('id_guru', $guru->id)->pluck('id');
            $teachesKelasIds = JadwalBelajar::whereIn('id_guru_mapel', $myGuruMapelIds)
                ->pluck('id_kelas')->filter()->unique();

            $pertemuanQuery->where(function ($q) use ($guru, $isWaliKelas, $kelasWali) {
                if ($isWaliKelas && $kelasWali) {
                    $q->whereHas('jadwalBelajar', fn($jb) => $jb->where('id_kelas', $kelasWali->id));
                }
                
                if (in_array($guru->status_pengajar, ['pengajar', 'keduanya'])) {
                    $method = ($isWaliKelas && $kelasWali) ? 'orWhereHas' : 'whereHas';
                    $q->$method('jadwalBelajar.guruMapel', fn($gm) => $gm->where('id_guru', $guru->id));
                }
            });

            $siswaQuery->where(function ($q) use ($guru, $isWaliKelas, $kelasWali, $teachesKelasIds) {
                if ($isWaliKelas && $kelasWali) {
                    $q->where('id_kelas', $kelasWali->id);
                }
                
                if (in_array($guru->status_pengajar, ['pengajar', 'keduanya'])) {
                    if ($isWaliKelas && $kelasWali) {
                        $q->orWhereIn('id_kelas', $teachesKelasIds);
                    } else {
                        $q->whereIn('id_kelas', $teachesKelasIds);
                    }
                }
            });
        }

        $pertemuans = $pertemuanQuery->get();
        $siswas     = $siswaQuery->get();

        return view('absensi.index', compact(
            'absensis',
            'search',
            'pertemuans',
            'siswas',
            'pertemuan_filter',
            'status_filter',
            'trashCount',
            'belumAdaKelas'
        ));
    }

    public function create(): View
    {
        $user   = Auth::user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery     = Siswa::query();

        if ($isGuru) {
            $guru    = $user->guru;
            $isWaliKelas = in_array($guru->status_pengajar, ['walikelas', 'keduanya']);
            $kelasWali   = $isWaliKelas ? $guru->kelas : null;

            $myGuruMapelIds = GuruMapel::where('id_guru', $guru->id)->pluck('id');
            $teachesKelasIds = JadwalBelajar::whereIn('id_guru_mapel', $myGuruMapelIds)
                ->pluck('id_kelas')->filter()->unique();

            $pertemuanQuery->where(function ($q) use ($guru, $isWaliKelas, $kelasWali) {
                if ($isWaliKelas && $kelasWali) {
                    $q->whereHas('jadwalBelajar', fn($jb) => $jb->where('id_kelas', $kelasWali->id));
                }
                
                if (in_array($guru->status_pengajar, ['pengajar', 'keduanya'])) {
                    $method = ($isWaliKelas && $kelasWali) ? 'orWhereHas' : 'whereHas';
                    $q->$method('jadwalBelajar.guruMapel', fn($gm) => $gm->where('id_guru', $guru->id));
                }
            });

            $siswaQuery->where(function ($q) use ($guru, $isWaliKelas, $kelasWali, $teachesKelasIds) {
                if ($isWaliKelas && $kelasWali) {
                    $q->where('id_kelas', $kelasWali->id);
                }
                
                if (in_array($guru->status_pengajar, ['pengajar', 'keduanya'])) {
                    if ($isWaliKelas && $kelasWali) {
                        $q->orWhereIn('id_kelas', $teachesKelasIds);
                    } else {
                        $q->whereIn('id_kelas', $teachesKelasIds);
                    }
                }
            });
        }

        return view('absensi.create', [
            'pertemuans' => $pertemuanQuery->get(),
            'siswas'     => $siswaQuery->get(),
        ]);
    }

    public function store(StoreAbsensiRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Fetch pertemuan to get deadline
        $pertemuan = Pertemuan::findOrFail($validated['id_pertemuan']);
        $batasWaktu = $this->attendanceService->getPertemuanAttendanceDeadline($pertemuan);

        // Mark attendance using service
        $this->attendanceService->markAttendanceForPertemuan(
            $validated['id_siswa'],
            $validated['id_pertemuan'],
            $validated['status'],
            $validated['keterangan'] ?? null,
            $batasWaktu
        );

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function show(Absensi $absensi): View
    {
        $absensi->load(['pertemuan', 'siswa']);

        return view('absensi.show', compact('absensi'));
    }

    public function edit(Absensi $absensi): View
    {
        $user   = Auth::user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery     = Siswa::query();

        if ($isGuru) {
            $guru    = $user->guru;
            $isWaliKelas = in_array($guru->status_pengajar, ['walikelas', 'keduanya']);
            $kelasWali   = $isWaliKelas ? $guru->kelas : null;

            $myGuruMapelIds = GuruMapel::where('id_guru', $guru->id)->pluck('id');
            $teachesKelasIds = JadwalBelajar::whereIn('id_guru_mapel', $myGuruMapelIds)
                ->pluck('id_kelas')->filter()->unique();

            $pertemuanQuery->where(function ($q) use ($guru, $isWaliKelas, $kelasWali) {
                if ($isWaliKelas && $kelasWali) {
                    $q->whereHas('jadwalBelajar', fn($jb) => $jb->where('id_kelas', $kelasWali->id));
                }
                
                if (in_array($guru->status_pengajar, ['pengajar', 'keduanya'])) {
                    $method = ($isWaliKelas && $kelasWali) ? 'orWhereHas' : 'whereHas';
                    $q->$method('jadwalBelajar.guruMapel', fn($gm) => $gm->where('id_guru', $guru->id));
                }
            });

            $siswaQuery->where(function ($q) use ($guru, $isWaliKelas, $kelasWali, $teachesKelasIds) {
                if ($isWaliKelas && $kelasWali) {
                    $q->where('id_kelas', $kelasWali->id);
                }
                
                if (in_array($guru->status_pengajar, ['pengajar', 'keduanya'])) {
                    if ($isWaliKelas && $kelasWali) {
                        $q->orWhereIn('id_kelas', $teachesKelasIds);
                    } else {
                        $q->whereIn('id_kelas', $teachesKelasIds);
                    }
                }
            });
        }

        return view('absensi.edit', [
            'absensi'    => $absensi,
            'pertemuans' => $pertemuanQuery->get(),
            'siswas'     => $siswaQuery->get(),
        ]);
    }

    public function update(UpdateAbsensiRequest $request, Absensi $absensi): RedirectResponse
    {
        $validated = $request->validated();

        // If status is updated or pertemuan is updated, recalculate lateness status
        $status = $validated['status'] ?? $absensi->status;
        $idPertemuan = $validated['id_pertemuan'] ?? $absensi->id_pertemuan;

        if ($status === 'hadir') {
            $pertemuan = Pertemuan::findOrFail($idPertemuan);
            $batasWaktu = $this->attendanceService->getPertemuanAttendanceDeadline($pertemuan);
            
            $waktuAbsen = $absensi->waktu_absen ?? now();
            if ($batasWaktu) {
                $validated['status_keterlambatan'] = $this->attendanceService->calculateLatenessStatus($batasWaktu, $waktuAbsen);
                $validated['batas_waktu_absen'] = $batasWaktu;
            } else {
                $validated['status_keterlambatan'] = 'tepat_waktu';
                $validated['batas_waktu_absen'] = null;
            }
        } else {
            $validated['status_keterlambatan'] = null;
            $validated['batas_waktu_absen'] = null;
        }

        // Set waktu_absen if not already set
        if (!$absensi->waktu_absen) {
            $validated['waktu_absen'] = now();
        }

        $absensi->update($validated);

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi): RedirectResponse
    {
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dipindahkan ke arsip.');
    }

    // ─── Trash ────────────────────────────────────────────────────────────────

    public function trash(Request $request): View
    {
        $search           = $request->get('search');
        $pertemuan_filter = $request->get('id_pertemuan');
        $status_filter    = $request->get('status');

        $absensis = Absensi::onlyTrashed()
            ->whereNotNull('id_pertemuan')
            ->whereNull('tipe_konten')
            ->with(['pertemuan', 'siswa'])
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($pertemuan_filter, fn($q) => $q->where('id_pertemuan', $pertemuan_filter))
            ->when($status_filter,    fn($q) => $q->where('status', $status_filter))
            ->latest('deleted_at')
            ->paginate(10)
            ->withQueryString();

        // Daftar pertemuan untuk dropdown filter (semua, tidak dibatasi per guru)
        $pertemuans = Pertemuan::orderBy('nomor_pertemuan')->get();

        return view('absensi.trash', compact(
            'absensis',
            'search',
            'pertemuans',
            'pertemuan_filter',
            'status_filter'
        ));
    }

    public function restore(string $id): RedirectResponse
    {
        Absensi::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('absensi.trash')->with('success', 'Absensi berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        Absensi::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('absensi.trash')->with('success', 'Absensi berhasil dihapus permanen.');
    }

    public function restoreAll(): RedirectResponse
    {
        Absensi::onlyTrashed()->restore();

        return redirect()->route('absensi.trash')->with('success', 'Semua data absensi berhasil dipulihkan.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        Absensi::onlyTrashed()->forceDelete();

        return redirect()->route('absensi.trash')->with('success', 'Semua data absensi berhasil dihapus permanen.');
    }
}
