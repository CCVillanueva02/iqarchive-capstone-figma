<!-- ================= TAB: COMMON DOCUMENTS ================= -->
<div x-show="activeTab === 'common'" class="flex flex-col gap-6">
    <!-- ================= STATE 1: CATEGORY SHOWCASE ================= -->
    <div x-show="selectedCategory === null" x-transition class="flex flex-col gap-6">
        <!-- Search bar for categories & Action Buttons -->
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
                
                <!-- Toolbar Action Buttons -->
                <div class="flex items-center gap-2 shrink-0">
                    <!-- Create Category Button (Strictly for IQA Admin and System Admin) -->
                    @if(in_array(auth()->user()->role, ['iqa-admin', 'system-administrator']) || auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('system-administrator'))
                    <button type="button" @click="openCreateCategoryModal()" class="bg-[#1b355a] hover:bg-[#112239] text-white text-xs font-bold px-4 py-3 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-3xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Create Category</span>
                    </button>
                    @endif

                    <!-- Upload Document Button (For IQA Admin, IQA Member, System Admin) -->
                    @if(in_array(auth()->user()->role, ['iqa-admin', 'iqa-member', 'system-administrator']) || auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('iqa-member') || auth()->user()->hasRole('system-administrator'))
                    <button type="button" @click="openUploadModal()" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-xs font-bold px-4.5 py-3 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-2xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span>Upload Document</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Showcase grid: strictly max 3 columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="cat in filteredCategories" :key="cat.id || cat.name">
                <div @click="selectCategory(cat.name)" class="bg-white border border-slate-200/65 rounded-xl p-5 shadow-3xs flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 hover:shadow-md hover:border-slate-300 cursor-pointer group font-sans">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-800 flex items-center justify-center mb-4 transition-colors group-hover:bg-[#F27224]/10 group-hover:text-[#F27224]" x-html="cat.icon || '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z\'></path></svg>'">
                        </div>
                        <h3 class="font-bold text-base text-[#1b355a] leading-tight" x-text="cat.name"></h3>
                        <p class="text-xs text-zinc-500 mt-1.5 leading-normal" x-text="cat.description"></p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-sm font-semibold text-zinc-400" x-text="(cat.docCount || 0) + ' documents'"></span>
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
                <button type="button" @click="openUploadModal()" class="bg-[#f27224] hover:bg-[#d65f1a] text-white text-sm font-bold px-5 py-3 rounded-lg flex items-center gap-1.5 shrink-0 shadow-2xs transition cursor-pointer">
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

                    <!-- College/Office Select -->
                    <div class="relative">
                        <select x-model="filterOffice" class="text-sm bg-[#f8fafc] border border-slate-200 rounded-lg pl-4 pr-10 py-2.5 text-zinc-650 appearance-none focus:outline-none focus:border-slate-300 font-semibold cursor-pointer">
                            <option value="all">Office: All</option>
                            <option value="IQA Central Office">IQA Central Office</option>
                            <option value="Office of the President">Office of the President</option>
                            <option value="College of Science">College of Science</option>
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
                            <th class="py-3.5 px-6">Lead Office</th>
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
                                    <div class="max-w-[280px] truncate" x-text="doc.name"></div>
                                </td>
                                <!-- Uploader -->
                                <td class="py-4 px-6 text-zinc-500" x-text="doc.uploader"></td>
                                <!-- Lead Office -->
                                <td class="py-4 px-6 text-zinc-500" x-text="doc.office"></td>
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

    <!-- Modal for Creating New Category (IQA Admin & System Admin only) -->
    <div x-show="showCreateCategoryModal" 
         @click="closeCreateCategoryModal()" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-[300] flex items-center justify-center p-4">
        
        <div @click.stop 
             x-show="showCreateCategoryModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 max-w-lg w-full p-6 flex flex-col gap-5 relative z-[310]">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1b355a] flex items-center justify-center font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-[#1b355a]">Create Document Category</h3>
                        <p class="text-xs text-zinc-400 mt-0.5">Add a new category card to organize common documents</p>
                    </div>
                </div>
                <button type="button" @click="closeCreateCategoryModal()" class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Alert messages -->
            <template x-if="createCategoryError">
                <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold" x-text="createCategoryError"></div>
            </template>
            <template x-if="createCategorySuccess">
                <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold" x-text="createCategorySuccess"></div>
            </template>

            <!-- Form Body -->
            <form @submit.prevent="submitNewCategory()" class="flex flex-col gap-4 font-sans">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" x-model="newCategoryForm.name" placeholder="e.g. Research & Publication Policies" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]" />
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Category Description</label>
                    <textarea x-model="newCategoryForm.description" rows="3" placeholder="Brief summary of files contained in this category card..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]"></textarea>
                </div>

                <!-- Modal Action Footer -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="closeCreateCategoryModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-xs rounded-xl transition cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" :disabled="createCategoryLoading" class="px-5 py-2.5 bg-[#1b355a] hover:bg-[#112239] text-white font-bold text-xs rounded-xl transition shadow-2xs cursor-pointer flex items-center gap-2">
                        <span x-text="createCategoryLoading ? 'Creating...' : 'Create Category Card'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Uploading Common Document -->
    <div x-show="showUploadModal" 
         @click="closeUploadModal()" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-[300] flex items-center justify-center p-4">
        
        <div @click.stop 
             x-show="showUploadModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 max-w-lg w-full p-6 flex flex-col gap-5 relative z-[310]">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#f27224] flex items-center justify-center font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-[#1b355a]">Upload Common Document</h3>
                        <p class="text-xs text-zinc-400 mt-0.5">Attach a file and assign it to a category</p>
                    </div>
                </div>
                <button type="button" @click="closeUploadModal()" class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Alert messages -->
            <template x-if="uploadError">
                <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold" x-text="uploadError"></div>
            </template>
            <template x-if="uploadSuccess">
                <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold" x-text="uploadSuccess"></div>
            </template>

            <!-- Form Body -->
            <form @submit.prevent="submitUploadDocument()" class="flex flex-col gap-4 font-sans">
                <!-- Document Title -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Document Title <span class="text-rose-500">*</span></label>
                    <input type="text" x-model="uploadForm.title" placeholder="e.g. Bicol University Academic Code 2026" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]" />
                </div>

                <!-- Document Category Select -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Document Category <span class="text-rose-500">*</span></label>
                    <select x-model="uploadForm.category_name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]">
                        <template x-for="cat in categories" :key="cat.id || cat.name">
                            <option :value="cat.name" x-text="cat.name"></option>
                        </template>
                    </select>
                </div>

                <!-- Lead Office -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Lead Office</label>
                    <input type="text" x-model="uploadForm.office" placeholder="e.g. IQA Central Office / Office of the President" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#1b355a]/20 focus:border-[#1b355a]" />
                </div>

                <!-- Attachment File -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#1b355a]">Attachment File</label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center bg-slate-50/50 hover:bg-slate-50 transition cursor-pointer flex flex-col items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                        </svg>
                        <span class="text-xs font-bold text-[#1b355a]">Click to select PDF or Word document</span>
                        <span class="text-[10px] text-zinc-400">Supported formats: .pdf, .docx, .xlsx (Max: 25MB)</span>
                    </div>
                </div>

                <!-- Modal Action Footer -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="closeUploadModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-zinc-700 font-bold text-xs rounded-xl transition cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" :disabled="uploadLoading" class="px-5 py-2.5 bg-[#f27224] hover:bg-[#d65f1a] text-white font-bold text-xs rounded-xl transition shadow-2xs cursor-pointer flex items-center gap-2">
                        <span x-text="uploadLoading ? 'Uploading...' : 'Save Document'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
