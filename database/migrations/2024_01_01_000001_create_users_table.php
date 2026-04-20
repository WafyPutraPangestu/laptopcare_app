<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['User', 'Teknisi', 'Kepala_IT'])->default('User');
            $table->string('unit_kerja')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->index('role');
            $table->index('unit_kerja');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
