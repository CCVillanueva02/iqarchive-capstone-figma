{{--
    Program Accreditation Compliance Reports: Context Header
    Displays current program context, level badge, and triggers for program switching & certificate modal.
--}}
<template x-if="accredProgram !== null">
    <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5 min-w-0">
            <div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center font-extrabold text-body shrink-0 shadow-3xs">
                <span x-text="accredProgram.code"></span>
            </div>
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-heading-sm font-extrabold text-primary truncate" x-text="accredProgram.name"></h2>
                    <span class="px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-primary/10 text-primary border border-primary/20"
                          x-text="accredProgram.level || 'Level III Accredited'"></span>
                </div>
                <p class="text-body-sm text-zinc-500 mt-0.5 truncate" x-text="accredProgram.college"></p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <!-- View Official AACCUP Certificates Button -->
            <button type="button"
                    @click="programCertificatesModalOpen = true"
                    class="px-4 py-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-700 font-bold text-body-sm rounded-xl transition cursor-pointer flex items-center gap-2 shadow-3xs">
                <x-lucide-file-badge class="w-4 h-4 text-emerald-600" />
                <span>AACCUP Certificates & Audits</span>
            </button>

            <!-- Switch Program Button -->
            <button x-show="isUnrestricted || filteredPrograms.length > 1"
                    type="button"
                    @click="clearProgram()"
                    class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 border border-slate-200/60 text-zinc-700 font-bold text-body-sm rounded-xl transition cursor-pointer flex items-center gap-1.5 shadow-3xs">
                <x-lucide-arrow-left-right class="w-3.5 h-3.5 text-zinc-500" />
                <span>Switch Program</span>
            </button>
        </div>
    </div>
</template>
