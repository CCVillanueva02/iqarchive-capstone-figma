<!-- 4. CRITERION MODAL (ADD / EDIT & EVIDENCE TAGS) -->
<div>
    @if ($showCriterionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-xl w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-surface-subtle text-primary flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-heading-sm font-bold text-primary">
                            {{ $editingCriterionId ? 'Edit Criterion' : 'Add Criterion' }}
                        </h3>
                        <p class="text-label-xs text-zinc-500">
                            Section: <span class="font-bold text-primary">{{ ucwords(str_replace('_', ' ', $activeSection)) }}</span>
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="closeCriterionModal" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveCriterion" class="flex flex-col gap-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Code <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="criterionCode" placeholder="e.g. S.1" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                        @error('criterionCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5 col-span-2">
                        <label class="text-label font-bold text-slate-700">Display Order</label>
                        <input type="number" wire:model="criterionOrder" min="1" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Benchmark Statement <span class="text-rose-500">*</span></label>
                    <textarea wire:model="criterionStatement" rows="3" placeholder="Enter benchmark statement or requirement..." class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition"></textarea>
                    @error('criterionStatement') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Required Document Tags Input & Chips -->
                <div class="flex flex-col gap-2">
                    <label class="text-label font-bold text-slate-700">Required Document Evidence Tags</label>
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model="newTagInput" wire:keydown.enter.prevent="addTag" placeholder="e.g. #BoardResolution (press Enter)" class="flex-1 rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                        <button type="button" wire:click="addTag" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-primary rounded-lg text-body-sm font-semibold transition cursor-pointer">Add Tag</button>
                    </div>

                    <!-- Current Tags Chips -->
                    <div class="flex flex-wrap gap-1.5 min-h-9 p-2 bg-slate-50 border border-slate-200 rounded-lg items-center">
                        @forelse ($criterionTags as $idx => $tag)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-label-xs font-bold bg-surface-subtle text-primary-dark border border-primary/15">
                            <span>{{ $tag }}</span>
                            <button type="button" wire:click="removeTag({{ $idx }})" class="hover:text-rose-600 cursor-pointer font-bold">&times;</button>
                        </span>
                        @empty
                        <span class="text-label-xs text-zinc-400 italic">No tags attached. Type a tag above and click Add Tag.</span>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeCriterionModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4.5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Save Criterion</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
