<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kuis extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'kuis';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pertemuan',
        'id_guru_mapel',
        'id_guru',
        'judul',
        'deskripsi',
        'cover_image',
        'durasi',
        'nilai_maksimal',
        'batas_mulai',
        'batas_selesai',
        'status',
        'waktu_rilis',
        'batas_absensi',
        'auto_release',
    ];

    // Cast tipe data kolom
    protected $casts = [
        'batas_mulai'    => 'datetime',
        'batas_selesai'  => 'datetime',
        'waktu_rilis'    => 'datetime',
        'batas_absensi'  => 'datetime',
        'nilai_maksimal' => 'decimal:2',
        'auto_release'   => 'boolean',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'batas_mulai',
        'batas_selesai',
        'waktu_rilis',
        'batas_absensi',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }

    public function GuruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'id_guru_mapel');
    }

    public function Guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function SoalKuis()
    {
        return $this->hasMany(SoalKuis::class, 'id_kuis');
    }

    public function HasilKuis()
    {
        return $this->hasMany(HasilKuis::class, 'id_kuis');
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
     * Scope to get kuis with upcoming deadlines
     */
    public function scopeUpcomingDeadline($query, $hours = 24)
    {
        return $query->where('batas_selesai', '>', now())
                     ->where('batas_selesai', '<=', now()->addHours($hours));
    }

    // ── Accessors & Helpers ──────────────────────────────────────────

    /**
     * Check if kuis is released
     */
    public function isReleased(): bool
    {
        return $this->waktu_rilis && now()->gte($this->waktu_rilis);
    }

    /**
     * Check if kuis is accessible
     */
    public function isAccessible(): bool
    {
        return $this->isReleased();
    }

    /**
     * Check if kuis has expired
     */
    public function isExpired(): bool
    {
        return now()->gt($this->batas_selesai);
    }

    /**
     * Check if kuis is currently active (within start and end time)
     */
    public function isActive(): bool
    {
        return now()->gte($this->batas_mulai) && now()->lte($this->batas_selesai);
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

        if (!$this->isActive()) {
            return 'Belum Dimulai';
        }
        
        return 'Tersedia';
    }
}
