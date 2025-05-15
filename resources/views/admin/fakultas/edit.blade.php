@extends('layouts.admin')

@section('title', 'Edit Fakultas')
@section('page-title', 'Edit Fakultas')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Edit Fakultas</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.fakultas.show', $fakultas->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                </a>
                <a href="{{ route('admin.fakultas.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
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

        <form action="{{ route('admin.fakultas.update', $fakultas->id) }}" method="POST" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_fakultas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Fakultas <span class="text-red-500">*</span></label>
                <input type="text" name="nama_fakultas" id="nama_fakultas" value="{{ old('nama_fakultas', $fakultas->nama_fakultas) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
            </div>

            <div class="mb-4">
                <label for="kode_fakultas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Fakultas <span class="text-red-500">*</span></label>
                <input type="text" name="kode_fakultas" id="kode_fakultas" value="{{ old('kode_fakultas', $fakultas->kode_fakultas) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Contoh: FT (gunakan kode unik untuk setiap fakultas)</p>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md shadow-sm">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
