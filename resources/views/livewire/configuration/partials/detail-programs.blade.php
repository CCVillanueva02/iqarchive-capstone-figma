{{--
    IQArchive Colleges & Programs: Detail Programs Pane
    Displays the selected college's hero identity, management actions, and degree programs matrix.
--}}

@if($selectedCollege)
<div class="flex flex-col gap-6">
    <!-- Selected College Hero Card -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col sm:flex-row sm:items-center justify-between gap-5">
        <div class="flex items-center gap-4 min-w-0">
            <!-- College Large Seal -->
            <img src="{{ $selectedCollege->logo }}"
                alt="{{ $selectedCollege->code }} Logo"
                class="w-14 h-14 object-contain shrink-0"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
            <div class="w-14 h-14 rounded-2xl items-center justify-center font-black text-sm shrink-0 bg-surface-subtle text-primary border border-primary/10" style="display: none;">
                <span>{{ $selectedCollege->code }}</span>
            </div>

            <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <h2 class="text-heading-md font-bold text-primary truncate" title="{{ $selectedCollege->name }}">
                        {{ $selectedCollege->name }}
                    </h2>
                </div>
                <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                    <span class="text-xs font-bold text-primary">
                        {{ $selectedCollege->programs->count() }} {{ Str::plural('Program', $selectedCollege->programs->count()) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- College-Level Actions Toolbar -->
        @if($canManage)
        <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
            <flux:button variant="primary" size="sm" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-3xs" icon="plus" wire:click="openCreateProgramModal({{ $selectedCollege->id }})">
                <span>Add Program</span>
            </flux:button>
            <flux:button variant="outline" size="sm" icon="pencil-square" wire:click="openEditCollegeModal({{ $selectedCollege->id }})" title="Edit College" />
            <flux:button variant="ghost" size="sm" icon="trash" class="text-rose-600 hover:text-rose-700" wire:click="openDeleteCollegeModal({{ $selectedCollege->id }})" title="Delete College" />
        </div>
        @endif
    </div>

    <!-- Programs Matrix Table Container -->
    <div class="bg-white border border-slate-200/70 rounded-2xl shadow-3xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Degree Programs Matrix</h3>
            </div>
        </div>

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
                    @forelse($selectedCollege->programs as $program)
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
                                <flux:button variant="ghost" size="sm" icon="trash" class="text-rose-600 hover:text-rose-700" wire:click="openDeleteProgramModal({{ $program->id }})" title="Delete Program" />
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $canManage ? '4' : '3' }}" class="p-12 text-center text-zinc-400 bg-slate-50/20">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <span class="text-body-sm font-semibold text-slate-600">No degree programs listed under {{ $selectedCollege->code }}</span>
                                @if($canManage)
                                <button type="button" wire:click="openCreateProgramModal({{ $selectedCollege->id }})" class="mt-1 text-xs font-bold text-brand-orange hover:underline cursor-pointer">
                                    + Add the first degree program
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="bg-white border border-slate-200/60 rounded-2xl p-16 text-center text-zinc-400 shadow-3xs flex flex-col items-center gap-3">
    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
    </div>
    <p class="font-bold text-primary text-heading-sm">No College Selected</p>
    <p class="text-body-sm text-zinc-500">Select an academic college from the directory to view its degree programs.</p>
</div>
@endif
