<?php

namespace App\Models;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use \App\Traits\LogsActivity;
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'kelas';
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_tingkatan',
        'id_jurusan',
        'id_bagian',
        'id_tahun_ajaran',
        'id_wali_kelas',
    ];

    // Accessor yang di-include dalam JSON serialization
    protected $appends = ['nama_kelas'];

    // Kolom tanggal yang otomatis diubah menjadi Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Tingkatan()
    {
        return $this->belongsTo(Tingkatan::class, 'id_tingkatan');
    }

    public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    public function Bagian()
    {
        return $this->belongsTo(Bagian::class, 'id_bagian');
    }

    public function TahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    public function WaliKelas()
    {
        return $this->belongsTo(Guru::class, 'id_wali_kelas');
    }

    public function Siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }

    /**
     * Accessor untuk mendapatkan nama kelas berdasarkan relasi
     */
    public function getNamaKelasAttribute()
    {
        $tingkatan = $this->Tingkatan?->nama_tingkatan ?? '';
        $jurusan = $this->Jurusan?->nama_jurusan ?? '';
        $bagian = $this->Bagian?->nama_bagian ?? '';

        return trim("{$tingkatan} {$jurusan} {$bagian}");
    }
}

