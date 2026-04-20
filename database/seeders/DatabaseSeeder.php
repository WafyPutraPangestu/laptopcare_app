<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== AKUN TEST LOGIN ====================

        // 1. Kepala IT (Admin)
        User::create([
            'nama_lengkap'     => 'Kepala IT - Admin',
            'username'         => 'kepala_it',
            'password'         => Hash::make('password123'),
            'role'             => 'Kepala_IT',
            'unit_kerja'       => 'Divisi IT',
            'email'            => 'kepala.it@angkasa.pura',
            'is_active'       => true,
            'email_verified_at' => now(),
        ]);

        // 2. Teknisi
        User::create([
            'nama_lengkap'     => 'Teknisi Senior',
            'username'         => 'teknisi1',
            'password'         => Hash::make('password123'),
            'role'             => 'Teknisi',
            'unit_kerja'       => 'Divisi IT',
            'email'            => 'teknisi@angkasa.pura',
            'is_active'       => true,
            'email_verified_at' => now(),
        ]);

        // 3. User Biasa (Karyawan)
        User::create([
            'nama_lengkap'     => 'Budi Santoso',
            'username'         => 'budi_karyawan',
            'password'         => Hash::make('password123'),
            'role'             => 'User',
            'unit_kerja'       => 'Operasional',
            'email'            => 'budi@angkasa.pura',
            'is_active'       => true,
            'email_verified_at' => now(),
        ]);

        // 4. User Biasa kedua (untuk testing multiple user)
        User::create([
            'nama_lengkap'     => 'Siti Rahayu',
            'username'         => 'siti_karyawan',
            'password'         => Hash::make('password123'),
            'role'             => 'User',
            'unit_kerja'       => 'Keuangan',
            'email'            => 'siti@angkasa.pura',
            'is_active'       => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ 4 akun test login berhasil dibuat!');
        $this->command->info('   Username & Password:');
        $this->command->info('   • kepala_it          / password123');
        $this->command->info('   • teknisi1           / password123');
        $this->command->info('   • budi_karyawan      / password123');
        $this->command->info('   • siti_karyawan      / password123');
    }
}
