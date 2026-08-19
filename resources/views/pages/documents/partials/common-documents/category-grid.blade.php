<!-- ================= STATE 1: CATEGORY SHOWCASE ================= -->
<div x-show="selectedOffice !== null && selectedCategory === null" x-transition class="flex flex-col gap-6">
    @if(auth()->user()->role === 'iqa-admin' || auth()->user()->hasRole('iqa-admin'))
    <!-- IQA Admin Verification Alert Notice Banner -->
    <div x-show="documents.filter(d => d.status === 'Pending').length > 0" class="bg-amber-50/90 border border-amber-200 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-amber-900 shadow-3xs">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-amber-500/10 text-amber-700 rounded-lg shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <h4 class="text-body-sm font-bold uppercase tracking-wider text-amber-800">Verification Pending Notice</h4>
                <p class="text-body-sm text-amber-700 mt-0.5 font-medium">
                    Note: There <span x-text="documents.filter(d => d.status === 'Pending').length === 1 ? 'is' : 'are'"></span> <strong class="font-extrabold text-amber-900" x-text="documents.filter(d => d.status === 'Pending').length"></strong> common document<span x-text="documents.filter(d => d.status === 'Pending').length === 1 ? '' : 's'"></span> awaiting verification.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Search bar for categories & Action Buttons -->
    <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
        <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
            <div class="relative w-full max-w-[480px]">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search document categories..."
                    class="w-full text-body border border-slate-200 rounded-lg pl-9 pr-3 py-3 focus:outline-none focus:border-slate-300 bg-slate-50/50" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                    </svg>
                </div>
            </div>

            <!-- Toolbar Action Buttons -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Back to Offices Button -->
                <button type="button" @click="selectedOffice = null; searchQuery = ''" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-body-sm font-bold px-4 py-3 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-3xs mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Back to Offices</span>
                </button>

                <!-- Create Category Button (Strictly for IQA Admin) -->
                @if(auth()->user()->role === 'iqa-admin' || auth()->user()->hasRole('iqa-admin'))
                <button type="button" @click="openCreateCategoryModal()" class="bg-primary hover:bg-primary-dark-hover text-white text-body-sm font-bold px-4 py-3 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-3xs">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Create Category</span>
                </button>
                @endif

                <!-- Upload Document Button (For IQA Admin, IQA Member) -->
                @if(in_array(auth()->user()->role, ['iqa-admin', 'iqa-member']) || auth()->user()->hasRole('iqa-admin') || auth()->user()->hasRole('iqa-member'))
                <button type="button" @click="openUploadModal()" class="bg-brand-orange hover:bg-brand-orange-hover text-white text-body-sm font-bold px-4.5 py-3 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-2xs">
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
            <div @click="selectCategory(cat.name)"
                class="bg-white border border-slate-200/90 rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:border-primary-dark/30 hover:shadow-md cursor-pointer group font-sans">
                <div>
                    <!-- Top Row: Icon Badge & Category Tag -->
                    <div class="flex items-start justify-between">
                        <!-- Icon Badge Container with Counter Badge -->
                        <div class="relative w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0 transition-colors group-hover:bg-blue-100/70">
                            <!-- Blue stroke folder icon (Lucide folder icon) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary-dark group-hover:text-primary-hover transition-colors">
                                <path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L8.6 3.3A2 2 0 0 0 7.1 2.5H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z" />
                            </svg>
                            <!-- Badge for Document Count (Dark Blue Badge) -->
                            <div class="absolute -top-1.5 -right-1.5 w-5.5 h-5.5 rounded-full flex items-center justify-center text-label transition-colors shadow-2xs"
                                :class="(cat.docCount && cat.docCount > 0) ? 'bg-primary-dark text-white font-bold' : 'bg-slate-200 text-slate-500 font-semibold'">
                                <span x-text="cat.docCount || 0"></span>
                            </div>
                        </div>

                        <!-- Category Label -->
                        <span class="text-label font-bold text-slate-400 tracking-wider uppercase mt-1 select-none">CATEGORY</span>
                    </div>

                    <!-- Card Title -->
                    <h3 class="font-bold text-heading-sm text-primary-dark group-hover:text-brand-orange transition-colors leading-snug mt-4" x-text="cat.name"></h3>

                    <!-- Card Description -->
                    <p class="text-body text-slate-500 mt-1 leading-normal" x-text="cat.description || 'No documents yet.'"></p>
                </div>

                <!-- Footer: Open Folder Link -->
                <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-end">
                    <span class="text-body font-bold text-brand-orange flex items-center gap-1.5 select-none transition-transform group-hover:translate-x-1">
                        <span>Open folder</span>
                        <span class="text-heading-sm leading-none">&rarr;</span>
                    </span>
                </div>
            </div>
        </template>
    </div>
</div>