@extends('layouts.admin')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Detail Pembayaran</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.mahasiswa.show', $pembayaran->user->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-user mr-1"></i> Lihat Mahasiswa
                </a>
                <a href="{{ route('admin.payment.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Status box -->
        <div class="mb-6">
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <div class="py-1"><i class="fas fa-check-circle mr-2"></i></div>
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <div class="py-1"><i class="fas fa-exclamation-circle mr-2"></i></div>
                        <div>{{ session('error') }}</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Informasi Pembayaran -->
            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Pembayaran</h3>

                <!-- Detail Transaksi -->
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Transaksi</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pembayaran->order_id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                            <p class="mt-1">
                                @if($pembayaran->status == 'settlement')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Sukses</span>
                                @elseif($pembayaran->status == 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Pending</span>
                                @elseif($pembayaran->status == 'deny')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Ditolak</span>
                                @elseif($pembayaran->status == 'cancel')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Dibatalkan</span>
                                @elseif($pembayaran->status == 'expire')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Kedaluwarsa</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">{{ ucfirst($pembayaran->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Pembayaran</p>
                            <p class="text-base text-gray-900 dark:text-white font-semibold">Rp {{ number_format($pembayaran->gross_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pembayaran</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pembayaran->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Metode Pembayaran</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ ucfirst($pembayaran->payment_type ?? '-') }}</p>
                            @if($pembayaran->payment_type == 'bank_transfer')
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ strtoupper($pembayaran->bank ?? '') }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Virtual Account/Kode</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pembayaran->va_number ?? $pembayaran->payment_code ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tanggal & Status Update -->
                <div class="mb-6 border-t border-gray-200 dark:border-gray-600 pt-4">
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Riwayat Status</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dibuat</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pembayaran->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Update Terakhir</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pembayaran->updated_at->format('d F Y H:i') }}</p>
                        </div>
                        @if($pembayaran->settlement_time)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pembayaran</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($pembayaran->settlement_time)->format('d F Y H:i') }}</p>
                        </div>
                        @endif
                        @if($pembayaran->verified_at)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Diverifikasi Pada</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($pembayaran->verified_at)->format('d F Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($pembayaran->notes)
                <!-- Catatan -->
                <div class="mb-6 border-t border-gray-200 dark:border-gray-600 pt-4">
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan</h4>
                    <p class="text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 p-3 rounded">{{ $pembayaran->notes }}</p>
                </div>
                @endif

                <!-- Aksi -->
                @if($pembayaran->status == 'pending')
                <div class="mb-4 border-t border-gray-200 dark:border-gray-600 pt-4 flex flex-col md:flex-row gap-4">
                    <form action="{{ route('admin.payment.verify', $pembayaran->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan (opsional)</label>
                            <textarea name="notes" id="notes" rows="2" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                            <i class="fas fa-check-circle mr-2"></i> Verifikasi Pembayaran
                        </button>
                    </form>

                    <form action="{{ route('admin.payment.reject', $pembayaran->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="notes" id="notes" rows="2" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" required></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                            <i class="fas fa-times-circle mr-2"></i> Tolak Pembayaran
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Informasi Mahasiswa -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Mahasiswa</h3>
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                            @if($pembayaran->user->foto_profil)
                                <img src="{{ asset('storage/profile_photos/' . $pembayaran->user->foto_profil) }}" alt="{{ $pembayaran->user->nama_lengkap }}" class="h-12 w-12 rounded-full">
                            @else
                                <i class="fas fa-user text-xl text-gray-400 dark:text-gray-500"></i>
                            @endif
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900 dark:text-white">{{ $pembayaran->user->nama_lengkap }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $pembayaran->user->nim }}</p>
                    </div>
                </div>

                <div class="space-y-3 mt-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $pembayaran->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $pembayaran->user->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fakultas / Program Studi</p>
                        <p class="text-base text-gray-900 dark:text-white">
                            {{ $pembayaran->user->fakultas->nama_fakultas ?? '-' }} / {{ $pembayaran->user->programStudi->nama_program ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pendaftaran</p>
                        <p class="mt-1">
                            @if($pembayaran->user->status_pendaftaran == 'diterima')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Diterima</span>
                            @elseif($pembayaran->user->status_pendaftaran == 'ditolak')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Ditolak</span>
                            @elseif($pembayaran->user->status_pendaftaran == 'menunggu')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Menunggu</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Belum Mendaftar</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
