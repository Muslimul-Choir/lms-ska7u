<?php

namespace App\Http\Controllers;

use App\Http\Requests\Jurusan\StoreJurusanRequest;
use App\Http\Requests\Jurusan\UpdateJurusanRequest;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JurusanController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->get('search');

        $jurusans = Jurusan::when($search, function ($query, $search) {
                return $query->where('nama_jurusan', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'jurusans' => $jurusans->items(),
                'pagination' => $jurusans->links()->toHtml(),
                'total' => $jurusans->total()
            ]);
        }

        return view('jurusan.index', compact('jurusans', 'search'));
    }

    public function create(): View
    {
        return view('jurusan.create');
    }

    public function store(StoreJurusanRequest $request): RedirectResponse
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

    public function update(UpdateJurusanRequest $request, Jurusan $jurusan): RedirectResponse
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

    public function restore(Jurusan $jurusan): RedirectResponse
    {
        $jurusan->restore();

        return redirect()
            ->route('jurusan.trash')
            ->with('success', 'Jurusan berhasil dipulihkan.');
    }

    public function forceDelete(Jurusan $jurusan): RedirectResponse
    {
        $jurusan->forceDelete();

        return redirect()
            ->route('jurusan.trash')
            ->with('success', 'Jurusan berhasil dihapus permanen.');
    }
}