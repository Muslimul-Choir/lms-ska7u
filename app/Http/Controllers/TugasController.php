<?php
namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pertemuan;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
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
            ->with(['jadwalBelajar.guruMapel.mapel', 'jadwalBelajar.guruMapel.guru', 'jadwalBelajar.mapel', 'jadwalBelajar.kelas'])
            ->orderBy('nomor_pertemuan')
            ->paginate(5)
            ->withQueryString();

        $pertemuanIds = $pertemuans->pluck('id');
        
        // Get tugas for these pertemuans
        $tugasQuery = Tugas::with(['pertemuan', 'guru', 'mapel', 'guruMapel.guru', 'guruMapel.kelas'])
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
        $allPertemuanQuery = \App\Models\Pertemuan::with(['jadwalBelajar.guruMapel.mapel', 'jadwalBelajar.mapel', 'jadwalBelajar.kelas']);
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
        
        return view('tugas.index', compact('tugas', 'pertemuans', 'allPertemuan', 'gurus', 'q', 'filter_status', 'kelasList', 'id_kelas'));
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
            'file_url' => $request->input('tipe_file') === 'link' ? 'required|url' : ($request->input('tipe_file') === 'tanpa' ? 'nullable' : 'required|file|mimes:pdf,doc,docx,mp4|max:102400'),
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'status' => 'required|in:draft,published,closed',
            'allow_late' => 'boolean',
        ]);

        $validated['allow_late'] = $request->has('allow_late');

        if ($request->hasFile('file_url') && in_array($validated['tipe_file'], ['dokumen', 'video'])) {
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        } elseif ($validated['tipe_file'] === 'link') {
            $validated['file_url'] = $request->input('file_url');
        } else {
            // For tanpa (no file) or if no file uploaded
            $validated['file_url'] = null;
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

        Tugas::create($validated);
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
            'file_url' => $request->input('tipe_file') === 'link' ? 'required|url' : ($request->input('tipe_file') === 'tanpa' ? 'nullable' : 'nullable|file|mimes:pdf,doc,docx,mp4|max:102400'),
            'batas_waktu' => 'required|date',
            'nilai_maksimal' => 'required|numeric',
            'status' => 'required|in:draft,published,closed',
            'allow_late' => 'boolean',
        ]);

        $validated['allow_late'] = $request->has('allow_late');

        if ($request->hasFile('file_url') && in_array($validated['tipe_file'], ['dokumen', 'video'])) {
            if ($tugas->file_url && !str_starts_with($tugas->file_url, 'http')) {
                Storage::disk('public')->delete($tugas->file_url);
            }
            $validated['file_url'] = $request->file('file_url')->store('tugas_files', 'public');
        } elseif ($validated['tipe_file'] === 'link') {
            $validated['file_url'] = $request->input('file_url');
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

        $tugas->update($validated);
        return back()->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tuga)
    {
        $tugas = $tuga;
        if ($tugas->file_url) Storage::disk('public')->delete($tugas->file_url);
        $tugas->delete();
        return back()->with('success', 'Tugas berhasil dihapus.');
    }
}