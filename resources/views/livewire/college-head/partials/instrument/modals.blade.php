<div>
    <!-- 1. ADD CUSTOM PARAMETER MODAL -->
    @if ($showAddParameterModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-heading-sm font-bold text-primary">Add Program-Specific Parameter</h3>
                        <p class="text-label-xs text-zinc-500">Tailor requirements for {{ $accreditation->program->name }}</p>
                    </div>
                </div>
                <button type="button" wire:click="closeAddParameterModal" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveCustomParameter" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Parameter Code <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="paramCode" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('paramCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Parameter Title <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="paramName" placeholder="e.g. Specialized Clinical Affiliations" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('paramName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Description / Rationale</label>
                    <textarea wire:model="paramDescription" rows="2" placeholder="Optional notes on why this parameter is required..." class="w-full rounded-lg border-slate-300 text-body-sm text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeAddParameterModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4.5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Add Parameter</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 2. ADD / EDIT CRITERION MODAL -->
    @if ($showAddCriterionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-xl w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-primary flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-heading-sm font-bold text-primary">
                            {{ $editingCriterionId ? 'Edit Criterion Tags' : 'Add Program Criterion' }}
                        </h3>
                        <p class="text-label-xs text-zinc-500">Benchmark checklist and document tag mapping</p>
                    </div>
                </div>
                <button type="button" wire:click="closeAddCriterionModal" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveCriterion" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Criterion Code <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="criterionCode" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('criterionCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Criterion Statement / Benchmark <span class="text-rose-500">*</span></label>
                    <textarea wire:model="criterionStatement" rows="3" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition"></textarea>
                    @error('criterionStatement') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Tag Management -->
                <div class="flex flex-col gap-2">
                    <label class="text-label font-bold text-slate-700">Required Document Evidence Tags</label>
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model="newTagInput" wire:keydown.enter.prevent="addTag" placeholder="e.g. #HospitalMOA (press Enter)" class="flex-1 rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                        <button type="button" wire:click="addTag" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-primary rounded-lg text-body-sm font-semibold transition cursor-pointer">Add Tag</button>
                    </div>

                    <div class="flex flex-wrap gap-1.5 min-h-9 p-2 bg-slate-50 border border-slate-200 rounded-lg items-center">
                        @forelse ($criterionTags as $idx => $tag)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-label-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            <span>{{ $tag }}</span>
                            <button type="button" wire:click="removeTag({{ $idx }})" class="hover:text-rose-600 cursor-pointer font-bold">&times;</button>
                        </span>
                        @empty
                        <span class="text-label-xs text-zinc-400 italic">No tags added. Enter a tag above and click Add Tag.</span>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeAddCriterionModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4.5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Save Criterion</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 3. FINALIZE & UNLOCK EVIDENCE REPOSITORY MODAL -->
    @if ($showFinalizeModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center gap-3.5 pb-2">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-heading-sm font-bold text-primary">Finalize &amp; Unlock Evidence Repository</h3>
                    <p class="text-label-xs text-emerald-700 font-semibold">Advance to Stage 5 (Document Uploads)</p>
                </div>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 flex flex-col gap-2">
                <p class="text-body-sm text-slate-700 leading-relaxed">
                    Finalizing the accreditation instrument will officially lock the baseline criteria for <strong class="text-primary">{{ $accreditation->program->name }}</strong>.
                </p>
                <p class="text-label-xs text-slate-500">
                    Assigned Task Force members will immediately receive in-app notifications and upload access to all Area I–X folders in the Evidence Repository.
                </p>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-100">
                <button type="button" wire:click="closeFinalizeModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Back to Review</button>
                <button type="button" wire:click="finalizeInstrument" class="px-5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Confirm &amp; Unlock Workspace</button>
            </div>
        </div>
    </div>
    @endif
</div>
