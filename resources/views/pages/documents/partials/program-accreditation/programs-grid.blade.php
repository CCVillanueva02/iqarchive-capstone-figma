<!-- LEVEL 2: PROGRAM SELECTION UI (When College is selected) -->
<div x-show="accredCollege !== null && accredProgram === null" x-transition class="flex flex-col gap-6 w-full py-2">
    <!-- Hero Title Banner for Program Selection -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-primary flex items-center justify-center shrink-0 mt-1">
                <x-lucide-graduation-cap class="w-6 h-6" />
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-primary" x-text="accredCollege?.name ? accredCollege.name + ' Degree Programs' : 'Select Academic Program'"></h2>
                <p class="text-xs text-zinc-500 mt-1 leading-relaxed max-w-2xl">
                    Select a degree program under <strong class="text-primary" x-text="accredCollege?.name"></strong> to access its self-survey accreditation files, compliance reports, and supporting documents.
                </p>
            </div>
        </div>

        <!-- Action Buttons: Count Badge & Add Program Button -->
        <div class="flex flex-wrap items-center gap-3 shrink-0 self-start md:self-auto">
            <button x-show="isUnrestricted || collegesList.length > 1" type="button" @click="clearCollege()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-xs rounded-xl shadow-2xs transition cursor-pointer flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Change College</span>
            </button>

            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200/60 px-3.5 py-2 rounded-xl">
                <span class="text-xs font-semibold text-zinc-500">Available Programs:</span>
                <span class="text-xs font-extrabold text-primary bg-white px-2 py-0.5 rounded-md border border-slate-200/50" x-text="filteredPrograms.length"></span>
            </div>

            @if(auth()->user()->hasAnyRole(['iqa-staff', 'iqa-admin', 'system-administrator']) || in_array(auth()->user()->role, ['iqa-staff', 'iqa-admin', 'system-administrator']))
            <button type="button" @click="openAddProgramModal()" class="px-4 py-2 bg-brand-orange hover:bg-brand-orange-hover text-white font-bold text-xs rounded-xl shadow-2xs transition cursor-pointer flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New Program</span>
            </button>
            @endif
        </div>
    </div>

    <!-- Search Bar -->
    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
        <!-- Search Input -->
        <div class="relative flex-1 max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text"
                x-model="programSearchQuery"
                placeholder="Search program name, code (e.g. BSCS, BSCE)..."
                class="w-full pl-10 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-zinc-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-3xs" />
            <template x-if="programSearchQuery">
                <button @click="programSearchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </template>
        </div>
    </div>

    <!-- Program Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="prog in filteredPrograms" :key="prog.id">
            <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 group">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-start justify-between gap-3">
                            <!-- Left Side: Profile Icon & Program Name -->
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center font-black text-sm shrink-0" :class="prog.iconBg || 'bg-blue-50 text-primary'">
                                    <span x-text="prog.code"></span>
                                </div>
                                <div class="flex flex-col overflow-hidden">
                                    <h3 class="text-body font-bold text-primary group-hover:text-primary-hover transition truncate" x-text="prog.name" :title="prog.name"></h3>
                                    <p class="text-xs text-zinc-500 mt-0.5 truncate" x-text="prog.college || accredCollege?.name"></p>
                                </div>
                            </div>

                            <!-- Right Side: College Code & Actions (Upper Right) -->
                            <div class="flex items-center gap-2 shrink-0 pt-0.5">
                                <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block" x-text="prog.collegeCode || accredCollege?.code"></span>

                                @if(auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('system-administrator'))
                                <div class="flex items-center">
                                    <button @click.stop="openEditProgramModal(prog)" class="p-1 text-zinc-400 hover:text-primary transition" title="Edit Program">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.89 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.89l3.4-3.4" />
                                        </svg>
                                    </button>
                                    <button @click.stop="confirmDeleteProgram(prog)" class="p-1 text-zinc-400 hover:text-rose-500 transition" title="Delete Program">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Accreditation Status / Level Info -->
                        <div class="flex flex-col gap-2 pt-3 border-t border-slate-100 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-400 font-medium">Accreditation Level:</span>
                                <span class="font-extrabold px-2.5 py-1 rounded-full border text-label-xs"
                                    :class="prog.level.includes('Level IV') ? 'bg-blue-50 text-primary border-blue-100' : (prog.level.includes('Level III') ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : (prog.level.includes('Level II') ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-100 text-zinc-700 border-slate-200'))"
                                    x-text="prog.level"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-400 font-medium">Instrument Status:</span>
                                <template x-if="prog.instrument_verified">
                                    <span class="font-bold px-2.5 py-0.5 rounded-full border text-label-xs bg-emerald-50 text-emerald-700 border-emerald-200 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span>Verified</span>
                                    </span>
                                </template>
                                <template x-if="!prog.instrument_verified">
                                    <span class="font-bold px-2.5 py-0.5 rounded-full border text-label-xs bg-amber-50 text-amber-800 border-amber-200 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>Pending Setup</span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button type="button" @click="selectProgram(prog)" class="w-full bg-primary hover:bg-primary-dark-hover text-white py-2.5 rounded-xl font-bold text-xs shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                        <span>Select Program</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
        </template>
    </div>

    <!-- Empty Search Result State -->
    <template x-if="filteredPrograms.length === 0">
        <div class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/60 rounded-2xl shadow-3xs gap-3">
            <div class="w-12 h-12 rounded-full bg-slate-100 text-zinc-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-zinc-800">No programs found for this college</h3>
            <p class="text-xs text-zinc-500 max-w-sm">No academic programs match your current search query within <span class="font-bold text-primary" x-text="accredCollege?.name"></span>.</p>
            <button type="button" @click="programSearchQuery = ''" class="mt-2 text-xs font-bold text-primary hover:underline cursor-pointer">
                Clear Search
            </button>
        </div>
    </template>

    <!-- Create / Edit Program Modal -->
    <div x-show="showProgramModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm" style="display: none;" x-transition.opacity>
        <div @click.away="closeProgramModal()" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" x-transition.scale.origin.bottom>
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-heading-sm font-bold text-primary" x-text="programForm.id ? 'Edit Program' : 'Add Program'"></h3>
                <button @click="closeProgramModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 flex flex-col gap-5">
                <div>
                    <label class="block text-label font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Program Name</label>
                    <input type="text" x-model="programForm.name" class="w-full text-body-sm border border-slate-200 rounded-lg px-4 py-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-slate-50 transition" placeholder="e.g. BS Computer Science">
                </div>
                <div>
                    <label class="block text-label font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Program Code</label>
                    <input type="text" x-model="programForm.code" class="w-full text-body-sm border border-slate-200 rounded-lg px-4 py-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-slate-50 transition" placeholder="e.g. BSCS">
                </div>
                <div>
                    <label class="block text-label font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Accreditation Level</label>
                    <select x-model="programForm.accreditation_level" class="w-full text-body-sm border border-slate-200 rounded-lg px-4 py-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-slate-50 transition cursor-pointer">
                        <option value="Candidate">Candidate Status</option>
                        <option value="Level I">Level I Accredited</option>
                        <option value="Level II">Level II Accredited</option>
                        <option value="Level III">Level III Accredited</option>
                        <option value="Level IV">Level IV Re-accredited</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button @click="closeProgramModal()" class="px-4 py-2.5 rounded-xl text-body-sm font-bold text-slate-600 hover:bg-slate-200 transition cursor-pointer">Cancel</button>
                <button @click="saveProgram()" class="px-5 py-2.5 rounded-xl text-body-sm font-bold text-white bg-primary hover:bg-primary-hover shadow-3xs transition cursor-pointer flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Save Program</span>
                </button>
            </div>
        </div>
    </div>
</div>