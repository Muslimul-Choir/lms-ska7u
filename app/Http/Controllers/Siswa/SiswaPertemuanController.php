<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pertemuan;
use App\Models\JadwalBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaPertemuanController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa || !$siswa->id_kelas) {
            return view('siswa.pertemuan.index', [
                'pertemuans' => collect(),
                'mapelFilter' => null,
                'mapels'     => collect(),
            ]);
        }

        $idKelas    = $siswa->id_kelas;
        $mapelFilter = $request->get('id_mapel');

        // Ambil semua pertemuan kelas siswa ini
        // FILTER BARU: Hanya tampilkan pertemuan yang tanggalnya sudah lewat atau hari ini
        $query = Pertemuan::with(['jadwalBelajar.mapel', 'jadwalBelajar.guruMapel.guru'])
            ->whereHas('jadwalBelajar', function ($q) use ($idKelas) {
                $q->where('id_kelas', $idKelas);
            })
            ->where(function($q) {
                $q->whereNull('tanggal') // Jika tanggal tidak diset, tampilkan (backward compatibility)
                  ->orWhere('tanggal', '<=', now()->toDateString()); // Atau tanggal pertemuan sudah lewat/hari ini
            })
            ->when($mapelFilter, function ($q) use ($mapelFilter) {
                $q->whereHas('jadwalBelajar', function ($q2) use ($mapelFilter) {
                    $q2->where('id_mapel', $mapelFilter);
                });
            })
            ->orderBy('tanggal', 'desc');

        $pertemuans = $query->paginate(10)->withQueryString();

        // Daftar mapel kelas ini untuk filter dropdown
        $mapels = JadwalBelajar::with('mapel')
            ->where('id_kelas', $idKelas)
            ->whereNotNull('id_mapel')
            ->get()
            ->pluck('mapel')
            ->filter()
            ->unique('id');

        return view('siswa.pertemuan.index', compact('pertemuans', 'mapelFilter', 'mapels'));
    }

    public function show($id)
    {
        $siswa = Auth::user()->siswa;

        $pertemuan = Pertemuan::with([
            'jadwalBelajar.mapel',
            'jadwalBelajar.guruMapel.guru',
            'materis',
            'tugas',
        ])->findOrFail($id);

        // Pastikan pertemuan ini untuk kelas siswa yang login
        if ($pertemuan->jadwalBelajar?->id_kelas != $siswa->id_kelas) {
            abort(403, 'Anda tidak berhak mengakses pertemuan ini.');
        }

        return view('siswa.pertemuan.show', compact('pertemuan', 'siswa'));
    }
}
