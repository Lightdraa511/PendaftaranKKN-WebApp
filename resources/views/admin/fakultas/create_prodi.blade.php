@extends('layouts.admin')

@section('title', 'Tambah Program Studi')
@section('page-title', 'Tambah Program Studi')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Tambah Program Studi - {{ $fakultas->nama_fakultas }}</h2>
            <a href="{{ route('admin.fakultas.show', $fakultas->id) }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
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

        <form action="{{ route('admin.fakultas.prodi.store', $fakultas->id) }}" method="POST" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            @csrf
            <div class="mb-4">
                <label for="nama_program" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="nama_program" id="nama_program" value="{{ old('nama_program') }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Contoh: Teknik Informatika</p>
            </div>

            <div class="mb-4">
                <label for="kode_program" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="kode_program" id="kode_program" value="{{ old('kode_program') }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Contoh: TI (gunakan kode unik untuk setiap program studi)</p>
            </div>

            <div class="mb-4">
                <label for="jenjang" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenjang <span class="text-red-500">*</span></label>
                <select name="jenjang" id="jenjang" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    <option value="">Pilih Jenjang</option>
                    <option value="D3" {{ old('jenjang') == 'D3' ? 'selected' : '' }}>D3</option>
                    <option value="D4" {{ old('jenjang') == 'D4' ? 'selected' : '' }}>D4</option>
                    <option value="S1" {{ old('jenjang') == 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('jenjang') == 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ old('jenjang') == 'S3' ? 'selected' : '' }}>S3</option>
                </select>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md shadow-sm">
                    <i class="fas fa-save mr-2"></i> Simpan Program Studi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
