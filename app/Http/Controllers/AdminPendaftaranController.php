<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPendaftaranController extends Controller
{
    /**
     * Menampilkan daftar semua pendaftaran
     */
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'lokasi']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan pencarian (nama/nim mahasiswa)
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan lokasi
        if ($request->has('lokasi_id') && $request->lokasi_id) {
            $query->where('lokasi_id', $request->lokasi_id);
        }

        // Urutkan berdasarkan tanggal terbaru
        $query->orderBy('created_at', 'desc');

        $pendaftaran = $query->paginate(10);
        $lokasi = Lokasi::all();

        return view('admin.pendaftaran.index', compact('pendaftaran', 'lokasi'));
    }

    /**
     * Menampilkan detail pendaftaran
     */
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'lokasi'])->findOrFail($id);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Menampilkan form edit pendaftaran
     */
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'lokasi'])->findOrFail($id);
        $lokasi = Lokasi::all();
        return view('admin.pendaftaran.edit', compact('pendaftaran', 'lokasi'));
    }

    /**
     * Update pendaftaran
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'golongan_darah' => 'required|string|max:3',
            'riwayat_penyakit' => 'nullable|string|max:500',
            'kontak_darurat_nama' => 'required|string|max:255',
            'kontak_darurat_telepon' => 'required|string|max:15',
            'lokasi_id' => 'required|exists:lokasi,id',
            'status' => 'required|in:draft,terdaftar',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $oldLokasiId = $pendaftaran->lokasi_id;
        $newLokasiId = $request->lokasi_id;

        DB::beginTransaction();
        try {
            // Update lokasi KKN jika berubah
            if ($oldLokasiId != $newLokasiId) {
                // Kurangi kuota terisi di lokasi lama
                if ($oldLokasiId) {
                    $oldLokasi = Lokasi::find($oldLokasiId);
                    if ($oldLokasi) {
                        $oldLokasi->kuota_terisi = max(0, $oldLokasi->kuota_terisi - 1);
                        $oldLokasi->save();
                    }
                }

                // Tambah kuota terisi di lokasi baru
                $newLokasi = Lokasi::find($newLokasiId);
                if ($newLokasi) {
                    $newLokasi->kuota_terisi = $newLokasi->kuota_terisi + 1;
                    $newLokasi->save();
                }
            }

            // Update data pendaftaran
            $pendaftaran->update([
                'lokasi_id' => $newLokasiId,
                'golongan_darah' => $request->golongan_darah,
                'riwayat_penyakit' => $request->riwayat_penyakit,
                'kontak_darurat_nama' => $request->kontak_darurat_nama,
                'kontak_darurat_telepon' => $request->kontak_darurat_telepon,
                'status' => $request->status,
            ]);

            // Update status user jika pendaftaran berstatus terdaftar
            if ($request->status == 'terdaftar') {
                $user = User::find($pendaftaran->user_id);
                $user->status_pendaftaran = 'sudah';
                $user->save();
            }

            DB::commit();
            return redirect()->route('admin.pendaftaran.show', $id)
                ->with('success', 'Pendaftaran berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pendaftaran
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        DB::beginTransaction();
        try {
            // Kurangi kuota terisi lokasi
            if ($pendaftaran->lokasi_id) {
                $lokasi = Lokasi::find($pendaftaran->lokasi_id);
                if ($lokasi) {
                    $lokasi->kuota_terisi = max(0, $lokasi->kuota_terisi - 1);
                    $lokasi->save();
                }
            }

            // Reset status pendaftaran user
            $user = User::find($pendaftaran->user_id);
            if ($user) {
                $user->status_pendaftaran = 'belum';
                $user->status_pemilihan_lokasi = 'belum';
                $user->save();
            }

            // Hapus pendaftaran
            $pendaftaran->delete();

            DB::commit();
            return redirect()->route('admin.pendaftaran.index')
                ->with('success', 'Pendaftaran berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
