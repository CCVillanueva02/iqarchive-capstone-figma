<flux:modal wire:model="showTimelineModal" class="max-w-3xl md:min-w-3xl no-scrollbar scrollbar-none" @close="closeTimeline">
    @if($selectedAccreditation)
    <div class="space-y-6">
        <!-- Header & Program Summary -->
        <div class="border-b border-slate-200 pb-5">
            <h2 class="text-heading font-bold text-primary-dark tracking-tight">
                {{ $selectedAccreditation->program->name }}
            </h2>
            <p class="text-body-sm text-slate-500 mt-0.5">
                Accreditation Preparation Lifecycle · Stage tracking for {{ $selectedAccreditation->program->code }}
            </p>
        </div>

        @if($selectedAccreditation->status === 'cancelled')
        <!-- Cancelled Alert Banner -->
        <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 flex items-center gap-3 text-rose-800">
            <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-body-sm text-rose-900">Accreditation Visit Cancelled</h4>
                <p class="text-label text-rose-700 mt-0.5">This accreditation visit has been halted by the IQA Office. Task force preparations are paused.</p>
            </div>
        </div>
        @endif

        <!-- Quick Summary Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-body-sm bg-surface-card p-3.5 rounded-xl border border-slate-200/80">
            <div>
                <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400 block">Assigned Task Force</span>
                <span class="font-bold text-primary-dark block mt-0.5">
                    {{ $selectedAccreditation->taskForce->name ?? 'None Nominated Yet' }}
                </span>
            </div>
            <div>
                <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400 block">Current Stage</span>
                <span class="font-bold {{ $selectedAccreditation->status === 'cancelled' ? 'text-rose-600' : 'text-brand-orange' }} block mt-0.5 capitalize">
                    {{ str_replace('_', ' ', $selectedAccreditation->status) }}
                </span>
            </div>
            <div>
                <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400 block">Completed Steps</span>
                @php
                $completedCount = collect($timelineStages)->where('status', 'completed')->count();
                $percent = round(($completedCount / 7) * 100);
                @endphp
                <span class="font-bold text-emerald-700 block mt-0.5">
                    {{ $completedCount }} of 7 Stages ({{ $percent }}%)
                </span>
            </div>
        </div>

        <!-- Timeline Steps Container -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-label font-bold text-primary-dark uppercase tracking-wider">
                    Accreditation Preparation Lifecycle
                </h4>
            </div>

            <div class="space-y-3">
                @foreach($timelineStages as $stage)
                @php
                $isLast = $loop->last;
                $isCompleted = $stage['status'] === 'completed';
                $isInProgress = $stage['status'] === 'in_progress';
                $isCancelledStage = $stage['status'] === 'cancelled';
                $isPending = $stage['status'] === 'pending';
                @endphp
                <div class="flex items-stretch gap-4">
                    <!-- Track & Node Column (Exact Center Alignment) -->
                    <div class="flex flex-col items-center shrink-0 w-7">
                        <!-- Node Circle -->
                        <div class="flex items-center justify-center w-7 h-7 rounded-full shrink-0 {{ $isCompleted ? 'bg-emerald-600 text-white shadow-xs' : ($isInProgress ? 'bg-brand-orange text-white ring-4 ring-brand-orange/20 shadow-xs animate-pulse' : ($isCancelledStage ? 'bg-rose-100 border-2 border-rose-300 text-rose-500' : 'bg-slate-100 border-2 border-slate-300 text-slate-400')) }}">
                            @if($isCompleted)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                            @elseif($isInProgress)
                            <span class="w-2.5 h-2.5 rounded-full bg-white"></span>
                            @elseif($isCancelledStage)
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                            @else
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                            @endif
                        </div>

                        <!-- Connecting Line between steps -->
                        @if(! $isLast)
                        <div class="w-0.5 flex-1 bg-slate-200 my-1"></div>
                        @endif
                    </div>

                    <!-- Step Content Card -->
                    <div class="flex-1 bg-white border rounded-xl p-4 transition-all {{ $isInProgress ? 'border-brand-orange/60 bg-amber-50/20 shadow-xs ring-1 ring-brand-orange/30' : ($isCompleted ? 'border-slate-200' : ($isCancelledStage ? 'border-rose-200/60 bg-rose-50/10 opacity-70' : 'border-slate-200/60 opacity-60')) }}">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-label-xs font-mono font-bold px-2 py-0.5 rounded {{ $isCompleted ? 'bg-emerald-100 text-emerald-800' : ($isInProgress ? 'bg-brand-orange text-white' : ($isCancelledStage ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600')) }}">
                                    Stage {{ $stage['step'] }}
                                </span>
                                <h5 class="text-body-sm font-bold {{ $isCompleted ? 'text-primary-dark' : ($isInProgress ? 'text-brand-orange-hover' : 'text-slate-700') }}">
                                    {{ $stage['title'] }}
                                </h5>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- Actor Badge -->
                                @if($stage['actor_badge'] === 'iqa')
                                <span class="text-label-xs font-semibold px-2 py-0.5 rounded-full bg-primary/10 text-primary border border-primary/20">
                                    {{ $stage['actor'] }}
                                </span>
                                @elseif($stage['actor_badge'] === 'dean')
                                <span class="text-label-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                    {{ $stage['actor'] }}
                                </span>
                                @else
                                <span class="text-label-xs font-semibold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $stage['actor'] }}
                                </span>
                                @endif

                                <!-- Status Badge -->
                                @if($isCompleted)
                                <span class="text-label-xs font-bold px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 border border-green-200">
                                    Completed
                                </span>
                                @elseif($isInProgress)
                                <span class="text-label-xs font-bold px-2.5 py-0.5 rounded-full bg-brand-orange/15 text-brand-orange border border-brand-orange/30">
                                    In Progress
                                </span>
                                @elseif($isCancelledStage)
                                <span class="text-label-xs font-semibold px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                                    Cancelled
                                </span>
                                @else
                                <span class="text-label-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200">
                                    Upcoming
                                </span>
                                @endif
                            </div>
                        </div>

                        <p class="text-body-sm text-slate-600 leading-relaxed">
                            {{ $stage['description'] }}
                        </p>

                        @if($stage['meta'] || $stage['timestamp'])
                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex flex-wrap items-center justify-between text-label-xs text-slate-500 gap-2">
                            <span class="font-medium text-primary-muted">{{ $stage['meta'] }}</span>
                            @if($stage['timestamp'])
                            <span class="font-mono text-slate-400 flex items-center gap-1">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                {{ $stage['timestamp'] }}
                            </span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-end pt-4 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeTimeline">
                {{ __('Close Timeline') }}
            </flux:button>
        </div>
    </div>
    @endif
</flux:modal>
