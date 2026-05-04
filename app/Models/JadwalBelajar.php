<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalBelajar extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_belajar';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_guru_mapel',
        'id_mapel',       
        'id_jam',
        'id_kelas',
        'hari',
        'nama_kegiatan',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    // ── Relasi ──────────────────────────────────────────

    public function JamBelajar()
    {
        return $this->belongsTo(JamBelajar::class, 'id_jam');
    }

    public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function GuruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'id_guru_mapel');
    }

    public function Mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    // ── Accessors ────────────────────────────────────────

    // Nama yang ditampilkan di grid kalender
    public function getNamaDisplayAttribute(): string
    {
        // 1. Kegiatan non-mapel (Istirahat, Upacara, dll)
        if ($this->nama_kegiatan) {
            return $this->nama_kegiatan;
        }

        // 2. Relasi langsung ke mapel (id_mapel)
        if ($this->Mapel) {
            return $this->Mapel->nama_mapel;
        }

        // 3. Fallback lewat guru_mapel → mapel
        return $this->GuruMapel?->Mapel?->nama_mapel ?? '-';
    }

    // Nama guru yang ditampilkan di grid kalender
    public function getNamaGuruAttribute(): string
    {
        return $this->GuruMapel?->Guru?->nama_lengkap ?? '';
    }
}