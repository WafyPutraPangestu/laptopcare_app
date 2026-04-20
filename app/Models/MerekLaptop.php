<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerekLaptop extends Model
{
    use HasFactory;

    protected $table = 'merek_laptop';
    protected $primaryKey = 'id_merek';
    protected $fillable = [
        'nama_merek',
        'tahun_rilis',
        'rata_usia_optimal',
        'spesifikasi',
    ];

    // Relasi: Merek memiliki banyak Laptop
    public function laptops()
    {
        return $this->hasMany(Laptop::class, 'id_merek', 'id_merek');
    }
}
