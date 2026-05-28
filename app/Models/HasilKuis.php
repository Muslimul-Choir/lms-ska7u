<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HasilKuis extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'hasil_kuis';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_kuis',
        'id_siswa',
        'jawaban',
        'nilai',
        'jumlah_benar',
        'waktu_mulai',
        'waktu_selesai',
    ];

    // Cast tipe data kolom
    protected $casts = [
        'jawaban'       => 'array',
        'nilai'         => 'decimal:2',
        'waktu_mulai'   => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Kuis()
    {
        return $this->belongsTo(Kuis::class, 'id_kuis');
    }

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
