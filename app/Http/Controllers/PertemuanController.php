<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pertemuan\StorePertemuanRequest;
use App\Http\Requests\Pertemuan\UpdatePertemuanRequest;
use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PertemuanController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $search = $request->get('search');
        $jadwalFilter = $request->get('id_jadwal');
        $statusFilter = $request->get('status');

        $query = Pertemuan::with([
            'jadwalBelajar',
            'guru',
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pertemuan', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        if ($jadwalFilter) {
            $query->where('id_jadwal', $jadwalFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($isGuru) {
            $query->where('id_guru', $user->guru->id);
        }

        $pertemuans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $trashCount = Pertemuan::onlyTrashed()
            ->when(
                $isGuru,
                fn($q) => $q->where('id_guru', $user->guru->id)
            )
            ->count();

        if ($request->ajax()) {
            return response()->json([
                'pertemuans' => $pertemuans->items(),
                'pagination' => $pertemuans->links()->toHtml(),
                'total' => $pertemuans->total(),
            ]);
        }

        $jadwalBelajars = $this->getJadwalBelajarByRole($isGuru);

        return view('pertemuan.index', compact(
            'pertemuans',
            'search',
            'jadwalBelajars',
            'jadwalFilter',
            'statusFilter',
            'isGuru',
            'trashCount'
        ));
    }

    public function create(): View
    {
        $user = auth()->user();
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

        $data['id_guru'] = $jadwal->guruMapel?->id_guru;
        $data['created_by'] = auth()->id();

        Pertemuan::create($data);

        return redirect()
            ->route('pertemuan.index')
            ->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function show(Pertemuan $pertemuan): View
    {
        $this->authorizeGuru($pertemuan);

        $pertemuan->load([
            'jadwalBelajar',
            'guru',
        ]);

        return view('pertemuan.show', compact('pertemuan'));
    }

    public function edit(Pertemuan $pertemuan): View
    {
        $this->authorizeGuru($pertemuan);

        $user = auth()->user();
        $isGuru = $user->role === 'guru' && $user->guru;

        $jadwalBelajars = $this->getJadwalBelajarByRole($isGuru);

        return view('pertemuan.edit', compact(
            'pertemuan',
            'jadwalBelajars'
        ));
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
    $user = auth()->user();
    $isGuru = $user->role === 'guru' && $user->guru;

    $search      = $request->get('search');
    $jadwalFilter = $request->get('id_jadwal');   // ← tambahkan ini
    $statusFilter = $request->get('status');       // ← tambahkan ini

    $query = Pertemuan::onlyTrashed()
        ->with([
            'jadwalBelajar',
            'guru',
        ]);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nomor_pertemuan', 'like', "%{$search}%")
              ->orWhere('tanggal', 'like', "%{$search}%");
        });
    }

    if ($jadwalFilter) {                           // ← tambahkan blok ini
        $query->where('id_jadwal', $jadwalFilter);
    }

    if ($statusFilter) {                           // ← tambahkan blok ini
        $query->where('status', $statusFilter);
    }

    if ($isGuru) {
        $query->where('id_guru', $user->guru->id);
    }

    $pertemuans = $query
        ->latest('deleted_at')
        ->paginate(10)
        ->withQueryString();

    $jadwalBelajars = $this->getJadwalBelajarByRole($isGuru);

    return view('pertemuan.trash', compact(
        'pertemuans',
        'search',
        'jadwalBelajars',
        'jadwalFilter',   // ← pass ke view agar select tetap terpilih
        'statusFilter',   // ← pass ke view agar select tetap terpilih
        'isGuru'
    ));
}

    public function restore(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()
            ->findOrFail($id);

        $this->authorizeGuru($pertemuan);

        $pertemuan->restore();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dipulihkan.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $pertemuan = Pertemuan::onlyTrashed()
            ->findOrFail($id);

        $this->authorizeGuru($pertemuan);

        $pertemuan->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Pertemuan berhasil dihapus permanen.');
    }

    public function restoreAll(): RedirectResponse
    {
        $user = auth()->user();

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
        $user = auth()->user();

        $query = Pertemuan::onlyTrashed();

        if ($user->role === 'guru' && $user->guru) {
            $query->where('id_guru', $user->guru->id);
        }

        $query->forceDelete();

        return redirect()
            ->route('pertemuan.trash')
            ->with('success', 'Semua data pertemuan berhasil dihapus permanen.');
    }

    private function getJadwalBelajarByRole(bool $isGuru)
    {
        $query = JadwalBelajar::with([
            'guruMapel',
            'kelas',
        ]);

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