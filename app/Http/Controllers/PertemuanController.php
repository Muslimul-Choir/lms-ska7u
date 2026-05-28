<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pertemuan\StorePertemuanRequest;
use App\Http\Requests\Pertemuan\UpdatePertemuanRequest;
use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PertemuanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;
        
        $search = $request->get('search');
        $jadwal_filter = $request->get('id_jadwal');
        $status_filter = $request->get('status');

        $pertemuanQuery = Pertemuan::with('jadwalBelajar')
            ->when($search, function ($query, $search) {
                return $query->where('nomor_pertemuan', 'like', '%' . $search . '%')
                             ->orWhere('tanggal', 'like', '%' . $search . '%');
            })
            ->when($jadwal_filter, function ($query, $jadwal_filter) {
                return $query->where('id_jadwal', $jadwal_filter);
            })
            ->when($status_filter, function ($query, $status_filter) {
                return $query->where('status', $status_filter);
            });

        if ($isGuru) {
            $guru = $user->guru;
            $pertemuanQuery->where('id_guru', $guru->id);
        }

        $pertemuans = $pertemuanQuery->latest()
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'pertemuans'  => $pertemuans->items(),
                'pagination'  => $pertemuans->links()->toHtml(),
                'total'       => $pertemuans->total(),
            ]);
        }

        $jadwalQuery = JadwalBelajar::query();
        if ($isGuru) {
            $guru = $user->guru;
            $jadwalQuery->whereHas('guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }
        $jadwalBelajars = $jadwalQuery->get();

        return view('pertemuan.index', compact(
            'pertemuans',
            'search',
            'jadwalBelajars',
            'jadwal_filter',
            'status_filter',
            'isGuru'
        ));
    }

    public function create(): View
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;
        
        $jadwalQuery = JadwalBelajar::query();
        if ($isGuru) {
            $guru = $user->guru;
            $jadwalQuery->whereHas('guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }
        $jadwalBelajars = $jadwalQuery->get();

        return view('pertemuan.create', compact('jadwalBelajars'));
    }

    public function store(StorePertemuanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $jadwal = JadwalBelajar::with('guruMapel')->findOrFail($data['id_jadwal']);
        $data['id_guru'] = $jadwal->guruMapel?->id_guru;
        $data['created_by'] = auth()->user()?->id;

        Pertemuan::create($data);

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function show(Pertemuan $pertemuan): View
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        // Guru hanya boleh lihat pertemuan milik mereka sendiri
        if ($isGuru) {
            $guru = $user->guru;
            if ($pertemuan->id_guru != $guru->id) {
                abort(403, 'Anda tidak berhak melihat pertemuan ini.');
            }
        }

        $pertemuan->load('jadwalBelajar');

        return view('pertemuan.show', compact('pertemuan'));
    }

    public function edit(Pertemuan $pertemuan): View
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        
        if ($isGuru) {
            $guru = $user->guru;
            if ($pertemuan->id_guru != $guru->id) {
                abort(403, 'Anda tidak berhak mengedit pertemuan ini.');
            }
        }
        
        $jadwalQuery = JadwalBelajar::query();
        if ($isGuru) {
            $guru = $user->guru;
            $jadwalQuery->whereHas('guruMapel', function($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }
        $jadwalBelajars = $jadwalQuery->get();

        return view('pertemuan.edit', compact('pertemuan', 'jadwalBelajars'));
    }

    public function update(UpdatePertemuanRequest $request, Pertemuan $pertemuan): RedirectResponse
    {
        $user = auth()->user();
        if ($user->role === 'guru' && $user->guru) {
            $guru = $user->guru;
            $isOwner = $pertemuan->id_guru == $guru->id;
            if (!$isOwner) {
                abort(403, 'Anda tidak berhak mengubah pertemuan ini.');
            }
        }

        $data = $request->validated();
        $jadwal = JadwalBelajar::with('guruMapel')->findOrFail($data['id_jadwal']);
        $data['id_guru'] = $jadwal->guruMapel?->id_guru;

        $pertemuan->update($data);

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil diperbarui.');
    }

    public function destroy(Pertemuan $pertemuan): RedirectResponse
    {
        $user = auth()->user();
        if ($user->role === 'guru' && $user->guru) {
            $guru = $user->guru;
            if ($pertemuan->id_guru != $guru->id) {
                abort(403, 'Anda tidak berhak menghapus pertemuan ini.');
            }
        }

        $pertemuan->delete();

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil dihapus.');
    }

    public function trash(): View
    {
        $user   = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $query = Pertemuan::onlyTrashed()->with('jadwalBelajar');

        if ($isGuru) {
            $guru = $user->guru;
            $query->where('id_guru', $guru->id);
        }

        $pertemuans = $query->latest()->paginate(10);

        return view('pertemuan.trash', compact('pertemuans'));
    }

    public function restore(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);
        
        $user = auth()->user();
        if ($user->role === 'guru' && $user->guru) {
            $guru = $user->guru;
            if ($pertemuan->id_guru != $guru->id) {
                abort(403, 'Anda tidak berhak memulihkan pertemuan ini.');
            }
        }
        
        $pertemuan->restore();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);
        
        $user = auth()->user();
        if ($user->role === 'guru' && $user->guru) {
            $guru = $user->guru;
            if ($pertemuan->id_guru != $guru->id) {
                abort(403, 'Anda tidak berhak menghapus permanen pertemuan ini.');
            }
        }
        
        $pertemuan->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dihapus permanen.');
    }
}