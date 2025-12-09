<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Cuti') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- FIX: Panggil Alpine.js lewat CDN agar menu hamburger & dropdown pasti jalan -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
        
        <style>
            body { font-family: 'Instrument Sans', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    
    <!-- x-data di body agar state sidebar bisa diakses di mana saja -->
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100" 
          x-data="{ sidebarOpen: false }">
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- Sidebar Navigation -->
            <!-- Pastikan file resources/views/layouts/sidebar.blade.php ada -->
            @include('layouts.sidebar')

            <!-- Main Content Wrapper -->
            <!-- md:ml-64 memberikan margin kiri di desktop agar konten tidak tertutup sidebar -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden md:ml-64 transition-all duration-300">
                
                <!-- Mobile Header -->
                <!-- Hanya tampil di mobile (md:hidden). Hamburger di kiri, Logo di sebelahnya. -->
                <header class="flex items-center justify-start gap-4 px-6 py-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 md:hidden sticky top-0 z-40">
                    
                    <!-- 1. Tombol Hamburger (Kiri) -->
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 -ml-2 text-gray-500 rounded-md focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <!-- Icon Garis 3 (Menu) -->
                        <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <!-- Icon Silang (Tutup) -->
                        <svg x-show="sidebarOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <!-- 2. Logo & Nama Aplikasi -->
                    <div class="flex items-center gap-3">
                        <x-application-logo class="w-8 h-8" />
                        <span class="text-lg font-bold text-gray-900 dark:text-white">E-Cuti</span>
                    </div>
                    
                </header>

                <!-- Page Heading (Desktop Sticky) -->
                <!-- Header halaman seperti 'Dashboard', 'Manajemen Pengguna', dll -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-30 transition-colors duration-300 hidden md:block">
                        <div class="px-6 py-4 md:px-8 md:py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-4 md:p-8">
                    {{ $slot }}
                </main>
            </div>

            <!-- Overlay Mobile -->
            <!-- Background gelap transparan saat sidebar terbuka di HP -->
            <div x-show="sidebarOpen" 
                 x-cloak
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-sm md:hidden">
            </div>

            <!-- TOAST NOTIFICATION COMPONENT -->
            <!-- Akan muncul otomatis jika ada session flash message (success/error) -->
            <x-toast />
            <x-confirm-modal />

        </div>
    </body>
</html>