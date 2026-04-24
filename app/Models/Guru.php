<?php

namespace App\Models;

use App\Models\GuruMapel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'guru';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_user',
        'email',
        'nama_lengkap',
        'status_pengajar',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_wali_kelas');
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class, 'id_guru');
    }
}
