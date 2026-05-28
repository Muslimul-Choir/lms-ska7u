<?php

namespace App\Http\Controllers;

use App\Models\JamBelajar;
use App\Http\Requests\JamBelajar\StoreJamBelajarRequest;
use App\Http\Requests\JamBelajar\UpdateJamBelajarRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JamBelajarController extends Controller
{
    public function index(Request $request): View
{
    $jamBelajars = JamBelajar::orderBy('jam_mulai')->get();

    $maxJam = max($jamBelajars->count() ?? 0, 5);
    $jamKe  = collect(range(1, $maxJam))->mapWithKeys(fn($n) => [$n => "Jam ke-{$n}"]);

    $tahunAktif = '2025/2026';

    return view('jambelajar.index', compact(
        'jamBelajars',
        'jamKe',
        'tahunAktif',
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
    $jamBelajars = JamBelajar::onlyTrashed()
        ->orderBy('jam_mulai')
        ->paginate(10);

    return view('jambelajar.trash', compact('jamBelajars'));
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