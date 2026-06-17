<?php

namespace App\Http\Controllers;

use App\Events\ContentUpdated;
use App\Http\Requests\Kuis\StoreKuisRequest;
use App\Http\Requests\Kuis\UpdateKuisRequest;
use App\Models\GuruMapel;
use App\Models\Kuis;
use App\Models\Pertemuan;
use App\Services\ContentReleaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KuisController extends Controller
{
    protected $contentReleaseService;

    public function __construct(ContentReleaseService $contentReleaseService)
    {
        $this->contentReleaseService = $contentReleaseService;
    }

    /**
     * Display a listing of kuis.
     * Guru sees only their own kuis, admin sees all.
     */
    public function index()
    {
        $user = Auth::user();

        $query = Kuis::with(['Pertemuan', 'GuruMapel.Mapel', 'Guru'])
            ->withCount('SoalKuis');

        // Filter by guru if not admin
        if ($user->role === 'guru' && $user->Guru) {
            $query->where('id_guru', $user->Guru->id);
        }

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('GuruMapel.Mapel', function ($q) use ($search) {
                      $q->where('nama_mapel', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $kuisList = $query->latest()->paginate(10)->withQueryString();

        // Count trashed kuis
        $trashQuery = Kuis::onlyTrashed();
        if ($user->role === 'guru' && $user->Guru) {
            $trashQuery->where('id_guru', $user->Guru->id);
        }
        $trashCount = $trashQuery->count();

        return view('kuis.index', compact('kuisList', 'trashCount'));
    }

    /**
     * Show the form for creating a new kuis.
     */
    public function create()
    {
        $user = Auth::user();

        // Get pertemuan filtered by guru's classes
        if ($user->role === 'guru' && $user->Guru) {
            // Get only pertemuan from guru's guru_mapel (their classes)
            $pertemuanList = Pertemuan::whereHas('JadwalBelajar.GuruMapel', function($q) use ($user) {
                $q->where('id_guru', $user->Guru->id);
            })
            ->with('JadwalBelajar')
            ->latest()
            ->get();
            
            $guruMapelList = GuruMapel::where('id_guru', $user->Guru->id)
                ->with('Mapel')
                ->get();
        } else {
            // Admin sees all
            $pertemuanList = Pertemuan::with('JadwalBelajar')->latest()->get();
            $guruMapelList = GuruMapel::with('Mapel')->get();
        }

        return view('kuis.create', compact('pertemuanList', 'guruMapelList'));
    }

    /**
     * Store a newly created kuis in storage.
     * Status defaults to 'draft' (Req 6.3).
     */
    public function store(StoreKuisRequest $request)
    {
        $user = Auth::user();

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Get guru ID - check if user has Guru relationship
            if ($user->role === 'guru' && $user->Guru) {
                $validated['id_guru'] = $user->Guru->id;
            } elseif (in_array($user->role, ['admin', 'super_admin'])) {
                // For admin, get guru from guru_mapel relationship
                $guruMapel = GuruMapel::find($validated['id_guru_mapel']);
                $validated['id_guru'] = $guruMapel ? $guruMapel->id_guru : null;
            } else {
                throw new \Exception('User tidak memiliki akses untuk membuat kuis.');
            }

            // Handle auto_release (default true if not provided)
            $autoRelease = $request->input('auto_release', true);
            $validated['auto_release'] = $autoRelease;

            // CRITICAL: Calculate waktu_rilis BEFORE creating kuis to set correct status
            $waktuRilis = null;
            if ($autoRelease) {
                // Calculate release time from pertemuan
                $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.JamBelajar')->find($validated['id_pertemuan']);
                $waktuRilis = $this->contentReleaseService->calculateReleaseTime($pertemuan);
                $validated['waktu_rilis'] = $waktuRilis;
                
                // Set batas_absensi to 24 hours after release (same as ContentReleaseService default)
                if ($waktuRilis) {
                    $validated['batas_absensi'] = $waktuRilis->copy()->addHours(24);
                }
                
                \Log::info('[KUIS CREATE] Auto-release: Calculated waktu_rilis BEFORE create', [
                    'pertemuan_id' => $validated['id_pertemuan'],
                    'waktu_rilis' => $waktuRilis,
                    'batas_absensi' => $validated['batas_absensi'] ?? null
                ]);
            } else {
                // Manual release: use waktu_rilis from form
                $waktuRilis = isset($validated['waktu_rilis']) ? \Carbon\Carbon::parse($validated['waktu_rilis']) : null;
                \Log::info('[KUIS CREATE] Manual release: Using waktu_rilis from form', [
                    'waktu_rilis' => $waktuRilis
                ]);
            }

            // CRITICAL: Kuis SELALU dimulai dengan status DRAFT sampai ada soal
            // Status akan otomatis berubah melalui ContentReleaseService setelah ada soal
            $validated['status'] = 'draft';
            
            \Log::info('[KUIS CREATE] Status set to DRAFT (default for new kuis)', [
                'waktu_rilis' => $waktuRilis,
                'now' => now()->toDateTimeString()
            ]);

            // Create kuis with draft status from the start
            $kuis = Kuis::create($validated);
            
            \Log::info('[KUIS CREATE] Kuis created successfully', [
                'kuis_id' => $kuis->id,
                'judul' => $kuis->judul,
                'status' => $kuis->status,
                'waktu_rilis' => $kuis->waktu_rilis
            ]);

            // Broadcast content update event
            $pertemuan = Pertemuan::find($validated['id_pertemuan']);
            $kelas_id = $pertemuan?->JadwalBelajar?->id_kelas;
            if ($kelas_id) {
                event(new ContentUpdated('kuis', 'created', $kuis->id, [$kelas_id], [
                    'judul' => $kuis->judul,
                    'status' => $kuis->status
                ]));
            }

            DB::commit();

            return redirect()->route('soal_kuis.index', $kuis)
                ->with('success', 'Kuis berhasil dibuat. Silakan tambahkan soal.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat kuis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified kuis with results summary.
     */
    public function show(Kuis $kuis)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        $kuis->load(['SoalKuis', 'HasilKuis.Siswa', 'GuruMapel.Mapel']);

        // Calculate statistics
        $totalSoal = $kuis->SoalKuis->count();
        $totalSiswa = $kuis->HasilKuis->count();
        $rataRata = $totalSiswa > 0 ? $kuis->HasilKuis->avg('nilai') : 0;

        return view('kuis.show', compact('kuis', 'totalSoal', 'totalSiswa', 'rataRata'));
    }

    /**
     * Show the form for editing the specified kuis.
     */
    public function edit(Kuis $kuis)
    {
        $user = Auth::user();

        // Authorization check (Req 10.2)
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kuis ini.');
        }

        // Get pertemuan filtered by guru's classes
        if ($user->role === 'guru' && $user->Guru) {
            // Get only pertemuan from guru's guru_mapel (their classes)
            $pertemuanList = Pertemuan::whereHas('JadwalBelajar.GuruMapel', function($q) use ($user) {
                $q->where('id_guru', $user->Guru->id);
            })
            ->with('JadwalBelajar')
            ->latest()
            ->get();
            
            $guruMapelList = GuruMapel::where('id_guru', $user->Guru->id)
                ->with('Mapel')
                ->get();
        } else {
            // Admin sees all
            $pertemuanList = Pertemuan::with('JadwalBelajar')->latest()->get();
            $guruMapelList = GuruMapel::with('Mapel')->get();
        }

        return view('kuis.edit', compact('kuis', 'pertemuanList', 'guruMapelList'));
    }

    /**
     * Update the specified kuis in storage.
     */
    public function update(UpdateKuisRequest $request, Kuis $kuis)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kuis ini.');
        }

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Handle auto_release
            $autoRelease = $request->input('auto_release', false);
            $validated['auto_release'] = $autoRelease;

            // Calculate waktu_rilis if auto_release is enabled
            if ($autoRelease) {
                // Calculate release time from pertemuan
                $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.JamBelajar')->find($validated['id_pertemuan']);
                $waktuRilis = $this->contentReleaseService->calculateReleaseTime($pertemuan);
                $validated['waktu_rilis'] = $waktuRilis;
                
                // Set batas_absensi to 24 hours after release (same as ContentReleaseService default)
                if ($waktuRilis) {
                    $validated['batas_absensi'] = $waktuRilis->copy()->addHours(24);
                }
                
                \Log::info('[KUIS UPDATE] Auto-release: Calculated waktu_rilis', [
                    'kuis_id' => $kuis->id,
                    'pertemuan_id' => $validated['id_pertemuan'],
                    'waktu_rilis' => $waktuRilis,
                    'batas_absensi' => $validated['batas_absensi'] ?? null
                ]);
            } else {
                // Manual release: use waktu_rilis from form
                $waktuRilis = isset($validated['waktu_rilis']) ? \Carbon\Carbon::parse($validated['waktu_rilis']) : null;
                \Log::info('[KUIS UPDATE] Manual release: Using waktu_rilis from form', [
                    'kuis_id' => $kuis->id,
                    'waktu_rilis' => $waktuRilis
                ]);
            }

            $kuis->update($validated);
            
            \Log::info('[KUIS UPDATE] Kuis updated successfully', [
                'kuis_id' => $kuis->id,
                'judul' => $kuis->judul,
                'status' => $kuis->status,
                'waktu_rilis' => $kuis->waktu_rilis
            ]);

            // Broadcast content update event
            $pertemuan = Pertemuan::find($validated['id_pertemuan']);
            $kelas_id = $pertemuan?->JadwalBelajar?->id_kelas;
            if ($kelas_id) {
                event(new ContentUpdated('kuis', 'updated', $kuis->id, [$kelas_id], [
                    'judul' => $kuis->judul,
                    'status' => $kuis->status
                ]));
            }

            DB::commit();

            return redirect()->route('kuis.show', $kuis)
                ->with('success', 'Kuis berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui kuis: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete the specified kuis.
     */
    public function destroy(Kuis $kuis)
    {
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus kuis ini.');
        }

        try {
            $kelas_id = $kuis->Pertemuan?->JadwalBelajar?->id_kelas;
            $kuis->delete();
            
            // Broadcast content update event
            if ($kelas_id) {
                event(new ContentUpdated('kuis', 'deleted', $kuis->id, [$kelas_id]));
            }
            
            return redirect()->route('kuis.index')
                ->with('success', 'Kuis berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus kuis.');
        }
    }

    /**
     * Display trashed kuis.
     */
    public function trash()
    {
        $user = Auth::user();

        $query = Kuis::onlyTrashed()
            ->with(['Pertemuan', 'GuruMapel.Mapel', 'Guru']);

        if ($user->role === 'guru' && $user->Guru) {
            $query->where('id_guru', $user->Guru->id);
        }

        $kuisList = $query->latest('deleted_at')->get();

        return view('kuis.trash', compact('kuisList'));
    }

    /**
     * Restore a soft-deleted kuis.
     */
    public function restore($id)
    {
        $kuis = Kuis::onlyTrashed()->findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk memulihkan kuis ini.');
        }

        try {
            $kuis->restore();
            return redirect()->route('kuis.index')
                ->with('success', 'Kuis berhasil dipulihkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memulihkan kuis.');
        }
    }

    /**
     * Permanently delete a kuis and cascade delete related soal and hasil.
     */
    public function forceDelete($id)
    {
        $kuis = Kuis::onlyTrashed()->findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->Guru && $kuis->id_guru !== $user->Guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus permanen kuis ini.');
        }

        try {
            DB::beginTransaction();

            // Cascade delete soal and hasil (Req 11.4)
            $kuis->SoalKuis()->forceDelete();
            $kuis->HasilKuis()->forceDelete();
            $kuis->forceDelete();

            DB::commit();

            return redirect()->route('kuis.trash')
                ->with('success', 'Kuis berhasil dihapus permanen.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus permanen kuis.');
        }
    }
}
