<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- === 1. WELCOME BANNER === --}}
            <div class="relative overflow-hidden rounded-2xl bg-indigo-600 dark:bg-indigo-900 shadow-xl">
                <!-- Dekorasi Background -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-40 h-40 bg-purple-500 opacity-20 rounded-full blur-2xl"></div>
                
                <div class="relative p-8 md:p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-indigo-100 text-lg">
                            Selamat datang di E-Cuti. 
                            @if(Auth::user()->isAdmin() || Auth::user()->isHrd())
                                Kelola data karyawan dan persetujuan cuti dengan mudah.
                            @else
                                Kelola jadwal dan pengajuan cuti Anda dengan mudah hari ini.
                            @endif
                        </p>
                    </div>
                    
                    {{-- TOMBOL AJUKAN CUTI (Disembunyikan untuk Admin & HRD) --}}
                    @if(!Auth::user()->isAdmin() && !Auth::user()->isHrd())
                        <div class="hidden md:block">
                            <a href="{{ route('leave-requests.create') }}" class="px-6 py-3 bg-white text-indigo-700 font-bold rounded-xl shadow-lg hover:bg-indigo-50 transition transform hover:-translate-y-1 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Ajukan Cuti Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- === 2. STATISTIK SAYA (Untuk Semua User) === --}}
            {{-- Bagian ini menampilkan data pribadi user yang login --}}
            <div>
                <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Statistik Saya
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Sisa Cuti -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Sisa Kuota</p>
                                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $data['my_quota'] }} <span class="text-base font-medium text-gray-400">Hari</span>
                                </h3>
                            </div>
                            <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Menunggu</p>
                                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                                    {{ $data['my_pending'] }} <span class="text-base font-medium text-gray-400">Request</span>
                                </h3>
                            </div>
                            <div class="p-3 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl text-yellow-600 dark:text-yellow-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Approved -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Disetujui</p>
                                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                    {{ $data['my_approved'] }} <span class="text-base font-medium text-gray-400">Kali</span>
                                </h3>
                            </div>
                            <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-xl text-green-600 dark:text-green-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === 3. PANEL MANAJEMEN (Hanya Admin & HRD) === --}}
            @if(Auth::user()->isAdmin() || Auth::user()->isHrd())
                <div>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Overview Perusahaan
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        <!-- Total Karyawan -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                            <div class="p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Karyawan</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['total_employees'] }}</p>
                            </div>
                        </div>

                        <!-- Total Divisi -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                            <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Divisi</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['total_divisions'] }}</p>
                            </div>
                        </div>

                        <!-- Need Approval -->
                        <a href="{{ route('approvals.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-red-100 dark:border-red-900/30 flex items-center gap-4 hover:shadow-md hover:border-red-200 transition-all cursor-pointer">
                            <div class="p-3 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-red-600 dark:text-red-400">Perlu Approval</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['global_pending'] }}</p>
                            </div>
                        </a>

                        <!-- On Leave Today -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                            <div class="p-3 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sedang Cuti</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['on_leave_today'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- === 4. PANEL TIM (Hanya Ketua Divisi) === --}}
            @if(Auth::user()->isDivisionHead() && Auth::user()->ledDivision)
                <div>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Divisi: {{ Auth::user()->ledDivision->name }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pending Approval Anggota Tim -->
                        <a href="{{ route('approvals.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-orange-100 dark:border-orange-900/30 hover:border-orange-200 transition-all flex items-center justify-between group cursor-pointer">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Verifikasi Anda</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1 group-hover:text-orange-600 transition-colors">{{ $data['team_pending'] }}</p>
                            </div>
                            <div class="p-3 bg-orange-50 dark:bg-orange-900/30 rounded-xl text-orange-500 dark:text-orange-400 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </a>

                        <!-- Total Anggota -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Anggota Tim</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $data['team_count'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-500 dark:text-blue-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- === 5. AKTIVITAS TERAKHIR (Semua User) === --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Aktivitas Terakhir</h4>
                    
                    {{-- Link Lihat Semua (Hanya untuk yang bukan Admin/HRD agar tidak bingung) --}}
                    @if(!Auth::user()->isAdmin() && !Auth::user()->isHrd())
                        <a href="{{ route('leave-requests.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Lihat Semua &rarr;</a>
                    @endif
                </div>
                
                <div class="p-6">
                    @if($data['my_last_request'])
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-300 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pengajuan Cuti</p>
                                    <p class="text-base font-bold text-gray-900 dark:text-white">{{ $data['my_last_request']->type->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $data['my_last_request']->created_at->format('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="text-right hidden md:block">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Durasi</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $data['my_last_request']->total_days }} Hari</p>
                                </div>
                                
                                <div>
                                    @php
                                        $status = $data['my_last_request']->status;
                                        $badges = [
                                            'approved' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400', 'label' => 'Disetujui'],
                                            'rejected' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400', 'label' => 'Ditolak'],
                                            'cancelled' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-700 dark:text-gray-300', 'label' => 'Dibatalkan'],
                                            'approved_by_leader' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400', 'label' => 'Menunggu HRD'],
                                            'pending' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400', 'label' => 'Menunggu Atasan'],
                                        ];
                                        $badge = $badges[$status] ?? $badges['pending'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badge['bg'] }} {{ $badge['text'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5"></span>
                                        {{ $badge['label'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat pengajuan cuti.</p>
                            
                            {{-- Tampilkan tombol hanya jika bukan Admin/HRD --}}
                            @if(!Auth::user()->isAdmin() && !Auth::user()->isHrd())
                                <a href="{{ route('leave-requests.create') }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Buat Pengajuan Pertama Anda &rarr;
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>