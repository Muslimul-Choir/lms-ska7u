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
        ->when($filterTingkatan, fn($q) => $q->where('id_tingkatan', $filterTingkatan))
        ->orderBy('id_tingkatan')
        ->orderBy('jam_mulai')
        ->get();

    $groupedJamBelajar = $jamBelajars
        ->groupBy(fn($item) => $item->tingkatan?->nama_tingkatan ?? 'Tanpa Tingkatan')
        ->map(fn($items) => $items->values()->mapWithKeys(fn($item, $i) => [$i + 1 => $item]));

    $maxJam = max($groupedJamBelajar->map->count()->max() ?? 0, 5);
    $jamKe  = collect(range(1, $maxJam))->mapWithKeys(fn($n) => [$n => "Jam ke-{$n}"]);

    $tahunAktif = '2025/2026';

    return view('jambelajar.index', compact(
        'jamBelajars',
        'groupedJamBelajar',
        'jamKe',
        'tahunAktif',
        'tingkatanList',
        'filterTingkatan',
    ));
}

    public function store(StoreJamBelajarRequest $request): RedirectResponse
    {
        JamBelajar::create($request->validated());

        return redirect()->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil ditambahkan');
    }

    public function update(UpdateJamBelajarRequest $request, JamBelajar $jambelajar): RedirectResponse
    {
        $jambelajar->update($request->validated());

        return redirect()->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil diupdate');
    }

    public function destroy(JamBelajar $jambelajar): RedirectResponse
    {
        $jambelajar->delete();

        return redirect()->route('jambelajar.index')
            ->with('success', 'Jam belajar berhasil dihapus');
    }

    public function trash(Request $request): View
{
    $tingkatanList   = Tingkatan::orderBy('nama_tingkatan')->get();
    $filterTingkatan = $request->get('tingkatan');

    $jamBelajars = JamBelajar::onlyTrashed()
        ->with('tingkatan')
        ->when($filterTingkatan, fn($q) => $q->where('id_tingkatan', $filterTingkatan))
        ->orderBy('id_tingkatan')
        ->orderBy('jam_mulai')
        ->paginate(10);

    return view('jambelajar.trash', compact('jamBelajars', 'tingkatanList', 'filterTingkatan'));
}

    public function restore(JamBelajar $jambelajar): RedirectResponse
    {
        $jambelajar->restore();

        return redirect()->route('jambelajar.trash')
            ->with('success', 'Data berhasil dipulihkan');
    }

    public function forceDelete(JamBelajar $jambelajar): RedirectResponse
    {
        $jambelajar->forceDelete();

        return redirect()->route('jambelajar.trash')
            ->with('success', 'Data berhasil dihapus permanen');
    }
}