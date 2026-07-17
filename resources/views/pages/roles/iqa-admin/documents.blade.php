<x-layouts::app :title="__('General Documents')">
    <div x-data="documentWorkspace()" class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen relative overflow-hidden">
        <!-- Top Header & Tabs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <!-- Common Documents Tab Header -->
                <div x-show="activeTab === 'common'">
                    <template x-if="selectedCategory === null">
                        <div>
                            <h1 class="text-2xl font-bold text-[#1b355a]">Common Documents</h1>
                            <p class="text-xs text-zinc-500 mt-1">Manage your common documents</p>
                        </div>
                    </template>
                    <template x-if="selectedCategory !== null">
                        <div class="flex items-center gap-3">
                            <button @click="selectCategory(null)" class="flex items-center justify-center p-2 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-[#1b355a] transition shadow-3xs cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                </svg>
                            </button>
                            <div>
                                <div class="flex items-center gap-1.5 text-xs text-zinc-400 font-medium">
                                    <span class="hover:underline cursor-pointer" @click="selectCategory(null)">Documents</span>
                                    <span>&gt;</span>
                                    <span class="text-zinc-600 font-semibold" x-text="selectedCategory"></span>
                                </div>
                                <h1 class="text-xl font-bold text-[#1b355a] mt-0.5" x-text="selectedCategory"></h1>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Accreditation Tab Header -->
                <div x-show="activeTab === 'accreditation'">
                    <h1 class="text-2xl font-bold text-[#1b355a]">Accreditation Documents</h1>
                    <p class="text-xs text-zinc-500 mt-1">Manage your self-survey accreditation compliance files</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 self-end md:self-auto">
                <!-- Toggle Tab Switcher -->
                <div class="bg-slate-100 border border-slate-200/60 rounded-lg p-0.5 flex gap-1 text-[11px]">
                    <button type="button" 
                            class="px-4 py-1.5 rounded-md transition cursor-pointer"
                            :class="activeTab === 'common' ? 'font-bold bg-white border border-slate-200/50 shadow-2xs text-[#1b355a]' : 'font-medium text-zinc-500 hover:text-[#1b355a]'"
                            @click="activeTab = 'common'">
                        Common Documents
                    </button>
                    <button type="button" 
                            class="px-4 py-1.5 rounded-md transition cursor-pointer"
                            :class="activeTab === 'accreditation' ? 'font-bold bg-white border border-slate-200/50 shadow-2xs text-[#1b355a]' : 'font-medium text-zinc-500 hover:text-[#1b355a]'"
                            @click="activeTab = 'accreditation'">
                        Accreditation
                    </button>
                </div>

                <!-- Bell Notification Button -->
                <button type="button" class="relative p-2 rounded-lg bg-white border border-slate-200 text-zinc-500 hover:text-[#1b355a] transition shadow-3xs cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a9.04 9.04 0 01-2.037.228 9 9 0 01-2.037-.228m4.074 0A8.987 8.987 0 0113.5 18a8.987 8.987 0 01-2.25-.918m4.074 0c.385-.233.644-.64.644-1.12 0-1.242.781-2.28 1.975-2.679.487-.163.825-.63.825-1.144V9a3 3 0 00-3-3m-6 3v1.14c0 .513-.338.98-.824 1.144A4.502 4.502 0 004.5 13.5c0 .48.259.887.644 1.12m0 0a9.03 9.03 0 012.037-.228m-2.037.228A9.01 9.01 0 019 15.75c0 .034-.002.066-.007.098m0 0A3.375 3.375 0 019 18" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-orange-500 rounded-full border border-white"></span>
                </button>
            </div>
        </div>

        <!-- ================= TAB: COMMON DOCUMENTS ================= -->
        <div x-show="activeTab === 'common'" class="flex flex-col gap-6">
            <!-- ================= STATE 1: CATEGORY SHOWCASE ================= -->
            <div x-show="selectedCategory === null" x-transition class="flex flex-col gap-6">
                <!-- Search bar for categories -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
                    <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                        <div class="relative w-full max-w-[480px]">
                            <input 
                                type="text" 
                                x-model="searchQuery"
                                placeholder="Search document categories..." 
                                class="w-full text-xs border border-slate-200 rounded-lg pl-8 pr-3 py-2.5 focus:outline-none focus:border-slate-300 bg-slate-50/50"
                            />
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-zinc-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Upload Button -->
                        <button type="button" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-xs font-bold px-4 py-2.5 rounded-lg flex items-center gap-1.5 shrink-0 shadow-2xs transition cursor-pointer" @click="alert('Upload workspace triggers here!')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Upload Document
                        </button>
                    </div>
                </div>

                <!-- Showcase grid: strictly max 3 columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <template x-for="cat in filteredCategories" :key="cat.id">
                        <div @click="selectCategory(cat.name)" class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md hover:border-slate-300 cursor-pointer group font-sans">
                            <div>
                                <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4 transition-colors group-hover:bg-[#F27224]/10 group-hover:text-[#F27224]" x-html="cat.icon">
                                </div>
                                <h3 class="font-bold text-sm text-[#1b355a] leading-tight" x-text="cat.name"></h3>
                                <p class="text-[11px] text-zinc-500 mt-1 leading-normal" x-text="cat.description"></p>
                            </div>
                            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-semibold text-zinc-400" x-text="cat.docCount + ' documents'"></span>
                                <span class="text-xs font-bold text-[#F27224] transition-all group-hover:translate-x-1 flex items-center gap-1 select-none">
                                    <span>View documents</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- ================= STATE 2: CATEGORY DETAIL WORKSPACE ================= -->
            <div x-show="selectedCategory !== null" x-transition class="flex flex-col gap-4">
                <!-- Filter Controls Container Card -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs flex flex-col gap-4">
                    <!-- Top Row: Search and Action -->
                    <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                        <!-- Search Input -->
                        <div class="relative w-full sm:max-w-md">
                            <input 
                                type="text" 
                                x-model="searchQuery"
                                placeholder="Search documents in this category..." 
                                class="w-full text-xs border border-slate-200 rounded-lg pl-8 pr-3 py-2.5 focus:outline-none focus:border-slate-300 bg-slate-50/50"
                            />
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-zinc-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <button type="button" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-xs font-bold px-4 py-2.5 rounded-lg flex items-center gap-1.5 shrink-0 shadow-2xs transition cursor-pointer" @click="alert('Upload workspace triggers here!')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Upload Document
                        </button>
                    </div>

                    <!-- Bottom Row: Select Filters -->
                    <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-slate-100/60">
                        <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Filter by:</span>
                        
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Doc Type Select -->
                            <div class="relative">
                                <select x-model="filterType" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                                    <option value="all">Doc Type: All</option>
                                    <option value="PDF">PDF</option>
                                    <option value="Word">Word</option>
                                    <option value="Excel">Excel</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>

                            <!-- College/Office Select -->
                            <div class="relative">
                                <select x-model="filterOffice" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                                    <option value="all">Office: All</option>
                                    <option value="IQA Central Office">IQA Central Office</option>
                                    <option value="Office of the President">Office of the President</option>
                                    <option value="College of Science">College of Science</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>

                            <!-- Date Select -->
                            <div class="relative">
                                <select x-model="filterDate" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                                    <option value="all">Date: All</option>
                                    <option value="2026">2026</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>

                            <!-- Status Select -->
                            <div class="relative">
                                <select x-model="filterStatus" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                                    <option value="all">Status: All</option>
                                    <option value="Verified">Verified</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Flagged">Flagged</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listing details table wrapper -->
                <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse font-sans text-xs">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100 text-zinc-400 font-bold uppercase tracking-wider select-none">
                                    <th class="py-3 px-6">Document Title</th>
                                    <th class="py-3 px-6">Uploader</th>
                                    <th class="py-3 px-6">Lead Office</th>
                                    <th class="py-3 px-6 text-center">Type</th>
                                    <th class="py-3 px-6">Upload Date</th>
                                    <th class="py-3 px-6">Status</th>
                                    <th class="py-3 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                <template x-for="doc in filteredDocuments" :key="doc.name">
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <!-- Title -->
                                        <td class="py-3.5 px-6 font-bold text-[#1b355a]">
                                            <div class="max-w-[280px] truncate" x-text="doc.name"></div>
                                        </td>
                                        <!-- Uploader -->
                                        <td class="py-3.5 px-6 text-zinc-500" x-text="doc.uploader"></td>
                                        <!-- Lead Office -->
                                        <td class="py-3.5 px-6 text-zinc-500" x-text="doc.office"></td>
                                        <!-- Type -->
                                        <td class="py-3.5 px-6 text-center shrink-0">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-600 uppercase tracking-wide" x-text="doc.type"></span>
                                        </td>
                                        <!-- Upload Date -->
                                        <td class="py-3.5 px-6 text-zinc-400 font-semibold" x-text="doc.date"></td>
                                        <!-- Status Badge -->
                                        <td class="py-3.5 px-6">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                                :class="{
                                                    'bg-emerald-50 text-emerald-700': doc.status === 'Verified',
                                                    'bg-amber-50 text-amber-700': doc.status === 'Pending',
                                                    'bg-rose-50 text-rose-700': doc.status === 'Flagged'
                                                }">
                                                <span class="w-1.5 h-1.5 rounded-full"
                                                    :class="{
                                                        'bg-emerald-500': doc.status === 'Verified',
                                                        'bg-amber-500': doc.status === 'Pending',
                                                        'bg-rose-500': doc.status === 'Flagged'
                                                    }"></span>
                                                <span x-text="doc.status"></span>
                                            </span>
                                        </td>
                                        <!-- View action -->
                                        <td class="py-3.5 px-6 text-right">
                                            <button @click="openDoc(doc)" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition cursor-pointer select-none">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer statistics summary -->
                    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center text-xs text-zinc-400 font-semibold select-none">
                        <span x-text="'Showing ' + filteredDocuments.length + ' documents'"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB: ACCREDITATION ================= -->
        <div x-show="activeTab === 'accreditation'" x-transition class="flex flex-col gap-6">
            
            <!-- Breadcrumbs Nav for Accreditation -->
            <div>
                <!-- Level 1 Breadcrumbs -->
                <template x-if="accredLevel === null">
                    <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3 shadow-3xs flex items-center gap-1.5 text-xs text-zinc-400 font-medium">
                        <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCategory = null">Documents</span>
                        <span>&gt;</span>
                        <span class="text-zinc-650 font-semibold">Accreditation</span>
                    </div>
                </template>

                <!-- Level 2 Breadcrumbs -->
                <template x-if="accredLevel !== null && accredCategory === null">
                    <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3 shadow-3xs flex items-center gap-1.5 text-xs text-zinc-400 font-medium">
                        <button @click="accredLevel = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                        </button>
                        <span class="hover:underline cursor-pointer" @click="accredLevel = null">Documents</span>
                        <span>&gt;</span>
                        <span class="text-zinc-650 font-semibold" x-text="accredLevel === 'program' ? 'Program Accreditation' : 'Institutional Accreditation'"></span>
                    </div>
                </template>

                <!-- Level 3 Breadcrumbs -->
                <template x-if="accredLevel !== null && accredCategory !== null">
                    <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3 shadow-3xs flex items-center gap-1.5 text-xs text-zinc-400 font-medium">
                        <button @click="accredCategory = null" class="mr-2 flex items-center justify-center p-1.5 rounded-md hover:bg-slate-50 border border-slate-200/50 text-[#1b355a] cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                        </button>
                        <span class="hover:underline cursor-pointer" @click="accredLevel = null; accredCategory = null">Documents</span>
                        <span>&gt;</span>
                        <span class="hover:underline cursor-pointer" @click="accredCategory = null" x-text="accredLevel === 'program' ? 'Program Accreditation' : 'Institutional Accreditation'"></span>
                        <span>&gt;</span>
                        <span class="text-zinc-650 font-semibold" x-text="accredCategory"></span>
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
                        <h3 class="text-base font-bold text-[#1b355a]">Program Accreditation</h3>
                        <p class="text-xs text-zinc-500 mt-2 leading-relaxed max-w-sm">
                            Evaluate specific degree programs (e.g. BSCS, BSIT, BSEE) for academic quality, faculty portfolio, and student facilities.
                        </p>
                    </div>
                    <button type="button" @click="accredLevel = 'program'; accredCategory = null" class="w-full mt-2 bg-[#1b355a] hover:bg-[#112239] text-white py-2.5 rounded-lg font-bold text-xs shadow-2xs transition cursor-pointer">
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
                        <h3 class="text-base font-bold text-[#1b355a]">Institutional Accreditation</h3>
                        <p class="text-xs text-zinc-500 mt-2 leading-relaxed max-w-sm">
                            Evaluate university-wide administration, leadership, fiscal soundness, and governance structure (Area I to VIII).
                        </p>
                    </div>
                    <button type="button" @click="accredLevel = 'institutional'; accredCategory = null" class="w-full mt-2 bg-[#f27224] hover:bg-[#d65f1a] text-white py-2.5 rounded-lg font-bold text-xs shadow-2xs transition cursor-pointer">
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
                            <h3 class="text-sm font-bold text-[#1b355a]">Self-Survey Documents</h3>
                            <p class="text-xs text-zinc-500 mt-2 leading-relaxed">
                                Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic summaries.
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="accredCategory = 'Self-Survey Documents'" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-lg font-bold text-xs shadow-3xs transition cursor-pointer">
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
                            <h3 class="text-sm font-bold text-[#1b355a]">Compliance Reports</h3>
                            <p class="text-xs text-zinc-500 mt-2 leading-relaxed">
                                Official compliance logs, AACCUP evaluations, corrective action reports, and certificates of accreditation.
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="accredCategory = 'Compliance Reports'" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-2.5 rounded-lg font-bold text-xs shadow-3xs transition cursor-pointer">
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
                            <h3 class="text-sm font-bold text-[#1b355a]">Supporting Documents</h3>
                            <p class="text-xs text-zinc-500 mt-2 leading-relaxed">
                                Checklist criteria link inputs for inputs (Systems), implementation details, outcomes, and best practices.
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="accredCategory = 'Supporting Documents'" class="w-full bg-[#1b355a] hover:bg-[#112239] text-white py-2.5 rounded-lg font-bold text-xs shadow-3xs transition cursor-pointer">
                        Open Supporting Docs
                    </button>
                </div>
            </div>

            <!-- LEVEL 3A: SUPPORTING DOCUMENTS WORKSPACE -->
            <div x-show="accredLevel !== null && accredCategory === 'Supporting Documents'" x-transition class="flex flex-col gap-4">
                <!-- Area Selector Horizontal Tablist -->
                <div class="flex border border-slate-200/60 bg-white rounded-xl p-1 shadow-3xs overflow-x-auto gap-1">
                    <template x-for="area in activeAccredData?.areas" :key="area.id">
                        <button type="button" 
                                class="px-4 py-2 text-xs font-bold rounded-lg transition whitespace-nowrap cursor-pointer"
                                :class="accredActiveAreaId === area.id ? 'bg-[#1b355a] text-white shadow-sm' : 'text-zinc-500 hover:text-[#1b355a] hover:bg-slate-50'"
                                @click="selectArea(area.id)">
                            <span x-text="area.code + ': ' + area.title"></span>
                        </button>
                    </template>
                </div>
                
                <!-- Main workspace split panel -->
                <div class="flex flex-col md:flex-row gap-4 items-start w-full">
                    <!-- Left Pane: Parameters Available -->
                    <div class="w-full md:w-64 shrink-0 flex flex-col gap-2 bg-white border border-slate-200/60 rounded-xl p-3 shadow-3xs">
                        <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider px-2">Parameters</span>
                        <div class="flex flex-col gap-1">
                            <template x-for="param in activeArea?.parameters" :key="param.id">
                                <button type="button" 
                                        class="w-full text-left px-3 py-2.5 rounded-lg text-xs font-semibold flex flex-col gap-1 transition cursor-pointer"
                                        :class="accredActiveParamId === param.id ? 'bg-slate-50 border border-slate-200/50 text-[#1b355a]' : 'text-zinc-500 hover:bg-slate-50 hover:text-[#1b355a] border border-transparent'"
                                        @click="accredActiveParamId = param.id; accredActiveSection = 'systems'">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-[#1b355a]" x-text="param.code"></span>
                                        <span class="text-[10px] font-semibold text-zinc-400" x-text="param.progress + '%'"></span>
                                    </div>
                                    <span class="truncate w-full text-[11px] text-zinc-500" x-text="param.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Right Pane: Parameters checklist workspace -->
                    <div class="flex-1 bg-white border border-slate-200/60 rounded-xl p-5 shadow-3xs flex flex-col gap-5 w-full">
                        <!-- Header Info -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-[10px] font-bold text-[#f27224] uppercase tracking-wider" x-text="activeParam?.code"></span>
                                <h2 class="text-sm font-bold text-[#1b355a]" x-text="activeParam?.title"></h2>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <div class="text-right">
                                    <div class="text-xs font-bold text-[#1b355a]" x-text="activeParam?.progress + '%'"></div>
                                    <div class="text-[10px] text-zinc-400 uppercase font-semibold">Progress</div>
                                </div>
                                <div class="w-12 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#f27224] rounded-full transition-all duration-300" :style="'width: ' + activeParam?.progress + '%'"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Navigation Tabs -->
                        <div class="bg-slate-50 border border-slate-100 rounded-lg p-0.5 flex flex-wrap gap-1 text-[11px] font-semibold">
                            <button type="button" 
                                    class="px-3 py-2 rounded-md transition cursor-pointer"
                                    :class="accredActiveSection === 'systems' ? 'bg-white text-[#1b355a] shadow-3xs' : 'text-zinc-500 hover:text-[#1b355a]'"
                                    @click="accredActiveSection = 'systems'">
                                Systems - Inputs & Processes
                            </button>
                            <button type="button" 
                                    class="px-3 py-2 rounded-md transition cursor-pointer"
                                    :class="accredActiveSection === 'implementation' ? 'bg-white text-[#1b355a] shadow-3xs' : 'text-zinc-500 hover:text-[#1b355a]'"
                                    @click="accredActiveSection = 'implementation'">
                                Implementation
                            </button>
                            <button type="button" 
                                    class="px-3 py-2 rounded-md transition cursor-pointer"
                                    :class="accredActiveSection === 'outcomes' ? 'bg-white text-[#1b355a] shadow-3xs' : 'text-zinc-500 hover:text-[#1b355a]'"
                                    @click="accredActiveSection = 'outcomes'">
                                Outcomes
                            </button>
                            <button type="button" 
                                    class="px-3 py-2 rounded-md transition cursor-pointer"
                                    :class="accredActiveSection === 'bestpractices' ? 'bg-white text-[#1b355a] shadow-3xs' : 'text-zinc-500 hover:text-[#1b355a]'"
                                    @click="accredActiveSection = 'bestpractices'">
                                Best Practices
                            </button>
                        </div>

                        <!-- Checklist list area -->
                        <div class="flex flex-col gap-3">
                            <template x-for="item in activeChecklistItems" :key="item.id">
                                <div class="border border-slate-200/60 rounded-xl p-4 flex flex-col gap-3 bg-slate-50/20">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-2.5">
                                            <span class="text-xs font-bold text-zinc-400 bg-slate-100 px-2 py-0.5 rounded" x-text="item.id"></span>
                                            <p class="text-xs text-[#1b355a] font-semibold leading-relaxed" x-text="item.statement"></p>
                                        </div>
                                    </div>

                                    <!-- If Best Practices -->
                                    <template x-if="accredActiveSection === 'bestpractices'">
                                        <p class="text-xs text-zinc-500 italic pl-10" x-text="item.description"></p>
                                    </template>

                                    <!-- If Document section -->
                                    <template x-if="accredActiveSection !== 'bestpractices'">
                                        <div class="pl-10">
                                            <!-- Linked documents list -->
                                            <template x-if="item.documents && item.documents.length > 0">
                                                <div class="flex flex-col gap-2">
                                                    <template x-for="doc in item.documents" :key="doc.name">
                                                        <div class="flex items-center justify-between p-2.5 bg-white border border-slate-150 rounded-lg text-xs gap-3">
                                                            <div class="flex items-center gap-2 min-w-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-[#1b355a] shrink-0">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                                </svg>
                                                                <span class="font-bold text-[#1b355a] truncate" x-text="doc.name"></span>
                                                            </div>
                                                            <div class="flex items-center gap-3 shrink-0">
                                                                <span class="text-[10px] text-zinc-400" x-text="doc.size"></span>
                                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                                                      :class="doc.status === 'Verified' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'"
                                                                      x-text="doc.status"></span>
                                                                <button type="button" class="text-xs font-bold text-[#f27224] hover:underline cursor-pointer" @click="openDoc(doc)">
                                                                    View Details
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            
                                            <!-- No documents linked -> Upload button -->
                                            <template x-if="!item.documents || item.documents.length === 0">
                                                <button type="button" class="border border-dashed border-slate-300 hover:border-slate-400 bg-slate-50/50 hover:bg-slate-50 text-[#1b355a] text-xs font-bold px-4 py-2.5 rounded-lg flex items-center justify-center gap-2 cursor-pointer transition w-full" @click="alert('Upload & link files for: ' + item.statement)">
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
                <h2 class="text-base font-extrabold text-zinc-900">Self Survey Documents Workspace</h2>
                <p class="text-xs text-zinc-505 text-zinc-500 max-w-md leading-relaxed">
                    This workspace holds numerical ratings, self-audit scoresheets, and diagnostic compliance evaluations. Click the breadcrumbs to return to your folders.
                </p>
                <button type="button" @click="accredCategory = null" class="mt-2 px-6 py-2 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold rounded-lg transition text-xs cursor-pointer shadow-3xs">
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
                <h2 class="text-base font-extrabold text-zinc-900">Compliance & Accreditation Reports</h2>
                <p class="text-xs text-zinc-500 max-w-md leading-relaxed">
                    Access and manage external evaluation audits, corrective plans, and AACCUP certificates. Click the breadcrumbs to return to your folders.
                </p>
                <button type="button" @click="accredCategory = null" class="mt-2 px-6 py-2 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold rounded-lg transition text-xs cursor-pointer shadow-3xs">
                    Back to Folders
                </button>
            </div>
        </div>

        <!-- ================= SIDE DRAWERS & MODALS ================= -->
        <!-- Background Overlay -->
        <div x-show="showDrawer" 
             @click="closeDrawer()" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-[2px] z-[200]">
        </div>

        <!-- Document Preview Drawer Panel -->
        <aside x-show="showDrawer"
               x-transition:enter="transition transform ease-out duration-300"
               x-transition:enter-start="translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition transform ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="translate-x-full"
               class="fixed right-0 top-0 h-screen w-full max-w-[420px] bg-white shadow-2xl z-[250] flex flex-col border-l border-slate-100">
            
            <!-- Drawer Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-4">
                    <h3 class="font-bold text-sm text-[#1b355a] leading-snug truncate" x-text="selectedDoc.name"></h3>
                    <div class="flex items-center gap-1.5 mt-1 text-[10px] text-zinc-400 font-semibold uppercase tracking-wide">
                        <span x-text="'Size: ' + selectedDoc.size"></span>
                        <span>&bull;</span>
                        <span x-text="'Uploaded: ' + selectedDoc.date"></span>
                    </div>
                </div>
                <button @click="closeDrawer()" class="p-1.5 rounded-lg hover:bg-slate-100 text-zinc-400 hover:text-zinc-600 transition cursor-pointer shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Drawer Body -->
            <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-5">
                <!-- Metadata & Open Document Card -->
                <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                    <div class="text-xs text-zinc-500 flex flex-col gap-1">
                        <div><span class="font-bold text-[#1b355a]">Uploader:</span> <span x-text="selectedDoc.uploader"></span></div>
                        <div><span class="font-bold text-[#1b355a]">Lead Office:</span> <span x-text="selectedDoc.office"></span></div>
                    </div>
                    <!-- Open Document Button -->
                    <button type="button" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-xs font-bold px-3.5 py-2.5 rounded-lg flex items-center justify-center gap-1.5 transition shadow-3xs cursor-pointer" @click="alert('Opening document: ' + selectedDoc.name)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Open Document
                    </button>
                </div>

                <!-- Document Evidentiary Text Preview (OCR) -->
                <div class="flex-1 flex flex-col min-h-[300px]">
                    <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider mb-2">📄 Original Document Preview</div>
                    <div class="flex-1 bg-[#fafbfc] border border-slate-100 rounded-xl p-4 font-mono text-[10.5px] leading-relaxed text-zinc-600 overflow-y-auto select-all whitespace-pre-wrap" x-text="selectedDoc.ocrText">
                    </div>
                </div>

                <!-- Validation Action Buttons -->
                <div class="flex flex-col gap-2 pt-4 border-t border-slate-100">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Compliance Audit Review</span>
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="approveDoc()" class="py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition shadow-sm cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            Approve & Verify
                        </button>
                        <button @click="flagDoc()" class="py-2.5 px-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition border border-rose-100 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            Flag for Revision
                        </button>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Client-side Interactive Workspaces using Alpine.js -->
    <script>
        function documentWorkspace() {
            return {
                activeTab: 'common', // 'common' or 'accreditation'
                accredLevel: null, // 'program' or 'institutional'
                accredCategory: null, // 'Self-Survey Documents', 'Compliance Reports', 'Supporting Documents'
                accredActiveAreaId: 'area_i1',
                accredActiveParamId: 'param_i1_a',
                accredActiveSection: 'systems',
                
                // Accreditation mock data
                accredData: {
                    program: {
                        title: 'Program Accreditation',
                        areas: [
                            {
                                id: 'area_p1',
                                code: 'Area I',
                                title: 'Vision, Mission, Goals, and Objectives',
                                progress: 100,
                                parameters: [
                                    {
                                        id: 'param_p1_a',
                                        code: 'Parameter A',
                                        title: 'Statement of VMGO',
                                        progress: 100,
                                        sections: {
                                            systems: [
                                                {
                                                    id: 'S.1',
                                                    statement: 'The institution has a clearly defined Vision, Mission, Goals, and Objectives.',
                                                    documents: [
                                                        { name: 'VMGO Approved Resolution s. 2024', type: 'PDF', size: '1.2 MB', date: '2024-03-15', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'BOARD RESOLUTION NO. 045, SERIES OF 2024\n\nSUBJECT: APPROVAL OF THE UNIVERSITY VISION, MISSION, GOALS AND OBJECTIVES.' }
                                                    ]
                                                }
                                            ],
                                            implementation: [],
                                            outcomes: [],
                                            bestpractices: []
                                        }
                                    }
                                ]
                            },
                            {
                                id: 'area_p2',
                                code: 'Area II',
                                title: 'Faculty',
                                progress: 64,
                                parameters: [
                                    {
                                        id: 'param_p2_a',
                                        code: 'Parameter A',
                                        title: 'Academic Qualifications',
                                        progress: 64,
                                        sections: {
                                            systems: [
                                                {
                                                    id: 'S.1',
                                                    statement: 'Faculty members possess the appropriate educational background and degrees for their assignments.',
                                                    documents: [
                                                        { name: 'Faculty Roster & Qualifications Database', type: 'Excel', size: '2.1 MB', date: '2025-10-15', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'FACULTY ROSTER & ACADEMIC CREDENTIALS\n\nTotal Faculty: 45. Doctorates: 15. Masters: 28. Baccalaureate: 2.' }
                                                    ]
                                                }
                                            ],
                                            implementation: [],
                                            outcomes: [],
                                            bestpractices: []
                                        }
                                    }
                                ]
                            },
                            {
                                id: 'area_p3',
                                code: 'Area III',
                                title: 'Curriculum and Instruction',
                                progress: 88,
                                parameters: [
                                    {
                                        id: 'param_p3_a',
                                        code: 'Parameter A',
                                        title: 'Curriculum Development',
                                        progress: 88,
                                        sections: {
                                            systems: [
                                                {
                                                    id: 'S.1',
                                                    statement: 'The curriculum is regularly reviewed and updated in consultation with stakeholders.',
                                                    documents: [
                                                        { name: 'Minutes of Curriculum Review Committee s. 2025', type: 'PDF', size: '1.6 MB', date: '2025-08-12', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'MINUTES OF THE JOINT CURRICULUM REVIEW ASSEMBLY\n\nDiscussed alignment of BSCS and BSIT program outcomes with AACCUP and CHED standards.' }
                                                    ]
                                                }
                                            ],
                                            implementation: [],
                                            outcomes: [],
                                            bestpractices: []
                                        }
                                    }
                                ]
                            }
                        ]
                    },
                    institutional: {
                        title: 'Institutional Accreditation',
                        areas: [
                            {
                                id: 'area_i1',
                                code: 'Area I',
                                title: 'Governance and Management',
                                progress: 85,
                                parameters: [
                                    {
                                        id: 'param_i1_a',
                                        code: 'Parameter A',
                                        title: 'Governance',
                                        progress: 85,
                                        sections: {
                                            systems: [
                                                {
                                                    id: 'S.1',
                                                    statement: 'The governing board operates under established charter and functions efficiently.',
                                                    documents: [
                                                        { name: 'Board of Regents Charter & Bylaws', type: 'PDF', size: '2.5 MB', date: '2024-02-10', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'CHARTER OF THE BOARD OF REGENTS\n\nPowers, duties, and responsibilities of Board members and executive committees.' }
                                                    ]
                                                },
                                                {
                                                    id: 'S.2',
                                                    statement: 'The organizational chart is clearly defined, approved, and disseminated to stakeholders.',
                                                    documents: [
                                                        { name: 'BU Approved Organizational Chart 2024', type: 'PDF', size: '1.1 MB', date: '2024-05-18', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'REVISED BICOL UNIVERSITY ORGANIZATIONAL STRUCTURE\n\nApproved per Board Resolution No. 120, series of 2024.' }
                                                    ]
                                                }
                                            ],
                                            implementation: [
                                                {
                                                    id: 'I.1',
                                                    statement: 'Decisions are documented via board resolutions and administrative issuances.',
                                                    documents: [
                                                        { name: 'Administrative Order No. 453, s. of 2024', type: 'PDF', size: '1.4 MB', date: '2024-05-10', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'ADMINISTRATIVE ORDER NO. 453, SERIES OF 2024\n\nSUBJECT: CONSTITUTION OF THE TECHNICAL WORKING GROUP.' }
                                                    ]
                                                }
                                            ],
                                            outcomes: [
                                                {
                                                    id: 'O.1',
                                                    statement: 'Governing board reviews and updates institutional plans regularly.',
                                                    documents: []
                                                }
                                            ],
                                            bestpractices: [
                                                {
                                                    id: 'BP.1',
                                                    statement: 'Conduct of annual strategic planning workshops with all unit heads.',
                                                    description: 'Aligns institutional budgets and plans directly with BOR targets.'
                                                }
                                            ]
                                        }
                                    },
                                    {
                                        id: 'param_i1_b',
                                        code: 'Parameter B',
                                        title: 'Probity',
                                        progress: 35,
                                        sections: {
                                            systems: [
                                                {
                                                    id: 'S.1',
                                                    statement: 'Administrative decisions are governed by established civil service rules and laws.',
                                                    documents: [
                                                        { name: 'BU Code revised 2024', type: 'PDF', size: '4.8 MB', date: '2024-11-20', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'REVISED UNIVERSITY CODE OF BICOL UNIVERSITY\n\nTitle Two: Academic Policies and Administrative Regulations.' }
                                                    ]
                                                }
                                            ],
                                            implementation: [],
                                            outcomes: [],
                                            bestpractices: []
                                        }
                                    }
                                ]
                            },
                            {
                                id: 'area_i2',
                                code: 'Area II',
                                title: 'Administration',
                                progress: 42,
                                parameters: [
                                    {
                                        id: 'param_i2_a',
                                        code: 'Parameter A',
                                        title: 'Administrative Staffing',
                                        progress: 42,
                                        sections: {
                                            systems: [
                                                {
                                                    id: 'S.1',
                                                    statement: 'Administrative offices are staffed with qualified personnel matching civil service requirements.',
                                                    documents: [
                                                        { name: 'Administrative Staff Profile 2025', type: 'PDF', size: '1.8 MB', date: '2025-09-12', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'ADMINISTRATIVE AND SUPPORT STAFF ROSTER\n\nQualifications, civil service eligibility status, and office distribution summaries.' }
                                                    ]
                                                }
                                            ],
                                            implementation: [],
                                            outcomes: [],
                                            bestpractices: []
                                        }
                                    }
                                ]
                            }
                        ]
                    }
                },

                selectedCategory: null,
                searchQuery: '',
                filterType: 'all',
                filterOffice: 'all',
                filterDate: 'all',
                filterStatus: 'all',
                showDrawer: false,
                selectedDoc: {
                    name: '',
                    size: '',
                    date: '',
                    uploader: '',
                    office: '',
                    type: '',
                    status: '',
                    ocrText: ''
                },

                get activeAccredData() {
                    if (!this.accredLevel) return null;
                    return this.accredData[this.accredLevel];
                },

                get activeArea() {
                    const data = this.activeAccredData;
                    if (!data) return null;
                    return data.areas.find(a => a.id === this.accredActiveAreaId) || data.areas[0];
                },

                get activeParam() {
                    const area = this.activeArea;
                    if (!area) return null;
                    return area.parameters.find(p => p.id === this.accredActiveParamId) || area.parameters[0];
                },

                get activeChecklistItems() {
                    const param = this.activeParam;
                    if (!param) return [];
                    return param.sections[this.accredActiveSection] || [];
                },

                selectArea(areaId) {
                    this.accredActiveAreaId = areaId;
                    const area = this.activeAccredData.areas.find(a => a.id === areaId);
                    if (area && area.parameters.length > 0) {
                        this.accredActiveParamId = area.parameters[0].id;
                    } else {
                        this.accredActiveParamId = null;
                    }
                    this.accredActiveSection = 'systems';
                },
                categories: [
                    {
                        id: 'cat_1',
                        name: 'Policies & Issuances',
                        description: 'Admin orders, office policies, notices',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>`,
                        docCount: 4
                    },
                    {
                        id: 'cat_2',
                        name: 'Instruments',
                        description: 'Per-area accreditation guides, surveys',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zM9 13h6M9 17h3" /></svg>`,
                        docCount: 3
                    },
                    {
                        id: 'cat_3',
                        name: 'Memoranda',
                        description: 'Internal circulars and memos',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>`,
                        docCount: 3
                    },
                    {
                        id: 'cat_4',
                        name: 'Correspondences',
                        description: 'Letters to/from colleges, AACCUP, admin',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>`,
                        docCount: 3
                    }
                ],
                documents: [
                    // Policies & Issuances
                    { name: "Administrative Order No. 453, s. of 2024", category: "Policies & Issuances", type: "PDF", size: "1.4 MB", date: "2024-05-10", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "ADMINISTRATIVE ORDER NO. 453, SERIES OF 2024\n\nSUBJECT: CONSTITUTION OF THE TECHNICAL WORKING GROUP (TWG) FOR THE REVIEW AND REVISION OF THE BICOL UNIVERSITY CODE OF 2016." },
                    { name: "Office Memorandum No. 153 s. of 2024", category: "Policies & Issuances", type: "PDF", size: "920 KB", date: "2024-06-15", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "OFFICE MEMORANDUM NO. 153, SERIES OF 2024\n\nTO: ALL MEMBERS OF THE CODE REVISION TWG\nSUBJECT: WRITESHOP FOR THE REVIEW AND AMENDMENTS OF THE UNIVERSITY CODE." },
                    { name: "BU Code revised 2024", category: "Policies & Issuances", type: "PDF", size: "4.8 MB", date: "2024-11-20", uploader: "Dr. Albert Santos", office: "Office of the President", status: "Verified", ocrText: "REVISED UNIVERSITY CODE OF BICOL UNIVERSITY\n\nApproved by the Board of Regents under Resolution No. 075, s. 2024." },
                    { name: "University Circular on Quality Audits", category: "Policies & Issuances", type: "PDF", size: "750 KB", date: "2025-01-10", uploader: "Dr. Albert Santos", office: "IQA Central Office", status: "Pending", ocrText: "UNIVERSITY CIRCULAR NO. 012, SERIES OF 2025\n\nSUBJECT: SCHEDULE OF INTERNAL QUALITY ASSURANCE AUDITS FOR ACADEMIC YEAR 2025-2026." },
                    
                    // Instruments
                    { name: "Self-Survey Instrument Area I", category: "Instruments", type: "Word", size: "680 KB", date: "2026-03-01", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "AACCUP SELF-SURVEY INSTRUMENT\nAREA I: GOVERNANCE AND MANAGEMENT\n\nRating guidelines and evidence checklist for institutional compliance evaluation." },
                    { name: "Self-Survey Instrument Area II", category: "Instruments", type: "Word", size: "720 KB", date: "2026-03-05", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "AACCUP SELF-SURVEY INSTRUMENT\nAREA II: CURRICULUM AND INSTRUCTION\n\nRating guidelines and syllabus compliance mapping database." },
                    { name: "AACCUP Survey Guideline 2026", category: "Instruments", type: "PDF", size: "2.3 MB", date: "2026-02-15", uploader: "Dr. Albert Santos", office: "Office of the President", status: "Verified", ocrText: "AACCUP ACCREDITATION MANUAL 2026\n\nLatest policies, procedures, and institutional survey instrumentation rules for higher education institutions." },
                    
                    // Memoranda
                    { name: "OM No. 214, s. 2015 (Signing Authorities)", category: "Memoranda", type: "PDF", size: "620 KB", date: "2025-06-01", uploader: "Maria Reyes", office: "Office of the President", status: "Verified", ocrText: "BICOL UNIVERSITY\nOFFICE OF THE PRESIDENT\n\nOFFICE MEMORANDUM NO. 214, SERIES OF 2015\n\nTO: ALL ACADEMIC AND ADMINISTRATIVE OFFICIALS\n\nSUBJECT: GUIDELINES ON SIGNING AUTHORITIES FOR REQUISITIONS AND GENERAL OFFICE TRANSACTIONS." },
                    { name: "Notice of 1st Regular Academic Council", category: "Memoranda", type: "PDF", size: "410 KB", date: "2026-02-05", uploader: "Maria Reyes", office: "Office of the President", status: "Verified", ocrText: "OFFICE OF THE BOARD SECRETARY\n\nNOTICE OF MEETING\n\nNotice is hereby given that the 1st Regular Academic Council Assembly of Bicol University will be held on February 12, 2026." },
                    { name: "Memorandum on Internal Quality Audits s. 2026", category: "Memoranda", type: "PDF", size: "890 KB", date: "2026-04-12", uploader: "Maria Reyes", office: "IQA Central Office", status: "Pending", ocrText: "OFFICE MEMORANDUM NO. 320, SERIES OF 2026\n\nTO: ALL DEANS, DIRECTORS, AND DEPARTMENT CHAIRS\nSUBJECT: CONSTITUTION OF COLLATERAL INTERNAL AUDIT TEAMS." },

                    // Correspondences
                    { name: "Letter to AACCUP Secretariat (Self-Survey Submission)", category: "Correspondences", type: "PDF", size: "1.1 MB", date: "2026-03-12", uploader: "Dr. Albert Santos", office: "Office of the President", status: "Verified", ocrText: "BICOL UNIVERSITY\nLegazpi City\n\nMarch 12, 2026\n\nTO: THE EXECUTIVE DIRECTOR, AACCUP SECRETARIAT\n\nDear Sir/Madam:\n\nWe have the honor to submit herewith the self-survey documents and supporting files for Bicol University's Institutional Accreditation." },
                    { name: "Endorsement Letter from BU President to BOR", category: "Correspondences", type: "PDF", size: "520 KB", date: "2026-03-15", uploader: "Maria Reyes", office: "Office of the President", status: "Verified", ocrText: "OFFICE OF THE UNIVERSITY PRESIDENT\n\nMEMORANDUM FOR THE BOARD OF REGENTS\n\nSUBJECT: ENDORSEMENT OF THE PROPOSED DIGITAL TRANSFORMATION ROADMAP FOR FY 2026." },
                    { name: "Query from College of Science Dean on IQA Timeline", category: "Correspondences", type: "PDF", size: "340 KB", date: "2026-04-01", uploader: "Prof. Lilian Diaz", office: "College of Science", status: "Flagged", ocrText: "COLLEGE OF SCIENCE\nOffice of the Dean\n\nApril 1, 2026\n\nTO: THE DIRECTOR, IQA OFFICE\n\nDear Director Santos:\n\nWe would like to request clarification on the timeline for submission of supporting folders for Parameter B." }
                ],
                
                get filteredCategories() {
                    if (this.selectedCategory !== null) return [];
                    if (!this.searchQuery) return this.categories;
                    const query = this.searchQuery.toLowerCase();
                    return this.categories.filter(c => 
                        c.name.toLowerCase().includes(query) || 
                        c.description.toLowerCase().includes(query)
                    );
                },
                
                get filteredDocuments() {
                    if (!this.selectedCategory) return [];
                    return this.documents.filter(doc => {
                        if (doc.category !== this.selectedCategory) return false;
                        
                        // Search filter
                        if (this.searchQuery) {
                            const query = this.searchQuery.toLowerCase();
                            const matchesSearch = doc.name.toLowerCase().includes(query) || 
                                                  doc.uploader.toLowerCase().includes(query) ||
                                                  doc.ocrText.toLowerCase().includes(query);
                            if (!matchesSearch) return false;
                        }
                        
                        // Type filter
                        if (this.filterType !== 'all' && doc.type !== this.filterType) return false;
                        
                        // Office filter
                        if (this.filterOffice !== 'all' && doc.office !== this.filterOffice) return false;
                        
                        // Date filter
                        if (this.filterDate !== 'all' && !doc.date.startsWith(this.filterDate)) return false;
                        
                        // Status filter
                        if (this.filterStatus !== 'all' && doc.status !== this.filterStatus) return false;
                        
                        return true;
                    });
                },

                selectCategory(catName) {
                    this.selectedCategory = catName;
                    this.searchQuery = ''; // Reset search query when switching views
                    this.filterType = 'all';
                    this.filterOffice = 'all';
                    this.filterDate = 'all';
                    this.filterStatus = 'all';
                },
                
                openDoc(doc) {
                    this.selectedDoc = doc;
                    this.showDrawer = true;
                },
                
                closeDrawer() {
                    this.showDrawer = false;
                },

                approveDoc() {
                    this.selectedDoc.status = 'Verified';
                    this.closeDrawer();
                },

                flagDoc() {
                    this.selectedDoc.status = 'Flagged';
                    this.closeDrawer();
                }
            };
        }
    </script>
</x-layouts::app>
