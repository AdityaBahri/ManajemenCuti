<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-transform duration-300 ease-in-out transform md:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <!-- Logo Header -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="w-8 h-8" />
            <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">E-Cuti</span>
        </a>
    </div>

    <!-- Menu Items -->
    <div class="overflow-y-auto overflow-x-hidden flex-1 h-[calc(100vh-4rem)] p-4 space-y-1">
        
        {{-- SECTION: UTAMA --}}
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Menu Utama</p>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        {{-- LOGIC: Menu 'Cuti Saya' HANYA muncul jika user BUKAN Admin dan BUKAN HRD --}}
        @if(!Auth::user()->isAdmin() && !Auth::user()->isHrd())
            <a href="{{ route('leave-requests.index') }}" 
               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('leave-requests.*') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('leave-requests.*') ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Cuti Saya
            </a>
        @endif

        {{-- SECTION: APPROVAL (Hanya untuk Leader, HRD, Admin) --}}
        @if(Auth::user()->isDivisionHead() || Auth::user()->isHrd())
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Verifikasi</p>
            
            <a href="{{ route('approvals.index') }}" 
               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('approvals.*') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('approvals.*') ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Persetujuan Cuti
            </a>
        @endif

        {{-- SECTION: ADMIN PANEL (Hanya Super Admin) --}}
        @can('access-admin-panel')
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Administrasi</p>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Manajemen User
            </a>

            <a href="{{ route('admin.divisions.index') }}" 
               class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('admin.divisions.*') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.divisions.*') ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Manajemen Divisi
            </a>
        @endcan
        
        <!-- Spacer agar menu tidak tertutup profil di layar kecil -->
        <div class="h-24"></div>
    </div>

    <!-- User Profile & Logout (Bottom) -->
    <div class="absolute bottom-0 left-0 w-full border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('profile.edit') }}" class="flex items-center justify-center px-3 py-2 font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg text-xs transition-colors">
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-3 py-2 font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-lg text-xs transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>