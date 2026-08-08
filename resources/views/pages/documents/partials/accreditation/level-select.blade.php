<!-- LEVEL 1: ACCREDITATION LEVEL SELECT -->
<div x-show="accredLevel === null" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto w-full py-6">
    <!-- Program Accreditation Card -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col items-center text-center gap-4">
        <div class="w-16 h-16 rounded-full bg-blue-50 text-[#1b355a] flex items-center justify-center">
            <x-lucide-graduation-cap class="w-8 h-8" />
        </div>
        <div>
            <h3 class="text-lg font-bold text-[#1b355a]">Program Accreditation</h3>
            <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                Evaluate specific degree programs for academic quality, faculty portfolio, and student facilities.
            </p>
        </div>
        <button type="button" @click="accredLevel = 'program'; accredCollege = null; accredProgram = null; accredCategory = null" class="w-full mt-2 bg-[#1b355a] hover:bg-[#112239] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
            Select College
        </button>
    </div>

    <!-- Institutional Accreditation Card -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col items-center text-center gap-4">
        <div class="w-16 h-16 rounded-full bg-orange-50 text-[#f27224] flex items-center justify-center">
            <x-lucide-landmark class="w-8 h-8" />
        </div>
        <div>
            <h3 class="text-lg font-bold text-[#1b355a]">Institutional Accreditation</h3>
            <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                Evaluate university-wide administration, leadership, fiscal soundness, and governance structure.
            </p>
        </div>
        <button type="button" @click="accredLevel = 'institutional'; accredCollege = null; accredProgram = null; accredCategory = null" class="w-full mt-2 bg-[#f27224] hover:bg-[#d65f1a] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
            Select Institutional
        </button>
    </div>
</div>
