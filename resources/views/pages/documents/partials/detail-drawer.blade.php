<!-- ================= SIDE DRAWERS & MODALS ================= -->
<!-- Background Overlay -->
<div x-show="showDrawer"
    x-cloak
    style="display: none;"
    @click="closeDrawer()"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-slate-900/40 backdrop-blur-[2px] z-200">
</div>

<!-- Document Preview Drawer Panel -->
<aside x-show="showDrawer"
    x-cloak
    style="display: none;"
    x-transition:enter="transition transform ease-out duration-300"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition transform ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed right-0 top-0 h-screen w-full max-w-115 bg-white shadow-2xl z-250 flex flex-col border-l border-slate-200/80 font-sans">

    <!-- Drawer Header -->
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col gap-1.5">
        <div class="flex items-start justify-between gap-3">
            <!-- Title & Status Pill -->
            <div class="flex-1 min-w-0 flex items-center gap-2.5 flex-wrap">
                <h3 class="font-extrabold text-heading-lg text-primary-dark leading-tight truncate" x-text="selectedDoc?.name || 'Document Details'"></h3>

                <!-- Status Pill -->
                <template x-if="currentUserRole === 'iqa-admin' || selectedDoc?.uploaded_by_id === currentUserId">
                    <div class="inline-flex items-center gap-1">
                        <template x-if="selectedDoc?.status === 'Verified'">
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-body-sm font-bold bg-green-100 text-green-700 border border-green-200">
                                <svg class="w-3.5 h-3.5 shrink-0 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span>Verified</span>
                            </span>
                        </template>
                        <template x-if="selectedDoc?.status === 'Pending'">
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-body-sm font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                <svg class="w-3.5 h-3.5 shrink-0 text-amber-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3" />
                                </svg>
                                <span>Pending</span>
                            </span>
                        </template>
                        <template x-if="selectedDoc?.status === 'Rejected'">
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-body-sm font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                <svg class="w-3.5 h-3.5 shrink-0 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Rejected</span>
                            </span>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Header Control Buttons (<, >, X) -->
            <div class="flex items-center gap-1.5 shrink-0">
                <button type="button"
                    @click="
                            let docs = (typeof sortedDocuments !== 'undefined' && sortedDocuments.length) ? sortedDocuments : documents;
                            let idx = docs.findIndex(d => d.name === selectedDoc?.name || d.id === selectedDoc?.id);
                            if (idx > 0) selectedDoc = docs[idx - 1];
                        "
                    class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-slate-600 transition cursor-pointer shadow-2xs"
                    title="Previous Document">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button type="button"
                    @click="
                            let docs = (typeof sortedDocuments !== 'undefined' && sortedDocuments.length) ? sortedDocuments : documents;
                            let idx = docs.findIndex(d => d.name === selectedDoc?.name || d.id === selectedDoc?.id);
                            if (idx !== -1 && idx < docs.length - 1) selectedDoc = docs[idx + 1];
                        "
                    class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-slate-600 transition cursor-pointer shadow-2xs"
                    title="Next Document">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <button type="button"
                    @click="closeDrawer()"
                    class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-slate-600 transition cursor-pointer shadow-2xs"
                    title="Close Drawer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Sub-header Metadata Line -->
        <p class="text-body-sm font-semibold text-slate-500"
            x-text="(selectedDoc?.size ? selectedDoc.size + ' · ' : '1.5 MB · ') + 'uploaded ' + (selectedDoc?.date || '2026-07-26') + ' · ' + (selectedDoc?.uploader || 'Sys Admin')">
        </p>
    </div>

    <!-- Drawer Body -->
    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6">
        <!-- Open Document Row -->
        <div class="flex items-center gap-2.5">
            <button type="button"
                @click="selectedDoc?.file_url ? window.open(selectedDoc.file_url, '_blank') : alert('No file URL available.')"
                class="flex-1 bg-primary-dark hover:bg-primary-dark-hover text-white text-body font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition shadow-xs cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span>Open document</span>
            </button>
            @if(auth()->user()->role === 'iqa-admin' || auth()->user()->hasRole('iqa-admin'))
            <button type="button"
                @click="deleteDoc(selectedDoc)"
                title="Delete document"
                class="w-11 h-11 rounded-xl border border-slate-200/80 bg-white hover:bg-rose-50 hover:border-rose-200 text-slate-500 hover:text-rose-600 flex items-center justify-center transition cursor-pointer shadow-2xs">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
            @endif
        </div>

        <!-- Original Document Preview Section -->
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-1.5 text-body-sm font-bold text-slate-400 uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span>ORIGINAL DOCUMENT PREVIEW</span>
            </div>

            <!-- Preview Viewer Card -->
            <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-2xs flex flex-col">
                <!-- Dark Viewer Canvas -->
                <div class="bg-zinc-900 p-6 flex items-center justify-center min-h-60">
                    <template x-if="selectedDoc?.file_url">
                        <iframe :src="selectedDoc.file_url + '#toolbar=0&navpanes=0&scrollbar=0&view=FitH'" class="w-full h-60 border-0 rounded"></iframe>
                    </template>
                    <template x-if="!selectedDoc?.file_url">
                        <div class="bg-white shadow-xl rounded p-6 max-w-70 w-full text-center flex flex-col gap-2 font-sans">
                            <div class="text-body-sm font-extrabold text-primary-dark" x-text="'Document: ' + (selectedDoc?.name || 'Faculty Profile')"></div>
                            <p class="text-label text-slate-500 leading-relaxed" x-text="selectedDoc?.ocrText || 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.'"></p>
                            <div class="text-label font-bold text-slate-400 mt-2 border-t border-slate-100 pt-2">Bicol University Institutional Quality Assurance Center</div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'iqa-admin' || auth()->user()->hasRole('iqa-admin'))
        <!-- Compliance Audit Review Section (IQA Admin Only) -->
        <div class="flex flex-col gap-3 pt-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">REVIEW DOCUMENT</span>
            <div class="grid grid-cols-2 gap-3">
                <button @click="approveDoc()" class="py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition shadow-2xs cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Approve and verify</span>
                </button>
                <button @click="rejectDoc()" class="py-3 px-4 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 rounded-xl font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer shadow-2xs">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-rose-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Reject document</span>
                </button>
            </div>

            <!-- Information Footer Note -->
            <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
                </svg>
                <span>Rejecting sends a notification back to the document uploader.</span>
            </div>
        </div>
        @endif
    </div>
</aside>