<!-- Submit Evidence to Dean Modal -->
@if($showSubmitModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-200/70"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-surface-subtle/60">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                    <x-lucide-send class="w-5 h-5 text-primary" />
                </div>
                <div>
                    <h3 class="text-heading-sm font-bold text-primary">Submit Evidence to College Dean</h3>
                    <p class="text-label text-zinc-500 mt-0.5">Advance cycle to Stage 6 Dean Verification.</p>
                </div>
            </div>
            <button type="button" wire:click="closeSubmitModal" class="text-zinc-400 hover:text-zinc-600 transition cursor-pointer p-1">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <!-- Body Form -->
        <form wire:submit="confirmSubmitToDean" class="p-6 flex flex-col gap-4">
            <div class="bg-surface-subtle/80 border border-primary/15/80 rounded-xl p-3.5 text-xs text-primary-dark leading-relaxed">
                By submitting this repository, you confirm that all required documentation for <strong>{{ $acc->program->name }}</strong> has been prepared and attached to their respective evaluation criteria.
            </div>

            <!-- Evidence Summary Chips -->
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/70 text-center">
                    <span class="text-label-xs text-zinc-400 block font-bold uppercase">Total Evidence</span>
                    <span class="text-heading-sm font-extrabold text-primary">{{ $stats['totalDocs'] }} Files</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/70 text-center">
                    <span class="text-label-xs text-zinc-400 block font-bold uppercase">Current Status</span>
                    <span class="text-heading-sm font-extrabold text-amber-700">Ready</span>
                </div>
            </div>

            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Task Force Submission Remarks (Optional)
                </label>
                <textarea wire:model="submissionRemarks" 
                    rows="3" 
                    placeholder="Add any handover notes or remarks for the Dean (e.g. All Area I to X evidence compiled and ready for review)..."
                    class="w-full text-body-sm border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium"></textarea>
            </div>

            <!-- Footer Actions -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" 
                    wire:click="closeSubmitModal" 
                    class="px-4 py-2 rounded-xl text-body-sm font-bold text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-5 py-2 rounded-xl text-body-sm font-bold text-white bg-primary hover:bg-primary-hover shadow-3xs transition cursor-pointer flex items-center gap-1.5">
                    <x-lucide-check-check class="w-4 h-4 text-white" />
                    <span>Confirm &amp; Submit to Dean</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif
