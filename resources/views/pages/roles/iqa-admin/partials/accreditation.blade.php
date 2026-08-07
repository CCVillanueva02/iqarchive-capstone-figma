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
    <div x-show="(accredLevel === 'institutional' || (accredLevel === 'program' && accredProgram !== null)) && accredCategory === 'Self-Survey Documents'" x-transition class="flex flex-col gap-5 w-full">

        <!-- ── Stage 1: AREA SELECTOR GRID ─────────────────────────────── -->
        <div x-show="selfSurveyActiveAreaId === null" x-transition class="flex flex-col gap-5">

            <!-- Header Banner -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v5.75c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 18.875v-5.75zM18 10.5c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 0118 19.875v-8.25zM10.5 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v10.125c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-[#1b355a]">Institutional Self-Survey</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Select an Area to begin self-rating the accreditation criteria.</p>
                    </div>
                </div>
                <span class="text-[11px] font-bold text-zinc-400 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg">9 Areas · AACCUP Rating Scale 0–5</span>
            </div>

            <!-- 9 Area Boxes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <template x-for="area in institutionalSurveyAreas" :key="area.id">
                    <button type="button"
                        @click="selectSurveyArea(area.id)"
                        class="group bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs hover:shadow-md transition-all duration-300 text-left flex flex-col gap-3 cursor-pointer hover:border-slate-350 relative overflow-hidden">

                        <!-- Color accent bar -->
                        <div class="absolute top-0 left-0 w-full h-1 rounded-t-2xl transition-all duration-300"
                             :class="area.color + ' opacity-80'"></div>

                        <div class="flex items-start gap-3 pt-1">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-black text-xs transition"
                                 :class="area.lightColor + ' ' + area.textColor">
                                <span x-text="area.code.replace('Area ', '')"></span>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 mb-0.5" x-text="area.code"></div>
                                <div class="text-sm font-bold text-[#1b355a] leading-snug group-hover:text-blue-700 transition" x-text="area.title"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-1">
                            <span class="text-[11px] text-zinc-400" x-text="area.parameters.length + ' Parameter' + (area.parameters.length > 1 ? 's' : '')"></span>
                            <span class="text-[11px] font-bold flex items-center gap-1" :class="area.textColor">
                                Start Rating
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                            </span>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        <!-- ── Stage 2: SURVEY TABLE (per Area) ──────────────────────────── -->
        <div x-show="selfSurveyActiveAreaId !== null" x-transition class="flex flex-col gap-5">


                <!-- Back + Area Title Header -->
                <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button type="button" @click="selfSurveyActiveAreaId = null"
                            class="flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#1b355a] transition cursor-pointer shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                        </button>
                    <div>
                            <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider" x-text="institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId)?.code"></div>
                            <h2 class="text-base font-extrabold text-[#1b355a] mt-0.5" x-text="(institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId)?.code || '') + ': ' + (institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId)?.title || '')"></h2>
                        </div>
                    </div>
                    <button type="button"
                        @click="selfSurveyActiveAreaId = null"
                        class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-zinc-500 hover:text-[#1b355a] transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        All Areas
                    </button>
                </div>

                <!-- RATING SCALE LEGEND -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-5 py-2.5 text-center">
                        <span class="text-xs font-extrabold text-[#1b355a] uppercase tracking-widest">Rating Scale</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-center border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-3 py-2.5 font-extrabold text-zinc-600 border-r border-slate-200 w-20">NA</th>
                                    <th class="px-3 py-2.5 font-extrabold text-zinc-600 border-r border-slate-200 w-16">0</th>
                                    <th class="px-3 py-2.5 font-extrabold text-zinc-800 border-r border-slate-200">1</th>
                                    <th class="px-3 py-2.5 font-extrabold text-zinc-800 border-r border-slate-200">2</th>
                                    <th class="px-3 py-2.5 font-extrabold text-[#1b355a] border-r border-slate-200">3</th>
                                    <th class="px-3 py-2.5 font-extrabold text-blue-700 border-r border-slate-200">4</th>
                                    <th class="px-3 py-2.5 font-extrabold text-emerald-700">5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-100">
                                    <td class="px-3 py-2 text-zinc-500 font-semibold border-r border-slate-100">–</td>
                                    <td class="px-3 py-2 text-zinc-500 font-semibold border-r border-slate-100">–</td>
                                    <td class="px-3 py-2 text-zinc-700 font-bold border-r border-slate-100">Poor</td>
                                    <td class="px-3 py-2 text-zinc-700 font-bold border-r border-slate-100">Fair</td>
                                    <td class="px-3 py-2 text-[#1b355a] font-bold border-r border-slate-100">Satisfactory</td>
                                    <td class="px-3 py-2 text-blue-700 font-bold border-r border-slate-100">Very Satisfactory</td>
                                    <td class="px-3 py-2 text-emerald-700 font-bold">Excellent</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2.5 text-zinc-500 italic leading-relaxed border-r border-slate-100 align-top">Not Applicable</td>
                                    <td class="px-3 py-2.5 text-zinc-500 italic leading-relaxed border-r border-slate-100 align-top">Missing</td>
                                    <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is met minimally in some respects, but much improvement is needed to overcome weaknesses<br><span class="italic">(75% lesser than the standards)</span></td>
                                    <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is met in most respects, but some improvement is needed to overcome weaknesses<br><span class="italic">(50% lesser than the standards)</span></td>
                                    <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is met in all respects<br><span class="italic">(100% compliance with the standards)</span></td>
                                    <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is fully met in all respects, at a level that demonstrates good practice<br><span class="italic">(50% greater than the standards)</span></td>
                                    <td class="px-3 py-2.5 text-zinc-500 leading-relaxed align-top">Criterion is fully met with substantial number of good practices, at a level that provides a model for others<br><span class="italic">(75% greater than the standards)</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SURVEY TABLE -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-sm" style="table-layout:fixed; min-width:680px;">
                            <!-- Column widths -->
                            <colgroup>
                                <col>
                                <col style="width:80px;">
                                <col style="width:100px;">
                                <col style="width:90px;">
                            </colgroup>
                            <!-- Column Headers -->
                            <thead>
                                <tr class="bg-slate-50 border-b-2 border-slate-200" style="height:110px;">
                                    <!-- Indicators -->
                                    <th class="px-5 text-left text-xs font-extrabold text-[#1b355a] border-r border-slate-200 align-bottom pb-3">Indicators</th>
                                    <!-- IR: rotated header -->
                                    <th class="border-r border-slate-200 align-bottom p-0 text-center w-[80px] min-w-[80px] max-w-[80px]">
                                        <div class="flex items-end justify-center pb-2.5 h-[110px] w-full overflow-hidden mx-auto">
                                            <span class="text-[10px] font-extrabold text-[#1b355a] uppercase tracking-wider block" style="writing-mode:vertical-rl; transform:rotate(180deg); white-space:nowrap;">
                                                Item Rating (IR)
                                            </span>
                                        </div>
                                    </th>
                                    <!-- SIOM: rotated header -->
                                    <th class="border-r border-slate-200 align-bottom p-0 text-center w-[100px] min-w-[100px] max-w-[100px]">
                                        <div class="flex items-end justify-center pb-2.5 h-[110px] w-full overflow-hidden mx-auto">
                                            <span class="text-[10px] font-extrabold text-[#1b355a] uppercase tracking-wider block" style="writing-mode:vertical-rl; transform:rotate(180deg); white-space:nowrap;">
                                                System–Implementation–Outcome Mean (SIOM)
                                            </span>
                                        </div>
                                    </th>
                                    <!-- PM: rotated header -->
                                    <th class="align-bottom p-0 text-center w-[90px] min-w-[90px] max-w-[90px]">
                                        <div class="flex items-end justify-center pb-2.5 h-[110px] w-full overflow-hidden mx-auto">
                                            <span class="text-[10px] font-extrabold text-[#1b355a] uppercase tracking-wider block" style="writing-mode:vertical-rl; transform:rotate(180deg); white-space:nowrap;">
                                                Parameter Mean (PM)
                                            </span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <template x-for="(param, pIdx) in institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId)?.parameters" :key="param.id">
                                <tbody class="border-b-2 border-slate-300">
                                    <!-- PARAMETER HEADER ROW -->
                                    <tr class="bg-[#1b355a]">
                                        <td colspan="4" class="px-5 py-2.5 text-xs font-extrabold text-white uppercase tracking-wide">
                                            <span x-text="'PARAMETER ' + param.code + ': ' + param.title"></span>
                                        </td>
                                    </tr>

                                    <!-- ── SYSTEM – INPUTS AND PROCESSES ── -->
                                    <tr class="bg-slate-100 border-b border-slate-200">
                                        <td colspan="4" class="px-5 py-1.5 text-[11px] font-extrabold text-zinc-600 uppercase tracking-wider">SYSTEM – INPUTS AND PROCESSES</td>
                                    </tr>
                                    <template x-for="ind in param.sections.system" :key="ind.id">
                                        <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                            <td class="px-5 py-3 text-sm text-[#1b355a] border-r border-slate-200">
                                                <div class="flex items-start gap-3">
                                                    <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                                    <span class="leading-relaxed" x-text="ind.statement"></span>
                                                </div>
                                            </td>
                                            <td class="border-r border-slate-200 text-center p-1 w-[80px] min-w-[80px] max-w-[80px]">
                                                <select
                                                    :value="selfSurveyRatings[ind.id] ?? ''"
                                                    @change="saveRating(ind.id, $event.target.value)"
                                                    class="w-12 mx-auto text-center text-xs font-bold text-[#1b355a] bg-white border border-slate-200 rounded-lg py-1 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a] cursor-pointer transition block">
                                                    <option value=""></option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </td>
                                            <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                            <td class="text-center p-1 w-[90px] min-w-[90px] max-w-[90px]"></td>
                                        </tr>
                                    </template>
                                    <!-- System SIOM average row -->
                                    <tr class="bg-blue-50/60 border-b border-slate-200">
                                        <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200">System mean</td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[80px] min-w-[80px] max-w-[80px]"></td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]">
                                            <span class="text-sm font-extrabold text-[#1b355a]" x-text="sectionMean(param.sections.system) ?? ''"></span>
                                        </td>
                                        <td class="text-center p-1 w-[90px] min-w-[90px] max-w-[90px]"></td>
                                    </tr>

                                    <!-- ── IMPLEMENTATION ── -->
                                    <tr class="bg-slate-100 border-b border-slate-200">
                                        <td colspan="4" class="px-5 py-1.5 text-[11px] font-extrabold text-zinc-600 uppercase tracking-wider">IMPLEMENTATION</td>
                                    </tr>
                                    <template x-for="ind in param.sections.implementation" :key="ind.id">
                                        <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                            <td class="px-5 py-3 text-sm text-[#1b355a] border-r border-slate-200">
                                                <div class="flex items-start gap-3">
                                                    <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                                    <span class="leading-relaxed" x-text="ind.statement"></span>
                                                </div>
                                            </td>
                                            <td class="border-r border-slate-200 text-center p-1 w-[80px] min-w-[80px] max-w-[80px]">
                                                <select
                                                    :value="selfSurveyRatings[ind.id] ?? ''"
                                                    @change="saveRating(ind.id, $event.target.value)"
                                                    class="w-12 mx-auto text-center text-xs font-bold text-[#1b355a] bg-white border border-slate-200 rounded-lg py-1 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a] cursor-pointer transition block">
                                                    <option value=""></option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </td>
                                            <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                            <td class="text-center p-1 w-[90px] min-w-[90px] max-w-[90px]"></td>
                                        </tr>
                                    </template>
                                    <!-- Implementation SIOM average row -->
                                    <tr class="bg-blue-50/60 border-b border-slate-200">
                                        <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200">Implementation mean</td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[80px] min-w-[80px] max-w-[80px]"></td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]">
                                            <span class="text-sm font-extrabold text-[#1b355a]" x-text="sectionMean(param.sections.implementation) ?? ''"></span>
                                        </td>
                                        <td class="text-center p-1 w-[90px] min-w-[90px] max-w-[90px]"></td>
                                    </tr>

                                    <!-- ── OUTCOME/S ── -->
                                    <tr class="bg-slate-100 border-b border-slate-200">
                                        <td colspan="4" class="px-5 py-1.5 text-[11px] font-extrabold text-zinc-600 uppercase tracking-wider">OUTCOME/S</td>
                                    </tr>
                                    <template x-for="ind in param.sections.outcome" :key="ind.id">
                                        <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                            <td class="px-5 py-3 text-sm text-[#1b355a] border-r border-slate-200">
                                                <div class="flex items-start gap-3">
                                                    <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                                    <span class="leading-relaxed" x-text="ind.statement"></span>
                                                </div>
                                            </td>
                                            <td class="border-r border-slate-200 text-center p-1 w-[80px] min-w-[80px] max-w-[80px]">
                                                <select
                                                    :value="selfSurveyRatings[ind.id] ?? ''"
                                                    @change="saveRating(ind.id, $event.target.value)"
                                                    class="w-12 mx-auto text-center text-xs font-bold text-[#1b355a] bg-white border border-slate-200 rounded-lg py-1 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a] cursor-pointer transition block">
                                                    <option value=""></option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </td>
                                            <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                            <td class="text-center p-1 w-[90px] min-w-[90px] max-w-[90px]"></td>
                                        </tr>
                                    </template>
                                    <!-- Outcome SIOM average row -->
                                    <tr class="bg-blue-50/60 border-b border-slate-200">
                                        <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200">Outcome mean</td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[80px] min-w-[80px] max-w-[80px]"></td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]">
                                            <span class="text-sm font-extrabold text-[#1b355a]" x-text="sectionMean(param.sections.outcome) ?? ''"></span>
                                        </td>
                                        <td class="text-center p-1 w-[90px] min-w-[90px] max-w-[90px]"></td>
                                    </tr>

                                    <!-- ── BEST PRACTICES row ── -->
                                    <tr class="border-b border-slate-200">
                                        <td colspan="4" class="px-5 py-3">
                                            <div class="flex flex-col gap-1.5">
                                                <span class="text-xs font-extrabold text-zinc-500 uppercase tracking-wide">Best Practices:</span>
                                                <textarea
                                                    :id="'bp_' + param.id"
                                                    x-model="selfSurveyBestPractices[param.id]"
                                                    rows="3"
                                                    placeholder="Describe notable best practices for this parameter…"
                                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-zinc-700 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/15 focus:border-[#1b355a] resize-none transition leading-relaxed">
                                                </textarea>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- ── PM row ── -->
                                    <tr class="bg-emerald-50/80 border-b-2 border-slate-300">
                                        <td class="px-5 py-2.5 text-xs font-bold text-zinc-500 border-r border-slate-200 italic">
                                            Parameter Mean —
                                            <span class="text-[#1b355a] not-italic font-extrabold" x-text="'Parameter ' + param.code + ': ' + param.title"></span>
                                        </td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[80px] min-w-[80px] max-w-[80px]"></td>
                                        <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                        <td class="text-center p-1 w-[90px] min-w-[90px] max-w-[90px]">
                                            <span class="text-sm font-extrabold text-emerald-700" x-text="paramMean(param) ?? ''"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </table>
                    </div>
                </div>

                <!-- Save / Print Actions -->
                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="selfSurveyActiveAreaId = null"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-sm rounded-xl transition cursor-pointer shadow-3xs">
                        ← Back to Areas
                    </button>
                    <button type="button"
                        onclick="window.print()"
                        class="px-5 py-2.5 bg-[#1b355a] hover:bg-[#112239] text-white font-bold text-sm rounded-xl transition cursor-pointer shadow-3xs flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                        Print / Export
                    </button>
                </div>
                </div>
            </div>
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
         x-cloak
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
             x-cloak
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