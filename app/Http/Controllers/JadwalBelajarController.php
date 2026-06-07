<?php

namespace App\Http\Controllers;

use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Kelas;
use App\Models\GuruMapel;
use App\Models\Mapel;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalBelajarController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $isAdmin = in_array($user->role, ['super_admin', 'admin']);
        $isGuru  = $user->role === 'guru' && $user->guru;

        $hariList = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        ];

        $idKelas = $request->get('id_kelas');
        $tingkat = $request->get('tingkat');

        $jamList = JamBelajar::orderBy('jam_mulai')->get();

        $tingkatanList = Tingkatan::orderBy('nama_tingkatan')->get();

        if ($isGuru) {
            $guru = $user->guru;

            $kelasList = Kelas::with([
                'Tingkatan',
                'Jurusan',
                'Bagian'
            ])
            ->whereHas('jadwalBelajars.guruMapel', function ($q) use ($guru) {
                $q->where('id_guru', $guru->id);
            })
            ->get();
        } else {
            $kelasList = Kelas::with([
                'Tingkatan',
                'Jurusan',
                'Bagian'
            ])->get();
        }

        $guruMapelList = $isAdmin
            ? GuruMapel::with(['Guru', 'Mapel'])->get()
            : collect();

        $mapelList = $isAdmin
            ? Mapel::orderBy('nama_mapel')->get()
            : collect();

        $jadwals = collect();

        if ($idKelas || $tingkat || $isGuru) {

            $jadwalQuery = JadwalBelajar::with([
                'JamBelajar',
                'Kelas.Tingkatan',
                'Kelas.Jurusan',
                'Kelas.Bagian',
                'GuruMapel.Guru',
                'GuruMapel.Mapel',
                'Mapel'
            ]);

            if ($idKelas) {
                $jadwalQuery->where('id_kelas', $idKelas);
            }

            if ($tingkat && !$isGuru) {
                $jadwalQuery->whereHas('Kelas.Tingkatan', function ($q) use ($tingkat) {
                    $q->where('id', $tingkat);
                });
            }

            if ($isGuru) {
                $guru = $user->guru;

                $jadwalQuery->whereHas('GuruMapel', function ($q) use ($guru) {
                    $q->where('id_guru', $guru->id);
                });
            }

            $jadwals = $jadwalQuery->get();
        }

        $grid = [];

        foreach ($jamList as $jam) {

            $grid[$jam->id] = [];

            foreach ($hariList as $hari) {

                $grid[$jam->id][$hari] = $jadwals
                    ->filter(fn($j) => $j->id_jam == $jam->id && $j->hari === $hari)
                    ->values();
            }
        }

        $trashCount = JadwalBelajar::onlyTrashed()->count();

        return view('jadwalbelajar.index', compact(
            'hariList',
            'jamList',
            'tingkatanList',
            'kelasList',
            'guruMapelList',
            'mapelList',
            'grid',
            'idKelas',
            'tingkat',
            'isAdmin',
            'isGuru',
            'jadwals',
            'trashCount'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(
            in_array(Auth::user()->role, ['super_admin', 'admin']),
            403
        );

        $validated = $request->validate([
            'hari'          => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'id_jam'        => 'required|exists:jam_belajar,id',
            'id_kelas'      => 'required|exists:kelas,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'id_mapel'      => 'nullable|exists:mapel,id',
            'nama_kegiatan' => 'nullable|string|max:100',
        ]);

        $exists = JadwalBelajar::where('hari', $validated['hari'])
            ->where('id_jam', $validated['id_jam'])
            ->where('id_kelas', $validated['id_kelas'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal pada hari, jam, dan kelas tersebut sudah ada.');
        }

        // Auto-generate nama_kegiatan if not provided
        if (empty($validated['nama_kegiatan'])) {
            $kelas = Kelas::with(['tingkatan', 'jurusan', 'bagian'])->find($validated['id_kelas']);
            $guruMapel = $validated['id_guru_mapel'] ? GuruMapel::with(['guru', 'mapel'])->find($validated['id_guru_mapel']) : null;
            
            if ($guruMapel && $kelas) {
                $namaGuru = $guruMapel->guru?->nama_lengkap ?? 'Guru';
                $namaMapel = $guruMapel->mapel?->nama_mapel ?? 'Mapel';
                $namaKelas = $kelas->tingkatan?->nama_tingkatan . ' ' . $kelas->jurusan?->nama_jurusan . ' ' . $kelas->bagian?->nama_bagian;
                
                $validated['nama_kegiatan'] = $namaGuru . ' - ' . $namaMapel . ' - ' . $namaKelas;
            }
        }

        JadwalBelajar::create($validated);

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, JadwalBelajar $jadwalbelajar): RedirectResponse
    {
        abort_unless(
            in_array(Auth::user()->role, ['super_admin', 'admin']),
            403
        );

        $validated = $request->validate([
            'hari'          => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'id_jam'        => 'required|exists:jam_belajar,id',
            'id_kelas'      => 'required|exists:kelas,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'id_mapel'      => 'nullable|exists:mapel,id',
            'nama_kegiatan' => 'nullable|string|max:100',
        ]);

        $exists = JadwalBelajar::where('hari', $validated['hari'])
            ->where('id_jam', $validated['id_jam'])
            ->where('id_kelas', $validated['id_kelas'])
            ->where('id', '!=', $jadwalbelajar->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal pada hari, jam, dan kelas tersebut sudah ada.');
        }

        // Auto-generate nama_kegiatan if not provided
        if (empty($validated['nama_kegiatan'])) {
            $kelas = Kelas::with(['tingkatan', 'jurusan', 'bagian'])->find($validated['id_kelas']);
            $guruMapel = $validated['id_guru_mapel'] ? GuruMapel::with(['guru', 'mapel'])->find($validated['id_guru_mapel']) : null;
            
            if ($guruMapel && $kelas) {
                $namaGuru = $guruMapel->guru?->nama_lengkap ?? 'Guru';
                $namaMapel = $guruMapel->mapel?->nama_mapel ?? 'Mapel';
                $namaKelas = $kelas->tingkatan?->nama_tingkatan . ' ' . $kelas->jurusan?->nama_jurusan . ' ' . $kelas->bagian?->nama_bagian;
                
                $validated['nama_kegiatan'] = $namaGuru . ' - ' . $namaMapel . ' - ' . $namaKelas;
            }
        }

        $jadwalbelajar->update($validated);

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalBelajar $jadwalbelajar): RedirectResponse
    {
        abort_unless(
            in_array(Auth::user()->role, ['super_admin', 'admin']),
            403
        );

        $jadwalbelajar->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function trash(Request $request): View
{
    $kelasList = Kelas::with([
        'Tingkatan',
        'Jurusan',
        'Bagian'
    ])->get();

    $query = JadwalBelajar::onlyTrashed()
        ->with([
            'JamBelajar',
            'Kelas.Tingkatan',
            'Kelas.Jurusan',
            'Kelas.Bagian',
            'GuruMapel.Guru',
            'GuruMapel.Mapel',
            'Mapel'
        ]);

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('hari', 'like', '%' . $request->search . '%')
              ->orWhere('nama_kegiatan', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('hari')) {
        $query->where('hari', $request->hari);
    }

    if ($request->filled('id_kelas')) {
        $query->where('id_kelas', $request->id_kelas);
    }

    $jadwals = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('jadwalbelajar.trash', compact(
        'jadwals',
        'kelasList'
    ));
}

    public function restore(JadwalBelajar $jadwalbelajar): RedirectResponse
    {
        $jadwalbelajar->restore();

        return redirect()
            ->route('jadwalbelajar.trash')
            ->with('success', 'Jadwal berhasil dipulihkan.');
    }

    public function restoreAll(): RedirectResponse
    {
        JadwalBelajar::onlyTrashed()->restore();

        return redirect()
            ->route('jadwalbelajar.trash')
            ->with('success', 'Semua jadwal berhasil dipulihkan.');
    }

    public function forceDelete(JadwalBelajar $jadwalbelajar): RedirectResponse
    {
        $jadwalbelajar->forceDelete();

        return redirect()
            ->route('jadwalbelajar.trash')
            ->with('success', 'Jadwal berhasil dihapus permanen.');
    }

    public function forceDeleteAll(): RedirectResponse
    {
        JadwalBelajar::onlyTrashed()->forceDelete();

        return redirect()
            ->route('jadwalbelajar.trash')
            ->with('success', 'Semua jadwal berhasil dihapus permanen.');
    }
}