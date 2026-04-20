<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_laptop')->constrained('laptops', 'id_laptop')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamp('tgl_lapor')->useCurrent();
            $table->text('keluhan_user')->comment('Deskripsi dari karyawan');
            $table->enum('status_tiket', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang');
            $table->timestamp('tgl_dikerjakan_teknisi')->nullable();
            $table->string('area_kerja_user', 100)->nullable();
            $table->text('dampak_produktivitas')->nullable();
            $table->timestamp('tgl_selesai_tiket')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->index('id_laptop');
            $table->index('id_user');
            $table->index('status_tiket');
            $table->index('prioritas');
            $table->index('tgl_lapor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan');
    }
};
