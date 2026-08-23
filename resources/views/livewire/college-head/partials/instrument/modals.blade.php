<div>
    <!-- 1. ADD CUSTOM PARAMETER MODAL -->
    @if ($showAddParameterModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-heading-sm font-extrabold text-primary">Add Program-Specific Parameter</h3>
                <button type="button" wire:click="closeAddParameterModal" class="text-zinc-400 hover:text-zinc-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveCustomParameter" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Parameter Code</label>
                    <input type="text" wire:model="paramCode" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    @error('paramCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Parameter Title</label>
                    <input type="text" wire:model="paramName" placeholder="e.g. Specialized Clinical Affiliations" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    @error('paramName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Description / Rationale</label>
                    <textarea wire:model="paramDescription" rows="2" placeholder="Optional notes on why this parameter is required..." class="w-full rounded-xl border-slate-200 text-body-sm focus:ring-brand-orange shadow-2xs"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeAddParameterModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-bold shadow-md cursor-pointer">Add Parameter</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 2. ADD / EDIT CRITERION MODAL -->
    @if ($showAddCriterionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-heading-sm font-extrabold text-primary">
                    {{ $editingCriterionId ? 'Edit Criterion Tags' : 'Add Program Criterion' }}
                </h3>
                <button type="button" wire:click="closeAddCriterionModal" class="text-zinc-400 hover:text-zinc-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveCriterion" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Criterion Code</label>
                    <input type="text" wire:model="criterionCode" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                    @error('criterionCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-body-sm font-bold text-slate-700">Criterion Statement / Benchmark</label>
                    <textarea wire:model="criterionStatement" rows="3" class="w-full rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs"></textarea>
                    @error('criterionStatement') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Tag Management -->
                <div class="flex flex-col gap-2">
                    <label class="text-body-sm font-bold text-slate-700">Required Document Evidence Tags</label>
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model="newTagInput" wire:keydown.enter.prevent="addTag" placeholder="e.g. #HospitalMOA (press Enter)" class="flex-1 rounded-xl border-slate-200 text-body-sm font-medium focus:ring-brand-orange shadow-2xs">
                        <button type="button" wire:click="addTag" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-primary rounded-xl text-body-sm font-bold cursor-pointer">Add Tag</button>
                    </div>

                    <div class="flex flex-wrap gap-2 min-h-8 p-2 bg-slate-50 border border-slate-200/80 rounded-xl">
                        @forelse ($criterionTags as $idx => $tag)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-label-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            <span>{{ $tag }}</span>
                            <button type="button" wire:click="removeTag({{ $idx }})" class="hover:text-rose-600 cursor-pointer">&times;</button>
                        </span>
                        @empty
                        <span class="text-label-xs text-zinc-400 italic">No tags added. Enter a tag above and click Add Tag.</span>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeAddCriterionModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-bold shadow-md cursor-pointer">Save Criterion</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- 3. FINALIZE & UNLOCK EVIDENCE REPOSITORY MODAL -->
    @if ($showFinalizeModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 flex flex-col gap-5">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <div>
                <h3 class="text-heading-sm font-extrabold text-primary">Finalize Instrument &amp; Unlock Evidence Repository?</h3>
                <p class="text-body-sm text-slate-600 mt-2 leading-relaxed">
                    Finalizing the accreditation instrument will advance <strong class="text-primary">{{ $accreditation->program->name }}</strong> to <span class="font-bold text-emerald-700">Stage 5 (Document Upload &amp; Evidence Gathering)</span>.
                </p>
                <p class="text-body-sm text-slate-500 mt-2">
                    Assigned Task Force faculty members will immediately receive in-app notifications and upload access to the area folders.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" wire:click="closeFinalizeModal" class="px-4 py-2 text-body-sm font-bold text-zinc-600 hover:text-zinc-800 cursor-pointer">Back to Review</button>
                <button type="button" wire:click="finalizeInstrument" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-body-sm font-bold shadow-md cursor-pointer">Confirm &amp; Unlock Workspace</button>
            </div>
        </div>
    </div>
    @endif
</div>
