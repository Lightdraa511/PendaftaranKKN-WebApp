@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Pengaturan Aplikasi</h2>
            <form action="{{ route('admin.pengaturan.reset') }}" method="POST" onsubmit="return confirm('Anda yakin ingin mereset semua pengaturan ke nilai default?');">
                @csrf
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-undo mr-1"></i> Reset ke Default
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-check-circle mr-2"></i></div>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-exclamation-circle mr-2"></i></div>
                    <div>
                        <p class="font-bold">Ada kesalahan pada data yang diinput:</p>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Biaya KKN -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Biaya KKN</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="biaya_pendaftaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biaya Pendaftaran <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">Rp</span>
                            </div>
                            <input type="number" name="biaya_pendaftaran" id="biaya_pendaftaran" value="{{ old('biaya_pendaftaran', $pengaturan->biaya_pendaftaran) }}" class="w-full pl-10 p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                        </div>
                    </div>
                    <div>
                        <label for="biaya_administrasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biaya Administrasi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">Rp</span>
                            </div>
                            <input type="number" name="biaya_administrasi" id="biaya_administrasi" value="{{ old('biaya_administrasi', $pengaturan->biaya_administrasi) }}" class="w-full pl-10 p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Periode Pendaftaran -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Periode Pendaftaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_mulai_pendaftaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai Pendaftaran <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai_pendaftaran" id="tanggal_mulai_pendaftaran" value="{{ old('tanggal_mulai_pendaftaran', $pengaturan->tanggal_mulai_pendaftaran->format('Y-m-d')) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>
                    <div>
                        <label for="tanggal_selesai_pendaftaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai Pendaftaran <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai_pendaftaran" id="tanggal_selesai_pendaftaran" value="{{ old('tanggal_selesai_pendaftaran', $pengaturan->tanggal_selesai_pendaftaran->format('Y-m-d')) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>
                </div>
            </div>

            <!-- Periode Pelaksanaan -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Periode Pelaksanaan KKN</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_mulai_pelaksanaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai_pelaksanaan" id="tanggal_mulai_pelaksanaan" value="{{ old('tanggal_mulai_pelaksanaan', $pengaturan->tanggal_mulai_pelaksanaan->format('Y-m-d')) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>
                    <div>
                        <label for="tanggal_selesai_pelaksanaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai_pelaksanaan" id="tanggal_selesai_pelaksanaan" value="{{ old('tanggal_selesai_pelaksanaan', $pengaturan->tanggal_selesai_pelaksanaan->format('Y-m-d')) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>
                </div>
            </div>

            <!-- Pengumuman -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pengumuman</h3>
                <div class="mb-4">
                    <label for="judul_pengumuman" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Pengumuman</label>
                    <input type="text" name="judul_pengumuman" id="judul_pengumuman" value="{{ old('judul_pengumuman', $pengaturan->judul_pengumuman) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                </div>
                <div class="mb-4">
                    <label for="isi_pengumuman" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Pengumuman</label>
                    <textarea name="isi_pengumuman" id="isi_pengumuman" rows="5" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">{{ old('isi_pengumuman', $pengaturan->isi_pengumuman) }}</textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="tampilkan_pengumuman" id="tampilkan_pengumuman" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ $pengaturan->tampilkan_pengumuman ? 'checked' : '' }}>
                    <label for="tampilkan_pengumuman" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Tampilkan Pengumuman di Dashboard</label>
                </div>
            </div>

            <!-- Status Pendaftaran -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Status Sistem</h3>
                <div class="flex items-center">
                    <input type="checkbox" name="pendaftaran_aktif" id="pendaftaran_aktif" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ $pengaturan->pendaftaran_aktif ? 'checked' : '' }}>
                    <label for="pendaftaran_aktif" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Aktifkan Pendaftaran KKN</label>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Jika dinonaktifkan, mahasiswa tidak akan dapat mendaftar KKN</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md shadow-sm">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
