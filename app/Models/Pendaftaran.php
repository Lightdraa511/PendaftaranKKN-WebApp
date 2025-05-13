<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'user_id',
        'lokasi_id',
        'golongan_darah',
        'riwayat_penyakit',
        'kontak_darurat_nama',
        'kontak_darurat_telepon',
        'pernyataan_data_benar',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}