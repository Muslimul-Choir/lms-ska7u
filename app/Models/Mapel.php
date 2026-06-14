<?php

namespace App\Models;

use App\Models\GuruMapel;
use App\Models\JadwalBelajar;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'mapel';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'agama',
        'deskripsi',
        'foto',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function GuruMapel()
    {
        return $this->hasMany(GuruMapel::class, 'id_mapel');
    }

    public function Tugas()
    {
        return $this->hasMany(Tugas::class, 'id_mapel');
    }

    public function Materi()
    {
        return $this->hasMany(Materi::class, 'id_mapel');
    }

    public function JadwalBelajar()
    {
        return $this->hasMany(JadwalBelajar::class, 'id_mapel');
    }

    /**
     * Scope untuk filter mapel berdasarkan agama siswa
     * Mapel yang agama = null (umum) akan selalu muncul
     * Mapel yang agama = agama siswa juga akan muncul
     */
    public function scopeForAgama($query, $agama)
    {
        return $query->where(function ($q) use ($agama) {
            $q->whereNull('agama')  // Mapel umum
              ->orWhere('agama', $agama);  // Mapel sesuai agama siswa
        });
    }
}
