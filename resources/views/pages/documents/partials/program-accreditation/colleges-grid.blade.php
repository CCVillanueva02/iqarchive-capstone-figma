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

    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div class="relative w-full max-w-md">
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

        @if(auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('system-administrator'))
        <button @click="openCreateCollegeModal" class="flex items-center gap-2 bg-[#f27224] hover:bg-[#d65f1a] text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow-3xs transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Add College</span>
        </button>
        @endif
    </div>

    <!-- College Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="col in availableColleges" :key="col.id">
            <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 group cursor-pointer" @click="selectCollege(col)">
                <div class="flex flex-col gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <!-- Left Side: Profile Icon & College Name -->
                        <div class="flex items-center gap-3 overflow-hidden">
                            <img :src="col.logo" :alt="col.code + ' Logo'" class="w-11 h-11 object-contain shrink-0" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                            <div class="w-11 h-11 rounded-xl items-center justify-center font-black text-sm shrink-0" style="display: none;" :class="col.iconBg || 'bg-blue-50 text-primary'">
                                <span x-text="col.code"></span>
                            </div>
                            <div class="flex flex-col overflow-hidden">
                                <h3 class="text-body font-bold text-primary group-hover:text-primary-hover transition truncate" x-text="col.name" :title="col.name"></h3>
                                <p class="text-xs text-zinc-500 mt-0.5 truncate" x-text="col.description || 'Academic College Unit'"></p>
                            </div>
                        </div>

                        <!-- Right Side: Program Count & Actions (Upper Right) -->
                        <div class="flex items-center gap-2 shrink-0 pt-0.5">
                            <span class="text-label-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-zinc-600 border border-slate-200 whitespace-nowrap" x-text="(col.programCount || 0) + ' Programs'"></span>

                            @if(auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('system-administrator'))
                            <div class="flex items-center">
                                <button @click.stop="openEditCollegeModal(col)" class="p-1 text-zinc-400 hover:text-primary transition" title="Edit College">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.89 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.89l3.4-3.4" />
                                    </svg>
                                </button>
                                <button @click.stop="confirmDeleteCollege(col)" class="p-1 text-zinc-400 hover:text-rose-500 transition" title="Delete College">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>
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

    <!-- Create / Edit College Modal -->
    <div x-show="showCollegeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm" style="display: none;" x-transition.opacity>
        <div @click.away="closeCollegeModal()" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" x-transition.scale.origin.bottom>
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-heading-sm font-bold text-primary" x-text="collegeForm.id ? 'Edit College' : 'Add College'"></h3>
                <button @click="closeCollegeModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 flex flex-col gap-5">
                <div>
                    <label class="block text-label font-bold text-slate-500 mb-1.5 uppercase tracking-wider">College Name</label>
                    <input type="text" x-model="collegeForm.name" class="w-full text-body-sm border border-slate-200 rounded-lg px-4 py-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-slate-50 transition" placeholder="e.g. College of Science">
                </div>
                <div>
                    <label class="block text-label font-bold text-slate-500 mb-1.5 uppercase tracking-wider">College Code</label>
                    <input type="text" x-model="collegeForm.code" class="w-full text-body-sm border border-slate-200 rounded-lg px-4 py-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-slate-50 transition" placeholder="e.g. CS">
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button @click="closeCollegeModal()" class="px-4 py-2.5 rounded-xl text-body-sm font-bold text-slate-600 hover:bg-slate-200 transition cursor-pointer">Cancel</button>
                <button @click="saveCollege()" class="px-5 py-2.5 rounded-xl text-body-sm font-bold text-white bg-primary hover:bg-primary-hover shadow-3xs transition cursor-pointer flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Save College</span>
                </button>
            </div>
        </div>
    </div>
</div>