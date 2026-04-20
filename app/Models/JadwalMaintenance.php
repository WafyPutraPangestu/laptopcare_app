<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMaintenance extends Model
{
    use HasFactory;

    protected $table = 'jadwal_maintenance';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = [
        'id_laptop',
        'id_teknisi',
        'tipe_maintenance',
        'tgl_jadwal_maintenance',
        'tgl_selesai_maintenance',
        'status',
        'deskripsi_maintenance',
        'catatan_teknisi',
        'hasil_maintenance',
        'durasi_hari',
        'biaya_maintenance',
    ];

    protected $casts = [
        'tgl_jadwal_maintenance' => 'datetime',
        'tgl_selesai_maintenance' => 'datetime',
    ];

    // Relasi: Jadwal untuk satu Laptop
    public function laptop()
    {
        return $this->belongsTo(Laptop::class, 'id_laptop', 'id_laptop');
    }

    // Relasi: Jadwal ditugaskan ke satu Teknisi
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'id_teknisi', 'id_user');
    }
}
