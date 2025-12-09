<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ __('Persetujuan Cuti') }}
        </h2>
    </x-slot>

    {{-- Wrapper Alpine.js untuk mengelola Modal Penolakan --}}
    <div class="py-12" x-data="{ 
        rejectModalOpen: false, 
        rejectUrl: '', 
        rejectionNote: '',
        openRejectModal(url) {
            this.rejectUrl = url;
            this.rejectionNote = ''; // Reset catatan
            this.rejectModalOpen = true;
            {{-- Fokus ke textarea setelah modal terbuka --}}
            setTimeout(() => $refs.noteInput.focus(), 100);
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Daftar Permintaan Masuk
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tinjau dan proses pengajuan cuti karyawan di bawah ini.</p>
                </div>

                <div class="p-6">
                    @if($pendingRequests->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Semua Beres!</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-1">Tidak ada pengajuan cuti yang perlu ditinjau saat ini.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($pendingRequests as $req)
                                <div class="group relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 hover:shadow-lg transition-all duration-300 hover:border-indigo-300 dark:hover:border-indigo-700">
                                    <div class="flex flex-col md:flex-row justify-between md:items-start gap-6">
                                        
                                        {{-- User Info --}}
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                    {{ substr($req->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $req->user->name }}</h4>
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                                        {{ ucfirst(str_replace('_', ' ', $req->user->role)) }}
                                                    </span>
                                                    @if($req->status == 'approved_by_leader')
                                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            Verified by Leader
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $req->user->division->name ?? 'Tanpa Divisi' }}</p>
                                            </div>
                                        </div>

                                        {{-- Request Details --}}
                                        <div class="flex-grow md:pl-8 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                            <div class="space-y-1">
                                                <p class="text-gray-500 dark:text-gray-400">Jenis Cuti</p>
                                                <p class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $req->type->name }}</p>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-gray-500 dark:text-gray-400">Durasi</p>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $req->total_days }} Hari 
                                                    <span class="text-gray-400 text-xs">({{ $req->start_date->format('d M') }} - {{ $req->end_date->format('d M Y') }})</span>
                                                </p>
                                            </div>
                                            <div class="col-span-1 sm:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700 mt-2">
                                                <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Alasan</p>
                                                <p class="text-gray-700 dark:text-gray-300 italic">"{{ $req->reason }}"</p>
                                            </div>
                                            
                                            @if($req->medical_certificate_path)
                                                <div class="col-span-1 sm:col-span-2">
                                                    <a href="{{ Storage::url($req->medical_certificate_path) }}" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                        Lihat Surat Dokter
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex flex-row md:flex-col gap-3 min-w-[140px] pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-700 mt-4 md:mt-0 pl-0 md:pl-6 justify-end">
                                            
                                            {{-- Tombol Setujui (Menggunakan Modal Konfirmasi Umum) --}}
                                            <button type="button"
                                                    x-on:click="$dispatch('open-confirm-modal', {
                                                        url: '{{ route('approvals.approve', $req) }}',
                                                        method: 'POST',
                                                        title: 'Setujui Pengajuan?',
                                                        message: 'Apakah Anda yakin ingin menyetujui pengajuan cuti dari {{ $req->user->name }}? {{ Auth::user()->isHrd() ? '(Kuota user akan dipotong otomatis)' : '' }}',
                                                        type: 'success'
                                                    })"
                                                    class="w-full justify-center inline-flex items-center px-4 py-2.5 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white rounded-lg font-semibold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Setujui
                                            </button>

                                            {{-- Tombol Tolak (Memicu Modal Penolakan Custom) --}}
                                            <button type="button" 
                                                    @click="openRejectModal('{{ route('approvals.reject', $req) }}')"
                                                    class="w-full justify-center inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg font-semibold text-xs uppercase tracking-widest shadow-sm hover:shadow transition-all focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Tolak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-8">
                            {{ $pendingRequests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- MODAL PENOLAKAN CUSTOM (Hidden by default) --}}
        <div x-show="rejectModalOpen" style="display: none;" class="relative z-[60]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div x-show="rejectModalOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" 
                 @click="rejectModalOpen = false"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    
                    <!-- Modal Panel -->
                    <div x-show="rejectModalOpen" 
                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200 dark:border-gray-700">
                        
                        <form method="POST" :action="rejectUrl">
                            @csrf
                            <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10 text-red-600 dark:text-red-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">Tolak Pengajuan Cuti</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                                Silakan berikan alasan mengapa Anda menolak pengajuan ini. Alasan ini akan terlihat oleh karyawan.
                                            </p>
                                            <textarea 
                                                name="rejection_note" 
                                                x-model="rejectionNote"
                                                x-ref="noteInput"
                                                rows="3" 
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="Contoh: Beban kerja tim sedang tinggi..."
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                                <button type="submit" 
                                        class="inline-flex w-full justify-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors">
                                    Tolak Pengajuan
                                </button>
                                <button type="button" 
                                        @click="rejectModalOpen = false" 
                                        class="mt-3 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>