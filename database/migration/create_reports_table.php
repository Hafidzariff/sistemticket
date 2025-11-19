<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('departemen');
            $table->date('tanggal_laporan');
            $table->string('jenis_masalah');
            $table->text('deskripsi');
            $table->enum('status', ['Baru', 'Sedang Dikerjakan', 'Selesai'])->default('Baru');
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan_teknisi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reports');
    }
};
