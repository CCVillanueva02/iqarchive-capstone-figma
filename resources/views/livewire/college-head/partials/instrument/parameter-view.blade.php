<div class="flex flex-col lg:flex-row gap-6 items-start w-full">
    <!-- Left Pane: Parameters in Active Area -->
    <div class="w-full lg:w-72 shrink-0 flex flex-col gap-3 bg-white border border-slate-200/80 rounded-2xl p-4 shadow-3xs">
        <div class="flex items-center justify-between px-1">
            <span class="text-body-sm font-bold text-primary">Parameters</span>
            <button type="button"
                wire:click="openAddParameterModal"
                class="text-label-xs font-bold text-brand-orange hover:text-brand-orange-hover transition flex items-center gap-1 cursor-pointer">
                + Add Param
            </button>
        </div>

        <div class="flex flex-col gap-1.5">
            @if ($activeArea)
                @forelse ($activeArea->parameters as $param)
                @php
                    $isParamSelected = ($activeParameterId === $param->id);
                    $cCount = $param->criteria->count();
                @endphp
                <button type="button"
                    wire:click="selectParameter({{ $param->id }})"
                    class="w-full text-left p-3 rounded-xl text-body-sm font-semibold flex flex-col gap-1 transition cursor-pointer relative {{ $isParamSelected ? 'bg-slate-100 text-primary border-l-4 border-primary pl-2.5 shadow-2xs font-bold' : 'text-zinc-600 hover:bg-slate-50 hover:text-primary pl-3.5 border-l-4 border-transparent' }}">
                    <div class="flex items-center justify-between">
                        <span class="font-extrabold text-primary text-label-xs uppercase tracking-wide">{{ $param->code }}</span>
                        <span class="text-label-xs font-bold px-1.5 py-0.2 rounded bg-slate-200/80 text-zinc-600">{{ $cCount }}</span>
                    </div>
                    <span class="text-body-sm leading-snug truncate block" title="{{ $param->name }}">{{ $param->name }}</span>
                </button>
                @empty
                <div class="text-center py-6 text-label-xs text-zinc-400 font-medium">
                    No parameters in this area.
                </div>
                @endforelse
            @endif
        </div>
    </div>

    <!-- Right Pane: Parameter Section Checklist Workspace -->
    <div class="flex-1 bg-white border border-slate-200/80 rounded-2xl p-6 shadow-3xs flex flex-col gap-6 w-full">
        @if ($activeParameter)
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-slate-200">
            <div>
                <span class="text-label-xs font-bold text-primary uppercase tracking-wider block">
                    {{ $activeArea?->code }} &bull; {{ $activeParameter->code }}
                </span>
                <h2 class="text-heading-sm font-extrabold text-primary mt-0.5">
                    {{ $activeParameter->name }}
                </h2>
            </div>
            <button type="button"
                wire:click="openAddCriterionModal()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary hover:bg-primary-hover text-white text-body-sm font-bold shadow-3xs transition cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add Criterion</span>
            </button>
        </div>

        <!-- Section Navigation Tabs -->
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
                class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $isActive ? 'border-primary text-primary font-extrabold' : 'border-transparent text-zinc-400 hover:text-zinc-700' }}">
                <span>{{ $meta['title'] }}</span>
                <span class="text-label-xs px-2 py-0.5 rounded-full font-bold {{ $isActive ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-zinc-500' }}">
                    {{ $count }}
                </span>
            </button>
            @endforeach
        </div>

        <!-- Checklist List -->
        <div class="flex flex-col gap-4">
            @forelse ($activeCriteria as $crit)
            <div class="border border-slate-200/80 rounded-xl p-5 flex flex-col gap-3.5 bg-slate-50/30">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <span class="text-body-sm font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full shrink-0">
                            {{ $crit->code }}
                        </span>
                        <div class="flex flex-col">
                            <p class="text-body font-bold text-primary leading-relaxed">{{ $crit->statement }}</p>
                            @if ($crit->description)
                            <p class="text-body-sm text-zinc-500 mt-1 italic">{{ $crit->description }}</p>
                            @endif
                        </div>
                    </div>

                    <button type="button"
                        wire:click="openAddCriterionModal({{ $crit->id }})"
                        class="p-1.5 rounded-lg text-zinc-400 hover:text-primary hover:bg-white transition cursor-pointer"
                        title="Edit Tag Requirements">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>

                <!-- Tags Badges -->
                <div class="pl-11 flex flex-wrap items-center gap-2 pt-2 border-t border-slate-200/60">
                    <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted shrink-0">Required Evidence Tags:</span>
                    @if (!empty($crit->required_tags) && is_array($crit->required_tags))
                        @foreach ($crit->required_tags as $tag)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            {{ $tag }}
                        </span>
                        @endforeach
                    @else
                        <span class="text-label-xs text-zinc-400 italic">No specific tags mapped</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-10 text-body-sm text-zinc-400 font-medium">
                No criteria mapped in this section. Click "+ Add Criterion" to add program-specific criteria.
            </div>
            @endforelse
        </div>
        @else
        <div class="text-center py-16 text-zinc-400 font-medium">
            Select a parameter to view criteria statements.
        </div>
        @endif
    </div>
</div>
