<!-- ================= TAB: ACCREDITATION ================= -->
<div x-show="activeTab === 'accreditation'" x-transition class="flex flex-col gap-6">
    
    <!-- Breadcrumbs Nav for Accreditation -->
    <div>
        <!-- Level 1 Breadcrumbs -->
        <template x-if="accredLevel === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="text-zinc-650 font-semibold">Accreditation</span>
            </div>
        </template>

        <!-- Level 2 Breadcrumbs -->
        <template x-if="accredLevel !== null && accredCategory === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="accredLevel = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null">Documents</span>
                <span>&gt;</span>
                <span class="text-zinc-655 font-semibold" x-text="accredLevel === 'program' ? 'Program Accreditation' : 'Institutional Accreditation'"></span>
            </div>
        </template>

        <!-- Level 3 Breadcrumbs -->
        <template x-if="accredLevel !== null && accredCategory !== null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="accredCategory = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCategory = null">Documents</span>
                <span>&gt;</span>
                <span class="hover:underline cursor-pointer" @click="accredCategory = null" x-text="accredLevel === 'program' ? 'Program Accreditation' : 'Institutional Accreditation'"></span>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.19a.75.75 0 01.44-.92l8-3a.75.75 0 01.56 0l8 3a.75.75 0 010 1.41l-8 3a.75.75 0 01-.56 0l-8-3a.75.75 0 01-.44-.92z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.19v6.26a1.5 1.5 0 001.07 1.43l7.5 2.14a1.5 1.5 0 00.84 0l7.5-2.14a1.5 1.5 0 001.07-1.43v-6.26" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#1b355a]">Program Accreditation</h3>
                <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                    Evaluate specific degree programs (e.g. BSCS, BSIT, BSEE) for academic quality, faculty portfolio, and student facilities.
                </p>
            </div>
            <button type="button" @click="accredLevel = 'program'; accredCategory = null" class="w-full mt-2 bg-[#1b355a] hover:bg-[#112239] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
                Select Program
            </button>
        </div>

        <!-- Institutional Accreditation Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-50 text-[#f27224] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.33A2.25 2.25 0 0018 8.08H6A2.25 2.25 0 003.75 10.33V21h16.5z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#1b355a]">Institutional Accreditation</h3>
                <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                    Evaluate university-wide administration, leadership, fiscal soundness, and governance structure (Area I to VIII).
                </p>
            </div>
            <button type="button" @click="accredLevel = 'institutional'; accredCategory = null" class="w-full mt-2 bg-[#f27224] hover:bg-[#d65f1a] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
                Select Institutional
            </button>
        </div>
    </div>

    <!-- LEVEL 2: ACCREDITATION SUB-CATEGORY SELECT -->
    <div x-show="accredLevel !== null && accredCategory === null" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full py-4">
        <!-- Self-Survey Documents Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col justify-between gap-5">
            <div class="flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5m-16.5 3.75h16.5m-16.5-11.25h16.5m-16.5-3.75h16.5" />
                    </svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
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

    <!-- LEVEL 3A: SUPPORTING DOCUMENTS WORKSPACE -->
    <div x-show="accredLevel !== null && accredCategory === 'Supporting Documents'" x-transition class="flex flex-col gap-5">
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
    <div x-show="accredLevel !== null && accredCategory === 'Self-Survey Documents'" x-transition class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/60 rounded-2xl shadow-3xs min-h-[400px] gap-4 max-w-2xl mx-auto w-full">
        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v5.75c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 013 18.875v-5.75zM18 10.5c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 0118 19.875v-8.25zM10.5 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v10.125c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625z" />
            </svg>
        </div>
        <h2 class="text-lg font-extrabold text-zinc-900">Self Survey Documents Workspace</h2>
        <p class="text-sm text-zinc-500 max-w-md leading-relaxed">
            This workspace holds numerical ratings, self-audit scoresheets, and diagnostic compliance evaluations. Click the breadcrumbs to return to your folders.
        </p>
        <button type="button" @click="accredCategory = null" class="mt-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold rounded-lg transition text-sm cursor-pointer shadow-3xs">
            Back to Folders
        </button>
    </div>

    <!-- LEVEL 3C: COMPLIANCE REPORTS VIEW -->
    <div x-show="accredLevel !== null && accredCategory === 'Compliance Reports'" x-transition class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/60 rounded-2xl shadow-3xs min-h-[400px] gap-4 max-w-2xl mx-auto w-full">
        <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75a1.125 1.125 0 00-1.125 1.125v3.375m9 0h-9M9 12h6m-6 3H6.75a3 3 0 01-3-3V6.75a3 3 0 013-3h10.5a3 3 0 013 3V12a3 3 0 01-3 3H15" />
            </svg>
        </div>
        <h2 class="text-lg font-extrabold text-zinc-900">Compliance & Accreditation Reports</h2>
        <p class="text-sm text-zinc-500 max-w-md leading-relaxed">
            Access and manage external evaluation audits, corrective plans, and AACCUP certificates. Click the breadcrumbs to return to your folders.
        </p>
        <button type="button" @click="accredCategory = null" class="mt-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold rounded-lg transition text-sm cursor-pointer shadow-3xs">
            Back to Folders
        </button>
    </div>
</div>
