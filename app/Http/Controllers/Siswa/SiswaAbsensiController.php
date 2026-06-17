<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Pertemuan;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Kuis;
use App\Services\AttendanceGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SiswaAbsensiController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceGatewayService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    /**
     * Display student attendance summary and statistics.
     * NEW: Redesigned to show statistics and per-pertemuan attendance, removed clock-in.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get all attendance records for this student (per-pertemuan only, where tipe_konten IS NULL)
        $absensi = Absensi::where('id_siswa', $siswa->id)
            ->whereNull('tipe_konten') // Only per-pertemuan attendance
            ->with(['Pertemuan.JadwalBelajar.Mapel', 'Pertemuan.JadwalBelajar.GuruMapel.Mapel'])
            ->latest('waktu_absen')
            ->get();

        // Calculate statistics
        $absensiSummary = [
            'hadir' => $absensi->where('status', 'hadir')->count(),
            'izin' => $absensi->where('status', 'izin')->count(),
            'sakit' => $absensi->where('status', 'sakit')->count(),
            'alpha' => $absensi->where('status', 'alpha')->count(),
        ];

        $total = $absensi->count();
        $presentRate = $total > 0 ? round(($absensiSummary['hadir'] / $total) * 100) : 100;
        
        // Calculate lateness statistics
        $latenessStats = [
            'tepat_waktu' => $absensi->where('status_keterlambatan', 'tepat_waktu')->count(),
            'terlambat' => $absensi->where('status_keterlambatan', 'terlambat')->count(),
            'sangat_terlambat' => $absensi->where('status_keterlambatan', 'sangat_terlambat')->count(),
        ];
        
        $lateRate = $total > 0 ? round((($latenessStats['terlambat'] + $latenessStats['sangat_terlambat']) / $total) * 100) : 0;

        return view('siswa.absensi.index', compact('siswa', 'absensi', 'absensiSummary', 'presentRate', 'latenessStats', 'lateRate'));
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
            return back()->with('error', ' Absensi belum dibuka. Waktu clock-in: 05:00 - 12:00 WIB');
        }
        
        if ($now->gt($endTime)) {
            return back()->with('error', ' Waktu absensi sudah ditutup. Waktu clock-in: 05:00 - 12:00 WIB');
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

    /**
     * Show attendance modal for content access
     * NEW: Shows pertemuan info and all content that will be accessible after attendance
     */
    public function showAttendanceModal(Request $request, $pertemuan)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan.');
        }

        $tipeKonten = $request->query('tipe_konten');
        $idKonten = $request->query('id_konten');
        $redirectTo = $request->query('redirect_to');

        // Handle both ID and model object (from route binding)
        if (is_object($pertemuan) && $pertemuan instanceof Pertemuan) {
            $pertemuanModel = $pertemuan;
            $pertemuanModel->load([
                'JadwalBelajar.JamBelajar',
                'JadwalBelajar.Mapel',
                'JadwalBelajar.GuruMapel.Mapel',
                'guru',
                'materis',
                'tugas',
                'kuis'
            ]);
        } else {
            // Load pertemuan with all relationships including content
            $pertemuanModel = Pertemuan::with([
                'JadwalBelajar.JamBelajar',
                'JadwalBelajar.Mapel',
                'JadwalBelajar.GuruMapel.Mapel',
                'guru',
                'materis',
                'tugas',
                'kuis'
            ])->findOrFail($pertemuan);
        }

        // Load the specific content that triggered this modal
        $content = match($tipeKonten) {
            'materi' => Materi::find($idKonten),
            'tugas' => Tugas::find($idKonten),
            'kuis' => Kuis::find($idKonten),
            default => null
        };

        if (!$content) {
            return redirect()->back()->with('error', 'Konten tidak ditemukan.');
        }

        // Get attendance deadline for this pertemuan (earliest from all content)
        $batasAbsensi = $this->attendanceService->getPertemuanAttendanceDeadline($pertemuanModel);

        // Count content in this pertemuan
        $contentCount = [
            'materi' => $pertemuanModel->materis->count(),
            'tugas' => $pertemuanModel->tugas->count(),
            'kuis' => $pertemuanModel->kuis->count(),
        ];

        return view('siswa.absensi.modal', compact(
            'siswa',
            'pertemuanModel',
            'content',
            'tipeKonten',
            'idKonten',
            'batasAbsensi',
            'redirectTo',
            'contentCount'
        ));
    }

    /**
     * Mark attendance for content access
     * NEW: Marks attendance for entire pertemuan, not individual content
     */
    public function markContentAttendance(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $validated = $request->validate([
            'id_pertemuan' => 'required|exists:pertemuan,id',
            'tipe_konten' => 'nullable|in:materi,tugas,kuis',
            'id_konten' => 'nullable|integer',
            'status' => 'required|in:hadir,izin,sakit',
            'keterangan' => 'nullable|string|max:500',
            'redirect_to' => 'nullable|url',
        ]);

        try {
            // Load pertemuan to get deadline
            $pertemuan = Pertemuan::with(['materis', 'tugas', 'kuis'])->findOrFail($validated['id_pertemuan']);
            
            $batasWaktu = $this->attendanceService->getPertemuanAttendanceDeadline($pertemuan);

            // NEW: Mark attendance for pertemuan (not specific content)
            $absensi = $this->attendanceService->markAttendanceForPertemuan(
                $siswa->id,
                $validated['id_pertemuan'],
                $validated['status'],
                $validated['keterangan'],
                $batasWaktu
            );

            // Count content that will be accessible
            $contentCount = $pertemuan->materis->count() + $pertemuan->tugas->count() + $pertemuan->kuis->count();

            $message = match($absensi->status_keterlambatan) {
                'tepat_waktu' => "✅ Absensi berhasil! Anda sekarang dapat mengakses {$contentCount} konten pada pertemuan ini.",
                'terlambat' => "⚠️ Absensi berhasil (terlambat 1-15 menit). Anda dapat mengakses {$contentCount} konten pada pertemuan ini.",
                'sangat_terlambat' => "⚠️ Absensi berhasil (terlambat >15 menit). Anda dapat mengakses {$contentCount} konten pada pertemuan ini.",
                default => "✅ Absensi berhasil dicatat. Anda dapat mengakses {$contentCount} konten pada pertemuan ini."
            };

            // Redirect to content or specified URL
            $redirectUrl = $validated['redirect_to'] ?? route('siswa.materi.index');
            
            return redirect($redirectUrl)->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat absensi: ' . $e->getMessage());
        }
    }
}
