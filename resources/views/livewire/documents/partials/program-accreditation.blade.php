{{--
    IQArchive Program Accreditation Workspace
    Level 1: 17-College Card Grid with search toolbar and badges (Reference Image 2)
    Level 2: Academic Degree Programs Selection Grid for selected college
    Level 3: Program Accreditation Workspace (Supporting Docs, Self-Survey, Compliance, Narrative)
--}}

<div class="p-6 space-y-6">
    @if(!$selectedCollegeId)
        {{-- LEVEL 1: 17-COLLEGE CARD GRID (Reference Image 2) --}}
        <!-- Header Banner -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-surface-subtle border border-primary/10 flex items-center justify-center text-primary shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-primary">Select Academic College</h2>
                    <p class="text-sm text-zinc-500 mt-0.5">
                        Select a college below to view its academic degree programs, accreditation compliance records, and self-survey documents.
                    </p>
                </div>
            </div>
            <div class="shrink-0">
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-slate-100 text-zinc-600 border border-slate-200 text-xs font-bold whitespace-nowrap">
                    Colleges: <strong class="text-primary font-black">{{ $colleges->count() }}</strong>
                </span>
            </div>
        </div>

        <!-- Search Bar for Colleges -->
        <div class="relative w-full max-w-md">
            <input type="text"
                wire:model.live.debounce.250ms="collegeSearch"
                placeholder="Search college name, code (e.g. CS, CENG, CAL)..."
                class="w-full text-xs border border-slate-200 rounded-xl pl-10 pr-4 py-3 bg-white text-zinc-800 placeholder-zinc-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-3xs transition" />
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <!-- 17-College Cards Grid -->
        @if($colleges->isEmpty())
            <div class="bg-white rounded-2xl border border-zinc-200 p-12 text-center shadow-3xs flex flex-col items-center justify-center gap-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-zinc-400 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-primary">No Academic Colleges Found</h3>
                <p class="text-xs text-zinc-500 max-w-sm">No college matches your search term "{{ $collegeSearch }}".</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($colleges as $col)
                    <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5 group">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3.5 overflow-hidden">
                                <img src="{{ $col->logo }}"
                                    alt="{{ $col->code }} Logo"
                                    class="w-11 h-11 object-contain shrink-0"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                <div class="w-11 h-11 rounded-xl items-center justify-center font-black text-xs shrink-0 bg-surface-subtle text-primary border border-primary/10" style="display: none;">
                                    <span>{{ $col->code }}</span>
                                </div>
                                <div class="flex flex-col overflow-hidden">
                                    <h3 class="text-sm font-bold text-primary group-hover:text-primary-hover transition truncate" title="{{ $col->name }}">
                                        {{ $col->name }}
                                    </h3>
                                    <p class="text-xs text-zinc-500 mt-0.5 truncate uppercase tracking-wider font-medium">
                                        {{ $col->campus ?? 'Main Campus' }}
                                    </p>
                                </div>
                            </div>
                            <span class="text-label-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-zinc-600 border border-slate-200 whitespace-nowrap shrink-0">
                                {{ $col->programs_count }} Programs
                            </span>
                        </div>

                        <button type="button" wire:click="selectCollege({{ $col->id }})"
                            class="w-full bg-primary hover:bg-primary-dark-hover text-white py-2.5 rounded-xl font-bold text-xs shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                            <span>View Academic Programs</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

    @elseif(!$selectedProgramId)
        {{-- LEVEL 2: DEGREE PROGRAMS GRID FOR SELECTED COLLEGE --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-zinc-200">
            <div class="flex items-center gap-3">
                @if(!$isCollegeLocked)
                    <button type="button" wire:click="clearCollege"
                        class="px-3.5 py-2 rounded-xl bg-white border border-zinc-300 text-zinc-700 hover:bg-zinc-50 text-xs font-bold transition shadow-3xs flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Back to Colleges</span>
                    </button>
                    <div class="h-5 w-px bg-zinc-200"></div>
                @endif
                <div>
                    <h2 class="text-base font-bold text-primary">{{ $selectedCollege->name }} ({{ $selectedCollege->code }})</h2>
                    <p class="text-xs text-zinc-500">Select an academic degree program below to access its accreditation matrices and evidence.</p>
                </div>
            </div>
            <span class="text-xs font-bold text-zinc-500 bg-zinc-100 border border-zinc-200 px-3 py-1.5 rounded-lg shrink-0">
                {{ $selectedCollege->programs->count() }} Programs
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($selectedCollege->programs as $prog)
                <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5 group">
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-label-xs font-black bg-primary/10 text-primary border border-primary/20">
                                {{ $prog->code }}
                            </span>
                            <span class="text-label-xs font-semibold text-zinc-400">
                                {{ $prog->level ?? 'Undergraduate' }}
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-primary group-hover:text-primary-hover transition mt-3">
                            {{ $prog->name }}
                        </h3>
                        <p class="text-xs text-zinc-500 mt-1">
                            {{ $prog->description ?? 'Academic degree program under ' . $selectedCollege->code }}
                        </p>
                    </div>

                    <button type="button" wire:click="selectProgram({{ $prog->id }})"
                        class="w-full bg-primary hover:bg-primary-dark-hover text-white py-2.5 rounded-xl font-bold text-xs shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                        <span>Open Program Workspace</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-zinc-200 p-12 text-center text-zinc-500 shadow-3xs">
                    No degree programs found for this college unit.
                </div>
            @endforelse
        </div>

    @else
        {{-- LEVEL 3: PROGRAM ACCREDITATION WORKSPACE --}}
        <!-- Navigation Switcher & Back Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-3 rounded-xl border border-zinc-200 shadow-3xs">
            <div class="flex items-center gap-2 flex-wrap">
                @if(!$isProgramLocked)
                    <button type="button" wire:click="clearProgram"
                        class="px-3 py-1.5 rounded-lg bg-zinc-100 hover:bg-zinc-200 text-zinc-700 text-xs font-bold transition flex items-center gap-1 cursor-pointer mr-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Change Program</span>
                    </button>
                @endif

                <button wire:click="switchProgramCategory('supporting-documents')"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'supporting-documents' ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <span>Supporting Documents</span>
                </button>

                <button wire:click="switchProgramCategory('self-survey')"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'self-survey' ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Self-Survey Matrix</span>
                </button>

                <button wire:click="switchProgramCategory('compliance-reports')"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'compliance-reports' ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Compliance Reports</span>
                </button>

                <button wire:click="switchProgramCategory('narrative-profile')"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $programCategory === 'narrative-profile' ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Narrative Profile</span>
                </button>
            </div>

            @if($programCategory === 'supporting-documents')
                <button wire:click="openEvidenceUploadModal" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-primary hover:bg-primary-dark-hover text-white text-xs font-semibold rounded-lg shadow-3xs transition shrink-0 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Upload Evidence</span>
                </button>
            @endif
        </div>

        <!-- Category Views -->
        @if($programCategory === 'supporting-documents')
            @include('livewire.documents.partials.program.supporting-documents')
        @elseif($programCategory === 'self-survey')
            @include('livewire.documents.partials.program.self-survey')
        @elseif($programCategory === 'compliance-reports')
            @include('livewire.documents.partials.program.compliance-reports')
        @elseif($programCategory === 'narrative-profile')
            @include('livewire.documents.partials.program.narrative-profile')
        @endif
    @endif
</div>
