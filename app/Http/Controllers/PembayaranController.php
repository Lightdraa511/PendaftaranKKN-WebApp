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
    public function index(Request $request)
    {
        $user = Auth::user();
        $pengaturan = Pengaturan::getCurrent();

        // Cek jika ada status close dari halaman pembayaran (user keluar dari jendela pembayaran)
        if ($request->status == 'close' || $request->status == 'error') {
            // Cari pembayaran pending terakhir dan hapus karena user batal bayar
            $lastPendingPayment = Pembayaran::where('user_id', $user->id)
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastPendingPayment) {
                $lastPendingPayment->delete();

                if ($request->status == 'close') {
                    return redirect()->route('pembayaran.index')
                        ->with('info', 'Pembayaran dibatalkan. Anda dapat mencoba kembali kapan saja.');
                } else {
                    return redirect()->route('pembayaran.index')
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                }
            }
        }

        // Hapus pembayaran pending yang sudah lama (lebih dari 1 jam)
        $oldPendingPayments = Pembayaran::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subHour())
            ->get();

        foreach ($oldPendingPayments as $oldPayment) {
            $oldPayment->delete();
        }

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

        // Hapus pembayaran pending sebelumnya jika ada
        $pendingPayments = Pembayaran::where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        foreach ($pendingPayments as $pendingPayment) {
            $pendingPayment->delete();
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
            // Rollback - hapus pembayaran jika terjadi error
            $pembayaran->delete();

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
        $status_param = $request->status;

        try {
            // Cek status transaksi di Midtrans
            $midtransStatus = Transaction::status($orderId);

            // Update pembayaran berdasarkan status dari Midtrans
            if ($midtransStatus) {
                // Dapatkan payment_type dari hasil midtrans
                $pembayaran->midtrans_payment_type = isset($midtransStatus->payment_type) ?
                    $midtransStatus->payment_type : null;

                // Cek dan ambil bank jika ada
                if (isset($midtransStatus->va_numbers) &&
                    is_array($midtransStatus->va_numbers) &&
                    !empty($midtransStatus->va_numbers) &&
                    isset($midtransStatus->va_numbers[0]->bank)) {
                    $pembayaran->midtrans_bank = $midtransStatus->va_numbers[0]->bank;
                }

                // Cek transaction_status
                $transactionStatus = isset($midtransStatus->transaction_status) ?
                    $midtransStatus->transaction_status : null;

                if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
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
                }
                elseif ($transactionStatus == 'pending') {
                    $pembayaran->status = 'pending';
                    $pembayaran->save();

                    return redirect()->route('pembayaran.index')
                        ->with('info', 'Pembayaran sedang diproses. Silakan cek status pembayaran Anda nanti.');
                }
                else {
                    // Rollback - hapus pembayaran jika gagal
                    $pembayaran->delete();

                    return redirect()->route('pembayaran.index')
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                }
            }
            else {
                // Jika tidak bisa mendapatkan status dari midtrans, gunakan parameter dari callback
                if ($status_param == 'success') {
                    $pembayaran->status = 'sukses';
                    $pembayaran->tanggal_bayar = now();

                    // Update status pembayaran di user
                    $user = $pembayaran->user;
                    $user->status_pembayaran = 'lunas';
                    $user->save();

                    $pembayaran->save();

                    return redirect()->route('pembayaran.index')
                        ->with('success', 'Pembayaran berhasil! Status pembayaran Anda telah diperbarui.');
                }
                elseif ($status_param == 'error') {
                    // Rollback - hapus pembayaran jika gagal
                    $pembayaran->delete();

                    return redirect()->route('pembayaran.index')
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                }
                else {
                    return redirect()->route('pembayaran.index')
                        ->with('info', 'Pembayaran sedang diproses. Silakan cek status pembayaran Anda nanti.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Status Error: ' . $e->getMessage());

            // Jika error, gunakan parameter dari URL sebagai fallback
            if ($status_param == 'success') {
                $pembayaran->status = 'sukses';
                $pembayaran->tanggal_bayar = now();

                // Update status pembayaran di user
                $user = $pembayaran->user;
                $user->status_pembayaran = 'lunas';
                $user->save();

                $pembayaran->save();

                return redirect()->route('pembayaran.index')
                    ->with('success', 'Pembayaran berhasil! Status pembayaran Anda telah diperbarui.');
            }
            elseif ($status_param == 'error') {
                // Rollback - hapus pembayaran jika gagal
                $pembayaran->delete();

                return redirect()->route('pembayaran.index')
                    ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
            }
        }

        return redirect()->route('pembayaran.index')
            ->with('info', 'Pembayaran sedang diproses. Silakan cek status pembayaran Anda nanti.');
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
            $midtransStatus = Transaction::status($pembayaran->id_pembayaran);

            // Update pembayaran berdasarkan status dari Midtrans
            if ($midtransStatus) {
                // Dapatkan payment_type dari hasil midtrans
                $pembayaran->midtrans_payment_type = isset($midtransStatus->payment_type) ?
                    $midtransStatus->payment_type : null;

                // Cek dan ambil bank jika ada
                if (isset($midtransStatus->va_numbers) &&
                    is_array($midtransStatus->va_numbers) &&
                    !empty($midtransStatus->va_numbers) &&
                    isset($midtransStatus->va_numbers[0]->bank)) {
                    $pembayaran->midtrans_bank = $midtransStatus->va_numbers[0]->bank;
                }

                // Cek transaction_status
                $transactionStatus = isset($midtransStatus->transaction_status) ?
                    $midtransStatus->transaction_status : null;

                if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
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
                }
                elseif ($transactionStatus == 'pending') {
                    $pembayaran->status = 'pending';
                    $pembayaran->save();

                    return redirect()->route('pembayaran.index')
                        ->with('info', 'Pembayaran sedang diproses. Silakan cek status pembayaran Anda nanti.');
                }
                else {
                    // Rollback - hapus pembayaran jika gagal
                    $pembayaran->delete();

                    return redirect()->route('pembayaran.index')
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                }
            }
            else {
                // Pembayaran terlalu lama pending (lebih dari 1 jam) dianggap gagal
                if ($pembayaran->created_at->diffInHours(now()) > 1) {
                    $pembayaran->delete();

                    return redirect()->route('pembayaran.index')
                        ->with('error', 'Pembayaran telah kedaluarsa. Silakan coba lagi.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Status Error: ' . $e->getMessage());
            return redirect()->route('pembayaran.index')
                ->with('error', 'Terjadi kesalahan saat memeriksa status pembayaran.');
        }

        return redirect()->route('pembayaran.index')
            ->with('info', 'Status pembayaran belum berubah. Silakan coba lagi nanti.');
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
