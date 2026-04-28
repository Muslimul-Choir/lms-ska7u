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
        $search           = $request->get('search');
        $pertemuan_filter = $request->get('id_pertemuan');
        $status_filter    = $request->get('status');

        $absensis = Absensi::with(['pertemuan', 'siswa'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('nis', 'like', '%' . $search . '%');
                });
            })
            ->when($pertemuan_filter, function ($query, $pertemuan_filter) {
                return $query->where('id_pertemuan', $pertemuan_filter);
            })
            ->when($status_filter, function ($query, $status_filter) {
                return $query->where('status', $status_filter);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'absensis'   => $absensis->items(),
                'pagination' => $absensis->links()->toHtml(),
                'total'      => $absensis->total(),
            ]);
        }

        $pertemuans = Pertemuan::all();
        $siswas     = Siswa::all();

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
        $pertemuans = Pertemuan::all();
        $siswas     = Siswa::all();

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
        $pertemuans = Pertemuan::all();
        $siswas     = Siswa::all();

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