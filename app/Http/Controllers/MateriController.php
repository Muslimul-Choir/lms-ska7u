<?php
namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Pertemuan;
use App\Services\ContentReleaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    protected $contentReleaseService;

    public function __construct(ContentReleaseService $contentReleaseService)
    {
        $this->contentReleaseService = $contentReleaseService;
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $isGuru = $user->role === 'guru' && $user->guru;
        
        $q = $request->input('q');
        $filter_status = $request->input('filter_status', 'semua');
        $id_kelas = $request->input('id_kelas');

        // Query pertemuan yang memiliki materi
        $pertemuanQuery = Pertemuan::whereHas('materis');

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

        // Search in pertemuan or materi
        if ($q) {
            $pertemuanQuery->where(function($query) use ($q) {
                $query->where('nomor_pertemuan', 'like', "%$q%")
                      ->orWhereHas('materis', function($subQuery) use ($q) {
                          $subQuery->where('judul', 'like', "%$q%")
                                   ->orWhere('deskripsi', 'like', "%$q%");
                      });
            });
        }

        $pertemuans = $pertemuanQuery
            ->with(['JadwalBelajar.GuruMapel.Mapel', 'JadwalBelajar.GuruMapel.Guru', 'JadwalBelajar.Mapel', 'JadwalBelajar.Kelas'])
            ->orderBy('nomor_pertemuan')
            ->paginate(5)
            ->withQueryString();

        $pertemuanIds = $pertemuans->pluck('id');
        
        // Get materis for these pertemuans
        $materiQuery = Materi::with(['Pertemuan', 'Mapel', 'GuruMapel.Guru'])
            ->whereIn('id_pertemuan', $pertemuanIds);

        if ($q) {
            $materiQuery->where(function($query) use ($q) {
                $query->where('judul', 'like', "%$q%")
                      ->orWhere('deskripsi', 'like', "%$q%");
            });
        }
        
        if ($filter_status !== 'semua') {
            $materiQuery->where('status', $filter_status);
        }

        $materis = $materiQuery->latest()->get();
        
        // Get kelas list for filter dropdown
        $kelasQuery = Kelas::with(['tingkatan', 'jurusan', 'bagian']);
        if ($isGuru) {
            $guru = $user->guru;
            $kelasQuery->whereHas('jadwalBelajars.guruMapel', function($query) use ($guru) {
                $query->where('id_guru', $guru->id);
            });
        }
        $kelasList = $kelasQuery->get();
        
        // Get all pertemuan for dropdown (filtered by guru)
        $allPertemuanQuery = Pertemuan::with(['JadwalBelajar.GuruMapel.Mapel', 'JadwalBelajar.Mapel', 'JadwalBelajar.Kelas']);
        if ($isGuru) {
            $guru = $user->guru;
            $allPertemuanQuery->whereHas('jadwalBelajar.guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }
        $allPertemuan = $allPertemuanQuery->orderBy('nomor_pertemuan')->get();
        
        // Count trashed materi
        $trashQuery = Materi::onlyTrashed();
        if ($isGuru) {
            $guru = $user->guru;
            $trashQuery->whereHas('GuruMapel', function($query) use ($guru) {
                $query->where('id_guru', $guru->id);
            });
        }
        $trashCount = $trashQuery->count();
        
        return view('materi.index', compact('materis', 'pertemuans', 'allPertemuan', 'q', 'filter_status', 'kelasList', 'id_kelas', 'trashCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|in:dokumen,video,link,lainnya',
            'file_url' => $request->tipe_materi === 'lainnya' ? 'nullable' : ($request->tipe_materi !== 'link' ? 'required|file|mimes:pdf,mp4,doc,docx|max:102400' : 'nullable'),
            'file_url_link' => $request->tipe_materi === 'link' ? 'required|url' : 'nullable',
            'auto_release' => 'nullable|boolean',
            'waktu_rilis' => 'nullable|date',
            'batas_absensi' => 'nullable|date|after:waktu_rilis',
        ]);

        // Handle file/link based on tipe_materi
        if ($request->tipe_materi === 'link') {
            $validated['file_url'] = $request->input('file_url_link');
        } elseif ($request->hasFile('file_url')) {
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        } elseif ($request->tipe_materi === 'lainnya') {
            $validated['file_url'] = null;
        }

        // Auto-resolve id_guru_mapel dan id_mapel dari JadwalBelajar
        $pertemuan = Pertemuan::with('JadwalBelajar.GuruMapel.Mapel')->find($validated['id_pertemuan']);
        $jadwal = $pertemuan?->JadwalBelajar;
        if ($jadwal) {
            $guruMapelId = $jadwal->id_guru_mapel;
            if ($guruMapelId && GuruMapel::where('id', $guruMapelId)->exists()) {
                $validated['id_guru_mapel'] = $guruMapelId;
                $mapelId = $jadwal->GuruMapel?->id_mapel ?? $jadwal->id_mapel;
                if ($mapelId && Mapel::where('id', $mapelId)->exists()) {
                    $validated['id_mapel'] = $mapelId;
                } else {
                    $validated['id_mapel'] = null;
                }
            } else {
                $validated['id_guru_mapel'] = null;
                $validated['id_mapel'] = null;
            }
        }

        // Handle auto_release
        $validated['auto_release'] = $request->has('auto_release') ? (bool) $request->auto_release : true;

        // Create materi
        $materi = Materi::create($validated);

        // Set release time using service
        if ($validated['auto_release']) {
            $this->contentReleaseService->setReleaseTime($materi);
        } elseif (isset($validated['waktu_rilis'])) {
            $this->contentReleaseService->setReleaseTime(
                $materi,
                \Carbon\Carbon::parse($validated['waktu_rilis']),
                isset($validated['batas_absensi']) ? \Carbon\Carbon::parse($validated['batas_absensi']) : null
            );
        }

        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|in:dokumen,video,link,lainnya',
            'file_url' => $request->tipe_materi === 'link' ? 'nullable|url' : 'nullable|file|mimes:pdf,mp4,doc,docx|max:102400',
            'auto_release' => 'nullable|boolean',
            'waktu_rilis' => 'nullable|date',
            'batas_absensi' => 'nullable|date|after_or_equal:waktu_rilis',
        ]);

        if ($request->hasFile('file_url') && $request->tipe_materi !== 'link') {
            if (isset($materi) && $materi->file_url && !str_starts_with($materi->file_url, 'http')) {
                Storage::disk('public')->delete($materi->file_url);
            }
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        } elseif ($request->tipe_materi === 'link' && $request->filled('file_url_link')) {
            $validated['file_url'] = $request->input('file_url_link');
        } else {
            // Keep existing file if no new file uploaded
            unset($validated['file_url']);
        }

        // Auto-resolve id_guru_mapel dan id_mapel dari JadwalBelajar
        $pertemuan = Pertemuan::with('JadwalBelajar.GuruMapel.Mapel')->find($validated['id_pertemuan']);
        $jadwal = $pertemuan?->JadwalBelajar;
        if ($jadwal) {
            $guruMapelId = $jadwal->id_guru_mapel;
            if ($guruMapelId && GuruMapel::where('id', $guruMapelId)->exists()) {
                $validated['id_guru_mapel'] = $guruMapelId;
                $mapelId = $jadwal->guruMapel?->id_mapel ?? $jadwal->id_mapel;
                if ($mapelId && Mapel::where('id', $mapelId)->exists()) {
                    $validated['id_mapel'] = $mapelId;
                } else {
                    $validated['id_mapel'] = null;
                }
            } else {
                $validated['id_guru_mapel'] = null;
                $validated['id_mapel'] = null;
            }
        }

        // Handle auto_release
        $validated['auto_release'] = $request->has('auto_release') ? (bool) $request->auto_release : false;

        // Update materi
        $materi->update($validated);

        // Update release time using service
        if ($validated['auto_release']) {
            $this->contentReleaseService->setReleaseTime($materi);
        } elseif (isset($validated['waktu_rilis'])) {
            $this->contentReleaseService->setReleaseTime(
                $materi,
                \Carbon\Carbon::parse($validated['waktu_rilis']),
                isset($validated['batas_absensi']) ? \Carbon\Carbon::parse($validated['batas_absensi']) : null
            );
        }

        return back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();
        return back()->with('success', 'Materi berhasil diarsipkan.');
    }

    public function show(Materi $materi)
    {
        $materi->load(['Pertemuan.JadwalBelajar.Kelas', 'Pertemuan.JadwalBelajar.GuruMapel.Mapel', 'GuruMapel.Guru']);
        return view('materi.show', compact('materi'));
    }

    public function trash(Request $request)
    {
        $user = Auth::user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $q = $request->input('q');
        $id_kelas = $request->input('id_kelas');

        $query = Materi::onlyTrashed()->with(['Pertemuan.JadwalBelajar.Kelas', 'Mapel', 'GuruMapel.Guru']);

        if ($isGuru) {
            $guru = $user->guru;
            $query->whereHas('GuruMapel', function($subQuery) use ($guru) {
                $subQuery->where('id_guru', $guru->id);
            });
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

        $materis = $query->latest('deleted_at')->paginate(10)->withQueryString();

        // Get kelas list for filters
        $kelasQuery = Kelas::with(['tingkatan', 'jurusan', 'bagian']);
        if ($isGuru) {
            $guru = $user->guru;
            $kelasQuery->whereHas('jadwalBelajars.guruMapel', function($subQuery) use ($guru) {
                $subQuery->where('id_guru', $guru->id);
            });
        }
        $kelasList = $kelasQuery->get();

        return view('materi.trash', compact('materis', 'kelasList', 'q', 'id_kelas', 'isGuru'));
    }

    public function restore($id)
    {
        $materi = Materi::onlyTrashed()->findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->guru) {
            if ($materi->GuruMapel?->id_guru !== $user->guru->id) {
                abort(403, 'Anda tidak memiliki akses untuk memulihkan materi ini.');
            }
        }

        $materi->restore();
        return redirect()->route('materi.index')->with('success', 'Materi berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $materi = Materi::onlyTrashed()->findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if ($user->role === 'guru' && $user->guru) {
            if ($materi->GuruMapel?->id_guru !== $user->guru->id) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus permanen materi ini.');
            }
        }

        if ($materi->file_url && !str_starts_with($materi->file_url, 'http')) {
            Storage::disk('public')->delete($materi->file_url);
        }

        $materi->forceDelete();
        return redirect()->route('materi.trash')->with('success', 'Materi berhasil dihapus permanen.');
    }

    public function restoreAll()
    {
        $user = Auth::user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $query = Materi::onlyTrashed();
        if ($isGuru) {
            $guru = $user->guru;
            $query->whereHas('GuruMapel', function($subQuery) use ($guru) {
                $subQuery->where('id_guru', $guru->id);
            });
        }

        $query->restore();
        return redirect()->route('materi.index')->with('success', 'Semua materi berhasil dipulihkan.');
    }

    public function forceDeleteAll()
    {
        $user = Auth::user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $query = Materi::onlyTrashed();
        if ($isGuru) {
            $guru = $user->guru;
            $query->whereHas('GuruMapel', function($subQuery) use ($guru) {
                $subQuery->where('id_guru', $guru->id);
            });
        }

        $materis = $query->get();
        foreach ($materis as $materi) {
            if ($materi->file_url && !str_starts_with($materi->file_url, 'http')) {
                Storage::disk('public')->delete($materi->file_url);
            }
            $materi->forceDelete();
        }

        return redirect()->route('materi.trash')->with('success', 'Semua materi berhasil dihapus permanen.');
    }
}