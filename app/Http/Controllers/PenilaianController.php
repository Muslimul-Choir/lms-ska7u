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

        $query = Penilaian::with(['pengumpulanTugas.siswa', 'pengumpulanTugas.tugas', 'guru']);
        if ($isGuru) {
            $guru = $user->guru;
            $query->whereHas('pengumpulanTugas.tugas', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }

        $penilaian = $query->latest()->paginate(15);
        return view('penilaian.index', compact('penilaian'));
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
}