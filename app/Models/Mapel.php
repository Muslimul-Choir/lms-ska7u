<?php

namespace App\Models;

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

    public function JadwalBelajar()
    {
        return $this->hasMany(JadwalBelajar::class, 'id_mapel');
    }
}
