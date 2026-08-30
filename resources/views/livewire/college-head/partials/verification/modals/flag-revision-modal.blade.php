<!-- Flag Document for Revision Modal -->
@if($showFlagModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-200/70"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-rose-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                    <x-lucide-flag class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="text-heading-sm font-bold text-rose-900">Flag Document for Revision</h3>
                    <p class="text-label text-rose-700 mt-0.5">Specify quality issues or corrections needed.</p>
                </div>
            </div>
            <button type="button" wire:click="closeFlagModal" class="text-zinc-400 hover:text-zinc-600 transition cursor-pointer p-1">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <!-- Body Form -->
        <form wire:submit="submitFlagDocument" class="p-6 flex flex-col gap-4">
            <div class="bg-surface-subtle border border-slate-200/70 rounded-xl p-3.5 flex flex-col gap-1 text-xs">
                <span class="text-zinc-400 font-medium">Document:</span>
                <span class="font-bold text-primary">{{ $flaggingDocTitle }}</span>
                <span class="text-label-xs text-zinc-500 mt-0.5">Criterion: {{ $flaggingDocCriterion }}</span>
            </div>

            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Dean Revision Remarks / Feedback <span class="text-rose-500">*</span>
                </label>
                <textarea wire:model="revisionRemarks" 
                    rows="3" 
                    required
                    placeholder="e.g. Missing board approval seal on page 4; please provide the signed BOR resolution."
                    class="w-full text-body-sm border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium"></textarea>
                @error('revisionRemarks') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Footer Actions -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" 
                    wire:click="closeFlagModal" 
                    class="px-4 py-2 rounded-xl text-body-sm font-bold text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-5 py-2 rounded-xl text-body-sm font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-3xs transition cursor-pointer flex items-center gap-1.5">
                    <x-lucide-flag class="w-4 h-4" />
                    <span>Submit Flag &amp; Notify TF</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif
