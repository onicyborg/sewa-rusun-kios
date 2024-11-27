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
        Schema::create('sewa_gedung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyewa');
            $table->string('kontak_penyewa')->nullable();
            $table->date('tanggal_sewa');
            $table->date('tanggal_akhir_sewa')->nullable();
            $table->integer('durasi_sewa');
            $table->string('keperluan');
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Sudah DP', 'Lunas'])->default('Belum Dibayar');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_gedung');
    }
};
