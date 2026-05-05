<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes;

    protected $table = 'siswa';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_user',
        'nama_lengkap',
        'email',
        'agama',
        'id_kelas',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

     public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}

