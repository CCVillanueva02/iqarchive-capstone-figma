<!-- 1. Flag Document for Revision Modal -->
@if($showFlagModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-zinc-200"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between bg-rose-50/50">
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
            <div class="bg-surface-subtle border border-zinc-200 rounded-xl p-3.5 flex flex-col gap-1 text-xs">
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
                    class="w-full text-body-sm border border-zinc-200 rounded-xl px-4 py-2.5 bg-surface-subtle focus:bg-white focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium"></textarea>
                @error('revisionRemarks') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Footer Actions -->
            <div class="pt-3 border-t border-zinc-100 flex items-center justify-end gap-3">
                <x-ui.button type="button" variant="secondary" wire:click="closeFlagModal">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" variant="danger" loading="submitFlagDocument">
                    <x-slot:icon>
                        <x-lucide-flag class="w-4 h-4 mr-1.5" />
                    </x-slot:icon>
                    Submit Flag &amp; Notify TF
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- 2. Request Task Force Revisions Modal -->
@if($showRequestRevisionsModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-zinc-200"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between bg-amber-50/60">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                    <x-lucide-rotate-ccw class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="text-heading-sm font-bold text-amber-900">Request Task Force Revisions</h3>
                    <p class="text-label text-amber-700 mt-0.5">Return repository for further document preparation.</p>
                </div>
            </div>
            <button type="button" wire:click="closeRequestRevisionsModal" class="text-zinc-400 hover:text-zinc-600 transition cursor-pointer p-1">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <!-- Body Form -->
        <form wire:submit="submitRequestRevisions" class="p-6 flex flex-col gap-4">
            <div class="bg-surface-subtle border border-zinc-200 rounded-xl p-3.5 flex flex-col gap-1 text-xs">
                <span class="text-zinc-400 font-medium">Program Under Review:</span>
                <span class="font-bold text-primary">{{ $acc->program->name }}</span>
                <span class="text-label-xs text-zinc-500 mt-0.5">Assigned Task Force: {{ $acc->taskForce?->name ?? 'Task Force' }}</span>
            </div>

            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    General Dean Feedback for Task Force <span class="text-amber-600">*</span>
                </label>
                <textarea wire:model="revisionsGeneralRemarks"
                    rows="3"
                    required
                    placeholder="e.g. Please re-check faculty profile credentials and update Area II documents according to new AACCUP guidelines."
                    class="w-full text-body-sm border border-zinc-200 rounded-xl px-4 py-2.5 bg-surface-subtle focus:bg-white focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition font-medium"></textarea>
                @error('revisionsGeneralRemarks') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-label text-amber-800 flex items-start gap-2">
                <x-lucide-alert-triangle class="w-4 h-4 shrink-0 text-amber-600 mt-0.5" />
                <span>Returning this repository will revert status to <strong>In Active Preparation</strong> and alert Task Force leaders.</span>
            </div>

            <!-- Footer Actions -->
            <div class="pt-3 border-t border-zinc-100 flex items-center justify-end gap-3">
                <x-ui.button type="button" variant="secondary" wire:click="closeRequestRevisionsModal">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" variant="brand" loading="submitRequestRevisions">
                    <x-slot:icon>
                        <x-lucide-rotate-ccw class="w-4 h-4 mr-1.5" />
                    </x-slot:icon>
                    Return to Task Force
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- 3. Complete Dean Verification & Submit to IQA Modal -->
@if($showSubmitToIqaModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-zinc-200"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-zinc-100 flex items-center justify-between bg-emerald-50/60">
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
        <form wire:submit="submitToIqa" class="p-6 flex flex-col gap-4">
            <div class="bg-surface-subtle border border-zinc-200 rounded-xl p-3.5 flex flex-col gap-1 text-xs">
                <span class="text-zinc-400 font-medium">Program:</span>
                <span class="font-bold text-primary">{{ $acc->program->name }}</span>
                <span class="text-label-xs text-zinc-500 mt-0.5">College: {{ $acc->program->college?->name }}</span>
            </div>

            <!-- Verification Readiness Summary Box -->
            <div class="p-4 bg-emerald-50/50 border border-emerald-200 rounded-xl flex items-center justify-between">
                <div>
                    <span class="text-label-xs font-bold text-emerald-700 uppercase tracking-wider block">Current Readiness</span>
                    <span class="text-heading-sm font-black text-emerald-800 block mt-0.5">{{ $stats['readinessPct'] }}% Verified</span>
                </div>
                <div class="text-right">
                    <span class="text-label-xs text-zinc-500 block">{{ $stats['verifiedDocs'] }} of {{ $stats['totalDocs'] }} docs</span>
                    <span class="text-label-xs text-rose-600 font-bold block mt-0.5">{{ $stats['flaggedDocs'] }} flagged</span>
                </div>
            </div>

            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Dean Quality Endorsement Notes (Optional)
                </label>
                <textarea wire:model="deanEndorsementNotes"
                    rows="2"
                    placeholder="e.g. All academic criteria verified compliant with AACCUP Level III standards."
                    class="w-full text-body-sm border border-zinc-200 rounded-xl px-4 py-2.5 bg-surface-subtle focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition font-medium"></textarea>
            </div>

            <!-- Footer Actions -->
            <div class="pt-3 border-t border-zinc-100 flex items-center justify-end gap-3">
                <x-ui.button type="button" variant="secondary" wire:click="closeSubmitToIqaModal">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" loading="submitToIqa" class="bg-emerald-600 hover:bg-emerald-700">
                    <x-slot:icon>
                        <x-lucide-shield-check class="w-4 h-4 mr-1.5" />
                    </x-slot:icon>
                    Seal &amp; Handover to IQA
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
@endif
