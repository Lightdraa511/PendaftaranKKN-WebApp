<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
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

    // Proses pembayaran
    public function process()
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
        $pembayaran->id_pembayaran = Pembayaran::generateIdPembayaran();
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

            return view('user.payment-process', compact('snapToken', 'pembayaran'));
        } catch (\Exception $e) {
            return redirect()->route('pembayaran.index')
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    // Callback dari Midtrans
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed == $request->signature_key) {
            $pembayaran = Pembayaran::where('id_pembayaran', $request->order_id)->first();

            if ($pembayaran) {
                // Update status pembayaran
                $pembayaran->midtrans_payment_type = $request->payment_type;

                if ($request->payment_type == 'bank_transfer') {
                    $pembayaran->midtrans_bank = $request->va_numbers[0]->bank ?? null;
                }

                if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                    $pembayaran->status = 'sukses';
                    $pembayaran->tanggal_bayar = now();

                    // Update status pembayaran di user
                    $user = $pembayaran->user;
                    $user->status_pembayaran = 'lunas';
                    $user->save();
                } else if ($request->transaction_status == 'pending') {
                    $pembayaran->status = 'pending';
                } else {
                    $pembayaran->status = 'gagal';
                }

                $pembayaran->save();

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }

    // Check status pembayaran
    public function check($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->user_id != Auth::id() && !Auth::guard('admin')->check()) {
            abort(403);
        }

        // Logic untuk cek status pembayaran di Midtrans bisa ditambahkan di sini

        return response()->json([
            'status' => $pembayaran->status,
            'payment_type' => $pembayaran->midtrans_payment_type,
            'bank' => $pembayaran->midtrans_bank,
        ]);
    }
}