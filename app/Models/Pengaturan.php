<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'biaya_pendaftaran',
        'biaya_administrasi',
        'tanggal_mulai_pendaftaran',
        'tanggal_selesai_pendaftaran',
        'tanggal_mulai_pelaksanaan',
        'tanggal_selesai_pelaksanaan',
        'judul_pengumuman',
        'isi_pengumuman',
        'tampilkan_pengumuman',
        'pendaftaran_aktif',
    ];

    protected $casts = [
        'tanggal_mulai_pendaftaran' => 'date',
        'tanggal_selesai_pendaftaran' => 'date',
        'tanggal_mulai_pelaksanaan' => 'date',
        'tanggal_selesai_pelaksanaan' => 'date',
        'tampilkan_pengumuman' => 'boolean',
        'pendaftaran_aktif' => 'boolean',
    ];

    // Mendapatkan pengaturan saat ini
    public static function getCurrent()
    {
        return self::first() ?? self::create([
            'biaya_pendaftaran' => 750000,
            'biaya_administrasi' => 10000,
            'tanggal_mulai_pendaftaran' => now(),
            'tanggal_selesai_pendaftaran' => now()->addDays(14),
            'tanggal_mulai_pelaksanaan' => now()->addMonth(),
            'tanggal_selesai_pelaksanaan' => now()->addMonth()->addDays(14),
            'judul_pengumuman' => 'Pendaftaran KKNM Dibuka',
            'isi_pengumuman' => 'Pendaftaran KKNM periode ' . date('Y') . ' telah dibuka.',
            'tampilkan_pengumuman' => true,
            'pendaftaran_aktif' => true,
        ]);
    }
}