<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gurumapel extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'guru_mapel';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_,mapel',
        'id_guru',
        'id_kelas',
        'id_semester',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     public function Mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

     public function Guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

     public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

     public function Semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester');
    }
}
