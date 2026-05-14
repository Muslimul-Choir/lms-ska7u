<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    // Nama tabel
    protected $table = 'activity_log';
    protected $primaryKey = 'id';
    
    // Disable updated_at since it doesn't exist in the table
    const UPDATED_AT = null;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_user',
        'aksi',
        'modul',
        'tabel_target',
        'id_target',
        'deskripsi',
        'status_aksi',
        'ip_address',
        'user_agent',
        'session_id',
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
}
