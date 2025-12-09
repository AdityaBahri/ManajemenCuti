<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'E-Cuti') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="min-h-screen flex">
        
        <!-- BAGIAN KIRI: GAMBAR (Hidden di Mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-indigo-900">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=2070&auto=format&fit=crop" 
                 alt="Office Background" 
                 class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay">
            
            <!-- Overlay Content -->
            <div class="relative z-10 w-full flex flex-col justify-between p-12 text-white">
                <div>
                    <a href="/" class="flex items-center gap-3 w-fit">
                        <div class="bg-white/10 backdrop-blur-md p-2 rounded-lg border border-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight">E-Cuti</span>
                    </a>
                </div>

                <div class="space-y-6">
                    <h1 class="text-5xl font-bold leading-tight">
                        Kelola Cuti Anda <br>
                        <span class="text-indigo-300">Lebih Efisien.</span>
                    </h1>
                    <p class="text-lg text-indigo-100 max-w-md leading-relaxed">
                        Sistem manajemen cuti terintegrasi untuk meningkatkan produktivitas dan kesejahteraan karyawan. Akses data cuti Anda kapan saja, di mana saja.
                    </p>
                </div>

                <div class="flex items-center gap-4 text-sm text-indigo-200">
                    <p>&copy; {{ date('Y') }} E-Cuti System</p>
                    <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                    <a href="#" class="hover:text-white transition">Terms</a>
                </div>
            </div>
            
            <!-- Dekorasi Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-indigo-900 via-indigo-900/40 to-transparent"></div>
        </div>

        <!-- BAGIAN KANAN: FORM LOGIN -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-white dark:bg-gray-950 relative">
            
            <!-- Tombol Kembali (Mobile Only) -->
            <a href="/" class="absolute top-6 left-6 lg:hidden text-gray-500 hover:text-indigo-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>

            <div class="w-full max-w-md space-y-8">
                <!-- Header Form -->
                <div class="text-center">
                    {{-- Logo Mobile --}}
                    <div class="lg:hidden flex justify-center mb-6">
                        <x-application-logo class="w-12 h-12 text-indigo-600" />
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                        Selamat Datang
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Masuk ke akun Anda untuk melanjutkan.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf

                    <div class="space-y-5">
                        <!-- Email / Username -->
                        <div>
                            <x-input-label for="login" :value="__('Email atau Username')" class="dark:text-gray-300 font-medium mb-1.5 block" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <x-text-input id="login" class="block w-full pl-11 py-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm sm:text-sm" 
                                              type="text" 
                                              name="login" 
                                              :value="old('login')" 
                                              required autofocus autocomplete="username" 
                                              placeholder="username atau email" />
                            </div>
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300 font-medium" />
                                @if (Route::has('password.request'))
                                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400" href="{{ route('password.request') }}">
                                        {{ __('Lupa password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password" class="block w-full pl-11 py-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm sm:text-sm"
                                                type="password"
                                                name="password"
                                                required autocomplete="current-password" 
                                                placeholder="••••••••" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900" name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
                        </label>
                    </div>

                    <div>
                        <x-primary-button class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                            {{ __('Masuk ke Dashboard') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Footer Info -->
                <div class="mt-6 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-gray-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-950 text-gray-500">Informasi Pendaftaran</span>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                        Belum memiliki akun? Silakan hubungi 
                        <span class="font-bold text-gray-700 dark:text-gray-300">HRD atau Admin</span> 
                        untuk pembuatan akun karyawan baru.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>