<!-- Filter & Search Control Panel -->
<div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs p-6 flex flex-col lg:flex-row items-center justify-between gap-4">
    <div class="w-full lg:w-72">
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Search college, program, or campus..." icon="magnifying-glass" />
    </div>

    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('Campus:') }}</span>
            <flux:select wire:model.live="campusFilter" placeholder="All Campuses" class="w-full sm:w-44">
                <flux:select.option value="">All Campuses</flux:select.option>
                @foreach($campusesList as $camp)
                <flux:select.option value="{{ $camp }}">{{ $camp }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('College:') }}</span>
            <flux:select wire:model.live="collegeFilter" placeholder="All Colleges" class="w-full sm:w-48">
                <flux:select.option value="">All Colleges</flux:select.option>
                @foreach($allCollegesDropdown as $col)
                <flux:select.option value="{{ $col->id }}">{{ $col->name }} ({{ $col->code }})</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('Level:') }}</span>
            <flux:select wire:model.live="levelFilter" placeholder="All Accreditation Levels" class="w-full sm:w-52">
                <flux:select.option value="">All Accreditation Levels</flux:select.option>
                @foreach($accreditationLevels as $lvl)
                <flux:select.option value="{{ $lvl }}">{{ $lvl }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>
</div>
