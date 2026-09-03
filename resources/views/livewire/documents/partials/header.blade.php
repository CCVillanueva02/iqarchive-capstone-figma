<div class="bg-white border-b border-zinc-200 px-6 py-5">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Title & Badges -->
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-zinc-900 leading-tight">Document Repository & Accreditation Workspace</h1>
                    <p class="text-xs text-zinc-500 mt-0.5">Centralized institutional documents, AACCUP program evidence, and self-survey metrics</p>
                </div>
            </div>
        </div>

        <!-- Action / Global Filters (e.g. Scoped College / Program Switcher) -->
        <div class="flex items-center gap-3">
            @if($activeTab === 'program-accreditation')
                <!-- College Scoped Selector -->
                <div class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-zinc-600 uppercase tracking-wider">College:</label>
                    @if($isCollegeLocked)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-zinc-100 border border-zinc-200 text-xs font-medium text-zinc-800">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            {{ $colleges->firstWhere('id', $selectedCollegeId)?->name ?? 'Assigned College' }}
                        </span>
                    @else
                        <select wire:change="selectCollege($event.target.value)" class="text-xs border border-zinc-300 rounded-lg px-2.5 py-1.5 bg-white text-zinc-800 focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            @foreach($colleges as $c)
                                <option value="{{ $c->id }}" @selected($selectedCollegeId == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <!-- Program Scoped Selector -->
                <div class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-zinc-600 uppercase tracking-wider">Program:</label>
                    @if($isProgramLocked)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-zinc-100 border border-zinc-200 text-xs font-medium text-zinc-800">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            {{ $selectedProgram?->name ?? 'Assigned Program' }}
                        </span>
                    @else
                        @php
                            $availablePrograms = $colleges->firstWhere('id', $selectedCollegeId)?->programs ?? collect();
                        @endphp
                        <select wire:change="selectProgram($event.target.value)" class="text-xs border border-zinc-300 rounded-lg px-2.5 py-1.5 bg-white text-zinc-800 focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            @foreach($availablePrograms as $p)
                                <option value="{{ $p->id }}" @selected($selectedProgramId == $p->id)>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Main Navigation Tabs -->
    <div class="mt-6 flex items-center border-b border-zinc-200 -mb-5 gap-8">
        @if($canAccessCommonDocs)
            <button wire:click="switchTab('common-documents')"
                class="pb-3 text-sm font-semibold transition-colors relative flex items-center gap-2 {{ $activeTab === 'common-documents' ? 'text-primary border-b-2 border-primary' : 'text-zinc-500 hover:text-zinc-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Common Documents
            </button>
        @endif

        <button wire:click="switchTab('program-accreditation')"
            class="pb-3 text-sm font-semibold transition-colors relative flex items-center gap-2 {{ $activeTab === 'program-accreditation' ? 'text-primary border-b-2 border-primary' : 'text-zinc-500 hover:text-zinc-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Program Accreditation
        </button>

        @if($canAccessInstitutionalDocs)
            <button wire:click="switchTab('institutional-accreditation')"
                class="pb-3 text-sm font-semibold transition-colors relative flex items-center gap-2 {{ $activeTab === 'institutional-accreditation' ? 'text-primary border-b-2 border-primary' : 'text-zinc-500 hover:text-zinc-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Institutional Accreditation
            </button>
        @endif
    </div>
</div>
