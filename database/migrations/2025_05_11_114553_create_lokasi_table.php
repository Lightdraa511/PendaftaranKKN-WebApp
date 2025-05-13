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
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->text('deskripsi')->nullable();
            $table->string('fokus_program')->nullable();
            $table->string('koordinator')->nullable();
            $table->string('kontak_koordinator')->nullable();
            $table->enum('status', ['tersedia', 'terbatas', 'penuh'])->default('tersedia');
            $table->integer('kuota_total');
            $table->integer('kuota_terisi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi');
    }
};
