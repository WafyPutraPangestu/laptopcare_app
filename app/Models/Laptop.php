<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $table = 'laptops';
    protected $primaryKey = 'id_laptop';
    protected $fillable = [
        'kode_aset',
        'id_user',
        'id_merek',
        'tipe_model',
        'nomor_seri',
        'tgl_pengadaan',
        'status_kondisi',
        'total_kerusakan_count',
        'tgl_last_maintenance',
        'nilai_aset',
        'catatan',
    ];

    protected $casts = [
        'tgl_pengadaan' => 'date',
        'tgl_last_maintenance' => 'date',
        'nilai_aset' => 'decimal:2',
    ];

    // Relasi: Laptop dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi: Laptop memiliki satu Merek
    public function merek()
    {
        return $this->belongsTo(MerekLaptop::class, 'id_merek', 'id_merek');
    }

    // Relasi: Laptop memiliki banyak Laporan Kerusakan
    public function laporanKerusakan()
    {
        return $this->hasMany(LaporanKerusakan::class, 'id_laptop', 'id_laptop');
    }

    // Relasi: Laptop memiliki banyak Jadwal Maintenance
    public function jadwalMaintenance()
    {
        return $this->hasMany(JadwalMaintenance::class, 'id_laptop', 'id_laptop');
    }
}
