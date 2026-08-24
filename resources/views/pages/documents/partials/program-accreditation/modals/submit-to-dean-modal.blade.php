<!-- Submit Evidence to Dean Modal (Step 5.3) -->
<div x-show="showSubmitToDeanModal" 
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto" 
    style="display: none;" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div @click.away="closeSubmitToDeanModal()" 
        class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-200/70"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-blue-50/50">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-primary text-white flex items-center justify-center shrink-0">
                    <x-lucide-send class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="text-heading-sm font-bold text-primary">Submit to College Dean</h3>
                    <p class="text-label text-zinc-500 mt-0.5">Hand over evidence repository for Dean verification.</p>
                </div>
            </div>
            <button @click="closeSubmitToDeanModal()" class="text-zinc-400 hover:text-zinc-600 transition cursor-pointer p-1">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <!-- Content Body -->
        <div class="p-6 flex flex-col gap-5">
            <!-- Program Summary Box -->
            <div class="bg-surface-subtle border border-slate-200/70 rounded-xl p-4 flex flex-col gap-2.5">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-zinc-500 font-medium">Program:</span>
                    <span class="font-bold text-primary" x-text="accredProgram?.name"></span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-zinc-500 font-medium">College:</span>
                    <span class="font-bold text-zinc-700" x-text="accredProgram?.college"></span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-zinc-500 font-medium">Target Status:</span>
                    <span class="font-bold text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full text-label-xs">
                        Dean Verification
                    </span>
                </div>
            </div>

            <!-- Informative Notice -->
            <div class="flex items-start gap-3 bg-amber-50/80 border border-amber-200/80 rounded-xl p-3.5 text-xs text-amber-900">
                <x-lucide-alert-circle class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" />
                <p class="leading-relaxed">
                    Submitting this repository will notify the College Dean that your Task Force has prepared the documentation for verification.
                </p>
            </div>

            <!-- Submitter Remarks / Notes -->
            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Task Force Notes for the Dean (Optional)
                </label>
                <textarea x-model="submitDeanNotes" 
                    rows="3" 
                    placeholder="Provide any summary comments, areas completed, or special notes for the Dean..."
                    class="w-full text-body-sm border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium"></textarea>
            </div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="px-6 py-4 bg-surface-subtle border-t border-slate-100 flex items-center justify-end gap-3">
            <button type="button" 
                @click="closeSubmitToDeanModal()" 
                class="px-4 py-2.5 rounded-xl text-body-sm font-bold text-zinc-600 hover:bg-slate-200 transition cursor-pointer">
                Cancel
            </button>
            <button type="button" 
                @click="submitEvidenceToDean()" 
                :disabled="isSubmittingToDean"
                class="px-5 py-2.5 rounded-xl text-body-sm font-bold text-white bg-primary hover:bg-primary-hover shadow-3xs transition cursor-pointer flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <template x-if="isSubmittingToDean">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <template x-if="!isSubmittingToDean">
                    <x-lucide-send class="w-4 h-4" />
                </template>
                <span x-text="isSubmittingToDean ? 'Submitting...' : 'Submit'"></span>
            </button>
        </div>
    </div>
</div>
