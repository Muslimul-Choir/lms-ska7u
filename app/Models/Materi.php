<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'materi';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pertemuan',
        'id_mapel',
        'id_guru_mapel',
        'judul',
        'deskripsi',
        'file_url',
        'tipe_materi',
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

    public function GuruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'id_guru_mapel');
    }

    public function Pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }
}

