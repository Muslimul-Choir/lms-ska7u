<?php

namespace App\Http\Controllers;

use App\Http\Requests\TahunAjaran\StoreTahunAjaranRequest;
use App\Http\Requests\TahunAjaran\UpdateTahunAjaranRequest;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $tahunAjarans = TahunAjaran::when($search, function ($query, $search) {
                return $query->where('nama_tahun', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'tahunAjarans' => $tahunAjarans->items(),
                'pagination' => $tahunAjarans->links()->toHtml(),
                'total' => $tahunAjarans->total()
            ]);
        }

        return view('tahunajaran.index', compact('tahunAjarans', 'search'));
    }

    public function create(): View
    {
        return view('tahunajaran.create');
    }

    public function store(StoreTahunAjaranRequest $request): RedirectResponse
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

    public function update(UpdateTahunAjaranRequest $request, TahunAjaran $tahunajaran): RedirectResponse
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

    public function restore(TahunAjaran $tahunajaran): RedirectResponse
    {
        $tahunajaran->restore();

        return redirect()
            ->route('tahunajaran.trash')
            ->with('success', 'Tahun ajaran berhasil dipulihkan.');
    }

    public function forceDelete(TahunAjaran $tahunajaran): RedirectResponse
    {
        $tahunajaran->forceDelete();

        return redirect()
            ->route('tahunajaran.trash')
            ->with('success', 'Tahun ajaran berhasil dihapus permanen.');
    }
}