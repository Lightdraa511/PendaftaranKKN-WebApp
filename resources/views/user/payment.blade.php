@extends('layouts.app')

@section('title', 'Pembayaran KKNM - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-4 sm:space-y-6">
  <div class="card w-full p-3 sm:p-5">
    <div class="flex items-center mb-3 sm:mb-4">
      <i class="fas fa-credit-card w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400 mr-2"></i>
      <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Pembayaran KKNM</h2>

      @if($user->status_pembayaran == 'lunas')
      <span class="ml-auto px-3 py-1 text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
        Pembayaran Telah Lunas
      </span>
      @endif
    </div>

    <div class="mb-4 sm:mb-5">
      <h3 class="text-sm sm:text-base font-medium text-gray-900 dark:text-white mb-2 sm:mb-3 pb-1.5 sm:pb-2 border-b border-gray-200 dark:border-gray-700">
        Rincian Biaya
      </h3>

      <div class="space-y-2 text-xs sm:text-sm">
        <div class="flex justify-between items-center py-1">
          <span class="text-gray-700 dark:text-gray-300">Biaya Pendaftaran KKNM</span>
          <span class="font-medium text-gray-900 dark:text-white">Rp{{ number_format($pengaturan->biaya_pendaftaran, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between items-center py-1">
          <span class="text-gray-700 dark:text-gray-300">Biaya Administrasi</span>
          <span class="font-medium text-gray-900 dark:text-white">Rp{{ number_format($pengaturan->biaya_administrasi, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between items-center pt-1.5 sm:pt-2 border-t border-gray-200 dark:border-gray-700 py-1">
          <span class="font-medium text-gray-900 dark:text-white">Total Pembayaran</span>
          <span class="font-medium text-gray-900 dark:text-white">Rp{{ number_format($pengaturan->biaya_pendaftaran + $pengaturan->biaya_administrasi, 0, ',', '.') }}</span>
        </div>
      </div>
    </div>

    <div class="card w-full p-3 sm:p-5">
      <h3 class="text-sm sm:text-base font-medium text-gray-900 dark:text-white mb-2 sm:mb-3">Metode Pembayaran</h3>

      <div class="border dark:border-gray-700 rounded-lg p-4 sm:p-6 bg-white dark:bg-gray-800 text-center">
        <div class="mb-4">
          <img src="https://nurosoft.id/blog/wp-content/uploads/2024/06/Midtrans.webp" alt="Midtrans Logo" class="h-10 mx-auto mb-3">
          <h4 class="text-sm sm:text-base font-medium dark:text-white mb-2">Pembayaran dengan Midtrans</h4>
          <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-4">
            Nikmati berbagai pilihan metode pembayaran aman dan mudah melalui Midtrans.
            <br>Transfer Bank, QRIS, E-Wallet, Kartu Kredit dan metode lainnya tersedia.
          </p>
        </div>

        <div class="flex flex-wrap justify-center gap-2 mb-4">
          <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/200px-BNI_logo.svg.png" alt="BNI" class="h-5">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/200px-BANK_BRI_logo.svg.png" alt="BRI" class="h-5">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/200px-Bank_Mandiri_logo_2016.svg.png" alt="Mandiri" class="h-5">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/200px-Gopay_logo.svg.png" alt="Gopay" class="h-5">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/200px-Logo_ovo_purple.svg.png" alt="OVO" class="h-5">
        </div>

        @if($user->status_pembayaran == 'belum')
          <form action="{{ route('pembayaran.process') }}" method="POST">
            @csrf
            <button type="submit" id="pay-button" class="btn btn-primary py-3 px-6">
              <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
            </button>
          </form>
        @else
          <button type="button" disabled class="btn bg-green-600 hover:bg-green-700 text-white py-3 px-6 cursor-not-allowed">
            <i class="fas fa-check-circle mr-2"></i> Pembayaran Telah Lunas
          </button>
        @endif
      </div>
    </div>
  </div>

  <!-- Pada tampilan mobile, kompak -->
  <div class="block sm:hidden card w-full p-3">
    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Riwayat Pembayaran</h3>

    @if($riwayatPembayaran->isEmpty())
      <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-3">
        Belum ada riwayat pembayaran
      </div>
    @else
      @foreach($riwayatPembayaran as $pembayaran)
        <div class="space-y-1.5 text-xs">
          <div class="flex justify-between py-0.5">
            <span class="text-gray-500 dark:text-gray-400">ID:</span>
            <span class="font-medium text-right text-gray-900 dark:text-white">{{ $pembayaran->id_pembayaran }}</span>
          </div>
          <div class="flex justify-between py-0.5">
            <span class="text-gray-500 dark:text-gray-400">Tanggal:</span>
            <span class="text-right text-gray-900 dark:text-white">
              @if($user->status_pembayaran == 'lunas')
                {{ now()->format('d/m/Y') }}
              @else
                {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y') : 'Belum dibayar' }}
              @endif
            </span>
          </div>
          <div class="flex justify-between py-0.5">
            <span class="text-gray-500 dark:text-gray-400">Jumlah:</span>
            <span class="text-right text-gray-900 dark:text-white">Rp{{ number_format($pembayaran->total_pembayaran, 0, ',', '.') }}</span>
          </div>
          <div class="flex justify-between py-0.5">
            <span class="text-gray-500 dark:text-gray-400">Status:</span>
            @if($user->status_pembayaran == 'lunas')
              <span class="px-1.5 py-0.5 text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
                Sukses
              </span>
            @else
              <span class="px-1.5 py-0.5 text-xs
                {{ $pembayaran->status == 'sukses' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                  ($pembayaran->status == 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' :
                  'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') }} rounded-full">
                {{ ucfirst($pembayaran->status) }}
              </span>
            @endif
          </div>
        </div>
      @endforeach
    @endif
  </div>

  <!-- Tampilkan tabel pada layar yang lebih besar -->
  <div class="hidden sm:block card w-full p-3 sm:p-5">
    <h3 class="text-sm sm:text-base font-medium text-gray-900 dark:text-white mb-2 sm:mb-3">Riwayat Pembayaran</h3>

    @if($riwayatPembayaran->isEmpty())
      <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-3">
        Belum ada riwayat pembayaran
      </div>
    @else
      <div class="overflow-x-auto -mx-3 sm:-mx-5">
        <div class="inline-block min-w-full align-middle">
          <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th scope="col" class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-medium text-xs sm:text-sm text-gray-500 dark:text-gray-400">ID Pembayaran</th>
                <th scope="col" class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-medium text-xs sm:text-sm text-gray-500 dark:text-gray-400">Tanggal</th>
                <th scope="col" class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-medium text-xs sm:text-sm text-gray-500 dark:text-gray-400">Jumlah</th>
                <th scope="col" class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-medium text-xs sm:text-sm text-gray-500 dark:text-gray-400">Metode</th>
                <th scope="col" class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-medium text-xs sm:text-sm text-gray-500 dark:text-gray-400">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($riwayatPembayaran as $pembayaran)
                <tr>
                  <td>{{ $pembayaran->id_pembayaran }}</td>
                  <td>
                    @if($user->status_pembayaran == 'lunas')
                      {{ now()->format('d/m/Y') }}
                    @else
                      {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y') : 'Belum dibayar' }}
                    @endif
                  </td>
                  <td>Rp{{ number_format($pembayaran->total_pembayaran, 0, ',', '.') }}</td>
                  <td>
                    @if($user->status_pembayaran == 'lunas')
                      {{ $pembayaran->midtrans_payment_type ? ucfirst(str_replace('_', ' ', $pembayaran->midtrans_payment_type)) : 'Bank Transfer' }}
                    @else
                      {{ $pembayaran->midtrans_payment_type ? ucfirst(str_replace('_', ' ', $pembayaran->midtrans_payment_type)) : '-' }}
                    @endif
                  </td>
                  <td>
                    @if($user->status_pembayaran == 'lunas')
                    <span class="px-2 py-1 text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
                      Sukses
                    </span>
                    @else
                    <span class="px-2 py-1 text-xs
                      {{ $pembayaran->status == 'sukses' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                        ($pembayaran->status == 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' :
                        'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') }} rounded-full">
                      {{ ucfirst($pembayaran->status) }}
                    </span>
                    @endif

                    @if($pembayaran->status == 'pending' && $user->status_pembayaran != 'lunas')
                    <a href="{{ route('pembayaran.check_status', $pembayaran->id) }}" class="ml-2 text-xs text-blue-600 dark:text-blue-400 hover:underline">
                      Cek Status
                    </a>
                    @endif
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection

@section('scripts')
<!-- Midtrans JS SDK -->
<script type="text/javascript" src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
  // Untuk halaman pembayaran-process
  @if(isset($snapToken))
    window.onload = function() {
      snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
          window.location.href = '{{ route('pembayaran.index') }}?status=success';
        },
        onPending: function(result) {
          window.location.href = '{{ route('pembayaran.index') }}?status=pending';
        },
        onError: function(result) {
          window.location.href = '{{ route('pembayaran.index') }}?status=error';
        },
        onClose: function() {
          window.location.href = '{{ route('pembayaran.index') }}?status=close';
        }
      });
    };
  @endif

  // Check status pembayaran jika parameter status ada
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
      alert('Pembayaran berhasil!');
    } else if (status === 'pending') {
      alert('Pembayaran sedang diproses. Silakan cek status pembayaran Anda nanti.');
    } else if (status === 'error') {
      alert('Pembayaran gagal. Silakan coba lagi.');
    } else if (status === 'close') {
      alert('Anda menutup jendela pembayaran sebelum menyelesaikan pembayaran.');
    }
  });
</script>
@endsection
