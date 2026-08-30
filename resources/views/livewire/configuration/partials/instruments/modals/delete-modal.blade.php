<!-- 5. DELETE CONFIRMATION MODAL -->
<div>
    @if ($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl border border-slate-200 flex flex-col gap-4">
            <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-heading-sm font-bold text-primary">Confirm Deletion</h3>
                <p class="text-body-sm text-zinc-600 mt-1 leading-relaxed">
                    Are you sure you want to delete <span class="font-bold text-primary">{{ $deleteTargetTitle }}</span>? This will permanently remove this item and any nested parameter or criterion records.
                </p>
            </div>
            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" wire:click="closeDeleteModal" class="px-4 py-2 rounded-lg text-body-sm font-semibold text-zinc-600 hover:text-zinc-800 hover:bg-slate-100 transition cursor-pointer">Cancel</button>
                <button type="button" wire:click="executeDelete" class="px-4.5 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">Delete Permanently</button>
            </div>
        </div>
    </div>
    @endif
</div>
