<x-layouts::app :title="__('Submission Evaluation')">
    <div x-data="Object.assign(documentWorkspace(), { activeTab: 'accreditation', accredLevel: 'program', accredCategory: 'Supporting Documents' })" 
         class="w-full flex flex-col bg-[#f4f6fa] min-h-screen relative overflow-hidden font-sans">
        
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-6">
            <!-- Reviewer Session Information & Logout (No Sidebar, No horizontal nav header) -->
            <div class="flex justify-between items-center border-b border-slate-200/60 pb-4 mb-2 select-none">
                <div class="flex items-center gap-2.5">
                    <img src="/bulogo.png" alt="BU Logo" class="w-8 h-8 object-contain shrink-0" />
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-[#002B61] leading-none">BU IQArchive</span>
                        <span class="text-[9px] text-zinc-500 font-bold uppercase tracking-wider mt-1">Accreditation Audit Workspace</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-zinc-500">Reviewer: <strong class="text-[#002B61]">{{ auth()->user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-zinc-200 hover:bg-zinc-300 text-zinc-700 text-[11px] font-bold rounded-lg transition cursor-pointer">
                            Log out
                        </button>
                    </form>
                </div>
            </div>

            <!-- Area Selector Horizontal Tablist (Starts directly with Areas) -->
            <div class="flex overflow-x-auto gap-4 pb-2 w-full select-none scrollbar-thin">
                <template x-for="area in activeAccredData?.areas" :key="area.id">
                    <button type="button"
                        class="flex-1 shrink-0 min-w-[280px] bg-white rounded-2xl border border-slate-200/50 p-5 text-left shadow-3xs hover:shadow-xs transition duration-200 cursor-pointer flex flex-col justify-center h-20 relative overflow-hidden"
                        :class="accredActiveAreaId === area.id ? 'border-[#1b355a] ring-1 ring-[#1b355a]/10' : ''"
                        @click="selectArea(area.id)">
                        <div class="pr-2">
                            <span class="text-[9px] font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                            <span class="text-sm font-bold text-[#1b355a] mt-1 leading-tight line-clamp-1 block" x-text="area.title"></span>
                        </div>
                    </button>
                </template>
            </div>

            <!-- Main workspace split panel -->
            <div class="flex flex-col lg:flex-row gap-6 items-start w-full">
                <!-- Left Pane: Parameters Available -->
                <div class="w-full lg:w-72 shrink-0 flex flex-col gap-3 bg-white border border-slate-200/50 rounded-2xl p-4 shadow-3xs">
                    <span class="text-xs font-bold text-[#1b355a] tracking-wider uppercase px-1 select-none">Parameters Available</span>
                    <div class="flex flex-col gap-1.5">
                        <template x-for="param in activeArea?.parameters" :key="param.id">
                            <button type="button"
                                class="w-full text-left p-3.5 rounded-xl text-sm font-semibold flex flex-col gap-1 transition cursor-pointer relative overflow-hidden"
                                :class="accredActiveParamId === param.id ? 'bg-slate-50/80 text-[#1b355a] border-l-4 border-[#1b355a] pl-2.5 shadow-3xs' : 'text-zinc-500 hover:bg-slate-50/40 hover:text-[#1b355a] pl-3.5 border-l-4 border-transparent'"
                                @click="accredActiveParamId = param.id; accredActiveSection = 'systems'">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-[#1b355a] text-[10px] uppercase tracking-wide" x-text="param.code"></span>
                                </div>
                                <span class="text-xs font-bold leading-snug mt-1 text-[#1b355a]" x-text="param.title"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Right Pane: Parameters checklist workspace -->
                <div class="flex-1 bg-white border border-slate-200/50 rounded-2xl p-6 shadow-3xs flex flex-col gap-6 w-full">
                    <!-- Parameter Title Header Block -->
                    <div class="flex flex-col gap-2 pb-4 border-b border-slate-100">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <span class="text-[9px] font-bold text-zinc-400 uppercase tracking-wider" x-text="activeParam?.code"></span>
                                <h2 class="text-base font-extrabold text-[#1b355a] mt-0.5" x-text="activeParam?.code + ' - ' + activeParam?.title"></h2>
                            </div>

                            <!-- Simplified documents counter (No Verified, No Progress) -->
                            <div class="flex items-center gap-2 shrink-0 select-none font-sans bg-slate-50 border border-slate-200/40 px-3.5 py-2 rounded-xl">
                                <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Total Documents:</span>
                                <span class="text-sm font-extrabold text-[#1b355a]" x-text="activeParam?.sections?.systems?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.implementation?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.outcomes?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0)"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Parameter Section Navigation Tabs -->
                    <div class="flex border-b border-slate-200 text-xs font-bold uppercase tracking-wider select-none gap-2">
                        <button type="button" class="pb-3 px-4 border-b-2 transition cursor-pointer"
                            :class="accredActiveSection === 'systems' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-400 hover:text-zinc-650'"
                            @click="accredActiveSection = 'systems'">
                            Systems - Inputs & Processes
                        </button>
                        <button type="button" class="pb-3 px-4 border-b-2 transition cursor-pointer"
                            :class="accredActiveSection === 'implementation' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-400 hover:text-zinc-650'"
                            @click="accredActiveSection = 'implementation'">
                            Implementation
                        </button>
                        <button type="button" class="pb-3 px-4 border-b-2 transition cursor-pointer"
                            :class="accredActiveSection === 'outcomes' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-400 hover:text-zinc-650'"
                            @click="accredActiveSection = 'outcomes'">
                            Outcomes
                        </button>
                        <button type="button" class="pb-3 px-4 border-b-2 transition cursor-pointer"
                            :class="accredActiveSection === 'bestpractices' ? 'border-[#1b355a] text-[#1b355a]' : 'border-transparent text-zinc-400 hover:text-zinc-650'"
                            @click="accredActiveSection = 'bestpractices'">
                            Best Practices
                        </button>
                    </div>

                    <!-- Checklist Statements List -->
                    <div class="flex flex-col gap-5">
                        <template x-for="item in activeParam?.sections?.[accredActiveSection]" :key="item.id">
                            <div class="bg-zinc-50 border border-slate-200/50 rounded-xl p-5 shadow-3xs flex flex-col gap-4">
                                <!-- Statement description -->
                                <div class="flex gap-3.5 items-start">
                                    <span class="px-2.5 py-1 bg-blue-50 text-[#1b355a] font-bold text-xs rounded-full shrink-0 select-none" x-text="item.id"></span>
                                    <p class="text-sm font-semibold text-[#1b355a] leading-relaxed pt-0.5" x-text="item.statement"></p>
                                </div>

                                <!-- Supporting Documents attached -->
                                <div class="flex flex-col gap-2 border-t border-slate-200/60 pt-3">
                                    <span class="text-[9px] font-bold uppercase tracking-wider text-zinc-400 block mb-1.5 font-sans">
                                        Supporting Documents Attached (<span x-text="item.documents ? item.documents.length : 0"></span>)
                                    </span>
                                    
                                    <div class="flex flex-col gap-2">
                                        <template x-for="doc in item.documents" :key="doc.name">
                                            <div class="bg-white border border-slate-200/60 hover:border-slate-350 rounded-xl p-3.5 flex items-center justify-between transition gap-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 bg-rose-50 text-rose-500 rounded-lg">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-semibold text-[#1b355a] line-clamp-1" x-text="doc.name"></span>
                                                        <span class="text-[10px] text-zinc-400 mt-0.5 font-medium" x-text="doc.size + ' • Uploaded ' + doc.date"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center gap-3">
                                                    <button type="button" @click="viewDocumentDetails(doc)" class="text-xs font-bold text-[#1b355a] hover:underline cursor-pointer">
                                                        View Drawer
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        @include('pages.roles.iqa-member.partials.detail-drawer')
    </div>

    @vite('resources/js/iqa-documents.js')
</x-layouts::app>
