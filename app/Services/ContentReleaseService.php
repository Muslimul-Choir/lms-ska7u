<?php

namespace App\Services;

use App\Models\Pertemuan;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Kuis;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContentReleaseService
{
    /**
     * Calculate release time based on pertemuan schedule
     * 
     * @param Pertemuan $pertemuan
     * @return Carbon|null
     */
    public function calculateReleaseTime(Pertemuan $pertemuan): ?Carbon
    {
        // Load relationships if not already loaded
        $pertemuan->load(['JadwalBelajar.JamBelajar']);
        
        $jadwal = $pertemuan->JadwalBelajar;
        if (!$jadwal) {
            return null;
        }

        $jamBelajar = $jadwal->JamBelajar;
        if (!$jamBelajar) {
            return null;
        }

        // Combine pertemuan date with jam_mulai from JamBelajar
        $tanggalPertemuan = Carbon::parse($pertemuan->tanggal);
        $jamMulai = Carbon::parse($jamBelajar->jam_mulai);
        
        return $tanggalPertemuan->copy()
            ->setHour($jamMulai->hour)
            ->setMinute($jamMulai->minute)
            ->setSecond(0);
    }

    /**
     * Get content status for display
     * 
     * @param Materi|Tugas|Kuis $content
     * @return string
     */
    public function getContentStatus($content): string
    {
        $cacheKey = sprintf('content_status_%s_%d', class_basename($content), $content->id);
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($content) {
            if (!$content->waktu_rilis) {
                return 'Belum Dijadwalkan';
            }
            
            if (now()->lt($content->waktu_rilis)) {
                return 'Belum Dirilis';
            }
            
            // Check if content has expiry
            if ($content instanceof Tugas && $content->isExpired()) {
                return 'Berakhir';
            }
            
            if ($content instanceof Kuis && $content->isExpired()) {
                return 'Berakhir';
            }
            
            return 'Tersedia';
        });
    }

    /**
     * Check if content is accessible to user
     * 
     * @param Materi|Tugas|Kuis $content
     * @param \App\Models\User|null $user
     * @return bool
     */
    public function isAccessible($content, $user = null): bool
    {
        // Check if content is released
        if (!$content->isReleased()) {
            return false;
        }

        // If user provided, check enrollment
        if ($user && $user->siswa) {
            $siswa = $user->siswa;
            
            // Check if content belongs to student's class
            $pertemuan = $content->Pertemuan;
            if ($pertemuan && $pertemuan->JadwalBelajar) {
                if ($pertemuan->JadwalBelajar->id_kelas !== $siswa->id_kelas) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Process all pending releases (run by scheduler)
     * 
     * @return int Number of content items released
     */
    public function processPendingReleases(): int
    {
        $releasedCount = 0;
        $now = now();

        DB::beginTransaction();
        try {
            // Process Materi - no status field, just check waktu_rilis
            $materis = Materi::where('waktu_rilis', '<=', $now)
                ->whereNotNull('waktu_rilis')
                ->get();
            
            foreach ($materis as $materi) {
                // Materi doesn't have status, just log it was accessible
                Log::info("Materi accessible: {$materi->judul}", ['id' => $materi->id]);
                $releasedCount++;
            }

            // Process Tugas - update status from draft to published
            $tugas = Tugas::where('waktu_rilis', '<=', $now)
                ->where('status', 'draft')
                ->whereNotNull('waktu_rilis')
                ->get();
            
            foreach ($tugas as $t) {
                $t->update(['status' => 'published']);
                Log::info("Tugas released: {$t->judul}", ['id' => $t->id]);
                $releasedCount++;
            }

            // Process Kuis - update status from draft to published
            $kuis = Kuis::where('waktu_rilis', '<=', $now)
                ->where('status', 'draft')
                ->whereNotNull('waktu_rilis')
                ->get();
            
            foreach ($kuis as $k) {
                $k->update(['status' => 'published']);
                Log::info("Kuis released: {$k->judul}", ['id' => $k->id]);
                $releasedCount++;
            }

            DB::commit();
            
            if ($releasedCount > 0) {
                Log::info("Content release completed", ['count' => $releasedCount]);
            }

            return $releasedCount;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Content release failed: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Bulk set release time for multiple content items
     * 
     * @param array $contentIds
     * @param string $contentType ('materi'|'tugas'|'kuis')
     * @param Carbon $releaseTime
     * @param \App\Models\Guru|null $guru - verify ownership
     * @return array ['success' => int, 'failed' => array]
     */
    public function bulkSetReleaseTime(array $contentIds, string $contentType, Carbon $releaseTime, $guru = null): array
    {
        $success = 0;
        $failed = [];

        DB::beginTransaction();
        try {
            $model = match($contentType) {
                'materi' => Materi::class,
                'tugas' => Tugas::class,
                'kuis' => Kuis::class,
                default => throw new \InvalidArgumentException("Invalid content type: {$contentType}")
            };

            $query = $model::whereIn('id', $contentIds);

            // If guru provided, verify ownership through pertemuan
            if ($guru) {
                $query->whereHas('Pertemuan', function ($q) use ($guru) {
                    $q->where('id_guru', $guru->id);
                });
            }

            $items = $query->get();

            foreach ($items as $item) {
                try {
                    $item->update([
                        'waktu_rilis' => $releaseTime,
                        'auto_release' => false // Manual override
                    ]);
                    $success++;
                } catch (\Exception $e) {
                    $failed[] = [
                        'id' => $item->id,
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();
            
            Log::info("Bulk release time set", [
                'type' => $contentType,
                'success' => $success,
                'failed' => count($failed)
            ]);

            return [
                'success' => $success,
                'failed' => $failed
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Bulk release time failed: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Set release time for a single content item
     * 
     * @param Materi|Tugas|Kuis $content
     * @param Carbon|null $releaseTime - if null, auto-calculate
     * @param Carbon|null $batasAbsensi - if null, default to 24 hours after release
     * @return bool
     */
    public function setReleaseTime($content, ?Carbon $releaseTime = null, ?Carbon $batasAbsensi = null): bool
    {
        try {
            // Auto-calculate if not provided and auto_release is true
            if (!$releaseTime && $content->auto_release) {
                $pertemuan = $content->Pertemuan;
                if ($pertemuan) {
                    $releaseTime = $this->calculateReleaseTime($pertemuan);
                }
            }

            // Default batas_absensi to 24 hours after release
            if (!$batasAbsensi && $releaseTime) {
                $batasAbsensi = $releaseTime->copy()->addHours(24);
            }

            $content->update([
                'waktu_rilis' => $releaseTime,
                'batas_absensi' => $batasAbsensi,
            ]);

            // Clear cache
            $cacheKey = sprintf('content_status_%s_%d', class_basename($content), $content->id);
            Cache::forget($cacheKey);

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to set release time", [
                'content_type' => class_basename($content),
                'content_id' => $content->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
