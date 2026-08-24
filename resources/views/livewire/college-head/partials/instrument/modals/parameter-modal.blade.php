<!-- Parameter Add/Edit Modal -->
@if ($showParameterModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-150">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-heading-sm font-extrabold text-primary">
                {{ $editingParameterId ? 'Edit Parameter' : 'Add Custom Parameter' }}
            </h3>
            <button type="button" wire:click="closeParameterModal" class="text-zinc-400 hover:text-zinc-700 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit="saveCustomParameter" class="p-6 flex flex-col gap-4">
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2 flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Parameter Code</label>
                    <input type="text" wire:model="paramCode" placeholder="e.g. Parameter A" class="rounded-lg border-slate-300 text-body-sm font-semibold focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs">
                    @error('paramCode') <span class="text-label-xs text-rose-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Order</label>
                    <input type="number" wire:model="paramOrder" min="1" class="rounded-lg border-slate-300 text-body-sm font-semibold focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs">
                    @error('paramOrder') <span class="text-label-xs text-rose-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-label font-bold text-slate-700">Parameter Title / Name</label>
                <input type="text" wire:model="paramName" placeholder="e.g. Statement of VMGO" class="rounded-lg border-slate-300 text-body-sm font-semibold focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs">
                @error('paramName') <span class="text-label-xs text-rose-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-label font-bold text-slate-700">Description <span class="text-zinc-400 font-normal">(Optional)</span></label>
                <textarea wire:model="paramDescription" rows="2" class="rounded-lg border-slate-300 text-body-sm focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs" placeholder="Guidelines for this parameter..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200">
                <button type="button" wire:click="closeParameterModal" class="px-4 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-body-sm transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white font-semibold text-body-sm shadow-xs transition cursor-pointer">
                    Save Parameter
                </button>
            </div>
        </form>
    </div>
</div>
@endif
