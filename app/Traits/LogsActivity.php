<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Boot the trait to listen for model events.
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logAction($model, 'CREATE');
        });

        static::updated(function ($model) {
            // Check if it's a soft delete or restore (since some models use SoftDeletes)
            if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($model))) {
                if ($model->isDirty('deleted_at') && $model->deleted_at !== null) {
                    return; // Covered by deleted event
                }
            }
            self::logAction($model, 'UPDATE');
        });

        static::deleted(function ($model) {
            self::logAction($model, 'DELETE');
        });
    }

    /**
     * Log the action to the activity_log table.
     */
    protected static function logAction($model, $action)
    {
        try {
            $table = $model->getTable();
            $id = $model->getKey();
            $name = class_basename($model);
            
            // Build a descriptive text
            $desc = "Melakukan $action pada data $name (ID: $id)";
            if ($action === 'UPDATE') {
                $changes = array_keys($model->getChanges());
                // Remove hidden/timestamp fields if needed
                $changes = array_diff($changes, ['updated_at']);
                if (count($changes) > 0) {
                    $desc .= ". Mengubah: " . implode(', ', $changes);
                }
            } elseif ($action === 'CREATE') {
                // If there's a name or judul field, let's include it
                $title = $model->judul ?? $model->nama ?? $model->name ?? $model->nama_lengkap ?? null;
                if ($title) {
                    $desc .= " - $title";
                }
            }

            // Determine user ID
            $userId = Auth::id();
            if (!$userId) {
                if ($name === 'User' || $name === 'Siswa' || $name === 'Guru') {
                    $userId = $model->id ?? $model->user_id ?? 1;
                } else {
                    $userId = 1; // Fallback to System/Admin ID
                }
            }

            ActivityLog::create([
                'id_user' => $userId,
                'aksi' => $action,
                'modul' => strtoupper($name),
                'tabel_target' => $table,
                'id_target' => $id,
                'deskripsi' => substr($desc, 0, 500),
                'status_aksi' => 'sukses',
                'ip_address' => Request::ip() ?? '127.0.0.1',
                'user_agent' => substr(Request::userAgent() ?? 'Unknown', 0, 300),
                'session_id' => session()->getId(),
            ]);
        } catch (\Exception $e) {
            // Fail silently to not disrupt the main flow
            \Log::error("Failed to log activity: " . $e->getMessage());
        }
    }
}
