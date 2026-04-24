<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Http\Requests\MapelRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $mapels = Mapel::when($search, function ($query, $search) {
                return $query->where('nama_mapel', 'like', '%' . $search . '%')
                             ->orWhere('kode_mapel', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(4)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'mapels' => $mapels->items(),
                'pagination' => $mapels->links()->toHtml(),
                'total' => $mapels->total()
            ]);
        }

        return view('mapel.index', compact('mapels', 'search'));
    }

    public function create(): View
    {
        return view('mapel.create');
    }

    public function store(MapelRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mapel', 'public');
        }

        Mapel::create($data);

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(Mapel $mapel): View
    {
        return view('mapel.show', compact('mapel'));
    }

    public function edit(Mapel $mapel): View
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(MapelRequest $request, Mapel $mapel): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($mapel->foto && Storage::disk('public')->exists($mapel->foto)) {
                Storage::disk('public')->delete($mapel->foto);
            }
            $data['foto'] = $request->file('foto')->store('mapel', 'public');
        }

        $mapel->update($data);

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel): RedirectResponse
    {
        $mapel->delete();

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    public function trash(): View
    {
        $mapels = Mapel::onlyTrashed()->latest()->paginate(10);

        return view('mapel.trash', compact('mapels'));
    }

    public function restore(Mapel $mapel): RedirectResponse
    {
        $mapel->restore();

        return redirect()
            ->route('mapel.trash')
            ->with('success', 'Mata pelajaran berhasil dipulihkan.');
    }

    public function forceDelete(Mapel $mapel): RedirectResponse
    {
        // Hapus foto jika ada
        if ($mapel->foto && Storage::disk('public')->exists($mapel->foto)) {
            Storage::disk('public')->delete($mapel->foto);
        }

        $mapel->forceDelete();

        return redirect()
            ->route('mapel.trash')
            ->with('success', 'Mata pelajaran berhasil dihapus permanen.');
    }
}