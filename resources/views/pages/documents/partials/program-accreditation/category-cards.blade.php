<!-- LEVEL 3: PROGRAM ACCREDITATION SUB-CATEGORY SELECT -->
<div x-show="accredProgram !== null && (accredCategory === null || (currentUserRole === 'task-force-member' && !accredProgram.instrument_verified))" x-transition class="flex flex-col gap-5 w-full py-2">
    
    <!-- Context Banner for Selected Program -->
    <template x-if="accredProgram !== null">
        <div class="bg-blue-50/70 border border-blue-200/70 rounded-xl px-5 py-3.5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-3xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary text-white flex items-center justify-center font-extrabold text-xs shrink-0">
                    <span x-text="accredProgram.code"></span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-extrabold text-primary" x-text="accredProgram.name"></span>
                        <span class="text-label-xs font-bold px-2 py-0.5 rounded bg-white border border-blue-200 text-primary" x-text="accredProgram.level"></span>
                    </div>
                    <p class="text-label-xs text-zinc-500 mt-0.5" x-text="accredProgram.college"></p>
                </div>
            </div>
            <button x-show="isUnrestricted || filteredPrograms.length > 1" type="button" @click="clearProgram()" class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 text-primary text-xs font-bold rounded-lg transition cursor-pointer shrink-0 shadow-3xs">
                Change Program
            </button>
        </div>
    </template>

    <!-- Task Force Locked Banner (When Instrument is NOT yet verified by Dean) -->
    <template x-if="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified">
        <div class="bg-amber-50/90 border border-amber-200 rounded-2xl p-6 shadow-3xs flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                    <x-lucide-lock class="w-6 h-6" />
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-heading-sm font-bold text-amber-900">Accreditation Instrument Pending Dean Verification</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                            Setup In Progress
                        </span>
                    </div>
                    <p class="text-body-sm text-amber-800/90 mt-1 leading-relaxed max-w-2xl">
                        The College Dean is currently configuring and verifying the accreditation instrument for <strong class="text-amber-950" x-text="accredProgram.name"></strong>. Document viewing, evidence repositories, and file uploads are locked until the instrument setup is finalized.
                    </p>
                </div>
            </div>
            <div class="shrink-0 flex items-center gap-2">
                <span class="text-label-xs font-bold text-amber-800 bg-white/90 border border-amber-200 px-3 py-2 rounded-xl shadow-3xs flex items-center gap-1.5">
                    <x-lucide-clock class="w-4 h-4 text-amber-600" />
                    <span>Awaiting Dean Approval</span>
                </span>
            </div>
        </div>
    </template>

    <!-- Dean & Staff Setup Notice (When Instrument is NOT yet verified) -->
    <template x-if="currentUserRole !== 'task-force-member' && accredProgram && !accredProgram.instrument_verified">
        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 shadow-3xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-primary flex items-center justify-center shrink-0 mt-0.5">
                    <x-lucide-file-cog class="w-5 h-5" />
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-body font-bold text-primary">Instrument Setup in Progress</h4>
                        <span class="px-2 py-0.5 rounded-full text-label-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                            Task Force Uploads Locked
                        </span>
                    </div>
                    <p class="text-body-sm text-primary/80 mt-0.5">
                        The accreditation instrument for this program has not yet been finalized. Finalizing the instrument will unlock upload access for Task Force members.
                    </p>
                </div>
            </div>
            <template x-if="accredProgram.accreditation_id">
                <a :href="'/accreditation/' + accredProgram.accreditation_id + '/instrument'" class="px-4 py-2 bg-primary hover:bg-primary-hover text-white text-body-sm font-bold rounded-xl shadow-3xs transition flex items-center gap-2 shrink-0">
                    <x-lucide-sliders class="w-4 h-4" />
                    <span>Customize & Finalize Instrument</span>
                </a>
            </template>
        </div>
    </template>

    <!-- Sub-Category Grid: Unified 5-Folder Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
        <!-- 1. Self-Survey Documents Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full"
            :class="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified ? 'opacity-60 bg-slate-50/80' : ''">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <x-lucide-clipboard-check class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Self-Survey Documents</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.
                    </p>
                </div>
            </div>
            <template x-if="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified">
                <button type="button" disabled class="w-full bg-slate-200 text-slate-500 py-3 rounded-lg font-bold text-sm cursor-not-allowed flex items-center justify-center gap-2">
                    <x-lucide-lock class="w-4 h-4" />
                    <span>Locked (Pending Setup)</span>
                </button>
            </template>
            <template x-if="currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified">
                <button type="button" @click="accredCategory = 'Self-Survey Documents'" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open Self-Survey
                </button>
            </template>
        </div>

        <!-- 2. Compliance Reports Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full"
            :class="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified ? 'opacity-60 bg-slate-50/80' : ''">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <x-lucide-file-badge class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Compliance Reports</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        Official compliance logs, AACCUP evaluations, corrective action reports, and certificates of accreditation.
                    </p>
                </div>
            </div>
            <template x-if="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified">
                <button type="button" disabled class="w-full bg-slate-200 text-slate-500 py-3 rounded-lg font-bold text-sm cursor-not-allowed flex items-center justify-center gap-2">
                    <x-lucide-lock class="w-4 h-4" />
                    <span>Locked (Pending Setup)</span>
                </button>
            </template>
            <template x-if="currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified">
                <button type="button" @click="accredCategory = 'Compliance Reports'" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open Reports
                </button>
            </template>
        </div>

        <!-- 3. Supporting Documents Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full"
            :class="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified ? 'opacity-60 bg-slate-50/80' : ''">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <x-lucide-files class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Supporting Documents</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        Checklist criteria link inputs for inputs (Systems), implementation details, outcomes, and best practices.
                    </p>
                </div>
            </div>
            <template x-if="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified">
                <button type="button" disabled class="w-full bg-slate-200 text-slate-500 py-3 rounded-lg font-bold text-sm cursor-not-allowed flex items-center justify-center gap-2">
                    <x-lucide-lock class="w-4 h-4" />
                    <span>Locked (Pending Setup)</span>
                </button>
            </template>
            <template x-if="currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified">
                <button type="button" @click="accredCategory = 'Supporting Documents'" class="w-full bg-primary hover:bg-primary-dark-hover text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open Supporting Docs
                </button>
            </template>
        </div>

        <!-- 4. Narrative Profile Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full"
            :class="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified ? 'opacity-60 bg-slate-50/80' : ''">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                    <x-lucide-notebook-pen class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Narrative Profile</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        AACCUP Level 3 narrative profile templates organized by area with direct in-app editing and formatting.
                    </p>
                </div>
            </div>
            <template x-if="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified">
                <button type="button" disabled class="w-full bg-slate-200 text-slate-500 py-3 rounded-lg font-bold text-sm cursor-not-allowed flex items-center justify-center gap-2">
                    <x-lucide-lock class="w-4 h-4" />
                    <span>Locked (Pending Setup)</span>
                </button>
            </template>
            <template x-if="currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified">
                <button type="button" @click="accredCategory = 'Narrative Profile'; initNarrativeProfile()" class="w-full bg-violet-600 hover:bg-violet-700 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open Narrative Profile
                </button>
            </template>
        </div>

        <!-- 5. Program Performance Portfolio (PPP) Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5 h-full"
            :class="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified ? 'opacity-60 bg-slate-50/80' : ''">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <x-lucide-layout-panel-top class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">Program Performance Portfolio</h3>
                    <p class="text-sm text-zinc-500 mt-2 leading-relaxed min-h-11">
                        Program performance evidence portfolios and documentation templates organized by area for in-app compilation.
                    </p>
                </div>
            </div>
            <template x-if="currentUserRole === 'task-force-member' && accredProgram && !accredProgram.instrument_verified">
                <button type="button" disabled class="w-full bg-slate-200 text-slate-500 py-3 rounded-lg font-bold text-sm cursor-not-allowed flex items-center justify-center gap-2">
                    <x-lucide-lock class="w-4 h-4" />
                    <span>Locked (Pending Setup)</span>
                </button>
            </template>
            <template x-if="currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified">
                <button type="button" @click="accredCategory = 'PPP'; initPPP()" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer">
                    Open PPP
                </button>
            </template>
        </div>
    </div>
</div>
