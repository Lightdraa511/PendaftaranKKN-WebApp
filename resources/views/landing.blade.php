@extends('layouts.app')

@section('title', 'Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-8 py-8">
  <!-- Hero Section -->
  <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-lg mx-4 md:mx-8">
    <div class="container mx-auto px-6 py-16">
      <div class="flex flex-col lg:flex-row items-center">
        <div class="lg:w-1/2">
          <h1 class="text-4xl font-bold mb-4">Kuliah Kerja Nyata Mahasiswa</h1>
          <p class="text-xl mb-6">Aplikasi pendaftaran KKNM untuk memudahkan proses pengabdian kepada masyarakat sebagai bagian integral dari Tri Dharma Perguruan Tinggi.</p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('login') }}" class="btn bg-white text-blue-700 hover:bg-blue-50 font-medium">
              <i class="fas fa-sign-in-alt mr-2"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="btn bg-blue-500 border border-white text-white hover:bg-blue-600 font-medium">
              <i class="fas fa-user-plus mr-2"></i> Daftar Akun
            </a>
          </div>
        </div>
        <div class="lg:w-1/2 mt-10 lg:mt-0 flex justify-center">
          <div class="bg-white/10 rounded-lg p-6 backdrop-blur-sm w-full max-w-md">
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 mr-3">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <div>
                <h3 class="font-bold text-xl">Jadwal Pendaftaran</h3>
                <p>{{ $pengaturan->tanggal_mulai_pendaftaran->format('d M Y') }} - {{ $pengaturan->tanggal_selesai_pendaftaran->format('d M Y') }}</p>
              </div>
            </div>
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 mr-3">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <div>
                <h3 class="font-bold text-xl">Jadwal Pelaksanaan</h3>
                <p>{{ $pengaturan->tanggal_mulai_pelaksanaan->format('d M Y') }} - {{ $pengaturan->tanggal_selesai_pelaksanaan->format('d M Y') }}</p>
              </div>
            </div>
            <div class="flex items-center">
              <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 mr-3">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div>
                <h3 class="font-bold text-xl">Lokasi Tersedia</h3>
                <p>{{ App\Models\Lokasi::where('status', '!=', 'penuh')->count() }} lokasi di seluruh Indonesia</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pengumuman (dalam format yang lebih terintegrasi) -->
  @if($pengaturan->tampilkan_pengumuman)
  <div class="container mx-auto px-6 mb-12">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $pengaturan->judul_pengumuman }}</h2>

      <p class="text-gray-600 dark:text-gray-300 mb-5 max-w-2xl mx-auto">
        {{ $pengaturan->isi_pengumuman }}
      </p>
    </div>
  </div>
  @endif

  <!-- Alur Pendaftaran KKNM -->
  <div class="container mx-auto px-6 pt-8">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Alur Pendaftaran KKNM</h2>
      <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
        Berikut adalah tahapan pendaftaran Kuliah Kerja Nyata Mahasiswa (KKNM) yang perlu Anda ikuti:
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md relative">
        <div class="absolute -top-4 -left-4 w-10 h-10 bg-blue-600 dark:bg-blue-700 rounded-full flex items-center justify-center text-white font-bold">
          1
        </div>
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 mx-auto">
          <i class="fas fa-user-plus text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2 dark:text-white text-center">Registrasi Akun</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center">
          Membuat akun pada sistem pendaftaran KKNM
        </p>
      </div>

      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md relative">
        <div class="absolute -top-4 -left-4 w-10 h-10 bg-blue-600 dark:bg-blue-700 rounded-full flex items-center justify-center text-white font-bold">
          2
        </div>
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 mx-auto">
          <i class="fas fa-money-bill-wave text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2 dark:text-white text-center">Pembayaran Biaya</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center">
          Melakukan pembayaran biaya administrasi KKNM
        </p>
      </div>

      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md relative">
        <div class="absolute -top-4 -left-4 w-10 h-10 bg-blue-600 dark:bg-blue-700 rounded-full flex items-center justify-center text-white font-bold">
          3
        </div>
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 mx-auto">
          <i class="fas fa-map-marked-alt text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2 dark:text-white text-center">Pemilihan Lokasi</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center">
          Memilih lokasi KKNM sesuai kuota yang tersedia
        </p>
      </div>

      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md relative">
        <div class="absolute -top-4 -left-4 w-10 h-10 bg-blue-600 dark:bg-blue-700 rounded-full flex items-center justify-center text-white font-bold">
          4
        </div>
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 mx-auto">
          <i class="fas fa-clipboard-list text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2 dark:text-white text-center">Mengisi Formulir</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center">
          Melengkapi formulir pendaftaran dengan data persyaratan
        </p>
      </div>
    </div>
  </div>

  <!-- Daftar Lokasi -->
  <div class="container mx-auto px-6 pt-8">
    <div class="mb-12">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Lokasi KKNM</h2>
        <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
          Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($locations as $location)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
          <div class="p-6">
            <div class="flex justify-between items-start mb-4">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $location->nama_lokasi }}</h3>
              <span class="px-2 py-1 text-xs font-medium
                {{ $location->status == 'tersedia' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                  ($location->status == 'terbatas' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' :
                  'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') }} rounded-full">
                {{ ucfirst($location->status) }}
              </span>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 flex items-center">
              <i class="fas fa-map-marker-alt w-4 h-4 mr-1 flex-shrink-0 text-gray-500 dark:text-gray-400"></i>
              <span>{{ $location->kecamatan }}, {{ $location->kabupaten }}, {{ $location->provinsi }}</span>
            </p>

            <div class="mb-3 flex items-center">
              <i class="fas fa-users w-4 h-4 mr-1 text-gray-500 dark:text-gray-400"></i>
              <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($location->kuota_terisi / $location->kuota_total) * 100 }}%"></div>
              </div>
              <span class="ml-2 text-xs text-gray-600 dark:text-gray-300">{{ $location->kuota_terisi }}/{{ $location->kuota_total }}</span>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
              {{ Str::limit($location->fokus_program, 100) }}
            </p>

            <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
              Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="bg-blue-50 dark:bg-blue-900/20">
    <div class="container mx-auto px-6 py-16 text-center">
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Siap Bergabung dengan KKNM?</h2>
      <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
        Jangan lewatkan kesempatan untuk mendapatkan pengalaman berharga dalam pengabdian masyarakat. Daftar sekarang dan jadilah bagian dari perubahan.
      </p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{ route('register') }}" class="btn btn-primary px-8 py-3">
          Daftar Sekarang
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline dark:border-gray-600 dark:text-gray-300 px-8 py-3">
            Masuk ke Akun
          </a>
        </div>
      </div>
    </div>
  </div>
  @endsection