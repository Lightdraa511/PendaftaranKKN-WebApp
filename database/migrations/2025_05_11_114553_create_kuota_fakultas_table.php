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
        Schema::create('kuota_fakultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lokasi_id');
            $table->unsignedBigInteger('fakultas_id');
            $table->integer('kuota');
            $table->integer('terisi')->default(0);
            $table->timestamps();
            $table->foreign('lokasi_id')->references('id')->on('lokasi');
            $table->foreign('fakultas_id')->references('id')->on('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuota_fakultas');
    }
};
