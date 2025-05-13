@extends('layouts.auth')

@section('title', 'Masuk - Sistem Pendaftaran KKNM')

@section('content')
<div class="flex min-h-full flex-col justify-center pb-12">
  <div class="mx-auto w-full max-w-md">
    <div class="text-center">
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
        Masuk ke Akun Anda
      </h2>
      <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
        Silakan masuk untuk mengakses sistem pendaftaran KKNM
      </p>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <form class="space-y-6" action="{{ route('login') }}" method="POST">
        @csrf

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

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Password
          </label>
          <div class="mt-1">
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              required
              class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember-me"
              name="remember"
              type="checkbox"
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded"
            />
            <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
              Ingat saya
            </label>
          </div>

          <div class="text-sm">
            <a href="#" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
              Lupa password?
            </a>
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            <i class="fas fa-sign-in-alt mr-2"></i>
            Masuk
          </button>
        </div>
      </form>

      <div class="mt-6">
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Atau masuk sebagai</span>
          </div>
        </div>

        <div class="mt-6">
          <button
            type="button"
            class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
            id="admin-login"
          >
            <i class="fas fa-user-shield mr-2 text-blue-600 dark:text-blue-400"></i>
            Admin
          </button>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <p class="text-sm text-gray-600 dark:text-gray-300">
        Belum memiliki akun?
        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
          Daftar sekarang
        </a>
      </p>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Admin login button
    const adminLoginButton = document.getElementById('admin-login');
    if (adminLoginButton) {
      adminLoginButton.addEventListener('click', function() {
        document.getElementById('nim').value = 'admin';
        document.getElementById('password').value = 'admin123';
      });
    }
  });
</script>
@endsection