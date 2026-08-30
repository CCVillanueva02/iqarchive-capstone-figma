<div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-3xs flex flex-col gap-4">
    <!-- Top Filter Bar -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 pb-3 border-b border-slate-100">
        <!-- Search -->
        <div class="relative flex-1">
            <svg class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search templates by code, name, or description..."
                class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-body-sm font-medium text-primary placeholder-zinc-400 focus:bg-white focus:ring-2 focus:ring-brand-orange focus:border-transparent transition">
        </div>

        <!-- Filter Selects -->
        <div class="flex items-center gap-2.5">
            <select wire:model.live="typeFilter" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-body-sm font-semibold text-primary focus:ring-2 focus:ring-brand-orange focus:bg-white transition cursor-pointer">
                <option value="templates">Master Templates Only</option>
                <option value="program_instances">Program Instances Only</option>
                <option value="all">All Instruments</option>
            </select>

            <select wire:model.live="levelFilter" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-body-sm font-semibold text-primary focus:ring-2 focus:ring-brand-orange focus:bg-white transition cursor-pointer">
                <option value="">All Levels</option>
                <option value="Candidate">Candidate</option>
                <option value="Level I">Level I</option>
                <option value="Level II">Level II</option>
                <option value="Level III">Level III</option>
                <option value="Level IV">Level IV</option>
            </select>
        </div>
    </div>

    <!-- Template Horizontal Picker List -->
    <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
        @forelse ($instrumentsCatalog as $inst)
        @php
            $isSelected = ($selectedInstrumentId === $inst->id);
            $areaCount = $inst->areas->count();
            $paramCount = $inst->areas->sum(fn($a) => $a->parameters->count());
        @endphp
        <button type="button"
            wire:click="selectInstrument({{ $inst->id }})"
            class="shrink-0 min-w-65 max-w-xs text-left p-4 rounded-xl border transition-all cursor-pointer flex flex-col justify-between gap-3 {{ $isSelected ? 'bg-surface-subtle/60 border-primary shadow-xs ring-2 ring-primary/20' : 'bg-white hover:bg-slate-50 border-slate-200/80 shadow-3xs' }}">
            <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-label-xs font-bold px-2 py-0.5 rounded {{ $inst->is_template ? 'bg-primary text-white' : 'bg-emerald-100 text-emerald-800' }}">
                        {{ $inst->is_template ? 'Master Template' : ($inst->program ? $inst->program->code : 'Instance') }}
                    </span>
                    <span class="text-label-xs font-extrabold text-zinc-500">{{ $inst->level }}</span>
                </div>
                <h3 class="text-body-sm font-bold text-primary leading-tight mt-1 line-clamp-1" title="{{ $inst->name }}">
                    {{ $inst->name }}
                </h3>
                <span class="text-label-xs text-primary-muted font-mono">{{ $inst->code }}</span>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-slate-100/80 text-label-xs text-zinc-500 font-semibold">
                <span>{{ $areaCount }} Areas &bull; {{ $paramCount }} Params</span>
                <span class="text-primary font-bold">v{{ $inst->version }}</span>
            </div>
        </button>
        @empty
        <div class="w-full text-center py-6 text-body-sm text-zinc-400 font-medium">
            No instruments match the selected filter.
        </div>
        @endforelse
    </div>
</div>
