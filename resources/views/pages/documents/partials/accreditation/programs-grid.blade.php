<!-- LEVEL 1.6: PROGRAM SELECTION UI (When College is selected) -->
<div x-show="accredLevel === 'program' && accredCollege !== null && accredProgram === null" x-transition class="flex flex-col gap-6 w-full py-2">
    <!-- Hero Title Banner for Program Selection -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#1b355a] flex items-center justify-center shrink-0 mt-1">
                <x-lucide-graduation-cap class="w-6 h-6" />
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-[#1b355a]" x-text="accredCollege?.name ? accredCollege.name + ' Degree Programs' : 'Select Academic Program'"></h2>
                <p class="text-xs text-zinc-500 mt-1 leading-relaxed max-w-2xl">
                    Select a degree program under <strong class="text-[#1b355a]" x-text="accredCollege?.name"></strong> to access its self-survey accreditation files, compliance reports, and supporting documents.
                </p>
            </div>
        </div>

        <!-- Action Buttons: Count Badge & Add Program Button -->
        <div class="flex flex-wrap items-center gap-3 shrink-0 self-start md:self-auto">
            <button type="button" @click="clearCollege()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-xs rounded-xl shadow-2xs transition cursor-pointer flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Change College</span>
            </button>

            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200/60 px-3.5 py-2 rounded-xl">
                <span class="text-xs font-semibold text-zinc-500">Available Programs:</span>
                <span class="text-xs font-extrabold text-[#1b355a] bg-white px-2 py-0.5 rounded-md border border-slate-200/50" x-text="filteredPrograms.length"></span>
            </div>

            <button type="button" @click="openAddProgramModal()" class="px-4 py-2 bg-[#f27224] hover:bg-[#d65f1a] text-white font-bold text-xs rounded-xl shadow-2xs transition cursor-pointer flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New Program</span>
            </button>
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
                class="w-full pl-10 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-zinc-800 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a] shadow-3xs" />
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
                    <!-- Card Header Badge & Code -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-xs shrink-0" :class="prog.iconBg || 'bg-blue-50 text-[#1b355a]'">
                                <span x-text="prog.code"></span>
                            </div>
                            <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block" x-text="prog.collegeCode || accredCollege?.code"></span>
                        </div>
                    </div>

                    <!-- Program Title and College -->
                    <div>
                        <h3 class="text-base font-bold text-[#1b355a] group-hover:text-blue-600 transition" x-text="prog.name"></h3>
                        <p class="text-xs text-zinc-500 mt-1" x-text="prog.college || accredCollege?.name"></p>
                    </div>

                    <!-- Accreditation Status / Level Info -->
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                        <span class="text-zinc-400 font-medium">Accreditation Level:</span>
                        <span class="font-extrabold px-2.5 py-1 rounded-full border text-[11px]"
                            :class="prog.level.includes('Level IV') ? 'bg-blue-50 text-[#1b355a] border-blue-100' : (prog.level.includes('Level III') ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : (prog.level.includes('Level II') ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-100 text-zinc-700 border-slate-200'))"
                            x-text="prog.level"></span>
                    </div>
                </div>

                <!-- Action Button -->
                <button type="button" @click="selectProgram(prog)" class="w-full bg-[#1b355a] hover:bg-[#112239] text-white py-2.5 rounded-xl font-bold text-xs shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
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
            <p class="text-xs text-zinc-500 max-w-sm">No academic programs match your current search query within <span class="font-bold text-[#1b355a]" x-text="accredCollege?.name"></span>.</p>
            <button type="button" @click="programSearchQuery = ''" class="mt-2 text-xs font-bold text-[#1b355a] hover:underline cursor-pointer">
                Clear Search
            </button>
        </div>
    </template>
</div>
