<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        
        // Check if student has clocked in today
        $today = Carbon::today();
        $todayAbsensi = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('waktu_absen', $today)
            ->first();

        return view('siswa.absensi.index', compact('siswa', 'absensi', 'absensiSummary', 'presentRate', 'todayAbsensi'));
    }
    
    /**
     * Clock in attendance for student (self-attendance)
     */
    public function clockIn(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        
        // Check if already clocked in today
        $existingAbsensi = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('waktu_absen', $today)
            ->first();

        if ($existingAbsensi) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini pada ' . $existingAbsensi->waktu_absen->format('H:i'));
        }

        // Define clock-in window (05:00 - 12:00)
        $startTime = $today->copy()->setTime(5, 0, 0);  // 05:00
        $endTime = $today->copy()->setTime(12, 0, 0);   // 12:00
        $cutoffTime = $today->copy()->setTime(7, 0, 0); // 07:00
        
        // Check if current time is within allowed window
        if ($now->lt($startTime)) {
            return back()->with('error', '⏰ Absensi belum dibuka. Waktu clock-in: 05:00 - 12:00 WIB');
        }
        
        if ($now->gt($endTime)) {
            return back()->with('error', '⏰ Waktu absensi sudah ditutup. Waktu clock-in: 05:00 - 12:00 WIB');
        }

        // Determine status based on time (07:00 cutoff)
        $status = $now->lte($cutoffTime) ? 'hadir' : 'alpha'; // Hadir jika <= 07:00, Alpha jika > 07:00
        
        $keterangan = null;
        if ($status === 'alpha') {
            $keterangan = 'Terlambat - Absen pada ' . $now->format('H:i');
        }

        // Create attendance record
        Absensi::create([
            'id_siswa' => $siswa->id,
            'id_pertemuan' => null, // Self attendance not tied to specific pertemuan
            'status' => $status,
            'waktu_absen' => $now,
            'keterangan' => $keterangan,
        ]);

        $message = $status === 'hadir' 
            ? '✅ Absensi berhasil! Anda hadir pada ' . $now->format('H:i')
            : '⚠️ Absensi berhasil! Anda terlambat (Setelah 07:00) - Status: Alpha';

        return back()->with('success', $message);
    }
}
