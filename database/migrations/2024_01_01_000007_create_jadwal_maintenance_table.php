<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_maintenance', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_laptop')->constrained('laptops', 'id_laptop')->onDelete('cascade');
            $table->foreignId('id_teknisi')->nullable()->constrained('users', 'id_user')->onDelete('set null');
            $table->enum('tipe_maintenance', ['Rutin', 'Darurat', 'Preventif'])->default('Rutin');
            $table->timestamp('tgl_jadwal_maintenance');
            $table->timestamp('tgl_selesai_maintenance')->nullable();
            $table->enum('status', ['Dijadwalkan', 'Selesai', 'Dibatalkan'])->default('Dijadwalkan');
            $table->text('deskripsi_maintenance')->nullable();
            $table->text('catatan_teknisi')->nullable();
            $table->text('hasil_maintenance')->nullable();
            $table->integer('durasi_hari')->nullable();
            $table->decimal('biaya_maintenance', 10, 2)->nullable();
            $table->timestamps();

            $table->index('id_laptop');
            $table->index('id_teknisi');
            $table->index('tipe_maintenance');
            $table->index('status');
            $table->index('tgl_jadwal_maintenance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_maintenance');
    }
};
