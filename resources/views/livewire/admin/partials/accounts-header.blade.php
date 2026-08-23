<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-heading-lg font-bold text-primary">Accounts Management</h1>
        <p class="text-body-sm text-zinc-500 mt-1">
            Pre-register and manage accounts
        </p>
    </div>

    <div class="flex items-center gap-3">
        <!-- Quick Pre-Register Task Force Button -->
        <button 
            type="button" 
            wire:click="openQuickTfModal"
            class="px-4 py-2 rounded-xl text-body-sm font-bold bg-brand-orange hover:bg-brand-orange-hover text-white transition-all flex items-center gap-2 cursor-pointer shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Quick Pre-Register Task Force</span>
        </button>

        <!-- Standard Pre-Register User Button -->
        <button 
            type="button" 
            wire:click="openCreateModal"
            class="px-4 py-2 rounded-xl text-body-sm font-bold bg-primary hover:bg-primary-hover text-white transition-all flex items-center gap-2 cursor-pointer shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Pre-Register User</span>
        </button>
    </div>
</div>
