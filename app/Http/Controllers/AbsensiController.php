<?php

namespace App\Http\Controllers;

use App\Http\Requests\Absensi\StoreAbsensiRequest;
use App\Http\Requests\Absensi\UpdateAbsensiRequest;
use App\Models\Absensi;
use App\Models\GuruMapel;
use App\Models\Pertemuan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $search           = $request->get('search');
        $pertemuan_filter = $request->get('id_pertemuan');
        $status_filter    = $request->get('status');

        $absensis = Absensi::with(['pertemuan', 'siswa'])
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($pertemuan_filter, fn($q) => $q->where('id_pertemuan', $pertemuan_filter))
            ->when($status_filter,    fn($q) => $q->where('status', $status_filter))
            ->when($isGuru, function ($query) use ($user) {
                $query->whereHas(
                    'pertemuan.jadwalBelajar.guruMapel',
                    fn($q) => $q->where('id_guru', $user->guru->id)
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $trashCount = Absensi::onlyTrashed()->count();

        if ($request->ajax()) {
            return response()->json([
                'absensis'   => $absensis->items(),
                'pagination' => $absensis->links()->toHtml(),
                'total'      => $absensis->total(),
            ]);
        }

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery     = Siswa::query();

        if ($isGuru) {
            $guru    = $user->guru;
            $kelasIds = GuruMapel::where('id_guru', $guru->id)->pluck('id_kelas')->unique();

            $pertemuanQuery->whereHas(
                'jadwalBelajar.guruMapel',
                fn($q) => $q->where('id_guru', $guru->id)
            );
            $siswaQuery->whereIn('id_kelas', $kelasIds);
        }

        $pertemuans = $pertemuanQuery->get();
        $siswas     = $siswaQuery->get();

        return view('absensi.index', compact(
            'absensis', 'search', 'pertemuans', 'siswas',
            'pertemuan_filter', 'status_filter', 'trashCount'
        ));
    }

    public function create(): View
    {
        $user   = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery     = Siswa::query();

        if ($isGuru) {
            $guru    = $user->guru;
            $kelasIds = GuruMapel::where('id_guru', $guru->id)->pluck('id_kelas')->unique();

            $pertemuanQuery->whereHas(
                'jadwalBelajar.guruMapel',
                fn($q) => $q->where('id_guru', $guru->id)
            );
            $siswaQuery->whereIn('id_kelas', $kelasIds);
        }

        return view('absensi.create', [
            'pertemuans' => $pertemuanQuery->get(),
            'siswas'     => $siswaQuery->get(),
        ]);
    }

    public function store(StoreAbsensiRequest $request): RedirectResponse
    {
        Absensi::create($request->validated());

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function show(Absensi $absensi): View
    {
        $absensi->load(['pertemuan', 'siswa']);

        return view('absensi.show', compact('absensi'));
    }

    public function edit(Absensi $absensi): View
    {
        $user   = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $pertemuanQuery = Pertemuan::query();
        $siswaQuery     = Siswa::query();

        if ($isGuru) {
            $guru    = $user->guru;
            $kelasIds = GuruMapel::where('id_guru', $guru->id)->pluck('id_kelas')->unique();

            $pertemuanQuery->whereHas(
                'jadwalBelajar.guruMapel',
                fn($q) => $q->where('id_guru', $guru->id)
            );
            $siswaQuery->whereIn('id_kelas', $kelasIds);
        }

        return view('absensi.edit', [
            'absensi'    => $absensi,
            'pertemuans' => $pertemuanQuery->get(),
            'siswas'     => $siswaQuery->get(),
        ]);
    }

    public function update(UpdateAbsensiRequest $request, Absensi $absensi): RedirectResponse
    {
        $absensi->update($request->validated());

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi): RedirectResponse
    {
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dipindahkan ke arsip.');
    }

    // ─── Trash ────────────────────────────────────────────────────────────────

    public function trash(Request $request): View
    {
        $search           = $request->get('search');
        $pertemuan_filter = $request->get('id_pertemuan');
        $status_filter    = $request->get('status');

        $absensis = Absensi::onlyTrashed()
            ->with(['pertemuan', 'siswa'])
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($pertemuan_filter, fn($q) => $q->where('id_pertemuan', $pertemuan_filter))
            ->when($status_filter,    fn($q) => $q->where('status', $status_filter))
            ->latest('deleted_at')
            ->paginate(10)
            ->withQueryString();

        // Daftar pertemuan untuk dropdown filter (semua, tidak dibatasi per guru)
        $pertemuans = Pertemuan::orderBy('nomor_pertemuan')->get();

        return view('absensi.trash', compact(
            'absensis', 'search', 'pertemuans',
            'pertemuan_filter', 'status_filter'
        ));
    }

    public function restore(string $id): RedirectResponse
    {
        Absensi::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('absensi.trash')->with('success', 'Absensi berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        Absensi::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('absensi.trash')->with('success', 'Absensi berhasil dihapus permanen.');
    }

    public function restoreAll(): RedirectResponse
    {
        Absensi::onlyTrashed()->restore();

        return redirect()->route('absensi.trash')->with('success', 'Semua data absensi berhasil dipulihkan.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        Absensi::onlyTrashed()->forceDelete();

        return redirect()->route('absensi.trash')->with('success', 'Semua data absensi berhasil dihapus permanen.');
    }
}