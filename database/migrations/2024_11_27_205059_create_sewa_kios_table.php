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
        Schema::create('sewa_kios', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai_kontrak');
            $table->date('tanggal_selesai_kontrak');
            $table->enum('status', ['active', 'expired']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kios_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('kios_id')->references('id')->on('kios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_kios');
    }
};
