@extends('layouts.app')

@section('title', 'Lokasi KKNM - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-6">
  <div class="card">
    <div class="flex items-center mb-6">
      <i class="fas fa-map-marker-alt w-6 h-6 text-blue-600 dark:text-blue-400 mr-2"></i>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Lokasi KKNM</h2>
    </div>

    <div class="mb-6">
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <i class="fas fa-search w-5 h-5 text-gray-400"></i>
        </div>
        <input
          type="text"
          id="search-location"
          class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
          placeholder="Cari lokasi KKNM..."
        />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($lokasi as $loc)
      <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 location-item">
        <div class="p-5">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $loc->nama_lokasi }}</h3>
            <span class="px-2 py-1 text-xs font-medium
              {{ $loc->status == 'tersedia' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' :
                ($loc->status == 'terbatas' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' :
                'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300') }} rounded-full">
              {{ ucfirst($loc->status) }}
            </span>
          </div>

          <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 flex items-center">
            <i class="fas fa-map-marker-alt w-4 h-4 mr-1 flex-shrink-0 text-gray-500 dark:text-gray-400"></i>
            <span>{{ $loc->kecamatan }}, {{ $loc->kabupaten }}, {{ $loc->provinsi }}</span>
          </p>

          <div class="mb-3 flex items-center">
            <i class="fas fa-users w-4 h-4 mr-1 text-gray-500 dark:text-gray-400"></i>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
              <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($loc->kuota_terisi / $loc->kuota_total) * 100 }}%"></div>
            </div>
            <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">{{ $loc->kuota_terisi }}/{{ $loc->kuota_total }}</span>
          </div>

          <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            {{ Str::limit($loc->fokus_program, 100) }}
          </p>

          <div class="flex justify-end">
            @if($loc->status != 'penuh')
              <button
                type="button"
                class="btn btn-primary text-sm py-1.5 px-3 detail-button"
                data-id="{{ $loc->id }}"
                data-nama="{{ $loc->nama_lokasi }}"
                data-alamat="{{ $loc->kecamatan }}, {{ $loc->kabupaten }}, {{ $loc->provinsi }}"
                data-status="{{ $loc->status }}"
                data-koordinator="{{ $loc->koordinator }}"
                data-kontak="{{ $loc->kontak_koordinator }}"
                data-deskripsi="{{ $loc->deskripsi }}"
                data-kuota="{{ $loc->kuota_terisi }}/{{ $loc->kuota_total }}"
              >
                <i class="fas fa-info-circle mr-1.5"></i>Detail
              </button>
            @else
              <button class="btn btn-outline text-sm py-1.5 px-3 opacity-75 cursor-not-allowed">
                <i class="fas fa-info-circle mr-1.5"></i>Detail
              </button>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Modal Detail Lokasi -->
<div id="location-detail-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white dark:bg-gray-800 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
    <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex justify-between items-center">
      <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modal-title">Detail Lokasi KKNM</h3>
      <button id="close-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Informasi Lokasi -->
        <div>
          <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3" id="modal-location-name"></h4>
          <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex items-start">
            <i class="fas fa-map-marker-alt w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-gray-500 dark:text-gray-400"></i>
            <span id="modal-location-address"></span>
          </p>

          <!-- Status dan Koordinator -->
          <div class="mb-4 space-y-2">
            <div class="flex items-center">
              <span class="w-28 text-sm text-gray-600 dark:text-gray-400">Status:</span>
              <span id="modal-location-status" class="px-2 py-1 text-xs font-medium rounded-full">
                Tersedia
              </span>
            </div>
            <div class="flex items-start">
              <span class="w-28 text-sm text-gray-600 dark:text-gray-400">Koordinator:</span>
              <span id="modal-coordinator" class="text-sm text-gray-800 dark:text-gray-300"></span>
            </div>
            <div class="flex items-start">
              <span class="w-28 text-sm text-gray-600 dark:text-gray-400">Kontak:</span>
              <span id="modal-coordinator-contact" class="text-sm text-gray-800 dark:text-gray-300"></span>
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="mb-4">
            <h5 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Deskripsi Program:</h5>
            <p id="modal-location-description" class="text-sm text-gray-700 dark:text-gray-300"></p>
          </div>
        </div>

        <!-- Kuota per Fakultas -->
        <div>
          <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Kuota per Fakultas</h4>
          <div class="space-y-3" id="modal-faculty-quotas">
            @foreach($fakultas as $fak)
            <div>
              <div class="flex justify-between items-center mb-1">
                <div class="flex items-center">
                  <span class="text-sm font-medium text-gray-800 dark:text-gray-300">{{ $fak->nama_fakultas }}</span>
                </div>
                <span class="text-xs text-gray-600 dark:text-gray-400" id="quota-faculty-{{ $fak->id }}">0/0</span>
              </div>
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" id="quota-bar-faculty-{{ $fak->id }}" style="width: 0%"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="mt-6 flex justify-end">
        <form id="select-location-form" method="POST" action="">
          @csrf
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-check-circle mr-2"></i> Pilih Lokasi Ini
          </button>
        </form>
      </div>

      <!-- Daftar Mahasiswa Yang Sudah Mendaftar -->
      <div class="mt-6">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Daftar Mahasiswa <span id="modal-student-count"></span></h4>
        <div class="border rounded-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                  <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                  <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIM</th>
                  <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fakultas</th>
                </tr>
              </thead>
              <tbody id="modal-student-list" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <!-- List mahasiswa akan diisi oleh JavaScript -->
                <tr>
                  <td colspan="3" class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 text-center">Memuat data...</td>
                </tr>
              </tbody>
            </table>
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
    // Search functionality
    const searchInput = document.getElementById('search-location');
    if (searchInput) {
      searchInput.addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const locationItems = document.querySelectorAll('.location-item');

        locationItems.forEach(item => {
          const locationName = item.querySelector('h3').textContent.toLowerCase();
          const locationAddress = item.querySelector('p span').textContent.toLowerCase();

          if (locationName.includes(searchTerm) || locationAddress.includes(searchTerm)) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      });
    }

    // Detail button functionality
    const detailButtons = document.querySelectorAll('.detail-button');
    const locationDetailModal = document.getElementById('location-detail-modal');
    const closeModalBtn = document.getElementById('close-modal');

    detailButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Ambil data dari atribut data-*
        const id = this.getAttribute('data-id');
        const nama = this.getAttribute('data-nama');
        const alamat = this.getAttribute('data-alamat');
        const status = this.getAttribute('data-status');
        const koordinator = this.getAttribute('data-koordinator');
        const kontak = this.getAttribute('data-kontak');
        const deskripsi = this.getAttribute('data-deskripsi');

        // Isi data ke modal
        document.getElementById('modal-location-name').textContent = nama;
        document.getElementById('modal-location-address').textContent = alamat;
        document.getElementById('modal-coordinator').textContent = koordinator;
        document.getElementById('modal-coordinator-contact').textContent = kontak;
        document.getElementById('modal-location-description').textContent = deskripsi;

        // Update status class
        const statusElement = document.getElementById('modal-location-status');
        statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);

        // Remove all classes first
        statusElement.className = 'px-2 py-1 text-xs font-medium rounded-full';

        // Add class based on status
        if (status === 'tersedia') {
          statusElement.classList.add('bg-green-100', 'dark:bg-green-900', 'text-green-800', 'dark:text-green-300');
        } else if (status === 'terbatas') {
          statusElement.classList.add('bg-yellow-100', 'dark:bg-yellow-900', 'text-yellow-800', 'dark:text-yellow-300');
        } else {
          statusElement.classList.add('bg-red-100', 'dark:bg-red-900', 'text-red-800', 'dark:text-red-300');
        }

        // Update form action
        document.getElementById('select-location-form').action = "{{ url('lokasi') }}/" + id + "/select";

        // Reset semua kuota fakultas ke 0/0
        const fakultasEls = document.querySelectorAll('[id^="quota-faculty-"]');
        fakultasEls.forEach(el => {
          el.textContent = "0/0";
        });

        const fakultasBarEls = document.querySelectorAll('[id^="quota-bar-faculty-"]');
        fakultasBarEls.forEach(el => {
          el.style.width = "0%";
        });

        // Reset daftar mahasiswa
        document.getElementById('modal-student-list').innerHTML = `
          <tr>
            <td colspan="3" class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 text-center">Memuat data...</td>
          </tr>
        `;

        // Fetch kuota fakultas dan mahasiswa terdaftar
        fetch('{{ url("lokasi") }}/' + id + '/detail')
          .then(response => response.json())
          .then(data => {
            console.log("Data from server:", data); // Debug log

            // Fill kuota fakultas
            if (data.kuota_fakultas && data.kuota_fakultas.length > 0) {
              data.kuota_fakultas.forEach(kuota => {
                const quotaElement = document.getElementById('quota-faculty-' + kuota.fakultas_id);
                const barElement = document.getElementById('quota-bar-faculty-' + kuota.fakultas_id);

                if (quotaElement && barElement) {
                  quotaElement.textContent = kuota.terisi + '/' + kuota.kuota;
                  barElement.style.width = (kuota.terisi / kuota.kuota * 100) + '%';
                }
              });
            }

            // Fill student list
            const studentListContainer = document.getElementById('modal-student-list');
            const studentCountSpan = document.getElementById('modal-student-count');
            studentListContainer.innerHTML = '';

            if (data.mahasiswa && data.mahasiswa.length > 0) {
              studentCountSpan.textContent = '(' + data.mahasiswa.length + '/' + data.lokasi.kuota_total + ')';

              data.mahasiswa.forEach(mhs => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">${mhs.nama_lengkap}</td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">${mhs.nim}</td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">${mhs.fakultas_nama}</td>
                `;
                studentListContainer.appendChild(tr);
              });
            } else {
              studentCountSpan.textContent = '(0/' + data.lokasi.kuota_total + ')';
              const tr = document.createElement('tr');
              tr.innerHTML = `
                <td colspan="3" class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 text-center">Belum ada mahasiswa yang terdaftar</td>
              `;
              studentListContainer.appendChild(tr);
            }
          })
          .catch(error => {
            console.error('Error fetching location details:', error);

            // Show error message in student list
            const studentListContainer = document.getElementById('modal-student-list');
            studentListContainer.innerHTML = `
              <tr>
                <td colspan="3" class="px-4 py-3 text-sm text-red-500 text-center">
                  Terjadi kesalahan saat memuat data
                </td>
              </tr>
            `;
          });

        // Show modal
        locationDetailModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
      });
    });

    // Close modal when clicking the close button
    if (closeModalBtn) {
      closeModalBtn.addEventListener('click', function() {
        locationDetailModal.classList.add('hidden');
        document.body.style.overflow = ''; // Re-enable scrolling
      });
    }

    // Close modal when clicking outside the modal content
    locationDetailModal?.addEventListener('click', function(e) {
      if (e.target === locationDetailModal) {
        locationDetailModal.classList.add('hidden');
        document.body.style.overflow = '';
      }
    });
  });
</script>
@endsection