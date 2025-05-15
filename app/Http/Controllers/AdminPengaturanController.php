<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminPengaturanController extends Controller
{
    /**
     * Menampilkan form pengaturan aplikasi
     */
    public function index()
    {
        $pengaturan = Pengaturan::getCurrent();

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    /**
     * Menyimpan pengaturan aplikasi
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'biaya_administrasi' => 'required|numeric|min:0',
            'tanggal_mulai_pendaftaran' => 'required|date',
            'tanggal_selesai_pendaftaran' => 'required|date|after:tanggal_mulai_pendaftaran',
            'tanggal_mulai_pelaksanaan' => 'required|date|after:tanggal_selesai_pendaftaran',
            'tanggal_selesai_pelaksanaan' => 'required|date|after:tanggal_mulai_pelaksanaan',
            'judul_pengumuman' => 'nullable|string|max:255',
            'isi_pengumuman' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pengaturan = Pengaturan::getCurrent();

        // Update data pengaturan
        $pengaturan->update([
            'biaya_pendaftaran' => $request->biaya_pendaftaran,
            'biaya_administrasi' => $request->biaya_administrasi,
            'tanggal_mulai_pendaftaran' => $request->tanggal_mulai_pendaftaran,
            'tanggal_selesai_pendaftaran' => $request->tanggal_selesai_pendaftaran,
            'tanggal_mulai_pelaksanaan' => $request->tanggal_mulai_pelaksanaan,
            'tanggal_selesai_pelaksanaan' => $request->tanggal_selesai_pelaksanaan,
            'judul_pengumuman' => $request->judul_pengumuman,
            'isi_pengumuman' => $request->isi_pengumuman,
            'tampilkan_pengumuman' => $request->has('tampilkan_pengumuman'),
            'pendaftaran_aktif' => $request->has('pendaftaran_aktif'),
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }

    /**
     * Mereset pengaturan ke nilai default
     */
    public function reset()
    {
        $pengaturan = Pengaturan::getCurrent();

        // Reset ke nilai default
        $pengaturan->update([
            'biaya_pendaftaran' => 750000,
            'biaya_administrasi' => 10000,
            'tanggal_mulai_pendaftaran' => now(),
            'tanggal_selesai_pendaftaran' => now()->addDays(14),
            'tanggal_mulai_pelaksanaan' => now()->addMonth(),
            'tanggal_selesai_pelaksanaan' => now()->addMonth()->addDays(14),
            'judul_pengumuman' => 'Pendaftaran KKNM Dibuka',
            'isi_pengumuman' => 'Pendaftaran KKNM periode ' . date('Y') . ' telah dibuka.',
            'tampilkan_pengumuman' => true,
            'pendaftaran_aktif' => true,
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil direset ke nilai default!');
    }
}
