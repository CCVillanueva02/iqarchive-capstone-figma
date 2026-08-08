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
