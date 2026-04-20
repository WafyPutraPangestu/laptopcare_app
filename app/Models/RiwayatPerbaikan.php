<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerbaikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_perbaikan';
    protected $primaryKey = 'id_perbaikan';
    protected $fillable = [
        'id_laporan',
        'id_teknisi',
        'id_komponen',
        'tgl_mulai_perbaikan',
        'tgl_selesai',
        'durasi_perbaikan_hari',
        'kategori_rusak',
        'komponen_rusak',
        'tingkat_kesulitan',
        'tindakan_penyelesaian',
        'rekomendasi_perawatan',
        'biaya_perbaikan',
        'apakah_terjadi_ulang',
        'spare_part_digunakan',
    ];

    protected $casts = [
        'tgl_mulai_perbaikan' => 'datetime',
        'tgl_selesai' => 'datetime',
        'biaya_perbaikan' => 'decimal:2',
        'apakah_terjadi_ulang' => 'boolean',
    ];

    // Relasi: Perbaikan mengarah ke satu Laporan Kerusakan
    public function laporan()
    {
        return $this->belongsTo(LaporanKerusakan::class, 'id_laporan', 'id_laporan');
    }

    // Relasi: Perbaikan dikerjakan oleh satu Teknisi (User)
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'id_teknisi', 'id_user');
    }

    // Relasi: Perbaikan mengenai satu Komponen
    public function komponen()
    {
        return $this->belongsTo(Komponen::class, 'id_komponen', 'id_komponen');
    }
}
