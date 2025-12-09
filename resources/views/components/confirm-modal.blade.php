<div x-data="{ 
    show: false, 
    title: '', 
    message: '', 
    url: '', 
    method: 'DELETE',
    type: 'danger', {{-- danger (merah), success (hijau), warning (kuning) --}}
    
    open(event) {
        this.show = true;
        this.title = event.detail.title;
        this.message = event.detail.message;
        this.url = event.detail.url;
        this.method = event.detail.method || 'DELETE';
        this.type = event.detail.type || 'danger';
    },
    
    close() {
        this.show = false;
    },

    submit() {
        {{-- Buat form dinamis untuk submit --}}
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = this.url;
        
        const csrfToken = document.querySelector('meta[name=\'csrf-token\']').getAttribute('content');
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = this.method;
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
}"
@open-confirm-modal.window="open($event)"
x-show="show"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">

    {{-- Backdrop Gelap --}}
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" @click="close()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            
            {{-- Panel Modal --}}
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200 dark:border-gray-700">
                
                <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        
                        {{-- Icon Dinamis Berdasarkan Tipe --}}
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10"
                             :class="{
                                'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400': type === 'danger',
                                'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400': type === 'success',
                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400': type === 'warning'
                             }">
                            
                            {{-- Icon Danger (Sampah/Peringatan) --}}
                            <svg x-show="type === 'danger'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>

                            {{-- Icon Success (Ceklis) --}}
                            <svg x-show="type === 'success'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>

                            {{-- Icon Warning (Tanda Tanya/Info) --}}
                            <svg x-show="type === 'warning'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                        </div>

                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-white" id="modal-title" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400" x-text="message"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Tombol --}}
                <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="button" 
                            @click="submit()"
                            class="inline-flex w-full justify-center rounded-lg px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto transition-colors"
                            :class="{
                                'bg-red-600 hover:bg-red-500': type === 'danger',
                                'bg-green-600 hover:bg-green-500': type === 'success',
                                'bg-yellow-600 hover:bg-yellow-500': type === 'warning'
                            }">
                        Ya, Lanjutkan
                    </button>
                    <button type="button" 
                            @click="close()"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>