<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Cuti') }} - Manajemen Cuti Karyawan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
        /* Pola Grid Latar Belakang */
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(99, 102, 241, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .dark .bg-grid-pattern {
            background-image: radial-gradient(rgba(99, 102, 241, 0.15) 1px, transparent 1px);
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans antialiased selection:bg-primary-500 selection:text-white">

    <!-- Navbar Sticky -->
    <header class="fixed w-full z-50 transition-all duration-300 bg-white/80 dark:bg-gray-950/80 backdrop-blur-lg border-b border-gray-100 dark:border-gray-800">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                {{-- Menggunakan Komponen Logo Laravel Breeze --}}
                <x-application-logo class="w-10 h-10 shadow-lg shadow-primary-500/20" />
                <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">E-Cuti</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Fitur</a>
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-all">
                            Dashboard
                        </a>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-all shadow-lg shadow-primary-600/20">
                                    Daftar Sekarang
                                </a>
                            @endif
                        </div>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
            <div class="absolute inset-0 bg-grid-pattern [mask-image:linear-gradient(to_bottom,white,transparent)] dark:[mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-900/30 border border-primary-100 dark:border-primary-800 text-primary-700 dark:text-primary-300 text-xs font-semibold mb-8 animate-fade-in-up">
                    <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                    Sistem Cuti Terintegrasi V1.0
                </div>

                <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 dark:text-white tracking-tight leading-tight mb-6">
                    Manajemen Cuti <br>
                    <span class="relative whitespace-nowrap text-primary-600 dark:text-primary-500">
                        <svg aria-hidden="true" viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-primary-200/50 dark:fill-primary-800/50" preserveAspectRatio="none"><path d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C46.169 14.687 14.666 17.518 4.8 22.426c-8.865 4.395-9.723 12.33 4.291 16.433 13.923 4.093 39.462 2.766 52.613 2.162 43.14-1.921 168.125-5.69 224.238-16.71 39.904-7.854 99.474-12.723 123.51-7.237 22.422 5.116 23.323 19.333-3.69 21.684-25.772 2.227-88.976-1.428-142.327-14.779-1.939-.484-3.515-1.528-2.529-2.73 1.05-1.277 4.093-.257 6.096.22 47.962 11.413 105.743 13.564 125.753 11.69 18.262-1.71 18.028-9.876.81-13.816-33.64-7.688-109.91-1.077-143.515 5.518-72.235 14.194-192.658 18.177-227.142 19.67-15.376.666-31.42 1.341-39.73-.284-8.777-1.715-6.837-7.796 3.697-12.96 17.15-8.412 59.72-11.597 81.332-13.064 77.027-5.23 162.776 1.48 190.548 7.37.94.2 2.233-.772 1.256-1.844-3.59-3.924-25.32-12.39-58.617-13.574Z"></path></svg>
                        Lebih Sederhana
                    </span>
                </h1>

                <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Platform digital untuk mengelola pengajuan, persetujuan, dan pelacakan cuti karyawan secara efisien. Tingkatkan produktivitas tim Anda hari ini.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-xl hover:bg-gray-800 dark:hover:bg-gray-200 transition-all shadow-xl hover:-translate-y-1">
                        Mulai Gratis
                    </a>
                    <a href="#demo" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Lihat Demo
                    </a>
                </div>

                <!-- Dashboard Preview (Floating with Glass Effect) -->
                <div class="mt-20 relative mx-auto max-w-5xl">
                    <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 to-purple-600 rounded-2xl blur opacity-20"></div>
                    <div class="relative bg-gray-900 rounded-xl border border-gray-800 shadow-2xl overflow-hidden group">
                        <div class="flex items-center gap-2 px-4 py-3 bg-gray-800 border-b border-gray-700">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="mx-auto text-xs text-gray-500 font-mono">dashboard.e-cuti.com</div>
                        </div>
                        <!-- Placeholder Image -->
                        <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=1974&auto=format&fit=crop" alt="Dashboard Preview" class="w-full h-auto opacity-90 transition duration-700 group-hover:scale-[1.01]">
                        
                        <!-- Floating Badge -->
                        <div class="absolute bottom-10 right-10 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 flex items-center gap-3 animate-bounce">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 dark:text-green-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Status Pengajuan</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Disetujui HRD</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid -->
        <section id="fitur" class="py-24 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-lg flex items-center justify-center text-primary-600 dark:text-primary-400 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Real-time Approval</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Persetujuan berjenjang dari Ketua Divisi hingga HRD. Notifikasi status instan tanpa perlu menunggu lama.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Pelacakan Kuota</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Sistem otomatis menghitung sisa cuti tahunan. Transparansi penuh bagi karyawan dan manajemen.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/50 rounded-lg flex items-center justify-center text-pink-600 dark:text-pink-400 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Manajemen Tim</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Dashboard khusus untuk Admin dan Ketua Divisi untuk mengelola anggota tim dan memantau kehadiran.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">500+</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Karyawan</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">12k</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Pengajuan</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">99%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Uptime</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">24/7</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Support</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-primary-600"></div>
            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
            <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Siap Meningkatkan Efisiensi HR Anda?</h2>
                <p class="text-primary-100 text-lg mb-10 max-w-2xl mx-auto">
                    Bergabunglah sekarang dan rasakan kemudahan mengelola cuti karyawan dengan sistem yang modern dan terintegrasi.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-primary-700 font-bold rounded-xl shadow-xl hover:bg-gray-50 transition-all transform hover:-translate-y-1">
                        Daftar Gratis
                    </a>
                    <a href="#" class="px-8 py-4 bg-primary-700 text-white font-bold rounded-xl border border-primary-500 hover:bg-primary-800 transition-all">
                        Hubungi Sales
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-gray-950 border-t border-gray-200 dark:border-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-900 dark:bg-white rounded-lg flex items-center justify-center text-white dark:text-gray-900 font-bold">E</div>
                <span class="text-lg font-bold text-gray-900 dark:text-white">E-Cuti</span>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} E-Cuti System. All rights reserved.
            </p>
            <div class="flex gap-6">
                <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Privacy</a>
                <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Terms</a>
                <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Twitter</a>
            </div>
        </div>
    </footer>

</body>
</html>