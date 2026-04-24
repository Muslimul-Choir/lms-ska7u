<?php

namespace App\Http\Controllers;

use App\Http\Requests\TingkatanRequest;
use App\Models\Tingkatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TingkatanController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $tingkatans = Tingkatan::when($search, function ($query, $search) {
                return $query->where('nama_tingkatan', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('tingkatan.index', compact('tingkatans', 'search'));
    }

    public function create(): View
    {
        return view('tingkatan.create');
    }

    public function store(TingkatanRequest $request): RedirectResponse
    {
        Tingkatan::create($request->validated());

        return redirect()
            ->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil ditambahkan.');
    }

    public function show(Tingkatan $tingkatan): View
    {
        return view('tingkatan.show', compact('tingkatan'));
    }

    public function edit(Tingkatan $tingkatan): View
    {
        return view('tingkatan.edit', compact('tingkatan'));
    }

    public function update(TingkatanRequest $request, Tingkatan $tingkatan): RedirectResponse
    {
        $tingkatan->update($request->validated());

        return redirect()
            ->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil diperbarui.');
    }

    public function destroy(Tingkatan $tingkatan): RedirectResponse
    {
        $tingkatan->delete();

        return redirect()
            ->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil dihapus.');
    }

    public function trash(): View
    {
        $tingkatans = Tingkatan::onlyTrashed()->latest()->paginate(10);

        return view('tingkatan.trash', compact('tingkatans'));
    }

    public function restore(Tingkatan $tingkatan): RedirectResponse
    {
        $tingkatan->restore();

        return redirect()
            ->route('tingkatan.trash')
            ->with('success', 'Tingkatan berhasil dipulihkan.');
    }

    public function forceDelete(Tingkatan $tingkatan): RedirectResponse
    {
        $tingkatan->forceDelete();

        return redirect()
            ->route('tingkatan.trash')
            ->with('success', 'Tingkatan berhasil dihapus permanen.');
    }
}