<flux:modal wire:model="showHistoryModal" class="max-w-3xl md:min-w-3xl no-scrollbar scrollbar-none" @close="closeHistoryModal">
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
                <span class="text-label-xs font-mono text-primary-muted ml-auto font-bold">
                    {{ $selectedProgram->code }}
                </span>
            </div>
            
            <h2 class="text-heading font-bold text-primary-dark tracking-tight">
                {{ $selectedProgram->name }}
            </h2>
            <p class="text-body-sm text-slate-500 mt-0.5">
                Comprehensive AACCUP survey accreditation history and technical evaluation records.
            </p>
        </div>

        <!-- History Timeline Container -->
        <div class="space-y-4">
            <!-- Latest Recorded Visit -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-heading-sm font-bold text-primary-dark">3rd Survey Visit (Phase 1)</h4>
                            <span class="bg-blue-100 text-blue-800 text-label-xs font-bold px-2 py-0.5 rounded border border-blue-200">Revisit</span>
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
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-label-xs font-bold uppercase bg-emerald-100 text-emerald-800 border border-emerald-200 self-start sm:self-auto">
                        Accredited
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

                    <div class="bg-surface-card p-3 rounded-xl border border-slate-200/80">
                        <span class="block text-label-xs text-slate-400 font-bold uppercase tracking-wider mb-0.5">Board Remarks</span>
                        <p class="text-label text-slate-700 leading-snug">
                            Ready for Next Cycle Revisit Survey on Aug 2026.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Historical Visit -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs opacity-85">
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

        <!-- Footer Actions -->
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeHistoryModal">
                {{ __('Close History') }}
            </flux:button>
        </div>
    </div>
    @endif
</flux:modal>
