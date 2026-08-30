<div class="w-full lg:w-80 shrink-0 flex flex-col gap-4">
    <!-- Areas Section Header -->
    <div class="bg-white border border-slate-200/80 rounded-xl p-4 shadow-3xs flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h2 class="text-body font-bold text-primary">Accreditation Areas</h2>
            </div>
            <button type="button"
                wire:click="openAreaModal()"
                class="text-label-xs font-bold text-brand-orange hover:text-brand-orange-hover transition flex items-center gap-1 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Area</span>
            </button>
        </div>

        @if ($selectedInstrument)
        <!-- Area List -->
        <div class="flex flex-col gap-1.5 max-h-[550px] overflow-y-auto pr-1 no-scrollbar">
            @forelse ($selectedInstrument->areas as $area)
            @php
                $isAreaSelected = ($activeAreaId === $area->id);
                $pCount = $area->parameters->count();
            @endphp
            <div class="flex flex-col rounded-xl border transition {{ $isAreaSelected ? 'border-primary bg-slate-50/70 shadow-2xs' : 'border-slate-200/70 bg-white hover:border-slate-300' }}">
                <!-- Area Header Row -->
                <div class="flex items-center justify-between p-3 gap-2">
                    <button type="button"
                        wire:click="selectArea({{ $area->id }})"
                        class="flex-1 text-left flex items-start gap-2.5 min-w-0 cursor-pointer">
                        <span class="px-2 py-0.5 rounded text-label-xs font-extrabold uppercase shrink-0 {{ $isAreaSelected ? 'bg-primary text-white' : 'bg-slate-100 text-primary-muted' }}">
                            {{ $area->code }}
                        </span>
                        <div class="min-w-0">
                            <span class="text-body-sm font-bold leading-tight block truncate {{ $isAreaSelected ? 'text-primary' : 'text-zinc-700' }}" title="{{ $area->name }}">
                                {{ $area->name }}
                            </span>
                            <span class="text-label-xs text-zinc-400 mt-0.5 block">
                                {{ $pCount }} Parameters &bull; {{ $area->weight ? (float)$area->weight . '%' : 'Weight N/A' }}
                            </span>
                        </div>
                    </button>

                    <!-- Area Actions Dropdown / Buttons -->
                    <div class="flex items-center gap-1 shrink-0">
                        <button type="button"
                            wire:click="openAreaModal({{ $area->id }})"
                            title="Edit Area"
                            class="p-1 rounded-lg text-zinc-400 hover:text-primary hover:bg-slate-100 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button type="button"
                            wire:click="confirmDelete('area', {{ $area->id }}, '{{ $area->code }}: {{ $area->name }}')"
                            title="Delete Area"
                            class="p-1 rounded-lg text-zinc-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Nested Parameters inside Area -->
                @if ($isAreaSelected)
                <div class="px-3 pb-3 pt-1 border-t border-slate-200/60 flex flex-col gap-1.5 bg-white/70 rounded-b-xl">
                    <div class="flex items-center justify-between pt-1">
                        <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted">Parameters</span>
                        <button type="button"
                            wire:click="openParameterModal()"
                            class="text-label-xs font-bold text-primary hover:underline cursor-pointer">
                            + Add Parameter
                        </button>
                    </div>

                    @forelse ($area->parameters as $param)
                    @php
                        $isParamSelected = ($activeParameterId === $param->id);
                        $cTotal = $param->criteria->count();
                    @endphp
                    <div class="flex items-center justify-between p-2 rounded-lg text-body-sm transition {{ $isParamSelected ? 'bg-primary text-white font-bold' : 'bg-slate-50 hover:bg-slate-100/70 text-zinc-700 font-semibold' }}">
                        <button type="button"
                            wire:click="selectParameter({{ $param->id }})"
                            class="flex-1 text-left flex items-center justify-between pr-2 min-w-0 cursor-pointer">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="text-label-xs font-extrabold uppercase shrink-0 {{ $isParamSelected ? 'text-white/80' : 'text-primary' }}">{{ $param->code }}</span>
                                <span class="truncate block">{{ $param->name }}</span>
                            </div>
                            <span class="text-label-xs shrink-0 px-1.5 py-0.2 rounded {{ $isParamSelected ? 'bg-white/20 text-white' : 'bg-slate-200 text-zinc-600' }}">{{ $cTotal }}</span>
                        </button>

                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button"
                                wire:click="openParameterModal({{ $param->id }})"
                                class="p-1 rounded {{ $isParamSelected ? 'text-white/70 hover:text-white' : 'text-zinc-400 hover:text-primary' }} cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-2 text-label-xs text-zinc-400">
                        No parameters. Click "+ Add Parameter"
                    </div>
                    @endforelse
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-8 text-body-sm text-zinc-400">
                No areas defined. Click "+ Add Area" above.
            </div>
            @endforelse
        </div>
        @endif
    </div>
</div>
