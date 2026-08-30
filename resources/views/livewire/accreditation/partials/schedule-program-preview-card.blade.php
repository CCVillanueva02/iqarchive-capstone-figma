@if($selectedProgram)
<div class="bg-surface-card border border-slate-200/90 rounded-2xl p-4 shadow-2xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/80">
        <div class="flex items-center gap-2.5">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-label-xs font-bold bg-primary/10 text-primary border border-primary/20 shrink-0">
                @if($selectedProgram->college)
                    <img src="{{ $selectedProgram->college->logo }}" alt="Logo" class="w-4 h-4 object-contain shrink-0" onerror="this.style.display='none'">
                @endif
                {{ $selectedProgram->college->code ?? 'N/A' }}
            </span>
            <div>
                <h4 class="text-body font-bold text-primary-dark leading-tight">
                    {{ $selectedProgram->name }}
                </h4>
                <p class="text-label-xs text-primary-muted font-mono mt-0.5">
                    {{ $selectedProgram->code }} &bull; {{ $selectedProgram->college->name ?? '' }}
                </p>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3">
        <!-- Campus Designation -->
        <div class="bg-white p-3 rounded-xl border border-slate-200/70">
            <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400 block">Campus</span>
            <span class="text-body-sm font-bold text-slate-800 block mt-0.5">
                {{ $selectedProgram->college->campus ?? 'Main Campus' }}
            </span>
        </div>

        <!-- Current Accreditation Status -->
        <div class="bg-white p-3 rounded-xl border border-slate-200/70">
            <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400 block">Current Standing</span>
            <span class="text-body-sm font-bold text-slate-800 block mt-0.5">
                {{ $selectedProgram->accreditation_level ?: 'Candidate Status' }}
            </span>
        </div>

        <!-- College Dean / Dept Head -->
        <div class="bg-white p-3 rounded-xl border border-slate-200/70">
            <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400 block">College Dean</span>
            @if($selectedCollegeDean)
            <div class="flex items-center gap-1.5 mt-0.5">
                <span class="text-body-sm font-bold text-primary-dark truncate">
                    {{ $selectedCollegeDean->name }}
                </span>
            </div>
            @else
            <span class="text-body-sm text-slate-400 italic block mt-0.5">
                Pending Dean Setup
            </span>
            @endif
        </div>
    </div>
</div>
@endif
