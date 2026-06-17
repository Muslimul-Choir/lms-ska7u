<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'materi';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pertemuan',
        'id_mapel',
        'id_guru_mapel',
        'judul',
        'deskripsi',
        'file_url',
        'tipe_materi',
        'status',
        'waktu_rilis',
        'batas_absensi',
        'auto_release',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'waktu_rilis',
        'batas_absensi',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Cast tipe data kolom
    protected $casts = [
        'waktu_rilis' => 'datetime',
        'batas_absensi' => 'datetime',
        'auto_release' => 'boolean',
    ];

     public function Mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function GuruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'id_guru_mapel');
    }

    public function Pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }

    // ── Query Scopes ──────────────────────────────────────────

    /**
     * Scope to get content that is pending release (waktu_rilis in the future or null)
     */
    public function scopePendingRelease($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('waktu_rilis')
              ->orWhere('waktu_rilis', '>', now());
        });
    }

    /**
     * Scope to get content that is already released
     */
    public function scopeReleased($query)
    {
        return $query->where('waktu_rilis', '<=', now());
    }

    /**
     * Scope to get content that is currently accessible (released and not expired)
     */
    public function scopeAccessible($query)
    {
        return $query->whereNotNull('waktu_rilis')
                     ->where('waktu_rilis', '<=', now());
    }

    // ── Accessors & Helpers ──────────────────────────────────────────

    /**
     * Check if content is released
     */
    public function isReleased(): bool
    {
        return $this->waktu_rilis && now()->gte($this->waktu_rilis);
    }

    /**
     * Check if content is accessible to students
     */
    public function isAccessible(): bool
    {
        return $this->isReleased();
    }

    /**
     * Get content status label
     */
    public function getStatusLabelAttribute(): string
    {
        // Use database status field for accurate status
        return match($this->status) {
            'draft' => 'Draft',
            'published' => 'Published',
            default => 'Unknown'
        };
    }
}

