<!-- ================= TAB: ACCREDITATION ================= -->
<div x-show="activeTab === 'accreditation'" x-transition class="flex flex-col gap-6">

    <!-- Breadcrumbs Nav for Accreditation -->
    <div>
        <!-- Level 1 Breadcrumbs (Root) -->
        <template x-if="accredLevel === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredProgram = null; accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="text-zinc-650 font-semibold">Accreditation</span>
            </div>
        </template>

        <!-- Level 2 Breadcrumbs (College Selection) -->
        <template x-if="accredLevel === 'program' && accredCollege === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="accredLevel = null; accredCollege = null; accredProgram = null; accredCategory = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCollege = null; accredProgram = null; accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="text-zinc-655 font-semibold">Program Accreditation</span>
            </div>
        </template>

        <!-- Level 2.5 Breadcrumbs (Program Selection inside College) -->
        <template x-if="accredLevel === 'program' && accredCollege !== null && accredProgram === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="clearCollege()" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCollege = null; accredProgram = null; accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="clearCollege()">Program Accreditation</span>
                <span>&gt;</span>
                <span class="text-zinc-655 font-semibold" x-text="accredCollege?.name"></span>
            </div>
        </template>

        <!-- Level 3 Breadcrumbs (Program Sub-Categories) -->
        <template x-if="accredLevel === 'program' && accredCollege !== null && accredProgram !== null && accredCategory === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="clearProgram()" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCollege = null; accredProgram = null; accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="clearCollege(); clearProgram()">Program Accreditation</span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="clearProgram()" x-text="accredCollege?.name"></span>
                <span>&gt;</span>
                <span class="text-zinc-655 font-semibold" x-text="accredProgram?.name"></span>
            </div>
        </template>

        <!-- Level 3 Breadcrumbs (Institutional Sub-Categories) -->
        <template x-if="accredLevel === 'institutional' && accredCategory === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="accredLevel = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null">Documents</span>
                <span>&gt;</span>
                <span class="text-zinc-655 font-semibold">Institutional Accreditation</span>
            </div>
        </template>

        <!-- Level 4 Breadcrumbs (Program Workspace Category) -->
        <template x-if="accredLevel === 'program' && accredCollege !== null && accredProgram !== null && accredCategory !== null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="accredCategory = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCollege = null; accredProgram = null; accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="clearCollege(); clearProgram()">Program Accreditation</span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="clearProgram()" x-text="accredCollege?.name"></span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="accredCategory = null" x-text="accredProgram?.name"></span>
                <span>&gt;</span>
                <span class="text-zinc-655 font-semibold" x-text="accredCategory"></span>
            </div>
        </template>

        <!-- Level 4 Breadcrumbs (Institutional Workspace Category) -->
        <template x-if="accredLevel === 'institutional' && accredCategory !== null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="accredCategory = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="accredCategory = null">Institutional Accreditation</span>
                <span>&gt;</span>
                <span class="text-zinc-655 font-semibold" x-text="accredCategory"></span>
            </div>
        </template>
    </div>

    <!-- LEVEL 1: ACCREDITATION LEVEL SELECT -->
    <div x-show="accredLevel === null" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto w-full py-6">
        <!-- Program Accreditation Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-50 text-[#1b355a] flex items-center justify-center">
                <x-lucide-graduation-cap class="w-8 h-8" />
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#1b355a]">Program Accreditation</h3>
                <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                    Evaluate specific degree programs for academic quality, faculty portfolio, and student facilities.
                </p>
            </div>
            <button type="button" @click="accredLevel = 'program'; accredCollege = null; accredProgram = null; accredCategory = null" class="w-full mt-2 bg-[#1b355a] hover:bg-[#112239] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
                Select College
            </button>
        </div>

        <!-- Institutional Accreditation Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-orange-50 text-[#f27224] flex items-center justify-center">
                <x-lucide-landmark class="w-8 h-8" />
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#1b355a]">Institutional Accreditation</h3>
                <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                    Evaluate university-wide administration, leadership, fiscal soundness, and governance structure.
                </p>
            </div>
            <button type="button" @click="accredLevel = 'institutional'; accredCollege = null; accredProgram = null; accredCategory = null" class="w-full mt-2 bg-[#f27224] hover:bg-[#d65f1a] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
                Select Institutional
            </button>
        </div>
    </div>

    <!-- LEVEL 1.5: COLLEGE SELECTION UI (When Program Accreditation is clicked) -->
    <div x-show="accredLevel === 'program' && accredCollege === null" x-transition class="flex flex-col gap-6 w-full py-2">
        <!-- Hero Title Banner for College Selection -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#1b355a] flex items-center justify-center shrink-0 mt-1">
                    <x-lucide-building-2 class="w-6 h-6" />
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-[#1b355a]">Select Academic College</h2>
                    <p class="text-xs text-zinc-500 mt-1 leading-relaxed max-w-2xl">
                        Select a college below to view its academic degree programs, accreditation compliance records, and self-survey documents.
                    </p>
                </div>
            </div>

            <!-- Available Colleges Count Badge -->
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200/60 px-3.5 py-2 rounded-xl shrink-0 self-start md:self-auto">
                <span class="text-xs font-semibold text-zinc-500">Colleges:</span>
                <span class="text-xs font-extrabold text-[#1b355a] bg-white px-2 py-0.5 rounded-md border border-slate-200/50" x-text="availableColleges.length"></span>
            </div>
        </div>

        <!-- Search Input for Colleges -->
        <div class="relative max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text"
                x-model="collegeSearchQuery"
                placeholder="Search college name, code (e.g. CS, CENG, CAL)..."
                class="w-full pl-10 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-zinc-800 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a] shadow-3xs" />
            <template x-if="collegeSearchQuery">
                <button @click="collegeSearchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </template>
        </div>

        <!-- College Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <template x-for="col in availableColleges" :key="col.id">
                <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 group cursor-pointer" @click="selectCollege(col)">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center font-black text-sm shrink-0" :class="col.iconBg || 'bg-blue-50 text-[#1b355a]'">
                                <span x-text="col.code"></span>
                            </div>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-slate-100 text-zinc-600 border border-slate-200" x-text="col.programCount + ' Programs'"></span>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#1b355a] group-hover:text-blue-600 transition" x-text="col.name"></h3>
                            <p class="text-xs text-zinc-500 mt-1.5 leading-relaxed line-clamp-2" x-text="col.description"></p>
                        </div>
                    </div>

                    <button type="button" @click.stop="selectCollege(col)" class="w-full bg-[#1b355a] hover:bg-[#112239] text-white py-2.5 rounded-xl font-bold text-xs shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                        <span>View Academic Programs</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- Empty Search State for Colleges -->
        <template x-if="availableColleges.length === 0">
            <div class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/60 rounded-2xl shadow-3xs gap-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-zinc-400 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-[#1b355a]">No Colleges Found</h3>
                <p class="text-xs text-zinc-400 max-w-sm">No academic college matching "<span x-text="collegeSearchQuery"></span>" was found.</p>
            </div>
        </template>
    </div>

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

    <!-- LEVEL 2: ACCREDITATION SUB-CATEGORY SELECT -->
    <div x-show="(accredLevel === 'institutional' || (accredLevel === 'program' && accredProgram !== null)) && accredCategory === null" x-transition class="flex flex-col gap-5 w-full py-2">
        
        <!-- Context Banner for Selected Program (when Level is program) -->
        <template x-if="accredLevel === 'program' && accredProgram !== null">
            <div class="bg-blue-50/70 border border-blue-200/70 rounded-xl px-5 py-3.5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-3xs">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#1b355a] text-white flex items-center justify-center font-extrabold text-xs shrink-0">
                        <span x-text="accredProgram.code"></span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-extrabold text-[#1b355a]" x-text="accredProgram.name"></span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-white border border-blue-200 text-[#1b355a]" x-text="accredProgram.level"></span>
                        </div>
                        <p class="text-[11px] text-zinc-500 mt-0.5" x-text="accredProgram.college"></p>
                    </div>
                </div>
                <button type="button" @click="clearProgram()" class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 text-[#1b355a] text-xs font-bold rounded-lg transition cursor-pointer shrink-0 shadow-3xs">
                    Change Program
                </button>
            </div>
        </template>

        <!-- Sub-Category Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
            <!-- Self-Survey Documents Card -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <x-lucide-clipboard-check class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#1b355a]">Self-Survey Documents</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.
                        </p>
                    </div>
                </div>
                <button type="button" @click="accredCategory = 'Self-Survey Documents'" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open Self-Survey
                </button>
            </div>

            <!-- Compliance Reports Card -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <x-lucide-file-badge class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#1b355a]">Compliance Reports</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            Official compliance logs, AACCUP evaluations, corrective action reports, and certificates of accreditation.
                        </p>
                    </div>
                </div>
                <button type="button" @click="accredCategory = 'Compliance Reports'" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open Reports
                </button>
            </div>

            <!-- Supporting Documents Card -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <x-lucide-files class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#1b355a]">Supporting Documents</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            Checklist criteria link inputs for inputs (Systems), implementation details, outcomes, and best practices.
                        </p>
                    </div>
                </div>
                <button type="button" @click="accredCategory = 'Supporting Documents'" class="w-full bg-[#1b355a] hover:bg-[#112239] text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open Supporting Docs
                </button>
            </div>
        </div>
    </div>

    <!-- LEVEL 3A: SUPPORTING DOCUMENTS WORKSPACE -->
    <div x-show="(accredLevel === 'institutional' || (accredLevel === 'program' && accredProgram !== null)) && accredCategory === 'Supporting Documents'" x-transition class="flex flex-col gap-5">
        
        <!-- Context Header Bar for Supporting Docs Workspace -->
        <template x-if="accredLevel === 'program' && accredProgram !== null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-5 py-3 shadow-3xs flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-bold text-[#1b355a]">
                    <span class="px-2 py-0.5 bg-blue-50 text-[#1b355a] rounded border border-blue-100" x-text="accredProgram.code"></span>
                    <span x-text="accredProgram.name"></span>
                    <span class="text-zinc-400 font-normal">•</span>
                    <span class="text-zinc-500 font-medium" x-text="accredProgram.college"></span>
                </div>
                <button type="button" @click="clearProgram()" class="text-xs font-bold text-blue-650 hover:underline cursor-pointer">
                    Switch Program
                </button>
            </div>
        </template>

        <!-- Area Selector Horizontal Tablist -->
        <div class="flex overflow-x-auto gap-3 pb-2 w-full select-none">
            <template x-for="area in activeAccredData?.areas" :key="area.id">
                <button type="button"
                    class="flex-1 shrink-0 min-w-[200px] bg-white rounded-xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24"
                    :class="accredActiveAreaId === area.id ? 'border-[#1b355a] ring-1 ring-[#1b355a]/30 shadow-xs' : 'border-slate-200/60 hover:border-slate-350'"
                    @click="selectArea(area.id)">
                    <div>
                        <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                        <span class="text-sm font-bold text-[#1b355a] mt-1 leading-tight line-clamp-2 block" x-text="area.title"></span>
                    </div>
                    <div class="w-full mt-2">
                        <div class="w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" :style="'width: ' + area.progress + '%'"></div>
                        </div>
                    </div>
                </button>
            </template>
        </div>

        <!-- Main workspace split panel -->
        <div class="flex flex-col lg:flex-row gap-5 items-start w-full">
            <!-- Left Pane: Parameters Available -->
            <div class="w-full lg:w-72 shrink-0 flex flex-col gap-3 bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
                <span class="text-sm font-bold text-[#1b355a] tracking-wide px-1">Parameters Available</span>
                <div class="flex flex-col gap-1.5">
                    <template x-for="param in activeArea?.parameters" :key="param.id">
                        <button type="button"
                            class="w-full text-left p-3 rounded-lg text-sm font-semibold flex flex-col gap-1 transition cursor-pointer relative overflow-hidden"
                            :class="accredActiveParamId === param.id ? 'bg-slate-50 text-[#1b355a] border-l-4 border-[#1b355a] pl-2.5 shadow-3xs' : 'text-zinc-500 hover:bg-slate-50/30 hover:text-[#1b355a] pl-3.5 border-l-4 border-transparent'"
                            @click="accredActiveParamId = param.id; accredActiveSection = 'systems'">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-[#1b355a] text-[10px] uppercase tracking-wide" x-text="param.code"></span>
                                <span class="text-[10px] font-bold text-emerald-600" x-text="param.progress + '%'"></span>
                            </div>
                            <span class="text-xs font-bold leading-snug mt-1 text-[#1b355a]" x-text="param.title"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Right Pane: Parameters checklist workspace -->
            <div class="flex-1 bg-white border border-slate-200/60 rounded-xl p-6 shadow-3xs flex flex-col gap-6 w-full">
                <!-- Parameter Title & Stats Header Block -->
                <div class="flex flex-col gap-4 pb-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <span class="text-[10px] font-bold text-[#1b355a] uppercase tracking-wider" x-text="activeParam?.code"></span>
                            <h2 class="text-base font-extrabold text-[#1b355a] mt-1" x-text="activeParam?.code + ' - ' + activeParam?.title"></h2>
                        </div>

                        <!-- Stats Grid -->
                        <div class="flex items-center gap-6 shrink-0 text-right">
                            <div>
                                <div class="text-sm font-extrabold text-[#1b355a]" x-text="activeParam?.sections?.systems?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.implementation?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.outcomes?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0)"></div>
                                <div class="text-[9px] text-zinc-400 uppercase font-bold tracking-wide mt-0.5">Documents</div>
                            </div>
                            <div class="border-l border-slate-200 h-8"></div>
                            <div>
                                <div class="text-sm font-extrabold text-[#1b355a]" x-text="activeParam?.sections?.systems?.reduce((acc, item) => acc + (item.documents ? item.documents.filter(d => d.status === 'Verified').length : 0), 0) + activeParam?.sections?.implementation?.reduce((acc, item) => acc + (item.documents ? item.documents.filter(d => d.status === 'Verified').length : 0), 0) + activeParam?.sections?.outcomes?.reduce((acc, item) => acc + (item.documents ? item.documents.filter(d => d.status === 'Verified').length : 0), 0) + '/' + (activeParam?.sections?.systems?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.implementation?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.outcomes?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0))"></div>
                                <div class="text-[9px] text-zinc-400 uppercase font-bold tracking-wide mt-0.5">Verified</div>
                            </div>
                            <div class="border-l border-slate-200 h-8"></div>
                            <div>
                                <div class="text-sm font-extrabold text-emerald-600" x-text="activeParam?.progress + '%'"></div>
                                <div class="text-[9px] text-zinc-400 uppercase font-bold tracking-wide mt-0.5">Progress</div>
                            </div>
                        </div>
                    </div>

                    <!-- Large progress line at the bottom of header block -->
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-1">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" :style="'width: ' + activeParam?.progress + '%'"></div>
                    </div>
                </div>

                <!-- Section Navigation Tabs -->
                <div class="flex border-b border-slate-200 gap-6 text-sm font-bold -mt-2">
                    <button type="button"
                        class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap"
                        :class="accredActiveSection === 'systems' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-450 hover:text-zinc-650'"
                        @click="accredActiveSection = 'systems'">
                        Systems - Inputs & Processes
                    </button>
                    <button type="button"
                        class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap"
                        :class="accredActiveSection === 'implementation' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-450 hover:text-zinc-650'"
                        @click="accredActiveSection = 'implementation'">
                        Implementation
                    </button>
                    <button type="button"
                        class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap"
                        :class="accredActiveSection === 'outcomes' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-455 hover:text-zinc-655'"
                        @click="accredActiveSection = 'outcomes'">
                        Outcomes
                    </button>
                    <button type="button"
                        class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap"
                        :class="accredActiveSection === 'bestpractices' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-455 hover:text-zinc-655'"
                        @click="accredActiveSection = 'bestpractices'">
                        Best Practices
                    </button>
                </div>

                <!-- Checklist list area -->
                <div class="flex flex-col gap-4">
                    <template x-for="item in activeChecklistItems" :key="item.id">
                        <div class="border border-slate-150 rounded-xl p-5 flex flex-col gap-4 bg-slate-50/20">
                            <div class="flex items-start gap-3">
                                <span class="text-sm font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-full shrink-0" x-text="item.id"></span>
                                <p class="text-sm font-bold text-[#1b355a] leading-relaxed mt-0.5" x-text="item.statement"></p>
                            </div>

                            <!-- If Best Practices -->
                            <template x-if="accredActiveSection === 'bestpractices'">
                                <p class="text-sm text-zinc-500 italic pl-12" x-text="item.description"></p>
                            </template>

                            <!-- If Document section -->
                            <template x-if="accredActiveSection !== 'bestpractices'">
                                <div class="pl-12 flex flex-col gap-3">
                                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider" x-text="'Supporting Documents Attached (' + (item.documents ? item.documents.length : 0) + ')'"></span>

                                    <!-- Linked documents list -->
                                    <template x-if="item.documents && item.documents.length > 0">
                                        <div class="flex flex-col gap-2">
                                            <template x-for="doc in item.documents" :key="doc.name">
                                                <div class="flex items-center justify-between p-3.5 bg-white border border-slate-150 rounded-lg text-sm gap-3">
                                                    <div class="flex items-center gap-3 min-w-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-rose-500 shrink-0">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                        </svg>
                                                        <div class="min-w-0">
                                                            <span class="font-bold text-[#1b355a] block truncate" x-text="doc.name"></span>
                                                            <span class="text-[11px] text-zinc-400 mt-0.5 block" x-text="doc.size + ' • Uploaded ' + doc.date"></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-4 shrink-0">
                                                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100"
                                                            :class="doc.status === 'Verified' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100'"
                                                            x-text="doc.status"></span>
                                                        <button type="button" class="text-sm font-bold text-blue-650 hover:underline cursor-pointer" @click="openDoc(doc)">
                                                            View Drawer
                                                        </button>
                                                        <button type="button" class="text-zinc-400 hover:text-zinc-655 cursor-pointer" @click="alert('Remove document link logic here!')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- No documents linked -> Upload button -->
                                    <template x-if="!item.documents || item.documents.length === 0">
                                        <button type="button" class="border border-dashed border-slate-300 hover:border-slate-400 bg-slate-50/50 hover:bg-slate-50 text-[#1b355a] text-sm font-bold px-4 py-3 rounded-lg flex items-center justify-center gap-2 cursor-pointer transition w-full" @click="alert('Upload & link files for: ' + item.statement)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-[#f27224]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                            Upload & Link Document
                                        </button>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- LEVEL 3B: SELF SURVEY VIEW -->
    <div x-show="(accredLevel === 'institutional' || (accredLevel === 'program' && accredProgram !== null)) && accredCategory === 'Self-Survey Documents'" x-transition class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/60 rounded-2xl shadow-3xs min-h-[400px] gap-4 max-w-2xl mx-auto w-full">
        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v5.75c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 18.875v-5.75zM18 10.5c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 0118 19.875v-8.25zM10.5 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v10.125c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625z" />
            </svg>
        </div>
        <h2 class="text-lg font-extrabold text-zinc-900">Self Survey Documents Workspace</h2>
        <p class="text-sm text-zinc-500 max-w-md leading-relaxed">
            <span x-text="accredLevel === 'program' ? ('Self survey rating guides and scoresheets for ' + accredProgram?.name) : 'Institutional self-survey rating guides and scoresheets.'"></span>
            Click the breadcrumbs to return to your folders.
        </p>
        <button type="button" @click="accredCategory = null" class="mt-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold rounded-lg transition text-sm cursor-pointer shadow-3xs">
            Back to Folders
        </button>
    </div>

    <!-- LEVEL 3C: COMPLIANCE REPORTS VIEW -->
    <div x-show="(accredLevel === 'institutional' || (accredLevel === 'program' && accredProgram !== null)) && accredCategory === 'Compliance Reports'" x-transition class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/60 rounded-2xl shadow-3xs min-h-[400px] gap-4 max-w-2xl mx-auto w-full">
        <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75a1.125 1.125 0 00-1.125 1.125v3.375m9 0h-9M9 12h6m-6 3H6.75a3 3 0 01-3-3V6.75a3 3 0 013-3h10.5a3 3 0 013 3V12a3 3 0 01-3 3H15" />
            </svg>
        </div>
        <h2 class="text-lg font-extrabold text-zinc-900">Compliance & Accreditation Reports</h2>
        <p class="text-sm text-zinc-500 max-w-md leading-relaxed">
            <span x-text="accredLevel === 'program' ? ('External evaluation audits and AACCUP certificates for ' + accredProgram?.name) : 'Institutional evaluation audits and certificates.'"></span>
            Click the breadcrumbs to return to your folders.
        </p>
        <button type="button" @click="accredCategory = null" class="mt-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold rounded-lg transition text-sm cursor-pointer shadow-3xs">
            Back to Folders
        </button>
    </div>

    <!-- Modal for Adding New Program (For IQA Admin & System Admin) -->
    <div x-show="showAddProgramModal" 
         @click="closeAddProgramModal()" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-[300] flex items-center justify-center p-4">
        
        <div @click.stop 
             x-show="showAddProgramModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 max-w-lg w-full p-6 flex flex-col gap-5 relative z-[310]">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#f27224] flex items-center justify-center font-bold">
                        <x-lucide-graduation-cap class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-[#1b355a]">Add Academic Program</h3>
                        <p class="text-xs text-zinc-400 mt-0.5">Register a new degree program into the backend system</p>
                    </div>
                </div>
                <button type="button" @click="closeAddProgramModal()" class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Alert messages -->
            <template x-if="addProgramError">
                <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold" x-text="addProgramError"></div>
            </template>
            <template x-if="addProgramSuccess">
                <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold" x-text="addProgramSuccess"></div>
            </template>

            <!-- Form Body -->
            <form @submit.prevent="submitNewProgram()" class="flex flex-col gap-4">
                <!-- Program Name -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Program Name <span class="text-rose-500">*</span></label>
                    <input type="text" x-model="newProgram.name" placeholder="e.g. BS Data Analytics" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]" />
                </div>

                <!-- Program Code -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Program Code <span class="text-rose-500">*</span></label>
                    <input type="text" x-model="newProgram.code" placeholder="e.g. BSDA" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]" />
                </div>

                <!-- College Select -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Assigned College <span class="text-rose-500">*</span></label>
                    <select x-model="newProgram.college_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]">
                        <template x-for="col in collegesList" :key="col.id">
                            <option :value="col.id" x-text="col.name + ' (' + col.code + ')'"></option>
                        </template>
                    </select>
                </div>

                <!-- Accreditation Level Select (Fetched from Backend) -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Accreditation Level <span class="text-rose-500">*</span></label>
                    <select x-model="newProgram.accreditation_level" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]">
                        <option value="Level IV Re-accredited">Level IV Re-accredited</option>
                        <option value="Level III Accredited">Level III Accredited</option>
                        <option value="Level II Accredited">Level II Accredited</option>
                        <option value="Level I Accredited">Level I Accredited</option>
                        <option value="Candidate Status">Candidate Status</option>
                        <option value="Not Accredited">Not Accredited</option>
                    </select>
                </div>

                <!-- Modal Action Footer -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="closeAddProgramModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-xs rounded-xl transition cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" :disabled="addProgramLoading" class="px-5 py-2.5 bg-[#1b355a] hover:bg-[#112239] text-white font-bold text-xs rounded-xl transition shadow-2xs cursor-pointer flex items-center gap-2">
                        <span x-text="addProgramLoading ? 'Saving...' : 'Save Program'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>