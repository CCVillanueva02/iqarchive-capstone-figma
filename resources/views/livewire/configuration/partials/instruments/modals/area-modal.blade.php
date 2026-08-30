<!-- 2. AREA MODAL (ADD / EDIT) -->
<div>
    @if ($showAreaModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-heading-sm font-bold text-primary">{{ $editingAreaId ? 'Edit Accreditation Area' : 'Add Accreditation Area' }}</h3>
                        <p class="text-label-xs text-zinc-500">AACCUP 10-Area standard survey division</p>
                    </div>
                </div>
                <button type="button" wire:click="closeAreaModal" class="p-1.5 rounded-md text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="saveArea" class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Area Code <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="areaCode" placeholder="e.g. Area I" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                        @error('areaCode') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Display Order</label>
                        <input type="number" wire:model="areaOrder" min="1" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-label font-bold text-slate-700">Area Name <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="areaName" placeholder="e.g. Vision, Mission, Goals, and Objectives" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    @error('areaName') <span class="text-label-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Weight (%)</label>
                        <input type="number" step="0.5" wire:model="areaWeight" placeholder="e.g. 10.0" class="w-full rounded-lg border-slate-300 text-body-sm font-medium text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-label font-bold text-slate-700">Scope Note</label>
                        <input type="text" wire:model="areaDescription" placeholder="e.g. Institutional focus" class="w-full rounded-lg border-slate-300 text-body-sm text-slate-800 focus:ring-2 focus:ring-brand-orange/20 focus:border-brand-orange shadow-xs transition">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeAreaModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4.5 py-2 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Save Area</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
