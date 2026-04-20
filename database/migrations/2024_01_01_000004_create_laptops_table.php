<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laptops', function (Blueprint $table) {
            $table->id('id_laptop');
            $table->string('kode_aset', 50)->unique()->comment('Nomor inventaris Angkasa Pura');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->onDelete('set null');
            $table->foreignId('id_merek')->constrained('merek_laptop', 'id_merek')->onDelete('restrict');
            $table->string('tipe_model', 100);
            $table->string('nomor_seri', 100)->nullable();
            $table->date('tgl_pengadaan');
            $table->enum('status_kondisi', ['Baik', 'Rusak', 'Dalam Perbaikan'])->default('Baik');
            $table->integer('total_kerusakan_count')->default(0)->comment('counter untuk analisis pola');
            $table->date('tgl_last_maintenance')->nullable();
            $table->decimal('nilai_aset', 12, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('kode_aset');
            $table->index('id_user');
            $table->index('status_kondisi');
            $table->index('tgl_pengadaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
