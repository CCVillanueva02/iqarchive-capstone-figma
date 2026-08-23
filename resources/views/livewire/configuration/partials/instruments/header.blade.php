<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-2 border-b border-slate-200">
    <div class="flex flex-col">
        <div class="flex items-center gap-3">
            <h1 class="text-heading-lg font-extrabold text-primary tracking-tight">Accreditation Instruments Builder</h1>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
        @if ($selectedInstrument)
        <button type="button"
            wire:click="openCloneModal({{ $selectedInstrument->id }})"
            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-primary font-bold text-body-sm shadow-3xs transition cursor-pointer">
            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <span>Duplicate Template</span>
        </button>
        @endif

        <button type="button"
            wire:click="openCreateTemplateModal"
            class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-brand-orange hover:bg-brand-orange-hover text-white font-bold text-body-sm shadow-md transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>New Master Template</span>
        </button>
    </div>
</div>
