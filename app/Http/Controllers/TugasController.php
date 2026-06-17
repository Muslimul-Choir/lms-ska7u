<?php
namespace App\Http\Controllers;

use App\Events\ContentUpdated;
use App\Models\Tugas;
use App\Models\Pertemuan;
use App\Models\Guru;
use App\Services\ContentReleaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    protected $contentReleaseService;

    public function __construct(ContentReleaseService $contentReleaseService)
    {
        $this->contentReleaseService = $contentReleaseService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $q = $request->input('q');
        $filter_status = $request->input('filter_status', 'semua');
        $id_kelas = $request->input('id_kelas');

        // Query pertemuan yang memiliki tugas
        $pertemuanQuery = \App\Models\Pertemuan::whereHas('tugas');

        if ($isGuru) {
            $guru = $user->guru;
            $pertemuanQuery->whereHas('jadwalBelajar.guruMapel', function($query) use ($guru) {
                $query->where('id_guru', $guru->id);
            });
        }

        // Filter by kelas
        if ($id_kelas) {
            $pertemuanQuery->whereHas('jadwalBelajar', function($query) use ($id_kelas) {
                $query->where('id_kelas', $id_kelas);
            });
        }

        // Search in pertemuan or tugas
        if ($q) {
            $pertemuanQuery->where(function($query) use ($q) {
                $query->where('nomor_pertemuan', 'like', "%$q%")
                      ->orWhereHas('tugas', function($subQuery) use ($q) {
                          $subQuery->where('judul', 'like', "%$q%")
                                   ->orWhere('deskripsi', 'like', "%$q%");
                      });
            });
        }

        $pertemuans = $pertemuanQuery
            ->with(['jadwalBelajar.GuruMapel.Mapel', 'jadwalBelajar.GuruMapel.Guru', 'jadwalBelajar.Mapel', 'jadwalBelajar.Kelas'])
            ->orderBy('nomor_pertemuan')
            ->paginate(5)
            ->withQueryString();

        $pertemuanIds = $pertemuans->pluck('id');
        
        // Get tugas for these pertemuans
        $tugasQuery = Tugas::with(['Pertemuan', 'Guru', 'Mapel', 'GuruMapel.Guru', 'GuruMapel.Mapel'])
            ->whereIn('id_pertemuan', $pertemuanIds);

        if ($isGuru) {
            $tugasQuery->where('id_guru', $user->guru->id);
        }

        if ($q) {
            $tugasQuery->where(function($query) use ($q) {
                $query->where('judul', 'like', "%$q%")
                      ->orWhere('deskripsi', 'like', "%$q%");
            });
        }
        
        if ($filter_status !== 'semua') {
            $tugasQuery->where('status', $filter_status);
        }

        $tugas = $tugasQuery->latest()->get();
        
        // Get kelas list for filter dropdown
        $kelasQuery = \App\Models\Kelas::with(['tingkatan', 'jurusan', 'bagian']);
        if ($isGuru) {
            $guru = $user->guru;
            $kelasQuery->whereHas('jadwalBelajars.guruMapel', function($query) use ($guru) {
                $query->where('id_guru', $guru->id);
            });
        }
        $kelasList = $kelasQuery->get();
        
        // Get all pertemuan for dropdown (filtered by guru)
        $allPertemuanQuery = \App\Models\Pertemuan::with(['JadwalBelajar.GuruMapel.Mapel', 'JadwalBelajar.Mapel', 'JadwalBelajar.Kelas', 'JadwalBelajar.JamBelajar']);
        if ($isGuru) {
            $guru = $user->guru;
            $allPertemuanQuery->whereHas('jadwalBelajar.guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }
        $allPertemuan = $allPertemuanQuery->orderBy('nomor_pertemuan')->get();
        
        $gurusQuery = \App\Models\Guru::with('user');
        if ($isGuru) {
            $gurusQuery->where('id', $user->guru->id);
        }
        $gurus = $gurusQuery->get();
        
        // Count trashed tugas
        $trashQuery = Tugas::onlyTrashed();
        if ($isGuru) {
            $trashQuery->where('id_guru', $user->guru->id);
        }
        $trashCount = $trashQuery->count();
        
        return view('tugas.index', compact('tugas', 'pertemuans', 'allPertemuan', 'gurus', 'q', 'filter_status', 'kelasList', 'id_kelas', 'trashCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'id_guru' => 'required|exists:guru,id',
            'id_mapel' => 'nullable|exists:mapel,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_tugas' => 'required|in:individu,kelompok',
            'tipe_file' => 'required|in:tanpa,dokumen,video,link',
            'file_url' => $request->input('tipe_file') === 'link'
                ? 'required|url'
                : ($request->input('tipe_file') === 'tanpa'
                    ? 'nullable'
                    : ($request->input('tipe_file') === 'dokumen'
                        ? 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp|max:102400'
                        : 'required|file|mimes:mp4,webm|max:102400')),
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'allow_late' => 'boolean',
            'auto_release' => 'nullable|boolean',
            'waktu_rilis' => 'nullable|date',
            'batas_absensi' => 'nullable|date|after:waktu_rilis',
        ]);

        $validated['allow_late'] = $request->has('allow_late');

        if ($request->hasFile('file_url') && in_array($validated['tipe_file'], ['dokumen', 'video'])) {
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        } elseif ($validated['tipe_file'] === 'link') {
            $validated['file_url'] = $request->input('file_url');
        } else {
            $validated['file_url'] = null;
        }

        // Auto-resolve id_guru_mapel dan id_mapel dari JadwalBelajar pertemuan
        if (!($validated['id_guru_mapel'] ?? null) || !($validated['id_mapel'] ?? null)) {
            $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.GuruMapel.Mapel')->find($validated['id_pertemuan']);
            $jadwal = $pertemuan?->JadwalBelajar;

            if ($jadwal) {
                if (!($validated['id_guru_mapel'] ?? null)) {
                    $guruMapelId = $jadwal->id_guru_mapel;
                    if ($guruMapelId && \App\Models\GuruMapel::where('id', $guruMapelId)->exists()) {
                        $validated['id_guru_mapel'] = $guruMapelId;
                    } else {
                        $validated['id_guru_mapel'] = null;
                    }
                }

                if (!($validated['id_mapel'] ?? null)) {
                    $mapelId = $jadwal->GuruMapel?->id_mapel ?? $jadwal->id_mapel;
                    if ($mapelId && \App\Models\Mapel::where('id', $mapelId)->exists()) {
                        $validated['id_mapel'] = $mapelId;
                    } else {
                        $validated['id_mapel'] = null;
                    }
                }
            } else {
                $validated['id_guru_mapel'] = $validated['id_guru_mapel'] ?? null;
                $validated['id_mapel'] = $validated['id_mapel'] ?? null;
            }
        }

        // Handle auto_release
        // IMPORTANT: Checkbox only sends value when checked, so we check if key exists in request
        $validated['auto_release'] = $request->has('auto_release') ? true : false;

        // CRITICAL: Determine waktu_rilis BEFORE creating tugas to set correct status
        $waktuRilis = null;
        if ($validated['auto_release']) {
            // Calculate release time from pertemuan
            $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.JamBelajar')->find($validated['id_pertemuan']);
            $waktuRilis = $this->contentReleaseService->calculateReleaseTime($pertemuan);
            $validated['waktu_rilis'] = $waktuRilis;
            
            // Set batas_absensi to 24 hours after release (same as ContentReleaseService default)
            if ($waktuRilis) {
                $validated['batas_absensi'] = $waktuRilis->copy()->addHours(24);
            }
            
            \Log::info('[TUGAS CREATE] Auto-release: Calculated waktu_rilis BEFORE create', [
                'pertemuan_id' => $validated['id_pertemuan'],
                'waktu_rilis' => $waktuRilis,
                'batas_absensi' => $validated['batas_absensi'] ?? null
            ]);
        } else {
            // Manual release: use waktu_rilis from form
            $waktuRilis = $validated['waktu_rilis'] ?? null;
            \Log::info('[TUGAS CREATE] Manual release: Using waktu_rilis from form', [
                'waktu_rilis' => $waktuRilis
            ]);
        }

        // CRITICAL: Set correct status BEFORE creating tugas
        if ($waktuRilis && now()->lt($waktuRilis)) {
            // Future release - set as draft
            $validated['status'] = 'draft';
            \Log::info('[TUGAS CREATE] Status set to DRAFT before create (future release)', [
                'waktu_rilis' => $waktuRilis,
                'now' => now()->toDateTimeString()
            ]);
        } else {
            // Immediate release or no waktu_rilis - set as published
            $validated['status'] = 'published';
            \Log::info('[TUGAS CREATE] Status set to PUBLISHED before create', [
                'waktu_rilis' => $waktuRilis
            ]);
        }

        // Create tugas with correct status from the start
        $tugas = Tugas::create($validated);
        
        \Log::info('[TUGAS CREATE] Tugas created successfully', [
            'tugas_id' => $tugas->id,
            'judul' => $tugas->judul,
            'status' => $tugas->status,
            'waktu_rilis' => $tugas->waktu_rilis
        ]);

        // Broadcast content update event
        $kelas_id = $pertemuan?->JadwalBelajar?->id_kelas;
        if ($kelas_id) {
            event(new ContentUpdated('tugas', 'created', $tugas->id, [$kelas_id], [
                'judul' => $tugas->judul,
                'status' => $tugas->status
            ]));
        }

        return back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function update(Request $request, Tugas $tuga) // Laravel singularizes tugas to tuga by default in route binding if not customized
    {
        $tugas = $tuga;
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'id_guru' => 'required|exists:guru,id',
            'id_mapel' => 'nullable|exists:mapel,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_tugas' => 'required|in:individu,kelompok',
            'tipe_file' => 'required|in:tanpa,dokumen,video,link',
            'file_url' => $request->input('tipe_file') === 'link'
                ? 'nullable'
                : ($request->input('tipe_file') === 'tanpa'
                    ? 'nullable'
                    : ($request->input('tipe_file') === 'dokumen'
                        ? 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp|max:102400'
                        : 'nullable|file|mimes:mp4,webm|max:102400')),
            'file_url_link' => $request->input('tipe_file') === 'link' ? 'required|url' : 'nullable',
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'allow_late' => 'boolean',
            'auto_release' => 'nullable|boolean',
            'waktu_rilis' => 'nullable|date',
            'batas_absensi' => 'nullable|date|after_or_equal:waktu_rilis',
        ]);

        $validated['allow_late'] = $request->has('allow_late');
        
        // Handle auto_release - default to false if not provided in update
        // IMPORTANT: Checkbox only sends value when checked, so we check if key exists in request
        $validated['auto_release'] = $request->has('auto_release') ? true : false;

        // CRITICAL: Determine waktu_rilis BEFORE updating to set correct status
        $waktuRilis = null;
        if ($validated['auto_release']) {
            // Calculate release time from pertemuan
            $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.JamBelajar')->find($validated['id_pertemuan']);
            $waktuRilis = $this->contentReleaseService->calculateReleaseTime($pertemuan);
            $validated['waktu_rilis'] = $waktuRilis;
            
            // Set batas_absensi to 24 hours after release (same as ContentReleaseService default)
            if ($waktuRilis) {
                $validated['batas_absensi'] = $waktuRilis->copy()->addHours(24);
            }
            
            \Log::info('[TUGAS UPDATE] Auto-release: Calculated waktu_rilis', [
                'tugas_id' => $tugas->id,
                'waktu_rilis' => $waktuRilis,
                'batas_absensi' => $validated['batas_absensi'] ?? null
            ]);
        } else {
            // Manual release: use waktu_rilis from form
            $waktuRilis = $validated['waktu_rilis'] ?? null;
            \Log::info('[TUGAS UPDATE] Manual release: Using waktu_rilis from form', [
                'tugas_id' => $tugas->id,
                'waktu_rilis' => $waktuRilis
            ]);
        }

        // CRITICAL: Set correct status BEFORE update
        if ($waktuRilis && now()->lt($waktuRilis)) {
            // Future release - set as draft
            $validated['status'] = 'draft';
            \Log::info('[TUGAS UPDATE] Status set to DRAFT (future release)', [
                'tugas_id' => $tugas->id,
                'waktu_rilis' => $waktuRilis
            ]);
        } else {
            // Immediate release or no waktu_rilis - set as published (unless manually closed)
            if ($tugas->status !== 'closed') {
                $validated['status'] = 'published';
            }
            \Log::info('[TUGAS UPDATE] Status set to PUBLISHED', [
                'tugas_id' => $tugas->id,
                'waktu_rilis' => $waktuRilis
            ]);
        }

        if ($request->hasFile('file_url') && in_array($validated['tipe_file'], ['dokumen', 'video'])) {
            if ($tugas->file_url && !str_starts_with($tugas->file_url, 'http')) {
                Storage::disk('public')->delete($tugas->file_url);
            }
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        } elseif ($validated['tipe_file'] === 'link') {
            // Use file_url_link for link type
            $validated['file_url'] = $request->input('file_url_link');
        } else {
            // For tanpa (no file) or if no new file uploaded
            if ($validated['tipe_file'] === 'tanpa') {
                // Delete old file if switching to tanpa
                if ($tugas->file_url && !str_starts_with($tugas->file_url, 'http')) {
                    Storage::disk('public')->delete($tugas->file_url);
                }
                $validated['file_url'] = null;
            }
            // If file type is dokumen/video but no new file uploaded, keep existing file
            else {
                unset($validated['file_url']); // Keep existing file
            }
        }

        // Auto-resolve id_guru_mapel dan id_mapel dari JadwalBelajar pertemuan
        if (!($validated['id_guru_mapel'] ?? null) || !($validated['id_mapel'] ?? null)) {
            $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.GuruMapel.Mapel')->find($validated['id_pertemuan']);
            $jadwal = $pertemuan?->JadwalBelajar;

            if ($jadwal) {
                // Resolve id_guru_mapel — hanya set jika record-nya benar-benar ada
                if (!($validated['id_guru_mapel'] ?? null)) {
                    $guruMapelId = $jadwal->id_guru_mapel;
                    if ($guruMapelId && \App\Models\GuruMapel::where('id', $guruMapelId)->exists()) {
                        $validated['id_guru_mapel'] = $guruMapelId;
                    } else {
                        $validated['id_guru_mapel'] = null;
                    }
                }

                // Resolve id_mapel — coba dari GuruMapel dulu, fallback ke kolom langsung
                if (!($validated['id_mapel'] ?? null)) {
                    $mapelId = $jadwal->GuruMapel?->id_mapel ?? $jadwal->id_mapel;
                    if ($mapelId && \App\Models\Mapel::where('id', $mapelId)->exists()) {
                        $validated['id_mapel'] = $mapelId;
                    } else {
                        $validated['id_mapel'] = null;
                    }
                }
            } else {
                $validated['id_guru_mapel'] = $validated['id_guru_mapel'] ?? null;
                $validated['id_mapel'] = $validated['id_mapel'] ?? null;
            }
        }

        // Update tugas with correct status
        $tugas->update($validated);

        \Log::info('[TUGAS UPDATE] Tugas updated successfully', [
            'tugas_id' => $tugas->id,
            'status' => $tugas->status,
            'waktu_rilis' => $tugas->waktu_rilis
        ]);

        // Broadcast content update event
        $kelas_id = $pertemuan?->JadwalBelajar?->id_kelas;
        if ($kelas_id) {
            event(new ContentUpdated('tugas', 'updated', $tugas->id, [$kelas_id], [
                'judul' => $tugas->judul,
                'status' => $tugas->status
            ]));
        }

        return back()->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tuga)
    {
        $kelas_id = $tuga->Pertemuan?->JadwalBelajar?->id_kelas;
        $tuga->delete();
        
        // Broadcast content update event
        if ($kelas_id) {
            event(new ContentUpdated('tugas', 'deleted', $tuga->id, [$kelas_id]));
        }
        
        return back()->with('success', 'Tugas berhasil diarsipkan.');
    }

    public function trash(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $q = $request->input('q');
        $id_kelas = $request->input('id_kelas');

        $query = Tugas::onlyTrashed()->with(['Pertemuan.JadwalBelajar.Kelas', 'Mapel', 'GuruMapel.Guru']);

        if ($isGuru) {
            $query->where('id_guru', $user->guru->id);
        }

        if ($id_kelas) {
            $query->whereHas('Pertemuan.JadwalBelajar', function($subQuery) use ($id_kelas) {
                $subQuery->where('id_kelas', $id_kelas);
            });
        }

        if ($q) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('judul', 'like', "%$q%")
                         ->orWhere('deskripsi', 'like', "%$q%");
            });
        }

        $tugas = $query->latest('deleted_at')->paginate(10)->withQueryString();

        // Get kelas list for filters
        $kelasQuery = \App\Models\Kelas::with(['tingkatan', 'jurusan', 'bagian']);
        if ($isGuru) {
            $guru = $user->guru;
            $kelasQuery->whereHas('jadwalBelajars.guruMapel', function($subQuery) use ($guru) {
                $subQuery->where('id_guru', $guru->id);
            });
        }
        $kelasList = $kelasQuery->get();

        return view('tugas.trash', compact('tugas', 'kelasList', 'q', 'id_kelas', 'isGuru'));
    }

    public function restore($id)
    {
        $tugas = Tugas::onlyTrashed()->findOrFail($id);
        $user = auth()->user();

        // Authorization check
        if ($user->role === 'guru' && $user->guru) {
            if ($tugas->id_guru !== $user->guru->id) {
                abort(403, 'Anda tidak memiliki akses untuk memulihkan tugas ini.');
            }
        }

        $tugas->restore();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $tugas = Tugas::onlyTrashed()->findOrFail($id);
        $user = auth()->user();

        // Authorization check
        if ($user->role === 'guru' && $user->guru) {
            if ($tugas->id_guru !== $user->guru->id) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus permanen tugas ini.');
            }
        }

        // Delete associated file if exists
        if ($tugas->file_url && !str_starts_with($tugas->file_url, 'http')) {
            Storage::disk('public')->delete($tugas->file_url);
        }

        // Cascade delete submissions and their grades
        foreach ($tugas->PengumpulanTugas as $pengumpulan) {
            if ($pengumpulan->file_url && !str_starts_with($pengumpulan->file_url, 'http')) {
                Storage::disk('public')->delete($pengumpulan->file_url);
            }
            $pengumpulan->penilaian()->forceDelete();
            $pengumpulan->forceDelete();
        }

        $tugas->forceDelete();
        return redirect()->route('tugas.trash')->with('success', 'Tugas dan data terkait berhasil dihapus permanen.');
    }

    public function restoreAll()
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $query = Tugas::onlyTrashed();
        if ($isGuru) {
            $query->where('id_guru', $user->guru->id);
        }

        $query->restore();
        return redirect()->route('tugas.index')->with('success', 'Semua tugas berhasil dipulihkan.');
    }

    public function forceDeleteAll()
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $query = Tugas::onlyTrashed();
        if ($isGuru) {
            $query->where('id_guru', $user->guru->id);
        }

        $tugasList = $query->get();
        foreach ($tugasList as $tugas) {
            if ($tugas->file_url && !str_starts_with($tugas->file_url, 'http')) {
                Storage::disk('public')->delete($tugas->file_url);
            }
            foreach ($tugas->PengumpulanTugas as $pengumpulan) {
                if ($pengumpulan->file_url && !str_starts_with($pengumpulan->file_url, 'http')) {
                    Storage::disk('public')->delete($pengumpulan->file_url);
                }
                $pengumpulan->penilaian()->forceDelete();
                $pengumpulan->forceDelete();
            }
            $tugas->forceDelete();
        }

        return redirect()->route('tugas.trash')->with('success', 'Semua tugas berhasil dihapus permanen.');
    }
}