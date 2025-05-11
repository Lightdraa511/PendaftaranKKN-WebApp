<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\KuotaFakultas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LokasiController extends Controller
{
    // Tampilkan daftar lokasi
    public function index()
    {
        $user = Auth::user();
        $lokasi = Lokasi::with('kuotaFakultas.fakultas')->get();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        return view('user.location', compact('lokasi', 'user', 'pendaftaran'));
    }

    // Tampilkan detail lokasi
    public function show($id)
    {
        $user = Auth::user();
        $lokasi = Lokasi::with('kuotaFakultas.fakultas')->findOrFail($id);
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        return view('user.location-detail', compact('lokasi', 'user', 'pendaftaran'));
    }

    // Pilih lokasi
    public function select(Request $request, $id)
    {
        $user = Auth::user();
        $lokasi = Lokasi::findOrFail($id);

        // Cek status pembayaran
        if ($user->status_pembayaran !== 'lunas') {
            return redirect()->route('pembayaran.index')
                ->with('error', 'Anda harus melunasi pembayaran terlebih dahulu');
        }

        // Cek kuota lokasi
        if ($lokasi->status === 'penuh') {
            return redirect()->route('lokasi.index')
                ->with('error', 'Lokasi sudah penuh, silakan pilih lokasi lain');
        }

        // Cek kuota fakultas
        $kuotaFakultas = KuotaFakultas::where('lokasi_id', $lokasi->id)
            ->where('fakultas_id', $user->fakultas_id)
            ->first();

        if (!$kuotaFakultas) {
            return redirect()->route('lokasi.index')
                ->with('error', 'Tidak ada kuota untuk fakultas Anda di lokasi ini');
        }

        if ($kuotaFakultas->terisi >= $kuotaFakultas->kuota) {
            return redirect()->route('lokasi.index')
                ->with('error', 'Kuota fakultas Anda di lokasi ini sudah penuh');
        }

        // Cek apakah user sudah pernah pilih lokasi
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        if ($pendaftaran) {
            if ($pendaftaran->lokasi_id === $lokasi->id) {
                return redirect()->route('lokasi.index')
                    ->with('info', 'Anda sudah memilih lokasi ini');
            }

            // Jika sudah pilih lokasi lain, kurangi kuota di lokasi lama
            $oldLokasi = Lokasi::find($pendaftaran->lokasi_id);
            $oldKuotaFakultas = KuotaFakultas::where('lokasi_id', $pendaftaran->lokasi_id)
                ->where('fakultas_id', $user->fakultas_id)
                ->first();

            if ($oldLokasi && $oldKuotaFakultas) {
                $oldLokasi->kuota_terisi = max(0, $oldLokasi->kuota_terisi - 1);
                $oldLokasi->save();
                $oldLokasi->updateStatusKuota();

                $oldKuotaFakultas->terisi = max(0, $oldKuotaFakultas->terisi - 1);
                $oldKuotaFakultas->save();
            }

            // Update pendaftaran dengan lokasi baru
            $pendaftaran->lokasi_id = $lokasi->id;
            $pendaftaran->save();
        } else {
            // Buat pendaftaran baru
            $pendaftaran = new Pendaftaran();
            $pendaftaran->user_id = $user->id;
            $pendaftaran->lokasi_id = $lokasi->id;
            $pendaftaran->status = 'draft';
            $pendaftaran->save();
        }

        // Update kuota lokasi
        $lokasi->kuota_terisi += 1;
        $lokasi->save();
        $lokasi->updateStatusKuota();

        // Update kuota fakultas
        $kuotaFakultas->terisi += 1;
        $kuotaFakultas->save();

        // Update status user
        $user->status_pemilihan_lokasi = 'sudah';
        $user->save();

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Lokasi berhasil dipilih, silakan lengkapi formulir pendaftaran');
    }
}