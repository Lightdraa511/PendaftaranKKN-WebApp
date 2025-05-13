<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $fillable = [
        'nama_lokasi',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'deskripsi',
        'fokus_program',
        'koordinator',
        'kontak_koordinator',
        'status',
        'kuota_total',
        'kuota_terisi',
    ];

    public function kuotaFakultas()
    {
        return $this->hasMany(KuotaFakultas::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // Method untuk cek status lokasi berdasarkan kuota
    public function updateStatusKuota()
    {
        if ($this->kuota_terisi >= $this->kuota_total) {
            $this->status = 'penuh';
        } elseif ($this->kuota_terisi / $this->kuota_total >= 0.7) {
            $this->status = 'terbatas';
        } else {
            $this->status = 'tersedia';
        }

        $this->save();
    }
}