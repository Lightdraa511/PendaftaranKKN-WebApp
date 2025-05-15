<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentController extends Controller
{
    /**
     * Menampilkan daftar semua pembayaran
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with('user');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan pencarian (nama/nim mahasiswa atau id_pembayaran)
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            })->orWhere('id_pembayaran', 'like', "%{$search}%");
        }

        // Urutkan berdasarkan tanggal terbaru
        $query->orderBy('created_at', 'desc');

        $pembayaran = $query->paginate(10);

        return view('admin.payment.index', compact('pembayaran'));
    }

    /**
     * Menampilkan detail pembayaran
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['user.fakultas', 'user.programStudi'])->findOrFail($id);
        return view('admin.payment.show', compact('pembayaran'));
    }
}
