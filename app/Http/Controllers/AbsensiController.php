<?php

namespace App\Http\Controllers;

use App\Http\Requests\Absensi\StoreAbsensiRequest;
use App\Http\Requests\Absensi\UpdateAbsensiRequest;
use App\Models\Absensi;
use App\Models\Pertemuan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $search           = $request->get('search');
        $pertemuan_filter = $request->get('id_pertemuan');
        $status_filter    = $request->get('status');

        $absensiQuery = Absensi::with(['pertemuan', 'siswa'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($pertemuan_filter, function ($query, $pertemuan_filter) {
                return $query->where('id_pertemuan', $pertemuan_filter);
            })
            ->when($status_filter, function ($query, $status_filter) {
                return $query->where('status', $status_filter);
            });

        if ($isGuru) {
            $guru = $user->guru;
            $absensiQuery->whereHas('pertemuan.jadwalBelajar.guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }

        $absensis = $absensiQuery->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'absensis'   => $absensis->items(),
                'pagination' => $absensis->links()->toHtml(),
                'total'      => $absensis->total(),
            ]);
        }

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery = Siswa::query();

        if ($isGuru) {
            $guru = $user->guru;
            $myClassIds = \App\Models\GuruMapel::where('id_guru', $guru->id)->pluck('id_kelas')->unique();
            
            $pertemuanQuery->whereHas('jadwalBelajar.guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
            $siswaQuery->whereIn('id_kelas', $myClassIds);
        }

        $pertemuans = $pertemuanQuery->get();
        $siswas     = $siswaQuery->get();

        return view('absensi.index', compact(
            'absensis',
            'search',
            'pertemuans',
            'siswas',
            'pertemuan_filter',
            'status_filter'
        ));
    }

    public function create(): View
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery = Siswa::query();

        if ($isGuru) {
            $guru = $user->guru;
            $myClassIds = \App\Models\GuruMapel::where('id_guru', $guru->id)->pluck('id_kelas')->unique();
            
            $pertemuanQuery->whereHas('jadwalBelajar.guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
            $siswaQuery->whereIn('id_kelas', $myClassIds);
        }

        $pertemuans = $pertemuanQuery->get();
        $siswas     = $siswaQuery->get();

        return view('absensi.create', compact('pertemuans', 'siswas'));
    }

    public function store(StoreAbsensiRequest $request): RedirectResponse
    {
        Absensi::create($request->validated());

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function show(Absensi $absensi): View
    {
        $absensi->load(['pertemuan', 'siswa']);

        return view('absensi.show', compact('absensi'));
    }

    public function edit(Absensi $absensi): View
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery = Siswa::query();

        if ($isGuru) {
            $guru = $user->guru;
            $myClassIds = \App\Models\GuruMapel::where('id_guru', $guru->id)->pluck('id_kelas')->unique();
            
            $pertemuanQuery->whereHas('jadwalBelajar.guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
            $siswaQuery->whereIn('id_kelas', $myClassIds);
        }

        $pertemuans = $pertemuanQuery->get();
        $siswas     = $siswaQuery->get();

        return view('absensi.edit', compact('absensi', 'pertemuans', 'siswas'));
    }

    public function update(UpdateAbsensiRequest $request, Absensi $absensi): RedirectResponse
    {
        $absensi->update($request->validated());

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi): RedirectResponse
    {
        $absensi->delete();

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Absensi berhasil dihapus.');
    }

    public function trash(): View
    {
        $absensis = Absensi::onlyTrashed()
            ->with(['pertemuan', 'siswa'])
            ->latest()
            ->paginate(10);

        return view('absensi.trash', compact('absensis'));
    }

    public function restore(string $id): RedirectResponse
    {
        $absensi = Absensi::onlyTrashed()->findOrFail($id);
        $absensi->restore();

        return redirect()
            ->route('absensi.trash')
            ->with('success', 'Absensi berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $absensi = Absensi::onlyTrashed()->findOrFail($id);
        $absensi->forceDelete();

        return redirect()
            ->route('absensi.trash')
            ->with('success', 'Absensi berhasil dihapus permanen.');
    }
}