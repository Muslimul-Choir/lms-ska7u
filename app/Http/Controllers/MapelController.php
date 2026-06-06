<?php

namespace App\Http\Controllers;

use App\Http\Requests\Mapel\StoreMapelRequest;
use App\Http\Requests\Mapel\UpdateMapelRequest;
use App\Models\Mapel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class MapelController extends Controller
{
    public function index(Request $request): View
    {
        $query = Mapel::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                fn($q) =>
                $q->where('nama_mapel', 'like', "%{$search}%")
                    ->orWhere('kode_mapel', 'like', "%{$search}%")
            );
        }

        $mapels = $query
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $trashCount = Mapel::onlyTrashed()->count();

        return view('mapel.index', compact('mapels', 'trashCount'));
    }

    public function store(StoreMapelRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('mapel', 'public');
            }

            Mapel::create($data);

            return redirect()
                ->route('mapel.index')
                ->with('success', 'Mata pelajaran berhasil ditambahkan.');
        } catch (Throwable $e) {
            return redirect()
                ->route('mapel.index')
                ->with('error', 'Gagal menambahkan mata pelajaran. Silakan coba lagi.');
        }
    }

    public function update(UpdateMapelRequest $request, Mapel $mapel): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('foto')) {
                if ($mapel->foto && Storage::disk('public')->exists($mapel->foto)) {
                    Storage::disk('public')->delete($mapel->foto);
                }
                $data['foto'] = $request->file('foto')->store('mapel', 'public');
            }

            $mapel->update($data);

            return redirect()
                ->route('mapel.index')
                ->with('success', 'Mata pelajaran berhasil diperbarui.');
        } catch (Throwable $e) {
            return redirect()
                ->route('mapel.index')
                ->with('error', 'Gagal memperbarui mata pelajaran. Silakan coba lagi.');
        }
    }

    public function destroy(Mapel $mapel): RedirectResponse
    {
        $error = [];

        if ($mapel->GuruMapel()->exists()) {
            $error[] = 'masih memiliki ' . $mapel->GuruMapel()->count() . ' guru mapel';
        }

        if ($mapel->Tugas()->exists()) {
            $error[] = 'masih memiliki ' . $mapel->Tugas()->count() . ' tugas';
        }

        if ($mapel->JadwalBelajar()->exists()) {
            $error[] = 'masih memiliki ' . $mapel->JadwalBelajar()->count() . ' jadwal belajar';
        }

        if (!empty($error)) {
            return redirect()
                ->route('mapel.index')
                ->with('error', 'Mapel "' . $mapel->nama_mapel . '" tidak dapat dihapus karena ' . implode(', ', $error) . '.');
        }

        $mapel->delete();

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    public function trash(Request $request): View
    {
        $query = Mapel::onlyTrashed();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                fn($q) =>
                $q->where('nama_mapel', 'like', "%{$search}%")
                    ->orWhere('kode_mapel', 'like', "%{$search}%")
            );
        }

        $mapels = $query
            ->latest('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('mapel.trash', compact('mapels'));
    }

    // ─── Per-record: gunakan model binding (Route::bind sudah pakai withTrashed) ───

    public function restore(Mapel $mapel): RedirectResponse
    {
        try {
            $mapel->restore();

            return redirect()
                ->route('mapel.trash')
                ->with('success', 'Mata pelajaran "' . $mapel->nama_mapel . '" berhasil dipulihkan.');
        } catch (Throwable $e) {
            return redirect()
                ->route('mapel.trash')
                ->with('error', 'Gagal memulihkan mata pelajaran. Silakan coba lagi.');
        }
    }

    public function forceDelete(Mapel $mapel): RedirectResponse
    {
        try {
            if ($mapel->foto && Storage::disk('public')->exists($mapel->foto)) {
                Storage::disk('public')->delete($mapel->foto);
            }

            $mapel->forceDelete();

            return redirect()
                ->route('mapel.trash')
                ->with('success', 'Mata pelajaran "' . $mapel->nama_mapel . '" berhasil dihapus permanen.');
        } catch (Throwable $e) {
            return redirect()
                ->route('mapel.trash')
                ->with('error', 'Gagal menghapus mata pelajaran. Silakan coba lagi.');
        }
    }

    // ─── Bulk actions ────────────────────────────────────────────────────────────

    public function restoreAll(): RedirectResponse
    {
        try {
            $count = Mapel::onlyTrashed()->count();
            Mapel::onlyTrashed()->restore();

            return redirect()
                ->route('mapel.trash')
                ->with('success', $count . ' mata pelajaran berhasil dipulihkan.');
        } catch (Throwable $e) {
            return redirect()
                ->route('mapel.trash')
                ->with('error', 'Gagal memulihkan semua mata pelajaran. Silakan coba lagi.');
        }
    }

    public function forceDeleteAll(): RedirectResponse
    {
        try {
            $mapels = Mapel::onlyTrashed()->get();
            $count  = $mapels->count();

            foreach ($mapels as $mapel) {
                if ($mapel->foto && Storage::disk('public')->exists($mapel->foto)) {
                    Storage::disk('public')->delete($mapel->foto);
                }
                $mapel->forceDelete();
            }

            return redirect()
                ->route('mapel.trash')
                ->with('success', $count . ' mata pelajaran berhasil dihapus permanen.');
        } catch (Throwable $e) {
            return redirect()
                ->route('mapel.trash')
                ->with('error', 'Gagal menghapus semua mata pelajaran. Silakan coba lagi.');
        }
    }
}