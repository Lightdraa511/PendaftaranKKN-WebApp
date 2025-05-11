<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'id_pembayaran',
        'user_id',
        'total_pembayaran',
        'midtrans_snap_token',
        'midtrans_payment_type',
        'midtrans_bank',
        'status',
        'tanggal_bayar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate ID Pembayaran
    public static function generateIdPembayaran()
    {
        $date = date('Ymd');
        $lastPayment = self::where('id_pembayaran', 'like', "KKNM-PAY-{$date}-%")
            ->orderBy('id_pembayaran', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = intval(substr($lastPayment->id_pembayaran, -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "KKNM-PAY-{$date}-" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}