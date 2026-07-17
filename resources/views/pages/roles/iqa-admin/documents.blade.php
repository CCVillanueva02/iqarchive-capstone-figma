<x-layouts::app :title="__('General Documents')">
    <div x-data="documentWorkspace()" class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen relative overflow-hidden">
        <!-- Top Header & Tabs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
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
            
            <div class="flex items-center gap-3 self-end md:self-auto">
                <!-- Toggle Tab Switcher -->
                <div class="bg-slate-100 border border-slate-200/60 rounded-lg p-0.5 flex gap-1 text-[11px]">
                    <button type="button" class="px-4 py-1.5 font-bold rounded-md bg-white border border-slate-200/50 shadow-2xs text-[#1b355a]">
                        Common Documents
                    </button>
                    <button type="button" class="px-4 py-1.5 font-medium rounded-md text-zinc-500 hover:text-[#1b355a] transition" onclick="window.location.href='{{ route('submissions.' . auth()->user()->role) }}'">
                        Accreditation
                    </button>
                </div>

                <!-- Bell Notification Button -->
                <button type="button" class="relative p-2 rounded-lg bg-white border border-slate-200 text-zinc-500 hover:text-[#1b355a] transition shadow-3xs cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-orange-500 rounded-full border border-white"></span>
                </button>
            </div>
        </div>

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
                            <span class="text-xs font-bold text-[#f27224] flex items-center gap-1 opacity-80 group-hover:opacity-100 group-hover:underline">
                                View documents
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 transform transition-transform group-hover:translate-x-1">
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

            <!-- Documents Table Container Card -->
            <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full border-collapse text-left text-xs text-zinc-600">
                        <thead>
                            <tr class="border-bottom border-slate-100 bg-slate-50/70 text-zinc-500 font-bold uppercase tracking-wider text-[10px]">
                                <th class="px-6 py-4">Document Title</th>
                                <th class="px-6 py-4">Uploader</th>
                                <th class="px-6 py-4">Lead Office</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4">Upload Date</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="doc in filteredDocuments" :key="doc.name">
                                <tr @click="openDoc(doc)" class="hover:bg-slate-50/80 transition-colors cursor-pointer group">
                                    <td class="px-6 py-4 font-semibold text-[#1b355a]" x-text="doc.name"></td>
                                    <td class="px-6 py-4 text-zinc-500" x-text="doc.uploader"></td>
                                    <td class="px-6 py-4 text-zinc-500" x-text="doc.office"></td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded-md font-bold text-[10px]" 
                                              :class="doc.type === 'PDF' ? 'bg-red-50 text-red-600' : (doc.type === 'Word' ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600')"
                                              x-text="doc.type">
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-zinc-400 font-medium" x-text="doc.date"></td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold"
                                              :class="doc.status === 'Verified' ? 'bg-emerald-50 text-emerald-700' : (doc.status === 'Pending' ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700')">
                                            <span class="w-1.5 h-1.5 rounded-full" 
                                                  :class="doc.status === 'Verified' ? 'bg-emerald-600' : (doc.status === 'Pending' ? 'bg-amber-500' : 'bg-rose-600')"></span>
                                            <span x-text="doc.status"></span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button @click.stop="openDoc(doc)" class="text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="filteredDocuments.length === 0">
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-zinc-400 font-medium bg-slate-50/20">
                                        No documents found matching the search criteria.
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
