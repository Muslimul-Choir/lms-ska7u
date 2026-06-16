<?php
namespace App\Http\Controllers;

use App\Http\Requests\Penilaian\StoreQuickPenilaianRequest;
use App\Models\Penilaian;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        // Get published tugas that need grading
        $query = \App\Models\Tugas::with(['GuruMapel.Mapel', 'Guru', 'Pertemuan'])
            ->where('status', 'published');
        
        if ($isGuru) {
            $guru = $user->guru;
            $query->where('id_guru', $guru->id);
        }

        // Search by tugas title
        if (request('search')) {
            $search = request('search');
            $query->where('judul', 'like', "%{$search}%");
        }

        // Get tugas with submission and grading statistics
        $tugasList = $query->latest()->paginate(15);
        
        // Add statistics for each tugas
        foreach ($tugasList as $tugas) {
            // Get kelas IDs from JadwalBelajar
            $kelasIds = $tugas->GuruMapel->JadwalBelajar()->pluck('id_kelas')->unique();
            
            // Count total students
            $totalSiswa = \App\Models\Siswa::whereIn('id_kelas', $kelasIds)->count();
            
            // Count submissions
            $totalSubmissions = \App\Models\PengumpulanTugas::where('id_tugas', $tugas->id)->count();
            
            // Count graded submissions
            $totalGraded = \App\Models\PengumpulanTugas::where('id_tugas', $tugas->id)
                ->whereHas('penilaian')
                ->count();
            
            $tugas->stats = (object) [
                'total_siswa' => $totalSiswa,
                'total_submissions' => $totalSubmissions,
                'total_graded' => $totalGraded,
                'pending_grade' => $totalSubmissions - $totalGraded,
            ];
        }

        // Count trashed tugas that acts as archived penilaian tasks
        $trashQuery = \App\Models\Tugas::onlyTrashed();
        if ($isGuru) {
            $trashQuery->where('id_guru', $user->guru->id);
        }
        $trashCount = $trashQuery->count();

        return view('penilaian.index', compact('tugasList', 'trashCount'));
    }

    /**
     * Quick store/update penilaian via AJAX from rekap modal.
     * Returns JSON response for dynamic UI updates.
     */
    public function quickStore(StoreQuickPenilaianRequest $request)
    {
        $user = Auth::user();

        try {
            // Get submission and related task
            $pengumpulan = PengumpulanTugas::with('Tugas')->findOrFail($request->id_pengumpulan_tugas);
            $tugas = $pengumpulan->Tugas;

            // Authorization check (Req 3.4, 10.1)
            $isAuthorized = false;
            if (in_array($user->role, ['super_admin', 'admin'])) {
                $isAuthorized = true;
            } elseif ($user->role === 'guru' && $user->Guru) {
                $isAuthorized = $tugas->id_guru === $user->Guru->id;
            }

            if (!$isAuthorized) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menilai tugas ini.',
                ], 403);
            }

            // Guard: Check if submission exists (Req 4.5)
            if (!$pengumpulan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa belum mengumpulkan tugas.',
                ], 422);
            }

            DB::beginTransaction();

            // Determine id_guru: only set if user is actually a guru
            $idGuru = null;
            if ($user->role === 'guru' && $user->Guru) {
                $idGuru = $user->Guru->id;
            }

            // Get nilai_maksimal from tugas for snapshot
            $nilaiMaksimal = $tugas->nilai_maksimal ?? 100.00;

            // Create or update penilaian (Req 3.6, 3.7, 3.8)
            $penilaian = Penilaian::updateOrCreate(
                ['id_pengumpulan_tugas' => $pengumpulan->id],
                [
                    'id_guru' => $idGuru,
                    'nilai' => $request->nilai,
                    'nilai_maksimal_snapshot' => $nilaiMaksimal,
                    'catatan_guru' => $request->catatan_guru,
                ]
            );

            DB::commit();

            // Return success response with data for UI update
            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disimpan.',
                'nilai' => $penilaian->nilai,
                'catatan_guru' => $penilaian->catatan_guru,
                'status' => 'Sudah Dinilai',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Penilaian quick-store error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan penilaian.',
            ], 500);
        }
    }

    public function trash()
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        // Get soft-deleted tugas
        $query = \App\Models\Tugas::onlyTrashed()
            ->with(['GuruMapel.Mapel', 'Guru', 'Pertemuan']);
        
        if ($isGuru) {
            $query->where('id_guru', $user->guru->id);
        }

        if (request('search')) {
            $search = request('search');
            $query->where('judul', 'like', "%{$search}%");
        }

        $tugasList = $query->latest('deleted_at')->paginate(15)->withQueryString();
        
        // Add statistics for each tugas
        foreach ($tugasList as $tugas) {
            // Get kelas IDs from JadwalBelajar
            $kelasIds = $tugas->GuruMapel->JadwalBelajar()->pluck('id_kelas')->unique();
            
            // Count total students
            $totalSiswa = \App\Models\Siswa::whereIn('id_kelas', $kelasIds)->count();
            
            // Count submissions
            $totalSubmissions = \App\Models\PengumpulanTugas::where('id_tugas', $tugas->id)->count();
            
            // Count graded submissions
            $totalGraded = \App\Models\PengumpulanTugas::where('id_tugas', $tugas->id)
                ->whereHas('penilaian')
                ->count();
            
            $tugas->stats = (object) [
                'total_siswa' => $totalSiswa,
                'total_submissions' => $totalSubmissions,
                'total_graded' => $totalGraded,
                'pending_grade' => $totalSubmissions - $totalGraded,
            ];
        }

        return view('penilaian.trash', compact('tugasList', 'isGuru'));
    }
}