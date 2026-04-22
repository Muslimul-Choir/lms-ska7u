<?php

namespace App\Http\Controllers;

use App\Http\Requests\TahunAjaranRequest;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TahunAjaranController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $tahunAjarans = TahunAjaran::when($search, function ($query, $search) {
                return $query->where('nama_tahun_ajaran', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('tahunajaran.index', compact('tahunAjarans', 'search'));
    }

    public function create(): View
    {
        return view('tahunajaran.create');
    }

    public function store(TahunAjaranRequest $request): RedirectResponse
    {
        TahunAjaran::create($request->validated());

        return redirect()
            ->route('tahunajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function show(TahunAjaran $tahunajaran): View
    {
        return view('tahunajaran.show', compact('tahunajaran'));
    }

    public function edit(TahunAjaran $tahunajaran): View
    {
        return view('tahunajaran.edit', compact('tahunajaran'));
    }

    public function update(TahunAjaranRequest $request, TahunAjaran $tahunajaran): RedirectResponse
    {
        $tahunajaran->update($request->validated());

        return redirect()
            ->route('tahunajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunajaran): RedirectResponse
    {
        $tahunajaran->delete();

        return redirect()
            ->route('tahunajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function trash(): View
    {
        $tahunAjarans = TahunAjaran::onlyTrashed()->latest()->paginate(10);

        return view('tahunajaran.trash', compact('tahunAjarans'));
    }

    public function restore(int $id): RedirectResponse
    {
        $tahunajaran = TahunAjaran::onlyTrashed()->findOrFail($id);
        $tahunajaran->restore();

        return redirect()
            ->route('tahunajaran.trash')
            ->with('success', 'Tahun ajaran berhasil dipulihkan.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $tahunajaran = TahunAjaran::onlyTrashed()->findOrFail($id);
        $tahunajaran->forceDelete();

        return redirect()
            ->route('tahunajaran.trash')
            ->with('success', 'Tahun ajaran berhasil dihapus permanen.');
    }
}