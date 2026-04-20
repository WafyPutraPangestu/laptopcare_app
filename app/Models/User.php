<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama_lengkap', 'username', 'password', 'role', 'unit_kerja', 'email', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $primaryKey = 'id_user';
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
    // Relasi: User memiliki banyak Laptop
    public function laptops()
    {
        return $this->hasMany(Laptop::class, 'id_user', 'id_user');
    }

    // Relasi: User (Karyawan) membuat banyak Laporan Kerusakan
    public function laporanKerusakan()
    {
        return $this->hasMany(LaporanKerusakan::class, 'id_user', 'id_user');
    }

    // Relasi: User (Teknisi) mengerjakan banyak Riwayat Perbaikan
    public function riwayatPerbaikan()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'id_teknisi', 'id_user');
    }

    // Relasi: User (Teknisi) membuat banyak Jadwal Maintenance
    public function jadwalMaintenance()
    {
        return $this->hasMany(JadwalMaintenance::class, 'id_teknisi', 'id_user');
    }
}
