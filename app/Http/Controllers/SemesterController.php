<?php

namespace App\Http\Controllers;

use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SemesterController extends Controller
{
    public function index(): View
    {
        $semesters = Semester::latest()->paginate(5);

        return view('semester.index', compact('semesters'));
    }

    public function create(): View
    {
        return view('semester.create');
    }

    public function store(SemesterRequest $request): RedirectResponse
    {
        Semester::create($request->validated());

        return redirect()
            ->route('semester.index')
            ->with('success', 'Semester berhasil ditambahkan.');
    }

    public function show(Semester $semester): View
    {
        return view('semester.show', compact('semester'));
    }

    public function edit(Semester $semester): View
    {
        return view('semester.edit', compact('semester'));
    }

    public function update(SemesterRequest $request, Semester $semester): RedirectResponse
    {
        $semester->update($request->validated());

        return redirect()
            ->route('semester.index')
            ->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        $semester->delete();

        return redirect()
            ->route('semester.index')
            ->with('success', 'Semester berhasil dihapus.');
    }

    public function trash(): View
    {
        $semesters = Semester::onlyTrashed()->latest()->paginate(10);

        return view('semester.trash', compact('semesters'));
    }

    public function restore(int $id): RedirectResponse
    {
        $semester = Semester::onlyTrashed()->findOrFail($id);
        $semester->restore();

        return redirect()
            ->route('semester.trash')
            ->with('success', 'Semester berhasil dipulihkan.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $semester = Semester::onlyTrashed()->findOrFail($id);
        $semester->forceDelete();

        return redirect()
            ->route('semester.trash')
            ->with('success', 'Semester berhasil dihapus permanen.');
    }
}