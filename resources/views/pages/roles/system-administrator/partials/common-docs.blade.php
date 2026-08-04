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
                        class="w-full text-sm border border-slate-200 rounded-lg pl-9 pr-3 py-3 focus:outline-none focus:border-slate-300 bg-slate-50/50"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                        </svg>
                    </div>
                </div>
                
                <!-- Upload Button -->
                <button type="button" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-sm font-bold px-5 py-3 rounded-lg flex items-center gap-1.5 shrink-0 shadow-2xs transition cursor-pointer" @click="alert('Upload workspace triggers here!')">
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
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4 transition-colors group-hover:bg-[#F27224]/10 group-hover:text-[#F27224]" x-html="cat.icon">
                        </div>
                        <h3 class="font-bold text-base text-[#1b355a] leading-tight" x-text="cat.name"></h3>
                        <p class="text-xs text-zinc-500 mt-1.5 leading-normal" x-text="cat.description"></p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-sm font-semibold text-zinc-400" x-text="cat.docCount + ' documents'"></span>
                        <span class="text-sm font-bold text-[#F27224] transition-all group-hover:translate-x-1 flex items-center gap-1 select-none">
                            <span>View documents</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- ================= STATE 2: CATEGORY FILE EXPLORER ================= -->
    <div x-show="selectedCategory !== null" x-transition class="flex flex-col gap-6 font-sans">
        <!-- Control Bar: Search & Multi-Filters -->
        <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Search Query -->
                <div class="relative md:col-span-1">
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        placeholder="Search document title, uploader..." 
                        class="w-full text-xs border border-slate-200 rounded-lg pl-8 pr-3 py-2.5 focus:outline-none focus:border-slate-300 bg-slate-50/50"
                    />
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-zinc-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                        </svg>
                    </div>
                </div>

                <!-- Type Filter -->
                <div>
                    <select x-model="filterType" class="w-full text-xs border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-300 bg-slate-50/50 text-zinc-600 font-medium">
                        <option value="all">File Type: All</option>
                        <option value="PDF">PDF</option>
                        <option value="Word">Word</option>
                    </select>
                </div>

                <!-- Office Filter -->
                <div>
                    <select x-model="filterOffice" class="w-full text-xs border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-300 bg-slate-50/50 text-zinc-600 font-medium">
                        <option value="all">Office: All Offices</option>
                        <option value="IQA Central Office">IQA Central Office</option>
                        <option value="Office of the President">Office of the President</option>
                        <option value="College of Science">College of Science</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <select x-model="filterStatus" class="w-full text-xs border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-300 bg-slate-50/50 text-zinc-600 font-medium">
                        <option value="all">Status: All Statuses</option>
                        <option value="Verified">Verified</option>
                        <option value="Pending">Pending</option>
                        <option value="Flagged">Flagged</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Files Data Table -->
        <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-150 text-zinc-400 font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4">Document Title</th>
                            <th class="py-3.5 px-4">Uploader / Office</th>
                            <th class="py-3.5 px-4">Date Uploaded</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        <template x-for="doc in filteredDocuments" :key="doc.name">
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-[10px] shrink-0">
                                            <span x-text="doc.type"></span>
                                        </div>
                                        <div class="min-w-0">
                                            <span class="font-bold text-[#1b355a] block truncate text-sm" x-text="doc.name"></span>
                                            <span class="text-[11px] text-zinc-400" x-text="doc.size"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-zinc-700 block" x-text="doc.uploader"></span>
                                    <span class="text-[11px] text-zinc-400 block" x-text="doc.office"></span>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-500 font-semibold" x-text="doc.date"></td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold border"
                                        :class="doc.status === 'Verified' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : (doc.status === 'Pending' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-rose-50 text-rose-700 border-rose-100')"
                                        x-text="doc.status"></span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <button type="button" class="text-xs font-bold text-blue-650 hover:underline cursor-pointer" @click="openDoc(doc)">
                                        Inspect File
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Empty File Table State -->
            <template x-if="filteredDocuments.length === 0">
                <div class="flex flex-col items-center justify-center text-center p-12 gap-2">
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-zinc-400 flex items-center justify-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-zinc-700">No documents found</span>
                    <span class="text-xs text-zinc-400">Try adjusting your filters or search terms.</span>
                </div>
            </template>
        </div>
    </div>
</div>
