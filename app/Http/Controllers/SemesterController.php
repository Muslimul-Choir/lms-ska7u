<?php

namespace App\Http\Controllers;

use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tahun_ajaran_filter = $request->get('tahun_ajaran');

        $semesters = Semester::with('tahunAjaran')
            ->when($search, function ($query, $search) {
                return $query->where('nama_semester', 'like', '%' . $search . '%');
            })
            ->when($tahun_ajaran_filter, function ($query, $tahun_ajaran_filter) {
                return $query->where('id_tahun_ajaran', $tahun_ajaran_filter);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'semesters' => $semesters->items(),
                'pagination' => $semesters->links()->toHtml(),
                'total' => $semesters->total()
            ]);
        }

        $tahunAjarans = TahunAjaran::all();

        return view('semester.index', compact('semesters', 'search', 'tahunAjarans', 'tahun_ajaran_filter'));
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

    public function restore(Semester $semester): RedirectResponse
    {
        $semester->restore();

        return redirect()
            ->route('semester.trash')
            ->with('success', 'Semester berhasil dipulihkan.');
    }

    public function forceDelete(Semester $semester): RedirectResponse
    {
        $semester->forceDelete();

        return redirect()
            ->route('semester.trash')
            ->with('success', 'Semester berhasil dihapus permanen.');
    }
}