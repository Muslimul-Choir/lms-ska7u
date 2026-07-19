<?php

namespace App\Listeners;

use App\Events\ContentUpdated;
use Illuminate\Support\Facades\Cache;

class BroadcastContentUpdate
{
    /**
     * Handle the event.
     */
    public function handle(ContentUpdated $event): void
    {
        // Store update information di cache untuk setiap kelas yang affected
        foreach ($event->kelasIds as $kelasId) {
            $cacheKey = "content_updates_{$kelasId}";
            
            // Get existing updates atau buat array baru
            $updates = Cache::get($cacheKey, []);
            
            // Add new update
            $updates[] = [
                'contentType' => $event->contentType,
                'action' => $event->action,
                'contentId' => $event->contentId,
                'timestamp' => now()->toIso8601String(),
                'data' => $event->data,
            ];
            
            // Store di cache selama 5 menit
            Cache::put($cacheKey, $updates, now()->addMinutes(5));
        }
        
        \Log::info("ContentUpdated event broadcast", [
            'type' => $event->contentType,
            'action' => $event->action,
            'id' => $event->contentId,
            'kelas_count' => count($event->kelasIds),
        ]);
    }
}
