<!-- Delete Confirmation Modal -->
@if ($showDeleteModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-150">
        <div class="p-6 flex flex-col gap-4">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>

            <div class="text-center">
                <h3 class="text-heading-sm font-extrabold text-primary">Delete {{ ucfirst($deleteType) }}?</h3>
                <p class="text-body-sm text-zinc-500 mt-2 leading-relaxed">
                    Are you sure you want to delete <strong class="text-slate-800">"{{ $deleteTargetTitle }}"</strong>?
                    @if ($deleteType === 'area')
                    All child parameters and checklist criteria in this area will also be removed.
                    @elseif ($deleteType === 'parameter')
                    All checklist criteria under this parameter will also be removed.
                    @endif
                </p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200">
                <button type="button" wire:click="closeDeleteModal" class="px-4 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-body-sm transition cursor-pointer">
                    Cancel
                </button>
                <button type="button" wire:click="executeDelete" class="px-5 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-semibold text-body-sm shadow-xs transition cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endif
