<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // Tampilkan halaman pendaftaran
    public function index()
    {
        $user = Auth::user();

        // Cek status pembayaran
        if ($user->status_pembayaran !== 'lunas') {
            return redirect()->route('pembayaran.index')
                ->with('error', 'Anda harus melunasi pembayaran terlebih dahulu');
        }

        // Cek status pemilihan lokasi
        if ($user->status_pemilihan_lokasi !== 'sudah') {
            return redirect()->route('lokasi.index')
                ->with('error', 'Anda harus memilih lokasi terlebih dahulu');
        }

        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('lokasi.index')
                ->with('error', 'Anda harus memilih lokasi terlebih dahulu');
        }

        return view('user.registration', compact('user', 'pendaftaran'));
    }

    // Proses pendaftaran
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $request->validate([
            'golongan_darah' => 'required|string|max:3',
            'riwayat_penyakit' => 'nullable|string|max:500',
            'kontak_darurat_nama' => 'required|string|max:255',
            'kontak_darurat_telepon' => 'required|string|max:15',
            'pernyataan_data_benar' => 'required|boolean',
        ]);

        // Cek status pembayaran
        if ($user->status_pembayaran !== 'lunas') {
            return redirect()->route('pembayaran.index')
                ->with('error', 'Anda harus melunasi pembayaran terlebih dahulu');
        }

        // Cek status pemilihan lokasi
        if ($user->status_pemilihan_lokasi !== 'sudah') {
            return redirect()->route('lokasi.index')
                ->with('error', 'Anda harus memilih lokasi terlebih dahulu');
        }

        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('lokasi.index')
                ->with('error', 'Anda harus memilih lokasi terlebih dahulu');
        }

        // Update pendaftaran
        $pendaftaran->golongan_darah = $request->golongan_darah;
        $pendaftaran->riwayat_penyakit = $request->riwayat_penyakit;
        $pendaftaran->kontak_darurat_nama = $request->kontak_darurat_nama;
        $pendaftaran->kontak_darurat_telepon = $request->kontak_darurat_telepon;
        $pendaftaran->pernyataan_data_benar = $request->pernyataan_data_benar ? 'Ya, data yang saya isi adalah benar' : null;
        $pendaftaran->status = 'terdaftar';
        $pendaftaran->save();

        // Update status user
        $user->status_pendaftaran = 'sudah';
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran KKNM berhasil');
    }
}