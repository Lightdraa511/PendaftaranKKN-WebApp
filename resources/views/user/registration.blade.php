@extends('layouts.app')

@section('title', 'Form Pendaftaran KKNM - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="card w-full">
    <div class="flex items-center mb-6">
      <i class="fas fa-clipboard-list w-6 h-6 text-blue-600 dark:text-blue-400 mr-2"></i>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pendaftaran KKNM</h2>
    </div>

    <!-- Progress Timeline (Ditambahkan dari baru2.html) -->
    <div class="mb-8">
      <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 dark:bg-blue-900/30 dark:border-blue-700 rounded-r-lg">
        <div class="flex">
          <div class="flex-shrink-0">
            <i class="fas fa-info-circle w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-blue-700 dark:text-blue-300">
              Silakan lengkapi semua informasi di bawah ini untuk mendaftar KKNM. Lokasi KKNM telah ditentukan berdasarkan fakultas Anda.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Pendaftaran -->
    <div>
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Formulir Pendaftaran KKNM</h3>
      <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
        <form action="{{ route('pendaftaran.store') }}" method="POST">
          @csrf

          <div class="space-y-6">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Pribadi</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Nama Lengkap <span class="text-red-500">*</span>
                  </label>
                  <input
                    type="text"
                    value="{{ $user->nama_lengkap }}"
                    class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    required
                    readonly
                  />
                  <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Data diambil dari profil</p>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    NIM <span class="text-red-500">*</span>
                  </label>
                  <input
                    type="text"
                    value="{{ $user->nim }}"
                    class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    required
                    readonly
                  />
                  <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Data diambil dari profil</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Program Studi <span class="text-red-500">*</span>
                      </label>
                      <input
                        type="text"
                        value="{{ $user->programStudi ? $user->programStudi->nama_program : 'Belum dipilih' }}"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required
                        readonly
                      />
                      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Data diambil dari profil</p>
                    </div>

                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        IPK <span class="text-red-500">*</span>
                      </label>
                      <input
                        type="text"
                        value="{{ $user->ipk ?? 'Belum tercatat' }}"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required
                        readonly
                      />
                      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Data diambil dari sistem akademik</p>
                    </div>

                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Alamat Tinggal <span class="text-red-500">*</span>
                      </label>
                      <textarea
                        name="alamat"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        rows="2"
                        required
                      >{{ $user->alamat }}</textarea>
                      @error('alamat')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                      @enderror
                    </div>

                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nomor Telepon <span class="text-red-500">*</span>
                      </label>
                      <input
                        type="tel"
                        name="no_telepon"
                        value="{{ $user->no_telepon }}"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required
                      />
                      @error('no_telepon')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tambahan</h3>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Golongan Darah <span class="text-red-500">*</span>
                      </label>
                      <select
                        name="golongan_darah"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required
                      >
                        <option value="" {{ old('golongan_darah', $pendaftaran->golongan_darah ?? '') === '' ? 'selected' : '' }}>Pilih Golongan Darah</option>
                        <option value="A" {{ old('golongan_darah', $pendaftaran->golongan_darah ?? '') === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah', $pendaftaran->golongan_darah ?? '') === 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah', $pendaftaran->golongan_darah ?? '') === 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah', $pendaftaran->golongan_darah ?? '') === 'O' ? 'selected' : '' }}>O</option>
                      </select>
                      @error('golongan_darah')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                      @enderror
                    </div>

                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Riwayat Penyakit
                      </label>
                      <input
                        type="text"
                        name="riwayat_penyakit"
                        value="{{ old('riwayat_penyakit', $pendaftaran->riwayat_penyakit ?? '') }}"
                        placeholder="Jika ada"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                      />
                      @error('riwayat_penyakit')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                      @enderror
                    </div>

                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Kontak Darurat <span class="text-red-500">*</span>
                      </label>
                      <input
                        type="text"
                        name="kontak_darurat_nama"
                        value="{{ old('kontak_darurat_nama', $pendaftaran->kontak_darurat_nama ?? '') }}"
                        placeholder="Nama kontak darurat"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 mb-2"
                        required
                      />
                      @error('kontak_darurat_nama')
                        <p class="mt-1 mb-2 text-xs text-red-500">{{ $message }}</p>
                      @enderror

                      <input
                        type="tel"
                        name="kontak_darurat_telepon"
                        value="{{ old('kontak_darurat_telepon', $pendaftaran->kontak_darurat_telepon ?? '') }}"
                        placeholder="Nomor telepon kontak darurat"
                        class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required
                      />
                      @error('kontak_darurat_telepon')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                </div>

                <!-- Lokasi yang Sudah Ditentukan -->
                <div>
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lokasi KKNM Anda</h3>
                  <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">
                      <div class="flex items-start justify-between mb-2">
                        <div>
                          <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $pendaftaran->lokasi->nama_lokasi }}</h4>
                          <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $pendaftaran->lokasi->kecamatan }}, {{ $pendaftaran->lokasi->kabupaten }}, {{ $pendaftaran->lokasi->provinsi }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Informasi Lokasi:</h5>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                          <li class="flex items-start">
                            <i class="fas fa-user-tie w-4 h-4 mr-2 mt-0.5 text-gray-500 dark:text-gray-400"></i>
                            <span>Koordinator: {{ $pendaftaran->lokasi->koordinator }}</span>
                          </li>
                          <li class="flex items-start">
                            <i class="fas fa-phone w-4 h-4 mr-2 mt-0.5 text-gray-500 dark:text-gray-400"></i>
                            <span>Kontak: {{ $pendaftaran->lokasi->kontak_koordinator }}</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="flex items-center pt-4">
                  <input
                    id="pernyataan_data_benar"
                    name="pernyataan_data_benar"
                    type="checkbox"
                    value="1"
                    {{ old('pernyataan_data_benar', $pendaftaran->pernyataan_data_benar ? 'checked' : '') }}
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600"
                    required
                  />
                  <label for="pernyataan_data_benar" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                    Saya menyatakan bahwa data yang saya isi adalah benar dan saya bersedia mengikuti semua ketentuan dan peraturan KKNM.
                  </label>
                </div>
                @error('pernyataan_data_benar')
                  <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror

                <!-- Note dan Tombol Submit -->
                <div class="pt-2 flex justify-end space-x-3">
                  <button type="submit" class="btn btn-primary">
                    Daftar KKNM
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endsection

    @section('scripts')
    <script>
      // Script tambahan jika diperlukan
    </script>
    @endsection

    @section('styles')
    <style>
      /* Timeline Custom Style */
      .timeline-container {
        position: relative;
        padding-left: 3rem;
      }
      .timeline-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 1.15rem;
        height: 100%;
        width: 2px;
        background-color: #e5e7eb;
      }
      .dark .timeline-container::before {
        background-color: #4b5563;
      }
      .timeline-dot {
        position: absolute;
        left: 0;
        top: 0;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        background-color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
      }
      .timeline-dot.completed {
        background-color: #10b981;
      }
      .timeline-dot.pending {
        background-color: #f59e0b;
      }
      .timeline-dot.disabled {
        background-color: #9ca3af;
      }
    </style>
    @endsection