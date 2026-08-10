<!-- ================= STATE 2: CATEGORY DETAIL WORKSPACE ================= -->
<div x-show="selectedCategory !== null" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-data="{ 
         sortField: 'date', 
         sortAsc: false,
         toggleSort(field) {
             if (this.sortField === field) {
                 this.sortAsc = !this.sortAsc;
             } else {
                 this.sortField = field;
                 this.sortAsc = true;
             }
         },
         get sortedDocuments() {
             let docs = [...filteredDocuments];
             if (this.sortField) {
                 docs.sort((a, b) => {
                     let valA = (a[this.sortField] || '').toString().toLowerCase();
                     let valB = (b[this.sortField] || '').toString().toLowerCase();
                     if (valA < valB) return this.sortAsc ? -1 : 1;
                     if (valA > valB) return this.sortAsc ? 1 : -1;
                     return 0;
                 });
             }
             return docs;
         }
     }"
     class="flex flex-col gap-4 font-sans">

    <!-- Filter & Action Controls Container Card -->
    <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs flex flex-col gap-4">
        <!-- Search and Action Row -->
        <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
            <!-- Search Input -->
            <div class="relative w-full sm:max-w-md">
                <input 
                    type="text" 
                    x-model="searchQuery"
                    placeholder="Search documents in this category..." 
                    class="w-full text-sm border border-slate-200 rounded-lg pl-9 pr-3 py-2.5 focus:outline-none focus:border-[#002B61] focus:ring-1 focus:ring-[#002B61] bg-slate-50/50"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                    </svg>
                </div>
            </div>

            <!-- Toolbar Actions & Filters -->
            <div class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto justify-end">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider hidden lg:inline">Filter by:</span>
                
                <!-- Doc Type Select -->
                <div class="relative">
                    <select x-model="filterType" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-650 appearance-none focus:outline-none focus:border-[#002B61] font-semibold cursor-pointer">
                        <option value="all">Type: All</option>
                        <option value="PDF">PDF</option>
                        <option value="Word">Word</option>
                        <option value="Excel">Excel</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                        <svg class="fill-current h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <!-- Date Select -->
                <div class="relative">
                    <select x-model="filterDate" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-650 appearance-none focus:outline-none focus:border-[#002B61] font-semibold cursor-pointer">
                        <option value="all">Date: All</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                        <svg class="fill-current h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <!-- Status Select -->
                <div class="relative">
                    <select x-model="filterStatus" class="text-xs bg-[#f8fafc] border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-zinc-650 appearance-none focus:outline-none focus:border-[#002B61] font-semibold cursor-pointer">
                        <option value="all">Status: All</option>
                        <option value="Verified">Verified</option>
                        <option value="Pending">Pending</option>
                        <option value="Flagged">Flagged</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                        <svg class="fill-current h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <!-- Upload Button -->
                @if(in_array(auth()->user()->role, ['iqa-admin', 'iqa-member', 'system-administrator']) || auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('iqa-member') || auth()->user()->hasRole('system-administrator'))
                <button type="button" @click="openUploadModal()" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-xs font-bold px-4 py-2 rounded-lg flex items-center gap-1.5 shrink-0 shadow-2xs transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Upload</span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Listing details table card -->
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans text-sm">
                <thead>
                    <tr class="bg-slate-50/90 border-b border-slate-200/80 text-zinc-500 font-bold uppercase tracking-wider select-none text-[11px]">
                        <!-- Document Title Header (Gives most space to Title) -->
                        <th class="py-3.5 pl-6 pr-4 cursor-pointer hover:text-[#002B61] transition group/th" @click="toggleSort('name')">
                            <div class="flex items-center gap-1.5">
                                <span>DOCUMENT TITLE</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200"
                                     :class="{
                                         'text-[#002B61] opacity-100': sortField === 'name',
                                         'text-zinc-300 opacity-60 group-hover/th:opacity-100': sortField !== 'name',
                                         'rotate-180': sortField === 'name' && sortAsc,
                                         'rotate-0': sortField !== 'name' || !sortAsc
                                     }"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </th>

                        <!-- Uploader Header -->
                        <th class="py-3.5 px-4 w-44 whitespace-nowrap shrink-0 cursor-pointer hover:text-[#002B61] transition group/th" @click="toggleSort('uploader')">
                            <div class="flex items-center gap-1">
                                <span>UPLOADER</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200"
                                     :class="{
                                         'text-[#002B61] opacity-100': sortField === 'uploader',
                                         'text-zinc-300 opacity-60 group-hover/th:opacity-100': sortField !== 'uploader',
                                         'rotate-180': sortField === 'uploader' && sortAsc,
                                         'rotate-0': sortField !== 'uploader' || !sortAsc
                                     }"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </th>

                        <!-- Upload Date Header -->
                        <th class="py-3.5 px-4 w-36 whitespace-nowrap shrink-0 cursor-pointer hover:text-[#002B61] transition group/th" @click="toggleSort('date')">
                            <div class="flex items-center gap-1">
                                <span>UPLOAD DATE</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200"
                                     :class="{
                                         'text-[#002B61] opacity-100': sortField === 'date',
                                         'text-zinc-300 opacity-60 group-hover/th:opacity-100': sortField !== 'date',
                                         'rotate-180': sortField === 'date' && sortAsc,
                                         'rotate-0': sortField !== 'date' || !sortAsc
                                     }"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </th>

                        <!-- Status Header -->
                        <th class="pl-8 px-4 w-36 whitespace-nowrap shrink-0 cursor-pointer hover:text-[#002B61] transition group/th" @click="toggleSort('status')">
                            <div class="flex items-center gap-1">
                                <span>STATUS</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200"
                                     :class="{
                                         'text-[#002B61] opacity-100': sortField === 'status',
                                         'text-zinc-300 opacity-60 group-hover/th:opacity-100': sortField !== 'status',
                                         'rotate-180': sortField === 'status' && sortAsc,
                                         'rotate-0': sortField !== 'status' || !sortAsc
                                     }"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </th>

                        <!-- Actions Header -->
                        <th class="pr-12 pl-4 w-32 text-right whitespace-nowrap shrink-0">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <template x-for="doc in sortedDocuments" :key="doc.id || doc.name">
                        <tr class="hover:bg-slate-50/70 transition group">
                            <!-- Document Title Column (Flexible, gives maximum space) -->
                            <td class="py-4 pl-6 pr-4">
                                <div class="flex items-center gap-2.5 cursor-pointer" @click="openDoc(doc)">
                                    <!-- PDF Icon -->
                                    <template x-if="doc.type === 'PDF' || !doc.type">
                                        <svg class="w-5 h-6 shrink-0" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 2A2 2 0 0 1 5 0H14L21 7V26A2 2 0 0 1 19 28H5A2 2 0 0 1 3 26V2Z" fill="#DC2626"/>
                                            <path d="M14 0L21 7H14V0Z" fill="#991B1B"/>
                                            <text x="3.5" y="22" fill="white" font-size="7" font-weight="900" font-family="sans-serif">PDF</text>
                                        </svg>
                                    </template>
                                    <!-- Word Icon -->
                                    <template x-if="doc.type === 'Word'">
                                        <svg class="w-5 h-6 shrink-0" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 2A2 2 0 0 1 5 0H14L21 7V26A2 2 0 0 1 19 28H5A2 2 0 0 1 3 26V2Z" fill="#2563EB"/>
                                            <path d="M14 0L21 7H14V0Z" fill="#1D4ED8"/>
                                            <text x="3" y="22" fill="white" font-size="7" font-weight="900" font-family="sans-serif">DOC</text>
                                        </svg>
                                    </template>
                                    <!-- Excel Icon -->
                                    <template x-if="doc.type === 'Excel'">
                                        <svg class="w-5 h-6 shrink-0" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 2A2 2 0 0 1 5 0H14L21 7V26A2 2 0 0 1 19 28H5A2 2 0 0 1 3 26V2Z" fill="#059669"/>
                                            <path d="M14 0L21 7H14V0Z" fill="#047857"/>
                                            <text x="3" y="22" fill="white" font-size="7" font-weight="900" font-family="sans-serif">XLS</text>
                                        </svg>
                                    </template>

                                    <!-- Document Name text -->
                                    <span class="font-bold text-[#111827] group-hover:text-[#F47920] transition leading-snug break-words" x-text="doc.name"></span>
                                </div>
                            </td>

                            <!-- Uploader Column -->
                            <td class="py-4 px-4 text-slate-700 font-semibold whitespace-nowrap shrink-0" x-text="doc.uploader || 'Sys Admin'"></td>

                            <!-- Upload Date Column -->
                            <td class="py-4 px-4 text-slate-700 font-semibold whitespace-nowrap shrink-0" x-text="doc.date"></td>

                            <!-- Status Badge Column -->
                            <td class="py-4 px-4 whitespace-nowrap shrink-0">
                                <!-- Verified Status Pill -->
                                <template x-if="doc.status === 'Verified'">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#dcfce7] text-[#15803d] border border-[#bbf7d0] shadow-2xs">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-[#15803d]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span>Verified</span>
                                    </span>
                                </template>

                                <!-- Pending Status Pill -->
                                <template x-if="doc.status === 'Pending'">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#fef3c7] text-[#92400e] border border-[#fde68a] shadow-2xs">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-[#92400e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <circle cx="12" cy="12" r="9" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3" />
                                        </svg>
                                        <span>Pending</span>
                                    </span>
                                </template>

                                <!-- Flagged Status Pill -->
                                <template x-if="doc.status === 'Flagged'">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 00-.005-10.499l-3.11.732a9 9 0 01-6.085-.71l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                        </svg>
                                        <span>Flagged</span>
                                    </span>
                                </template>
                            </td>

                            <!-- View Action Button Column -->
                            <td class="py-4 pl-4 pr-6 text-right whitespace-nowrap shrink-0">
                                <button @click="openDoc(doc)" class="text-xs font-bold text-[#002B61] hover:text-[#F47920] transition cursor-pointer select-none bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg border border-slate-200/80">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    </template>

                    <!-- Empty State -->
                    <template x-if="sortedDocuments.length === 0">
                        <tr>
                            <td colspan="5" class="py-12 px-6 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <p class="text-sm font-semibold text-slate-600">No documents found</p>
                                <p class="text-xs text-slate-400 mt-1">Try adjusting your search query or filter options.</p>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Summary & Pagination Bar -->
        <div class="px-6 py-3.5 bg-white border-t border-slate-200/60 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 font-semibold select-none">
            <span x-text="'Showing 1-' + sortedDocuments.length + ' of ' + sortedDocuments.length + ' documents'"></span>

            <!-- Pagination Buttons matching reference image -->
            <div class="flex items-center gap-1.5">
                <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:bg-slate-50 transition cursor-pointer shadow-2xs disabled:opacity-40 disabled:cursor-not-allowed" disabled>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:bg-slate-50 transition cursor-pointer shadow-2xs disabled:opacity-40 disabled:cursor-not-allowed" disabled>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>


