<div class="flex flex-col gap-6">
    <!-- Filter Controls Panel -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto flex-1">
            <!-- Search Input -->
            <div class="w-full sm:w-72">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search program name or code..." icon="magnifying-glass" size="sm" />
            </div>

            <!-- College Filter -->
            <div class="w-full sm:w-56">
                <flux:select wire:model.live="collegeFilter" size="sm">
                    <flux:select.option value="all">All Colleges &amp; Units</flux:select.option>
                    @foreach($colleges as $col)
                    <flux:select.option value="{{ $col->id }}">{{ $col->code }} - {{ $col->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <!-- Level Filter -->
            <div class="w-full sm:w-52">
                <flux:select wire:model.live="levelFilter" size="sm">
                    <flux:select.option value="all">All Accreditation Levels</flux:select.option>
                    <flux:select.option value="Level IV">Level IV</flux:select.option>
                    <flux:select.option value="Level III">Level III</flux:select.option>
                    <flux:select.option value="Level II">Level II</flux:select.option>
                    <flux:select.option value="Level I">Level I</flux:select.option>
                    <flux:select.option value="Candidate Status">Candidate Status</flux:select.option>
                </flux:select>
            </div>
        </div>

        <!-- Accordion Toggles -->
        <div class="flex items-center gap-2 self-end md:self-center shrink-0">
            <button type="button" wire:click="expandAll" class="text-label-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors cursor-pointer">
                Expand All
            </button>
            <button type="button" wire:click="collapseAll" class="text-label-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors cursor-pointer">
                Collapse All
            </button>
        </div>
    </div>

    <!-- Colleges & Programs Accordion List -->
    <div class="flex flex-col gap-5">
        @forelse($groupedColleges as $college)
            @include('livewire.monitoring.partials.monitoring-college-card', ['college' => $college])
        @empty
        <div class="bg-white border border-slate-200/80 rounded-2xl p-12 text-center text-slate-400 shadow-xs flex flex-col items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
                </svg>
            </div>
            <p class="font-bold text-primary-dark text-heading-sm">No Colleges or Programs Found</p>
            <p class="text-body-sm text-slate-500">No degree programs match your search query or selected filter criteria.</p>
        </div>
        @endforelse
    </div>
</div>
