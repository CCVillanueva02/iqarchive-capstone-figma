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
