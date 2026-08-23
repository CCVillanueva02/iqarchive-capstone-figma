{{--
    Program Accreditation Compliance Reports: Statistics Overview
    Displays active area and overall program compliance metrics with progress bar.
--}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3.5">
    <!-- 1. Total Recommendations -->
    <div class="bg-white border border-slate-200/70 rounded-xl p-4 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label font-bold text-zinc-500 uppercase tracking-wide">Area Recommendations</span>
            <span class="w-2 h-2 rounded-full bg-primary"></span>
        </div>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-heading font-extrabold text-primary" x-text="programAreaStats(activeProgramComplianceArea).total"></span>
            <span class="text-label text-zinc-400 font-medium">Active Area</span>
        </div>
    </div>

    <!-- 2. Fully Complied -->
    <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-xl p-4 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label font-bold text-emerald-800 uppercase tracking-wide">Fully Complied</span>
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        </div>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-heading font-extrabold text-emerald-700" x-text="programAreaStats(activeProgramComplianceArea).complied"></span>
            <span class="text-label text-emerald-600 font-bold" x-text="programAreaStats(activeProgramComplianceArea).rate + '% rate'"></span>
        </div>
    </div>

    <!-- 3. Partial -->
    <div class="bg-amber-50/70 border border-amber-200/80 rounded-xl p-4 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label font-bold text-amber-800 uppercase tracking-wide">In Progress / Partial</span>
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
        </div>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-heading font-extrabold text-amber-700" x-text="programAreaStats(activeProgramComplianceArea).partial"></span>
            <span class="text-label text-amber-600 font-medium">Ongoing</span>
        </div>
    </div>

    <!-- 4. Not Started -->
    <div class="bg-rose-50/70 border border-rose-200/80 rounded-xl p-4 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label font-bold text-rose-800 uppercase tracking-wide">Not Started</span>
            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
        </div>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-heading font-extrabold text-rose-700" x-text="programAreaStats(activeProgramComplianceArea).notStarted"></span>
            <span class="text-label text-rose-500 font-medium">Action Required</span>
        </div>
    </div>
</div>
