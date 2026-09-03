<div class="p-6 space-y-6">
    <!-- Category Switcher Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-3 rounded-xl border border-zinc-200 shadow-3xs">
        <div class="flex items-center gap-1.5 flex-wrap">
            <button wire:click="switchProgramCategory('supporting-documents')"
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'supporting-documents' ? 'bg-primary text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-100' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Supporting Documents
            </button>

            <button wire:click="switchProgramCategory('self-survey')"
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'self-survey' ? 'bg-primary text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-100' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Self-Survey Matrix
            </button>

            <button wire:click="switchProgramCategory('compliance-reports')"
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'compliance-reports' ? 'bg-primary text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-100' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Compliance Reports
            </button>

            <button wire:click="switchProgramCategory('narrative-profile')"
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'narrative-profile' ? 'bg-primary text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-100' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Narrative Profile
            </button>
        </div>

        @if($programCategory === 'supporting-documents')
            <button wire:click="openEvidenceUploadModal" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 shadow-sm transition shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Upload Evidence
            </button>
        @endif
    </div>

    <!-- Category Views -->
    @if($programCategory === 'supporting-documents')
        @include('livewire.documents.partials.program.supporting-documents')
    @elseif($programCategory === 'self-survey')
        @include('livewire.documents.partials.program.self-survey')
    @elseif($programCategory === 'compliance-reports')
        @include('livewire.documents.partials.program.compliance-reports')
    @elseif($programCategory === 'narrative-profile')
        @include('livewire.documents.partials.program.narrative-profile')
    @endif
</div>
