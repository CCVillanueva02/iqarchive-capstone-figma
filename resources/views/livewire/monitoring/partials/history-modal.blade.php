<flux:modal wire:model="showHistoryModal" class="max-w-3xl md:min-w-3xl" @close="closeHistoryModal">
    @if($selectedProgram)
    <div class="space-y-6">
        <!-- Header -->
        <div class="border-b border-slate-200 pb-4">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-label-xs font-bold bg-primary text-white">
                    {{ $selectedProgram->college->code ?? 'N/A' }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-label-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $selectedProgram->accreditation_level ?: 'Candidate Status' }}
                </span>
                <span class="text-label-xs font-mono text-primary-muted ml-auto">
                    {{ $selectedProgram->code }}
                </span>
            </div>
            
            <h2 class="text-heading font-bold text-primary-dark tracking-tight">
                {{ $selectedProgram->name }}
            </h2>
            <p class="text-body-sm text-primary-muted mt-0.5">
                Comprehensive AACCUP survey accreditation history and technical evaluation record.
            </p>
        </div>

        <!-- Timeline Container -->
        <div class="relative pl-6 space-y-8 before:absolute before:left-2.75 before:top-2.5 before:bottom-2.5 before:w-0.5 before:bg-slate-200">
            <!-- Latest Recorded Visit -->
            <div class="relative flex items-start gap-4">
                <div class="absolute -left-6 mt-0.5">
                    <div class="w-6 h-6 rounded-full bg-brand-orange text-white flex items-center justify-center ring-4 ring-white shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-heading-sm font-bold text-primary-dark">3rd Survey Visit (Phase 1)</h4>
                                <span class="bg-surface-subtle text-primary-dark text-label-xs font-bold px-2 py-0.5 rounded border border-primary/15">Revisit VI</span>
                            </div>
                            <p class="text-label text-slate-500 font-medium mt-0.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Survey Date: Nov 21 - 25, 2022
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-label-xs font-bold uppercase bg-rose-100 text-rose-700 border border-rose-200 self-start sm:self-auto">
                            Late Submission
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-surface-card p-3 rounded-xl border border-slate-200/80 text-center">
                            <span class="block text-label-xs text-slate-400 font-bold uppercase tracking-wider">Final Rating</span>
                            <span class="text-heading-lg font-black text-primary mt-0.5 block">4.03</span>
                            <span class="text-label-xs text-emerald-600 font-semibold">Passed Criteria</span>
                        </div>

                        <div class="bg-surface-card p-3 rounded-xl border border-slate-200/80 text-center">
                            <span class="block text-label-xs text-slate-400 font-bold uppercase tracking-wider">Validity Period</span>
                            <span class="text-body-sm font-bold text-slate-800 mt-1 block">Dec 16, 2023</span>
                            <span class="text-label-xs text-slate-400">to Dec 15, 2024</span>
                        </div>

                        <div class="bg-amber-50/60 p-3 rounded-xl border border-amber-200/70">
                            <span class="block text-label-xs text-amber-800 font-bold uppercase tracking-wider mb-0.5">Board Remarks</span>
                            <p class="text-label text-amber-900 leading-snug">
                                Requested for Reschedule of Revisit on Aug 27-29, 2025.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Previous Historical Visit -->
            <div class="relative flex items-start gap-4 opacity-80 hover:opacity-100 transition-opacity">
                <div class="absolute -left-6 mt-0.5">
                    <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center ring-4 ring-white shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                </div>

                <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                        <div>
                            <h4 class="text-heading-sm font-bold text-primary-dark">2nd Survey Visit</h4>
                            <p class="text-label text-slate-500 font-medium mt-0.5">
                                Survey Date: Nov 8 - 11, 2017
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-label-xs font-bold uppercase bg-emerald-100 text-emerald-800 border border-emerald-200 self-start sm:self-auto">
                            Timely Evaluation
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-surface-card p-3 rounded-xl border border-slate-200/80 text-center">
                            <span class="block text-label-xs text-slate-400 font-bold uppercase tracking-wider">Final Rating</span>
                            <span class="text-heading-lg font-black text-primary mt-0.5 block">3.63</span>
                            <span class="text-label-xs text-emerald-600 font-semibold">Accredited</span>
                        </div>

                        <div class="bg-surface-card p-3 rounded-xl border border-slate-200/80 text-center">
                            <span class="block text-label-xs text-slate-400 font-bold uppercase tracking-wider">Validity Period</span>
                            <span class="text-body-sm font-bold text-slate-800 mt-1 block">Dec 16, 2018</span>
                            <span class="text-label-xs text-slate-400">to Dec 15, 2022</span>
                        </div>

                        <div class="bg-surface-card p-3 rounded-xl border border-slate-200/80 flex items-center justify-center text-center">
                            <span class="text-label text-slate-400 italic">No additional board actions.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeHistoryModal">
                {{ __('Close History') }}
            </flux:button>
        </div>
    </div>
    @endif
</flux:modal>
