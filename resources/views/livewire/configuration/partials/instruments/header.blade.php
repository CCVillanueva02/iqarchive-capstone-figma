<div class="flex flex-col gap-4 pb-3 border-b border-slate-200">
    <!-- Top Row: Title, Scope Toggle, and Action Buttons -->
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-heading font-extrabold text-primary tracking-tight">Accreditation Instruments Builder</h1>
                @if ($selectedProgram)
                <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 border border-emerald-200 text-label-xs font-bold uppercase tracking-wider flex items-center gap-1">
                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>Program: {{ $selectedProgram->code }}</span>
                </span>
                @else
                <span class="px-2.5 py-0.5 rounded-md bg-surface-subtle text-primary-dark border border-primary/15 text-label-xs font-bold uppercase tracking-wider flex items-center gap-1">
                    <span>Master Template Baseline</span>
                </span>
                @endif
            </div>
            <p class="text-body-sm text-zinc-500 mt-1">
                {{ $selectedProgram 
                    ? "Inspecting program-tailored instrument criteria and #EvidenceTags for {$selectedProgram->name}." 
                    : "Viewing university-wide Master Baseline standards. Select a specific degree program below to customize its requirements." }}
            </p>
        </div>

        <!-- Scope Separator Toggle: Program vs Institutional -->
        <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl border border-slate-200 shrink-0">
            <button type="button"
                wire:click="switchScope('program')"
                class="px-3.5 py-1.5 rounded-lg text-body-sm font-bold transition-all cursor-pointer flex items-center gap-2 {{ $accreditationScope === 'program' ? 'bg-white text-primary shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
                <span>Program Accreditation</span>
            </button>

            <button type="button"
                wire:click="switchScope('institutional')"
                class="px-3.5 py-1.5 rounded-lg text-body-sm font-bold transition-all cursor-pointer flex items-center gap-2 {{ $accreditationScope === 'institutional' ? 'bg-white text-primary shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span>Institutional Accreditation</span>
            </button>
        </div>
    </div>

    <!-- Second Row: Program Search & Action Controls -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-1">
        <!-- Program Search & Inspection Selector (Program Scope only) -->
        <div class="flex-1 max-w-xl">
            @if ($accreditationScope === 'program')
            <div class="flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none flex items-center text-slate-400">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <select wire:change="selectProgram($event.target.value)" 
                        class="w-full pl-9 pr-8 py-2 bg-white border {{ $selectedProgramId ? 'border-emerald-300 ring-1 ring-emerald-200' : 'border-slate-300' }} rounded-lg text-body-sm font-semibold text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-2xs transition cursor-pointer">
                        <option value="" {{ !$selectedProgramId ? 'selected' : '' }}>Master Template Baseline (Default)</option>
                        @foreach ($colleges as $college)
                            @if ($college->programs->isNotEmpty())
                            <optgroup label="{{ $college->name }} ({{ $college->code }})">
                                @foreach ($college->programs as $program)
                                <option value="{{ $program->id }}" {{ $selectedProgramId == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }} ({{ $program->code }})
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                        @endforeach
                    </select>
                </div>

                @if ($selectedProgramId)
                <button type="button"
                    wire:click="clearProgramFilter"
                    title="Reset to Master Template Baseline"
                    class="px-3 py-2 rounded-lg border border-slate-300 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-body-sm transition cursor-pointer flex items-center gap-1.5 shrink-0 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>Master Template</span>
                </button>
                @endif
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2.5 shrink-0">
            @if ($selectedInstrument)
            <button type="button"
                wire:click="openCloneModal({{ $selectedInstrument->id }})"
                class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-primary font-semibold text-body-sm shadow-2xs transition cursor-pointer">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span>Duplicate Instrument</span>
            </button>
            @endif

            <button type="button"
                wire:click="openCreateTemplateModal"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white font-semibold text-body-sm shadow-2xs transition cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Template</span>
            </button>
        </div>
    </div>
</div>
