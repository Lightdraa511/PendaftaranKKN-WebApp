@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')
@section('page-title', 'Detail Pendaftaran')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Detail Pendaftaran</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.mahasiswa.show', $pendaftaran->user->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-user mr-1"></i> Lihat Mahasiswa
                </a>
                <a href="{{ route('admin.pendaftaran.edit', $pendaftaran->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a href="{{ route('admin.pendaftaran.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
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
            <!-- Informasi Pendaftaran -->
            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Pendaftaran</h3>

                <!-- Detail Pendaftaran -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Status Pendaftaran</h4>
                    <div class="mb-4">
                        @if($pendaftaran->status == 'terdaftar')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Terdaftar</span>
                        @elseif($pendaftaran->status == 'draft')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Draft</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">{{ ucfirst($pendaftaran->status) }}</span>
                        @endif
                    </div>

                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Informasi Lokasi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi KKN</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->lokasi ? $pendaftaran->lokasi->nama_lokasi : '-' }}</p>
                        </div>
                        @if($pendaftaran->lokasi)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->lokasi->alamat }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kabupaten</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->lokasi->kabupaten }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kecamatan</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->lokasi->kecamatan }}</p>
                        </div>
                        @endif
                    </div>

                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Data Pendaftaran</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Golongan Darah</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->golongan_darah ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pendaftaran</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Riwayat Penyakit</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->riwayat_penyakit ?: 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="mb-6 border-t border-gray-200 dark:border-gray-600 pt-4">
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Kontak Darurat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Kontak Darurat</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->kontak_darurat_nama ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Telepon Kontak Darurat</p>
                            <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->kontak_darurat_telepon ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pernyataan -->
                <div class="mb-6 border-t border-gray-200 dark:border-gray-600 pt-4">
                    <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Pernyataan</h4>
                    <div class="bg-gray-100 dark:bg-gray-600 p-3 rounded">
                        <p class="text-gray-700 dark:text-gray-300">{{ $pendaftaran->pernyataan_data_benar ?: 'Belum menyetujui pernyataan' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Mahasiswa -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Mahasiswa</h3>
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                            @if($pendaftaran->user->foto_profil)
                                <img src="{{ asset('storage/profile_photos/' . $pendaftaran->user->foto_profil) }}" alt="{{ $pendaftaran->user->nama_lengkap }}" class="h-12 w-12 rounded-full">
                            @else
                                <i class="fas fa-user text-xl text-gray-400 dark:text-gray-500"></i>
                            @endif
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900 dark:text-white">{{ $pendaftaran->user->nama_lengkap }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $pendaftaran->user->nim }}</p>
                    </div>
                </div>

                <div class="space-y-3 mt-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->user->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fakultas / Program Studi</p>
                        <p class="text-base text-gray-900 dark:text-white">
                            {{ $pendaftaran->user->fakultas->nama_fakultas ?? '-' }} / {{ $pendaftaran->user->programStudi->nama_program ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">IPK</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->user->ipk ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $pendaftaran->user->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pembayaran</p>
                        <p class="mt-1">
                            @if($pendaftaran->user->status_pembayaran == 'lunas')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Lunas</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Belum Lunas</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex justify-end">
            <form action="{{ route('admin.pendaftaran.destroy', $pendaftaran->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pendaftaran ini? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-trash mr-1"></i> Hapus Pendaftaran
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
