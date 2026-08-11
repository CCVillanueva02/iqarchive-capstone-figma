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
                    <h3 class="text-base font-bold text-[#1b355a]">Self-Survey Documents</h3>
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
                    <h3 class="text-base font-bold text-[#1b355a]">Compliance Reports</h3>
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
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <x-lucide-files class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#1b355a]">Supporting Documents</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                        Checklist criteria link inputs for inputs (Systems), implementation details, outcomes, and best practices.
                    </p>
                </div>
            </div>
            <button type="button" @click="accredCategory = 'Supporting Documents'" class="w-full bg-[#1b355a] hover:bg-[#112239] text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                Open Supporting Docs
            </button>
        </div>
    </div>
</div>
