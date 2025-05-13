<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Notification handler
    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $order_id = $notification->order_id;
            $status_code = $notification->status_code;
            $transaction_status = $notification->transaction_status;
            $payment_type = $notification->payment_type;

            $pembayaran = Pembayaran::where('id_pembayaran', $order_id)->first();

            if ($pembayaran) {
                // Update data midtrans
                $pembayaran->midtrans_payment_type = $payment_type;

                // Bank untuk metode bank_transfer
                if ($payment_type == 'bank_transfer' && isset($notification->va_numbers[0]->bank)) {
                    $pembayaran->midtrans_bank = $notification->va_numbers[0]->bank;
                }

                // Update status berdasarkan transaction_status
                if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
                    $pembayaran->status = 'sukses';
                    $pembayaran->tanggal_bayar = now();

                    // Update status pembayaran di user
                    $user = User::find($pembayaran->user_id);
                    if ($user) {
                        $user->status_pembayaran = 'lunas';
                        $user->save();
                    }
                } else if ($transaction_status == 'pending') {
                    $pembayaran->status = 'pending';
                } else {
                    $pembayaran->status = 'gagal';
                }

                $pembayaran->save();

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Pembayaran tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}