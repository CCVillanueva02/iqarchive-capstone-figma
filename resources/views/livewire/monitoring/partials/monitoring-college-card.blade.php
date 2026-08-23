@php
    $isExpanded = in_array($college->id, $expandedCollegeIds);
@endphp
<div wire:key="monitoring-college-{{ $college->id }}" class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition-all">
    <!-- College Card Header Row (Collapsible) -->
    <div class="p-5 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3 cursor-pointer select-none flex-1 min-w-0" wire:click="toggleCollegeExpand({{ $college->id }})">
            <!-- Chevron Toggle Button -->
            <button type="button" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 flex items-center justify-center shrink-0 transition-transform duration-200" style="{{ $isExpanded ? '' : 'transform: rotate(-90deg);' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-label-xs font-bold bg-primary text-white">
                        {{ $college->code }}
                    </span>
                    <span class="text-primary font-bold text-heading-sm truncate">
                        {{ $college->name }}
                    </span>
                </div>
                <div class="flex items-center gap-2 mt-0.5 text-label text-slate-500 font-medium">
                    <span>{{ $college->programs->count() }} {{ Str::plural('degree program', $college->programs->count()) }}</span>
                    @if($college->campus)
                    <span>&bull;</span>
                    <span>{{ $college->campus }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button type="button" wire:click="toggleCollegeExpand({{ $college->id }})" class="text-label-xs font-semibold px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-primary-dark transition-colors cursor-pointer">
                {{ $isExpanded ? 'Collapse' : 'Expand' }}
            </button>
        </div>
    </div>

    <!-- Programs Table inside College (Expanded view) -->
    @if($isExpanded)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-body-sm whitespace-nowrap">
            <thead>
                <tr class="border-b border-slate-100 bg-white text-slate-400 font-semibold uppercase tracking-wider text-label">
                    <th class="p-4 pl-6 w-32">Program Code</th>
                    <th class="p-4">Program Title</th>
                    <th class="p-4 text-center">Current Level</th>
                    <th class="p-4 text-center">Validity Period</th>
                    <th class="p-4 text-center">Time Left / Status</th>
                    <th class="p-4 pr-6 text-right w-28">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($college->programs as $program)
                @php
                    $validityText = match($program->accreditation_level) {
                        'Level IV' => 'July 16, 2024 - July 15, 2028',
                        'Level III' => 'Dec 16, 2023 - Dec 15, 2024',
                        'Level II' => 'Nov 01, 2022 - Oct 30, 2026',
                        'Level I' => 'Jan 13, 2023 - Jan 12, 2027',
                        default => 'Candidate Status',
                    };

                    $statusBadge = match($program->accreditation_level) {
                        'Level IV' => ['label' => 'Timely · 1 yr, 10 mos', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
                        'Level III' => ['label' => 'Expired · Late', 'class' => 'bg-rose-100 text-rose-700 border-rose-200'],
                        'Level II' => ['label' => '2 mos left', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                        'Level I' => ['label' => '5 mos left', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                        default => ['label' => 'Candidate', 'class' => 'bg-slate-100 text-slate-600 border-slate-200'],
                    };
                @endphp
                <tr wire:key="monitoring-program-{{ $program->id }}" class="hover:bg-slate-50/60 transition-colors cursor-pointer group" wire:click="viewProgramHistory({{ $program->id }})">
                    <!-- Code -->
                    <td class="p-4 pl-6 font-mono font-bold text-primary text-body-sm">
                        {{ $program->code }}
                    </td>

                    <!-- Title -->
                    <td class="p-4 font-semibold text-slate-800 group-hover:text-brand-orange transition-colors">
                        {{ $program->name }}
                    </td>

                    <!-- Level -->
                    <td class="p-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label font-bold {{ $program->accreditation_level === 'Level IV' || $program->accreditation_level === 'Level III' ? 'bg-primary text-white' : 'bg-primary/10 text-primary border border-primary/20' }}">
                            {{ $program->accreditation_level ?: 'Candidate Status' }}
                        </span>
                    </td>

                    <!-- Validity -->
                    <td class="p-4 text-center font-mono text-label-xs text-slate-600">
                        {{ $validityText }}
                    </td>

                    <!-- Time Left / Status -->
                    <td class="p-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-bold border {{ $statusBadge['class'] }}">
                            {{ $statusBadge['label'] }}
                        </span>
                    </td>

                    <!-- Action -->
                    <td class="p-4 pr-6 text-right">
                        <button type="button" wire:click.stop="viewProgramHistory({{ $program->id }})" class="inline-flex items-center gap-1 text-body-sm font-semibold text-brand-orange hover:text-brand-orange-hover transition-colors cursor-pointer">
                            <span>History</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-slate-400 bg-slate-50/30 text-body-sm">
                        No degree programs match your filter criteria for this college.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>
