<!-- Sidebar -->
<aside
  id="sidebar"
  class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 lg:translate-x-0"
  aria-label="Sidebar"
>
  <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
    <div id="close-sidebar" class="lg:hidden absolute right-2 top-2 p-1">
      <button class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
        <i class="fas fa-times w-5 h-5"></i>
      </button>
    </div>

    <ul class="space-y-2 font-medium mt-2">
      <li>
        <a
          href="{{ route('dashboard') }}"
          class="flex items-center p-2 text-gray-900 dark:text-white rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
        >
          <i class="fas fa-home w-5 h-5"></i>
          <span class="ml-3">Dashboard</span>
        </a>
      </li>

      <li>
        <a
          href="{{ route('profile.index') }}"
          class="flex items-center p-2 text-gray-900 dark:text-white rounded-lg {{ request()->routeIs('profile.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
        >
          <i class="fas fa-user w-5 h-5"></i>
          <span class="ml-3">Profil Saya</span>
        </a>
      </li>

      <li>
        <a
          href="{{ route('pembayaran.index') }}"
          class="flex items-center p-2 text-gray-900 dark:text-white rounded-lg {{ request()->routeIs('pembayaran.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
        >
          <i class="fas fa-credit-card w-5 h-5"></i>
          <span class="ml-3">Pembayaran</span>
        </a>
      </li>

      <li>
        <a
          href="{{ route('lokasi.index') }}"
          class="flex items-center p-2 text-gray-900 dark:text-white rounded-lg {{ request()->routeIs('lokasi.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
        >
          <i class="fas fa-map-marker-alt w-5 h-5"></i>
          <span class="ml-3">Lokasi KKNM</span>
        </a>
      </li>

      <li>
        <a
          href="{{ route('pendaftaran.index') }}"
          class="flex items-center p-2 text-gray-900 dark:text-white rounded-lg {{ request()->routeIs('pendaftaran.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
        >
          <i class="fas fa-file-alt w-5 h-5"></i>
          <span class="ml-3">Pendaftaran KKNM</span>
        </a>
      </li>

      <li class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
        <a
          href="{{ route('help') }}"
          class="flex items-center p-2 text-gray-900 dark:text-white rounded-lg {{ request()->routeIs('help') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"
        >
          <i class="fas fa-question-circle w-5 h-5"></i>
          <span class="ml-3">Bantuan</span>
        </a>
      </li>
    </ul>

    <div class="mt-6 p-3 {{ Auth::user()->status_pembayaran === 'lunas' ? 'bg-green-50 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800' : 'bg-yellow-50 dark:bg-yellow-900/30 rounded-lg border border-yellow-200 dark:border-yellow-800' }}">
      <p class="text-sm {{ Auth::user()->status_pembayaran === 'lunas' ? 'text-green-800 dark:text-green-200' : 'text-yellow-800 dark:text-yellow-200' }} flex items-center">
        <span class="w-2 h-2 {{ Auth::user()->status_pembayaran === 'lunas' ? 'bg-green-500' : 'bg-yellow-500' }} rounded-full mr-2"></span>
        Status Pembayaran: {{ Auth::user()->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas' }}
      </p>
    </div>
  </div>
</aside>