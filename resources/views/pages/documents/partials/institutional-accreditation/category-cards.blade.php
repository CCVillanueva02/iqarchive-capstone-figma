<!-- LEVEL 1: INSTITUTIONAL ACCREDITATION SUB-CATEGORY SELECT -->
<div x-show="accredCategory === null" x-transition class="flex flex-col gap-5 w-full py-2">
    <!-- Sub-Category Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
        <!-- Self-Survey Documents Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <x-lucide-clipboard-check class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Self-Survey Documents</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                        Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.
                    </p>
                </div>
            </div>
            <button type="button" @click="accredCategory = 'Self-Survey Documents'" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                Open Self-Survey
            </button>
        </div>

        <!-- Compliance Reports Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <x-lucide-file-badge class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Compliance Reports</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                        Official compliance logs, AACCUP evaluations, corrective action reports, and certificates of accreditation.
                    </p>
                </div>
            </div>
            <button type="button" @click="accredCategory = 'Compliance Reports'" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                Open Reports
            </button>
        </div>

        <!-- Supporting Documents Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-surface-subtle text-primary flex items-center justify-center">
                    <x-lucide-files class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Supporting Documents</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        Checklist criteria link inputs for inputs (Systems), implementation details, outcomes, and best practices.
                    </p>
                </div>
            </div>
            <button type="button" @click="accredCategory = 'Supporting Documents'" class="w-full bg-primary hover:bg-primary-dark-hover text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                Open Supporting Docs
            </button>
        </div>

        <!-- Narrative Profile Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                    <x-lucide-notebook-pen class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Narrative Profile</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        AACCUP Level 3 narrative profile templates organized by area with direct in-app editing and formatting.
                    </p>
                </div>
            </div>
            <button type="button" @click="accredCategory = 'Narrative Profile'; initNarrativeProfile()" class="w-full bg-violet-600 hover:bg-violet-700 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                Open Narrative Profile
            </button>
        </div>

        <!-- Performance Portfolio (PPP) Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <x-lucide-layout-panel-top class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Performance Portfolio (PPP)</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        Institutional performance evidence portfolios and documentation templates organized by area for in-app compilation.
                    </p>
                </div>
            </div>
            <button type="button" @click="accredCategory = 'PPP'; initPPP()" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                Open PPP
            </button>
        </div>
    </div>
</div>
