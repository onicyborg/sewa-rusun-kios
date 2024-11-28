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
        Schema::create('keluhan', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi');// Deskripsi keluhan
            $table->enum('status', ['Pending', 'Proses', 'Selesai'])->default('Pending'); // Status keluhan
            $table->unsignedBigInteger('mekanik_id')->nullable(); // Status keluhan
            $table->unsignedBigInteger('sewa_rusun_id'); // Status keluhan
            $table->timestamps();

            // Index untuk optimasi pencarian
            $table->foreign('sewa_rusun_id')->references('id')->on('sewa_rusun');
            $table->foreign('mekanik_id')->references('id')->on('mekanikals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};
