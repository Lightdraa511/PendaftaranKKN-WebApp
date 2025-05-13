@extends('layouts.app')

@section('title', 'Bantuan - Sistem Pendaftaran KKNM')

@section('content')
<div class="space-y-6">
  <div class="card">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
      <i class="fas fa-question-circle w-6 h-6 text-blue-600 dark:text-blue-400 mr-2"></i>
      Bantuan
    </h2>

    <div class="mb-8">
      <p class="text-gray-600 dark:text-gray-300 mb-6">
        Selamat datang di pusat bantuan Sistem Pendaftaran KKNM. Halaman ini berisi panduan dan informasi tentang berbagai fitur dan proses dalam sistem.
      </p>
    </div>

    <div class="mb-8">
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Pertanyaan Umum (FAQ)</h3>

      <div class="space-y-4">
        <div class="border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 faq-item">
          <button class="flex w-full justify-between items-center px-4 py-3 text-left" onclick="toggleFAQ(this)">
            <span class="font-medium text-gray-900 dark:text-white">Apa itu KKNM?</span>
            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 faq-toggle-icon"></i>
          </button>
          <div class="px-4 pb-4 faq-content">
            <p class="text-gray-600 dark:text-gray-300">
              KKNM (Kuliah Kerja Nyata Mahasiswa) adalah program pengabdian kepada masyarakat yang dilakukan oleh mahasiswa sebagai bagian dari Tri Dharma Perguruan Tinggi. Program ini memungkinkan mahasiswa untuk menerapkan ilmu yang telah dipelajari di perguruan tinggi untuk membantu memecahkan masalah dan mendorong pembangunan di masyarakat.
            </p>
          </div>
        </div>

        <div class="border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 faq-item">
          <button class="flex w-full justify-between items-center px-4 py-3 text-left" onclick="toggleFAQ(this)">
            <span class="font-medium text-gray-900 dark:text-white">Siapa yang wajib mengikuti KKNM?</span>
            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 faq-toggle-icon"></i>
          </button>
          <div class="px-4 pb-4 faq-content">
            <p class="text-gray-600 dark:text-gray-300">
              KKNM wajib diikuti oleh seluruh mahasiswa jenjang S1 yang telah memenuhi persyaratan akademik, yaitu telah menyelesaikan minimal 100 SKS dan IPK minimal 2.00. Persyaratan lebih detail dapat dilihat pada pedoman KKNM yang berlaku.
            </p>
          </div>
        </div>

        <div class="border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 faq-item">
          <button class="flex w-full justify-between items-center px-4 py-3 text-left" onclick="toggleFAQ(this)">
            <span class="font-medium text-gray-900 dark:text-white">Berapa lama pelaksanaan KKNM?</span>
            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 faq-toggle-icon"></i>
          </button>
          <div class="px-4 pb-4 faq-content">
            <p class="text-gray-600 dark:text-gray-300">
              Pelaksanaan KKNM berlangsung selama 2 bulan (8 minggu) di lokasi yang telah ditentukan. Sebelum pelaksanaan, mahasiswa akan mengikuti pembekalan selama 2 minggu. Total program KKNM termasuk pembekalan dan pelaporan hasil adalah kurang lebih 3 bulan.
            </p>
          </div>
        </div>

        <div class="border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 faq-item">
          <button class="flex w-full justify-between items-center px-4 py-3 text-left" onclick="toggleFAQ(this)">
            <span class="font-medium text-gray-900 dark:text-white">Bagaimana cara memilih lokasi KKNM?</span>
            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 faq-toggle-icon"></i>
          </button>
          <div class="px-4 pb-4 faq-content">
            <p class="text-gray-600 dark:text-gray-300">
              Setelah melakukan pembayaran dan mengisi formulir pendaftaran, mahasiswa dapat memilih lokasi KKNM yang tersedia sesuai kuota yang ada. Pemilihan lokasi dilakukan secara online melalui sistem pendaftaran ini. Mahasiswa dapat memilih 3 lokasi sebagai prioritas pilihan.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-6 flex flex-col md:flex-row items-center justify-between">
      <div class="mb-4 md:mb-0 md:mr-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Masih memiliki pertanyaan?</h3>
        <p class="text-gray-600 dark:text-gray-300">
          Jika Anda tidak menemukan jawaban untuk pertanyaan Anda, silakan hubungi tim dukungan kami.
        </p>
      </div>
      <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
        <a href="mailto:kknm@university.ac.id" class="btn bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
          <i class="fas fa-envelope mr-1"></i> Email
        </a>
        <a href="https://wa.me/628123456789" target="_blank" class="btn btn-primary">
          <i class="fab fa-whatsapp mr-1"></i> WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // FAQ Toggle functionality
  function toggleFAQ(element) {
    const faqItem = element.closest('.faq-item');
    faqItem.classList.toggle('active');

    const faqContent = faqItem.querySelector('.faq-content');
    const faqToggleIcon = faqItem.querySelector('.faq-toggle-icon');

    if (faqItem.classList.contains('active')) {
      faqContent.style.maxHeight = faqContent.scrollHeight + 'px';
      faqToggleIcon.style.transform = 'rotate(180deg)';
    } else {
      faqContent.style.maxHeight = '0px';
      faqToggleIcon.style.transform = 'rotate(0)';
    }
  }

  // Initialize FAQ items
  document.addEventListener('DOMContentLoaded', function() {
    const faqContents = document.querySelectorAll('.faq-content');
    faqContents.forEach(content => {
      content.style.maxHeight = '0px';
      content.style.overflow = 'hidden';
      content.style.transition = 'max-height 0.3s ease';
    });

    const faqToggleIcons = document.querySelectorAll('.faq-toggle-icon');
    faqToggleIcons.forEach(icon => {
      icon.style.transition = 'transform 0.2s ease';
    });
  });
</script>
@endsection

@section('styles')
<style>
  /* FAQ Toggle */
  .faq-toggle-icon {
    transition: transform 0.2s ease;
  }
  .faq-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }
  .faq-item.active .faq-toggle-icon {
    transform: rotate(180deg);
  }
  .faq-item.active .faq-content {
    max-height: 1000px;
  }
</style>
@endsection