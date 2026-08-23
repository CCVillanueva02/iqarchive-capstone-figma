{{--
    Program Accreditation Compliance Reports: AACCUP Certificates & Audits Modal
    Displays official accreditation certificates, external survey technical reports, and compliance validation orders.
--}}
<div x-show="programCertificatesModalOpen"
     x-cloak
     @keydown.escape.window="programCertificatesModalOpen = false"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <div @click.outside="programCertificatesModalOpen = false"
         class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 max-w-2xl w-full flex flex-col max-h-[85vh] overflow-hidden"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">

        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shrink-0">
                    <x-lucide-award class="w-5 h-5 text-emerald-600" />
                </div>
                <div>
                    <h3 class="text-heading-sm font-extrabold text-primary">AACCUP Certificates & Audits</h3>
                    <p class="text-label text-zinc-500 mt-0.5" x-text="accredProgram ? ('Official accreditation records for ' + accredProgram.name) : 'Accreditation records'"></p>
                </div>
            </div>
            <button type="button"
                    @click="programCertificatesModalOpen = false"
                    class="p-2 rounded-xl text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <!-- Modal Body: Scrollable Certificates Content -->
        <div class="p-6 overflow-y-auto flex flex-col gap-5 custom-scrollbar">
            <!-- Program Status Callout Banner -->
            <div class="bg-gradient-to-r from-primary to-primary-hover rounded-2xl p-5 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-3xs">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-white shrink-0">
                        <x-lucide-shield-check class="w-6 h-6" />
                    </div>
                    <div>
                        <span class="text-label-xs font-bold text-slate-200 uppercase tracking-widest block">Current Accreditation Standing</span>
                        <h4 class="text-heading-sm font-extrabold text-white mt-0.5" x-text="accredProgram?.level || 'Level III Re-accredited'"></h4>
                        <span class="text-label text-slate-300 block mt-0.5" x-text="accredProgram?.name"></span>
                    </div>
                </div>
                <div class="bg-white/15 px-3.5 py-2 rounded-xl border border-white/20 text-right shrink-0">
                    <span class="text-label-xs text-slate-300 font-bold uppercase tracking-wider block">Accrediting Agency</span>
                    <span class="text-body-sm font-extrabold text-white block">AACCUP, Inc.</span>
                </div>
            </div>

            <!-- Certificates & Documents Grid -->
            <div class="flex flex-col gap-3.5">
                <span class="text-label font-bold text-zinc-400 uppercase tracking-wider">Official Documentation & Certificates</span>

                <template x-for="cert in programCertificates" :key="cert.id">
                    <div class="bg-white border border-slate-200/80 rounded-xl p-4.5 shadow-3xs hover:border-primary/40 transition flex flex-col gap-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <x-lucide-file-text class="w-5 h-5 text-rose-600" />
                                </div>
                                <div class="min-w-0">
                                    <h5 class="text-body font-bold text-primary leading-snug" x-text="cert.title"></h5>
                                    <div class="flex flex-wrap items-center gap-2 mt-1">
                                        <span class="text-label-xs font-bold px-2 py-0.5 rounded bg-slate-100 text-zinc-600" x-text="cert.type"></span>
                                        <span class="text-label-xs text-zinc-400" x-text="cert.validity"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-label-xs font-extrabold bg-green-100 text-green-700 border border-green-200 shrink-0"
                                  x-text="cert.status"></span>
                        </div>

                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-body-sm">
                            <div class="text-label text-zinc-500 min-w-0 truncate">
                                <span class="font-bold text-zinc-700" x-text="cert.issuer"></span>
                                <span x-show="cert.boardResolution" class="text-zinc-400" x-text="' • ' + cert.boardResolution"></span>
                            </div>
                            <button type="button"
                                    @click="openDoc({ name: cert.filename, type: 'PDF', size: cert.fileSize, date: '2024-12-16', status: 'Verified', uploader: 'IQA Director', office: 'IQA Central Office' })"
                                    class="text-body-sm font-bold text-primary hover:underline cursor-pointer flex items-center gap-1.5 shrink-0 ml-2">
                                <x-lucide-external-link class="w-4 h-4" />
                                <span>Preview Exhibit</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
            <button type="button"
                    @click="programCertificatesModalOpen = false"
                    class="px-5 py-2.5 bg-primary hover:bg-primary-hover text-white font-bold text-body-sm rounded-xl transition cursor-pointer shadow-3xs">
                Close
            </button>
        </div>
    </div>
</div>
