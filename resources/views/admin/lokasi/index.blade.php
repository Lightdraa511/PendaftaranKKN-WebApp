@extends('layouts.admin')

@section('title', 'Manajemen Lokasi KKN')
@section('page-title', 'Manajemen Lokasi KKN')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between mb-6">
            <div>
                <h1 class="text-xl font-medium text-gray-800 dark:text-gray-200">Daftar Lokasi KKN</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola data lokasi KKNM yang tersedia</p>
            </div>
            <div>
                <a href="{{ route('admin.lokasi.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Lokasi
                </a>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <form action="{{ route('admin.lokasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" placeholder="Nama Lokasi / Kecamatan / Kabupaten">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" id="status" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="terbatas" {{ request('status') == 'terbatas' ? 'selected' : '' }}>Kuota Terbatas</option>
                        <option value="penuh" {{ request('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Lokasi -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Lokasi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kecamatan/Kabupaten</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Koordinator</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kuota</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($lokasi as $loc)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $loc->nama_lokasi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $loc->kecamatan }}, {{ $loc->kabupaten }}
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $loc->provinsi }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $loc->koordinator }}
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $loc->kontak_koordinator }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $loc->kuota_terisi }}/{{ $loc->kuota_total }}
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 mt-1">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($loc->kuota_terisi / $loc->kuota_total) * 100 }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($loc->status == 'tersedia')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Tersedia</span>
                                @elseif($loc->status == 'terbatas')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Terbatas</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Penuh</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.lokasi.show', $loc->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.lokasi.edit', $loc->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.lokasi.destroy', $loc->id) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus lokasi ini? Pastikan tidak ada mahasiswa yang mendaftar di lokasi ini.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data lokasi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $lokasi->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script tambahan jika diperlukan
    });
</script>
@endsection
