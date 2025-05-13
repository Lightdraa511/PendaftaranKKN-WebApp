<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $fillable = [
        'nama_fakultas',
    ];

    public function programStudi()
    {
        return $this->hasMany(ProgramStudi::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function kuotaFakultas()
    {
        return $this->hasMany(KuotaFakultas::class);
    }
}