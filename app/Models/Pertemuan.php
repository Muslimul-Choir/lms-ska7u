<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Pertemuan extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'pertemuan';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_jadwal',
        'id_guru',
        'created_by',
        'nomor_pertemuan',
        'tanggal',
        'status',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // ── Relasi ──────────────────────────────────────────

     public function JadwalBelajar()
    {
        return $this->belongsTo(JadwalBelajar::class, 'id_jadwal');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function materis()
    {
        return $this->hasMany(Materi::class, 'id_pertemuan');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'id_pertemuan');
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'id_pertemuan');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_pertemuan');
    }
}

