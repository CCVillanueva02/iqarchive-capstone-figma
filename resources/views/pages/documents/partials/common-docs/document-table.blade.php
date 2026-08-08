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
                    class="w-full text-sm border border-slate-200 rounded-lg pl-9 pr-3 py-3 focus:outline-none focus:border-slate-300 bg-slate-50/50"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                    </svg>
                </div>
            </div>

            <!-- Upload Button -->
            @if(in_array(auth()->user()->role, ['iqa-admin', 'iqa-member', 'system-administrator']) || auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('iqa-member') || auth()->user()->hasRole('system-administrator'))
            <button type="button" @click="openUploadModal()" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-xs font-bold px-5 py-3 rounded-lg flex items-center gap-1.5 shrink-0 shadow-2xs transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Upload Document</span>
            </button>
            @endif
        </div>

        <!-- Bottom Row: Select Filters -->
        <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-slate-100/60 font-sans">
            <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider">Filter by:</span>
            
            <div class="flex flex-wrap items-center gap-2">
                <!-- Doc Type Select -->
                <div class="relative">
                    <select x-model="filterType" class="text-sm bg-[#f8fafc] border border-slate-200 rounded-lg pl-4 pr-10 py-2.5 text-zinc-600 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                        <option value="all">Doc Type: All</option>
                        <option value="PDF">PDF</option>
                        <option value="Word">Word</option>
                        <option value="Excel">Excel</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <!-- Date Select -->
                <div class="relative">
                    <select x-model="filterDate" class="text-sm bg-[#f8fafc] border border-slate-200 rounded-lg pl-4 pr-10 py-2.5 text-zinc-650 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                        <option value="all">Date: All</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <!-- Status Select -->
                <div class="relative">
                    <select x-model="filterStatus" class="text-sm bg-[#f8fafc] border border-slate-200 rounded-lg pl-4 pr-10 py-2.5 text-zinc-650 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                        <option value="all">Status: All</option>
                        <option value="Verified">Verified</option>
                        <option value="Pending">Pending</option>
                        <option value="Flagged">Flagged</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Listing details table wrapper -->
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans text-sm">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100 text-zinc-400 font-bold uppercase tracking-wider select-none text-[11px]">
                        <th class="py-3.5 px-6">Document Title</th>
                        <th class="py-3.5 px-6">Uploader</th>
                        <th class="py-3.5 px-6 text-center">Type</th>
                        <th class="py-3.5 px-6">Upload Date</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <template x-for="doc in filteredDocuments" :key="doc.name">
                        <tr class="hover:bg-slate-50/50 transition">
                            <!-- Title -->
                            <td class="py-4 px-6 font-bold text-[#1b355a]">
                                <div class="max-w-[320px] truncate" x-text="doc.name"></div>
                            </td>
                            <!-- Uploader -->
                            <td class="py-4 px-6 text-zinc-500" x-text="doc.uploader"></td>
                            <!-- Type -->
                            <td class="py-4 px-6 text-center shrink-0">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-rose-50 text-rose-600 uppercase tracking-wide" x-text="doc.type"></span>
                            </td>
                            <!-- Upload Date -->
                            <td class="py-4 px-6 text-zinc-400 font-semibold" x-text="doc.date"></td>
                            <!-- Status Badge -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold"
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
                            <td class="py-4 px-6 text-right">
                                <button @click="openDoc(doc)" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition cursor-pointer select-none">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Footer statistics summary -->
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center text-sm text-zinc-400 font-semibold select-none">
            <span x-text="'Showing ' + filteredDocuments.length + ' documents'"></span>
        </div>
    </div>
</div>
