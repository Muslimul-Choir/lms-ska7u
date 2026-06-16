<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pertemuan\StorePertemuanRequest;
use App\Http\Requests\Pertemuan\UpdatePertemuanRequest;
use App\Models\Guru;
use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PertemuanController extends Controller
{
    // ── Public Methods ───────────────────────────────────────────────────

    public function index(Request $request): View|JsonResponse
    {
        /** @var \App\Models\User $user */
        $user         = Auth::user();
        $isGuru       = $user->role === 'guru' && $user->guru;
        $isAdmin      = $user->role === 'admin';
        $isSuperAdmin = $user->role === 'super_admin';

        $search       = $request->input('search');
        $statusFilter = $request->input('status');

        // ── GURU: tampilan tabel, hanya data milik sendiri ───────────────
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
                ->paginate(5)
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
                'isWaliKelasOnly' => $user->guru->status_pengajar === 'walikelas',
                'canCrud'         => true,   // guru bisa CRUD penuh
            ]);
        }

        // ── ADMIN / SUPER ADMIN: read-only, accordion per guru ───────────
        $idGuruFilter = $request->input('id_guru');

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
            ->map(function ($items) {
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

        return view('pertemuan.index', [
            'pertemuans'      => collect(),
            'pertemuanByGuru' => $pertemuanByGuru,
            'gurus'           => $gurus,
            'search'          => $search,
            'jadwalBelajars'  => collect(),
            'idGuruFilter'    => $idGuruFilter,
            'statusFilter'    => $statusFilter,
            'isGuru'          => false,
            'isAdmin'         => $isAdmin,
            'isSuperAdmin'    => $isSuperAdmin,
            'trashCount'      => $trashCount,
            'isWaliKelasOnly' => false,
            'canCrud'         => false,   // admin & super_admin: read-only
        ]);
    }

    public function create(): View
    {
        $this->authorizeOnlyGuru();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $jadwalBelajars = $this->getJadwalBelajarByRole(true);

        return view('pertemuan.create', compact('jadwalBelajars'));
    }

    public function store(StorePertemuanRequest $request): RedirectResponse
    {
        $this->authorizeOnlyGuru();

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
        $data['created_by'] = Auth::id();

        Pertemuan::create($data);

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function show(Pertemuan $pertemuan): View
    {
        $this->authorizeViewAccess($pertemuan);

        $pertemuan->load(['jadwalBelajar', 'guru']);

        return view('pertemuan.show', compact('pertemuan'));
    }

    public function edit(Pertemuan $pertemuan): View
    {
        $this->authorizeOnlyGuru();
        $this->authorizeGuru($pertemuan);

        $jadwalBelajars = $this->getJadwalBelajarByRole(true);

        return view('pertemuan.edit', compact('pertemuan', 'jadwalBelajars'));
    }

    public function update(
        UpdatePertemuanRequest $request,
        Pertemuan $pertemuan
    ): RedirectResponse {
        $this->authorizeOnlyGuru();
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
        $this->authorizeOnlyGuru();
        $this->authorizeGuru($pertemuan);

        $pertemuan->delete();

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil dipindahkan ke arsip.');
    }

    public function trash(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user         = Auth::user();
        $isGuru       = $user->role === 'guru' && $user->guru;
        $isAdmin      = $user->role === 'admin';
        $isSuperAdmin = $user->role === 'super_admin';

        $search       = $request->input('search');
        $statusFilter = $request->input('status');

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
                'canCrud'      => true,    // guru bisa restore & force-delete
            ]);
        }

        // ── ADMIN / SUPER ADMIN: read-only, accordion per guru ───────────
        $idGuruFilter = $request->input('id_guru');

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

        // Kelompokkan per id_guru
        $trashByGuru = $allTrashed
            ->groupBy('id_guru')
            ->map(function ($items) {
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
            'canCrud'      => false,       // admin & super_admin: read-only
        ]);
    }

    public function restore(string $id): RedirectResponse
    {
        $this->authorizeOnlyGuru();

        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);
        $this->authorizeGuru($pertemuan);

        $pertemuan->restore();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $this->authorizeOnlyGuru();

        $pertemuan = Pertemuan::onlyTrashed()->findOrFail($id);
        $this->authorizeGuru($pertemuan);

        $pertemuan->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dihapus permanen.');
    }

    public function restoreAll(): RedirectResponse
    {
        $this->authorizeOnlyGuru();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        Pertemuan::onlyTrashed()
            ->where('id_guru', $user->guru->id)
            ->restore();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Semua data pertemuan berhasil dipulihkan.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        $this->authorizeOnlyGuru();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        Pertemuan::onlyTrashed()
            ->where('id_guru', $user->guru->id)
            ->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Semua data pertemuan berhasil dihapus permanen.');
    }

    // ── Private Helpers ──────────────────────────────────────────────────

    /**
     * Hanya guru (bukan admin/super_admin) yang boleh melakukan aksi CUD.
     * Admin & super_admin mendapat 403 jika mencoba mengakses route CUD.
     */
    private function authorizeOnlyGuru(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role !== 'guru' || ! $user->guru) {
            abort(403, 'Akses ditolak. Hanya guru yang dapat melakukan aksi ini.');
        }
    }

    /**
     * Guru hanya boleh mengelola data miliknya sendiri.
     */
    private function authorizeGuru(Pertemuan $pertemuan): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (
            $user->role === 'guru' &&
            $user->guru &&
            $pertemuan->id_guru != $user->guru->id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }

    /**
     * Akses show (detail) diizinkan untuk semua role.
     * Guru hanya bisa lihat miliknya, admin & super_admin bisa lihat semua.
     */
    private function authorizeViewAccess(Pertemuan $pertemuan): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (
            $user->role === 'guru' &&
            $user->guru &&
            $pertemuan->id_guru != $user->guru->id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }

    private function getJadwalBelajarByRole(bool $isGuru)
    {
        $query = JadwalBelajar::with(['guruMapel', 'kelas']);

        if ($isGuru) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $guru = $user->guru;

            $query->whereHas('guruMapel', function ($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            });
        }

        return $query->get();
    }
}