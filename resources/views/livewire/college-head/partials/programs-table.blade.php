<div class="bg-surface-card border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-brand-orange animate-pulse"></span>
                <h2 class="text-heading-sm font-bold text-primary-dark tracking-tight">
                    College Degree Programs & Accreditation Status
                </h2>
            </div>
            <p class="text-body-sm text-slate-500 mt-0.5">
                Programs currently undergoing an official accreditation visit or survey preparation.
            </p>
        </div>

        <div class="w-full sm:w-72">
            <flux:input 
                wire:model.live.debounce.300ms="searchProgram" 
                placeholder="Search active cycles..." 
                size="sm"
                icon="magnifying-glass"
            />
        </div>
    </div>

    <!-- Active Accreditation Cycles Table -->
    <div class="overflow-x-auto rounded-xl border border-slate-200/80 bg-white">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-subtle border-b border-slate-200/80 text-label-xs font-bold uppercase tracking-wider text-slate-500">
                    <th class="py-3 px-4">Program & Code</th>
                    <th class="py-3 px-4">Current Standing</th>
                    <th class="py-3 px-4">Active Cycle Status</th>
                    <th class="py-3 px-4">Assigned Task Force</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-body-sm">
                @forelse($activeAccreditationPrograms as $prog)
                @php
                    $latestAcc = $prog->accreditations->first();
                @endphp
                <tr wire:key="active-acc-prog-{{ $prog->id }}" class="hover:bg-slate-50/70 transition-colors">
                    <td class="py-3.5 px-4">
                        <div class="font-bold text-primary-dark">{{ $prog->name }}</div>
                        <div class="text-label-xs font-mono text-slate-500 mt-0.5">{{ $prog->code }}</div>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-semibold {{ str_contains(strtolower($prog->accreditation_level ?? ''), 'level') ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                            {{ $prog->accreditation_level ?? 'Candidate Status' }}
                        </span>
                    </td>
                    <td class="py-3.5 px-4">
                        @if($latestAcc)
                            @if($latestAcc->status === 'scheduled')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-brand-orange/10 text-brand-orange border border-brand-orange/25">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-orange animate-pulse"></span>
                                Scheduled (Stage 2)
                            </span>
                            @elseif($latestAcc->status === 'task_force_setup')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                IQA Review (Stage 3)
                            </span>
                            @elseif($latestAcc->status === 'dean_verification')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                Dean Verification (Stage 6)
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-semibold bg-primary/10 text-primary border border-primary/20 capitalize">
                                {{ str_replace('_', ' ', $latestAcc->status) }}
                            </span>
                            @endif
                            
                            @if($latestAcc->target_date)
                            <div class="text-label-xs text-slate-400 mt-1">
                                Target: {{ $latestAcc->target_date->format('M d, Y') }}
                            </div>
                            @endif
                        @else
                            <span class="text-label-xs text-slate-400 italic">No Active Survey</span>
                        @endif
                    </td>
                    <td class="py-3.5 px-4">
                        @if($latestAcc?->taskForce)
                            <span class="font-medium text-slate-800">{{ $latestAcc->taskForce->name }}</span>
                        @elseif($latestAcc && $latestAcc->status === 'scheduled')
                            <span class="text-label-xs font-semibold text-brand-orange">Nomination Required</span>
                        @else
                            <span class="text-label-xs text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="py-3.5 px-4 text-right">
                        @if($latestAcc)
                        <button 
                            type="button" 
                            wire:click="openTimeline({{ $latestAcc->id }})"
                            class="px-3 py-1.5 rounded-lg text-label-xs font-bold bg-primary hover:bg-primary-hover text-white transition-colors cursor-pointer shadow-xs">
                            View Timeline
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-500 text-body-sm">
                        <div class="max-w-md mx-auto space-y-1">
                            <p class="font-semibold text-slate-700">No Active Accreditation Cycles</p>
                            <p class="text-label-xs text-slate-400">There are currently no degree programs under this college scheduled for an ongoing survey preparation.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
