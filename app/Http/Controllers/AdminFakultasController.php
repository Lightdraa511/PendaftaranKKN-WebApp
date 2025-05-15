<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFakultasController extends Controller
{
    /**
     * Menampilkan daftar semua fakultas
     */
    public function index(Request $request)
    {
        $query = Fakultas::query();

        // Filter berdasarkan nama fakultas jika ada
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_fakultas', 'like', "%{$search}%")
                  ->orWhere('kode_fakultas', 'like', "%{$search}%");
            });
        }

        $fakultas = $query->withCount('programStudi')->paginate(10);

        return view('admin.fakultas.index', compact('fakultas'));
    }

    /**
     * Menampilkan form untuk membuat fakultas baru
     */
    public function create()
    {
        return view('admin.fakultas.create');
    }

    /**
     * Menyimpan fakultas baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255|unique:fakultas',
            'kode_fakultas' => 'required|string|max:10|unique:fakultas',
        ]);

        Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
            'kode_fakultas' => $request->kode_fakultas,
        ]);

        return redirect()->route('admin.fakultas.index')
            ->with('success', 'Fakultas berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail fakultas dan program studi
     */
    public function show($id)
    {
        $fakultas = Fakultas::with('programStudi')->findOrFail($id);

        return view('admin.fakultas.show', compact('fakultas'));
    }

    /**
     * Menampilkan form untuk mengedit fakultas
     */
    public function edit($id)
    {
        $fakultas = Fakultas::findOrFail($id);

        return view('admin.fakultas.edit', compact('fakultas'));
    }

    /**
     * Mengupdate data fakultas di database
     */
    public function update(Request $request, $id)
    {
        $fakultas = Fakultas::findOrFail($id);

        $request->validate([
            'nama_fakultas' => 'required|string|max:255|unique:fakultas,nama_fakultas,'.$id,
            'kode_fakultas' => 'required|string|max:10|unique:fakultas,kode_fakultas,'.$id,
        ]);

        $fakultas->update([
            'nama_fakultas' => $request->nama_fakultas,
            'kode_fakultas' => $request->kode_fakultas,
        ]);

        return redirect()->route('admin.fakultas.show', $fakultas->id)
            ->with('success', 'Fakultas berhasil diperbarui!');
    }

    /**
     * Menghapus fakultas dari database
     */
    public function destroy($id)
    {
        $fakultas = Fakultas::findOrFail($id);

        // Cek apakah ada program studi terkait
        $programCount = ProgramStudi::where('fakultas_id', $id)->count();

        if ($programCount > 0) {
            return redirect()->route('admin.fakultas.index')
                ->with('error', 'Tidak dapat menghapus fakultas karena masih memiliki program studi terkait!');
        }

        // Hapus fakultas
        $fakultas->delete();

        return redirect()->route('admin.fakultas.index')
            ->with('success', 'Fakultas berhasil dihapus!');
    }

    /**
     * Menampilkan form untuk menambah program studi baru
     */
    public function createProdi($fakultasId)
    {
        $fakultas = Fakultas::findOrFail($fakultasId);

        return view('admin.fakultas.create_prodi', compact('fakultas'));
    }

    /**
     * Menyimpan program studi baru ke database
     */
    public function storeProdi(Request $request, $fakultasId)
    {
        $fakultas = Fakultas::findOrFail($fakultasId);

        $request->validate([
            'nama_program' => 'required|string|max:255',
            'kode_program' => 'required|string|max:10|unique:program_studi',
            'jenjang' => 'required|string|in:D3,D4,S1,S2,S3',
        ]);

        ProgramStudi::create([
            'fakultas_id' => $fakultasId,
            'nama_program' => $request->nama_program,
            'kode_program' => $request->kode_program,
            'jenjang' => $request->jenjang,
        ]);

        return redirect()->route('admin.fakultas.show', $fakultasId)
            ->with('success', 'Program Studi berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit program studi
     */
    public function editProdi($fakultasId, $prodiId)
    {
        $fakultas = Fakultas::findOrFail($fakultasId);
        $prodi = ProgramStudi::findOrFail($prodiId);

        return view('admin.fakultas.edit_prodi', compact('fakultas', 'prodi'));
    }

    /**
     * Mengupdate data program studi di database
     */
    public function updateProdi(Request $request, $fakultasId, $prodiId)
    {
        $prodi = ProgramStudi::findOrFail($prodiId);

        $request->validate([
            'nama_program' => 'required|string|max:255',
            'kode_program' => 'required|string|max:10|unique:program_studi,kode_program,'.$prodiId,
            'jenjang' => 'required|string|in:D3,D4,S1,S2,S3',
        ]);

        $prodi->update([
            'nama_program' => $request->nama_program,
            'kode_program' => $request->kode_program,
            'jenjang' => $request->jenjang,
        ]);

        return redirect()->route('admin.fakultas.show', $fakultasId)
            ->with('success', 'Program Studi berhasil diperbarui!');
    }

    /**
     * Menghapus program studi dari database
     */
    public function destroyProdi($fakultasId, $prodiId)
    {
        $prodi = ProgramStudi::findOrFail($prodiId);

        // Cek apakah ada mahasiswa yang menggunakan program studi ini
        $userCount = DB::table('users')->where('program_studi_id', $prodiId)->count();

        if ($userCount > 0) {
            return redirect()->route('admin.fakultas.show', $fakultasId)
                ->with('error', 'Tidak dapat menghapus program studi karena masih digunakan oleh mahasiswa!');
        }

        // Hapus program studi
        $prodi->delete();

        return redirect()->route('admin.fakultas.show', $fakultasId)
            ->with('success', 'Program Studi berhasil dihapus!');
    }
}
