<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalBelajar\StoreJadwalBelajarRequest;
use App\Http\Requests\JadwalBelajar\UpdateJadwalBelajarRequest;
use App\Models\JadwalBelajar;
use App\Models\GuruMapel;
use App\Models\JamBelajar;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JadwalBelajarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $hari   = $request->get('hari');

        $jadwals = JadwalBelajar::with([
                'GuruMapel.Guru',
                'GuruMapel.Mapel',
                'JamBelajar',
                'Kelas.Tingkatan',
                'Kelas.Jurusan',
                'Kelas.Bagian',
            ])
            ->when($search, function ($query, $search) {
                return $query->whereHas('GuruMapel.Guru', function ($q) use ($search) {
                    $q->where('nama_guru', 'like', '%' . $search . '%');
                })->orWhereHas('Kelas.Jurusan', function ($q) use ($search) {
                    $q->where('nama_jurusan', 'like', '%' . $search . '%');
                });
            })
            ->when($hari, function ($query, $hari) {
                return $query->where('hari', $hari);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $guruMapels  = GuruMapel::with(['Guru', 'Mapel'])->get();
        $jamBelajars = JamBelajar::all();
        $kelas       = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        $hariList    = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        if ($request->ajax()) {
            return response()->json([
                'jadwals'    => $jadwals->items(),
                'pagination' => $jadwals->links()->toHtml(),
                'total'      => $jadwals->total(),
            ]);
        }

        return view('jadwalbelajar.index', compact(
            'jadwals',
            'search',
            'hari',
            'guruMapels',
            'jamBelajars',
            'kelas',
            'hariList'
        ));
    }

    public function create(): View
    {
        $guruMapels  = GuruMapel::with(['Guru', 'Mapel'])->get();
        $jamBelajars = JamBelajar::all();
        $kelas       = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        $hariList    = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwalbelajar.create', compact(
            'guruMapels',
            'jamBelajars',
            'kelas',
            'hariList'
        ));
    }

    public function store(StoreJadwalBelajarRequest $request): RedirectResponse
    {
        JadwalBelajar::create($request->validated());

        return redirect()
            ->route('jadwalbelajar.index')
            ->with('success', 'Jadwal belajar berhasil ditambahkan.');
    }

    public function show(JadwalBelajar $jadwalBelajar): View
    {
        $jadwalBelajar->load([
            'GuruMapel.Guru',
            'GuruMapel.Mapel',
            'JamBelajar',
            'Kelas.Tingkatan',
            'Kelas.Jurusan',
            'Kelas.Bagian',
        ]);

        return view('jadwalbelajar.show', compact('jadwalBelajar'));
    }

    public function edit(JadwalBelajar $jadwalBelajar): View
    {
        $guruMapels  = GuruMapel::with(['Guru', 'Mapel'])->get();
        $jamBelajars = JamBelajar::all();
        $kelas       = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        $hariList    = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwalbelajar.edit', compact(
            'jadwalBelajar',
            'guruMapels',
            'jamBelajars',
            'kelas',
            'hariList'
        ));
    }

    public function update(UpdateJadwalBelajarRequest $request, JadwalBelajar $jadwalBelajar): RedirectResponse
    {
        $jadwalBelajar->update($request->validated());

        return redirect()
            ->route('jadwalbelajar.index')
            ->with('success', 'Jadwal belajar berhasil diperbarui.');
    }

    public function destroy(JadwalBelajar $jadwalBelajar): RedirectResponse
    {
        $jadwalBelajar->delete();

        return redirect()
            ->route('jadwalbelajar.index')
            ->with('success', 'Jadwal belajar berhasil dihapus.');
    }

    public function trash(): View
    {
        $jadwals = JadwalBelajar::onlyTrashed()
            ->with([
                'GuruMapel.Guru',
                'GuruMapel.Mapel',
                'JamBelajar',
                'Kelas.Tingkatan',
                'Kelas.Jurusan',
                'Kelas.Bagian',
            ])
            ->latest()
            ->paginate(10);

        return view('jadwalbelajar.trash', compact('jadwals'));
    }

    public function restore(int $id): RedirectResponse
    {
        JadwalBelajar::onlyTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('jadwalbelajar.trash')
            ->with('success', 'Jadwal belajar berhasil dipulihkan.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        JadwalBelajar::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()
            ->route('jadwalbelajar.trash')
            ->with('success', 'Jadwal belajar berhasil dihapus permanen.');
    }
}