<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-heading-sm font-bold text-primary-dark tracking-tight flex items-center gap-2">
            <span>Action Required</span>
            @if($kpiMetrics['pendingActions'] > 0)
            <span class="text-label-xs font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                {{ $kpiMetrics['pendingActions'] }} Pending
            </span>
            @endif
        </h2>
    </div>

    @if($pendingSetupAccreditations->isEmpty() && $pendingVerificationAccreditations->isEmpty())
    <div class="bg-surface-card border border-slate-200/80 rounded-2xl p-6 text-center shadow-xs">
        <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 mx-auto flex items-center justify-center mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 class="text-body font-bold text-primary-dark">No Pending Actions</h3>
        <p class="text-body-sm text-slate-500 mt-1">All program task forces are mobilized and no compliance documents are currently awaiting Dean verification.</p>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- 1. Task Force Nominations Needed (Stage 2) -->
        @foreach($pendingSetupAccreditations as $acc)
        <div class="bg-surface-card border border-brand-orange/30 rounded-2xl p-5 shadow-xs flex flex-col justify-between relative overflow-hidden ring-1 ring-brand-orange/20">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-brand-orange"></div>
            
            <div class="space-y-3">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <span class="text-label-xs font-bold text-brand-orange uppercase tracking-wider block">
                            Stage 2 · Task Force Nomination
                        </span>
                        <h3 class="text-body font-bold text-primary-dark mt-0.5">
                            {{ $acc->program->name }}
                        </h3>
                    </div>
                    <span class="text-label-xs font-mono font-bold px-2 py-0.5 rounded bg-primary/10 text-primary shrink-0">
                        {{ $acc->program->code }}
                    </span>
                </div>

                <div class="text-body-sm text-slate-600 bg-surface-subtle p-3 rounded-xl border border-slate-200/60 space-y-1">
                    <div class="flex justify-between text-label-xs">
                        <span class="text-slate-500">Target Survey Date:</span>
                        <span class="font-bold text-primary-dark">{{ $acc->target_date ? $acc->target_date->format('M d, Y') : 'TBD' }}</span>
                    </div>
                    <div class="flex justify-between text-label-xs">
                        <span class="text-slate-500">Initiated By:</span>
                        <span class="font-medium text-slate-700">{{ $acc->creator?->name ?? 'IQA Office' }}</span>
                    </div>
                </div>

                <p class="text-body-sm text-slate-600 leading-relaxed">
                    Please propose faculty members and assign area chairs to lead the accreditation self-survey for this degree program.
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between gap-2">
                <button 
                    type="button" 
                    wire:click="openTimeline({{ $acc->id }})" 
                    class="text-label-xs font-semibold text-primary hover:text-primary-hover flex items-center gap-1 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>View Lifecycle</span>
                </button>

                <flux:button 
                    size="sm" 
                    variant="primary" 
                    wire:click="openProposeModal({{ $acc->id }})">
                    Propose Task Force
                </flux:button>
            </div>
        </div>
        @endforeach

        <!-- 2. Two-Stage Dean Verification Needed (Stage 6) -->
        @foreach($pendingVerificationAccreditations as $acc)
        <div class="bg-surface-card border border-indigo-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between relative overflow-hidden ring-1 ring-indigo-100">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
            
            <div class="space-y-3">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <span class="text-label-xs font-bold text-indigo-700 uppercase tracking-wider block">
                            Stage 6 · Two-Stage Dean Verification
                        </span>
                        <h3 class="text-body font-bold text-primary-dark mt-0.5">
                            {{ $acc->program->name }}
                        </h3>
                    </div>
                    <span class="text-label-xs font-mono font-bold px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 shrink-0">
                        {{ $acc->program->code }}
                    </span>
                </div>

                <div class="text-body-sm text-slate-600 bg-surface-subtle p-3 rounded-xl border border-slate-200/60 space-y-1">
                    <div class="flex justify-between text-label-xs">
                        <span class="text-slate-500">Mobilized Task Force:</span>
                        <span class="font-bold text-primary-dark">{{ $acc->taskForce?->name ?? 'Program Task Force' }}</span>
                    </div>
                    <div class="flex justify-between text-label-xs">
                        <span class="text-slate-500">Target Survey Date:</span>
                        <span class="font-bold text-primary-dark">{{ $acc->target_date ? $acc->target_date->format('M d, Y') : 'TBD' }}</span>
                    </div>
                </div>

                <p class="text-body-sm text-slate-600 leading-relaxed">
                    Task Force completed evidence upload. Perform Stage 1 technical check and Stage 2 completeness verification.
                </p>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between gap-2">
                <button 
                    type="button" 
                    wire:click="openTimeline({{ $acc->id }})" 
                    class="text-label-xs font-semibold text-primary hover:text-primary-hover flex items-center gap-1 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>View Lifecycle</span>
                </button>

                <flux:button 
                    size="sm" 
                    variant="primary" 
                    wire:click="openTimeline({{ $acc->id }})">
                    Start Verification
                </flux:button>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
