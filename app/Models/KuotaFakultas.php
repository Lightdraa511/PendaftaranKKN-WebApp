<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaFakultas extends Model
{
    use HasFactory;

    protected $table = 'kuota_fakultas';

    protected $fillable = [
        'lokasi_id',
        'fakultas_id',
        'kuota',
        'terisi',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }
}