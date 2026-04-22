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
        'id_wali_kelas',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Tingkatan()
        {
            return $this->belongsTo(Tingkatan::class, 'id_tingkatan');
        }    

     public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

     public function Bagian()
    {
        return $this->belongsTo(Bagian::class, 'id_bagian');
    }

     public function TahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

     public function Guru()
    {
        return $this->belongsTo(Guru::class, 'id_wali_kelas');
    }
}
