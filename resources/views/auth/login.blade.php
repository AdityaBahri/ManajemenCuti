<x-guest-layout>
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Selamat Datang Kembali! 👋
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Masuk untuk mengelola cuti Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address / Username -->
        <div>
            <x-input-label for="login" :value="__('Email atau Username')" class="dark:text-gray-300 font-medium" />
            <div class="relative mt-1">
                {{-- Icon Container --}}
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
                
                {{-- Input Field --}}
                {{-- Perubahan: pl-10 diganti menjadi agar tidak tumpang tindih --}}
                <x-text-input id="login" class="block w-full pl-12 py-2.5 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm sm:text-sm" 
                              type="text" 
                              name="login" 
                              :value="old('login')" 
                              required autofocus autocomplete="username" 
                              placeholder="nama@perusahaan.com" />
            </div>
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300 font-medium" />
            <div class="relative mt-1">
                {{-- Icon Container --}}
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </div>

                {{-- Input Field --}}
                {{-- Perubahan: pl-10 diganti menjadi pl-12 --}}
                <x-text-input id="password" class="block w-full pl-12 py-2.5 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm sm:text-sm"
                                type="password"
                                name="password"
                                required autocomplete="current-password" 
                                placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-primary-600 shadow-sm focus:ring-primary-500 dark:focus:ring-primary-600 dark:bg-gray-900" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                {{ __('Masuk ke Dashboard') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                    Daftar Karyawan Baru
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>