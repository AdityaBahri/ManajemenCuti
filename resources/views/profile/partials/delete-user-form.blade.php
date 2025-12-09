<section class="space-y-6">
    <!-- Layout Flexbox: Teks di Kiri, Tombol di Kanan -->
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
        
        <!-- Header / Peringatan (Sisi Kiri) -->
        <header class="flex items-start gap-4 max-w-4xl">
            <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-full text-red-600 dark:text-red-400 shrink-0 mt-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-red-600 dark:text-red-400">
                    {{ __('Hapus Akun') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
                </p>
            </div>
        </header>

        <!-- Tombol Aksi (Sisi Kanan) -->
        <div class="flex-shrink-0 flex items-center">
            <x-danger-button
                x-data=""
                @click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="bg-red-600 hover:bg-red-700 focus:ring-red-500 w-full md:w-auto justify-center px-6 py-3 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5"
            >{{ __('Hapus Akun Saya') }}</x-danger-button>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Akun -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white dark:bg-gray-800">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-red-100 dark:bg-red-900/50 rounded-full text-red-600 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
                </h2>
            </div>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 pl-11">
                {{ __('Setelah dihapus, data tidak dapat dikembalikan. Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun ini secara permanen.') }}
            </p>

            <div class="mt-6 pl-11">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full md:w-3/4 pl-10 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm"
                        placeholder="{{ __('Password Anda') }}"
                    />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <x-secondary-button x-on:click="$dispatch('close')" class="dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 focus:ring-red-500">
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>