<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MapelController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $mapels = Mapel::when($search, function ($query, $search) {
                return $query->where('nama_mapel', 'like', '%' . $search . '%')
                             ->orWhere('kode_mapel', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('mapel.index', compact('mapels', 'search'));
    }

    public function create(): View
    {
        return view('mapel.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:50|unique:mapel,kode_mapel',
            'nama_mapel' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Mapel::create($request->all());

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(Mapel $mapel): View
    {
        return view('mapel.show', compact('mapel'));
    }

    public function edit(Mapel $mapel): View
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel): RedirectResponse
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:50|unique:mapel,kode_mapel,' . $mapel->id,
            'nama_mapel' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $mapel->update($request->all());

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel): RedirectResponse
    {
        $mapel->delete();

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    public function trash(): View
    {
        $mapels = Mapel::onlyTrashed()->latest()->paginate(10);

        return view('mapel.trash', compact('mapels'));
    }

    public function restore(int $id): RedirectResponse
    {
        $mapel = Mapel::onlyTrashed()->findOrFail($id);
        $mapel->restore();

        return redirect()
            ->route('mapel.trash')
            ->with('success', 'Mata pelajaran berhasil dipulihkan.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $mapel = Mapel::onlyTrashed()->findOrFail($id);
        $mapel->forceDelete();

        return redirect()
            ->route('mapel.trash')
            ->with('success', 'Mata pelajaran berhasil dihapus permanen.');
    }
}