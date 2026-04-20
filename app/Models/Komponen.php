<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    use HasFactory;

    protected $table = 'komponen';
    protected $primaryKey = 'id_komponen';
    protected $fillable = [
        'nama_komponen',
        'kategori',
        'frekuensi_kerusakan',
        'deskripsi',
        'is_critical',
    ];

    protected $casts = [
        'is_critical' => 'boolean',
    ];

    // Relasi: Komponen memiliki banyak Riwayat Perbaikan
    public function riwayatPerbaikan()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'id_komponen', 'id_komponen');
    }
}
