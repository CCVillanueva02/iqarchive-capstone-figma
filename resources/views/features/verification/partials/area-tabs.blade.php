<!-- Horizontal Area I-X Tablist for Dean Verification -->
<div class="flex overflow-x-auto gap-3 pb-2 w-full select-none">
    @if($instrument && $instrument->areas->isNotEmpty())
        @foreach($instrument->areas as $area)
            @php
                $isActive = $activeAreaId === $area->id;
                $areaParamIds = $area->parameters->pluck('id')->toArray();
                $areaDocs = $allProgramDocs->filter(function($doc) use ($areaParamIds) {
                    foreach ($doc->accreditationLinks as $link) {
                        $crit = $link->complianceRequirement?->criterion;
                        if ($crit && in_array($crit->instrument_parameter_id, $areaParamIds)) {
                            return true;
                        }
                    }
                    return false;
                });
                $areaTotal = $areaDocs->count();
                $areaVerified = $areaDocs->where('status', 'verified')->count();
                $areaPct = $areaTotal > 0 ? (int) round(($areaVerified / $areaTotal) * 100) : 0;
            @endphp
            <button type="button"
                wire:click="selectArea({{ $area->id }})"
                class="flex-1 shrink-0 min-w-48 bg-white rounded-2xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24 {{ $isActive ? 'border-primary ring-1 ring-primary/30 shadow-xs' : 'border-zinc-200/80 hover:border-zinc-300' }}">
                <div class="flex items-center justify-between w-full">
                    <span class="text-label-xs font-bold uppercase tracking-wider block {{ $isActive ? 'text-primary' : 'text-zinc-400' }}">
                        {{ $area->code }}
                    </span>
                    <span class="px-2 py-0.5 rounded text-label-xs font-bold {{ $areaTotal > 0 && $areaVerified === $areaTotal ? 'bg-emerald-50 text-emerald-700' : 'bg-zinc-100 text-zinc-600' }}">
                        {{ $areaVerified }}/{{ $areaTotal }}
                    </span>
                </div>
                <span class="text-xs font-bold mt-1 line-clamp-1 block {{ $isActive ? 'text-primary' : 'text-zinc-700' }}">
                    {{ $area->name }}
                </span>
                <div class="w-full mt-2">
                    <div class="w-full h-1 bg-zinc-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ $areaPct }}%"></div>
                    </div>
                </div>
            </button>
        @endforeach
    @else
        <div class="p-4 bg-white border border-zinc-200 rounded-xl text-body-sm text-zinc-500">
            No instrument areas found for this accreditation cycle.
        </div>
    @endif
</div>
