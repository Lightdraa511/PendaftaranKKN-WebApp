<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Tampilkan profil
    public function index()
    {
        $user = Auth::user();
        $fakultas = Fakultas::all();
        $programStudi = ProgramStudi::where('fakultas_id', $user->fakultas_id)->get();

        return view('user.profile', compact('user', 'fakultas', 'programStudi'));
    }

    // Update profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
            'fakultas_id' => 'required|exists:fakultas,id',
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil) {
                Storage::delete('public/profile_photos/' . $user->foto_profil);
            }

            // Upload foto baru
            $filename = time() . '.' . $request->foto_profil->extension();
            $request->foto_profil->storeAs('public/profile_photos', $filename);
            $user->foto_profil = $filename;
        }

        // Update data user
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;
        $user->fakultas_id = $request->fakultas_id;
        $user->program_studi_id = $request->program_studi_id;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui');
    }

    // Get program studi berdasarkan fakultas (AJAX)
    public function getProgramStudi(Request $request)
    {
        $programStudi = ProgramStudi::where('fakultas_id', $request->fakultas_id)->get();
        return response()->json($programStudi);
    }
}