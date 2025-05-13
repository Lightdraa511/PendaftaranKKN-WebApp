@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')
@section('page-title', 'Manajemen Pembayaran')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between mb-6">
            <div>
                <h1 class="text-xl font-medium text-gray-800 dark:text-gray-200">Daftar Pembayaran</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola pembayaran pendaftaran KKNM</p>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <form action="{{ route('admin.payment.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" placeholder="Nama / NIM / ID Pesanan">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" id="status" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="settlement" {{ request('status') == 'settlement' ? 'selected' : '' }}>Sukses</option>
                        <option value="deny" {{ request('status') == 'deny' ? 'selected' : '' }}>Ditolak</option>
                        <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Dibatalkan</option>
                        <option value="expire" {{ request('status') == 'expire' ? 'selected' : '' }}>Kedaluwarsa</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Pembayaran -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Mahasiswa</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Metode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($pembayaran as $payment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $payment->order_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $payment->user->nama_lengkap }}
                                <div class="text-xs text-gray-400 dark:text-gray-500">NIM: {{ $payment->user->nim }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ ucfirst($payment->payment_type ?? '-') }}
                                @if($payment->payment_type == 'bank_transfer')
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ strtoupper($payment->bank ?? '') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->status == 'settlement')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Sukses</span>
                                @elseif($payment->status == 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Pending</span>
                                @elseif($payment->status == 'deny')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Ditolak</span>
                                @elseif($payment->status == 'cancel')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Dibatalkan</span>
                                @elseif($payment->status == 'expire')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Kedaluwarsa</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $payment->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.payment.show', $payment->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $pembayaran->links() }}
        </div>
    </div>
</div>
@endsection
