<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tingkatan\StoreTingkatanRequest;
use App\Http\Requests\Tingkatan\UpdateTingkatanRequest;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TingkatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $tingkatans = Tingkatan::when($search, function ($query, $search) {
                return $query->where('nama_tingkatan', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $trashCount = Tingkatan::onlyTrashed()->count();

        if ($request->ajax()) {
            return response()->json([
                'tingkatans' => $tingkatans->items(),
                'pagination' => $tingkatans->links()->toHtml(),
                'total' => $tingkatans->total()
            ]);
        }

        return view('tingkatan.index', compact(
            'tingkatans',
            'search',
            'trashCount'
        ));
    }

    public function create(): View
    {
        return view('tingkatan.create');
    }

    public function store(StoreTingkatanRequest $request): RedirectResponse
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

    public function update(
        UpdateTingkatanRequest $request,
        Tingkatan $tingkatan
    ): RedirectResponse {
        $tingkatan->update($request->validated());

        return redirect()
            ->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil diperbarui.');
    }

    public function destroy(Tingkatan $tingkatan): RedirectResponse
    {
        if ($tingkatan->Kelas()->exists() || $tingkatan->JamBelajars()->exists()) {
            return redirect()
                ->route('tingkatan.index')
                ->with('error', 'Tingkatan tidak dapat dihapus karena masih digunakan di kelas atau jam belajar. Hapus atau ubah data terkait terlebih dahulu.');
        }

        $tingkatan->delete();

        return redirect()
            ->route('tingkatan.index')
            ->with('success', 'Tingkatan berhasil dipindahkan ke arsip.');
    }

    public function trash(): View
    {
        $tingkatans = Tingkatan::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

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

    public function restoreAll(): RedirectResponse
    {
        Tingkatan::onlyTrashed()->restore();

        return redirect()
            ->route('tingkatan.trash')
            ->with('success', 'Semua data tingkatan berhasil dipulihkan.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        Tingkatan::onlyTrashed()->forceDelete();

        return redirect()
            ->route('tingkatan.trash')
            ->with('success', 'Semua data tingkatan berhasil dihapus permanen.');
    }
}