<x-layouts::html :title="'Bicol University IQA Office'" html-class="light scroll-smooth no-scrollbar" body-class="bg-surface-subtle antialiased text-zinc-800 font-sans min-h-screen flex flex-col justify-between no-scrollbar">
    @include('partials.header')

    <div id="home" class="flex-1 flex flex-col">
        <!-- Hero Section -->
        <main class="flex-1 flex flex-col items-center justify-center max-w-5xl mx-auto px-6 py-16 text-center gap-6 mt-8 md:mt-12">
            <div class="flex flex-col items-center gap-4">
                <flux:badge color="orange" size="sm" class="font-bold uppercase tracking-wider px-3.5 py-1 shadow-2xs">
                    BICOL UNIVERSITY
                </flux:badge>

                <h1 class="text-hero md:text-hero font-extrabold text-primary-dark tracking-tight max-w-4xl leading-tight">
                    A Document Management & Monitoring System for Quality Assurance
                </h1>

                <p class="text-body-sm md:text-heading-sm text-zinc-500 max-w-2xl leading-relaxed mt-2">
                    Centralize accreditation documents, track compliance in real time, and simplify quality assurance workflows across Bicol University's colleges and programs.
                </p>

                <!-- Orange Divider -->
                <div class="w-16 h-1 bg-brand-orange mt-4 rounded-full"></div>
            </div>

            <!-- Call to Actions -->
            <div class="flex flex-col sm:flex-row gap-4 mt-4 mb-8">
                <a href="#faq" class="px-6 py-3 bg-white border border-brand-orange text-brand-orange hover:bg-surface-subtle font-bold rounded-xl transition shadow-xs text-body-sm inline-flex items-center justify-center select-none">
                    Browse FAQ
                </a>
            </div>
        </main>

        <!-- Accreditation Overview Section -->
        <section class="relative w-full bg-primary-dark text-white min-h-[75vh] mb-18 flex flex-col justify-center py-16 lg:py-24 px-6 md:px-12 mt-12 rounded-[2.5rem] md:rounded-[4rem] shadow-2xl overflow-hidden">
            <!-- Background Ambient Glow Accents -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-brand-orange/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-primary-light/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto w-full my-auto grid grid-cols-1 lg:grid-cols-12 items-center gap-12 lg:gap-16 relative z-10">
                <!-- Left Text Column -->
                <div class="lg:col-span-6 flex flex-col justify-center text-left gap-6">
                    <!-- Main Headline -->
                    <h2 class="text-heading-lg sm:text-hero font-extrabold tracking-tight leading-[1.1] text-white">
                        Every accreditation, <span class="text-brand-orange">one verified record</span> away.
                    </h2>

                    <!-- Body Description -->
                    <p class="text-body-sm sm:text-body text-zinc-300 leading-relaxed max-w-xl">
                        IQArchive tracks {{ $totalPrograms }} programs against AACCUP standards — from candidacy to Level IV — so your compliance evidence is never scattered across a hundred folders.
                    </p>
                </div>

                <!-- Right Card Column (Bar Chart & Donut Rating) -->
                <div id="accreditation-card" class="lg:col-span-6 w-full">
                    <div class="bg-primary/80 border border-white/10 rounded-3xl p-6 sm:p-8 backdrop-blur-md shadow-2xl flex flex-col gap-6">
                        <!-- Bar Chart Grid -->
                        <div class="h-64 sm:h-72 flex items-end justify-between gap-3 sm:gap-4 px-1 pt-6 pb-2">
                            <!-- LEVEL I -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end group">
                                <div class="w-full bg-[#7c3a00] border border-brand-orange/20 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-110 shadow-md" style="height: 48%;">
                                    <span class="text-body-sm font-bold text-white">{{ $levelI }}</span>
                                </div>
                                <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">LEVEL I</span>
                            </div>

                            <!-- LEVEL II -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end group">
                                <div class="w-full bg-[#b84d09] border border-brand-orange/30 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-110 shadow-md" style="height: 65%;">
                                    <span class="text-body-sm font-bold text-white">{{ $levelII }}</span>
                                </div>
                                <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">LEVEL II</span>
                            </div>

                            <!-- LEVEL III -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end group">
                                <div class="w-full bg-brand-orange-hover border border-brand-orange/40 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-110 shadow-md" style="height: 82%;">
                                    <span class="text-body-sm font-bold text-white">{{ $levelIII }}</span>
                                </div>
                                <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">LEVEL III</span>
                            </div>

                            <!-- LEVEL IV -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end group">
                                <div class="w-full bg-brand-orange border border-brand-orange rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-110 shadow-lg shadow-brand-orange/20" style="height: 100%;">
                                    <span class="text-body-sm font-bold text-white">{{ $levelIV }}</span>
                                </div>
                                <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">LEVEL IV</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="w-full max-w-7xl mx-auto px-6 py-12 text-left scroll-mt-6">
            <div class="max-w-3xl mx-auto flex flex-col gap-6">
                <div class="text-center flex flex-col gap-2">
                    <h3 class="text-heading-lg font-extrabold text-primary-dark tracking-tight">Frequently Asked Questions</h3>
                    <p class="text-body-sm text-zinc-400 max-w-lg mx-auto">
                        Find quick answers relative to documentation audits, role access, and system processes.
                    </p>
                </div>

                <!-- Accordion list using Alpine.js -->
                <div class="mt-6 flex flex-col gap-3" x-data="{ active: null }">
                    <!-- FAQ Item 1 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 1 ? active = null : active = 1" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-body text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>What is the primary role of the BU Internal Quality Assurance Office?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 1 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 1 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 1 }">
                            <p class="px-6 py-4 text-body-sm text-zinc-500 leading-relaxed">
                                The IQA Office oversees the planning, implementation, and monitoring of quality assurance policies at Bicol University, ensuring academic programs align with national and international accreditation standards.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 2 ? active = null : active = 2" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-body text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>What is AACCUP accreditation and why is it important?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 2 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 2 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 2 }">
                            <p class="px-6 py-4 text-body-sm text-zinc-500 leading-relaxed">
                                The Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP) evaluates programs to ensure quality education. BU programs undergo this to benchmark their performance, maintain high academic standards, and qualify for government support.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 3 ? active = null : active = 3" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-body text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>How many levels of AACCUP accreditation exist, and what do they signify?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 3 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 3 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 3 }">
                            <p class="px-6 py-4 text-body-sm text-zinc-500 leading-relaxed">
                                There are four levels of accreditation: Level I (formal accreditation), Level II (re-accredited), Level III (highly re-accredited, emphasizing instruction and community research), and Level IV (outstanding status, recognizing international standards and institutional impact).
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 4 ? active = null : active = 4" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-body text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>What are the core areas assessed during an accreditation survey visit?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 4 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 4 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 4 }">
                            <p class="px-6 py-4 text-body-sm text-zinc-500 leading-relaxed">
                                Evaluators review 10 major areas: Mission/Goals, Faculty, Curriculum, Support to Students, Research, Extension/Community, Library, Physical Plant, Administration, and Quality Assurance.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 5 ? active = null : active = 5" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-body text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>How frequently do university programs undergo quality audits?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 5 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 5 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 5 }">
                            <p class="px-6 py-4 text-body-sm text-zinc-500 leading-relaxed">
                                Programs typically undergo internal quality audits annually, while formal AACCUP survey visits occur every 3 to 5 years depending on the level of accreditation status granted.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('partials.footer')

</x-layouts::html>