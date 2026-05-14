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
        $q = $request->input('q');
        $filter_tipe = $request->input('filter_tipe', 'semua');
        $filter_status = $request->input('filter_status', 'semua');

        $pertemuanQuery = Pertemuan::where(function($query) {
            $query->has('materis')->orHas('tugas');
        });

        if ($q || $filter_tipe !== 'semua' || $filter_status !== 'semua') {
            $pertemuanQuery->where(function ($qBuilder) use ($q, $filter_tipe, $filter_status) {
                if ($q) {
                    $qBuilder->where('nomor_pertemuan', 'like', "%$q%");
                }

                if ($filter_tipe === 'semua' || $filter_tipe === 'materi') {
                    $qBuilder->orWhereHas('materis', function($query) use ($q) {
                        if ($q) $query->where('judul', 'like', "%$q%");
                    });
                }
                
                if ($filter_tipe === 'semua' || $filter_tipe === 'tugas') {
                    $qBuilder->orWhereHas('tugas', function($query) use ($q, $filter_status) {
                        if ($q) $query->where('judul', 'like', "%$q%");
                        if ($filter_status !== 'semua') $query->where('status', $filter_status);
                    });
                }
            });
        }

        $pertemuans = $pertemuanQuery
            ->with(['jadwalBelajar.guruMapel.mapel', 'jadwalBelajar.guruMapel.guru', 'jadwalBelajar.mapel'])
            ->orderBy('nomor_pertemuan')->paginate(5)->withQueryString();
        $pertemuanIds = $pertemuans->pluck('id');
        
        $materiQuery = Materi::with(['pertemuan', 'mapel', 'guruMapel.guru'])->whereIn('id_pertemuan', $pertemuanIds);
        $tugasQuery = \App\Models\Tugas::with(['pertemuan', 'guru', 'mapel', 'guruMapel.guru'])->whereIn('id_pertemuan', $pertemuanIds);

        // Filter the children items as well
        if ($q) {
            $materiQuery->where(function($query) use ($q) {
                $query->where('judul', 'like', "%$q%")
                      ->orWhereHas('pertemuan', function($pQuery) use ($q) {
                          $pQuery->where('nomor_pertemuan', 'like', "%$q%");
                      });
            });
            $tugasQuery->where(function($query) use ($q) {
                $query->where('judul', 'like', "%$q%")
                      ->orWhereHas('pertemuan', function($pQuery) use ($q) {
                          $pQuery->where('nomor_pertemuan', 'like', "%$q%");
                      });
            });
        }
        
        if ($filter_status !== 'semua') {
            $tugasQuery->where('status', $filter_status);
        }

        $materis = $filter_tipe === 'tugas' ? collect() : $materiQuery->latest()->get();
        $tugas = $filter_tipe === 'materi' ? collect() : $tugasQuery->latest()->get();
        
        $allPertemuan = Pertemuan::with(['jadwalBelajar.guruMapel.mapel', 'jadwalBelajar.mapel'])->orderBy('nomor_pertemuan')->get();
        $gurus = \App\Models\Guru::with('user')->get();
        $allGuruMapel = \App\Models\GuruMapel::with(['guru', 'mapel', 'kelas'])->get();
        
        return view('materi.index', compact('materis', 'tugas', 'pertemuans', 'allPertemuan', 'gurus', 'allGuruMapel', 'q', 'filter_tipe', 'filter_status'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|in:dokumen,video,link,lainnya',
            'file_url' => $request->tipe_materi === 'link' ? 'required|url' : 'nullable|file|mimes:pdf,mp4,doc,docx|max:50000',
        ]);

        if ($request->hasFile('file_url') && $request->tipe_materi !== 'link') {
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        } elseif ($request->tipe_materi === 'link') {
            $validated['file_url'] = $request->input('file_url');
        }

        $pertemuan = \App\Models\Pertemuan::with('jadwalBelajar.guruMapel')->find($validated['id_pertemuan']);
        if ($pertemuan && $pertemuan->jadwalBelajar && $pertemuan->jadwalBelajar->guruMapel) {
            $validated['id_guru_mapel'] = $pertemuan->jadwalBelajar->id_guru_mapel;
            $validated['id_mapel'] = $pertemuan->jadwalBelajar->guruMapel->id_mapel;
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
            'file_url' => $request->tipe_materi === 'link' ? 'required|url' : 'nullable|file|mimes:pdf,mp4,doc,docx|max:50000',
        ]);

        if ($request->hasFile('file_url') && $request->tipe_materi !== 'link') {
            if (isset($materi) && $materi->file_url && !str_starts_with($materi->file_url, 'http')) {
                Storage::disk('public')->delete($materi->file_url);
            }
            $validated['file_url'] = $request->file('file_url')->store('materi_files', 'public');
        } elseif ($request->tipe_materi === 'link') {
            $validated['file_url'] = $request->input('file_url');
        }

        $pertemuan = \App\Models\Pertemuan::with('jadwalBelajar.guruMapel')->find($validated['id_pertemuan']);
        if ($pertemuan && $pertemuan->jadwalBelajar && $pertemuan->jadwalBelajar->guruMapel) {
            $validated['id_guru_mapel'] = $pertemuan->jadwalBelajar->id_guru_mapel;
            $validated['id_mapel'] = $pertemuan->jadwalBelajar->guruMapel->id_mapel;
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
}