<!-- ================= STATE 0: OFFICE SHOWCASE ================= -->
<div x-show="selectedOffice === null" x-transition class="flex flex-col gap-6">
    <!-- Action Buttons -->
    <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
        <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
            <div class="relative w-full max-w-120">
                <input 
                    type="text" 
                    x-model="searchQuery"
                    placeholder="Search offices..." 
                    class="w-full text-body border border-slate-200 rounded-lg pl-9 pr-3 py-3 focus:outline-none focus:border-slate-300 bg-slate-50/50"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Showcase grid: strictly max 3 columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <template x-for="office in filteredOffices" :key="office.id || office.name">
            <div @click="selectOffice(office.id)" 
                 class="bg-white border border-slate-200/90 rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:border-primary-dark/30 hover:shadow-md cursor-pointer group font-sans">
                <div>
                    <!-- Top Row: Icon Badge & Category Tag -->
                    <div class="flex items-start justify-between">
                        <!-- Icon Badge Container -->
                        <div class="relative w-12 h-12 rounded-2xl bg-surface-subtle border border-primary/10 flex items-center justify-center shrink-0 transition-colors group-hover:bg-primary/10/70">
                            <!-- Building icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary-dark group-hover:text-primary-hover transition-colors">
                                <path d="M3 21h18"></path><path d="M9 8h1"></path><path d="M9 12h1"></path><path d="M9 16h1"></path><path d="M14 8h1"></path><path d="M14 12h1"></path><path d="M14 16h1"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path>
                            </svg>
                        </div>

                        <!-- Category Label -->
                        <span class="text-label font-bold text-slate-400 tracking-wider uppercase mt-1 select-none">OFFICE</span>
                    </div>

                    <!-- Card Title -->
                    <h3 class="font-bold text-heading-sm text-primary-dark group-hover:text-brand-orange transition-colors leading-snug mt-4" x-text="office.name"></h3>

                    <!-- Card Description -->
                    <p class="text-body text-slate-500 mt-1 leading-normal" x-text="office.description || 'View office documents'"></p>
                </div>

                <!-- Footer: Open Folder Link -->
                <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-end">
                    <span class="text-body font-bold text-brand-orange flex items-center gap-1.5 select-none transition-transform group-hover:translate-x-1">
                        <span>View categories</span>
                        <span class="text-heading-sm leading-none">&rarr;</span>
                    </span>
                </div>
            </div>
        </template>
    </div>
</div>
