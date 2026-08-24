<div class="flex-1 bg-white border border-slate-200/80 rounded-xl p-6 shadow-3xs flex flex-col gap-6 w-full">
    @if ($activeParameter)
    <!-- Parameter Banner Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-label-xs font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800 uppercase tracking-wider">
                    {{ $activeArea?->code }} &bull; {{ $activeParameter->code }}
                </span>
                <span class="text-label-xs text-zinc-400 font-bold uppercase">Section Benchmark Editor</span>
            </div>
            <h2 class="text-heading-sm font-extrabold text-primary mt-1">
                {{ $activeParameter->code }} — {{ $activeParameter->name }}
            </h2>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button type="button"
                wire:click="openAddCriterionModal()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary hover:bg-primary-hover text-white text-body-sm font-semibold shadow-xs transition cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Criterion</span>
            </button>
        </div>
    </div>

    <!-- 4-Section Standard Tabs -->
    <div class="flex border-b border-slate-200 gap-6 text-body-sm font-bold -mt-2 overflow-x-auto no-scrollbar">
        @php
            $sections = [
                'systems' => ['title' => 'Systems - Inputs & Processes', 'prefix' => 'S'],
                'implementation' => ['title' => 'Implementation', 'prefix' => 'I'],
                'outcomes' => ['title' => 'Outcomes', 'prefix' => 'O'],
                'best_practices' => ['title' => 'Best Practices', 'prefix' => 'BP'],
            ];
        @endphp

        @foreach ($sections as $key => $meta)
        @php
            $isActive = ($activeSection === $key);
            $count = $activeParameter->criteria->where('section', $key)->count();
        @endphp
        <button type="button"
            wire:click="setSection('{{ $key }}')"
            class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $isActive ? 'border-brand-orange text-brand-orange' : 'border-transparent text-zinc-500 hover:text-primary' }}">
            <span>{{ $meta['title'] }}</span>
            <span class="text-label-xs px-2 py-0.5 rounded-full font-extrabold {{ $isActive ? 'bg-orange-100 text-brand-orange' : 'bg-slate-100 text-zinc-500' }}">
                {{ $count }}
            </span>
        </button>
        @endforeach
    </div>

    <!-- Criteria Items List for Active Section -->
    <div class="flex flex-col gap-4">
        @forelse ($activeCriteria as $crit)
        <div class="border border-slate-200/80 rounded-xl p-5 bg-slate-50/40 hover:bg-slate-50/80 transition flex flex-col gap-3.5">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-3 min-w-0">
                    <span class="text-body-sm font-extrabold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200 shrink-0">
                        {{ $crit->code }}
                    </span>
                    <div class="flex flex-col">
                        <p class="text-body font-bold text-primary leading-relaxed">
                            {{ $crit->statement }}
                        </p>
                        @if ($crit->description)
                        <p class="text-body-sm text-zinc-500 mt-1 italic">
                            {{ $crit->description }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Item Actions -->
                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="button"
                        wire:click="openAddCriterionModal({{ $crit->id }})"
                        class="p-1.5 rounded-lg text-zinc-400 hover:text-primary hover:bg-white transition cursor-pointer"
                        title="Edit Criterion & Tags">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <button type="button"
                        wire:click="openDeleteModal('criterion', {{ $crit->id }}, '{{ $crit->code }}: {{ substr($crit->statement, 0, 30) }}...')"
                        class="p-1.5 rounded-lg text-zinc-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                        title="Delete Criterion">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Required Document Tags Badges -->
            <div class="pl-11 flex flex-wrap items-center gap-2 pt-2 border-t border-slate-200/60">
                <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted shrink-0">
                    Required Evidence Tags:
                </span>
                @if (!empty($crit->required_tags) && is_array($crit->required_tags))
                    @foreach ($crit->required_tags as $tag)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-label-xs font-bold bg-blue-100/70 text-blue-800 border border-blue-200">
                        <span>{{ $tag }}</span>
                    </span>
                    @endforeach
                @else
                    <span class="text-label-xs text-zinc-400 italic">No specific tags mapped</span>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-12 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center gap-2">
            <svg class="w-8 h-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-body-sm font-bold text-zinc-400">No criteria defined in this section.</span>
            <button type="button"
                wire:click="openAddCriterionModal()"
                class="text-body-sm font-bold text-brand-orange hover:underline cursor-pointer">
                + Add First Criterion
            </button>
        </div>
        @endforelse
    </div>
    @else
    <div class="text-center py-16 flex flex-col items-center justify-center gap-2 text-zinc-400">
        <svg class="w-10 h-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
        </svg>
        <span class="text-body font-semibold">Select a parameter from the left pane to view benchmark criteria.</span>
    </div>
    @endif
</div>
