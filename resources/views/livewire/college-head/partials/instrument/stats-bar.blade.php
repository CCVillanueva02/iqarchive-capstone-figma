<!-- 3 Core Instrument Categories (Supporting Documents, Self-Survey, Compliance Reports) -->
<div class="flex flex-col gap-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- 1. Supporting Documents Tab -->
        <button type="button"
            wire:click="switchCategory('supporting-docs')"
            class="p-4 rounded-xl border text-left transition-all cursor-pointer flex items-center justify-between gap-4 {{ $activeCategory === 'supporting-docs' ? 'bg-white border-primary shadow-xs ring-2 ring-primary/20' : 'bg-white/80 hover:bg-white border-slate-200/80 hover:border-slate-300' }}">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 {{ $activeCategory === 'supporting-docs' ? 'bg-primary text-white' : 'bg-surface-subtle text-primary' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-label-xs font-bold uppercase tracking-wider {{ $activeCategory === 'supporting-docs' ? 'text-primary' : 'text-primary-muted' }}">
                        Instrument 01
                    </span>
                    <span class="text-heading-sm font-bold text-primary truncate">
                        Supporting Documents
                    </span>
                    <span class="text-label-xs text-zinc-500 truncate mt-0.5">
                        Areas I–X Benchmark Criteria &amp; #Tags
                    </span>
                </div>
            </div>
            @if ($activeCategory === 'supporting-docs')
                <div class="w-2.5 h-2.5 rounded-full bg-primary shrink-0 animate-pulse"></div>
            @endif
        </button>

        <!-- 2. Self-Survey Tab -->
        <button type="button"
            wire:click="switchCategory('self-survey')"
            class="p-4 rounded-xl border text-left transition-all cursor-pointer flex items-center justify-between gap-4 {{ $activeCategory === 'self-survey' ? 'bg-white border-emerald-600 shadow-xs ring-2 ring-emerald-500/20' : 'bg-white/80 hover:bg-white border-slate-200/80 hover:border-slate-300' }}">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 {{ $activeCategory === 'self-survey' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-label-xs font-bold uppercase tracking-wider {{ $activeCategory === 'self-survey' ? 'text-emerald-700' : 'text-primary-muted' }}">
                        Instrument 02
                    </span>
                    <span class="text-heading-sm font-bold text-primary truncate">
                        Self-Survey
                    </span>
                    <span class="text-label-xs text-zinc-500 truncate mt-0.5">
                        Numerical Ratings &amp; Diagnostic Rubrics
                    </span>
                </div>
            </div>
            @if ($activeCategory === 'self-survey')
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-600 shrink-0 animate-pulse"></div>
            @endif
        </button>

        <!-- 3. Compliance Reports Tab -->
        <button type="button"
            wire:click="switchCategory('compliance-reports')"
            class="p-4 rounded-xl border text-left transition-all cursor-pointer flex items-center justify-between gap-4 {{ $activeCategory === 'compliance-reports' ? 'bg-white border-brand-orange shadow-xs ring-2 ring-brand-orange/20' : 'bg-white/80 hover:bg-white border-slate-200/80 hover:border-slate-300' }}">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 {{ $activeCategory === 'compliance-reports' ? 'bg-brand-orange text-white' : 'bg-brand-orange/10 text-brand-orange' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-label-xs font-bold uppercase tracking-wider {{ $activeCategory === 'compliance-reports' ? 'text-brand-orange' : 'text-primary-muted' }}">
                        Instrument 03
                    </span>
                    <span class="text-heading-sm font-bold text-primary truncate">
                        Compliance Report
                    </span>
                    <span class="text-label-xs text-zinc-500 truncate mt-0.5">
                        Recommendations &amp; Corrective Actions
                    </span>
                </div>
            </div>
            @if ($activeCategory === 'compliance-reports')
                <div class="w-2.5 h-2.5 rounded-full bg-brand-orange shrink-0 animate-pulse"></div>
            @endif
        </button>
    </div>

    <!-- Active Template Info Context Bar -->
    @if ($selectedInstrument)
    @php
        $totalAreas = $selectedInstrument->areas->count();
        $totalParameters = $selectedInstrument->areas->sum(fn($a) => $a->parameters->count());
        $totalCriteria = $selectedInstrument->areas->sum(fn($a) => $a->parameters->sum(fn($p) => $p->criteria->count()));
    @endphp
    <div class="bg-white border border-slate-200/80 rounded-xl px-5 py-3 shadow-3xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="px-2.5 py-0.5 rounded-md text-label-xs font-extrabold uppercase tracking-wider bg-emerald-100 text-emerald-800">
                {{ $accreditation->program->code }} Custom
            </span>
            <span class="text-body-sm font-bold text-primary">
                {{ $selectedInstrument->name }}
            </span>
            <span class="text-label-xs text-zinc-400 font-mono hidden md:inline">
                ({{ $selectedInstrument->code }})
            </span>
        </div>

        <div class="flex items-center gap-4 text-body-sm font-semibold text-slate-600 shrink-0">
            <div class="flex items-center gap-1.5">
                <span class="font-extrabold text-primary">{{ $totalAreas }}</span>
                <span class="text-zinc-500 text-body-sm">Areas</span>
            </div>
            <span class="text-zinc-300">&bull;</span>
            <div class="flex items-center gap-1.5">
                <span class="font-extrabold text-primary">{{ $totalParameters }}</span>
                <span class="text-zinc-500 text-body-sm">Parameters</span>
            </div>
            <span class="text-zinc-300">&bull;</span>
            <div class="flex items-center gap-1.5">
                <span class="font-extrabold text-primary">{{ $totalCriteria }}</span>
                <span class="text-zinc-500 text-body-sm">Criteria Statements</span>
            </div>
        </div>
    </div>
    @endif
</div>
