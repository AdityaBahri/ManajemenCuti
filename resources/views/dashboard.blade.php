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
                            @if(Auth::user()->isAdmin())
                                Panel Admin: Kelola data master dan pengguna sistem.
                            @elseif(Auth::user()->isHrd())
                                Panel HRD: Kelola persetujuan dan rekapitulasi cuti.
                            @elseif(Auth::user()->isDivisionHead())
                                Panel Leader: Pantau tim dan kelola cuti Anda.
                            @else
                                Selamat bekerja! Jaga kesehatan dan keseimbangan kerja.
                            @endif
                        </p>
                    </div>
                    
                    {{-- TOMBOL AJUKAN CUTI (Hanya untuk Karyawan & Ka. Divisi) --}}
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

            {{-- === 2. PANEL ADMIN (Data Master) === --}}
            @if(Auth::user()->isAdmin() && isset($data['admin']))
                <div>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-l-4 border-indigo-500 pl-3">Statistik Sistem</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <!-- Total Pengguna -->
                        <a href="{{ route('admin.users.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:border-indigo-300 transition-all cursor-pointer group">
                            <div class="p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['total_users'] ?? 0 }}</p>
                            </div>
                        </a>

                        <!-- Total Divisi -->
                        <a href="{{ route('admin.divisions.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:border-purple-300 transition-all cursor-pointer group">
                            <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Divisi</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['total_divisions'] ?? 0 }}</p>
                            </div>
                        </a>

                        <!-- Karyawan Aktif -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                            <div class="p-3 rounded-xl bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">User Aktif</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['admin']['active_users'] ?? 0 }}</p>
                            </div>
                        </div>

                        <!-- Pending Approval (Global) -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                            <div class="p-3 rounded-xl bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Approval</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $data['admin']['pending_approvals'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Karyawan Belum Eligible --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <h5 class="font-bold text-gray-700 dark:text-gray-200">Karyawan < 1 Tahun (Belum Eligible Cuti Tahunan)</h5>
                            <span class="text-xs bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-full">
                                {{ isset($data['admin']['ineligible_users']) ? count($data['admin']['ineligible_users']) : 0 }} Orang
                            </span>
                        </div>
                        <div class="p-0">
                            @if(isset($data['admin']['ineligible_users']) && count($data['admin']['ineligible_users']) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Divisi</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Bergabung</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Masa Kerja</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($data['admin']['ineligible_users'] as $user)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $user->division->name ?? '-' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $user->join_date->format('d M Y') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $user->join_date->diffForHumans(null, true) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-6 text-center text-gray-500 dark:text-gray-400 italic">Semua karyawan sudah eligible cuti tahunan.</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif


            {{-- === 3. PANEL HRD (Operasional) === --}}
            @if(Auth::user()->isHrd() && isset($data['hrd']))
                <div>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-l-4 border-pink-500 pl-3">Panel HRD</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <!-- Need Approval -->
                        <a href="{{ route('approvals.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-red-100 dark:border-red-900/30 flex items-center gap-4 hover:border-red-200 transition-all cursor-pointer group">
                            <div class="p-3 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-red-600 dark:text-red-400">Menunggu Persetujuan</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $data['hrd']['pending_final'] ?? 0 }}</p>
                            </div>
                        </a>

                        <!-- On Leave Today -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-teal-100 dark:border-teal-900/30 flex items-center gap-4">
                            <div class="p-3 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sedang Cuti Hari Ini</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $data['on_leave_today'] ?? 0 }}</p>
                            </div>
                        </div>

                        <!-- Total Employees -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-blue-100 dark:border-blue-900/30 flex items-center gap-4">
                            <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pegawai</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $data['total_employees'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Karyawan Sedang Cuti Bulan Ini -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mt-6">
                        <div class="p-4 bg-pink-50 dark:bg-pink-900/20 border-b border-pink-100 dark:border-pink-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h5 class="font-bold text-pink-700 dark:text-pink-300">Karyawan Sedang Cuti (Bulan Ini)</h5>
                        </div>
                        <div class="p-4">
                            @if(isset($data['hrd']['on_leave_month']) && $data['hrd']['on_leave_month']->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach($data['hrd']['on_leave_month'] as $userLeave)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                            <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                            {{ $userLeave->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic text-center py-4">Tidak ada karyawan yang sedang cuti bulan ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif


            {{-- === 4. PANEL KETUA DIVISI === --}}
            @if(Auth::user()->isDivisionHead() && Auth::user()->ledDivision && isset($data['head']))
                <div>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-l-4 border-orange-500 pl-3">
                        Panel Divisi: {{ Auth::user()->ledDivision->name }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('approvals.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-orange-100 dark:border-orange-900/30 hover:border-orange-200 transition-all flex items-center justify-between group cursor-pointer hover:shadow-md">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Verifikasi Anda</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1 group-hover:text-orange-600 transition-colors">{{ $data['head']['pending_verification'] ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-orange-50 dark:bg-orange-900/30 rounded-xl text-orange-500 dark:text-orange-400 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </a>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Anggota Tim</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $data['head']['team_count'] ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-500 dark:text-blue-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- === 5. PANEL USER (KARYAWAN) === --}}
            {{-- Disembunyikan untuk Admin dan HRD --}}
            @if(!Auth::user()->isAdmin() && !Auth::user()->isHrd() && isset($data['user']))
                <div>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-l-4 border-blue-500 pl-3">Data Cuti Saya</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-blue-100 dark:border-blue-900/30">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Sisa Kuota</p>
                            <h3 class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-2">{{ $data['my_quota'] ?? 0 }} <span class="text-base text-gray-400">Hari</span></h3>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Pending</p>
                            <h3 class="text-3xl font-extrabold text-yellow-500 mt-2">{{ $data['my_pending'] ?? 0 }} <span class="text-base text-gray-400">Req</span></h3>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Disetujui</p>
                            <h3 class="text-3xl font-extrabold text-green-600 dark:text-green-400 mt-2">{{ $data['my_approved'] ?? 0 }} <span class="text-base text-gray-400">Kali</span></h3>
                        </div>
                    </div>
                </div>

                {{-- Aktivitas Terakhir --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mt-8">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Aktivitas Terakhir</h4>
                        <a href="{{ route('leave-requests.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Lihat Semua &rarr;</a>
                    </div>
                    
                    <div class="p-6">
                        @if(isset($data['my_last_request']) && $data['my_last_request'])
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
                                <a href="{{ route('leave-requests.create') }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Buat Pengajuan Pertama Anda &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>