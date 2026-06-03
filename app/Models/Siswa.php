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

    public function Absensi()
    {
        return $this->hasMany(Absensi::class, 'id_siswa');
    }

    public function PengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'id_siswa');
    }

    public function HasilKuis()
    {
        return $this->hasMany(HasilKuis::class, 'id_siswa');
    }


}

