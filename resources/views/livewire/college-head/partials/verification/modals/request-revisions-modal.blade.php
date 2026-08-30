<!-- Request Task Force Revisions Modal -->
@if($showRequestRevisionsModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-200/70"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-amber-50/60">
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
        <form wire:submit="confirmRequestRevisions" class="p-6 flex flex-col gap-4">
            <div class="bg-amber-50/80 border border-amber-200/80 rounded-xl p-3.5 text-xs text-amber-900 leading-relaxed">
                This action will revert the cycle status to <strong>Document Preparation</strong>, allowing Task Force members to re-upload files and correct flagged criteria.
            </div>

            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Consolidated Feedback &amp; Action Items <span class="text-rose-500">*</span>
                </label>
                <textarea wire:model="reworkSummaryNotes" 
                    rows="4" 
                    required
                    placeholder="Provide a summary of areas or criteria requiring revisions (e.g. Area III needs updated syllabi; Area V requires research ethics committee approvals)..."
                    class="w-full text-body-sm border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition font-medium"></textarea>
                @error('reworkSummaryNotes') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Footer Actions -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" 
                    wire:click="closeRequestRevisionsModal" 
                    class="px-4 py-2 rounded-xl text-body-sm font-bold text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-5 py-2 rounded-xl text-body-sm font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-3xs transition cursor-pointer flex items-center gap-1.5">
                    <x-lucide-send class="w-4 h-4" />
                    <span>Return to Task Force</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif
