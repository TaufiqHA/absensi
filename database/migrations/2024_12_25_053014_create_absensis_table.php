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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama absensi
            $table->foreignId('user_id') // Foreign Key ke tabel siswa
                ->constrained('siswas') // Asumsikan tabel siswa memiliki kolom id sebagai primary key
                ->cascadeOnDelete()->cascadeOnUpdate(); // Hapus absensi jika siswa dihapus
            $table->date('tanggal'); // Tanggal absensi
            $table->time('jam_masuk')->nullable(); // Jam masuk (nullable)
            $table->string('foto_masuk')->nullable(); // Path foto masuk (nullable)
            $table->time('jam_keluar')->nullable(); // Jam keluar (nullable)
            $table->string('foto_keluar')->nullable(); // Path foto keluar (nullable)
            $table->string('keterangan')->nullable(); // Keterangan absensi (nullable)
            $table->enum('status', ['hadir', 'izin', 'alfa'])->nullable(); // Status absensi
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
