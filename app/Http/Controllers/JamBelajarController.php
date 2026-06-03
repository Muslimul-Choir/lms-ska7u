<?php

namespace App\Http\Controllers;

use App\Models\JamBelajar;
use App\Models\Tingkatan;
use App\Http\Requests\JamBelajar\StoreJamBelajarRequest;
use App\Http\Requests\JamBelajar\UpdateJamBelajarRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JamBelajarController extends Controller
{
    public function index(Request $request): View
    {
        $tingkatanList = Tingkatan::orderBy('nama_tingkatan')->get();
        $filterTingkatan = $request->get('tingkatan');

        $jamBelajars = JamBelajar::with('tingkatan')
            ->when($filterTingkatan, function ($query) use ($filterTingkatan) {
                $query->where('id_tingkatan', $filterTingkatan);
            })
            ->orderBy('id_tingkatan')
            ->orderBy('jam_mulai')
            ->get();

        $groupedJamBelajar = $jamBelajars
            ->groupBy(fn($item) => $item->tingkatan?->nama_tingkatan ?? 'Tanpa Tingkatan')
            ->map(fn($items) => $items->values()->mapWithKeys(
                fn($item, $i) => [$i + 1 => $item]
            ));

        $maxJam = max(
            $groupedJamBelajar->map->count()->max() ?? 0,
            5
        );

        $jamKe = collect(range(1, $maxJam))
            ->mapWithKeys(fn($n) => [$n => "Jam ke-{$n}"]);

        $tahunAktif = '2025/2026';

        $trashCount = JamBelajar::onlyTrashed()->count();

        return view('jambelajar.index', compact(
            'jamBelajars',
            'groupedJamBelajar',
            'jamKe',
            'tahunAktif',
            'tingkatanList',
            'filterTingkatan',
            'trashCount'
        ));
    }

    public function store(StoreJamBelajarRequest $request): RedirectResponse
{
    $exists = JamBelajar::where('id_tingkatan', $request->id_tingkatan)
        ->where('jam_mulai', $request->jam_mulai)
        ->where('jam_selesai', $request->jam_selesai)
        ->exists();

    if ($exists) {
        return redirect()
            ->route('jambelajar.index')
            ->withInput()
            ->with('error', 'Jam belajar dengan tingkatan dan waktu yang sama sudah tersedia.');
    }

    JamBelajar::create($request->validated());

    return redirect()
        ->route('jambelajar.index')
        ->with('success', 'Jam belajar berhasil ditambahkan.');
}

    public function update(
        UpdateJamBelajarRequest $request,
        JamBelajar $jambelajar
    ): RedirectResponse {
        $jambelajar->update($request->validated());

        return redirect()
            ->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil diperbarui.');
    }

    public function destroy(JamBelajar $jambelajar): RedirectResponse
    {
        if ($jambelajar->JadwalBelajars()->exists()) {
            return redirect()
                ->route('jambelajar.index')
                ->with(
                    'error',
                    'Jam belajar tidak dapat dihapus karena masih digunakan pada jadwal belajar.'
                );
        }

        $jambelajar->delete();

        return redirect()
            ->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil dipindahkan ke arsip.');
    }

    public function trash(Request $request): View
    {
        $tingkatanList = Tingkatan::orderBy('nama_tingkatan')->get();
        $filterTingkatan = $request->get('tingkatan');

        $jamBelajars = JamBelajar::onlyTrashed()
            ->with('tingkatan')
            ->when($filterTingkatan, function ($query) use ($filterTingkatan) {
                $query->where('id_tingkatan', $filterTingkatan);
            })
            ->latest('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('jambelajar.trash', compact(
            'jamBelajars',
            'tingkatanList',
            'filterTingkatan'
        ));
    }

    public function restore($id): RedirectResponse
    {
        JamBelajar::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('jambelajar.trash')
            ->with('success', 'Jam belajar berhasil dipulihkan.');
    }

    public function restoreAll(): RedirectResponse
    {
        JamBelajar::onlyTrashed()->restore();

        return redirect()
            ->route('jambelajar.trash')
            ->with('success', 'Semua jam belajar berhasil dipulihkan.');
    }

    public function forceDelete($id): RedirectResponse
    {
        JamBelajar::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return redirect()
            ->route('jambelajar.trash')
            ->with('success', 'Jam belajar berhasil dihapus permanen.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        JamBelajar::onlyTrashed()->forceDelete();

        return redirect()
            ->route('jambelajar.trash')
            ->with('success', 'Semua jam belajar berhasil dihapus permanen.');
    }
}