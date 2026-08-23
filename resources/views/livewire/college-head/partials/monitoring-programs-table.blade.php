<div class="bg-surface-card border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-heading-sm font-bold text-primary-dark tracking-tight">
                College Degree Programs Directory & Validity Status
            </h2>
            <p class="text-body-sm text-slate-500 mt-0.5">
                Comprehensive directory of academic programs, AACCUP accredited tiers, and certificate expiration timelines.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-label-xs font-semibold px-3 py-1.5 rounded-lg bg-surface-subtle border border-slate-200/80 text-slate-600">
                {{ $allCollegePrograms->count() }} Total {{ Str::plural('Program', $allCollegePrograms->count()) }}
            </span>
        </div>
    </div>

    <!-- Programs Directory Table (Monitoring Format) -->
    <div class="overflow-x-auto rounded-xl border border-slate-200/80 bg-white">
        <table class="w-full text-left border-collapse text-body-sm whitespace-nowrap">
            <thead>
                <tr class="border-b border-slate-200/80 bg-surface-subtle text-slate-500 font-bold uppercase tracking-wider text-label-xs">
                    <th class="py-3 px-4 pl-6 w-32">Program Code</th>
                    <th class="py-3 px-4">Program Title</th>
                    <th class="py-3 px-4 text-center">Current Level</th>
                    <th class="py-3 px-4 text-center">Validity Period</th>
                    <th class="py-3 px-4 text-center">Time Left / Status</th>
                    <th class="py-3 px-4 pr-6 text-right w-28">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($allCollegePrograms as $prog)
                @php
                    $lvl = $prog->accreditation_level;
                    $validityText = match($lvl) {
                        'Level IV', 'Level IV Re-accredited' => 'July 16, 2024 - July 15, 2028',
                        'Level III', 'Level III Re-accredited' => 'Dec 16, 2023 - Dec 15, 2024',
                        'Level II', 'Level II Re-accredited' => 'Nov 01, 2022 - Oct 30, 2026',
                        'Level I', 'Level I Accredited' => 'Jan 13, 2023 - Jan 12, 2027',
                        default => 'Candidate Status',
                    };

                    $statusBadge = match($lvl) {
                        'Level IV', 'Level IV Re-accredited' => ['label' => 'Timely · 1 yr, 10 mos', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
                        'Level III', 'Level III Re-accredited' => ['label' => 'Expired · Late', 'class' => 'bg-rose-100 text-rose-700 border-rose-200'],
                        'Level II', 'Level II Re-accredited' => ['label' => '2 mos left', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                        'Level I', 'Level I Accredited' => ['label' => '5 mos left', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                        default => ['label' => 'Candidate', 'class' => 'bg-slate-100 text-slate-600 border-slate-200'],
                    };
                @endphp
                <tr wire:key="all-col-prog-{{ $prog->id }}" class="hover:bg-slate-50/70 transition-colors group">
                    <!-- Code -->
                    <td class="py-3.5 px-4 pl-6 font-mono font-bold text-primary">
                        {{ $prog->code }}
                    </td>

                    <!-- Title -->
                    <td class="py-3.5 px-4 font-semibold text-slate-800 group-hover:text-brand-orange transition-colors">
                        {{ $prog->name }}
                    </td>

                    <!-- Level -->
                    <td class="py-3.5 px-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-bold {{ str_contains(strtolower($lvl ?? ''), 'level iv') || str_contains(strtolower($lvl ?? ''), 'level iii') ? 'bg-primary text-white' : (str_contains(strtolower($lvl ?? ''), 'level') ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-slate-100 text-slate-600 border border-slate-200') }}">
                            {{ $lvl ?: 'Candidate Status' }}
                        </span>
                    </td>

                    <!-- Validity -->
                    <td class="py-3.5 px-4 text-center font-mono text-label-xs text-slate-600">
                        {{ $validityText }}
                    </td>

                    <!-- Time Left / Status -->
                    <td class="py-3.5 px-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-bold border {{ $statusBadge['class'] }}">
                            {{ $statusBadge['label'] }}
                        </span>
                    </td>

                    <!-- Action -->
                    <td class="py-3.5 px-4 pr-6 text-right">
                        <button 
                            type="button" 
                            wire:click="viewProgramHistory({{ $prog->id }})" 
                            class="inline-flex items-center gap-1 text-body-sm font-semibold text-brand-orange hover:text-brand-orange-hover transition-colors cursor-pointer">
                            <span>History</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400 bg-slate-50/30 text-body-sm">
                        No degree programs found for this college.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
