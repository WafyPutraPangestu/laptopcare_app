<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_perbaikan', function (Blueprint $table) {
            $table->id('id_perbaikan');
            $table->foreignId('id_laporan')->constrained('laporan_kerusakan', 'id_laporan')->onDelete('cascade');
            $table->foreignId('id_teknisi')->constrained('users', 'id_user')->onDelete('restrict');
            $table->foreignId('id_komponen')->nullable()->constrained('komponen', 'id_komponen')->onDelete('set null');
            $table->timestamp('tgl_mulai_perbaikan')->useCurrent();
            $table->timestamp('tgl_selesai');
            $table->integer('durasi_perbaikan_hari')->nullable()->comment('dihitung otomatis');
            $table->enum('kategori_rusak', ['Hardware', 'Software', 'Jaringan', 'Lainnya'])->default('Hardware');
            $table->string('komponen_rusak', 100)->comment('catatan komponen yang rusak');
            $table->enum('tingkat_kesulitan', ['Mudah', 'Sedang', 'Sulit'])->default('Sedang');
            $table->text('tindakan_penyelesaian')->comment('Catatan teknis dari teknisi');
            $table->text('rekomendasi_perawatan')->nullable()->comment('Saran untuk planned maintenance');
            $table->decimal('biaya_perbaikan', 10, 2)->nullable();
            $table->boolean('apakah_terjadi_ulang')->default(false)->comment('Track recurring issues');
            $table->string('spare_part_digunakan', 255)->nullable();
            $table->timestamps();

            $table->index('id_laporan');
            $table->index('id_teknisi');
            $table->index('id_komponen');
            $table->index('kategori_rusak');
            $table->index('tgl_selesai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_perbaikan');
    }
};
