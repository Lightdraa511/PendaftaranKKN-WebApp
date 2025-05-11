@extends('layouts.app')

@section('title', 'Proses Pembayaran - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-6">
  <div class="card w-full">
    <div class="flex items-center mb-6">
      <i class="fas fa-credit-card w-6 h-6 text-blue-600 dark:text-blue-400 mr-2"></i>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Proses Pembayaran</h2>
    </div>

    <div class="text-center p-6">
      <div class="mb-6">
        <i class="fas fa-spinner fa-spin text-blue-600 dark:text-blue-400 text-5xl mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Memproses Pembayaran</h3>
        <p class="text-gray-600 dark:text-gray-300">
          Mohon tunggu sebentar, Anda akan dialihkan ke halaman pembayaran Midtrans...
        </p>
      </div>

      <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg mb-6">
        <div class="text-left mb-4">
          <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Detail Pembayaran:</h4>
          <div class="space-y-1">
            <div class="flex justify-between text-sm">
              <span class="text-gray-600 dark:text-gray-400">ID Pembayaran:</span>
              <span class="font-medium text-gray-900 dark:text-white">{{ $pembayaran->id_pembayaran }}</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-600 dark:text-gray-400">Total Pembayaran:</span>
              <span class="font-medium text-gray-900 dark:text-white">Rp{{ number_format($pembayaran->total_pembayaran, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>
      </div>

      <p class="text-sm text-gray-500 dark:text-gray-400">
        Jika Anda tidak dialihkan secara otomatis dalam beberapa detik, silakan klik tombol di bawah.
      </p>

      <button type="button" id="pay-button" class="btn btn-primary mt-4">
        <i class="fas fa-external-link-alt mr-2"></i> Lanjutkan ke Pembayaran
      </button>

      <div class="mt-4">
        <a href="{{ route('pembayaran.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
          <i class="fas fa-arrow-left mr-1"></i> Kembali ke halaman pembayaran
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- Midtrans JS SDK -->
<script type="text/javascript" src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Tampilkan Snap popup
    setTimeout(function() {
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
    }, 1000);

    // Tombol untuk membuka popup secara manual
    document.getElementById('pay-button').addEventListener('click', function() {
      snap.pay('{{ $snapToken }}');
    });
  });
</script>
@endsection