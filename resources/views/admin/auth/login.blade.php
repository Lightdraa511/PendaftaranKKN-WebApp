<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - Sistem Pendaftaran KKNM</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #f3f4f6;
        }
        .dark body {
            background-color: #111827;
            color: #f9fafb;
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

        /* Dark mode specific styles */
        .dark .bg-white {
            background-color: #1f2937;
        }
        .dark .bg-gray-50 {
            background-color: #111827;
        }
        .dark .bg-gray-100 {
            background-color: #1f2937;
        }
        .dark .border-gray-300 {
            border-color: #374151;
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
        .dark .text-gray-900 {
            color: #f9fafb;
        }
        .dark .hover\:bg-gray-50:hover {
            background-color: #374151;
        }

        /* Input styles for dark mode */
        .dark input[type="text"],
        .dark input[type="email"],
        .dark input[type="password"],
        .dark textarea,
        .dark select {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }

        /* Input styles for light mode */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        .dark input::placeholder {
            color: #9ca3af;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <a href="{{ route('landing') }}" class="flex items-center">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-indigo-600 dark:text-indigo-400">
                        Admin KKNM
                    </span>
                </a>

                <button id="theme-toggle" class="theme-toggle" aria-label="Toggle Dark Mode">
                    <i class="fas fa-moon w-5 h-5 dark:hidden"></i>
                    <i class="fas fa-sun w-5 h-5 hidden dark:block"></i>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col justify-center">
            <div class="container mx-auto px-4 py-8">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded mx-auto max-w-md" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded mx-auto max-w-md" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded mx-auto max-w-md" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <div class="flex min-h-full flex-col justify-center pb-12">
                    <div class="mx-auto w-full max-w-md">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                Admin Login
                            </h2>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                Silakan masuk untuk mengakses panel admin KKNM
                            </p>
                        </div>

                        <div class="mt-8 bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
                            <form class="space-y-6" action="{{ route('admin.login') }}" method="POST">
                                @csrf

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Email
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            id="email"
                                            name="email"
                                            type="email"
                                            required
                                            class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Masukkan email admin"
                                            value="{{ old('email') }}"
                                        />
                                    </div>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Password
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            autocomplete="current-password"
                                            required
                                            class="w-full p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                        />
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input
                                            id="remember"
                                            name="remember"
                                            type="checkbox"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                                        />
                                        <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Ingat saya
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <button
                                        type="submit"
                                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Masuk
                                    </button>
                                </div>
                            </form>

                            <div class="mt-6">
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Atau masuk sebagai</span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <a href="{{ route('login') }}"
                                        class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        <i class="fas fa-user mr-2 text-indigo-600 dark:text-indigo-400"></i>
                                        Mahasiswa
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                <a href="/" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    <i class="fas fa-home mr-1"></i> Kembali ke Beranda
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 py-6 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <div class="text-center md:text-left mb-4 md:mb-0">
                        <p class="text-sm text-gray-600 dark:text-gray-300">© 2025 Aplikasi Pendaftaran KKNM. Hak Cipta Dilindungi.</p>
                    </div>
                    <div class="flex justify-center md:justify-end space-x-6">
                        <a href="#" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Kebijakan Privasi</a>
                        <a href="#" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Syarat & Ketentuan</a>
                        <a href="#" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Kontak</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
</body>
</html>
