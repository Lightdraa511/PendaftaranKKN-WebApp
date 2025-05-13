@extends('layouts.admin')

@section('title', 'Edit Lokasi KKN')
@section('page-title', 'Edit Lokasi KKN')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Edit Lokasi KKN</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.lokasi.show', $lokasi->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                </a>
                <a href="{{ route('admin.lokasi.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
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

        <form action="{{ route('admin.lokasi.update', $lokasi->id) }}" method="POST" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Dasar Lokasi -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Dasar</h3>

                    <div class="mb-4">
                        <label for="nama_lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lokasi" id="nama_lokasi" value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $lokasi->kecamatan) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="kabupaten" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten <span class="text-red-500">*</span></label>
                        <input type="text" name="kabupaten" id="kabupaten" value="{{ old('kabupaten', $lokasi->kabupaten) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="provinsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Provinsi <span class="text-red-500">*</span></label>
                        <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $lokasi->provinsi) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="fokus_program" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fokus Program</label>
                        <input type="text" name="fokus_program" id="fokus_program" value="{{ old('fokus_program', $lokasi->fokus_program) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>

                <!-- Informasi Kuota dan Koordinator -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Kuota dan Koordinator</h3>

                    <div class="mb-4">
                        <label for="kuota_total" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kuota Total <span class="text-red-500">*</span></label>
                        <input type="number" name="kuota_total" id="kuota_total" value="{{ old('kuota_total', $lokasi->kuota_total) }}" min="1" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                            <option value="tersedia" {{ old('status', $lokasi->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="terbatas" {{ old('status', $lokasi->status) == 'terbatas' ? 'selected' : '' }}>Kuota Terbatas</option>
                            <option value="penuh" {{ old('status', $lokasi->status) == 'penuh' ? 'selected' : '' }}>Penuh</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="koordinator" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Koordinator <span class="text-red-500">*</span></label>
                        <input type="text" name="koordinator" id="koordinator" value="{{ old('koordinator', $lokasi->koordinator) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label for="kontak_koordinator" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kontak Koordinator <span class="text-red-500">*</span></label>
                        <input type="text" name="kontak_koordinator" id="kontak_koordinator" value="{{ old('kontak_koordinator', $lokasi->kontak_koordinator) }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" required>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mt-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Lokasi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">{{ old('deskripsi', $lokasi->deskripsi) }}</textarea>
            </div>

            <!-- Kuota per Fakultas -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Kuota per Fakultas</h3>

                <div class="overflow-x-auto mb-4">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kuota</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terisi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($lokasi->kuotaFakultas as $kuota)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $kuota->fakultas->nama_fakultas }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <input type="hidden" name="kuota_fakultas_id[]" value="{{ $kuota->id }}">
                                        <input type="number" name="edit_kuota[]" value="{{ old('edit_kuota.'.$loop->index, $kuota->kuota) }}" min="{{ $kuota->terisi }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $kuota->terisi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="if(confirm('Hapus kuota fakultas ini?')) document.getElementById('delete-kuota-{{ $kuota->id }}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-kuota-{{ $kuota->id }}" action="{{ route('admin.lokasi.delete-kuota', $kuota->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada kuota fakultas yang diatur</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-2">Tambah Kuota Fakultas Baru</h4>

                    <div class="space-y-4" id="kuota-fakultas-container">
                        <!-- Placeholder untuk form kuota fakultas baru -->
                    </div>

                    <button type="button" id="tambah-fakultas" class="mt-2 px-4 py-2 bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-md hover:bg-indigo-200 dark:hover:bg-indigo-700">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Kuota Fakultas
                    </button>
                </div>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menambahkan form kuota fakultas
        const tambahFakultasBtn = document.getElementById('tambah-fakultas');
        const container = document.getElementById('kuota-fakultas-container');
        let counter = 0;

        // Fungsi untuk mendapatkan daftar fakultas
        async function getFakultas() {
            try {
                const response = await fetch('{{ route("api.fakultas") }}');
                if (!response.ok) throw new Error('Gagal mengambil data fakultas');
                return await response.json();
            } catch (error) {
                console.error('Error:', error);
                return [];
            }
        }

        tambahFakultasBtn.addEventListener('click', async function() {
            const fakultasList = await getFakultas();
            if (fakultasList.length === 0) {
                alert('Tidak dapat memuat daftar fakultas. Silakan coba lagi nanti.');
                return;
            }

            const div = document.createElement('div');
            div.className = 'flex items-center space-x-4';
            div.innerHTML = `
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fakultas</label>
                    <select name="fakultas_id[]" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                        ${fakultasList.map(f => `<option value="${f.id}">${f.nama_fakultas}</option>`).join('')}
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kuota</label>
                    <input type="number" name="kuota[]" min="1" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                </div>
                <div class="flex items-end">
                    <button type="button" class="hapus-fakultas p-2 bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-300 rounded-md hover:bg-red-200 dark:hover:bg-red-700 mb-1">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            container.appendChild(div);

            // Tambahkan event listener untuk tombol hapus
            div.querySelector('.hapus-fakultas').addEventListener('click', function() {
                div.remove();
            });

            counter++;
        });
    });
</script>
@endsection
