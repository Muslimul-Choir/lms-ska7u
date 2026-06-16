<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tugas extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'tugas';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pertemuan',
        'id_mapel',
        'id_guru_mapel',
        'id_guru',
        'judul',
        'deskripsi',
        'file_url',
        'tipe_tugas',
        'tipe_file',
        'batas_waktu',
        'nilai_maksimal',
        'status',
        'allow_late',
        'waktu_rilis',
        'batas_absensi',
        'auto_release',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'batas_waktu',
        'waktu_rilis',
        'batas_absensi',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Cast tipe data kolom
    protected $casts = [
        'batas_waktu' => 'datetime',
        'waktu_rilis' => 'datetime',
        'batas_absensi' => 'datetime',
        'auto_release' => 'boolean',
        'allow_late' => 'boolean',
        'nilai_maksimal' => 'decimal:2',
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

    public function Guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function PengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'id_tugas');
    }

    // ── Query Scopes ──────────────────────────────────────────

    /**
     * Scope to get content that is pending release
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
     * Scope to get content that is currently accessible
     */
    public function scopeAccessible($query)
    {
        return $query->whereNotNull('waktu_rilis')
                     ->where('waktu_rilis', '<=', now());
    }

    /**
     * Scope to get content with upcoming deadlines
     */
    public function scopeUpcomingDeadline($query, $hours = 24)
    {
        return $query->where('batas_waktu', '>', now())
                     ->where('batas_waktu', '<=', now()->addHours($hours));
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
     * Check if content is accessible
     */
    public function isAccessible(): bool
    {
        return $this->isReleased();
    }

    /**
     * Check if deadline has passed
     */
    public function isExpired(): bool
    {
        return now()->gt($this->batas_waktu);
    }

    /**
     * Get content status label
     */
    public function getStatusLabelAttribute(): string
    {
        if (!$this->waktu_rilis) {
            return 'Belum Dijadwalkan';
        }
        
        if (now()->lt($this->waktu_rilis)) {
            return 'Belum Dirilis';
        }

        if ($this->isExpired()) {
            return 'Berakhir';
        }
        
        return 'Tersedia';
    }
}

