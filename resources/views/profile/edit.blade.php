<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- === BAGIAN 1: INFO KEPEGAWAIAN === --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10">
                    <header class="flex items-center gap-3 mb-8 border-b border-gray-100 dark:border-gray-700 pb-4">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg text-indigo-600 dark:text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ __('Informasi Kepegawaian') }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Data resmi kepegawaian Anda.') }}
                            </p>
                        </div>
                    </header>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="group p-4 rounded-xl bg-gray-50 dark:bg-gray-700/30 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900 transition-all">
                            <span class="block text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Username</span>
                            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->username }}</span>
                        </div>
                        <div class="group p-4 rounded-xl bg-gray-50 dark:bg-gray-700/30 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900 transition-all">
                            <span class="block text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-2">Jabatan</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </div>
                        <div class="group p-4 rounded-xl bg-gray-50 dark:bg-gray-700/30 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900 transition-all">
                            <span class="block text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Divisi</span>
                            <span class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->division->name ?? '-' }}
                            </span>
                        </div>
                        <div class="group p-4 rounded-xl bg-gray-50 dark:bg-gray-700/30 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900 transition-all">
                            <span class="block text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Bergabung Sejak</span>
                            <span class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->join_date ? $user->join_date->format('d M Y') : '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-dashed border-gray-200 dark:border-gray-700 grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="flex items-center justify-between p-5 rounded-xl bg-gray-50 dark:bg-gray-700/30">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gray-200 dark:bg-gray-600 rounded-lg text-gray-600 dark:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Kuota Tahunan</span>
                            </div>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->initial_annual_leave_quota }} Hari</span>
                        </div>
                        <div class="flex items-center justify-between p-5 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-200 dark:bg-indigo-800 rounded-lg text-indigo-700 dark:text-indigo-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">Sisa Kuota Saat Ini</span>
                            </div>
                            <span class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $user->current_annual_leave_quota }} <span class="text-base font-medium text-indigo-500">Hari</span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === BAGIAN 2: EDIT INFO PRIBADI (FULL WIDTH) === --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                <!-- Hapus div max-w-xl agar form melebar -->
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- === BAGIAN 3: UPDATE PASSWORD (FULL WIDTH) === --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                <!-- Hapus div max-w-xl agar form melebar -->
                @include('profile.partials.update-password-form')
            </div>

            {{-- === BAGIAN 4: HAPUS AKUN (FULL WIDTH) === --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                <!-- Hapus div max-w-xl agar form melebar -->
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>