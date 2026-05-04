<?php

namespace App\Http\Controllers;

use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Kelas;
use App\Models\GuruMapel;
use App\Models\Mapel;
use Illuminate\Http\Request;

class JadwalBelajarController extends Controller
{
    public function index(Request $request)
{
    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    $idKelas = $request->get('id_kelas');
    $tingkat = $request->get('tingkat');

    // Ambil semua jam belajar
    $jamList = JamBelajar::orderByRaw('COALESCE(urutan, 999), jam_mulai')->get();

    // Ambil tingkatan untuk dropdown
    $tingkatanList = \App\Models\Tingkatan::orderBy('nama_tingkatan')->get();

    // Ambil SEMUA kelas untuk dropdown (bukan difilter, filter hanya via JS)
    $kelasList = Kelas::with(['Tingkatan', 'Jurusan', 'Bagian'])->get();

    // Ambil guru mapel & mapel untuk modal
    $guruMapelList = GuruMapel::with(['Guru', 'Mapel'])->get();
    $mapelList     = \App\Models\Mapel::orderBy('nama_mapel')->get();

    // Ambil jadwal — wajib ada filter kelas atau tingkat untuk tampil
    $jadwals = collect();

    if ($idKelas || $tingkat) {
        $jadwals = JadwalBelajar::with([
            'JamBelajar',
            'Kelas.Tingkatan',
            'Kelas.Jurusan',
            'Kelas.Bagian',
            'GuruMapel.Guru',
            'GuruMapel.Mapel',
            'Mapel',
        ])
        ->when($idKelas, fn($q) => $q->where('id_kelas', $idKelas))
        ->when($tingkat && !$idKelas, fn($q) => $q->whereHas('Kelas.Tingkatan',
            fn($q2) => $q2->where('tingkatan.id', $tingkat)
        ))
        ->get();
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
        'hariList',
        'jamList',
        'tingkatanList',
        'kelasList',
        'guruMapelList',
        'mapelList',
        'grid',
        'idKelas',
        'tingkat',
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'hari'          => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'id_jam'        => 'required|exists:jam_belajar,id',
            'id_kelas'      => 'required|exists:kelas,id',
            'id_guru_mapel' => 'nullable|exists:guru_mapel,id',
            'id_mapel'      => 'nullable|exists:mapel,id',
            'nama_kegiatan' => 'nullable|string|max:100',
        ]);

        // Minimal salah satu harus diisi: guru_mapel, mapel, atau nama_kegiatan
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