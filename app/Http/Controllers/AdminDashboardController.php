<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Menghitung total untuk statistik
        $totalUsers = User::count();
        $totalPendaftaran = Pendaftaran::count();
        $totalPembayaran = Pembayaran::where('status', 'settlement')->count();
        $totalLokasi = Lokasi::count();

        // Data untuk grafik pendaftaran per bulan - perbaikan untuk SQLite
        $pendaftaranPerBulan = Pendaftaran::select(
            DB::raw('strftime("%m", created_at) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->whereRaw('strftime("%Y", created_at) = ?', [date('Y')])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Data untuk grafik status pendaftaran
        $statusPendaftaran = Pendaftaran::select(
            'status',
            DB::raw('COUNT(*) as jumlah')
        )
            ->groupBy('status')
            ->get();

        // Penanganan jika tidak ada status pendaftaran
        if ($statusPendaftaran->isEmpty()) {
            $statusPendaftaran = collect([
                ['status' => 'menunggu', 'jumlah' => 0],
                ['status' => 'diterima', 'jumlah' => 0],
                ['status' => 'ditolak', 'jumlah' => 0]
            ]);
        }

        // Data untuk grafik lokasi terpopuler
        $lokasiTerpopuler = Lokasi::select(
            'nama_lokasi',
            'kuota_terisi',
            'kuota_total'
        )
            ->orderBy('kuota_terisi', 'desc')
            ->limit(5)
            ->get();

        // Pastikan semua lokasi memiliki kuota_total yang valid
        $lokasiTerpopuler->transform(function($lokasi) {
            if (!isset($lokasi->kuota_total) || $lokasi->kuota_total <= 0) {
                $lokasi->kuota_total = 1; // Default untuk menghindari pembagian dengan nol
            }
            return $lokasi;
        });

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPendaftaran',
            'totalPembayaran',
            'totalLokasi',
            'pendaftaranPerBulan',
            'statusPendaftaran',
            'lokasiTerpopuler'
        ));
    }
}
