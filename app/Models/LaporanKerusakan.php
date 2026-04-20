<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kerusakan';
    protected $primaryKey = 'id_laporan';
    protected $fillable = [
        'id_laptop',
        'id_user',
        'keluhan_user',
        'status_tiket',
        'prioritas',
        'tgl_dikerjakan_teknisi',
        'area_kerja_user',
        'dampak_produktivitas',
        'tgl_selesai_tiket',
        'catatan_admin',
    ];

    protected $casts = [
        'tgl_lapor' => 'datetime',
        'tgl_dikerjakan_teknisi' => 'datetime',
        'tgl_selesai_tiket' => 'datetime',
    ];

    // Relasi: Laporan dikirim oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi: Laporan mengenai satu Laptop
    public function laptop()
    {
        return $this->belongsTo(Laptop::class, 'id_laptop', 'id_laptop');
    }

    // Relasi: Laporan memiliki satu Riwayat Perbaikan (biasanya)
    public function riwayatPerbaikan()
    {
        return $this->hasOne(RiwayatPerbaikan::class, 'id_laporan', 'id_laporan');
    }

    // Relasi: Laporan bisa memiliki banyak Riwayat Perbaikan (jika ada perbaikan berkali-kali)
    public function riwayatPerbaikanMultiple()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'id_laporan', 'id_laporan');
    }
}
