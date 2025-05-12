@extends('layouts.auth')

@section('title', 'Daftar - Sistem Pendaftaran KKNM')

@section('content')
<div class="flex min-h-screen flex-col justify-center pb-12">
  <div class="mx-auto w-full max-w-md">
    <div class="text-center">
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
        Daftar Akun Baru
      </h2>
      <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
        Buat akun untuk memulai pendaftaran KKNM
      </p>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <form class="space-y-6" action="{{ route('register') }}" method="POST">
        @csrf

        <div>
          <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Nama Lengkap
          </label>
          <div class="mt-1">
            <input
              id="nama_lengkap"
              name="nama_lengkap"
              type="text"
              required
              class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
              placeholder="Masukkan nama lengkap"
              value="{{ old('nama_lengkap') }}"
            />
          </div>
          @error('nama_lengkap')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="nim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            NIM
          </label>
          <div class="mt-1">
            <input
              id="nim"
              name="nim"
              type="text"
              required
              class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
              placeholder="Masukkan Nomor Induk Mahasiswa"
              value="{{ old('nim') }}"
            />
          </div>
          @error('nim')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="fakultas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Fakultas
            </label>
            <div class="mt-1">
              <select
                id="fakultas_id"
                name="fakultas_id"
                required
                class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="" disabled {{ old('fakultas_id') ? '' : 'selected' }}>Pilih fakultas</option>
                @foreach($fakultas as $fak)
                  <option value="{{ $fak->id }}" {{ old('fakultas_id') == $fak->id ? 'selected' : '' }}>{{ $fak->nama_fakultas }}</option>
                @endforeach
              </select>
            </div>
            @error('fakultas_id')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="program_studi_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Program Studi
            </label>
            <div class="mt-1">
              <select
                id="program_studi_id"
                name="program_studi_id"
                required
                class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="" selected disabled>Pilih program studi</option>
              </select>
            </div>
            @error('program_studi_id')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Email
          </label>
          <div class="mt-1">
            <input
              id="email"
              name="email"
              type="email"
              required
              class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
              placeholder="Masukkan email"
              value="{{ old('email') }}"
            />
          </div>
          @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="no_telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Nomor Telepon
          </label>
          <div class="mt-1">
            <input
              id="no_telepon"
              name="no_telepon"
              type="text"
              required
              class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
              placeholder="Masukkan nomor telepon"
              value="{{ old('no_telepon') }}"
            />
          </div>
          @error('no_telepon')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Password
          </label>
          <div class="mt-1">
            <input
              id="password"
              name="password"
              type="password"
              required
              class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Password minimal 8 karakter dengan kombinasi huruf dan angka
          </p>
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Konfirmasi Password
          </label>
          <div class="mt-1">
            <input
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              required
              class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        <div class="flex items-center">
          <input
            id="terms"
            name="terms"
            type="checkbox"
            required
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded"
          />
          <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
            Saya menyetujui <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Syarat dan Ketentuan</a> serta <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Kebijakan Privasi</a>
          </label>
        </div>

        <div>
          <button
            type="submit"
            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            <i class="fas fa-user-plus mr-2"></i>
            Daftar
          </button>
        </div>
      </form>
    </div>

    <div class="text-center mt-4">
      <p class="text-sm text-gray-600 dark:text-gray-300">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
          Login
        </a>
      </p>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fakultasSelect = document.getElementById('fakultas_id');
    const programStudiSelect = document.getElementById('program_studi_id');

    fakultasSelect.addEventListener('change', function() {
      const fakultasId = this.value;
      if (fakultasId) {
        // Kosongkan dropdown program studi
        programStudiSelect.innerHTML = '<option value="" selected disabled>Memuat program studi...</option>';

        // Ambil data program studi berdasarkan fakultas
        fetch(`/api/program-studi/${fakultasId}`)
          .then(response => response.json())
          .then(data => {
            programStudiSelect.innerHTML = '<option value="" selected disabled>Pilih program studi</option>';

            data.forEach(prodi => {
              const option = document.createElement('option');
              option.value = prodi.id;
              option.textContent = prodi.nama_program;
              programStudiSelect.appendChild(option);
            });
          })
          .catch(error => {
            console.error('Error:', error);
            programStudiSelect.innerHTML = '<option value="" selected disabled>Gagal memuat data</option>';
          });
      } else {
        programStudiSelect.innerHTML = '<option value="" selected disabled>Pilih program studi</option>';
      }
    });
  });
</script>
@endsection
