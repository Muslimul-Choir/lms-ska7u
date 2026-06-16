<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'absensi';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pertemuan',
        'id_siswa',
        'status',
        'waktu_absen',
        'keterangan',
        'tipe_konten',
        'id_konten',
        'batas_waktu_absen',
        'status_keterlambatan',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'waktu_absen',
        'batas_waktu_absen',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
        'batas_waktu_absen' => 'datetime',
    ];

     public function Pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    // Polymorphic relationship to content
    public function content()
    {
        return $this->morphTo(null, 'tipe_konten', 'id_konten');
    }

    // ── Query Scopes ──────────────────────────────────────────

    /**
     * Scope untuk content tertentu
     */
    public function scopeForContent($query, string $tipeKonten, int $idKonten)
    {
        return $query->where('tipe_konten', $tipeKonten)
                     ->where('id_konten', $idKonten);
    }

    /**
     * Scope untuk pertemuan tertentu
     */
    public function scopeForPertemuan($query, int $idPertemuan)
    {
        return $query->where('id_pertemuan', $idPertemuan);
    }

    // ── Helper Methods ──────────────────────────────────────────

    /**
     * Check if attendance was marked on time
     */
    public function isOnTime(): bool
    {
        if (!$this->waktu_absen || !$this->batas_waktu_absen) {
            return true; // No deadline or no mark time
        }
        
        return $this->waktu_absen->lte($this->batas_waktu_absen);
    }

    /**
     * Get lateness status
     */
    public function getLatenessStatus(): string
    {
        if (!$this->waktu_absen || !$this->batas_waktu_absen) {
            return 'tepat_waktu';
        }

        $minutesLate = $this->batas_waktu_absen->diffInMinutes($this->waktu_absen, false);
        
        if ($minutesLate <= 0) {
            return 'tepat_waktu';
        } elseif ($minutesLate <= 15) {
            return 'terlambat';
        } else {
            return 'sangat_terlambat';
        }
    }
}