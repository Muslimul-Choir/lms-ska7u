<?php

namespace App\Http\Controllers;

use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Kelas;
use App\Models\GuruMapel;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalBelajarController extends Controller
{
    public function index(Request $request)
    {
        $user    = Auth::user();
        $isAdmin = in_array($user->role, ['super_admin', 'admin']);
        $isGuru  = $user->role === 'guru' && $user->guru;

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $idKelas = $request->get('id_kelas');
        $tingkat = $request->get('tingkat');

        // Ambil semua jam belajar
        $jamList = JamBelajar::orderBy('jam_mulai')->get();

        // Ambil tingkatan untuk dropdown
        $tingkatanList = \App\Models\Tingkatan::orderBy('nama_tingkatan')->get();

        // ── Kelas dropdown ─────────────────────────────────────────────
        // Guru hanya lihat kelas yang dia ajar
        if ($isGuru) {
            $guru = $user->guru;
            $kelasList = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])
                ->whereHas('jadwalBelajars.guruMapel', function ($q) use ($guru) {
                    $q->where('id_guru', $guru->id);
                })->get();
        } else {
            $kelasList = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();
        }

        // Ambil guru mapel & mapel untuk modal (hanya admin pakai ini)
        $guruMapelList = $isAdmin ? GuruMapel::with(['Guru', 'Mapel'])->get() : collect();
        $mapelList     = $isAdmin ? \App\Models\Mapel::orderBy('nama_mapel')->get() : collect();

        // ── Jadwal query ───────────────────────────────────────────────
        $jadwals = collect();

        if ($idKelas || $tingkat || $isGuru) {
            $jadwalQuery = JadwalBelajar::with([
                'JamBelajar', 'Kelas.Tingkatan', 'Kelas.Jurusan',
                'Kelas.Bagian', 'GuruMapel.Guru', 'GuruMapel.Mapel', 'Mapel',
            ]);

            // Filter kelas spesifik
            if ($idKelas) {
                $jadwalQuery->where('id_kelas', $idKelas);
            } elseif ($tingkat && !$isGuru) {
                $jadwalQuery->whereHas('Kelas.Tingkatan', fn($q) => $q->where('tingkatan.id', $tingkat));
            }

            // Guru hanya lihat jadwal yang mereka ajar
            if ($isGuru) {
                $guru = $user->guru;
                $jadwalQuery->whereHas('guruMapel', function ($q) use ($guru) {
                    $q->where('id_guru', $guru->id);
                });
                // Kalau guru, auto-filter kelas pertama jika belum ada filter kelas
                if (!$idKelas && !$tingkat) {
                    // tampilkan semua jadwal guru ini lintas kelas
                }
            }

            $jadwals = $jadwalQuery->get();
        }

        // Susun grid
        $grid = [];
        foreach ($jamList as $jam) {
            $grid[$jam->id] = [];
            foreach ($hariList as $hari) {
                $grid[$jam->id][$hari] = $jadwals->filter(
                    fn($j) => $j->id_jam == $jam->id && $j->hari === $hari
                )->values();
            }
        }

        return view('jadwalbelajar.index', compact(
            'hariList', 'jamList', 'tingkatanList', 'kelasList',
            'guruMapelList', 'mapelList', 'grid', 'idKelas', 'tingkat',
            'isAdmin', 'isGuru', 'jadwals',
        ));
    }


    public function store(Request $request)
    {
        // Hanya admin yang boleh tambah jadwal
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Hanya admin yang dapat menambah jadwal belajar.');
        }

        $request->validate([
            'hari'          => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'id_jam'        => 'required|exists:jam_belajar,id',
            'id_kelas'      => 'required|exists:kelas,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'id_mapel'      => 'nullable|exists:mapel,id',
            'nama_kegiatan' => 'nullable|string|max:100',
        ]);

        if (!$request->id_guru_mapel && !$request->id_mapel && !$request->nama_kegiatan) {
            return back()->withErrors(['nama_kegiatan' => 'Isi salah satu: Guru Mapel, Mapel, atau Nama Kegiatan.'])->withInput();
        }

        JadwalBelajar::create($request->only([
            'hari', 'id_jam', 'id_kelas', 'id_guru_mapel', 'id_mapel', 'nama_kegiatan'
        ]));

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, JadwalBelajar $jadwalbelajar)
    {
        // Hanya admin yang boleh edit jadwal
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Hanya admin yang dapat mengubah jadwal belajar.');
        }

        $request->validate([
            'hari'          => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'id_jam'        => 'required|exists:jam_belajar,id',
            'id_kelas'      => 'required|exists:kelas,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'id_mapel'      => 'nullable|exists:mapel,id',
            'nama_kegiatan' => 'nullable|string|max:100',
        ]);

        $jadwalbelajar->update($request->only([
            'hari', 'id_jam', 'id_kelas', 'id_guru_mapel', 'id_mapel', 'nama_kegiatan'
        ]));

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalBelajar $jadwalbelajar)
    {
        // Hanya admin yang boleh hapus jadwal
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Hanya admin yang dapat menghapus jadwal belajar.');
        }

        $jadwalbelajar->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function trash()
    {
        $jadwals = JadwalBelajar::onlyTrashed()
            ->with(['JamBelajar', 'Kelas', 'GuruMapel.Guru', 'GuruMapel.Mapel', 'Mapel'])
            ->paginate(10);

        return view('jadwalbelajar.trash', compact('jadwals'));
    }

    public function restore($id)
    {
        JadwalBelajar::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Jadwal berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        JadwalBelajar::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Jadwal berhasil dihapus permanen.');
    }
}