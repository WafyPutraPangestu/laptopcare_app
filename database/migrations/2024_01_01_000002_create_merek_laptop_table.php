<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merek_laptop', function (Blueprint $table) {
            $table->id('id_merek');
            $table->string('nama_merek', 100)->unique();
            $table->year('tahun_rilis')->nullable();
            $table->integer('rata_usia_optimal')->default(5)->comment('dalam tahun');
            $table->text('spesifikasi')->nullable();
            $table->timestamps();

            $table->index('nama_merek');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merek_laptop');
    }
};
