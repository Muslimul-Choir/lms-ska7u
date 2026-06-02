<?php

namespace App\Http\Controllers;

use App\Http\Requests\Semester\StoreSemesterRequest;
use App\Http\Requests\Semester\UpdateSemesterRequest;
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

        $trashCount = Semester::onlyTrashed()->count();

        if ($request->ajax()) {
            return response()->json([
                'semesters' => $semesters->items(),
                'pagination' => $semesters->links()->toHtml(),
                'total' => $semesters->total()
            ]);
        }

        $tahunAjarans = TahunAjaran::all();

        return view('semester.index', compact(
            'semesters',
            'search',
            'tahunAjarans',
            'tahun_ajaran_filter',
            'trashCount'
        ));
    }

    public function create(): View
    {
        return view('semester.create');
    }

    public function store(StoreSemesterRequest $request): RedirectResponse
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

    public function update(
        UpdateSemesterRequest $request,
        Semester $semester
    ): RedirectResponse {
        $semester->update($request->validated());

        return redirect()
            ->route('semester.index')
            ->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        if ($semester->GuruMapels()->exists()) {
            return redirect()
                ->route('semester.index')
                ->with('error', 'Semester tidak dapat dihapus karena masih digunakan di guru mapel. Hapus atau ubah data terkait terlebih dahulu.');
        }

        $semester->delete();

        return redirect()
            ->route('semester.index')
            ->with('success', 'Semester berhasil dipindahkan ke arsip.');
    }

    public function trash(): View
    {
        $semesters = Semester::with('tahunAjaran')
            ->onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

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

    public function restoreAll(): RedirectResponse
    {
        Semester::onlyTrashed()->restore();

        return redirect()
            ->route('semester.trash')
            ->with('success', 'Semua data semester berhasil dipulihkan.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        Semester::onlyTrashed()->forceDelete();

        return redirect()
            ->route('semester.trash')
            ->with('success', 'Semua data semester berhasil dihapus permanen.');
    }
}