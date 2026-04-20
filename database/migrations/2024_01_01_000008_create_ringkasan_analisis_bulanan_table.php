<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ringkasan_analisis_bulanan', function (Blueprint $table) {
            $table->id('id_ringkasan');
            $table->date('bulan_tahun')->unique();
            $table->integer('total_kerusakan')->default(0);
            $table->string('komponen_terbanyak_rusak', 100)->nullable();
            $table->integer('frekuensi_komponen')->nullable();
            $table->decimal('durasi_rata_perbaikan', 5, 2)->nullable()->comment('dalam hari');
            $table->decimal('tingkat_repeat_issue', 5, 2)->nullable()->comment('dalam persen');
            $table->integer('total_laptop_bermasalah')->nullable();
            $table->integer('total_tiket_terselesaikan')->nullable();
            $table->decimal('rata_prioritas_urgent_count', 5, 2)->nullable();
            $table->text('rekomendasi')->nullable();
            $table->integer('total_biaya_perbaikan')->nullable();
            $table->text('insight_tambahan')->nullable();
            $table->timestamps();

            $table->index('bulan_tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ringkasan_analisis_bulanan');
    }
};
