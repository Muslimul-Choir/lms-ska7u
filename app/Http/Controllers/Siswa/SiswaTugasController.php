<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengumpulanTugas\StorePengumpulanTugasRequest;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiswaTugasController extends Controller
{
    /**
     * Display a listing of assignments categorized by status.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Fetch all published tasks for the student's class
        $tugasList = Tugas::whereHas('guruMapel', function ($query) use ($siswa) {
            $query->where('id_kelas', $siswa->id_kelas);
        })
        ->where('status', 'published')
        ->with(['Mapel', 'Pertemuan'])
        ->latest()
        ->get();

        $belumDikerjakan = [];
        $menungguDinilai = [];
        $selesai = [];

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
                $belumDikerjakan[] = $item;
            } elseif (!$assessment) {
                $menungguDinilai[] = $item;
            } else {
                $selesai[] = $item;
            }
        }

        return view('siswa.tugas.index', compact('siswa', 'belumDikerjakan', 'menungguDinilai', 'selesai'));
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

        $tugas = Tugas::findOrFail($id);

        // Verify class access
        if ($tugas->guruMapel && $tugas->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        // Get submission and grade
        $submission = PengumpulanTugas::where('id_tugas', $tugas->id)
            ->where('id_siswa', $siswa->id)
            ->first();

        $assessment = null;
        if ($submission) {
            $assessment = Penilaian::where('id_pengumpulan_tugas', $submission->id)->first();
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

        // Verify access
        if ($tugas->guruMapel && $tugas->guruMapel->id_kelas !== $siswa->id_kelas) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
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
