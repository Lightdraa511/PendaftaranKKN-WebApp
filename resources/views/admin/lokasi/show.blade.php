@extends('layouts.admin')

@section('title', 'Detail Lokasi KKN')
@section('page-title', 'Detail Lokasi KKN')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-900 dark:text-white">Detail Lokasi KKN</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.lokasi.edit', $lokasi->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a href="{{ route('admin.lokasi.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi Lokasi -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Lokasi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lokasi</p>
                        <p class="text-base text-gray-900 dark:text-white font-semibold">{{ $lokasi->nama_lokasi }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</p>
                        <p class="text-base text-gray-900 dark:text-white">
                            {{ $lokasi->kecamatan }}, {{ $lokasi->kabupaten }}, {{ $lokasi->provinsi }}
                        </p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                        <p class="text-base">
                            @if($lokasi->status == 'tersedia')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Tersedia</span>
                            @elseif($lokasi->status == 'terbatas')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Terbatas</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Penuh</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Koordinator</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $lokasi->koordinator }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kontak Koordinator</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $lokasi->kontak_koordinator }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fokus Program</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $lokasi->fokus_program ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Deskripsi</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $lokasi->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>

        <!-- Kuota dan Statistik -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Kuota dan Statistik</h3>
            <div class="mb-4">
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Kuota Terisi</span>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $lokasi->kuota_terisi }} / {{ $lokasi->kuota_total }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($lokasi->kuota_terisi / $lokasi->kuota_total) * 100 }}%"></div>
                </div>
            </div>

            <div class="mt-6">
                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-3">Kuota Per Fakultas</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kuota</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terisi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($lokasi->kuotaFakultas as $kuota)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $kuota->fakultas->nama_fakultas }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $kuota->kuota }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $kuota->terisi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 mr-2 w-24">
                                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($kuota->terisi / max($kuota->kuota, 1)) * 100 }}%"></div>
                                            </div>
                                            <span>{{ round(($kuota->terisi / max($kuota->kuota, 1)) * 100) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data kuota fakultas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Daftar Mahasiswa Terdaftar -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Mahasiswa Terdaftar</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIM</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas/Prodi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Daftar</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($pendaftaran as $daftar)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $daftar->user->nim }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $daftar->user->nama_lengkap }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $daftar->user->fakultas->nama_fakultas ?? '-' }}
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $daftar->user->programStudi->nama_program ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $daftar->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($daftar->user->status_pendaftaran == 'diterima')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Diterima</span>
                                    @elseif($daftar->user->status_pendaftaran == 'ditolak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Ditolak</span>
                                    @elseif($daftar->user->status_pendaftaran == 'menunggu')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Menunggu</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Belum Mendaftar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 dark:text-indigo-400">
                                    <a href="{{ route('admin.mahasiswa.show', $daftar->user->id) }}" class="hover:underline">
                                        <i class="fas fa-external-link-alt mr-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada mahasiswa yang mendaftar di lokasi ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection