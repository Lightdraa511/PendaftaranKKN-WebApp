<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\KuotaFakultas;
use App\Models\Lokasi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLokasiController extends Controller
{
    /**
     * Menampilkan daftar semua lokasi KKN
     */
    public function index(Request $request)
    {
        $query = Lokasi::query();

        // Filter berdasarkan nama lokasi atau kabupaten jika ada
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lokasi', 'like', "%{$search}%")
                  ->orWhere('kabupaten', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $lokasi = $query->paginate(10);

        return view('admin.lokasi.index', compact('lokasi'));
    }

    /**
     * Menampilkan form untuk membuat lokasi baru
     */
    public function create()
    {
        $fakultas = Fakultas::all();

        return view('admin.lokasi.create', compact('fakultas'));
    }

    /**
     * Menyimpan lokasi baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'fokus_program' => 'nullable|string|max:255',
            'koordinator' => 'required|string|max:255',
            'kontak_koordinator' => 'required|string|max:255',
            'kuota_total' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,terbatas,penuh',
        ]);

        DB::beginTransaction();
        try {
            // Buat lokasi baru
            $lokasi = Lokasi::create([
                'nama_lokasi' => $request->nama_lokasi,
                'kecamatan' => $request->kecamatan,
                'kabupaten' => $request->kabupaten,
                'provinsi' => $request->provinsi,
                'deskripsi' => $request->deskripsi,
                'fokus_program' => $request->fokus_program,
                'koordinator' => $request->koordinator,
                'kontak_koordinator' => $request->kontak_koordinator,
                'status' => $request->status,
                'kuota_total' => $request->kuota_total,
                'kuota_terisi' => 0,
            ]);

            // Buat kuota fakultas jika ada
            if ($request->has('fakultas_id') && $request->has('kuota')) {
                $fakultasIds = $request->fakultas_id;
                $kuotas = $request->kuota;

                foreach ($fakultasIds as $index => $fakultasId) {
                    if (isset($kuotas[$index]) && $kuotas[$index] > 0) {
                        KuotaFakultas::create([
                            'lokasi_id' => $lokasi->id,
                            'fakultas_id' => $fakultasId,
                            'kuota' => $kuotas[$index],
                            'terisi' => 0,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.lokasi.index')
                ->with('success', 'Lokasi KKN berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail lokasi
     */
    public function show($id)
    {
        $lokasi = Lokasi::with(['kuotaFakultas.fakultas', 'pendaftaran.user'])->findOrFail($id);
        $pendaftaran = Pendaftaran::where('lokasi_id', $id)->with('user')->get();

        return view('admin.lokasi.show', compact('lokasi', 'pendaftaran'));
    }

    /**
     * Menampilkan form untuk mengedit lokasi
     */
    public function edit($id)
    {
        $lokasi = Lokasi::with('kuotaFakultas.fakultas')->findOrFail($id);
        $fakultas = Fakultas::all();

        return view('admin.lokasi.edit', compact('lokasi', 'fakultas'));
    }

    /**
     * Mengupdate data lokasi di database
     */
    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'fokus_program' => 'nullable|string|max:255',
            'koordinator' => 'required|string|max:255',
            'kontak_koordinator' => 'required|string|max:255',
            'kuota_total' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,terbatas,penuh',
        ]);

        DB::beginTransaction();
        try {
            // Update data lokasi
            $lokasi->update([
                'nama_lokasi' => $request->nama_lokasi,
                'kecamatan' => $request->kecamatan,
                'kabupaten' => $request->kabupaten,
                'provinsi' => $request->provinsi,
                'deskripsi' => $request->deskripsi,
                'fokus_program' => $request->fokus_program,
                'koordinator' => $request->koordinator,
                'kontak_koordinator' => $request->kontak_koordinator,
                'status' => $request->status,
                'kuota_total' => $request->kuota_total,
            ]);

            // Update kuota fakultas yang sudah ada
            if ($request->has('kuota_fakultas_id') && $request->has('edit_kuota')) {
                $kuotaIds = $request->kuota_fakultas_id;
                $kuotas = $request->edit_kuota;

                foreach ($kuotaIds as $index => $kuotaId) {
                    if (isset($kuotas[$index])) {
                        $kuotaFakultas = KuotaFakultas::find($kuotaId);
                        if ($kuotaFakultas) {
                            $kuotaFakultas->kuota = $kuotas[$index];
                            $kuotaFakultas->save();
                        }
                    }
                }
            }

            // Tambah kuota fakultas baru jika ada
            if ($request->has('fakultas_id') && $request->has('kuota')) {
                $fakultasIds = $request->fakultas_id;
                $kuotas = $request->kuota;

                foreach ($fakultasIds as $index => $fakultasId) {
                    if (isset($kuotas[$index]) && $kuotas[$index] > 0) {
                        KuotaFakultas::create([
                            'lokasi_id' => $lokasi->id,
                            'fakultas_id' => $fakultasId,
                            'kuota' => $kuotas[$index],
                            'terisi' => 0,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.lokasi.show', $lokasi->id)
                ->with('success', 'Lokasi KKN berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus lokasi dari database
     */
    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        // Cek apakah ada pendaftaran yang terkait
        $pendaftaranCount = Pendaftaran::where('lokasi_id', $id)->count();

        if ($pendaftaranCount > 0) {
            return redirect()->route('admin.lokasi.index')
                ->with('error', 'Tidak dapat menghapus lokasi karena sudah ada mahasiswa yang mendaftar!');
        }

        // Hapus kuota fakultas terkait
        KuotaFakultas::where('lokasi_id', $id)->delete();

        // Hapus lokasi
        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi KKN berhasil dihapus!');
    }

    /**
     * Menghapus kuota fakultas
     */
    public function deleteKuota($id)
    {
        $kuota = KuotaFakultas::findOrFail($id);

        // Cek apakah ada mahasiswa yang terdaftar
        if ($kuota->terisi > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kuota karena sudah ada mahasiswa yang terdaftar di fakultas ini!');
        }

        // Perbarui jumlah kuota di lokasi
        $lokasi = $kuota->lokasi;
        $lokasi->kuota_total -= $kuota->kuota;
        $lokasi->save();

        // Hapus kuota fakultas
        $kuota->delete();

        return redirect()->back()
            ->with('success', 'Kuota fakultas berhasil dihapus!');
    }
}
