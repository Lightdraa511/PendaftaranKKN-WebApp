{{--
Catatan Pengembangan:
1. Perlu membuat halaman admin/lokasi/index.blade.php untuk melihat daftar semua lokasi
2. Perlu membuat halaman admin/lokasi/show.blade.php untuk melihat detail lokasi
3. Perlu membuat halaman admin/lokasi/create.blade.php untuk menambah lokasi baru
4. Perlu membuat halaman admin/lokasi/edit.blade.php untuk mengedit lokasi

5. Perlu membuat halaman admin/payment/index.blade.php untuk melihat daftar semua pembayaran
6. Perlu membuat halaman admin/payment/show.blade.php untuk melihat detail pembayaran
--}}

@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Detail Mahasiswa</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a href="{{ route('admin.mahasiswa.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi Dasar -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Dasar</h3>

            <div class="flex flex-col md:flex-row gap-6 mb-4">
                <!-- Foto Profil -->
                <div class="flex-shrink-0 flex flex-col items-center">
                    <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden flex items-center justify-center mb-2">
                        @if($mahasiswa->foto_profil)
                            <img src="{{ asset('storage/profile_photos/' . $mahasiswa->foto_profil) }}" alt="{{ $mahasiswa->nama_lengkap }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-4xl text-gray-400 dark:text-gray-500"></i>
                        @endif
                    </div>
                </div>

                <!-- Data Dasar -->
                <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">NIM</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->nim }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Akademik -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Akademik</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fakultas</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->fakultas->nama_fakultas ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Program Studi</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->programStudi->nama_program ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">IPK</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ $mahasiswa->ipk ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Status Pendaftaran -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Status Pendaftaran KKN</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pembayaran</p>
                    <p class="mt-1">
                        @if($mahasiswa->status_pembayaran == 'lunas')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Lunas</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Belum Lunas</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pemilihan Lokasi</p>
                    <p class="mt-1">
                        @if($mahasiswa->status_pemilihan_lokasi == 'sudah')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Sudah Memilih</span>
                            @if($mahasiswa->pendaftaran && $mahasiswa->pendaftaran->lokasi)
                                <span class="block mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $mahasiswa->pendaftaran->lokasi->nama_lokasi }}
                                </span>
                            @endif
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Belum Memilih</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pendaftaran</p>
                    <p class="mt-1">
                        @if($mahasiswa->status_pendaftaran == 'sudah')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Sudah Mendaftar</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Belum Mendaftar</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Informasi Pendaftaran -->
        @if($mahasiswa->pendaftaran && $mahasiswa->pendaftaran->lokasi)
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi Pendaftaran</h3>
                @if(isset($mahasiswa->pendaftaran->id))
                <a href="{{ route('admin.pendaftaran.show', $mahasiswa->pendaftaran->id) }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                    <i class="fas fa-external-link-alt mr-1"></i> Lihat Detail Pendaftaran
                </a>
                @endif
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 mb-4 bg-white dark:bg-gray-800">
                <div class="flex flex-col md:flex-row justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $mahasiswa->pendaftaran->lokasi->nama_lokasi }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $mahasiswa->pendaftaran->lokasi->kecamatan }}, {{ $mahasiswa->pendaftaran->lokasi->kabupaten }}
                        </p>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-calendar-alt mr-1 text-gray-500"></i> Terdaftar pada: {{ $mahasiswa->pendaftaran->created_at->format('d F Y H:i') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Data Kesehatan</p>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 mt-2 space-y-1">
                            <li class="flex items-start">
                                <i class="fas fa-heartbeat w-4 h-4 mr-2 mt-0.5 text-gray-500"></i>
                                <span>Golongan Darah: {{ $mahasiswa->pendaftaran->golongan_darah }}</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-notes-medical w-4 h-4 mr-2 mt-0.5 text-gray-500"></i>
                                <span>Riwayat Penyakit: {{ $mahasiswa->pendaftaran->riwayat_penyakit ?: 'Tidak ada' }}</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Kontak Darurat</p>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 mt-2 space-y-1">
                            <li class="flex items-start">
                                <i class="fas fa-user w-4 h-4 mr-2 mt-0.5 text-gray-500"></i>
                                <span>Nama: {{ $mahasiswa->pendaftaran->kontak_darurat_nama ?: '-' }}</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-phone w-4 h-4 mr-2 mt-0.5 text-gray-500"></i>
                                <span>Telepon: {{ $mahasiswa->pendaftaran->kontak_darurat_telepon ?: '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Pendaftaran</p>
                    <p class="mt-1">
                        @if($mahasiswa->pendaftaran->status == 'terdaftar')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Terdaftar</span>
                        @elseif($mahasiswa->pendaftaran->status == 'draft')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Draft</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">{{ ucfirst($mahasiswa->pendaftaran->status) }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Informasi Pembayaran -->
        @if($mahasiswa->pembayaran && $mahasiswa->pembayaran->count() > 0)
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Pembayaran</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Metode Pembayaran</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($mahasiswa->pembayaran as $payment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $payment->order_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->status == 'sukses')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Sukses</span>
                                @elseif($payment->status == 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Pending</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $payment->payment_type ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $payment->created_at->format('d F Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <a href="{{ route('admin.payment.show', $payment->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
