@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')
@section('page-title', 'Tambah Mahasiswa')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Tambah Mahasiswa Baru</h2>
            <a href="{{ route('admin.mahasiswa.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.mahasiswa.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIM <span class="text-red-500">*</span></label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                    @error('nim')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">No. Telepon <span class="text-red-500">*</span></label>
                    <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                    @error('no_telepon')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fakultas -->
                <div>
                    <label for="fakultas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fakultas <span class="text-red-500">*</span></label>
                    <select name="fakultas_id" id="fakultas_id" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Fakultas</option>
                        @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}" {{ old('fakultas_id') == $fak->id ? 'selected' : '' }}>{{ $fak->nama_fakultas }}</option>
                        @endforeach
                    </select>
                    @error('fakultas_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program Studi -->
                <div>
                    <label for="program_studi_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Program Studi <span class="text-red-500">*</span></label>
                    <select name="program_studi_id" id="program_studi_id" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Program Studi</option>
                        @foreach($programStudi as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('program_studi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_program }}</option>
                        @endforeach
                    </select>
                    @error('program_studi_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script untuk mengambil program studi berdasarkan fakultas
        const fakultasSelect = document.getElementById('fakultas_id');
        const prodiSelect = document.getElementById('program_studi_id');

        fakultasSelect.addEventListener('change', function() {
            const fakultasId = this.value;
            if (fakultasId) {
                fetch(`{{ url('admin/api/program-studi') }}/${fakultasId}`)
                    .then(response => response.json())
                    .then(data => {
                        prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                        data.forEach(prodi => {
                            prodiSelect.innerHTML += `<option value="${prodi.id}">${prodi.nama_program}</option>`;
                        });
                    });
            } else {
                prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            }
        });
    });
</script>
@endsection
