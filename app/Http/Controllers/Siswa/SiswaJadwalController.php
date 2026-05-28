<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalBelajar;
use App\Models\JamBelajar;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaJadwalController extends Controller
{
    /**
     * Display the student's class weekly schedule grid.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $jamList = JamBelajar::orderBy('jam_mulai')->get();

        $jadwals = JadwalBelajar::where('id_kelas', $siswa->id_kelas)
            ->with([
                'JamBelajar',
                'GuruMapel.Guru',
                'GuruMapel.Mapel',
                'Mapel',
            ])
            ->get();

        // Build the grid
        $grid = [];
        foreach ($jamList as $jam) {
            $grid[$jam->id] = [];
            foreach ($hariList as $hari) {
                $grid[$jam->id][$hari] = $jadwals->filter(
                    fn($j) => $j->id_jam == $jam->id && $j->hari === $hari
                )->values();
            }
        }

        return view('siswa.jadwal.index', compact('siswa', 'hariList', 'jamList', 'grid'));
    }
}
