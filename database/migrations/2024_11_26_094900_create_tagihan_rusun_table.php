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
        Schema::create('tagihan_rusun', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('bulan'); // Menyimpan angka 1-12
            $table->year('tahun'); // Menyimpan tahun
            $table->unsignedBigInteger('sewa'); // Nilai sewa
            $table->unsignedBigInteger('denda')->nullable(); // Nilai denda
            $table->unsignedBigInteger('air')->nullable(); // Nilai air
            $table->enum('status_post', ['Release', 'Draft'])->default('Draft'); // Status post
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Dibayar'])->default('Belum Dibayar'); // Status pembayaran
            $table->unsignedBigInteger('sewa_rusun_id'); // Foreign key ke tabel sewa_rusun
            $table->timestamps();

            // Foreign key
            $table->foreign('sewa_rusun_id')->references('id')->on('sewa_rusun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_rusun');
    }
};
