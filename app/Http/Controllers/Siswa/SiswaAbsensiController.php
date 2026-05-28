<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaAbsensiController extends Controller
{
    /**
     * Display student attendance summary and log.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get all attendance records for this student
        $absensi = Absensi::where('id_siswa', $siswa->id)
            ->with(['Pertemuan.JadwalBelajar.Mapel', 'Pertemuan.JadwalBelajar.GuruMapel.Mapel'])
            ->latest()
            ->get();

        $absensiSummary = [
            'hadir' => $absensi->where('status', 'hadir')->count(),
            'izin' => $absensi->where('status', 'izin')->count(),
            'sakit' => $absensi->where('status', 'sakit')->count(),
            'alpha' => $absensi->where('status', 'alpha')->count(),
        ];

        $total = $absensi->count();
        $presentRate = $total > 0 ? round(($absensiSummary['hadir'] / $total) * 100) : 100;

        return view('siswa.absensi.index', compact('siswa', 'absensi', 'absensiSummary', 'presentRate'));
    }
}
