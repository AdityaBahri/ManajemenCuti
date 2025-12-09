<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ __('Persetujuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Messages --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm">
                    {{ $errors->first() }}
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
                                            <form action="{{ route('approvals.approve', $req) }}" method="POST" class="w-full">
                                                @csrf
                                                <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2.5 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white rounded-lg font-semibold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="return confirm('Setujui pengajuan ini? {{ Auth::user()->isHrd() ? '(Kuota user akan dipotong otomatis)' : '' }}')">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Setujui
                                                </button>
                                            </form>

                                            <button type="button" onclick="openRejectModal({{ $req->id }})" class="w-full justify-center inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg font-semibold text-xs uppercase tracking-widest shadow-sm hover:shadow transition-all focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
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
    </div>

    {{-- Script Modal Reject --}}
    <script>
        function openRejectModal(id) {
            const reason = prompt("Masukkan alasan penolakan (Wajib):");
            if (reason !== null) {
                if (reason.trim().length < 5) {
                    alert("Alasan penolakan minimal 5 karakter.");
                    return;
                }
                
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/approvals/${id}/reject`; // Pastikan path URL sesuai dengan route yang ada
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                
                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'rejection_note';
                reasonInput.value = reason;

                form.appendChild(csrfInput);
                form.appendChild(reasonInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>