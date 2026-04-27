<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pertemuan\StorePertemuanRequest;
use App\Http\Requests\Pertemuan\UpdatePertemuanRequest;
use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PertemuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $jadwal_filter = $request->get('id_jadwal');
        $status_filter = $request->get('status');

        $pertemuans = Pertemuan::with('jadwalBelajar')
            ->when($search, function ($query, $search) {
                return $query->where('nomor_pertemuan', 'like', '%' . $search . '%')
                             ->orWhere('tanggal', 'like', '%' . $search . '%');
            })
            ->when($jadwal_filter, function ($query, $jadwal_filter) {
                return $query->where('id_jadwal', $jadwal_filter);
            })
            ->when($status_filter, function ($query, $status_filter) {
                return $query->where('status', $status_filter);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'pertemuans'  => $pertemuans->items(),
                'pagination'  => $pertemuans->links()->toHtml(),
                'total'       => $pertemuans->total(),
            ]);
        }

        $jadwalBelajars = JadwalBelajar::all();

        return view('pertemuan.index', compact(
            'pertemuans',
            'search',
            'jadwalBelajars',
            'jadwal_filter',
            'status_filter'
        ));
    }

    public function create(): View
    {
        $jadwalBelajars = JadwalBelajar::all();

        return view('pertemuan.create', compact('jadwalBelajars'));
    }

    public function store(StorePertemuanRequest $request): RedirectResponse
    {
        Pertemuan::create($request->validated());

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function show(Pertemuan $pertemuan): View
    {
        $pertemuan->load('jadwalBelajar');

        return view('pertemuan.show', compact('pertemuan'));
    }

    public function edit(Pertemuan $pertemuan): View
    {
        $jadwalBelajars = JadwalBelajar::all();

        return view('pertemuan.edit', compact('pertemuan', 'jadwalBelajars'));
    }

    public function update(UpdatePertemuanRequest $request, Pertemuan $pertemuan): RedirectResponse
    {
        $pertemuan->update($request->validated());

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil diperbarui.');
    }

    public function destroy(Pertemuan $pertemuan): RedirectResponse
    {
        $pertemuan->delete();

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil dihapus.');
    }

    public function trash(): View
    {
        $pertemuans = Pertemuan::onlyTrashed()
            ->with('jadwalBelajar')
            ->latest()
            ->paginate(10);

        return view('pertemuan.trash', compact('pertemuans'));
    }

    public function restore(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);
        $pertemuan->restore();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);
        $pertemuan->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dihapus permanen.');
    }
}