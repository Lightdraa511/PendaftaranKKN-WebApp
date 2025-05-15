<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Tampilkan halaman pembayaran
    public function index()
    {
        $user = Auth::user();
        $pengaturan = Pengaturan::getCurrent();
        $riwayatPembayaran = Pembayaran::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.payment', compact('user', 'pengaturan', 'riwayatPembayaran'));
    }

    // Proses pembayaran - memunculkan Snap Midtrans
    public function process(Request $request)
    {
        $user = Auth::user();
        $pengaturan = Pengaturan::getCurrent();

        // Cek apakah user sudah pernah bayar
        if ($user->status_pembayaran === 'lunas') {
            return redirect()->route('pembayaran.index')
                ->with('info', 'Anda sudah melakukan pembayaran');
        }

        // Hitung total pembayaran
        $totalPembayaran = $pengaturan->biaya_pendaftaran + $pengaturan->biaya_administrasi;

        // Buat record pembayaran
        $pembayaran = new Pembayaran();
        $pembayaran->id_pembayaran = $this->generateIdPembayaran();
        $pembayaran->user_id = $user->id;
        $pembayaran->total_pembayaran = $totalPembayaran;
        $pembayaran->status = 'pending';
        $pembayaran->save();

        // Setup parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $pembayaran->id_pembayaran,
                'gross_amount' => $totalPembayaran,
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap,
                'email' => $user->email,
                'phone' => $user->no_telepon,
            ],
            'item_details' => [
                [
                    'id' => 'KKNM001',
                    'price' => $pengaturan->biaya_pendaftaran,
                    'quantity' => 1,
                    'name' => 'Biaya Pendaftaran KKNM',
                ],
                [
                    'id' => 'KKNM002',
                    'price' => $pengaturan->biaya_administrasi,
                    'quantity' => 1,
                    'name' => 'Biaya Administrasi',
                ],
            ],
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Update pembayaran dengan snap token
            $pembayaran->midtrans_snap_token = $snapToken;
            $pembayaran->save();

            // Tampilkan halaman dengan snap token
            return view('user.payment-process', compact('snapToken', 'pembayaran'));
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->route('pembayaran.index')
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silahkan coba lagi.');
        }
    }

    // Halaman finish setelah pembayaran
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $pembayaran = Pembayaran::where('id_pembayaran', $orderId)->firstOrFail();

        try {
            // Cek status transaksi di Midtrans
            $status = Transaction::status($orderId);

            // Update pembayaran berdasarkan status dari Midtrans
            if ($status) {
                $pembayaran->midtrans_payment_type = $status->payment_type ?? null;

                if (isset($status->va_numbers[0]->bank)) {
                    $pembayaran->midtrans_bank = $status->va_numbers[0]->bank;
                }

                if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    $pembayaran->status = 'sukses';
                    $pembayaran->tanggal_bayar = now();

                    // Update status pembayaran di user
                    $user = $pembayaran->user;
                    $user->status_pembayaran = 'lunas';
                    $user->save();

                    // Simpan perubahan status pembayaran
                    $pembayaran->save();

                    return redirect()->route('pembayaran.index')
                        ->with('success', 'Pembayaran berhasil! Status pembayaran Anda telah diperbarui.');
                } else if ($status->transaction_status == 'pending') {
                    $pembayaran->status = 'pending';

                    return redirect()->route('pembayaran.index')
                        ->with('info', 'Pembayaran sedang diproses. Silakan cek status pembayaran Anda nanti.');
                } else {
                    // Karena enum status hanya menerima 'pending' atau 'sukses'
                    $pembayaran->status = 'pending';

                    return redirect()->route('pembayaran.index')
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                }

                $pembayaran->save();
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Status Error: ' . $e->getMessage());
        }

        return redirect()->route('pembayaran.index');
    }

    // Cek status pembayaran
    public function checkStatus($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->user_id != Auth::id() && !Auth::guard('admin')->check()) {
            abort(403);
        }

        try {
            // Cek status transaksi di Midtrans
            $status = Transaction::status($pembayaran->id_pembayaran);

            // Update pembayaran berdasarkan status dari Midtrans
            if ($status) {
                $pembayaran->midtrans_payment_type = $status->payment_type ?? null;

                if (isset($status->va_numbers[0]->bank)) {
                    $pembayaran->midtrans_bank = $status->va_numbers[0]->bank;
                }

                if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    $pembayaran->status = 'sukses';
                    $pembayaran->tanggal_bayar = now();

                    // Update status pembayaran di user
                    $user = $pembayaran->user;
                    $user->status_pembayaran = 'lunas';
                    $user->save();

                    // Simpan perubahan status pembayaran
                    $pembayaran->save();

                    return redirect()->route('pembayaran.index')
                        ->with('success', 'Pembayaran berhasil! Status pembayaran Anda telah diperbarui.');
                } else if ($status->transaction_status == 'pending') {
                    $pembayaran->status = 'pending';

                    return redirect()->route('pembayaran.index')
                        ->with('info', 'Pembayaran sedang diproses. Silakan cek status pembayaran Anda nanti.');
                } else {
                    // Karena enum status hanya menerima 'pending' atau 'sukses'
                    $pembayaran->status = 'pending';

                    return redirect()->route('pembayaran.index')
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                }

                $pembayaran->save();
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Status Error: ' . $e->getMessage());
            return redirect()->route('pembayaran.index')
                ->with('error', 'Terjadi kesalahan saat memeriksa status pembayaran.');
        }
    }

    // Generate ID Pembayaran
    private function generateIdPembayaran()
    {
        $date = date('Ymd');
        $lastPayment = Pembayaran::where('id_pembayaran', 'like', "KKNM-PAY-{$date}-%")
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
