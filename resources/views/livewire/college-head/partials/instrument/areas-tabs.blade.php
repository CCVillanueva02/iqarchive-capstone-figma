<!-- Horizontal Area Selector Tablist -->
<div class="flex overflow-x-auto gap-3 pb-2 w-full select-none no-scrollbar">
    @if ($accreditation->instrument)
        @foreach ($accreditation->instrument->areas as $area)
        @php
            $isSelected = ($activeAreaId === $area->id);
            $pCount = $area->parameters->count();
        @endphp
        <button type="button"
            wire:click="selectArea({{ $area->id }})"
            class="shrink-0 min-w-50 bg-white rounded-xl border p-3.5 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-22 {{ $isSelected ? 'border-primary ring-2 ring-primary/20 bg-blue-50/40 shadow-xs' : 'border-slate-200/80 hover:border-slate-300' }}">
            <div>
                <span class="text-label-xs font-extrabold text-primary-muted uppercase tracking-wider block">{{ $area->code }}</span>
                <span class="text-body-sm font-bold text-primary mt-1 leading-tight line-clamp-1 block" title="{{ $area->name }}">{{ $area->name }}</span>
            </div>
            <div class="flex items-center justify-between text-label-xs text-zinc-500 font-semibold pt-1 border-t border-slate-100">
                <span>{{ $pCount }} Params</span>
                <span class="text-primary font-bold">{{ $area->weight ? (float)$area->weight . '%' : 'Weight N/A' }}</span>
            </div>
        </button>
        @endforeach
    @endif
</div>
