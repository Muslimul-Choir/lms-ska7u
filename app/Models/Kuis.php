<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kuis extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'kuis';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pertemuan',
        'id_guru_mapel',
        'id_guru',
        'judul',
        'deskripsi',
        'durasi',
        'nilai_maksimal',
        'batas_mulai',
        'batas_selesai',
        'status',
    ];

    // Cast tipe data kolom
    protected $casts = [
        'batas_mulai'    => 'datetime',
        'batas_selesai'  => 'datetime',
        'nilai_maksimal' => 'decimal:2',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }

    public function GuruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'id_guru_mapel');
    }

    public function Guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function SoalKuis()
    {
        return $this->hasMany(SoalKuis::class, 'id_kuis');
    }

    public function HasilKuis()
    {
        return $this->hasMany(HasilKuis::class, 'id_kuis');
    }
}
