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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lokasi_id')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->string('kontak_darurat_nama')->nullable();
            $table->string('kontak_darurat_telepon')->nullable();
            $table->text('pernyataan_data_benar')->nullable();
            $table->enum('status', ['draft', 'terdaftar'])->default('draft');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lokasi_id')->references('id')->on('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
