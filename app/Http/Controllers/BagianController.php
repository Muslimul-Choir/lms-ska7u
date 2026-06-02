<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bagian\StoreBagianRequest;
use App\Http\Requests\Bagian\UpdateBagianRequest;
use App\Models\Bagian;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BagianController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\JsonResponse
    {
        $search = $request->get('search');

        $bagians = Bagian::when($search, function ($query, $search) {
                $query->where('nama_bagian', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $trashCount = Bagian::onlyTrashed()->count();

        if ($request->ajax()) {
            return response()->json([
                'bagians' => $bagians->items(),
                'pagination' => $bagians->links()->toHtml(),
                'total' => $bagians->total(),
            ]);
        }

        return view('bagian.index', compact(
            'bagians',
            'search',
            'trashCount'
        ));
    }

    public function create(): View
    {
        return view('bagian.create');
    }

    public function store(StoreBagianRequest $request): RedirectResponse
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

    public function update(
        UpdateBagianRequest $request,
        Bagian $bagian
    ): RedirectResponse {
        $bagian->update($request->validated());

        return redirect()
            ->route('bagian.index')
            ->with('success', 'Bagian berhasil diperbarui.');
    }

    public function destroy(Bagian $bagian): RedirectResponse
    {
        if ($bagian->Kelas()->exists()) {
            return redirect()
                ->route('bagian.index')
                ->with('error', 'Bagian tidak dapat dihapus karena masih digunakan oleh kelas. Hapus atau pindahkan kelas terkait terlebih dahulu.');
        }

        $bagian->delete();

        return redirect()
            ->route('bagian.index')
            ->with('success', 'Bagian berhasil dipindahkan ke arsip.');
    }

    public function trash(): View
    {
        $bagians = Bagian::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

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

    public function restoreAll(): RedirectResponse
    {
        Bagian::onlyTrashed()->restore();

        return redirect()
            ->route('bagian.trash')
            ->with('success', 'Semua data bagian berhasil dipulihkan.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        Bagian::onlyTrashed()->forceDelete();

        return redirect()
            ->route('bagian.trash')
            ->with('success', 'Semua data bagian berhasil dihapus permanen.');
    }
}