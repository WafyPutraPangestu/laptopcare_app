<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komponen', function (Blueprint $table) {
            $table->id('id_komponen');
            $table->string('nama_komponen', 100)->unique();
            $table->enum('kategori', ['Hardware', 'Software', 'Jaringan', 'Lainnya'])->default('Hardware');
            $table->integer('frekuensi_kerusakan')->default(0)->comment('counter untuk analisis');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_critical')->default(false)->comment('apakah komponen kritis');
            $table->timestamps();

            $table->index('kategori');
            $table->index('frekuensi_kerusakan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komponen');
    }
};
