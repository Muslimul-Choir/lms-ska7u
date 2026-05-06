<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
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
        'tanggal_lahir',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at',
        'tanggal_lahir' => 'date',
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
