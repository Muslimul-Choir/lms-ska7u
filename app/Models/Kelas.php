<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'kelas';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_tingkatan',
        'id_jurusan',
        'id_bagian',
        'id_tahun_ajaran',
        'id_semester',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Tingkatan()
        {
            return $this->hasOne(Tingkatan::class, 'id_tingkatan');
        }    

     public function Jurusan()
    {
        return $this->hasOne(Jurusan::class, 'id_jurusan');
    }

     public function Bagian()
    {
        return $this->hasOne(Bagian::class, 'id_bagian');
    }

     public function TahunAjaran()
    {
        return $this->hasOne(TahunAjaran::class, 'id_tahun_ajaran');
    }

     public function Semester()
    {
        return $this->hasOne(Semester::class, 'id_semester');
    }
}
