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
                        <select x-model="filterType" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-650 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
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
                        <select x-model="filterOffice" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-650 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
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
                        <select x-model="filterDate" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-650 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
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
                        <select x-model="filterStatus" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-650 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
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
