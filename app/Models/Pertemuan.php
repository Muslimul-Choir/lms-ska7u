<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

     public function JadwalBelajar()
    {
        return $this->belongsTo(JadwalBelajar::class, 'id_jadwal');
    }

    public function materis()
    {
        return $this->hasMany(Materi::class, 'id_pertemuan');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'id_pertemuan');
    }
}

