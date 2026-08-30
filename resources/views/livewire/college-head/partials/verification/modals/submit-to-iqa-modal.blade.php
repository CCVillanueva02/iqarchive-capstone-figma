<!-- Complete Dean Verification & Submit to IQA Modal -->
@if($showSubmitToIqaModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-200/70"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-emerald-50/60">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                    <x-lucide-award class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="text-heading-sm font-bold text-emerald-950">Seal &amp; Submit to IQA Office</h3>
                    <p class="text-label text-emerald-700 mt-0.5">Formal College Dean quality seal and final handover.</p>
                </div>
            </div>
            <button type="button" wire:click="closeSubmitToIqaModal" class="text-zinc-400 hover:text-zinc-600 transition cursor-pointer p-1">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <!-- Body Form -->
        <form wire:submit="confirmSubmitToIqa" class="p-6 flex flex-col gap-4">
            <!-- Readiness Summary Box -->
            <div class="bg-surface-subtle border border-slate-200/70 rounded-xl p-4 flex flex-col gap-2 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-zinc-500 font-medium">Program:</span>
                    <span class="font-bold text-primary">{{ $acc->program->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-zinc-500 font-medium">Readiness Level:</span>
                    <span class="font-bold text-emerald-700">{{ $stats['verifiedDocs'] }}/{{ $stats['totalDocs'] }} Verified ({{ $stats['readinessPct'] }}%)</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-zinc-500 font-medium">Target Status:</span>
                    <span class="font-bold text-primary bg-surface-subtle px-2 py-0.5 rounded-full text-label-xs">Submitted for Accreditor Review</span>
                </div>
            </div>

            <div class="bg-emerald-50/80 border border-emerald-200/80 rounded-xl p-3.5 text-xs text-emerald-900 leading-relaxed">
                By submitting, you formally certify as College Dean that the documentation has been reviewed and is ready for the University Internal Quality Assurance (IQA) Office and external accreditors.
            </div>

            <!-- Optional Sign-Off Comments -->
            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Dean Sign-Off Comments / Quality Endorsement (Optional)
                </label>
                <textarea wire:model="signoffNotes" 
                    rows="2" 
                    placeholder="e.g. Verified and endorsed by the College Dean. All 10 areas comply with AACCUP benchmarks..."
                    class="w-full text-body-sm border border-slate-200 rounded-xl px-4 py-2 bg-slate-50 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition font-medium"></textarea>
            </div>

            <!-- Footer Actions -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" 
                    wire:click="closeSubmitToIqaModal" 
                    class="px-4 py-2 rounded-xl text-body-sm font-bold text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-5 py-2.5 rounded-xl text-body-sm font-bold text-white bg-primary hover:bg-primary-hover shadow-3xs transition cursor-pointer flex items-center gap-2">
                    <x-lucide-shield-check class="w-4 h-4 text-emerald-400" />
                    <span>Confirm &amp; Submit to IQA</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif
