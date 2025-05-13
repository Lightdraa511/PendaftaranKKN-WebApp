<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\User;
use App\Models\Admin;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function loginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek login admin
        if ($request->nim === 'admin') {
            if (Auth::guard('admin')->attempt(['email' => 'admin@admin.com', 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        // Cek login mahasiswa
        if (Auth::attempt(['nim' => $request->nim, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->back()
            ->withErrors(['nim' => 'Kredensial yang diberikan tidak cocok dengan data kami.'])
            ->withInput();
    }

    // Tampilkan halaman register
    public function registerForm()
    {
        $fakultas = Fakultas::all();
        return view('auth.register', compact('fakultas'));
    }

    // Proses register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users',
            'fakultas_id' => 'required|exists:fakultas,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'email' => 'required|string|email|max:255|unique:users',
            'no_telepon' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
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

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // Proses logout
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // API untuk mendapatkan program studi berdasarkan fakultas
    public function getProgramStudi($fakultasId)
    {
        $programStudi = ProgramStudi::where('fakultas_id', $fakultasId)->get();
        return response()->json($programStudi);
    }
}
