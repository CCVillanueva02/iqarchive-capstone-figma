{{--
    Program Accreditation Compliance Reports: Statistics Overview
    Matches Institutional Accreditation Compliance Reports summary statistics bar.
--}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
    <!-- Recommendations -->
    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4">
        <span class="text-label-xs font-bold text-zinc-500 uppercase tracking-wide block">Recommendations</span>
        <span class="text-2xl font-extrabold text-primary mt-1 block" x-text="programAreaStats(activeProgramComplianceArea).total"></span>
    </div>
    <!-- Fully complied -->
    <div class="bg-emerald-50/60 border border-emerald-100 rounded-xl p-4">
        <span class="text-label-xs font-bold text-emerald-700 uppercase tracking-wide block">Fully complied</span>
        <span class="text-2xl font-extrabold text-emerald-700 mt-1 block" x-text="programAreaStats(activeProgramComplianceArea).complied"></span>
    </div>
    <!-- Partial -->
    <div class="bg-amber-50/60 border border-amber-100 rounded-xl p-4">
        <span class="text-label-xs font-bold text-amber-700 uppercase tracking-wide block">Partial</span>
        <span class="text-2xl font-extrabold text-amber-700 mt-1 block" x-text="programAreaStats(activeProgramComplianceArea).partial"></span>
    </div>
    <!-- Not started -->
    <div class="bg-rose-50/60 border border-rose-100 rounded-xl p-4">
        <span class="text-label-xs font-bold text-rose-700 uppercase tracking-wide block">Not started</span>
        <span class="text-2xl font-extrabold text-rose-700 mt-1 block" x-text="programAreaStats(activeProgramComplianceArea).notStarted"></span>
    </div>
</div>
