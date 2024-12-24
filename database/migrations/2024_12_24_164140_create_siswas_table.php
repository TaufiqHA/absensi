<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('nis', 255);
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete()->cascadeOnUpdate();
            // Foreign Key ke tabel kelas, null jika tidak ada kelas, hapus relasi jika kelas dihapus
            $table->rememberToken(); // remember_token (default 100 karakter)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
