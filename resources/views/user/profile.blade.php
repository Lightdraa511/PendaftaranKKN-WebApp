@extends('layouts.app')

@section('title', 'Profil Saya - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-6">
  <div class="card w-full">
    <div class="flex items-center mb-6">
      <i class="fas fa-user w-6 h-6 text-blue-600 dark:text-blue-400 mr-2"></i>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profil Saya</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="md:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 text-center">
          <div class="w-32 h-32 mx-auto bg-gray-800 rounded-full flex items-center justify-center mb-4 overflow-hidden">
            @if($user->foto_profil)
              <img src="{{ asset('storage/profile_photos/' . $user->foto_profil) }}" alt="{{ $user->nama_lengkap }}" class="w-full h-full object-cover">
            @else
              <i class="fas fa-user text-5xl text-gray-300"></i>
            @endif
          </div>
          <h3 class="text-xl font-semibold mb-1 dark:text-white">{{ $user->nama_lengkap }}</h3>
          <p class="text-md text-gray-600 dark:text-gray-300 mb-4">{{ $user->email }}</p>
          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="foto-form">
            @csrf
            @method('PUT')
            <input type="file" name="foto_profil" id="foto_profil" class="hidden" onChange="document.getElementById('foto-form').submit()">
            <label for="foto_profil" class="w-full btn bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 mt-2 cursor-pointer">
              <i class="fas fa-camera mr-1"></i> Ubah Foto
            </label>
          </form>
        </div>

        <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
          <h3 class="font-semibold text-lg mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 dark:text-white">Status</h3>
          <div class="space-y-4">
            <div>
              <p class="text-gray-600 dark:text-gray-300 mb-2">Pembayaran</p>
              <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full {{ $user->status_pembayaran == 'lunas' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                <span class="font-medium dark:text-white">{{ $user->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas' }}</span>
              </div>
            </div>
            <div>
              <p class="text-gray-600 dark:text-gray-300 mb-2">Pemilihan Lokasi</p>
              <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full {{ $user->status_pemilihan_lokasi == 'sudah' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                <span class="font-medium dark:text-white">{{ $user->status_pemilihan_lokasi == 'sudah' ? 'Sudah Memilih' : 'Belum Memilih' }}</span>
              </div>
            </div>
            <div>
              <p class="text-gray-600 dark:text-gray-300 mb-2">Pendaftaran KKNM</p>
              <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full {{ $user->status_pendaftaran == 'sudah' ? 'bg-green-500' : 'bg-yellow-400' }}"></span>
                <span class="font-medium dark:text-white">{{ $user->status_pendaftaran == 'sudah' ? 'Sudah Mendaftar' : 'Belum Mendaftar' }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="md:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
          <h3 class="font-semibold text-lg mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 dark:text-white">Informasi Pribadi</h3>
          <form class="space-y-5" action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Nama Lengkap
                </label>
                <input
                  type="text"
                  name="nama_lengkap"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  value="{{ $user->nama_lengkap }}"
                  required
                />
                @error('nama_lengkap')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  NIM
                </label>
                <input
                  type="text"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  value="{{ $user->nim }}"
                  readonly
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Email
                </label>
                <input
                  type="email"
                  name="email"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  value="{{ $user->email }}"
                  required
                />
                @error('email')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  No. Telepon
                </label>
                <input
                  type="tel"
                  name="no_telepon"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  value="{{ $user->no_telepon }}"
                />
                @error('no_telepon')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Alamat
              </label>
              <textarea
                name="alamat"
                class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                rows="3"
              >{{ $user->alamat }}</textarea>
              @error('alamat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Fakultas
                </label>
                <select
                  name="fakultas_id"
                  id="fakultas_id"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  required
                >
                  @foreach($fakultas as $fak)
                    <option value="{{ $fak->id }}" {{ $user->fakultas_id == $fak->id ? 'selected' : '' }}>
                      {{ $fak->nama_fakultas }}
                    </option>
                  @endforeach
                </select>
                @error('fakultas_id')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Program Studi
                </label>
                <select
                  name="program_studi_id"
                  id="program_studi_id"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                  @foreach($programStudi as $prodi)
                    <option value="{{ $prodi->id }}" {{ $user->program_studi_id == $prodi->id ? 'selected' : '' }}>
                      {{ $prodi->nama_program }}
                    </option>
                  @endforeach
                </select>
                @error('program_studi_id')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div class="pt-2">
              <button type="submit" class="btn btn-primary px-6 py-3">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
              </button>
            </div>
          </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
          <h3 class="font-semibold text-lg mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 dark:text-white">Ubah Password</h3>
          <div class="flex justify-center">
            <form class="space-y-4 w-full max-w-md" action="{{ route('profile.update_password') }}" method="POST">
              @csrf
              @method('PUT')

              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Password Lama
                </label>
                <input
                  type="password"
                  name="current_password"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  placeholder="••••••••"
                  required
                />
                @error('current_password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Password Baru
                </label>
                <input
                  type="password"
                  name="password"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  placeholder="••••••••"
                  required
                />
                @error('password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Konfirmasi Password Baru
                </label>
                <input
                  type="password"
                  name="password_confirmation"
                  class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  placeholder="••••••••"
                  required
                />
              </div>
              <div class="pt-3 flex justify-center">
                <button type="submit" class="btn bg-gray-800 dark:bg-gray-700 text-white hover:bg-gray-700 dark:hover:bg-gray-600 px-6 py-3">
                  <i class="fas fa-lock mr-2"></i> Ubah Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Program Studi dependent dropdown
    const fakultasSelect = document.getElementById('fakultas_id');
    const prodiSelect = document.getElementById('program_studi_id');

    if (fakultasSelect && prodiSelect) {
      fakultasSelect.addEventListener('change', function() {
        fetch('{{ route("profile.get_program_studi") }}?fakultas_id=' + this.value)
          .then(response => response.json())
          .then(data => {
            prodiSelect.innerHTML = '';
            data.forEach(prodi => {
              const option = document.createElement('option');
              option.value = prodi.id;
              option.textContent = prodi.nama_program;
              prodiSelect.appendChild(option);
            });
          })
          .catch(error => console.error('Error:', error));
      });
    }
  });
</script>
@endsection