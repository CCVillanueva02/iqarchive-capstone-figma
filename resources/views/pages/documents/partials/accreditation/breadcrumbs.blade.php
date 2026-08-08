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
