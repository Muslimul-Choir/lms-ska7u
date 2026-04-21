<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penilaian extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'penilaian';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pengumpulan_tugas',
        'id_guru',
        'nilai',
        'nilai_maksimal_snapshot',
        'catatan_guru',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     public function PengumpulanTugas()
    {
        return $this->hasOne(PengumpulanTugas::class, 'id_pengumpulan_tugas');
    }

     public function Guru()
    {
        return $this->hasOne(Guru::class, 'id_guru');
    }
}
