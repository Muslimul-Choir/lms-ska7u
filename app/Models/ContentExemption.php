<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentExemption extends Model
{
    use SoftDeletes;

    protected $table = 'content_exemptions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_siswa',
        'id_guru',
        'tipe_konten',
        'id_konten',
        'alasan',
        'berlaku_hingga',
    ];

    protected $casts = [
        'berlaku_hingga' => 'datetime',
    ];

    protected $dates = [
        'berlaku_hingga',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ── Relationships ──────────────────────────────────────────

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
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
     * Scope untuk siswa tertentu
     */
    public function scopeForSiswa($query, int $idSiswa)
    {
        return $query->where('id_siswa', $idSiswa);
    }

    /**
     * Scope untuk exemption yang masih berlaku
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('berlaku_hingga')
              ->orWhere('berlaku_hingga', '>=', now());
        });
    }

    // ── Helper Methods ──────────────────────────────────────────

    /**
     * Check if exemption is still valid
     */
    public function isValid(): bool
    {
        if (!$this->berlaku_hingga) {
            return true; // No expiry = permanent exemption
        }
        
        return now()->lte($this->berlaku_hingga);
    }
}
