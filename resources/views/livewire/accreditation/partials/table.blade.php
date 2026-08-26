<div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-body-sm whitespace-nowrap">
            <thead class="bg-slate-50 text-slate-500 text-label uppercase tracking-wider font-semibold border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">College &amp; Program</th>
                    <th class="px-6 py-4">Initiated Date</th>
                    <th class="px-6 py-4">Target Visit Date</th>
                    <th class="px-6 py-4">Current Stage</th>
                    <th class="pl-10 py-4 ">Process Flow</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($accreditations as $acc)
                @php
                    $isCancelled = $acc->status === 'cancelled';
                @endphp
                <tr wire:click="openTimeline({{ $acc->id }})" class="hover:bg-slate-50/80 transition-colors cursor-pointer group {{ $isCancelled ? 'bg-slate-50/40 opacity-75' : '' }}">
                    <!-- College & Program -->
                    <td class="px-6 py-4.5">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-label-xs font-bold {{ $isCancelled ? 'bg-slate-200 text-slate-600' : 'bg-primary/10 text-primary border border-primary/15' }} shrink-0">
                                @if($acc->program->college)
                                    <img src="{{ $acc->program->college->logo }}" alt="Logo" class="w-4 h-4 object-contain shrink-0" onerror="this.style.display='none'">
                                @endif
                                {{ $acc->program->college->code ?? 'N/A' }}
                            </span>
                            <div class="flex flex-col">
                                <span class="font-bold {{ $isCancelled ? 'text-slate-600 line-through' : 'text-primary-dark group-hover:text-brand-orange' }} transition-colors">
                                    {{ $acc->program->name ?? 'N/A' }}
                                </span>
                                <span class="text-label-xs text-primary-muted font-mono">
                                    {{ $acc->program->code ?? '' }} &bull; {{ $acc->program->accreditation_level ?? 'Level Not Set' }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <!-- Initiated Date -->
                    <td class="px-6 py-4.5">
                        <div class="flex flex-col">
                            <span class="font-semibold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-primary-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $acc->created_at ? $acc->created_at->format('M d, Y') : 'N/A' }}
                            </span>
                            <span class="text-label-xs text-slate-400">
                                {{ $acc->created_at ? $acc->created_at->diffForHumans() : '' }} &bull; {{ $acc->creator->name ?? 'IQA Staff' }}
                            </span>
                        </div>
                    </td>

                    <!-- Target Visit Date -->
                    <td class="px-6 py-4.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg {{ $isCancelled ? 'bg-slate-100 text-slate-400' : 'bg-amber-50 text-amber-600 border border-amber-200/60' }} flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold {{ $isCancelled ? 'text-slate-500' : 'text-slate-800' }}">
                                    {{ $acc->target_date ? \Carbon\Carbon::parse($acc->target_date)->format('M d, Y') : 'Date TBD' }}
                                </span>
                                <span class="text-label-xs {{ $isCancelled ? 'text-slate-400' : 'text-amber-700/80' }}">
                                    {{ $isCancelled ? 'Cancelled' : 'Scheduled Survey' }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <!-- Current Stage / Status -->
                    <td class="px-6 py-4.5">
                        @php
                            $stageMap = [
                                'scheduled' => ['label' => '1. Scheduled', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                                'pending_task_force' => ['label' => '2. TF Nomination', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                                'task_force_setup' => ['label' => '2. TF Proposed', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                'task_force_approved' => ['label' => '3. TF Active', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                'instrument_building' => ['label' => '4. Instrument Customization', 'class' => 'bg-indigo-100 text-indigo-800 border-indigo-200'],
                                'document_preparation' => ['label' => '5. Evidence Gathering', 'class' => 'bg-purple-100 text-purple-800 border-purple-200'],
                                'uploading' => ['label' => '5. Evidence Gathering', 'class' => 'bg-purple-100 text-purple-800 border-purple-200'],
                                'dean_verification' => ['label' => '6. Dean Verification', 'class' => 'bg-cyan-100 text-cyan-800 border-cyan-200'],
                                'submitted' => ['label' => '7. Submitted to IQA', 'class' => 'bg-green-100 text-green-700 border-green-200'],
                                'completed' => ['label' => '7. Review Completed', 'class' => 'bg-green-100 text-green-700 border-green-200'],
                                'cancelled' => ['label' => 'Cancelled', 'class' => 'bg-rose-100 text-rose-700 border-rose-200'],
                            ];
                            $stage = $stageMap[$acc->status] ?? ['label' => ucwords(str_replace('_', ' ', $acc->status)), 'class' => 'bg-slate-100 text-slate-800 border-slate-200'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-label-xs font-bold border {{ $stage['class'] }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ $stage['label'] }}
                        </span>
                    </td>

                    <!-- Action / View Timeline -->
                    <td class="px-6 py-4.5 text-right">
                        <button type="button" wire:click.stop="openTimeline({{ $acc->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-body-sm font-semibold text-primary bg-slate-100 group-hover:bg-brand-orange group-hover:text-white transition-all shadow-2xs">
                            <span>View Timeline</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <h4 class="text-heading-sm font-bold text-primary-dark">No Accreditation Visits Found</h4>
                            <p class="text-body-sm text-primary-muted mt-1">
                                @if(!empty($search) || $statusFilter !== 'all')
                                    No records match your search criteria. Try adjusting your filters.
                                @else
                                    Initiate an accreditation visit to track its full multi-stage lifecycle here.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($accreditations->hasPages())
    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        {{ $accreditations->links() }}
    </div>
    @endif
</div>
