<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjaran extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'nama_tahun',
        'is_aktif',
    ];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Kelas()
    {
        return $this->hasMany(Kelas::class, 'id_tahun_ajaran');
    }

    public function Semester() {
        return $this->hasMany(Semester::class, 'id_tahun_ajaran');
    }
}
