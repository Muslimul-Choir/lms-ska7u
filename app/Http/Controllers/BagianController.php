<?php

namespace App\Http\Controllers;

use App\Http\Requests\BagianRequest;
use App\Models\Bagian;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BagianController extends Controller
{
   
    public function index(): View
    {
        $search = request('search');

        $bagians = Bagian::when($search, function ($query, $search) {
                return $query->where('nama_bagian', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString(); // biar search tidak hilang saat pagination

        return view('bagian.index', compact('bagians', 'search'));
    }

    public function create(): View
    {
        return view('bagian.create');
    }

    public function store(BagianRequest $request): RedirectResponse
    {
        Bagian::create($request->validated());

        return redirect()
            ->route('bagian.index')
            ->with('success', 'Bagian berhasil ditambahkan.');
    }

    public function show(Bagian $bagian): View
    {
        return view('bagian.show', compact('bagian'));
    }

    public function edit(Bagian $bagian): View
    {
        return view('bagian.edit', compact('bagian'));
    }

    public function update(BagianRequest $request, Bagian $bagian): RedirectResponse
    {
        $bagian->update($request->validated());

        return redirect()
            ->route('bagian.index')
            ->with('success', 'Bagian berhasil diperbarui.');
    }

    public function destroy(Bagian $bagian): RedirectResponse
    {
        $bagian->delete();

        return redirect()
            ->route('bagian.index')
            ->with('success', 'Bagian berhasil dihapus.');
    }

    public function trash(): View
    {
        $bagians = Bagian::onlyTrashed()->latest()->paginate(10);

        return view('bagian.trash', compact('bagians'));
    }

    public function restore(Bagian $bagian): RedirectResponse
    {
        $bagian->restore();

        return redirect()
            ->route('bagian.trash')
            ->with('success', 'Bagian berhasil dipulihkan.');
    }

    public function forceDelete(Bagian $bagian): RedirectResponse
    {
        $bagian->forceDelete();

        return redirect()
            ->route('bagian.trash')
            ->with('success', 'Bagian berhasil dihapus permanen.');
    }
}