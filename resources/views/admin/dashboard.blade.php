@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Mahasiswa -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-100 rounded-full p-3">
                <i class="fas fa-users text-indigo-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Mahasiswa</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $totalUsers }}</h3>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Lihat semua <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
        </div>
    </div>

    <!-- Total Pendaftaran -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-emerald-100 rounded-full p-3">
                <i class="fas fa-clipboard-list text-emerald-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pendaftaran</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $totalPendaftaran }}</h3>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-sm text-emerald-600 hover:text-emerald-800">Lihat semua <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
        </div>
    </div>

    <!-- Total Pembayaran -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-amber-100 rounded-full p-3">
                <i class="fas fa-money-bill-wave text-amber-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pembayaran</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $totalPembayaran }}</h3>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-sm text-amber-600 hover:text-amber-800">Lihat semua <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
        </div>
    </div>

    <!-- Total Lokasi -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                <i class="fas fa-map-marker-alt text-red-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Lokasi</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $totalLokasi }}</h3>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-sm text-red-600 hover:text-red-800">Lihat semua <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
        </div>
    </div>
</div>

<!-- Grafik dan Tabel -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Grafik Pendaftaran -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Pendaftaran</h2>
        <canvas id="pendaftaranChart" height="250"></canvas>
    </div>

    <!-- Grafik Status Pendaftaran -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Pendaftaran</h2>
        <canvas id="statusPendaftaranChart" height="250"></canvas>
    </div>
</div>

<!-- Lokasi Terpopuler -->
<div class="mt-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Lokasi Terpopuler</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Lokasi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kuota Terisi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Persentase
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($lokasiTerpopuler as $lokasi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $lokasi->nama_lokasi }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $lokasi->kuota_terisi }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 h-2 rounded-full">
                                @php
                                    $percentage = 0;
                                    if (isset($lokasi->kuota_total) && $lokasi->kuota_total > 0) {
                                        $percentage = ($lokasi->kuota_terisi / $lokasi->kuota_total) * 100;
                                    }
                                    $colorClass = 'bg-green-500';

                                    if ($percentage >= 70 && $percentage < 100) {
                                        $colorClass = 'bg-yellow-500';
                                    } elseif ($percentage >= 100) {
                                        $colorClass = 'bg-red-500';
                                    }
                                @endphp
                                <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-xs text-gray-600 mt-1">{{ round($percentage) }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk grafik pendaftaran per bulan
        const pendaftaranData = @json($pendaftaranPerBulan);
        const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const pendaftaranCounts = Array(12).fill(0);

        if (pendaftaranData && pendaftaranData.length > 0) {
            pendaftaranData.forEach(item => {
                if (item.bulan && !isNaN(item.bulan)) {
                    pendaftaranCounts[item.bulan - 1] = item.jumlah;
                }
            });
        }

        // Grafik pendaftaran per bulan
        const pendaftaranCtx = document.getElementById('pendaftaranChart').getContext('2d');
        new Chart(pendaftaranCtx, {
            type: 'bar',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Jumlah Pendaftaran',
                    data: pendaftaranCounts,
                    backgroundColor: 'rgba(79, 70, 229, 0.6)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Data untuk grafik status pendaftaran
        const statusData = @json($statusPendaftaran);
        const statusLabels = [];
        const statusCounts = [];
        const statusColors = [
            'rgba(52, 211, 153, 0.8)',
            'rgba(251, 191, 36, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(59, 130, 246, 0.8)'
        ];

        if (statusData && statusData.length > 0) {
            statusData.forEach((item, index) => {
                if (item.status) {
                    statusLabels.push(item.status);
                    statusCounts.push(item.jumlah);
                }
            });
        }

        // Grafik status pendaftaran
        const statusCtx = document.getElementById('statusPendaftaranChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusCounts,
                    backgroundColor: statusColors.slice(0, statusCounts.length),
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>
@endsection
