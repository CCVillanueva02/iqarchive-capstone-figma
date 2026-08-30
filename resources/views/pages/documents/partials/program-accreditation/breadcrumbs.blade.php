<!-- Breadcrumbs Nav for Program Accreditation -->
<div>
    <!-- Level 1 Breadcrumbs (College Selection) -->
    <template x-if="accredCollege === null">
        <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
            <span class="hover:underline cursor-pointer" @click="clearCollege()">Documents</span>
            <span>&gt;</span>
            <span class="text-zinc-650 font-semibold">Program Accreditation</span>
        </div>
    </template>

    <!-- Level 2 Breadcrumbs (Program Selection inside College) -->
    <template x-if="accredCollege !== null && accredProgram === null">
        <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
            <template x-if="isUnrestricted || collegesList.length > 1">
                <button @click="clearCollege()" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-primary cursor-pointer" title="Back to Colleges">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
            </template>
            <span class="hover:underline cursor-pointer" @click="clearCollege()">Documents</span>
            <template x-if="isUnrestricted || collegesList.length > 1">
                <span class="flex items-center gap-1.5">
                    <span>&gt;</span>
                    <span class="hover:underline cursor-pointer" @click="clearCollege()">Program Accreditation</span>
                </span>
            </template>
            <span>&gt;</span>
            <template x-if="accredCollege?.code">
                <img :src="accredCollege.logo" alt="Logo" class="w-5 h-5 object-contain shrink-0" onerror="this.style.display='none'" />
            </template>
            <span class="text-zinc-650 font-semibold" x-text="accredCollege?.name"></span>
        </div>
    </template>

    <!-- Level 3 Breadcrumbs (Program Sub-Categories) -->
    <template x-if="accredCollege !== null && accredProgram !== null && accredCategory === null">
        <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
            <template x-if="isUnrestricted || filteredPrograms.length > 1">
                <button @click="clearProgram()" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-primary cursor-pointer" title="Back to Programs">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
            </template>
            <span class="hover:underline cursor-pointer" @click="clearCollege()">Documents</span>
            <template x-if="isUnrestricted || collegesList.length > 1">
                <span class="flex items-center gap-1.5">
                    <span>&gt;</span>
                    <span class="hover:underline cursor-pointer" @click="clearCollege()">Program Accreditation</span>
                </span>
            </template>
            <span>&gt;</span>
            <template x-if="accredCollege?.code">
                <img :src="accredCollege.logo" alt="Logo" class="w-5 h-5 object-contain shrink-0" onerror="this.style.display='none'" />
            </template>
            <span class="hover:underline cursor-pointer" @click="clearProgram()" x-text="accredCollege?.name"></span>
            <span>&gt;</span>
            <span class="text-zinc-650 font-semibold" x-text="accredProgram?.name"></span>
        </div>
    </template>

    <!-- Level 4 Breadcrumbs (Program Workspace Category) -->
    <template x-if="accredCollege !== null && accredProgram !== null && accredCategory !== null">
        <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex flex-wrap items-center justify-between gap-3 text-sm text-zinc-400 font-medium">
            <div class="flex items-center gap-1.5 flex-wrap">
                <button @click="accredCategory = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-primary cursor-pointer" title="Back to Sub-Categories">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="clearCollege()">Documents</span>
                <template x-if="isUnrestricted || collegesList.length > 1">
                    <span class="flex items-center gap-1.5">
                        <span>&gt;</span>
                        <span class="hover:underline cursor-pointer" @click="clearCollege()">Program Accreditation</span>
                    </span>
                </template>
                <span>&gt;</span>
                <template x-if="accredCollege?.code">
                    <img :src="accredCollege.logo" alt="Logo" class="w-5 h-5 object-contain shrink-0" onerror="this.style.display='none'" />
                </template>
                <span class="hover:underline cursor-pointer" @click="clearProgram()" x-text="accredCollege?.name"></span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="accredCategory = null" x-text="accredProgram?.name"></span>
                <span>&gt;</span>
                <span class="text-zinc-650 font-semibold" x-text="accredCategory"></span>
            </div>

            <template x-if="accredCategory === 'Self-Survey Documents'">
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button"
                        onclick="window.print()"
                        class="px-4 py-2 bg-primary hover:bg-primary-hover text-white font-bold text-xs rounded-xl transition cursor-pointer shadow-3xs flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                        Print / Export
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>
