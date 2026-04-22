<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalBelajar extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'jadwal_belajar';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_jam',
        'id_kelas',
        'hari',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     public function JamBelajar()
    {
        return $this->belongsTo(JamBelajar::class, 'id_jam');
    }

     public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
