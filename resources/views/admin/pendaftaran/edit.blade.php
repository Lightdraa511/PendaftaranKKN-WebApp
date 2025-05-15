@extends('layouts.admin')

@section('title', 'Edit Pendaftaran')
@section('page-title', 'Edit Pendaftaran')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Edit Pendaftaran</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
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

            @if($errors->any())
                <div class="bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <div class="py-1"><i class="fas fa-exclamation-circle mr-2"></i></div>
                        <div>
                            <p class="font-bold">Terdapat kesalahan input:</p>
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Form Edit Pendaftaran -->
            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Data Pendaftaran</h3>

                <form action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Status Pendaftaran -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Pendaftaran <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                            <option value="draft" {{ old('status', $pendaftaran->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="terdaftar" {{ old('status', $pendaftaran->status) == 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                        </select>
                    </div>

                    <!-- Lokasi KKN -->
                    <div class="mb-4">
                        <label for="lokasi_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi KKN <span class="text-red-500">*</span></label>
                        <select name="lokasi_id" id="lokasi_id" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                            @foreach($lokasi as $item)
                                <option value="{{ $item->id }}" {{ old('lokasi_id', $pendaftaran->lokasi_id) == $item->id ? 'selected' : '' }}>{{ $item->nama_lokasi }} ({{ $item->kabupaten }}, {{ $item->kecamatan }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Data Kesehatan -->
                    <div class="mb-4">
                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Data Kesehatan</h4>
                        <div class="mb-4">
                            <label for="golongan_darah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Golongan Darah <span class="text-red-500">*</span></label>
                            <select name="golongan_darah" id="golongan_darah" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                                <option value="A" {{ old('golongan_darah', $pendaftaran->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('golongan_darah', $pendaftaran->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('golongan_darah', $pendaftaran->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('golongan_darah', $pendaftaran->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Riwayat Penyakit</label>
                            <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="3" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">{{ old('riwayat_penyakit', $pendaftaran->riwayat_penyakit) }}</textarea>
                        </div>
                    </div>

                    <!-- Kontak Darurat -->
                    <div class="mb-4">
                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Kontak Darurat</h4>
                        <div class="mb-4">
                            <label for="kontak_darurat_nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kontak Darurat <span class="text-red-500">*</span></label>
                            <input type="text" name="kontak_darurat_nama" id="kontak_darurat_nama" value="{{ old('kontak_darurat_nama', $pendaftaran->kontak_darurat_nama) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                        </div>
                        <div class="mb-4">
                            <label for="kontak_darurat_telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telepon Kontak Darurat <span class="text-red-500">*</span></label>
                            <input type="text" name="kontak_darurat_telepon" id="kontak_darurat_telepon" value="{{ old('kontak_darurat_telepon', $pendaftaran->kontak_darurat_telepon) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fakultas / Program Studi</p>
                        <p class="text-base text-gray-900 dark:text-white">
                            {{ $pendaftaran->user->fakultas->nama_fakultas ?? '-' }} / {{ $pendaftaran->user->programStudi->nama_program ?? '-' }}
                        </p>
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
    </div>
</div>
@endsection
