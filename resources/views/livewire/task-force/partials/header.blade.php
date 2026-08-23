<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-heading-lg font-bold text-primary flex items-center gap-2.5">
            <svg class="w-7 h-7 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm14 10v-2a4 4 0 010 7.75"></path>
            </svg>
            Task Force Management
        </h1>
        <p class="text-body-sm text-zinc-500 mt-1">Assemble accreditation task forces, review Dean nominations, and monitor area preparation progress.</p>
    </div>

    @if($this->canCreate)
    <div>
        <button 
            type="button" 
            wire:click="openCreateModal"
            class="px-4 py-2.5 rounded-xl font-bold text-body-sm bg-brand-orange hover:bg-brand-orange-hover text-white transition-colors cursor-pointer shadow-xs flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Create Task Force</span>
        </button>
    </div>
    @endif
</div>
