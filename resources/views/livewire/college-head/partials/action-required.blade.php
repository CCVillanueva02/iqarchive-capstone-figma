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
                <div>
                    <span class="text-label-xs font-bold text-brand-orange uppercase tracking-wider block">
                        Stage 2 · Task Force Nomination
                    </span>
                    <h3 class="text-body font-bold text-primary-dark mt-0.5">
                        {{ $acc->program->name }}
                    </h3>
                </div>

                <p class="text-body-sm text-slate-600 leading-relaxed">
                    Please assign task force to this degree program's upcoming accreditation.
                </p>

                <!-- Clean Metadata Chips -->
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-label-xs text-slate-500 pt-2 border-t border-slate-100">
                    <div class="flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-brand-orange shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Target: <strong class="text-primary-dark font-bold">{{ $acc->target_date ? $acc->target_date->format('M d, Y') : 'TBD' }}</strong></span>
                    </div>
                    <div class="flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Initiated by <strong class="text-slate-700 font-semibold">{{ $acc->creator?->name ?? 'IQA Office' }}</strong></span>
                    </div>
                </div>
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

                <button 
                    type="button" 
                    wire:click="openProposeModal({{ $acc->id }})"
                    class="px-3.5 py-2 rounded-xl text-body-sm font-bold bg-brand-orange hover:bg-brand-orange-hover text-white transition-colors flex items-center gap-1.5 cursor-pointer shadow-xs">
                    <span>Assign Task Force</span>
                </button>
            </div>
        </div>
        @endforeach

        <!-- 2. Two-Stage Dean Verification Needed (Stage 6) -->
        @foreach($pendingVerificationAccreditations as $acc)
        <div class="bg-surface-card border border-indigo-200 rounded-2xl p-5 shadow-xs flex flex-col justify-between relative overflow-hidden ring-1 ring-indigo-100">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
            
            <div class="space-y-3">
                <div>
                    <span class="text-label-xs font-bold text-indigo-700 uppercase tracking-wider block">
                        Stage 6 · Two-Stage Dean Verification
                    </span>
                    <h3 class="text-body font-bold text-primary-dark mt-0.5">
                        {{ $acc->program->name }}
                    </h3>
                </div>

                <p class="text-body-sm text-slate-600 leading-relaxed">
                    Task Force completed evidence upload. Perform Stage 1 technical check and Stage 2 completeness verification.
                </p>

                <!-- Clean Metadata Chips -->
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-label-xs text-slate-500 pt-2 border-t border-slate-100">
                    <div class="flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Team: <strong class="text-primary-dark font-bold">{{ $acc->taskForce?->name ?? 'Program Task Force' }}</strong></span>
                    </div>
                    <div class="flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Target: <strong class="text-slate-700 font-semibold">{{ $acc->target_date ? $acc->target_date->format('M d, Y') : 'TBD' }}</strong></span>
                    </div>
                </div>
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

                <button 
                    type="button" 
                    wire:click="openTimeline({{ $acc->id }})"
                    class="px-3.5 py-2 rounded-xl text-body-sm font-bold bg-primary hover:bg-primary-hover text-white transition-colors flex items-center gap-1.5 cursor-pointer shadow-xs">
                    <span>Start Verification</span>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
