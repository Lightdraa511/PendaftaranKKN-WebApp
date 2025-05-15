@extends('layouts.app')

@section('title', 'Proses Pembayaran - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-6">
  <div class="card w-full p-5 text-center">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Proses Pembayaran</h2>

    <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg text-left">
      <div class="flex">
        <div class="flex-shrink-0">
          <i class="fas fa-info-circle w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5"></i>
        </div>
        <div class="ml-3">
          <p class="text-sm text-blue-700 dark:text-blue-300">
            Silakan selesaikan pembayaran Anda menggunakan metode pembayaran yang tersedia. Jangan tutup halaman ini sebelum pembayaran selesai.
          </p>
        </div>
      </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Pembayaran</h3>

      <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
        <span class="text-gray-700 dark:text-gray-300">ID Pembayaran</span>
        <span class="font-medium text-gray-900 dark:text-white">{{ $pembayaran->id_pembayaran }}</span>
      </div>

      <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
        <span class="text-gray-700 dark:text-gray-300">Total Pembayaran</span>
        <span class="font-medium text-gray-900 dark:text-white">Rp{{ number_format($pembayaran->total_pembayaran, 0, ',', '.') }}</span>
      </div>

      <div class="flex justify-between items-center py-2">
        <span class="text-gray-700 dark:text-gray-300">Status</span>
        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 rounded-full">
          Menunggu Pembayaran
        </span>
      </div>
    </div>

    <button id="pay-button" class="btn btn-primary py-3 px-6 mx-auto">
      <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
    </button>

    <div class="mt-4">
      <a href="{{ route('pembayaran.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke halaman pembayaran
      </a>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- Midtrans JS SDK -->
<script type="text/javascript" src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Untuk halaman pembayaran-process
    const payButton = document.getElementById('pay-button');

    if (payButton) {
      payButton.addEventListener('click', function() {
        // Tampilkan popup Midtrans Snap
        snap.pay('{{ $pembayaran->midtrans_snap_token }}', {
          onSuccess: function(result) {
            // Redirect ke halaman finish dengan parameter order_id
            window.location.href = '{{ route('pembayaran.finish') }}?order_id={{ $pembayaran->id_pembayaran }}&status=success';
          },
          onPending: function(result) {
            window.location.href = '{{ route('pembayaran.finish') }}?order_id={{ $pembayaran->id_pembayaran }}&status=pending';
          },
          onError: function(result) {
            window.location.href = '{{ route('pembayaran.finish') }}?order_id={{ $pembayaran->id_pembayaran }}&status=error';
          },
          onClose: function() {
            window.location.href = '{{ route('pembayaran.index') }}?status=close';
          }
        });
      });

      // Otomatis klik tombol bayar setelah 1 detik
      setTimeout(function() {
        payButton.click();
      }, 1000);
    }
  });
</script>
@endsection
