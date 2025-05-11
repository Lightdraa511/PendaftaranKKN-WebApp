<!DOCTYPE html>
<html lang="id" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Sistem Pendaftaran KKNM')</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Custom Tailwind Configuration -->
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            blue: {
              50: '#f0f5ff',
              100: '#e0eaff',
              200: '#c7d9ff',
              300: '#a5bfff',
              400: '#7e9dff',
              500: '#5a74fc',
              600: '#3b82f6',
              700: '#2563eb',
              800: '#1d4ed8',
              900: '#1e40af',
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
    .card {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      padding: 1.5rem;
    }
    .dark .card {
      background-color: #1f2937;
      border-color: #374151;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.625rem 1.25rem;
      font-weight: 500;
      font-size: 0.875rem;
      border-radius: 0.375rem;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-primary {
      background-color: #3b82f6;
      color: white;
    }
    .btn-primary:hover {
      background-color: #2563eb;
    }
    .btn-outline {
      border: 1px solid #d1d5db;
      color: #4b5563;
      background-color: white;
    }
    .dark .btn-outline {
      border-color: #4b5563;
      color: #d1d5db;
      background-color: #1f2937;
    }
    .btn-outline:hover {
      background-color: #f9fafb;
    }
    .dark .btn-outline:hover {
      background-color: #374151;
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
    .dark .bg-blue-50 {
      background-color: rgba(30, 58, 138, 0.5);
    }
    .dark .border-gray-200 {
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
    .dark .hover\:bg-gray-100:hover {
      background-color: #374151;
    }

    /* Input styles for dark mode */
    .dark input[type="text"],
    .dark input[type="email"],
    .dark input[type="password"],
    .dark input[type="tel"],
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
    input[type="tel"],
    textarea,
    select {
      background-color: #f9fafb;
      border-color: #d1d5db;
    }

    .dark input::placeholder {
      color: #9ca3af;
    }

    /* Table styles for dark mode */
    .dark th {
      background-color: #1f2937;
    }
    .dark td {
      border-color: #374151;
    }
    .dark tr:hover {
      background-color: #374151;
    }

    /* Pada elemen input dan select di mode terang */
    .bg-gray-50 {
      background-color: #f1f5f9;
    }
    .bg-gray-100 {
      background-color: #f3f4f6;
    }
    .bg-blue-50 {
      background-color: rgba(59, 130, 246, 0.1);
    }
  </style>
  @yield('styles')
</head>
<body class="bg-gray-100 dark:bg-gray-900">
  <div id="app" class="flex flex-col min-h-screen">
    <!-- Navbar -->
    @include('partials.navbar')

    <div class="flex pt-16 flex-grow">
      <!-- Sidebar -->
      @auth
        @include('partials.sidebar')
      @endauth

      <!-- Main Content -->
      <div id="main-content" class="w-full bg-gray-100 dark:bg-gray-900 relative {{ auth()->check() ? 'lg:ml-64' : '' }} flex flex-col min-h-screen">
        <main class="p-4 md:p-6 flex-grow">
          <!-- Alert Messages -->
          @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
              <p>{{ session('success') }}</p>
            </div>
          @endif

          @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
              <p>{{ session('error') }}</p>
            </div>
          @endif

          @if(session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded" role="alert">
              <p>{{ session('info') }}</p>
            </div>
          @endif

          @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Content -->
          @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
      </div>
    </div>
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
      if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function() {
          let isDark = document.documentElement.classList.toggle('dark');
          localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
      }

      // Set up CSRF token for AJAX requests
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Sidebar Toggle untuk tampilan mobile
      const toggleSidebarButton = document.getElementById('toggle-sidebar-button');
      const closeSidebarButton = document.getElementById('close-sidebar');
      const sidebar = document.getElementById('sidebar');

      if (toggleSidebarButton && sidebar) {
        toggleSidebarButton.addEventListener('click', function() {
          sidebar.classList.toggle('-translate-x-full');
        });
      }

      if (closeSidebarButton && sidebar) {
        closeSidebarButton.addEventListener('click', function() {
          sidebar.classList.add('-translate-x-full');
        });
      }

      // Logout button
      const logoutButton = document.getElementById('logout-button');
      if (logoutButton) {
        logoutButton.addEventListener('click', function(e) {
          e.preventDefault();
          if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
            document.getElementById('logout-form').submit();
          }
        });
      }
    });
  </script>
  @yield('scripts')
</body>
</html>