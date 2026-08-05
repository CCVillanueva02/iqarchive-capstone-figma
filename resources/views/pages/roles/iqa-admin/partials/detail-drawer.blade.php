<!-- ================= SIDE DRAWERS & MODALS ================= -->
<!-- Background Overlay -->
<div x-show="showDrawer" 
     @click="closeDrawer()" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/40 backdrop-blur-[2px] z-[200]">
</div>

<!-- Document Preview Drawer Panel -->
<aside x-show="showDrawer"
       x-transition:enter="transition transform ease-out duration-300"
       x-transition:enter-start="translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition transform ease-in duration-200"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="translate-x-full"
       class="fixed right-0 top-0 h-screen w-full max-w-[420px] bg-white shadow-2xl z-[250] flex flex-col border-l border-slate-100">
    
    <!-- Drawer Header -->
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <div class="flex-1 min-w-0 pr-4">
            <h3 class="font-bold text-base text-[#1b355a] leading-snug truncate" x-text="selectedDoc.name"></h3>
            <div class="flex items-center gap-1.5 mt-1 text-xs text-zinc-400 font-semibold uppercase tracking-wide">
                <span x-text="'Size: ' + selectedDoc.size"></span>
                <span>&bull;</span>
                <span x-text="'Uploaded: ' + selectedDoc.date"></span>
            </div>
        </div>
        <button @click="closeDrawer()" class="p-1.5 rounded-lg hover:bg-slate-100 text-zinc-400 hover:text-zinc-650 transition cursor-pointer shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Drawer Body -->
    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-5">
        <!-- Metadata & Open Document Card -->
        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl flex flex-col gap-3">
            <div class="text-sm text-zinc-500 flex flex-col gap-1.5">
                <div><span class="font-bold text-[#1b355a]">Uploader:</span> <span x-text="selectedDoc.uploader"></span></div>
                <div><span class="font-bold text-[#1b355a]">Lead Office:</span> <span x-text="selectedDoc.office"></span></div>
            </div>
            <!-- Open Document + Delete Row -->
            <div class="flex gap-2">
                <button type="button" class="flex-1 bg-[#f27224] hover:bg-[#d65f1a] text-white text-sm font-bold py-2.5 rounded-lg flex items-center justify-center gap-1.5 transition shadow-3xs cursor-pointer" @click="selectedDoc.file_url ? window.open(selectedDoc.file_url, '_blank') : alert('No file URL available.')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    Open Document
                </button>
                <button type="button" title="Delete document" class="shrink-0 w-10 h-10 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 rounded-lg flex items-center justify-center transition cursor-pointer" @click="deleteDoc(selectedDoc)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Document Preview -->
        <div class="flex-1 flex flex-col min-h-[300px]">
            <div class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">📄 Original Document Preview</div>
            <div class="flex-1 bg-[#fafbfc] border border-slate-100 rounded-xl overflow-hidden" style="min-height: 300px;">
                <iframe
                    x-bind:src="selectedDoc.file_url ? selectedDoc.file_url + '#toolbar=0&navpanes=0&scrollbar=0&view=FitH' : ''"
                    class="w-full h-full"
                    style="min-height: 300px; border: none;"
                    x-show="selectedDoc.file_url"
                ></iframe>
                <div x-show="!selectedDoc.file_url" class="flex items-center justify-center h-full text-zinc-400 text-sm p-4">
                    No preview available.
                </div>
            </div>
        </div>

        <!-- Validation Action Buttons -->
        <div class="flex flex-col gap-2 pt-4 border-t border-slate-100">
            <span class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Compliance Audit Review</span>
            <div class="grid grid-cols-2 gap-2">
                <button @click="approveDoc()" class="py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-sm flex items-center justify-center gap-1.5 transition shadow-sm cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Approve & Verify
                </button>
                <button @click="flagDoc()" class="py-2.5 px-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-sm flex items-center justify-center gap-1.5 transition border border-rose-100 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Flag for Revision
                </button>
            </div>
        </div>
    </div>
</aside>
