<!-- Top Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        @if(in_array(auth()->user()->role, ['iqa-admin', 'iqa-member', 'task-force', 'task-force-member']) || auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('iqa-member') || auth()->user()->hasRole('task-force'))
        <!-- Common Documents Tab Header -->
        <div x-show="activeTab === 'common-documents' || activeTab === 'common'">
            <template x-if="selectedCategory === null">
                <div>
                    <h1 class="text-3xl font-bold text-[#1b355a]">Common Documents</h1>
                    <p class="text-sm text-zinc-500 mt-1"><span x-text="categories.length">9</span> categories &middot; manage your common university documents</p>
                </div>
            </template>
            <template x-if="selectedCategory !== null">
                <div class="flex items-center gap-3">
                    <button @click="selectCategory(null)" class="flex items-center justify-center p-2.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-[#1b355a] transition shadow-3xs cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-1.5 text-xs text-zinc-400 font-medium">
                            <span class="hover:underline cursor-pointer" @click="selectCategory(null)">Common Documents</span>
                            <span>&gt;</span>
                            <span class="text-zinc-600 font-semibold" x-text="selectedCategory"></span>
                        </div>
                        <h1 class="text-2xl font-bold text-[#1b355a] mt-0.5" x-text="selectedCategory"></h1>
                    </div>
                </div>
            </template>
        </div>
        @endif

        <!-- Program Accreditation Tab Header -->
        <div x-show="activeTab === 'program-accreditation'">
            <h1 class="text-3xl font-bold text-[#1b355a]">Program Accreditation Documents</h1>
            <p class="text-sm text-zinc-500 mt-1">Manage degree program accreditation files, faculty portfolios, and compliance reports</p>
        </div>

        <!-- Institutional Accreditation Tab Header -->
        <div x-show="activeTab === 'institutional-accreditation'">
            <h1 class="text-3xl font-bold text-[#1b355a]">Institutional Accreditation Documents</h1>
            <p class="text-sm text-zinc-500 mt-1">Manage university-wide accreditation, governance, and self-survey compliance files</p>
        </div>
    </div>
    
    <div class="flex items-center gap-3 self-end md:self-auto">
        <!-- Bell Notification Button -->
        <button type="button" class="relative p-2 rounded-lg bg-white border border-slate-200 text-zinc-500 hover:text-[#1b355a] transition shadow-3xs cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" />
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-orange-500 rounded-full border border-white"></span>
        </button>
    </div>
</div>
