@extends('layouts.admin')

@section('title', 'Manajemen Mahasiswa')
@section('page-title', 'Manajemen Mahasiswa')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between mb-6">
            <div>
                <h1 class="text-xl font-medium text-gray-800 dark:text-gray-200">Daftar Mahasiswa</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola data mahasiswa yang terdaftar pada sistem</p>
            </div>
            <div>
                <a href="{{ route('admin.mahasiswa.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Mahasiswa
                </a>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <form action="{{ route('admin.mahasiswa.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white" placeholder="Nama / NIM / Email">
                </div>
                <div>
                    <label for="fakultas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fakultas</label>
                    <select name="fakultas_id" id="fakultas_id" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                        <option value="">Semua Fakultas</option>
                        @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}" {{ request('fakultas_id') == $fak->id ? 'selected' : '' }}>{{ $fak->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status_pendaftaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Pendaftaran</label>
                    <select name="status_pendaftaran" id="status_pendaftaran" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="belum" {{ request('status_pendaftaran') == 'belum' ? 'selected' : '' }}>Belum Mendaftar</option>
                        <option value="sudah" {{ request('status_pendaftaran') == 'sudah' ? 'selected' : '' }}>Sudah Mendaftar</option>
                        <option value="menunggu" {{ request('status_pendaftaran') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ request('status_pendaftaran') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status_pendaftaran') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Mahasiswa -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIM</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas/Prodi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Pendaftaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($mahasiswa as $mhs)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $mhs->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $mhs->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $mhs->fakultas->nama_fakultas ?? '-' }}
                                <br>
                                <span class="text-xs text-gray-400">{{ $mhs->programStudi->nama_program ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $mhs->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($mhs->status_pendaftaran == 'diterima')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">Diterima</span>
                                @elseif($mhs->status_pendaftaran == 'ditolak')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">Ditolak</span>
                                @elseif($mhs->status_pendaftaran == 'menunggu')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100">Menunggu</span>
                                @elseif($mhs->status_pendaftaran == 'sudah')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100">Sudah Mendaftar</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">Belum Mendaftar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.mahasiswa.show', $mhs->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
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
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data mahasiswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $mahasiswa->links() }}
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
