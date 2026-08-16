<x-layouts::html :title="'Bicol University IQA Office'" html-class="light scroll-smooth" body-class="bg-[#f3f7fa] antialiased text-zinc-800 font-sans min-h-screen flex flex-col justify-between">
    @include('partials.header')

    <div id="home" class="flex-1 flex flex-col">
        <!-- Hero Section -->
        <main class="flex-1 flex flex-col items-center justify-center max-w-5xl mx-auto px-6 py-16 text-center gap-6 mt-8 md:mt-12">
            <div class="flex flex-col items-center gap-4">
                <flux:badge color="orange" size="sm" class="font-bold uppercase tracking-wider px-3.5 py-1 shadow-2xs">
                    BICOL UNIVERSITY
                </flux:badge>

                <h1 class="text-4xl md:text-6xl font-extrabold text-[#002B61] tracking-tight max-w-4xl leading-tight">
                    A Document Management & Monitoring System for Quality Assurance
                </h1>

                <p class="text-sm md:text-base text-zinc-500 max-w-2xl leading-relaxed mt-2">
                    Access accreditation documents, monitor compliance records, and streamline quality assurance evaluations for Bicol University colleges, program chairs, and accreditors.
                </p>

                <!-- Orange Divider -->
                <div class="w-16 h-[4px] bg-[#f27224] mt-4 rounded-full"></div>
            </div>

            <!-- Call to Actions -->
            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <a href="#help-center" class="px-6 py-3 bg-[#0056b3] hover:bg-[#004085] text-white font-bold rounded-xl transition shadow-md text-xs inline-flex items-center justify-center gap-2 select-none">
                    <span>Explore Help Center</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="#faq" class="px-6 py-3 bg-white border border-[#f27224] text-[#f27224] hover:bg-[#fff9f5] font-bold rounded-xl transition shadow-xs text-xs inline-flex items-center justify-center select-none">
                    Browse FAQ
                </a>
            </div>
        </main>

        <!-- Accreditation Overview Section -->
        <section class="w-full bg-[#002855] text-white py-16 px-6 mt-12 rounded-t-[2.5rem] md:rounded-t-[4rem] shadow-md">
            <div class="max-w-5xl mx-auto flex flex-col lg:flex-row items-center gap-12" x-data="{ tab: 'levels' }">
                <!-- Left Text Column -->
                <div class="lg:w-2/5 flex flex-col gap-4 text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight">
                        We are committed to maintaining the highest quality standards.
                    </h2>
                    <p class="text-zinc-300 text-xs md:text-sm leading-relaxed">
                        IQArchive serves as Bicol University's central digital repository, supporting the Internal Quality Assurance Office in managing documentation, tracking compliance, and ensuring successful AACCUP accreditation audits.
                    </p>
                </div>

                <!-- Right Tabbed Stats Grid -->
                <div class="w-full lg:w-3/5 shrink-0 flex flex-col gap-5">
                    <!-- Tab Switches -->
                    <div class="flex flex-wrap bg-white/10 p-1 rounded-xl border border-white/10 self-start lg:self-end">
                        <button type="button" @click="tab = 'levels'" :class="tab === 'levels' ? 'bg-[#f27224] text-white' : 'text-zinc-300 hover:text-white'" class="px-3.5 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-wider transition cursor-pointer select-none">
                            Accreditation Levels
                        </button>
                        <button type="button" @click="tab = 'degrees'" :class="tab === 'degrees' ? 'bg-[#f27224] text-white' : 'text-zinc-300 hover:text-white'" class="px-3.5 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-wider transition cursor-pointer select-none">
                            Programs by Degree
                        </button>
                        <button type="button" @click="tab = 'accredited'" :class="tab === 'accredited' ? 'bg-[#f27224] text-white' : 'text-zinc-300 hover:text-white'" class="px-3.5 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-wider transition cursor-pointer select-none">
                            Accreditation Status
                        </button>
                    </div>

                    <!-- Tab 1: Accreditation Levels -->
                    <div x-show="tab === 'levels'" class="grid grid-cols-2 sm:grid-cols-3 gap-3 md:gap-4 transition-all duration-200">
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-[#f27224] mb-1">11</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Level IV</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-[#f27224] mb-1">32</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Level III</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-white mb-1">35</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Level II</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-white mb-1">38</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Level I</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-zinc-400 mb-1">4</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Candidate</span>
                        </div>
                        <div class="bg-[#f27224]/10 border border-[#f27224]/30 p-4 rounded-xl text-center backdrop-blur-xs select-none flex flex-col justify-center">
                            <span class="block text-2xl font-extrabold text-[#f27224] mb-0.5">116</span>
                            <span class="text-[9px] text-white font-bold uppercase tracking-wider">Accredited Programs</span>
                        </div>
                    </div>

                    <!-- Tab 2: Programs by Degree -->
                    <div x-show="tab === 'degrees'" class="grid grid-cols-2 sm:grid-cols-3 gap-3 md:gap-4 transition-all duration-200" style="display: none;">
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-[#f27224] mb-1">80</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Baccalaureate</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-white mb-1">39</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Master's Degree</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-white mb-1">7</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Doctoral Degree</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-zinc-400 mb-1">2</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Post Bacc</span>
                        </div>
                        <div class="bg-[#f27224]/10 border border-[#f27224]/30 p-4 rounded-xl text-center backdrop-blur-xs select-none flex flex-col justify-center col-span-2">
                            <span class="block text-2xl font-extrabold text-[#f27224] mb-0.5">126</span>
                            <span class="text-[9px] text-white font-bold uppercase tracking-wider">Total Programs</span>
                        </div>
                    </div>

                    <!-- Tab 3: Accreditation Status -->
                    <div x-show="tab === 'accredited'" class="grid grid-cols-2 sm:grid-cols-3 gap-3 md:gap-4 transition-all duration-200" style="display: none;">
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-[#f27224] mb-1">74</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Undergraduate</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl text-center backdrop-blur-xs select-none">
                            <span class="block text-2xl font-extrabold text-white mb-1">42</span>
                            <span class="text-[9px] text-zinc-300 font-semibold uppercase tracking-wider">Graduate</span>
                        </div>
                        <div class="bg-[#f27224]/10 border border-[#f27224]/30 p-4 rounded-xl text-center backdrop-blur-xs select-none flex flex-col justify-center col-span-2 sm:col-span-1">
                            <span class="block text-2xl font-extrabold text-[#f27224] mb-0.5">116</span>
                            <span class="text-[9px] text-white font-bold uppercase tracking-wider">Total Accredited</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Accreditation News & Announcements Section -->
        <section id="accreditations" class="w-full max-w-7xl mx-auto px-6 py-16 scroll-mt-6">
            <!-- Main Outer Card -->
            <div class="bg-white border border-slate-200/60 rounded-3xl p-8 md:p-12 shadow-3xs flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Left Text Column -->
                <div class="lg:w-1/3 flex flex-col gap-3 text-left justify-center">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">LATEST ANNOUNCEMENTS</span>
                    <h3 class="text-2xl font-extrabold text-[#002B61]">Accreditation & IQA Updates</h3>
                    <p class="text-xs text-zinc-500 leading-relaxed">
                        Stay updated with the latest program evaluations, accreditation calendar schedules, and official quality standards announcements from the IQA Office.
                    </p>
                </div>

                <!-- Right Cards Column -->
                <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nested Card 1 -->
                    <div class="bg-[#f8fafc] border border-slate-200/60 p-6 rounded-2xl flex flex-col justify-between hover:shadow-xs transition duration-200 text-left">
                        <div>
                            <span class="text-[9px] font-bold text-[#f27224] uppercase tracking-wider">Program Accreditation</span>
                            <h4 class="font-extrabold text-sm text-slate-800 mt-1 mb-2">BS Computer Science Achieves Level IV</h4>
                            <p class="text-xs text-zinc-500 leading-relaxed mb-4">
                                The BS Computer Science program has officially been awarded Level IV Re-accredited status by AACCUP, recognizing its excellence in instruction, research, and community extension.
                            </p>
                        </div>
                        <a href="mailto:bu-iqao@bicol-u.edu.ph" class="inline-flex items-center gap-1.5 text-[10px] font-bold text-[#002B61] hover:text-[#f27224] transition uppercase tracking-wider select-none">
                            <span>Read Announcement</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>

                    <!-- Nested Card 2 -->
                    <div class="bg-[#f8fafc] border border-slate-200/60 p-6 rounded-2xl flex flex-col justify-between hover:shadow-xs transition duration-200 text-left">
                        <div>
                            <span class="text-[9px] font-bold text-[#0056b3] uppercase tracking-wider">Institutional Status</span>
                            <h4 class="font-extrabold text-sm text-slate-800 mt-1 mb-2">Bicol University Awarded Institutional Accreditation</h4>
                            <p class="text-xs text-zinc-500 leading-relaxed mb-4">
                                Bicol University has successfully passed the rigorous AACCUP evaluation, securing full Institutional Accreditation status for its outstanding university operations and quality assurance systems.
                            </p>
                        </div>
                        <a href="mailto:bu-iqao@bicol-u.edu.ph" class="inline-flex items-center gap-1.5 text-[10px] font-bold text-[#002B61] hover:text-[#f27224] transition uppercase tracking-wider select-none">
                            <span>Read Announcement</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="w-full max-w-7xl mx-auto px-6 py-12 text-left scroll-mt-6">
            <div class="max-w-3xl mx-auto flex flex-col gap-6">
                <div class="text-center flex flex-col gap-2">
                    <h3 class="text-3xl font-extrabold text-[#002B61] tracking-tight">Frequently Asked Questions</h3>
                    <p class="text-xs text-zinc-400 max-w-lg mx-auto">
                        Find quick answers relative to documentation audits, role access, and system processes.
                    </p>
                </div>

                <!-- Accordion list using Alpine.js -->
                <div class="mt-6 flex flex-col gap-3" x-data="{ active: null }">
                    <!-- FAQ Item 1 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 1 ? active = null : active = 1" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-sm text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>What is the primary role of the BU Internal Quality Assurance Office?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 1 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 1 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 1 }">
                            <p class="px-6 py-4 text-xs text-zinc-500 leading-relaxed">
                                The IQA Office oversees the planning, implementation, and monitoring of quality assurance policies at Bicol University, ensuring academic programs align with national and international accreditation standards.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 2 ? active = null : active = 2" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-sm text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>What is AACCUP accreditation and why is it important?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 2 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 2 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 2 }">
                            <p class="px-6 py-4 text-xs text-zinc-500 leading-relaxed">
                                The Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP) evaluates programs to ensure quality education. BU programs undergo this to benchmark their performance, maintain high academic standards, and qualify for government support.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 3 ? active = null : active = 3" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-sm text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>How many levels of AACCUP accreditation exist, and what do they signify?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 3 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 3 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 3 }">
                            <p class="px-6 py-4 text-xs text-zinc-500 leading-relaxed">
                                There are four levels of accreditation: Level I (formal accreditation), Level II (re-accredited), Level III (highly re-accredited, emphasizing instruction and community research), and Level IV (outstanding status, recognizing international standards and institutional impact).
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 4 ? active = null : active = 4" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-sm text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>What are the core areas assessed during an accreditation survey visit?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 4 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 4 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 4 }">
                            <p class="px-6 py-4 text-xs text-zinc-500 leading-relaxed">
                                Evaluators review 10 major areas: Mission/Goals, Faculty, Curriculum, Support to Students, Research, Extension/Community, Library, Physical Plant, Administration, and Quality Assurance.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden transition shadow-3xs">
                        <button type="button" @click="active === 5 ? active = null : active = 5" class="w-full px-6 py-4.5 flex items-center justify-between font-bold text-sm text-slate-800 hover:bg-slate-50 transition cursor-pointer select-none text-left gap-4">
                            <span>How frequently do university programs undergo quality audits?</span>
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': active === 5 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="transition-all duration-300 overflow-hidden" :style="active === 5 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-slate-100': active === 5 }">
                            <p class="px-6 py-4 text-xs text-zinc-500 leading-relaxed">
                                Programs typically undergo internal quality audits annually, while formal AACCUP survey visits occur every 3 to 5 years depending on the level of accreditation status granted.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Help Center Section -->
        <section id="help-center" class="w-full max-w-7xl mx-auto px-6 py-12 text-left mb-16 scroll-mt-6">
            <div class="bg-white border border-slate-200/60 rounded-3xl p-8 md:p-12 shadow-3xs flex flex-col gap-8">
                <!-- Header and Technical Support Button -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-100">
                    <div class="flex flex-col gap-2">
                        <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">RESOURCES &amp; SUPPORT</span>
                        <h3 class="text-2xl font-extrabold text-[#002B61]">Need assistance or guidance? We're here to help!</h3>
                        <p class="text-xs text-zinc-500 max-w-xl leading-relaxed">
                            Access official user manuals, download AACCUP accreditation guidelines, or get in touch with the system administration team.
                        </p>
                    </div>
                    <a href="mailto:bu-iqao@bicol-u.edu.ph" class="self-start md:self-center inline-flex items-center gap-2 px-6 py-3 bg-[#0056b3] hover:bg-[#004085] text-white font-bold rounded-xl transition shadow-md text-xs select-none">
                        <span>Get Support</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>

                <!-- Resources & System Support Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Guidelines Column -->
                    <div class="flex flex-col gap-4">
                        <span class="text-[10px] font-bold text-[#0056b3] uppercase tracking-wider">Guidelines &amp; Manuals</span>
                        <div class="flex flex-col gap-3">
                            <!-- Guideline Item 1 -->
                            <a href="#" class="group bg-[#f8fafc] hover:bg-slate-50 border border-slate-200/40 rounded-xl p-4.5 flex items-center justify-between transition cursor-pointer select-none">
                                <div>
                                    <span class="block text-[9px] text-zinc-400 font-bold uppercase tracking-wider">Lorem Ipsum</span>
                                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#f27224] transition">Lorem Ipsum Dolor</span>
                                    <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                                </div>
                                <svg class="w-5 h-5 text-zinc-400 group-hover:text-[#f27224] transition shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a><!-- Guideline Item 1 -->
                            <a href="#" class="group bg-[#f8fafc] hover:bg-slate-50 border border-slate-200/40 rounded-xl p-4.5 flex items-center justify-between transition cursor-pointer select-none">
                                <div>
                                    <span class="block text-[9px] text-zinc-400 font-bold uppercase tracking-wider">Lorem Ipsum</span>
                                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#f27224] transition">Lorem Ipsum Dolor</span>
                                    <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                                </div>
                                <svg class="w-5 h-5 text-zinc-400 group-hover:text-[#f27224] transition shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                            <!-- Guideline Item 1 -->
                            <a href="#" class="group bg-[#f8fafc] hover:bg-slate-50 border border-slate-200/40 rounded-xl p-4.5 flex items-center justify-between transition cursor-pointer select-none">
                                <div>
                                    <span class="block text-[9px] text-zinc-400 font-bold uppercase tracking-wider">Lorem Ipsum</span>
                                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#f27224] transition">Lorem Ipsum Dolor</span>
                                    <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                                </div>
                                <svg class="w-5 h-5 text-zinc-400 group-hover:text-[#f27224] transition shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- System Support Column -->
                    <div class="flex flex-col gap-4">
                        <span class="text-[10px] font-bold text-[#0056b3] uppercase tracking-wider">System Support Contacts</span>
                        <div class="flex flex-col gap-3">
                            <!-- Support Item 1 -->
                            <div class="bg-[#f8fafc] border border-slate-200/40 rounded-xl p-4.5 flex items-center justify-between">
                                <div>
                                    <span class="block text-[9px] text-zinc-400 font-bold uppercase tracking-wider">ICTO Help Desk &bull; System Issues</span>
                                    <span class="text-xs font-bold text-slate-800">ictohelpdesk@bicol-u.edu.ph</span>
                                </div>
                                <svg class="w-5 h-5 text-zinc-400 shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <!-- Support Item 2 -->
                            <div class="bg-[#f8fafc] border border-slate-200/40 rounded-xl p-4.5 flex items-center justify-between">
                                <div>
                                    <span class="block text-[9px] text-zinc-400 font-bold uppercase tracking-wider">IQA Office &bull; Quality Assurance</span>
                                    <span class="text-xs font-bold text-slate-800">bu-iqao@bicol-u.edu.ph</span>
                                </div>
                                <svg class="w-5 h-5 text-zinc-400 shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <!-- Support Item 3 -->
                            <div class="bg-[#f8fafc] border border-slate-200/40 rounded-xl p-4.5 flex items-center justify-between">
                                <div>
                                    <span class="block text-[9px] text-zinc-400 font-bold uppercase tracking-wider">ICTO Help Desk &bull; Globe Contact</span>
                                    <span class="text-xs font-bold text-slate-800">0956 225 3405</span>
                                </div>
                                <svg class="w-5 h-5 text-zinc-400 shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.94-6.94l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('partials.footer')
</x-layouts::html>