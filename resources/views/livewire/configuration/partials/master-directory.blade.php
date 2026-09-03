{{--
    IQArchive Colleges & Programs: Master Directory Pane
    Displays Bicol University colleges grouped by campus with quick navigation and active selection states.
--}}

<div class="flex flex-col h-full bg-white">
    <!-- Master Pane Header -->
    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Colleges Directory</h2>
        </div>
    </div>

    <!-- Scrollable Directory List -->
    <div class="divide-y divide-slate-100 overflow-y-auto max-h-187.5 scrollbar-thin">
        @forelse($collegesByCampus as $campusName => $campusColleges)
            <!-- Campus Group Header -->
            <div class="px-4 py-2 bg-slate-100/60 border-y border-slate-200/50 flex items-center justify-between sticky top-0 z-10 backdrop-blur-xs">
                <span class="text-label-xs font-extrabold uppercase tracking-wider text-slate-600">
                    {{ $campusName }}
                </span>
                <span class="text-label-xs font-bold text-slate-400">
                    {{ $campusColleges->count() }}
                </span>
            </div>

            <!-- College Item Rows -->
            <div class="divide-y divide-slate-50">
                @foreach($campusColleges as $college)
                    @php
                        $isSelected = ($selectedCollegeId === $college->id);
                    @endphp
                    <button type="button"
                        wire:click="selectCollege({{ $college->id }})"
                        class="w-full text-left p-3.5 flex items-center justify-between gap-3 transition-all cursor-pointer {{ $isSelected ? 'bg-primary/10 border-l-4 border-primary text-primary font-bold shadow-3xs' : 'hover:bg-slate-50/80 text-slate-700 border-l-4 border-transparent' }}">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <!-- Logo / Fallback Avatar -->
                            <img src="{{ $college->logo }}"
                                alt="{{ $college->code }} Logo"
                                class="w-8 h-8 object-contain shrink-0"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                            <div class="w-8 h-8 rounded-lg items-center justify-center font-black text-label-xs shrink-0 bg-surface-subtle text-primary border border-primary/10" style="display: none;">
                                <span>{{ $college->code }}</span>
                            </div>

                            <div class="flex flex-col min-w-0">
                                <span class="text-body-sm font-semibold truncate leading-tight {{ $isSelected ? 'text-primary font-bold' : 'text-slate-800' }}" title="{{ $college->name }}">
                                    {{ $college->name }}
                                </span>
                                <span class="text-label text-slate-400 mt-0.5">
                                    {{ $college->code }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <span class="px-2 py-0.5 rounded-full text-label-xs font-bold {{ $isSelected ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                {{ $college->programs_count }}
                            </span>
                            <svg class="w-4 h-4 {{ $isSelected ? 'text-primary' : 'text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </button>
                @endforeach
            </div>
        @empty
            <div class="p-8 text-center text-slate-400 text-xs">
                No colleges match your filter.
            </div>
        @endforelse
    </div>
</div>
