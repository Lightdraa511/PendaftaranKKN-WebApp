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

        // Filter berdasarkan pencarian (nama/nim mahasiswa atau order_id)
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            })->orWhere('order_id', 'like', "%{$search}%");
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
        $pembayaran = Pembayaran::with('user')->findOrFail($id);
        return view('admin.payment.show', compact('pembayaran'));
    }

    /**
     * Verifikasi pembayaran (manual)
     */
    public function verify(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        DB::beginTransaction();
        try {
            // Update status pembayaran
            $pembayaran->update([
                'status' => 'settlement',
                'verified_at' => now(),
                'verified_by' => auth('admin')->id(),
                'notes' => $request->notes ?? 'Verified manually by admin'
            ]);

            // Update status pembayaran user jika belum sudah
            $user = User::find($pembayaran->user_id);
            if ($user->status_pembayaran != 'sudah') {
                $user->update(['status_pembayaran' => 'sudah']);
            }

            DB::commit();
            return redirect()->route('admin.payment.show', $id)
                ->with('success', 'Pembayaran berhasil diverifikasi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tolak pembayaran
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->update([
            'status' => 'deny',
            'verified_at' => now(),
            'verified_by' => auth('admin')->id(),
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.payment.show', $id)
            ->with('success', 'Pembayaran berhasil ditolak!');
    }
}
