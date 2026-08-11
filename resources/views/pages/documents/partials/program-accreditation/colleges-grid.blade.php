<!-- LEVEL 1: COLLEGE SELECTION UI -->
<div x-show="accredCollege === null" x-transition class="flex flex-col gap-6 w-full py-2">
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
