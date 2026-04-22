<?php

namespace App\Http\Controllers;

use App\Http\Requests\JurusanRequest;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JurusanController extends Controller
{
    
    public function index(): View
    {
        $jurusans = Jurusan::latest()->paginate(10);

        return view('jurusan.index', compact('jurusans'));
    }

    public function create(): View
    {
        return view('jurusan.create');
    }

    public function store(JurusanRequest $request): RedirectResponse
    {
        Jurusan::create($request->validated());

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function show(Jurusan $jurusan): View
    {
        return view('jurusan.show', compact('jurusan'));
    }

    public function edit(Jurusan $jurusan): View
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(JurusanRequest $request, Jurusan $jurusan): RedirectResponse
    {
        $jurusan->update($request->validated());

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan): RedirectResponse
    {
        $jurusan->delete();

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }

    public function trash(): View
    {
        $jurusans = Jurusan::onlyTrashed()->latest()->paginate(10);

        return view('jurusan.trash', compact('jurusans'));
    }

    public function restore(int $id): RedirectResponse
    {
        $jurusan = Jurusan::onlyTrashed()->findOrFail($id);
        $jurusan->restore();

        return redirect()
            ->route('jurusan.trash')
            ->with('success', 'Jurusan berhasil dipulihkan.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $jurusan = Jurusan::onlyTrashed()->findOrFail($id);
        $jurusan->forceDelete();

        return redirect()
            ->route('jurusan.trash')
            ->with('success', 'Jurusan berhasil dihapus permanen.');
    }
}