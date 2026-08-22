<div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-label text-primary-muted font-bold uppercase tracking-wider mb-1">
                <span>Configuration</span>
                <span>&bull;</span>
                <span>Institutional Structure</span>
            </div>
            <h1 class="text-heading-lg font-bold text-primary">Colleges &amp; Programs</h1>
            <p class="text-body-sm text-zinc-500 mt-1">Manage Bicol University campuses, colleges, academic units, and degree program accreditation levels.</p>
        </div>

        @if($canManage)
        <div class="flex items-center gap-3">
            <flux:button variant="outline" class="font-semibold shadow-xs" icon="plus" wire:click="openCreateCollegeModal">
                {{ __('Add College / Satellite') }}
            </flux:button>
            <flux:button variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs" icon="plus" wire:click="openCreateProgramModal()">
                {{ __('Add Program') }}
            </flux:button>
        </div>
        @endif
    </div>

    <!-- Summary Stats Bar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        <!-- 1. Colleges & Satellites Simple Count Card -->
        <div class="lg:col-span-3 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-primary flex items-center justify-center font-bold shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-label text-slate-500 font-medium uppercase tracking-wider">Colleges &amp; Satellites</span>
                <span class="text-heading font-bold text-primary mt-0.5">{{ $totalColleges }}</span>
            </div>
        </div>

        <!-- 2. Degree Programs Simple Count Card -->
        <div class="lg:col-span-3 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-brand-orange flex items-center justify-center font-bold shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-label text-slate-500 font-medium uppercase tracking-wider">Degree Programs</span>
                <span class="text-heading font-bold text-primary mt-0.5">{{ $totalPrograms }}</span>
            </div>
        </div>

        <!-- 3. Accreditation Progress Visualization Card -->
        <div class="lg:col-span-6 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2 mb-2">
                <span class="text-label text-slate-500 font-medium uppercase tracking-wider">Accreditation Progress</span>
                <span class="text-label font-bold text-slate-600">{{ $totalPrograms }} {{ Str::plural('program', $totalPrograms) }} total</span>
            </div>

            <!-- Segmented Progress Bar -->
            <div class="w-full h-3.5 bg-slate-100 rounded-full overflow-hidden flex shadow-inner">
                @foreach($levelBreakdown as $levelKey => $data)
                    @php
                        $pct = $totalPrograms > 0 ? ($data['count'] / $totalPrograms) * 100 : 0;
                    @endphp
                    @if($pct > 0)
                    <div class="{{ $data['barColor'] }} h-full transition-all duration-300" style="width: {{ $pct }}%;" title="{{ $data['label'] }}: {{ $data['count'] }} ({{ round($pct, 1) }}%)"></div>
                    @endif
                @endforeach
                @if($totalPrograms === 0)
                    <div class="bg-slate-200 h-full w-full" title="No programs"></div>
                @endif
            </div>

            <!-- Legend Swatches -->
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-3 text-label font-medium text-slate-600">
                @foreach($levelBreakdown as $levelKey => $data)
                <div class="flex items-center gap-1.5" title="{{ $levelKey }}">
                    <span class="w-2.5 h-2.5 rounded-full {{ $data['dotColor'] }} shrink-0"></span>
                    <span>{{ $data['label'] }}</span>
                    <span class="font-bold text-slate-800">({{ $data['count'] }})</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Filter & Search Control Panel -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs p-6 flex flex-col lg:flex-row items-center justify-between gap-4">
        <div class="w-full lg:w-72">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search college, program, or campus..." icon="magnifying-glass" />
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('Campus:') }}</span>
                <flux:select wire:model.live="campusFilter" placeholder="All Campuses" class="w-full sm:w-44">
                    <flux:select.option value="">All Campuses</flux:select.option>
                    @foreach($campusesList as $camp)
                    <flux:select.option value="{{ $camp }}">{{ $camp }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('College:') }}</span>
                <flux:select wire:model.live="collegeFilter" placeholder="All Colleges" class="w-full sm:w-48">
                    <flux:select.option value="">All Colleges</flux:select.option>
                    @foreach($allCollegesDropdown as $col)
                    <flux:select.option value="{{ $col->id }}">{{ $col->name }} ({{ $col->code }})</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('Level:') }}</span>
                <flux:select wire:model.live="levelFilter" placeholder="All Accreditation Levels" class="w-full sm:w-52">
                    <flux:select.option value="">All Accreditation Levels</flux:select.option>
                    @foreach($accreditationLevels as $lvl)
                    <flux:select.option value="{{ $lvl }}">{{ $lvl }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>

    <!-- Colleges & Programs List -->
    <div class="flex flex-col gap-5">
        @forelse($colleges as $college)
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
                                        str_contains($lvl, 'Level II') => 'bg-blue-50 text-blue-700 border-blue-200',
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
        @empty
        <div class="bg-white border border-slate-200/60 rounded-2xl p-12 text-center text-zinc-400 shadow-3xs flex flex-col items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
                </svg>
            </div>
            <p class="font-bold text-primary text-heading-sm">No Colleges or Programs Found</p>
            <p class="text-body-sm text-zinc-500">No entries match your search query or selected filter criteria.</p>
        </div>
        @endforelse
    </div>

    <!-- ========================================== -->
    <!-- MODALS (College & Program Forms) -->
    <!-- ========================================== -->

    @if($canManage)
    <!-- Create College Modal -->
    <flux:modal wire:model="showCreateCollegeModal" class="max-w-md md:min-w-md" @close="closeCreateCollegeModal">
        <form wire:submit="createCollege" class="space-y-6">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-primary flex items-center justify-center font-bold">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Add New College / Satellite') }}</flux:heading>
                </div>
                <flux:subheading class="mt-1 text-xs text-slate-500">
                    {{ __('Register a new college or satellite campus within Bicol University.') }}
                </flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:input wire:model="college_name" :label="__('College / Unit Name')" required placeholder="e.g. BU College of Science or BU Polangui" />
                </div>
                <div>
                    <flux:input wire:model="college_code" :label="__('College Code / Abbreviation')" required placeholder="e.g. CS or BUP" />
                    <p class="text-[11px] text-slate-400 mt-1">Unique short code or abbreviation for official reports.</p>
                </div>
                <div>
                    <flux:input wire:model="college_campus" :label="__('Campus Designation')" required placeholder="e.g. LEGAZPI WEST CAMPUS, BU POLANGUI" />
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
                <flux:button variant="outline" wire:click="closeCreateCollegeModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">
                    {{ __('Add College') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit College Modal -->
    <flux:modal wire:model="showEditCollegeModal" class="max-w-md md:min-w-md" @close="closeEditCollegeModal">
        <form wire:submit="updateCollege" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Edit College Details') }}</flux:heading>
                <flux:subheading class="mt-1 text-xs text-slate-500">{{ __('Modify name, abbreviation code, or campus designation.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:input wire:model="college_name" :label="__('College / Unit Name')" required placeholder="e.g. College of Science" />
                </div>
                <div>
                    <flux:input wire:model="college_code" :label="__('College Code / Abbreviation')" required placeholder="e.g. CS" />
                </div>
                <div>
                    <flux:input wire:model="college_campus" :label="__('Campus Designation')" required placeholder="e.g. LEGAZPI WEST CAMPUS, BU POLANGUI" />
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
                <flux:button variant="outline" wire:click="closeEditCollegeModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">{{ __('Save Changes') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Delete College Modal -->
    <flux:modal wire:model="showDeleteCollegeModal" class="max-w-md md:min-w-md" @close="closeDeleteCollegeModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-rose-700">{{ __('Soft Delete College?') }}</flux:heading>
                <flux:subheading class="mt-1 text-xs text-slate-500">
                    {{ __('Are you sure you want to delete ') }} <strong>{{ $targetCollegeName }}</strong>? {{ __('This will soft-delete the college and all degree programs under it. Historical audit logs will be preserved.') }}
                </flux:subheading>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button variant="outline" wire:click="closeDeleteCollegeModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="button" variant="danger" wire:click="deleteCollege">{{ __('Confirm Soft Delete') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Create Program Modal -->
    <flux:modal wire:model="showCreateProgramModal" class="max-w-md md:min-w-md" @close="closeCreateProgramModal">
        <form wire:submit="createProgram" class="space-y-6">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-brand-orange flex items-center justify-center font-bold">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Add Academic Program') }}</flux:heading>
                </div>
                <flux:subheading class="mt-1 text-xs text-slate-500">
                    {{ __('Register a degree program under an institutional college or satellite campus.') }}
                </flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:select wire:model="program_college_id" :label="__('Parent College / Campus')" required placeholder="Select College">
                        <flux:select.option value="">Select College / Campus</flux:select.option>
                        @foreach($allCollegesDropdown as $c)
                        <flux:select.option value="{{ $c->id }}">{{ $c->name }} ({{ $c->code }})</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:input wire:model="program_name" :label="__('Program Name')" required placeholder="e.g. Bachelor of Science in Computer Science" />
                </div>

                <div>
                    <flux:input wire:model="program_code" :label="__('Program Code')" required placeholder="e.g. BSCS" />
                </div>

                <div>
                    <flux:select wire:model="program_accreditation_level" :label="__('Accreditation Status / Level')" required placeholder="Select Accreditation Level">
                        @foreach($accreditationLevels as $al)
                        <flux:select.option value="{{ $al }}">{{ $al }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
                <flux:button variant="outline" wire:click="closeCreateProgramModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">
                    {{ __('Add Program') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit Program Modal -->
    <flux:modal wire:model="showEditProgramModal" class="max-w-md md:min-w-md" @close="closeEditProgramModal">
        <form wire:submit="updateProgram" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Edit Degree Program') }}</flux:heading>
                <flux:subheading class="mt-1 text-xs text-slate-500">{{ __('Update degree title, code, or accreditation level.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:select wire:model="program_college_id" :label="__('Parent College / Campus')" required placeholder="Select College">
                        @foreach($allCollegesDropdown as $c)
                        <flux:select.option value="{{ $c->id }}">{{ $c->name }} ({{ $c->code }})</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:input wire:model="program_name" :label="__('Program Name')" required placeholder="e.g. Bachelor of Science in Computer Science" />
                </div>

                <div>
                    <flux:input wire:model="program_code" :label="__('Program Code')" required placeholder="e.g. BSCS" />
                </div>

                <div>
                    <flux:select wire:model="program_accreditation_level" :label="__('Accreditation Status / Level')" required placeholder="Select Accreditation Level">
                        @foreach($accreditationLevels as $al)
                        <flux:select.option value="{{ $al }}">{{ $al }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
                <flux:button variant="outline" wire:click="closeEditProgramModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">{{ __('Save Changes') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Delete Program Modal -->
    <flux:modal wire:model="showDeleteProgramModal" class="max-w-md md:min-w-md" @close="closeDeleteProgramModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-rose-700">{{ __('Soft Delete Program?') }}</flux:heading>
                <flux:subheading class="mt-1 text-xs text-slate-500">
                    {{ __('Are you sure you want to delete ') }} <strong>{{ $targetProgramName }}</strong>? {{ __('This will soft-delete the program from active selections. Historical document links and audit trail will be retained.') }}
                </flux:subheading>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button variant="outline" wire:click="closeDeleteProgramModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="button" variant="danger" wire:click="deleteProgram">{{ __('Confirm Soft Delete') }}</flux:button>
            </div>
        </div>
    </flux:modal>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                const data = event[0];
                Swal.fire({
                    icon: data.icon || 'success',
                    title: data.title || '',
                    text: data.text || '',
                    confirmButtonColor: '#f47920',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200/60 shadow-lg font-sans',
                        title: 'text-primary font-bold text-heading-lg',
                        confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white'
                    }
                });
            });
        });
    </script>
</div>
