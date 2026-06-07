<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pertemuan\StorePertemuanRequest;
use App\Http\Requests\Pertemuan\UpdatePertemuanRequest;
use App\Models\Guru;
use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PertemuanController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $user         = auth()->user();
        $isGuru       = $user->role === 'guru' && $user->guru;
        $isAdmin      = $user->role === 'admin';
        $isSuperAdmin = $user->role === 'super_admin';

        $search       = $request->get('search');
        $statusFilter = $request->get('status');

        // ── GURU: tampilan tabel, hanya data milik sendiri ──────────────
        if ($isGuru) {
            $query = Pertemuan::with(['jadwalBelajar', 'guru'])
                ->where('id_guru', $user->guru->id);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_pertemuan', 'like', "%{$search}%")
                      ->orWhere('tanggal', 'like', "%{$search}%");
                });
            }

            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }

            $pertemuans = $query
                ->orderBy('id_jadwal')
                ->orderBy('nomor_pertemuan')
                ->paginate(5)           // ← 5 per halaman
                ->withQueryString();

            $trashCount = Pertemuan::onlyTrashed()
                ->where('id_guru', $user->guru->id)
                ->count();

            if ($request->ajax()) {
                return response()->json([
                    'pertemuans' => $pertemuans->items(),
                    'pagination' => $pertemuans->links()->toHtml(),
                    'total'      => $pertemuans->total(),
                ]);
            }

            $jadwalBelajars = $this->getJadwalBelajarByRole(true);

            return view('pertemuan.index', [
                'pertemuans'      => $pertemuans,
                'pertemuanByGuru' => collect(),
                'gurus'           => collect(),
                'search'          => $search,
                'jadwalBelajars'  => $jadwalBelajars,
                'statusFilter'    => $statusFilter,
                'isGuru'          => true,
                'isAdmin'         => false,
                'isSuperAdmin'    => false,
                'trashCount'      => $trashCount,
            ]);
        }

        // ── ADMIN / SUPER ADMIN: tampilan accordion per guru ─────────────
        $idGuruFilter = $request->get('id_guru');

        $query = Pertemuan::with(['jadwalBelajar', 'guru', 'creator'])
            ->orderBy('created_by')
            ->orderBy('id_jadwal')
            ->orderBy('nomor_pertemuan');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pertemuan', 'like', "%{$search}%")
                  ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        if ($idGuruFilter) {
            $query->where('id_guru', $idGuruFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $allPertemuans = $query->get();

        // Kelompokkan per id_guru
        $pertemuanByGuru = $allPertemuans
            ->groupBy('id_guru')
            ->map(function ($items, $guruId) {
                $guruModel = $items->first()?->guru;
                return [
                    'guru'       => $guruModel,
                    'guruUser'   => $guruModel?->user,
                    'pertemuans' => $items,
                ];
            });

        // Daftar guru untuk dropdown filter
        $guruIds = $allPertemuans->pluck('id_guru')->unique()->filter();
        $gurus   = Guru::with('user')->whereIn('id', $guruIds)->get();

        $trashCount = Pertemuan::onlyTrashed()->count();

        if ($request->ajax()) {
            return response()->json([
                'total' => $allPertemuans->count(),
            ]);
        }

        $jadwalBelajars = $this->getJadwalBelajarByRole(false);

        return view('pertemuan.index', [
            'pertemuans'      => collect(),
            'pertemuanByGuru' => $pertemuanByGuru,
            'gurus'           => $gurus,
            'search'          => $search,
            'jadwalBelajars'  => $jadwalBelajars,
            'idGuruFilter'    => $idGuruFilter,
            'statusFilter'    => $statusFilter,
            'isGuru'          => false,
            'isAdmin'         => $isAdmin,
            'isSuperAdmin'    => $isSuperAdmin,
            'trashCount'      => $trashCount,
        ]);
    }

    public function create(): View
    {
        $user   = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $jadwalBelajars = $this->getJadwalBelajarByRole($isGuru);

        return view('pertemuan.create', compact('jadwalBelajars'));
    }

    public function store(StorePertemuanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $exists = Pertemuan::where('id_jadwal', $data['id_jadwal'])
            ->where('nomor_pertemuan', $data['nomor_pertemuan'])
            ->exists();

        if ($exists) {
            return redirect()
                ->route('pertemuan.index')
                ->withInput()
                ->with('error', 'Nomor pertemuan pada jadwal tersebut sudah tersedia.');
        }

        $jadwal = JadwalBelajar::with('guruMapel')
            ->findOrFail($data['id_jadwal']);

        $data['id_guru']    = $jadwal->guruMapel?->id_guru;
        $data['created_by'] = auth()->id();

        Pertemuan::create($data);

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function show(Pertemuan $pertemuan): View
    {
        $this->authorizeGuru($pertemuan);

        $pertemuan->load(['jadwalBelajar', 'guru']);

        return view('pertemuan.show', compact('pertemuan'));
    }

    public function edit(Pertemuan $pertemuan): View
    {
        $this->authorizeGuru($pertemuan);

        $user   = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $jadwalBelajars = $this->getJadwalBelajarByRole($isGuru);

        return view('pertemuan.edit', compact('pertemuan', 'jadwalBelajars'));
    }

    public function update(
        UpdatePertemuanRequest $request,
        Pertemuan $pertemuan
    ): RedirectResponse {
        $this->authorizeGuru($pertemuan);

        $data = $request->validated();

        $exists = Pertemuan::where('id_jadwal', $data['id_jadwal'])
            ->where('nomor_pertemuan', $data['nomor_pertemuan'])
            ->where('id', '!=', $pertemuan->id)
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Nomor pertemuan pada jadwal tersebut sudah digunakan.');
        }

        $jadwal = JadwalBelajar::with('guruMapel')
            ->findOrFail($data['id_jadwal']);

        $data['id_guru'] = $jadwal->guruMapel?->id_guru;

        $pertemuan->update($data);

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil diperbarui.');
    }

    public function destroy(Pertemuan $pertemuan): RedirectResponse
    {
        $this->authorizeGuru($pertemuan);

        $pertemuan->delete();

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil dipindahkan ke arsip.');
    }

    public function trash(Request $request): View
{
    $user         = auth()->user();
    $isGuru       = $user->role === 'guru' && $user->guru;
    $isAdmin      = $user->role === 'admin';
    $isSuperAdmin = $user->role === 'super_admin';

    $search       = $request->get('search');
    $statusFilter = $request->get('status');

    // ── GURU: tabel paginated, hanya milik sendiri ──────────────────
    if ($isGuru) {
        $query = Pertemuan::onlyTrashed()
            ->with(['jadwalBelajar', 'guru'])
            ->where('id_guru', $user->guru->id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pertemuan', 'like', "%{$search}%")
                  ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $pertemuans = $query
            ->latest('deleted_at')
            ->paginate(5)
            ->withQueryString();

        return view('pertemuan.trash', [
            'pertemuans'   => $pertemuans,
            'trashByGuru'  => collect(),
            'gurus'        => collect(),
            'search'       => $search,
            'statusFilter' => $statusFilter,
            'isGuru'       => true,
            'isAdmin'      => false,
            'isSuperAdmin' => false,
        ]);
    }

    // ── ADMIN / SUPER ADMIN: accordion per guru ─────────────────────
    $idGuruFilter = $request->get('id_guru');

    $query = Pertemuan::onlyTrashed()
        ->with(['jadwalBelajar', 'guru'])
        ->orderBy('id_guru')
        ->latest('deleted_at');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nomor_pertemuan', 'like', "%{$search}%")
              ->orWhere('tanggal', 'like', "%{$search}%");
        });
    }

    if ($idGuruFilter) {
        $query->where('id_guru', $idGuruFilter);
    }

    if ($statusFilter) {
        $query->where('status', $statusFilter);
    }

    $allTrashed = $query->get();

    // Kelompokkan per id_guru — sama persis seperti index
    $trashByGuru = $allTrashed
        ->groupBy('id_guru')
        ->map(function ($items, $guruId) {
            $guruModel = $items->first()?->guru;
            return [
                'guru'       => $guruModel,
                'guruUser'   => $guruModel?->user,
                'pertemuans' => $items,
            ];
        });

    // Daftar guru untuk dropdown filter
    $guruIds = $allTrashed->pluck('id_guru')->unique()->filter();
    $gurus   = Guru::with('user')->whereIn('id', $guruIds)->get();

    return view('pertemuan.trash', [
        'pertemuans'   => collect(),
        'trashByGuru'  => $trashByGuru,
        'gurus'        => $gurus,
        'search'       => $search,
        'idGuruFilter' => $idGuruFilter,
        'statusFilter' => $statusFilter,
        'isGuru'       => false,
        'isAdmin'      => $isAdmin,
        'isSuperAdmin' => $isSuperAdmin,
    ]);
}

    public function restore(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);

        $this->authorizeGuru($pertemuan);

        $pertemuan->restore();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);

        $this->authorizeGuru($pertemuan);

        $pertemuan->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dihapus permanen.');
    }

    public function restoreAll(): RedirectResponse
    {
        $user  = auth()->user();
        $query = Pertemuan::onlyTrashed();

        if ($user->role === 'guru' && $user->guru) {
            $query->where('id_guru', $user->guru->id);
        }

        $query->restore();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Semua data pertemuan berhasil dipulihkan.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        $user  = auth()->user();
        $query = Pertemuan::onlyTrashed();

        if ($user->role === 'guru' && $user->guru) {
            $query->where('id_guru', $user->guru->id);
        }

        $query->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Semua data pertemuan berhasil dihapus permanen.');
    }

    // ── Private Helpers ──────────────────────────────────────────────────

    private function getJadwalBelajarByRole(bool $isGuru)
    {
        $query = JadwalBelajar::with(['guruMapel', 'kelas']);

        if ($isGuru) {
            $guru = auth()->user()->guru;
            $query->whereHas('guruMapel', function ($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }

        return $query->get();
    }

    private function authorizeGuru(Pertemuan $pertemuan): void
    {
        $user = auth()->user();

        if (
            $user->role === 'guru' &&
            $user->guru &&
            $pertemuan->id_guru != $user->guru->id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }
}