<!-- LEVEL 2A: SUPPORTING DOCUMENTS WORKSPACE -->
<div x-show="accredCategory === 'Supporting Documents'" x-transition class="flex flex-col gap-5">
    
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
