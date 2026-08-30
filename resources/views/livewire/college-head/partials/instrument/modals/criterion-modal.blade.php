<!-- Criterion Add/Edit Modal -->
@if ($showCriterionModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-xl overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-150">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-heading-sm font-extrabold text-primary">
                {{ $editingCriterionId ? 'Edit Checklist Criterion' : 'Add Section Criterion' }}
            </h3>
            <button type="button" wire:click="closeCriterionModal" class="text-zinc-400 hover:text-zinc-700 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit="saveCriterion" class="p-6 flex flex-col gap-4">
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2 flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Criterion Code</label>
                    <input type="text" wire:model="criterionCode" placeholder="e.g. S.1, I.2, O.1, BP.1" class="rounded-lg border-slate-300 text-body-sm font-semibold focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs">
                    @error('criterionCode') <span class="text-label-xs text-rose-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Order</label>
                    <input type="number" wire:model="criterionOrder" min="1" class="rounded-lg border-slate-300 text-body-sm font-semibold focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs">
                    @error('criterionOrder') <span class="text-label-xs text-rose-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-label font-bold text-slate-700">Benchmark Statement / Requirement</label>
                <textarea wire:model="criterionStatement" rows="3" class="rounded-lg border-slate-300 text-body-sm focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs" placeholder="e.g. The institution has a system of determining its Vision and Mission..."></textarea>
                @error('criterionStatement') <span class="text-label-xs text-rose-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-label font-bold text-slate-700">Guideline / Description <span class="text-zinc-400 font-normal">(Optional)</span></label>
                <textarea wire:model="criterionDescription" rows="2" class="rounded-lg border-slate-300 text-body-sm focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs" placeholder="Supporting instructions or evaluator guidelines..."></textarea>
            </div>

            <!-- Required Document Evidence Tags Manager -->
            <div class="flex flex-col gap-2 pt-2 border-t border-slate-200">
                <label class="text-label font-bold text-slate-700 flex items-center justify-between">
                    <span>Required #EvidenceTags for Uploads</span>
                    <span class="text-zinc-400 font-normal text-label-xs">Press Enter to add tag</span>
                </label>

                <div class="flex items-center gap-2">
                    <input type="text" wire:model="newTagInput" wire:keydown.enter.prevent="addTag" placeholder="#BoardResolution, #UniversityManual" class="flex-1 rounded-lg border-slate-300 text-body-sm focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs">
                    <button type="button" wire:click="addTag" class="px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-primary font-bold text-body-sm transition cursor-pointer">
                        Add Tag
                    </button>
                </div>

                <!-- Displayed Tags List -->
                <div class="flex flex-wrap items-center gap-2 min-h-[32px] p-2 bg-slate-50 border border-slate-200/80 rounded-lg">
                    @forelse ($criterionTags as $index => $tag)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-label-xs font-bold bg-surface-subtle text-primary-dark border border-primary/15">
                        <span>{{ $tag }}</span>
                        <button type="button" wire:click="removeTag({{ $index }})" class="text-primary hover:text-primary-dark-hover cursor-pointer font-extrabold">&times;</button>
                    </span>
                    @empty
                    <span class="text-label-xs text-zinc-400 italic">No evidence tags added yet.</span>
                    @endforelse
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200">
                <button type="button" wire:click="closeCriterionModal" class="px-4 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-body-sm transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white font-semibold text-body-sm shadow-xs transition cursor-pointer">
                    Save Criterion
                </button>
            </div>
        </form>
    </div>
</div>
@endif
