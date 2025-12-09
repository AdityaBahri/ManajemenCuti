<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Ajukan Permohonan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Info Kuota Modern Card --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-100 dark:border-blue-800 p-6 mb-8 rounded-2xl shadow-sm flex items-center gap-5">
                <div class="p-3 bg-blue-100 dark:bg-blue-800 rounded-xl text-blue-600 dark:text-blue-200 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Sisa Kuota Cuti Tahunan</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Anda memiliki <span class="font-extrabold text-indigo-600 dark:text-indigo-400 text-lg">{{ $user->current_annual_leave_quota }} Hari</span> sisa cuti yang dapat digunakan tahun ini.
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                
                <div class="p-8">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm">
                            <strong class="font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Perhatian!
                            </strong>
                            <ul class="mt-2 list-disc list-inside text-sm pl-2 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('leave-requests.store') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Section 1: Detail Cuti -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-3 pb-2 border-b border-gray-100 dark:border-gray-700">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-sm font-bold">1</span>
                                Detail Pengajuan
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                {{-- Jenis Cuti --}}
                                <div>
                                    <x-input-label for="leave_type_id" :value="__('Jenis Cuti')" class="dark:text-gray-300 font-medium mb-1.5" />
                                    <div class="relative">
                                        <select id="leave_type_id" name="leave_type_id" class="block w-full pl-4 pr-10 py-3 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl dark:bg-gray-900 dark:text-gray-300 transition-shadow" required onchange="toggleAttachment(this)">
                                            <option value="">-- Pilih Jenis Cuti --</option>
                                            @foreach ($leaveTypes as $type)
                                                <option value="{{ $type->id }}" data-name="{{ $type->name }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }} 
                                                    {{ $type->name == 'Cuti Tahunan' ? '(Mengurangi Kuota)' : '(Perlu Dokumen)' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Tanggal Mulai --}}
                                    <div>
                                        <x-input-label for="start_date" :value="__('Tanggal Mulai')" class="dark:text-gray-300 font-medium mb-1.5" />
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <x-text-input id="start_date" name="start_date" type="date" class="block w-full pl-11 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm" :value="old('start_date')" required />
                                        </div>
                                    </div>

                                    {{-- Tanggal Selesai --}}
                                    <div>
                                        <x-input-label for="end_date" :value="__('Tanggal Selesai')" class="dark:text-gray-300 font-medium mb-1.5" />
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <x-text-input id="end_date" name="end_date" type="date" class="block w-full pl-11 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm" :value="old('end_date')" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Alasan --}}
                                <div>
                                    <x-input-label for="reason" :value="__('Alasan Cuti')" class="dark:text-gray-300 font-medium mb-1.5" />
                                    <div class="relative">
                                        <textarea id="reason" name="reason" rows="4" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm transition-shadow p-3" required placeholder="Jelaskan keperluan cuti Anda secara singkat...">{{ old('reason') }}</textarea>
                                    </div>
                                </div>

                                {{-- Upload Surat Dokter --}}
                                <div id="attachment-container" class="hidden transition-all duration-300 ease-in-out">
                                    <div class="p-6 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border-indigo-200 dark:border-indigo-800 border-dashed border-2">
                                        <x-input-label for="medical_certificate" :value="__('Upload Surat Dokter (Wajib)')" class="text-indigo-700 dark:text-indigo-300 font-bold mb-3 block" />
                                        <input id="medical_certificate" name="medical_certificate" type="file" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 dark:hover:file:bg-indigo-500 cursor-pointer transition-colors shadow-sm" />
                                        <p class="mt-3 text-xs text-indigo-500 dark:text-indigo-400 font-medium flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Format: JPG, PNG, PDF. Maks: 2MB.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Kontak Darurat -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-3 pb-2 border-b border-gray-100 dark:border-gray-700">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-bold">2</span>
                                Kontak Selama Cuti (Opsional)
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="address" :value="__('Alamat')" class="dark:text-gray-300 font-medium mb-1.5" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <x-text-input id="address" name="address" type="text" class="block w-full pl-11 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm" :value="old('address', $user->address)" placeholder="Alamat saat ini" />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="phone_number" :value="__('Nomor Darurat')" class="dark:text-gray-300 font-medium mb-1.5" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </div>
                                        <x-text-input id="phone_number" name="phone_number" type="text" class="block w-full pl-11 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm" :value="old('phone_number', $user->phone_number)" placeholder="08..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <x-primary-button class="px-6 py-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-base font-bold rounded-xl shadow-lg transform transition hover:-translate-y-0.5">
                                {{ __('Kirim Pengajuan') }}
                            </x-primary-button>
                            <a href="{{ route('leave-requests.index') }}" class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAttachment(select) {
            const selectedOption = select.options[select.selectedIndex];
            const typeName = selectedOption.getAttribute('data-name');
            const container = document.getElementById('attachment-container');
            
            // Tampilkan upload jika nama cuti mengandung kata 'Sakit'
            if (typeName && typeName.includes('Sakit')) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>