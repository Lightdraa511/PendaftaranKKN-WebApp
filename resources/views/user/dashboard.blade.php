@extends('layouts.app')

@section('title', 'Dashboard - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-6">
  <!-- Hero Section -->
  <div class="card bg-gradient-to-br from-blue-600 to-blue-800 text-white p-0">
    <div class="py-6 px-6">
      <h1 class="text-3xl md:text-4xl font-bold mb-2">
        Selamat Datang di Sistem Pendaftaran KKNM
      </h1>
      <p class="text-blue-100 mb-6 text-lg">
        Kuliah Kerja Nyata Mahasiswa - Pengabdian kepada masyarakat sebagai bagian integral dari Tri Dharma Perguruan Tinggi
      </p>

      <div class="space-y-4">
        <div class="p-4 bg-white/10 backdrop-blur-sm rounded-lg">
          <h3 class="font-semibold mb-1">Status Pendaftaran Anda:</h3>
          <div class="flex items-center">
            <span class="w-3 h-3 rounded-full mr-2
              {{ $user->status_pendaftaran == 'sudah' ? 'bg-green-400' :
                ($user->status_pemilihan_lokasi == 'sudah' ? 'bg-blue-400' :
                  ($user->status_pembayaran == 'lunas' ? 'bg-yellow-400' : 'bg-red-400')) }}"></span>
            <span>
              @if($user->status_pendaftaran == 'sudah')
                Pendaftaran Selesai
              @elseif($user->status_pemilihan_lokasi == 'sudah')
                Lokasi Dipilih, Silahkan Lengkapi Formulir Pendaftaran
              @elseif($user->status_pembayaran == 'lunas')
                Pembayaran Lunas, Silahkan Pilih Lokasi
              @else
                Belum Melakukan Pembayaran
              @endif
            </span>
          </div>
        </div>

        <div class="flex flex-wrap gap-3">
          @if($user->status_pembayaran != 'lunas')
            <a href="{{ route('pembayaran.index') }}" class="btn bg-white text-blue-700 hover:bg-blue-50">
              Lakukan Pembayaran
            </a>
          @elseif($user->status_pemilihan_lokasi != 'sudah')
            <a href="{{ route('lokasi.index') }}" class="btn bg-white text-blue-700 hover:bg-blue-50">
              Pilih Lokasi KKNM
            </a>
          @elseif($user->status_pendaftaran != 'sudah')
            <a href="{{ route('pendaftaran.index') }}" class="btn bg-white text-blue-700 hover:bg-blue-50">
              Lengkapi Pendaftaran
            </a>
          @else
            <a href="#" class="btn bg-white text-green-700 hover:bg-green-50">
              <i class="fas fa-check-circle mr-2"></i> Pendaftaran Telah Selesai
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Informasi Umum -->
  <div class="card">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tentang KKNM</h2>
    <p class="text-gray-700 dark:text-gray-300 mb-6">
      Kuliah Kerja Nyata Mahasiswa (KKNM) adalah salah satu bentuk pengabdian kepada masyarakat yang dilakukan oleh mahasiswa dengan pendekatan lintas keilmuan dan sektoral pada waktu dan daerah tertentu. KKNM merupakan bagian integral dari proses pendidikan yang mempunyai ciri-ciri khusus.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="flex items-start p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="w-8 h-8 text-blue-600 mr-3 flex items-center justify-center">
          <i class="fas fa-book-open"></i>
        </div>
        <div>
          <h3 class="font-semibold mb-1">Edukasi</h3>
          <p class="text-sm text-gray-600 dark:text-gray-300">
            Memberikan pengalaman belajar bagi mahasiswa tentang pembangunan masyarakat
          </p>
        </div>
      </div>

      <div class="flex items-start p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="w-8 h-8 text-blue-600 mr-3 flex items-center justify-center">
          <i class="fas fa-users"></i>
        </div>
        <div>
          <h3 class="font-semibold mb-1">Pengabdian</h3>
          <p class="text-sm text-gray-600 dark:text-gray-300">
            Memberdayakan masyarakat melalui penerapan ilmu pengetahuan
          </p>
        </div>
      </div>

      <div class="flex items-start p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="w-8 h-8 text-blue-600 mr-3 flex items-center justify-center">
          <i class="fas fa-award"></i>
        </div>
        <div>
          <h3 class="font-semibold mb-1">Pengalaman</h3>
          <p class="text-sm text-gray-600 dark:text-gray-300">
            Melatih soft-skill kepemimpinan dan kerja tim dalam lingkungan nyata
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Timeline atau Jadwal -->
  <div class="card">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Alur Pendaftaran KKNM</h2>

    <div class="relative border-l-2 border-blue-500 pb-8 pl-8 ml-4">
      <div class="mb-10 relative">
        <div class="absolute -left-10 bg-blue-500 w-6 h-6 rounded-full flex items-center justify-center">
          <i class="fas fa-user-plus w-3 h-3 text-white"></i>
        </div>
        <div>
          <h3 class="font-semibold mb-1">Registrasi Akun</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">Langkah 1</p>
          <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Membuat akun di sistem pendaftaran KKNM
          </p>
        </div>
      </div>

      <div class="mb-10 relative">
        <div class="absolute -left-10 bg-blue-500 w-6 h-6 rounded-full flex items-center justify-center">
          <i class="fas fa-money-bill-wave w-3 h-3 text-white"></i>
        </div>
        <div>
          <h3 class="font-semibold mb-1">Pembayaran Biaya KKNM</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">Langkah 2</p>
          <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Melakukan pembayaran biaya KKNM melalui sistem pembayaran yang tersedia
          </p>
        </div>
      </div>

      <div class="mb-10 relative">
        <div class="absolute -left-10 bg-blue-500 w-6 h-6 rounded-full flex items-center justify-center">
          <i class="fas fa-map-marked-alt w-3 h-3 text-white"></i>
        </div>
        <div>
          <h3 class="font-semibold mb-1">Pemilihan Lokasi</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">Langkah 3</p>
          <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Memilih lokasi KKNM sesuai dengan kuota yang tersedia
          </p>
        </div>
      </div>

      <div class="relative">
        <div class="absolute -left-10 bg-blue-500 w-6 h-6 rounded-full flex items-center justify-center">
          <i class="fas fa-clipboard-list w-3 h-3 text-white"></i>
        </div>
        <div>
          <h3 class="font-semibold mb-1">Mengisi Formulir Pendaftaran</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">Langkah 4</p>
          <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Melengkapi formulir pendaftaran dengan data diri dan persyaratan KKNM
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="card bg-gray-100 dark:bg-gray-800">
    <div class="text-center py-6">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Siap Mendaftar KKNM?</h2>
      <p class="text-gray-600 dark:text-gray-300 mb-6">
        Segera daftar dan ikuti program KKNM untuk pengalaman belajar yang berharga dan berkontribusi pada masyarakat.
      </p>

      @if($user->status_pendaftaran != 'sudah')
        @if($user->status_pembayaran != 'lunas')
          <a href="{{ route('pembayaran.index') }}" class="btn btn-primary">
            Lakukan Pembayaran
          </a>
        @elseif($user->status_pemilihan_lokasi != 'sudah')
          <a href="{{ route('lokasi.index') }}" class="btn btn-primary">
            Pilih Lokasi KKNM
          </a>
        @else
          <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">
            Lengkapi Pendaftaran
          </a>
        @endif
      @else
        <span class="btn bg-green-600 text-white hover:bg-green-700">
          <i class="fas fa-check-circle mr-2"></i> Pendaftaran Telah Selesai
        </span>
      @endif
    </div>
  </div>
</div>
@endsection