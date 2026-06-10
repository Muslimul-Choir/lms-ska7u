<?php
namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;
        
        $q = $request->input('q');
        $filter_status = $request->input('filter_status', 'semua');
        $id_kelas = $request->input('id_kelas');

        // Query pertemuan yang memiliki materi
        $pertemuanQuery = \App\Models\Pertemuan::whereHas('materis');

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
        $kelasQuery = \App\Models\Kelas::with(['tingkatan', 'jurusan', 'bagian']);
        if ($isGuru) {
            $guru = $user->guru;
            $kelasQuery->whereHas('jadwalBelajars.guruMapel', function($query) use ($guru) {
                $query->where('id_guru', $guru->id);
            });
        }
        $kelasList = $kelasQuery->get();
        
        // Get all pertemuan for dropdown (filtered by guru)
        $allPertemuanQuery = \App\Models\Pertemuan::with(['JadwalBelajar.GuruMapel.Mapel', 'JadwalBelajar.Mapel', 'JadwalBelajar.Kelas']);
        if ($isGuru) {
            $guru = $user->guru;
            $allPertemuanQuery->whereHas('jadwalBelajar.guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }
        $allPertemuan = $allPertemuanQuery->orderBy('nomor_pertemuan')->get();
        
        return view('materi.index', compact('materis', 'pertemuans', 'allPertemuan', 'q', 'filter_status', 'kelasList', 'id_kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|in:dokumen,video,link,lainnya',
            'file_url' => $request->tipe_materi === 'link' ? 'required|url' : ($request->tipe_materi === 'lainnya' ? 'nullable' : 'required|file|mimes:pdf,mp4,doc,docx|max:102400'),
        ]);

        if ($request->hasFile('file_url') && $request->tipe_materi !== 'link') {
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        } elseif ($request->tipe_materi === 'link') {
            $validated['file_url'] = $request->input('file_url');
        }

        // Auto-resolve id_guru_mapel dan id_mapel dari JadwalBelajar
        $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.GuruMapel.Mapel')->find($validated['id_pertemuan']);
        $jadwal = $pertemuan?->JadwalBelajar;
        if ($jadwal) {
            $guruMapelId = $jadwal->id_guru_mapel;
            if ($guruMapelId && \App\Models\GuruMapel::where('id', $guruMapelId)->exists()) {
                $validated['id_guru_mapel'] = $guruMapelId;
                $mapelId = $jadwal->GuruMapel?->id_mapel ?? $jadwal->id_mapel;
                if ($mapelId && \App\Models\Mapel::where('id', $mapelId)->exists()) {
                    $validated['id_mapel'] = $mapelId;
                } else {
                    $validated['id_mapel'] = null;
                }
            } else {
                $validated['id_guru_mapel'] = null;
                $validated['id_mapel'] = null;
            }
        }

        Materi::create($validated);
        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|in:dokumen,video,link,lainnya',
            'file_url' => $request->tipe_materi === 'link' ? 'required|url' : ($request->tipe_materi === 'lainnya' ? 'nullable' : 'required_if:tipe_materi,dokumen,video|file|mimes:pdf,mp4,doc,docx|max:102400'),
        ]);

        if ($request->hasFile('file_url') && $request->tipe_materi !== 'link') {
            if (isset($materi) && $materi->file_url && !str_starts_with($materi->file_url, 'http')) {
                Storage::disk('public')->delete($materi->file_url);
            }
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        } elseif ($request->tipe_materi === 'link') {
            $validated['file_url'] = $request->input('file_url');
        }

        // Auto-resolve id_guru_mapel dan id_mapel dari JadwalBelajar
        $pertemuan = \App\Models\Pertemuan::with('JadwalBelajar.GuruMapel.Mapel')->find($validated['id_pertemuan']);
        $jadwal = $pertemuan?->JadwalBelajar;
        if ($jadwal) {
            $guruMapelId = $jadwal->id_guru_mapel;
            if ($guruMapelId && \App\Models\GuruMapel::where('id', $guruMapelId)->exists()) {
                $validated['id_guru_mapel'] = $guruMapelId;
                $mapelId = $jadwal->guruMapel?->id_mapel ?? $jadwal->id_mapel;
                if ($mapelId && \App\Models\Mapel::where('id', $mapelId)->exists()) {
                    $validated['id_mapel'] = $mapelId;
                } else {
                    $validated['id_mapel'] = null;
                }
            } else {
                $validated['id_guru_mapel'] = null;
                $validated['id_mapel'] = null;
            }
        }

        $materi->update($validated);
        return back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        if ($materi->file_url) Storage::disk('public')->delete($materi->file_url);
        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus.');
    }

    public function show(Materi $materi)
    {
        $materi->load(['Pertemuan.JadwalBelajar.Kelas', 'Pertemuan.JadwalBelajar.GuruMapel.Mapel', 'GuruMapel.Guru']);
        return view('materi.show', compact('materi'));
    }
}