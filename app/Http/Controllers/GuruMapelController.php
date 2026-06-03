<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuruMapel\StoreGuruMapelRequest;
use App\Http\Requests\GuruMapel\UpdateGuruMapelRequest;
use App\Models\GuruMapel;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuruMapelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $mapels    = Mapel::all();
        $gurus     = Guru::all();
        $kelas     = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        $semesters = Semester::all();

        $guruMapels = GuruMapel::with([
                'Mapel',
                'Guru',
                'Kelas.Tingkatan',
                'Kelas.Jurusan',
                'Kelas.Bagian',
                'Semester',
            ])
            ->when($search, function ($query, $search) {
                return $query->whereHas('Mapel', function ($q) use ($search) {
                    $q->where('nama_mapel', 'like', "%{$search}%");
                })->orWhereHas('Guru', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $trashCount = GuruMapel::onlyTrashed()->count();

        if ($request->ajax()) {
            return response()->json([
                'guru_mapel' => $guruMapels->map(function ($item) {
                    return [
                        'id'          => $item->id,
                        'id_mapel'    => $item->id_mapel,
                        'id_guru'     => $item->id_guru,
                        'id_kelas'    => $item->id_kelas,
                        'id_semester' => $item->id_semester,
                        'mapel' => [
                            'nama_mapel' => $item->Mapel->nama_mapel ?? '-',
                        ],
                        'guru' => [
                            'nama_lengkap' => $item->Guru->nama_lengkap ?? '-',
                        ],
                        'kelas' => [
                            'tingkatan' => [
                                'nama_tingkatan' => $item->Kelas->Tingkatan->nama_tingkatan ?? ''
                            ],
                            'jurusan' => [
                                'nama_jurusan' => $item->Kelas->Jurusan->nama_jurusan ?? ''
                            ],
                            'bagian' => [
                                'nama_bagian' => $item->Kelas->Bagian->nama_bagian ?? ''
                            ],
                        ],
                        'semester' => [
                            'nama_semester' => $item->Semester->nama_semester ?? '-',
                        ],
                    ];
                }),
                'pagination' => $guruMapels->links()->toHtml(),
                'total' => $guruMapels->total(),
            ]);
        }

        return view('guru_mapel.index', compact(
            'guruMapels',
            'search',
            'mapels',
            'gurus',
            'kelas',
            'semesters',
            'trashCount'
        ));
    }

    public function create(): View
    {
        $mapels    = Mapel::all();
        $gurus     = Guru::all();
        $kelas     = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        $semesters = Semester::all();

        return view('guru_mapel.create', compact(
            'mapels',
            'gurus',
            'kelas',
            'semesters'
        ));
    }

    public function store(StoreGuruMapelRequest $request): RedirectResponse
    {
        GuruMapel::create($request->validated());

        return redirect()
            ->route('guru_mapel.index')
            ->with('success', 'Guru Mapel berhasil ditambahkan.');
    }

    public function show(GuruMapel $guru_mapel): View
    {
        $guru_mapel->load([
            'Mapel',
            'Guru',
            'Kelas.Tingkatan',
            'Kelas.Jurusan',
            'Kelas.Bagian',
            'Semester',
        ]);

        return view('guru_mapel.show', compact('guru_mapel'));
    }

    public function edit(GuruMapel $guru_mapel): View
    {
        $mapels    = Mapel::all();
        $gurus     = Guru::all();
        $kelas     = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        $semesters = Semester::all();

        return view('guru_mapel.edit', compact(
            'guru_mapel',
            'mapels',
            'gurus',
            'kelas',
            'semesters'
        ));
    }

    public function update(
        UpdateGuruMapelRequest $request,
        GuruMapel $guru_mapel
    ): RedirectResponse {
        $guru_mapel->update($request->validated());

        return redirect()
            ->route('guru_mapel.index')
            ->with('success', 'Guru Mapel berhasil diperbarui.');
    }

    public function destroy(GuruMapel $guru_mapel): RedirectResponse
    {
        $guru_mapel->delete();

        return redirect()
            ->route('guru_mapel.index')
            ->with('success', 'Guru Mapel berhasil dipindahkan ke arsip.');
    }

    public function trash(Request $request): View
{
    $search = $request->search;

    $guruMapels = GuruMapel::onlyTrashed()
        ->with([
            'Mapel',
            'Guru',
            'Kelas.Tingkatan',
            'Kelas.Jurusan',
            'Kelas.Bagian',
            'Semester',
        ])
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('Mapel', function ($sub) use ($search) {
                    $sub->where('nama_mapel', 'like', "%{$search}%");
                })
                ->orWhereHas('Guru', function ($sub) use ($search) {
                    $sub->where('nama_lengkap', 'like', "%{$search}%");
                })
                ->orWhereHas('Semester', function ($sub) use ($search) {
                    $sub->where('nama_semester', 'like', "%{$search}%");
                });
            });
        })
        ->latest('deleted_at')
        ->paginate(10)
        ->withQueryString();

    return view('guru_mapel.trash', compact('guruMapels'));
}

    public function restore($id): RedirectResponse
    {
        GuruMapel::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('guru_mapel.trash')
            ->with('success', 'Guru Mapel berhasil dipulihkan.');
    }

    public function restoreAll(): RedirectResponse
    {
        GuruMapel::onlyTrashed()->restore();

        return redirect()
            ->route('guru_mapel.trash')
            ->with('success', 'Semua Guru Mapel berhasil dipulihkan.');
    }

    public function forceDelete($id): RedirectResponse
    {
        GuruMapel::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return redirect()
            ->route('guru_mapel.trash')
            ->with('success', 'Guru Mapel berhasil dihapus permanen.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        GuruMapel::onlyTrashed()->forceDelete();

        return redirect()
            ->route('guru_mapel.trash')
            ->with('success', 'Semua Guru Mapel berhasil dihapus permanen.');
    }
}