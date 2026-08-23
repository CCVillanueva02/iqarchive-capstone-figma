<flux:modal wire:model="showDeleteModal" class="max-w-md md:min-w-md no-scrollbar scrollbar-none" @close="closeDeleteModal">
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $targetUserStatus === 'active' || $targetUserStatus === 'pending_activation' ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }}">
                @if($targetUserStatus === 'active' || $targetUserStatus === 'pending_activation')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @endif
            </div>
            <div>
                <flux:heading size="lg">
                    {{ $targetUserStatus === 'active' || $targetUserStatus === 'pending_activation' ? __('Deactivate Account') : __('Activate Account') }}
                </flux:heading>
                <flux:subheading class="mt-1 text-xs text-slate-500">
                    {{ $targetUserStatus === 'active' || $targetUserStatus === 'pending_activation' 
                        ? __('Are you sure you want to deactivate this account? The user will be unable to sign in via Google OAuth.') 
                        : __('Are you sure you want to restore and activate this user account?') }}
                </flux:subheading>
            </div>
        </div>

        <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeDeleteModal">{{ __('Cancel') }}</flux:button>
            <button 
                type="button" 
                wire:click="toggleAccountStatus" 
                class="px-4 py-2 rounded-xl text-body-sm font-bold text-white transition-colors cursor-pointer shadow-xs {{ $targetUserStatus === 'active' || $targetUserStatus === 'pending_activation' ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                {{ $targetUserStatus === 'active' || $targetUserStatus === 'pending_activation' ? __('Deactivate') : __('Activate') }}
            </button>
        </div>
    </div>
</flux:modal>
