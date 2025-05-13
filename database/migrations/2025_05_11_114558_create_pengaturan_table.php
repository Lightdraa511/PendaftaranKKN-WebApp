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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();

            // Biaya
            $table->bigInteger('biaya_pendaftaran')->default(750000);
            $table->bigInteger('biaya_administrasi')->default(10000);

            // Periode Pendaftaran
            $table->date('tanggal_mulai_pendaftaran')->nullable();
            $table->date('tanggal_selesai_pendaftaran')->nullable();
            $table->date('tanggal_mulai_pelaksanaan')->nullable();
            $table->date('tanggal_selesai_pelaksanaan')->nullable();

            // Pengumuman
            $table->string('judul_pengumuman')->nullable();
            $table->text('isi_pengumuman')->nullable();
            $table->boolean('tampilkan_pengumuman')->default(true);

            // Pengaturan Lainnya
            $table->boolean('pendaftaran_aktif')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
