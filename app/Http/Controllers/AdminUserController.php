<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar semua mahasiswa
     */
    public function index(Request $request)
    {
        $query = User::query()->with(['fakultas', 'programStudi']);

        // Filter berdasarkan nama, NIM, atau email jika ada
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan fakultas
        if ($request->has('fakultas_id') && $request->fakultas_id) {
            $query->where('fakultas_id', $request->fakultas_id);
        }

        // Filter berdasarkan status pendaftaran
        if ($request->has('status_pendaftaran') && $request->status_pendaftaran) {
            $query->where('status_pendaftaran', $request->status_pendaftaran);
        }

        // Urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');

        $mahasiswa = $query->paginate(10);
        $fakultas = Fakultas::all();

        return view('admin.mahasiswa.index', compact('mahasiswa', 'fakultas'));
    }

    /**
     * Menampilkan form untuk membuat mahasiswa baru
     */
    public function create()
    {
        $fakultas = Fakultas::all();
        $programStudi = collect();

        return view('admin.mahasiswa.create', compact('fakultas', 'programStudi'));
    }

    /**
     * Menyimpan mahasiswa baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users',
            'fakultas_id' => 'required|exists:fakultas,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'email' => 'required|string|email|max:255|unique:users',
            'no_telepon' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nim' => $request->nim,
            'email' => $request->email,
            'fakultas_id' => $request->fakultas_id,
            'program_studi_id' => $request->program_studi_id,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'status_pembayaran' => 'belum',
            'status_pemilihan_lokasi' => 'belum',
            'status_pendaftaran' => 'belum',
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail mahasiswa
     */
    public function show($id)
    {
        $mahasiswa = User::with([
            'fakultas',
            'programStudi',
            'pendaftaran.lokasi',
            'pembayaran' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Menampilkan form untuk mengedit mahasiswa
     */
    public function edit($id)
    {
        $mahasiswa = User::findOrFail($id);
        $fakultas = Fakultas::all();
        $programStudi = ProgramStudi::where('fakultas_id', $mahasiswa->fakultas_id)->get();

        return view('admin.mahasiswa.edit', compact('mahasiswa', 'fakultas', 'programStudi'));
    }

    /**
     * Mengupdate data mahasiswa di database
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($mahasiswa->id)],
            'fakultas_id' => 'required|exists:fakultas,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'email' => ['required', 'email', Rule::unique('users')->ignore($mahasiswa->id)],
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'nullable|string',
            'status_pembayaran' => 'required|in:belum,sudah',
            'status_pemilihan_lokasi' => 'required|in:belum,sudah',
            'status_pendaftaran' => 'required|in:belum,menunggu,diterima,ditolak',
        ]);

        $mahasiswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nim' => $request->nim,
            'email' => $request->email,
            'fakultas_id' => $request->fakultas_id,
            'program_studi_id' => $request->program_studi_id,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'status_pembayaran' => $request->status_pembayaran,
            'status_pemilihan_lokasi' => $request->status_pemilihan_lokasi,
            'status_pendaftaran' => $request->status_pendaftaran,
        ]);

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);

            $mahasiswa->password = Hash::make($request->password);
            $mahasiswa->save();
        }

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    /**
     * Menghapus mahasiswa dari database
     */
    public function destroy($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus!');
    }

    /**
     * Mendapatkan program studi berdasarkan fakultas (untuk AJAX)
     */
    public function getProgramStudi($fakultasId)
    {
        $programStudi = ProgramStudi::where('fakultas_id', $fakultasId)->get();
        return response()->json($programStudi);
    }
}
