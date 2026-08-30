<!-- LEVEL 3A: SUPPORTING DOCUMENTS WORKSPACE -->
<div x-show="accredCategory === 'Supporting Documents' && (currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified)" x-transition class="flex flex-col gap-5">
    
    <!-- Context Header Bar for Supporting Docs Workspace -->
    <template x-if="accredProgram !== null">
        <div class="bg-white border border-slate-200/60 rounded-xl px-5 py-3 shadow-3xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-xs font-bold text-primary">
                <span class="px-2 py-0.5 bg-surface-subtle text-primary rounded border border-primary/10" x-text="accredProgram.code"></span>
                <span x-text="accredProgram.name"></span>
                <span class="text-zinc-400 font-normal">•</span>
                <span class="text-zinc-500 font-medium" x-text="accredProgram.college"></span>
            </div>

            <!-- Header Action Controls -->
            <div class="flex items-center gap-3">
                <!-- Submit to Dean Button for Task Force (Step 5.3) -->
                <template x-if="currentUserRole === 'task-force-member' || userRole === 'task-force-member'">
                    <div>
                        <template x-if="accredProgram.accreditation_status === 'dean_verification'">
                            <span class="px-3 py-1.5 bg-amber-50 text-amber-800 border border-amber-200 text-label-xs font-bold rounded-xl flex items-center gap-1.5 shadow-3xs">
                                <x-lucide-clock class="w-3.5 h-3.5 text-amber-600" />
                                <span>Submitted for Dean Review</span>
                            </span>
                        </template>
                        <template x-if="accredProgram.accreditation_status !== 'dean_verification' && accredProgram.accreditation_status !== 'submitted' && accredProgram.accreditation_status !== 'completed'">
                            <button type="button" 
                                @click="openSubmitToDeanModal()" 
                                class="px-3.5 py-1.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold rounded-xl shadow-3xs transition cursor-pointer flex items-center gap-1.5">
                                <x-lucide-send class="w-3.5 h-3.5" />
                                <span>Submit Evidence to Dean</span>
                            </button>
                        </template>
                    </div>
                </template>

                <button x-show="isUnrestricted || filteredPrograms.length > 1" type="button" @click="clearProgram()" class="text-xs font-bold text-primary hover:underline cursor-pointer">
                    Switch Program
                </button>
            </div>
        </div>
    </template>

    <!-- Area Selector Horizontal Tablist -->
    <div class="flex overflow-x-auto gap-3 pb-2 w-full select-none">
        <template x-for="area in activeAccredData?.areas" :key="area.id">
            <button type="button"
                class="flex-1 shrink-0 min-w-50 bg-white rounded-xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24"
                :class="accredActiveAreaId === area.id ? 'border-primary ring-1 ring-primary/30 shadow-xs' : 'border-slate-200/60 hover:border-slate-300'"
                @click="selectArea(area.id)">
                <div>
                    <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                    <span class="text-sm font-bold text-primary mt-1 leading-tight line-clamp-2 block" x-text="area.title"></span>
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
            <span class="text-sm font-bold text-primary tracking-wide px-1">Parameters Available</span>
            <div class="flex flex-col gap-1.5">
                <template x-for="param in activeArea?.parameters" :key="param.id">
                    <button type="button"
                        class="w-full text-left p-3 rounded-lg text-sm font-semibold flex flex-col gap-1 transition cursor-pointer relative overflow-hidden"
                        :class="accredActiveParamId === param.id ? 'bg-slate-50 text-primary border-l-4 border-primary pl-2.5 shadow-3xs' : 'text-zinc-500 hover:bg-slate-50/30 hover:text-primary pl-3.5 border-l-4 border-transparent'"
                        @click="accredActiveParamId = param.id; accredActiveSection = 'systems'">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-primary text-label-xs uppercase tracking-wide" x-text="param.code"></span>
                            <span class="text-label-xs font-bold text-emerald-600" x-text="param.progress + '%'"></span>
                        </div>
                        <span class="text-xs font-bold leading-snug mt-1 text-primary" x-text="param.title"></span>
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
                        <span class="text-label-xs font-bold text-primary uppercase tracking-wider" x-text="activeParam?.code"></span>
                        <h2 class="text-base font-extrabold text-primary mt-1" x-text="activeParam?.code + ' - ' + activeParam?.title"></h2>
                    </div>

                    <!-- Stats Grid -->
                    <div class="flex items-center gap-6 shrink-0 text-right">
                        <div>
                            <div class="text-sm font-extrabold text-primary" x-text="activeParam?.sections?.systems?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.implementation?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.outcomes?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0)"></div>
                            <div class="text-label-xs text-zinc-400 uppercase font-bold tracking-wide mt-0.5">Documents</div>
                        </div>
                        <div class="border-l border-slate-200 h-8"></div>
                        <div>
                            <div class="text-sm font-extrabold text-primary" x-text="activeParam?.sections?.systems?.reduce((acc, item) => acc + (item.documents ? item.documents.filter(d => d.status === 'Verified').length : 0), 0) + activeParam?.sections?.implementation?.reduce((acc, item) => acc + (item.documents ? item.documents.filter(d => d.status === 'Verified').length : 0), 0) + activeParam?.sections?.outcomes?.reduce((acc, item) => acc + (item.documents ? item.documents.filter(d => d.status === 'Verified').length : 0), 0) + '/' + (activeParam?.sections?.systems?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.implementation?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0) + activeParam?.sections?.outcomes?.reduce((acc, item) => acc + (item.documents ? item.documents.length : 0), 0))"></div>
                            <div class="text-label-xs text-zinc-400 uppercase font-bold tracking-wide mt-0.5">Verified</div>
                        </div>
                        <div class="border-l border-slate-200 h-8"></div>
                        <div>
                            <div class="text-sm font-extrabold text-emerald-600" x-text="activeParam?.progress + '%'"></div>
                            <div class="text-label-xs text-zinc-400 uppercase font-bold tracking-wide mt-0.5">Progress</div>
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
                    :class="accredActiveSection === 'systems' ? 'border-primary text-primary' : 'border-transparent text-zinc-400 hover:text-zinc-600'"
                    @click="accredActiveSection = 'systems'">
                    Systems - Inputs & Processes
                </button>
                <button type="button"
                    class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap"
                    :class="accredActiveSection === 'implementation' ? 'border-primary text-primary' : 'border-transparent text-zinc-400 hover:text-zinc-600'"
                    @click="accredActiveSection = 'implementation'">
                    Implementation
                </button>
                <button type="button"
                    class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap"
                    :class="accredActiveSection === 'outcomes' ? 'border-primary text-primary' : 'border-transparent text-zinc-400 hover:text-zinc-600'"
                    @click="accredActiveSection = 'outcomes'">
                    Outcomes
                </button>
                <button type="button"
                    class="pb-3 border-b-2 transition cursor-pointer whitespace-nowrap"
                    :class="accredActiveSection === 'bestpractices' ? 'border-primary text-primary' : 'border-transparent text-zinc-400 hover:text-zinc-600'"
                    @click="accredActiveSection = 'bestpractices'">
                    Best Practices
                </button>
            </div>

            <!-- Checklist list area -->
            <div class="flex flex-col gap-4">
                <template x-for="item in activeChecklistItems" :key="item.id">
                    <div class="border border-slate-200 rounded-xl p-5 flex flex-col gap-4 bg-slate-50/30">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <span class="text-sm font-bold text-primary bg-surface-subtle px-3 py-1 rounded-full shrink-0" x-text="item.id"></span>
                                <p class="text-sm font-bold text-primary leading-relaxed mt-0.5" x-text="item.statement"></p>
                            </div>
                            <!-- Quick Upload Action in Header -->
                            <template x-if="accredActiveSection !== 'bestpractices'">
                                <button type="button" 
                                    @click="openUploadModal(item)" 
                                    class="shrink-0 px-3 py-1 bg-white hover:bg-slate-100 border border-slate-200 text-primary text-label-xs font-bold rounded-lg transition cursor-pointer flex items-center gap-1 shadow-3xs"
                                    title="Upload file for this criterion">
                                    <x-lucide-plus class="w-3.5 h-3.5 text-brand-orange" />
                                    <span>Add File</span>
                                </button>
                            </template>
                        </div>

                        <!-- If Best Practices -->
                        <template x-if="accredActiveSection === 'bestpractices'">
                            <p class="text-sm text-zinc-500 italic pl-12" x-text="item.description"></p>
                        </template>

                        <!-- If Document section -->
                        <template x-if="accredActiveSection !== 'bestpractices'">
                            <div class="pl-12 flex flex-col gap-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider" x-text="'Supporting Documents Attached (' + (item.documents ? item.documents.length : 0) + ')'"></span>
                                </div>

                                <!-- Linked documents list -->
                                <template x-if="item.documents && item.documents.length > 0">
                                    <div class="flex flex-col gap-2">
                                        <template x-for="doc in item.documents" :key="doc.name">
                                            <div class="flex items-center justify-between p-3.5 bg-white border border-slate-200/80 rounded-lg text-sm gap-3 shadow-3xs">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    <x-lucide-file-text class="w-4 h-4 text-rose-500 shrink-0" />
                                                    <div class="min-w-0">
                                                        <span class="font-bold text-primary block truncate" x-text="doc.name"></span>
                                                        <span class="text-label-xs text-zinc-400 mt-0.5 block" x-text="doc.size + ' • Uploaded ' + doc.date"></span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-4 shrink-0">
                                                    <span class="px-2 py-0.5 rounded text-label-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100"
                                                        :class="doc.status === 'Verified' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100'"
                                                        x-text="doc.status"></span>
                                                    <button type="button" class="text-sm font-bold text-primary hover:underline cursor-pointer" @click="openDoc(doc)">
                                                        View Drawer
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <!-- No documents linked -> Upload button -->
                                <template x-if="!item.documents || item.documents.length === 0">
                                    <button type="button" class="border border-dashed border-slate-300 hover:border-primary bg-slate-50/50 hover:bg-slate-50 text-primary text-sm font-bold px-4 py-3 rounded-lg flex items-center justify-center gap-2 cursor-pointer transition w-full" @click="openUploadModal(item)">
                                        <x-lucide-upload class="w-4 h-4 text-brand-orange" />
                                        <span>Upload & Link Document</span>
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
