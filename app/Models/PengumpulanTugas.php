<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengumpulanTugas extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'pengumpulan_tugas';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_tugas',
        'id_siswa',
        'file_url',
        'catatan',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     public function Tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas');
    }

     public function Siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}

