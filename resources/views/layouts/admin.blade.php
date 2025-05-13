<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Sistem Pendaftaran KKNM</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js for Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        indigo: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Base Styles */
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        /* Dark Mode Toggle */
        .theme-toggle {
            background-color: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.375rem;
            color: #4b5563;
        }
        .dark .theme-toggle {
            color: #e5e7eb;
        }
        .theme-toggle:hover {
            background-color: #f3f4f6;
        }
        .dark .theme-toggle:hover {
            background-color: #374151;
        }

        /* Sidebar Styles */
        .active-nav-link {
            color: #4F46E5;
            border-left: 4px solid #4F46E5;
            background-color: #EEF2FF;
        }
        .dark .active-nav-link {
            color: #818cf8;
            border-left: 4px solid #818cf8;
            background-color: #1e1b4b;
        }
        .nav-link:hover {
            background-color: #EEF2FF;
        }
        .dark .nav-link:hover {
            background-color: #1e1b4b;
        }

        /* Dark Mode Styles */
        .dark body {
            background-color: #111827;
            color: #f9fafb;
        }
        .dark .bg-white {
            background-color: #1f2937;
        }
        .dark .bg-gray-50, .dark .bg-gray-100 {
            background-color: #111827;
        }
        .dark .text-gray-500 {
            color: #9ca3af;
        }
        .dark .text-gray-600 {
            color: #d1d5db;
        }
        .dark .text-gray-700 {
            color: #e5e7eb;
        }
        .dark .text-gray-800 {
            color: #f3f4f6;
        }
        .dark .text-gray-900 {
            color: #f9fafb;
        }
        .dark .border-gray-200, .dark .border-r, .dark .border-b, .dark .border-t {
            border-color: #374151;
        }
        .dark .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
        }
        .dark .ring-black {
            --tw-ring-color: #000;
        }

        /* Dark Mode Card Styles */
        .dark .bg-green-100 {
            background-color: rgba(6, 78, 59, 0.5);
        }
        .dark .bg-emerald-100 {
            background-color: rgba(6, 78, 59, 0.5);
        }
        .dark .bg-amber-100 {
            background-color: rgba(120, 53, 15, 0.5);
        }
        .dark .bg-red-100 {
            background-color: rgba(127, 29, 29, 0.5);
        }
        .dark .bg-indigo-100 {
            background-color: rgba(49, 46, 129, 0.5);
        }
    </style>

    @yield('styles')
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white dark:bg-gray-800 border-r dark:border-gray-700">
                <!-- Sidebar Header -->
                <div class="h-16 flex items-center justify-center border-b dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Admin KKNM</h2>
                </div>

                <!-- Sidebar Content -->
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                 {{ request()->routeIs('admin.dashboard') ? 'active-nav-link' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-500 dark:text-gray-400"></i>
                            Dashboard
                        </a>

                        <!-- Mahasiswa -->
                        <a href="{{ route('admin.mahasiswa.index') }}"
                           class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                 {{ request()->routeIs('admin.mahasiswa.*') ? 'active-nav-link' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-users mr-3 text-gray-500 dark:text-gray-400"></i>
                            Mahasiswa
                        </a>

                        <!-- Lokasi KKN -->
                        <a href="{{ route('admin.lokasi.index') }}"
                           class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                 {{ request()->routeIs('admin.lokasi.*') ? 'active-nav-link' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-map-marker-alt mr-3 text-gray-500 dark:text-gray-400"></i>
                            Lokasi KKN
                        </a>

                        <!-- Pendaftaran -->
                        <a href="#"
                           class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-clipboard-list mr-3 text-gray-500 dark:text-gray-400"></i>
                            Pendaftaran
                        </a>

                        <!-- Pembayaran -->
                        <a href="{{ route('admin.payment.index') }}"
                           class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                 {{ request()->routeIs('admin.payment.*') ? 'active-nav-link' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-money-bill-wave mr-3 text-gray-500 dark:text-gray-400"></i>
                            Pembayaran
                        </a>

                        <!-- Fakultas & Prodi -->
                        <a href="#"
                           class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-university mr-3 text-gray-500 dark:text-gray-400"></i>
                            Fakultas & Prodi
                        </a>

                        <!-- Pengaturan -->
                        <a href="#"
                           class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-cog mr-3 text-gray-500 dark:text-gray-400"></i>
                            Pengaturan
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow dark:shadow-gray-700">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left side -->
                        <div class="flex">
                            <button class="md:hidden px-4 text-gray-500 dark:text-gray-300 focus:outline-none" id="mobile-menu-button">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="flex-shrink-0 flex items-center">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">@yield('page-title', 'Dashboard')</h2>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center">
                            <!-- Theme Toggle -->
                            <button id="theme-toggle" class="theme-toggle mr-3" aria-label="Toggle Dark Mode">
                                <i class="fas fa-moon w-5 h-5 dark:hidden"></i>
                                <i class="fas fa-sun w-5 h-5 hidden dark:block"></i>
                            </button>

                            <!-- Notification -->
                            <button class="p-2 rounded-full text-gray-500 dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                                <i class="fas fa-bell"></i>
                            </button>

                            <!-- Profile Dropdown -->
                            <div class="ml-3 relative">
                                <div class="flex items-center">
                                    <span class="hidden md:inline-block mr-2 text-sm text-gray-700 dark:text-gray-300">{{ auth()->guard('admin')->user()->nama ?? 'Admin' }}</span>
                                    <button class="flex text-sm rounded-full focus:outline-none" id="profile-menu-button">
                                        <span class="sr-only">Buka menu pengguna</span>
                                        <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600 dark:text-gray-300"></i>
                                        </div>
                                    </button>
                                </div>

                                <!-- Dropdown menu -->
                                <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none" id="profile-dropdown">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Profil</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Pengaturan</a>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Mobile Menu (Hidden by default) -->
            <div class="md:hidden hidden bg-white dark:bg-gray-800 border-b dark:border-gray-700" id="mobile-menu">
                <nav class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Dashboard</a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.mahasiswa.*') ? 'text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Mahasiswa</a>
                    <a href="{{ route('admin.lokasi.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.lokasi.*') ? 'text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Lokasi KKN</a>
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Pendaftaran</a>
                    <a href="{{ route('admin.payment.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.payment.*') ? 'text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Pembayaran</a>
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Fakultas & Prodi</a>
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Pengaturan</a>
                </nav>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-100 dark:bg-gray-900">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.toggle('hidden');
            });

            // Profile dropdown toggle
            document.getElementById('profile-menu-button').addEventListener('click', function() {
                const profileDropdown = document.getElementById('profile-dropdown');
                profileDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const profileButton = document.getElementById('profile-menu-button');
                const profileDropdown = document.getElementById('profile-dropdown');

                if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // Theme Toggle functionality
            const themeToggleBtn = document.getElementById('theme-toggle');

            // Check for saved theme preference or use the system preference
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme === 'dark' ||
                (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            // Toggle theme
            themeToggleBtn.addEventListener('click', function() {
                let isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
