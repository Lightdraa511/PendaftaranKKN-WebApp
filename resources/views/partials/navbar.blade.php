<!-- Navbar -->
<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 fixed z-30 w-full">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          @auth
            <button
              id="toggle-sidebar-button"
              class="lg:hidden mr-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
            >
              <i class="fas fa-bars w-6 h-6"></i>
            </button>
          @endauth
          <a href="{{ route('landing') }}" id="logo-link" class="flex items-center">
            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-blue-600 dark:text-blue-400">
              KKNM App
            </span>
          </a>
        </div>

        <div class="flex items-center gap-3">
          <!-- Theme Toggle Button -->
          <button id="theme-toggle" class="theme-toggle" aria-label="Toggle Dark Mode">
            <i class="fas fa-moon w-5 h-5 dark:hidden"></i>
            <i class="fas fa-sun w-5 h-5 hidden dark:block"></i>
          </button>

          <!-- User is logged in view -->
          @auth
            <div class="flex items-center gap-3">
              <button class="relative p-1 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-bell w-6 h-6"></i>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">
                  2
                </span>
              </button>

              <div class="flex items-center">
                <div class="hidden md:flex flex-col mr-3 text-right">
                  <span class="text-sm font-medium text-gray-900 dark:text-white" id="user-name">
                    {{ Auth::user()->nama_lengkap }}
                  </span>
                  <span class="text-xs text-gray-500 dark:text-gray-400" id="user-email">
                    {{ Auth::user()->nim }}
                  </span>
                </div>
                <div class="relative">
                  <div class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300">
                    @if(Auth::user()->foto_profil)
                      <img src="{{ asset('storage/profile_photos/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->nama_lengkap }}" class="w-8 h-8 rounded-full">
                    @else
                      <i class="fas fa-user-circle w-8 h-8 text-gray-300"></i>
                    @endif
                  </div>
                </div>
              </div>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
              </form>
              <button
                id="logout-button"
                class="flex items-center text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors"
              >
                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                <span class="ml-1 text-sm hidden md:inline">Keluar</span>
              </button>
            </div>
          @else
            <!-- User is not logged in view -->
            <div>
              <a
                href="{{ route('login') }}"
                class="py-2 px-3 text-sm font-medium text-gray-900 dark:text-white rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 mr-2"
              >
                Masuk
              </a>
              <a
                href="{{ route('register') }}"
                class="py-2 px-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
              >
                Daftar
              </a>
            </div>
          @endauth
        </div>
      </div>
    </div>
  </nav>