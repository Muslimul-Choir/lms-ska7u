<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\ContentExemption;
use App\Models\Pertemuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceGatewayService
{
    /**
     * Check if student has marked attendance for pertemuan
     * 
     * @param int $siswaId
     * @param int $pertemuanId
     * @return bool
     */
    public function hasMarkedAttendanceForPertemuan(int $siswaId, int $pertemuanId): bool
    {
        $cacheKey = "attendance_pertemuan_{$siswaId}_{$pertemuanId}";
        
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($siswaId, $pertemuanId) {
            return Absensi::where('id_siswa', $siswaId)
                ->where('id_pertemuan', $pertemuanId)
                ->whereNull('tipe_konten') // Attendance for pertemuan, not specific content
                ->exists();
        });
    }

    /**
     * Check if student has marked attendance for content (old method - kept for compatibility)
     * 
     * @param int $siswaId
     * @param string $tipeKonten (materi|tugas|kuis)
     * @param int $idKonten
     * @return bool
     */
    public function hasMarkedAttendance(int $siswaId, string $tipeKonten, int $idKonten): bool
    {
        $cacheKey = "attendance_{$siswaId}_{$tipeKonten}_{$idKonten}";
        
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($siswaId, $tipeKonten, $idKonten) {
            return Absensi::where('id_siswa', $siswaId)
                ->where('tipe_konten', $tipeKonten)
                ->where('id_konten', $idKonten)
                ->exists();
        });
    }

    /**
     * Calculate lateness status based on mark time
     * 
     * @param Carbon $batasWaktu
     * @param Carbon $waktuAbsen
     * @return string ('tepat_waktu'|'terlambat'|'sangat_terlambat')
     */
    public function calculateLatenessStatus(Carbon $batasWaktu, Carbon $waktuAbsen): string
    {
        $minutesLate = $batasWaktu->diffInMinutes($waktuAbsen, false);
        
        if ($minutesLate <= 0) {
            return 'tepat_waktu';
        } elseif ($minutesLate <= 15) {
            return 'terlambat'; // 1-15 minutes late
        } else {
            return 'sangat_terlambat'; // More than 15 minutes late
        }
    }

    /**
     * Mark attendance for pertemuan (NEW - primary method)
     * 
     * @param int $siswaId
     * @param int $pertemuanId
     * @param string $status ('hadir'|'izin'|'sakit'|'alpha')
     * @param string|null $keterangan
     * @param Carbon|null $batasWaktu
     * @return Absensi
     */
    public function markAttendanceForPertemuan(
        int $siswaId,
        int $pertemuanId,
        string $status = 'hadir',
        ?string $keterangan = null,
        ?Carbon $batasWaktu = null
    ): Absensi {
        DB::beginTransaction();
        try {
            // Check if already marked
            $existing = Absensi::where('id_siswa', $siswaId)
                ->where('id_pertemuan', $pertemuanId)
                ->whereNull('tipe_konten')
                ->first();

            if ($existing) {
                DB::rollBack();
                return $existing; // Already marked
            }

            $waktuAbsen = now();
            
            // Calculate lateness if deadline provided
            $statusKeterlambatan = null;
            if ($batasWaktu && $status === 'hadir') {
                $statusKeterlambatan = $this->calculateLatenessStatus($batasWaktu, $waktuAbsen);
            }

            // Create attendance record for pertemuan
            $absensi = Absensi::create([
                'id_siswa' => $siswaId,
                'id_pertemuan' => $pertemuanId,
                'tipe_konten' => null, // NULL means attendance for whole pertemuan
                'id_konten' => null,
                'status' => $status,
                'keterangan' => $keterangan,
                'waktu_absen' => $waktuAbsen,
                'batas_waktu_absen' => $batasWaktu,
                'status_keterlambatan' => $statusKeterlambatan,
            ]);

            // Invalidate cache
            $cacheKey = "attendance_pertemuan_{$siswaId}_{$pertemuanId}";
            Cache::forget($cacheKey);

            DB::commit();

            Log::info("Attendance marked for pertemuan", [
                'siswa_id' => $siswaId,
                'pertemuan_id' => $pertemuanId,
                'status' => $status,
                'lateness' => $statusKeterlambatan
            ]);

            return $absensi;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to mark attendance for pertemuan", [
                'error' => $e->getMessage(),
                'siswa_id' => $siswaId,
                'pertemuan_id' => $pertemuanId
            ]);
            throw $e;
        }
    }

    /**
     * Mark attendance for content (OLD method - kept for backwards compatibility)
     * 
     * @param int $siswaId
     * @param int $pertemuanId
     * @param string $tipeKonten
     * @param int $idKonten
     * @param string $status ('hadir'|'izin'|'sakit'|'alpha')
     * @param string|null $keterangan
     * @param Carbon|null $batasWaktu
     * @return Absensi
     */
    public function markAttendance(
        int $siswaId,
        int $pertemuanId,
        string $tipeKonten,
        int $idKonten,
        string $status = 'hadir',
        ?string $keterangan = null,
        ?Carbon $batasWaktu = null
    ): Absensi {
        // For now, just mark attendance for pertemuan instead
        return $this->markAttendanceForPertemuan($siswaId, $pertemuanId, $status, $keterangan, $batasWaktu);
    }

    /**
     * Check if student is exempted from attendance for pertemuan
     * 
     * @param int $siswaId
     * @param int $pertemuanId
     * @return bool
     */
    public function isExemptedFromPertemuan(int $siswaId, int $pertemuanId): bool
    {
        $cacheKey = "exemption_pertemuan_{$siswaId}_{$pertemuanId}";
        
        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($siswaId, $pertemuanId) {
            // Check if there's any exemption for this pertemuan
            $exemption = ContentExemption::where('id_siswa', $siswaId)
                ->where('tipe_konten', 'pertemuan')
                ->where('id_konten', $pertemuanId)
                ->where(function($q) {
                    $q->whereNull('berlaku_hingga')
                      ->orWhere('berlaku_hingga', '>=', now());
                })
                ->first();

            return $exemption !== null;
        });
    }

    /**
     * Check if student is exempted from attendance for content (old method)
     * 
     * @param int $siswaId
     * @param string $tipeKonten
     * @param int $idKonten
     * @return bool
     */
    public function isExempted(int $siswaId, string $tipeKonten, int $idKonten): bool
    {
        $cacheKey = "exemption_{$siswaId}_{$tipeKonten}_{$idKonten}";
        
        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($siswaId, $tipeKonten, $idKonten) {
            $exemption = ContentExemption::forSiswa($siswaId)
                ->forContent($tipeKonten, $idKonten)
                ->active()
                ->first();

            return $exemption && $exemption->isValid();
        });
    }

    /**
     * Add exemption for student
     * 
     * @param int $siswaId
     * @param string $tipeKonten
     * @param int $idKonten
     * @param int $guruId
     * @param string $alasan
     * @param Carbon|null $berlakuHingga
     * @return ContentExemption
     */
    public function addExemption(
        int $siswaId,
        string $tipeKonten,
        int $idKonten,
        int $guruId,
        string $alasan,
        ?Carbon $berlakuHingga = null
    ): ContentExemption {
        try {
            $exemption = ContentExemption::create([
                'id_siswa' => $siswaId,
                'id_guru' => $guruId,
                'tipe_konten' => $tipeKonten,
                'id_konten' => $idKonten,
                'alasan' => $alasan,
                'berlaku_hingga' => $berlakuHingga,
            ]);

            // Invalidate cache
            $cacheKey = "exemption_{$siswaId}_{$tipeKonten}_{$idKonten}";
            Cache::forget($cacheKey);

            Log::info("Attendance exemption added", [
                'siswa_id' => $siswaId,
                'content' => "{$tipeKonten}:{$idKonten}",
                'guru_id' => $guruId,
                'expires' => $berlakuHingga ? $berlakuHingga->toDateTimeString() : 'never'
            ]);

            return $exemption;
        } catch (\Exception $e) {
            Log::error("Failed to add exemption", [
                'error' => $e->getMessage(),
                'siswa_id' => $siswaId,
                'content' => "{$tipeKonten}:{$idKonten}"
            ]);
            throw $e;
        }
    }

    /**
     * Remove exemption
     * 
     * @param int $exemptionId
     * @return bool
     */
    public function removeExemption(int $exemptionId): bool
    {
        try {
            $exemption = ContentExemption::findOrFail($exemptionId);
            
            // Invalidate cache
            $cacheKey = "exemption_{$exemption->id_siswa}_{$exemption->tipe_konten}_{$exemption->id_konten}";
            Cache::forget($cacheKey);

            $exemption->delete();

            Log::info("Attendance exemption removed", ['exemption_id' => $exemptionId]);

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to remove exemption", [
                'error' => $e->getMessage(),
                'exemption_id' => $exemptionId
            ]);
            return false;
        }
    }

    /**
     * Check if pertemuan requires attendance
     * 
     * @param Pertemuan $pertemuan
     * @return bool
     */
    public function pertemuanRequiresAttendance(Pertemuan $pertemuan): bool
    {
        // Pertemuan requires attendance if it has content with batas_absensi
        $hasMateriWithDeadline = $pertemuan->materis()->whereNotNull('batas_absensi')->exists();
        $hasTugasWithDeadline = $pertemuan->tugas()->whereNotNull('batas_absensi')->exists();
        $hasKuisWithDeadline = $pertemuan->kuis()->whereNotNull('batas_absensi')->exists();
        
        return $hasMateriWithDeadline || $hasTugasWithDeadline || $hasKuisWithDeadline;
    }

    /**
     * Check if content requires attendance (old method - deprecated)
     * 
     * @param mixed $content (Materi|Tugas|Kuis)
     * @return bool
     */
    public function requiresAttendance($content): bool
    {
        // Content requires attendance if it has batas_absensi set
        return !empty($content->batas_absensi);
    }

    /**
     * Get attendance deadline for pertemuan (earliest deadline from all content)
     * 
     * @param Pertemuan $pertemuan
     * @return Carbon|null
     */
    public function getPertemuanAttendanceDeadline(Pertemuan $pertemuan): ?Carbon
    {
        $deadlines = [];
        
        // Get all deadlines from materi, tugas, kuis
        foreach ($pertemuan->materis()->whereNotNull('batas_absensi')->get() as $materi) {
            $deadlines[] = Carbon::parse($materi->batas_absensi);
        }
        
        foreach ($pertemuan->tugas()->whereNotNull('batas_absensi')->get() as $tugas) {
            $deadlines[] = Carbon::parse($tugas->batas_absensi);
        }
        
        foreach ($pertemuan->kuis()->whereNotNull('batas_absensi')->get() as $kuis) {
            $deadlines[] = Carbon::parse($kuis->batas_absensi);
        }
        
        // Return the earliest deadline
        return !empty($deadlines) ? collect($deadlines)->min() : null;
    }

    /**
     * Get attendance deadline for content (old method)
     * 
     * @param mixed $content (Materi|Tugas|Kuis)
     * @return Carbon|null
     */
    public function getAttendanceDeadline($content): ?Carbon
    {
        return $content->batas_absensi ? Carbon::parse($content->batas_absensi) : null;
    }
}
