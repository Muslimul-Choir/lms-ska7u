<?php
namespace App\Http\Controllers;

use App\Models\PengumpulanTugas;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumpulanTugasController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $query = PengumpulanTugas::with(['tugas.GuruMapel.Mapel', 'siswa']);
        
        if ($isGuru) {
            $guru = $user->guru;
            $query->whereHas('tugas', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('siswa', function($sq) use ($search) {
                    $sq->where('nama_lengkap', 'like', "%{$search}%")
                       ->orWhere('nis', 'like', "%{$search}%");
                })
                ->orWhereHas('tugas', function($tq) use ($search) {
                    $tq->where('judul', 'like', "%{$search}%");
                });
            });
        }

        // Filter by status
        if (request('status')) {
            if (request('status') === 'dinilai') {
                $query->whereHas('penilaian');
            } elseif (request('status') === 'belum_dinilai') {
                $query->whereDoesntHave('penilaian');
            }
        }

        $pengumpulanTugas = $query->latest()->paginate(15);
        return view('pengumpulan_tugas.index', compact('pengumpulanTugas'));
    }

    /**
     * Display recap of all students' submissions for a specific task.
     * Shows: total students, submitted count, graded count, and detailed list.
     */
    public function rekap(Tugas $tugas)
    {
        $user = Auth::user();

        // Get source page for back button
        $source = request('source', 'tugas'); // default to 'tugas' if not specified

        // Get all students in the task's class through JadwalBelajar
        // GuruMapel tidak punya id_kelas lagi, ambil dari JadwalBelajar
        $kelasIds = $tugas->GuruMapel->JadwalBelajar()->pluck('id_kelas')->unique();
        
        $siswaList = Siswa::whereIn('id_kelas', $kelasIds)
            ->with('User')
            ->orderBy('nama_lengkap')
            ->get();

        // Build recap data
        $rekapData = [];
        $totalSiswa = $siswaList->count();
        $sudahMengumpulkan = 0;
        $sudahDinilai = 0;

        foreach ($siswaList as $siswa) {
            $submission = PengumpulanTugas::where('id_tugas', $tugas->id)
                ->where('id_siswa', $siswa->id)
                ->first();

            $penilaian = null;
            if ($submission) {
                $sudahMengumpulkan++;
                $penilaian = Penilaian::where('id_pengumpulan_tugas', $submission->id)->first();
                if ($penilaian) {
                    $sudahDinilai++;
                }
            }

            $rekapData[] = [
                'siswa' => $siswa,
                'submission' => $submission,
                'penilaian' => $penilaian,
            ];
        }

        $statistik = [
            'total' => $totalSiswa,
            'sudah_mengumpulkan' => $sudahMengumpulkan,
            'sudah_dinilai' => $sudahDinilai,
        ];

        // Check if current user is the task creator
        $isCreator = false;
        if ($user->role === 'guru' && $user->Guru) {
            $isCreator = $tugas->id_guru === $user->Guru->id;
        } elseif (in_array($user->role, ['super_admin', 'admin'])) {
            $isCreator = true;
        }

        return view('pengumpulan_tugas.rekap', compact('tugas', 'rekapData', 'statistik', 'isCreator', 'source'));
    }

    /**
     * Export rekap pengumpulan tugas to PDF
     */
    public function exportPdf(Tugas $tugas)
    {
        $user = Auth::user();

        // Get all students in the task's class through JadwalBelajar
        // GuruMapel tidak punya id_kelas lagi, ambil dari JadwalBelajar
        $kelasIds = $tugas->GuruMapel->JadwalBelajar()->pluck('id_kelas')->unique();
        
        $siswaList = Siswa::whereIn('id_kelas', $kelasIds)
            ->with('User')
            ->orderBy('nama_lengkap')
            ->get();

        // Build recap data
        $rekapData = [];
        $totalSiswa = $siswaList->count();
        $sudahMengumpulkan = 0;
        $sudahDinilai = 0;

        foreach ($siswaList as $siswa) {
            $submission = PengumpulanTugas::where('id_tugas', $tugas->id)
                ->where('id_siswa', $siswa->id)
                ->first();

            $penilaian = null;
            if ($submission) {
                $sudahMengumpulkan++;
                $penilaian = Penilaian::where('id_pengumpulan_tugas', $submission->id)->first();
                if ($penilaian) {
                    $sudahDinilai++;
                }
            }

            $rekapData[] = [
                'siswa' => $siswa,
                'submission' => $submission,
                'penilaian' => $penilaian,
            ];
        }

        $statistik = [
            'total' => $totalSiswa,
            'sudah_mengumpulkan' => $sudahMengumpulkan,
            'sudah_dinilai' => $sudahDinilai,
        ];

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pengumpulan_tugas.pdf', compact('tugas', 'rekapData', 'statistik'));
        
        return $pdf->download('rekap-pengumpulan-' . \Str::slug($tugas->judul) . '.pdf');
    }

    /**
     * Download a student's submission file.
     * Guards: 403 if not task creator/admin, 404 if file doesn't exist.
     */
    public function download(PengumpulanTugas $pengumpulanTugas)
    {
        $user = Auth::user();
        $tugas = $pengumpulanTugas->Tugas;

        // Authorization check (Req 2.4)
        $isAuthorized = false;
        if (in_array($user->role, ['super_admin', 'admin'])) {
            $isAuthorized = true;
        } elseif ($user->role === 'guru' && $user->Guru) {
            $isAuthorized = $tugas->id_guru === $user->Guru->id;
        }

        if (!$isAuthorized) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        // Check if file exists (Req 2.5)
        $filePath = $pengumpulanTugas->file_url;

        // Skip download for URL links
        if (str_starts_with($filePath, 'http')) {
            return redirect($filePath);
        }

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Download file
        return Storage::disk('public')->download($filePath);
    }
}