<!-- 3. PARAMETER MODAL (ADD / EDIT) -->
<div>
    @if ($showParameterModal)
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
                        <h3 class="text-heading-sm font-bold text-primary">{{ $editingParameterId ? 'Edit Parameter' : 'Add Parameter' }}</h3>
                        <p class="text-label-xs text-zinc-500">Benchmark subdivision under active area</p>
                    </div>
                </div>
                <button type="button" wire:click="closeParameterModal" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveParameter" class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Parameter Code <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="parameterCode" placeholder="e.g. Parameter A" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                        @error('parameterCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Display Order</label>
                        <input type="number" wire:model="parameterOrder" min="1" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Parameter Title <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="parameterName" placeholder="e.g. Statement of VMGO" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('parameterName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Description / Focus</label>
                    <textarea wire:model="parameterDescription" rows="2" placeholder="Optional notes for accreditors or task force..." class="w-full rounded-lg border-slate-300 text-body-sm text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeParameterModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4.5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Save Parameter</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
