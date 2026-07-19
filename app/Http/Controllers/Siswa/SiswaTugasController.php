<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengumpulanTugas\StorePengumpulanTugasRequest;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Kuis;
use App\Models\HasilKuis;
use App\Services\AttendanceGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiswaTugasController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceGatewayService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    /**
     * Display a listing of assignments categorized by status.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get current status tab (default: 'belum')
        $currentTab = $request->get('status', 'belum');

        // Base query for all tugas
        $baseQuery = Tugas::whereHas('guruMapel.JadwalBelajar', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })
        ->whereHas('Mapel', function ($query) use ($siswa) {
            $query->forAgama($siswa->agama);
        })
        ->whereHas('Pertemuan', function ($query) {
            $query->where(function($q) {
                $q->whereNull('tanggal')
                  ->orWhere('tanggal', '<=', now()->toDateString());
            });
        })
        ->where('status', 'published')
        ->where(function($query) {
            $query->whereNull('waktu_rilis')
                  ->orWhere('waktu_rilis', '<=', now());
        })
        ->with(['Mapel', 'Pertemuan']);

        // Get IDs for status filtering
        $submittedIds = PengumpulanTugas::where('id_siswa', $siswa->id)->pluck('id_tugas');
        $assessedIds = PengumpulanTugas::where('id_siswa', $siswa->id)
            ->whereHas('Penilaian')
            ->pluck('id_tugas');

        // Filter by status and paginate
        $tugasList = match($currentTab) {
            'pending' => (clone $baseQuery)
                ->whereIn('id', $submittedIds)
                ->whereNotIn('id', $assessedIds)
                ->latest()
                ->paginate(10)
                ->appends(['status' => 'pending']),
            'selesai' => (clone $baseQuery)
                ->whereIn('id', $assessedIds)
                ->latest()
                ->paginate(10)
                ->appends(['status' => 'selesai']),
            default => (clone $baseQuery)
                ->whereNotIn('id', $submittedIds)
                ->latest()
                ->paginate(10)
                ->appends(['status' => 'belum'])
        };

        // Build collections for display
        $belumDikerjakan = collect();
        $menungguDinilai = collect();
        $selesai = collect();

        foreach ($tugasList as $t) {
            $submission = PengumpulanTugas::where('id_tugas', $t->id)
                ->where('id_siswa', $siswa->id)
                ->first();
            
            $assessment = null;
            if ($submission) {
                $assessment = Penilaian::where('id_pengumpulan_tugas', $submission->id)->first();
            }

            $item = [
                'task' => $t,
                'submission' => $submission,
                'assessment' => $assessment
            ];

            if (!$submission) {
                $belumDikerjakan->push($item);
            } elseif (!$assessment) {
                $menungguDinilai->push($item);
            } else {
                $selesai->push($item);
            }
        }

        // Get total counts for each status (not paginated)
        $totalBelumCount = (clone $baseQuery)
            ->whereNotIn('id', $submittedIds)
            ->count();
            
        $totalPendingCount = (clone $baseQuery)
            ->whereIn('id', $submittedIds)
            ->whereNotIn('id', $assessedIds)
            ->count();
            
        $totalSelesaiCount = (clone $baseQuery)
            ->whereIn('id', $assessedIds)
            ->count();

        // Badge counts for nav tabs
        $tugasBelumCount = $totalBelumCount;
        
        $kuisTersediaCount = Kuis::whereHas('guruMapel.JadwalBelajar', fn($q) => $q->where('id_kelas', $siswa->id_kelas))
            ->whereHas('GuruMapel.Mapel', fn($q) => $q->forAgama($siswa->agama))
            ->where('status', 'published')
            ->where('batas_mulai', '<=', now())
            ->where('batas_selesai', '>=', now())
            ->whereNotIn('id', HasilKuis::where('id_siswa', $siswa->id)->pluck('id_kuis'))
            ->count();

        return view('siswa.tugas.index', compact('siswa', 'belumDikerjakan', 'menungguDinilai', 'selesai', 'tugasBelumCount', 'kuisTersediaCount', 'tugasList', 'currentTab', 'totalBelumCount', 'totalPendingCount', 'totalSelesaiCount'));
    }

    /**
     * Display the specified assignment.
     */
    public function show($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $tugas = Tugas::with(['Pertemuan', 'guruMapel'])->findOrFail($id);

        // Verify class access through JadwalBelajar
        if ($tugas->guruMapel) {
            $hasAccess = $tugas->guruMapel->JadwalBelajar()
                ->where('id_kelas', $siswa->id_kelas)
                ->exists();
            
            if (!$hasAccess) {
                abort(403, 'Anda tidak memiliki akses ke tugas ini.');
            }
        }

        // Get submission and grade
        $submission = PengumpulanTugas::where('id_tugas', $tugas->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        $assessment = null;
        if ($submission) {
            $assessment = Penilaian::where('id_pengumpulan_tugas', $submission->id)->first();
        }

        // Check pertemuan-level attendance (shared with materi & kuis of same pertemuan)
        $pertemuan = $tugas->Pertemuan;
        if ($pertemuan) {
            $alreadyAbsen = $this->attendanceService->hasMarkedAttendanceForPertemuan($siswa->id, $pertemuan->id);

            if (!$alreadyAbsen) {
                $batasAbsensi = $this->attendanceService->getPertemuanAttendanceDeadline($pertemuan);
                $deadlinePassed = $batasAbsensi && now()->gt($batasAbsensi);

                if (!$deadlinePassed) {
                    $params = http_build_query([
                        'tipe_konten' => 'tugas',
                        'id_konten'   => $tugas->id,
                        'redirect_to' => route('siswa.tugas.show', $tugas->id),
                    ]);
                    return redirect(route('siswa.attendance.modal', $pertemuan->id) . '?' . $params);
                }
            }
        }

        return view('siswa.tugas.show', compact('siswa', 'tugas', 'submission', 'assessment'));
    }

    /**
     * Store a new submission or update an existing one.
     */
    public function store(StorePengumpulanTugasRequest $request, $id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login');
        }

        $tugas = Tugas::findOrFail($id);

        // Verify access through JadwalBelajar
        if ($tugas->guruMapel) {
            $hasAccess = $tugas->guruMapel->JadwalBelajar()
                ->where('id_kelas', $siswa->id_kelas)
                ->exists();
            
            if (!$hasAccess) {
                abort(403, 'Anda tidak memiliki akses ke tugas ini.');
            }
        }

        // Check if deadline passed and late submissions are NOT allowed
        $overdue = $tugas->batas_waktu && \Carbon\Carbon::parse($tugas->batas_waktu)->isPast();
        if ($overdue && !$tugas->allow_late) {
            return back()->with('error', 'Batas waktu pengumpulan telah berakhir dan pengumpulan terlambat dinonaktifkan.');
        }

        // Find existing submission
        $submission = PengumpulanTugas::where('id_tugas', $tugas->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        // Guard: Check if already graded (Req 1.8)
        if ($submission) {
            $graded = Penilaian::where('id_pengumpulan_tugas', $submission->id)->exists();
            if ($graded) {
                return back()->with('error', 'Tugas sudah dinilai dan tidak dapat diubah.');
            }
        }

        try {
            DB::beginTransaction();

            $validated = $request->validated();

            // Handle file upload with new path structure: submissions/{id_tugas}/{id_siswa}/{hashName}
            if ($request->hasFile('file_upload')) {
                // Delete old file if exists (Req 1.7)
                if ($submission && $submission->file_url && !str_starts_with($submission->file_url, 'http')) {
                    Storage::disk('public')->delete($submission->file_url);
                }

                // Store with new path structure (Req 1.5)
                $file = $request->file('file_upload');
                $path = $file->storeAs(
                    "submissions/{$tugas->id}/{$siswa->id}",
                    $file->hashName(),
                    'public'
                );
                $validated['file_url'] = $path;
                unset($validated['file_upload']);
            }

            if ($submission) {
                $submission->update($validated);
                $msg = 'Tugas berhasil diperbarui.';
            } else {
                $validated['id_tugas'] = $tugas->id;
                $validated['id_siswa'] = $siswa->id;
                PengumpulanTugas::create($validated);
                $msg = 'Tugas berhasil dikumpulkan.';
            }

            DB::commit();

            return redirect()->route('siswa.tugas.index')->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan tugas. Silakan coba lagi.');
        }
    }
}
