<div x-data="documentsWorkspace()" class="flex flex-col gap-6 relative w-full h-full">

    <!-- Breadcrumbs -->
    <div>
        <template x-if="accredLevel === null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <span class="text-zinc-650 font-semibold">Documents Overview</span>
            </div>
        </template>
        
        <template x-if="accredLevel !== null">
            <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3.5 shadow-3xs flex items-center gap-1.5 text-sm text-zinc-400 font-medium">
                <button @click="accredLevel = null; selectedProgram = null; documentsSearchQuery = ''; documentsOfficeFilter = 'all'; documentsStatusFilter = 'all'" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <span class="hover:underline cursor-pointer" @click="accredLevel = null; selectedProgram = null">Documents</span>
                <span>&gt;</span>
                <template x-if="selectedProgram === null">
                    <span class="text-zinc-655 font-semibold" x-text="activeDocumentsData?.title"></span>
                </template>
                <template x-if="selectedProgram !== null">
                    <div class="flex items-center gap-1.5">
                        <span class="hover:underline cursor-pointer" @click="selectedProgram = null" x-text="activeDocumentsData?.title"></span>
                        <span>&gt;</span>
                        <span class="text-zinc-655 font-semibold" x-text="selectedProgram.name"></span>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- LEVEL 1: ACCREDITATION LEVEL SELECT -->
    <div x-show="accredLevel === null" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto w-full py-6">
        <!-- Program Accreditation Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-50 text-[#1b355a] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#1b355a]">Program Accreditation</h3>
                <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                    Monitor document submissions and compliance rates across specific academic degree programs.
                </p>
            </div>
            <button type="button" @click="accredLevel = 'program'" class="w-full mt-2 bg-[#1b355a] hover:bg-[#112239] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
                Select Program
            </button>
        </div>

        <!-- Institutional Accreditation Card -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md transition-all duration-300 flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-orange-50 text-[#f27224] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#1b355a]">Institutional Accreditation</h3>
                <p class="text-sm text-zinc-500 mt-2 leading-relaxed max-w-sm">
                    Track the overall university-wide compliance status for administrative and governance operations.
                </p>
            </div>
            <button type="button" @click="accredLevel = 'institutional'" class="w-full mt-2 bg-[#f27224] hover:bg-[#d65f1a] text-white py-3 rounded-lg font-bold text-sm shadow-2xs transition cursor-pointer">
                Select Institutional
            </button>
        </div>
    </div>

    <!-- LEVEL 2: DASHBOARD VIEW -->
    <div x-show="accredLevel !== null" x-transition class="flex flex-col gap-6 w-full py-2">
        <div x-show="selectedProgram === null" x-transition class="flex flex-col gap-6 w-full">
            
        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-blue-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Total Areas</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                    </div>
                </div>
                <div class="relative z-10 flex items-end gap-2 mt-1">
                    <span class="text-3xl font-black text-[#1b355a]" x-text="metrics.total"></span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Compliant</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <div class="relative z-10 flex items-end gap-2 mt-1">
                    <span class="text-3xl font-black text-emerald-600" x-text="metrics.compliant"></span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-amber-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">In Progress</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <div class="relative z-10 flex items-end gap-2 mt-1">
                    <span class="text-3xl font-black text-amber-500" x-text="metrics.inProgress"></span>
                </div>
            </div>

            <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-2 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-rose-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Overdue</span>
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
                        </svg>
                    </div>
                </div>
                <div class="relative z-10 flex items-end gap-2 mt-1">
                    <span class="text-3xl font-black text-rose-500" x-text="metrics.overdue"></span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- Main Content Area: Search and Table -->
            <div class="flex-1 flex flex-col gap-4 min-w-0">
                <!-- Search and Filters -->
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
                    <div class="relative flex-1 w-full max-w-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input type="text"
                            x-model="documentsSearchQuery"
                            placeholder="Search by area or office..."
                            class="w-full pl-10 pr-9 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-zinc-800 focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a] transition" />
                    </div>
                    
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <select x-model="documentsOfficeFilter" class="flex-1 md:flex-none px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-zinc-700 font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20">
                            <option value="all">All Offices/Colleges</option>
                            <template x-for="opt in officeOptions" :key="opt">
                                <option :value="opt" x-text="opt"></option>
                            </template>
                        </select>
                        <select x-model="documentsStatusFilter" class="flex-1 md:flex-none px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-zinc-700 font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20">
                            <option value="all">All Statuses</option>
                            <option value="compliant">Compliant</option>
                            <option value="in_progress">In Progress</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-zinc-600">
                            <thead class="bg-slate-50 border-b border-slate-200/80 text-xs text-zinc-500 uppercase tracking-wider font-bold">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Area / Program</th>
                                    <th scope="col" class="px-6 py-4">Responsible Office</th>
                                    <th scope="col" class="px-6 py-4">Progress</th>
                                    <th scope="col" class="px-6 py-4">Deadline</th>
                                    <th scope="col" class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="area in filteredAreas" :key="area.id">
                                    <tr @click="selectedProgram = area" class="hover:bg-slate-50/50 transition cursor-pointer group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-[#1b355a] group-hover:text-blue-600 transition" x-text="area.name"></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-zinc-600 font-medium" x-text="area.office"></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-full h-1.5 bg-slate-100 rounded-full max-w-[80px]">
                                                    <div class="h-full bg-[#1b355a] rounded-full" :style="'width: ' + area.progress + '%'"></div>
                                                </div>
                                                <span class="text-xs font-bold text-zinc-700" x-text="area.progress + '%'"></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-zinc-500 text-xs font-medium flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <span x-text="area.deadline"></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide border inline-flex items-center justify-center w-[85px]"
                                                :class="getStatusBadgeClass(area.status)"
                                                x-text="getStatusLabel(area.status)">
                                            </span>
                                        </td>
                                    </tr>
                                </template>
                                
                                <template x-if="filteredAreas.length === 0">
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center gap-3">
                                                <div class="w-12 h-12 rounded-full bg-slate-50 text-zinc-400 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-sm font-bold text-zinc-700">No documents found</h3>
                                                <p class="text-xs text-zinc-500">Adjust your search or filters to see results.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Activity and Deadlines -->
            <div class="w-full lg:w-80 flex flex-col gap-6 shrink-0">
                <!-- Upcoming Deadlines -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-sm font-extrabold text-[#1b355a] flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-orange-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
                        </svg>
                        Upcoming Deadlines
                    </h3>
                    <div class="flex flex-col gap-3">
                        <template x-for="dl in activeDocumentsData?.deadlines" :key="dl.id">
                            <div class="flex flex-col gap-2 p-3 rounded-lg border border-slate-100 bg-slate-50/50">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <h4 class="text-xs font-bold text-[#1b355a] leading-snug" x-text="dl.title"></h4>
                                        <p class="text-[10px] text-zinc-500 mt-0.5" x-text="dl.subtitle"></p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold border"
                                        :class="dl.type === 'danger' ? 'bg-rose-50 text-rose-700 border-rose-100' : (dl.type === 'warning' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-100 text-zinc-700 border-slate-200')"
                                        x-text="dl.days + ' days left'">
                                    </span>
                                </div>
                                <div class="text-[11px] font-medium text-zinc-500 flex items-center gap-1.5 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    <span x-text="dl.date"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-sm font-extrabold text-[#1b355a]">Recent Activity</h3>
                    <div class="flex flex-col gap-4 relative">
                        <div class="absolute left-[15px] top-4 bottom-4 w-px bg-slate-200 z-0"></div>
                        <template x-for="act in activeDocumentsData?.activity" :key="act.id">
                            <div class="flex items-start gap-3 relative z-10">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-[#1b355a] font-bold text-xs flex items-center justify-center shrink-0 border-2 border-white shadow-xs" x-text="act.initials"></div>
                                <div class="pt-0.5">
                                    <p class="text-xs text-zinc-600 leading-snug">
                                        <span class="font-bold text-[#1b355a]" x-text="act.user"></span>
                                        <span x-text="act.action"></span>
                                    </p>
                                    <span class="text-[10px] font-medium text-zinc-400 mt-0.5 block" x-text="act.time"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- LEVEL 3: DETAILED PROGRAM VIEW -->
        <div x-show="selectedProgram !== null" x-transition class="flex flex-col gap-6 w-full py-2">
            <!-- Program Header -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-3xs flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-blue-50/50 rounded-bl-full -mr-10 -mt-10 z-0"></div>
                <div class="relative z-10 flex flex-col gap-1">
                    <h2 class="text-2xl font-black text-[#1b355a]" x-text="selectedProgram?.name"></h2>
                    <div class="flex items-center gap-3 mt-0.5">
                        <p class="text-sm font-medium text-zinc-500 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
                            <span x-text="selectedProgram?.office"></span>
                        </p>
                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-[#1b355a]/10 text-[#1b355a] uppercase tracking-wider border border-[#1b355a]/20">
                            AACCUP Instrument
                        </span>
                    </div>
                </div>
                <div class="relative z-10 flex gap-4">
                    <div class="flex flex-col items-center justify-center bg-slate-50 px-4 py-2 rounded-lg border border-slate-200/50">
                        <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Overall Readiness</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="text-xl font-black text-[#1b355a]" x-text="getDetails(selectedProgram, accredLevel)?.overallScore + '%'"></span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center bg-rose-50 px-4 py-2 rounded-lg border border-rose-100/50">
                        <span class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Pending Docs</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="text-xl font-black text-rose-600" x-text="getDetails(selectedProgram, accredLevel)?.pendingDocs"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Grid (Areas or Parameters) -->
            <div class="flex flex-col gap-2 mt-2">
                <h3 class="text-sm font-extrabold text-[#1b355a] uppercase tracking-wider" x-text="getDetails(selectedProgram, accredLevel)?.subItemsTitle"></h3>
                <div class="flex flex-col gap-4">
                    <template x-for="itemDetail in getDetails(selectedProgram, accredLevel)?.subItems" :key="itemDetail.id">
                        <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs flex flex-col transition-all duration-300 group relative overflow-hidden"
                             :class="expandedItem === itemDetail.id ? 'border-blue-300 ring-2 ring-blue-100/50' : 'hover:border-blue-200 cursor-pointer'">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-50/0 to-blue-50/50 opacity-0 transition-opacity pointer-events-none"
                                 :class="expandedItem === itemDetail.id ? 'opacity-100' : 'group-hover:opacity-100'"></div>
                            
                            <!-- Header / Summary (Clickable) -->
                            <div class="p-5 flex flex-col gap-3 z-10 relative cursor-pointer" @click="expandedItem = expandedItem === itemDetail.id ? null : itemDetail.id">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 pr-4">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-zinc-400 transition-transform duration-300 shrink-0"
                                                 :class="expandedItem === itemDetail.id ? 'rotate-90 text-blue-600' : ''">
                                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                            </svg>
                                            <h4 class="text-sm font-bold text-[#1b355a] group-hover:text-blue-700 transition-colors line-clamp-1" x-text="itemDetail.name"></h4>
                                        </div>
                                        <p class="text-xs text-zinc-500 mt-1 flex items-center gap-1.5 pl-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-zinc-400"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                                            <span x-text="itemDetail.leader"></span>
                                        </p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider border shrink-0"
                                        :class="getStatusBadgeClass(itemDetail.status)"
                                        x-text="getStatusLabel(itemDetail.status)">
                                    </span>
                                </div>
                                <div class="relative mt-1 pl-6">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[10px] font-bold text-zinc-400 uppercase">Progress</span>
                                        <span class="text-xs font-bold text-[#1b355a]" x-text="itemDetail.progress + '%'"></span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500" 
                                            :class="itemDetail.progress === 100 ? 'bg-emerald-500' : (itemDetail.progress > 50 ? 'bg-[#1b355a]' : 'bg-amber-500')"
                                            :style="'width: ' + itemDetail.progress + '%'"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Expandable Checklist Details -->
                            <div x-show="expandedItem === itemDetail.id" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-[-10px]"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="border-t border-slate-100 bg-slate-50 p-5 flex flex-col gap-3 relative z-10" style="display: none;">
                                <h5 class="text-xs font-bold text-[#1b355a] uppercase tracking-wider mb-1" x-text="accredLevel === 'program' ? 'Parameters Compliance' : 'Statements Compliance'"></h5>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                <template x-for="check in itemDetail.checklist" :key="check.id">
                                    <div class="flex flex-col gap-3 p-3 rounded-lg border bg-white shadow-2xs transition-colors"
                                         :class="check.complied ? 'border-emerald-100' : 'border-rose-100'">
                                        <div class="flex items-start gap-3">
                                            <!-- Icon -->
                                            <div class="shrink-0 mt-0.5">
                                                <template x-if="check.complied">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                                    </svg>
                                                </template>
                                                <template x-if="!check.complied">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-rose-400">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                                    </svg>
                                                </template>
                                            </div>
                                            <!-- Content -->
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold" :class="check.complied ? 'text-zinc-700' : 'text-rose-700'" x-text="check.title"></p>
                                                <div class="mt-1 flex items-center gap-2">
                                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full"
                                                          :class="check.complied ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'"
                                                          x-text="check.complied ? 'Complied' : 'Missing'"></span>
                                                    <span class="text-xs text-zinc-500 font-medium" x-show="check.documents?.length > 0" x-text="check.documents?.length + ' file(s) attached'"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Documents List -->
                                        <div class="pl-8 flex flex-col gap-2" x-show="check.documents?.length > 0">
                                            <template x-for="doc in check.documents" :key="doc.id">
                                                <div class="flex items-center gap-3 p-2 rounded bg-slate-50 border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 cursor-pointer transition-colors group">
                                                    <div class="shrink-0 p-1.5 bg-white rounded shadow-sm border border-slate-200">
                                                        <template x-if="doc.type === 'PDF'">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-red-500"><path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" /><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" /></svg>
                                                        </template>
                                                        <template x-if="doc.type !== 'PDF'">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-blue-500"><path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" /><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" /></svg>
                                                        </template>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-bold text-[#1b355a] truncate group-hover:text-blue-700" x-text="doc.name"></p>
                                                        <p class="text-[10px] text-zinc-500 mt-0.5 truncate" x-text="doc.uploader + ' • ' + doc.date + ' • ' + doc.size"></p>
                                                    </div>
                                                </div>
                                            </template>
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
</div>
