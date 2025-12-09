@if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    @php
        $type = session()->has('success') ? 'success' : (session()->has('error') ? 'error' : (session()->has('warning') ? 'warning' : 'info'));
        $message = session($type);
        
        $colors = [
            'success' => 'bg-green-50 dark:bg-green-900/30 border-green-500 text-green-800 dark:text-green-200',
            'error'   => 'bg-red-50 dark:bg-red-900/30 border-red-500 text-red-800 dark:text-red-200',
            'warning' => 'bg-yellow-50 dark:bg-yellow-900/30 border-yellow-500 text-yellow-800 dark:text-yellow-200',
            'info'    => 'bg-blue-50 dark:bg-blue-900/30 border-blue-500 text-blue-800 dark:text-blue-200',
        ];

        $icons = [
            'success' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'error'   => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'warning' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
            'info'    => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ];

        $titles = [
            'success' => 'Berhasil!',
            'error'   => 'Terjadi Kesalahan!',
            'warning' => 'Perhatian!',
            'info'    => 'Informasi',
        ];
    @endphp

    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)" {{-- Hilang otomatis setelah 4 detik --}}
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-24 right-5 z-[60] max-w-sm w-full shadow-lg rounded-xl pointer-events-auto overflow-hidden border-l-4 {{ $colors[$type] }}"
         role="alert">
        
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    {!! $icons[$type] !!}
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-bold">
                        {{ $titles[$type] }}
                    </p>
                    <p class="mt-1 text-sm opacity-90">
                        {{ $message }}
                    </p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="show = false" class="inline-flex text-current hover:opacity-75 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Progress Bar Animasi (Opsional untuk estetika) --}}
        <div class="absolute bottom-0 left-0 h-1 bg-current opacity-20 w-full"
             x-data="{ width: '100%' }"
             x-init="setTimeout(() => width = '0%', 100); setTimeout(() => show = false, 4000)"
             :style="'width: ' + width + '; transition: width 4s linear;'">
        </div>
    </div>
@endif