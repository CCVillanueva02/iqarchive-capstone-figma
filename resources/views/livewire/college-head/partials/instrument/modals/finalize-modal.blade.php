<!-- Finalize Instrument Confirmation Modal -->
@if ($showFinalizeModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-150">
        <div class="p-6 flex flex-col gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <div class="text-center">
                <h3 class="text-heading-sm font-extrabold text-primary">Finalize Accreditation Instruments?</h3>
                <p class="text-body-sm text-zinc-500 mt-2 leading-relaxed">
                    This will lock the baseline parameters and criteria for <strong>{{ $accreditation->program->name }}</strong>, advance the accreditation cycle to <strong>Stage 5 (Document Preparation)</strong>, and open the evidence repository for Task Force uploads.
                </p>
            </div>

            <div class="bg-surface-subtle border border-primary/15 rounded-lg p-3.5 flex items-start gap-3 text-label-xs text-primary-dark">
                <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Task Force members assigned to this accreditation will immediately receive notification to begin uploading supporting compliance documents.</span>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200">
                <button type="button" wire:click="closeFinalizeModal" class="px-4 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-body-sm transition cursor-pointer">
                    Cancel
                </button>
                <button type="button" wire:click="finalizeInstrument" class="px-5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-body-sm shadow-xs transition cursor-pointer flex items-center gap-1.5">
                    <span>Confirm</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif
