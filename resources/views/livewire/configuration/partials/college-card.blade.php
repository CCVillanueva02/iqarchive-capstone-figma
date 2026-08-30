@php
    $isExpanded = in_array($college->id, $expandedCollegeIds);
@endphp
<div wire:key="college-card-{{ $college->id }}" class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden transition-all">
    <!-- College Card Header Row (Collapsed State View) -->
    <div class="p-5 bg-slate-50/70 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3 cursor-pointer select-none flex-1 min-w-0" wire:click="toggleCollegeExpand({{ $college->id }})">
            <!-- Chevron Toggle Icon -->
            <button type="button" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 flex items-center justify-center shrink-0 transition-transform duration-200" style="{{ $isExpanded ? '' : 'transform: rotate(-90deg);' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <img src="{{ $college->logo }}" alt="{{ $college->code }} Logo" class="w-8 h-8 object-contain shrink-0" onerror="this.style.display='none'">
                    <!-- College / Unit Name -->
                    <span class="text-primary font-bold text-heading-sm truncate">{{ $college->name }}</span>
                </div>
                <!-- Simplified Muted Program Count Label -->
                <span class="text-label text-slate-500 font-medium mt-0.5">
                    {{ $college->programs->count() }} {{ Str::plural('program', $college->programs->count()) }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2 self-end sm:self-center">
            @if($canManage)
            <flux:button variant="ghost" size="sm" icon="plus" wire:click="openCreateProgramModal({{ $college->id }})" title="Add Program to {{ $college->code }}">
                <span class="hidden sm:inline">Add Program</span>
            </flux:button>
            <flux:button variant="ghost" size="sm" icon="pencil-square" wire:click="openEditCollegeModal({{ $college->id }})" title="Edit College Details" />
            <flux:button variant="ghost" size="sm" icon="trash" class="text-rose-600 hover:text-rose-700" wire:click="openDeleteCollegeModal({{ $college->id }})" title="Delete College" />
            @endif
        </div>
    </div>

    <!-- Full Programs Table inside College (Renders ONLY when expanded) -->
    @if($isExpanded)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-slate-100 bg-white text-slate-400 font-semibold uppercase tracking-wider">
                    <th class="p-4 pl-6 w-32">Code</th>
                    <th class="p-4">Program Title</th>
                    <th class="p-4">Accreditation Level</th>
                    @if($canManage)
                    <th class="p-4 pr-6 text-right w-28">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($college->programs as $program)
                <tr wire:key="program-row-{{ $program->id }}" class="hover:bg-slate-50/50 transition-colors text-slate-700">
                    <!-- Code -->
                    <td class="p-4 pl-6 font-mono font-bold text-primary text-body-sm">
                        {{ $program->code }}
                    </td>

                    <!-- Title -->
                    <td class="p-4 font-semibold text-slate-800 text-body-sm">
                        {{ $program->name }}
                    </td>

                    <!-- Accreditation Level Badge -->
                    <td class="p-4">
                        @php
                            $lvl = $program->accreditation_level ?: 'Candidate Status';
                            $badgeStyle = match(true) {
                                str_contains($lvl, 'Level IV') => 'bg-purple-50 text-purple-700 border-purple-200',
                                str_contains($lvl, 'Level III') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                str_contains($lvl, 'Level II') => 'bg-surface-subtle text-primary border-primary/15',
                                str_contains($lvl, 'Level I') => 'bg-amber-50 text-amber-800 border-amber-200',
                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label font-bold border {{ $badgeStyle }}">
                            {{ $lvl }}
                        </span>
                    </td>

                    <!-- Actions -->
                    @if($canManage)
                    <td class="p-4 pr-6 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <flux:button variant="ghost" size="sm" icon="pencil-square" wire:click="openEditProgramModal({{ $program->id }})" title="Edit Program" />
                            <flux:button variant="ghost" size="sm" icon="trash" class="text-rose-600 hover:text-rose-700" wire:click="openDeleteProgramModal({{ $program->id }})" title="Soft Delete Program" />
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $canManage ? '4' : '3' }}" class="p-6 text-center text-zinc-400 bg-slate-50/30">
                        <span class="text-body-sm font-medium">No degree programs listed under this college yet.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>
