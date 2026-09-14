

<section id="faq" class="w-full max-w-7xl mx-auto px-6 py-16 scroll-mt-6">
    <div class="max-w-4xl mx-auto flex flex-col gap-8">
        
        <div class="text-center flex flex-col items-center gap-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-zinc-100 border border-zinc-200 text-label-xs font-bold uppercase tracking-widest text-zinc-600">
                <svg class="w-3.5 h-3.5 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <span>Accreditation Guidelines &amp; Reference</span>
            </div>

            <h3 class="text-heading-lg font-extrabold text-primary-dark tracking-tight">
                Frequently Asked Questions
            </h3>

            <p class="text-body text-zinc-500 max-w-xl">
                Quick guidance on documentation audits, AACCUP survey standards, and IQA quality monitoring workflows.
            </p>
        </div>

        
        <div class="flex flex-col gap-3.5" x-data="{ active: 1 }">
            
            <div class="rounded-2xl transition-all duration-200 overflow-hidden border"
                 :class="active === 1 ? 'bg-white shadow-md border-zinc-300 ring-1 ring-zinc-950/5 border-l-4 border-l-brand-orange' : 'bg-white/80 border-zinc-200/80 hover:border-zinc-300'">
                <button type="button" @click="active === 1 ? active = null : active = 1"
                        class="w-full px-6 py-5 flex items-center justify-between font-bold text-body text-zinc-800 hover:text-primary transition cursor-pointer select-none text-left gap-4">
                    <span class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-brand-orange/10 text-brand-orange flex items-center justify-center text-label-xs font-black shrink-0">01</span>
                        <span>What is the primary role of the BU Internal Quality Assurance Office?</span>
                    </span>
                    <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200 shrink-0" :class="{ 'rotate-180 text-brand-orange': active === 1 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="transition-all duration-300 overflow-hidden" :style="active === 1 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-zinc-100': active === 1 }">
                    <p class="px-6 py-4.5 text-body-sm text-zinc-600 leading-relaxed pl-15">
                        The IQA Office oversees the planning, implementation, and monitoring of quality assurance policies at Bicol University, ensuring academic programs align with national and international accreditation standards.
                    </p>
                </div>
            </div>

            
            <div class="rounded-2xl transition-all duration-200 overflow-hidden border"
                 :class="active === 2 ? 'bg-white shadow-md border-zinc-300 ring-1 ring-zinc-950/5 border-l-4 border-l-brand-orange' : 'bg-white/80 border-zinc-200/80 hover:border-zinc-300'">
                <button type="button" @click="active === 2 ? active = null : active = 2"
                        class="w-full px-6 py-5 flex items-center justify-between font-bold text-body text-zinc-800 hover:text-primary transition cursor-pointer select-none text-left gap-4">
                    <span class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-brand-orange/10 text-brand-orange flex items-center justify-center text-label-xs font-black shrink-0">02</span>
                        <span>What is AACCUP accreditation and why is it essential?</span>
                    </span>
                    <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200 shrink-0" :class="{ 'rotate-180 text-brand-orange': active === 2 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="transition-all duration-300 overflow-hidden" :style="active === 2 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-zinc-100': active === 2 }">
                    <p class="px-6 py-4.5 text-body-sm text-zinc-600 leading-relaxed pl-15">
                        The Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP) evaluates programs to ensure quality education. BU programs undergo this to benchmark their performance, maintain high academic standards, and qualify for government support.
                    </p>
                </div>
            </div>

            
            <div class="rounded-2xl transition-all duration-200 overflow-hidden border"
                 :class="active === 3 ? 'bg-white shadow-md border-zinc-300 ring-1 ring-zinc-950/5 border-l-4 border-l-brand-orange' : 'bg-white/80 border-zinc-200/80 hover:border-zinc-300'">
                <button type="button" @click="active === 3 ? active = null : active = 3"
                        class="w-full px-6 py-5 flex items-center justify-between font-bold text-body text-zinc-800 hover:text-primary transition cursor-pointer select-none text-left gap-4">
                    <span class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-brand-orange/10 text-brand-orange flex items-center justify-center text-label-xs font-black shrink-0">03</span>
                        <span>How many levels of AACCUP accreditation exist, and what do they signify?</span>
                    </span>
                    <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200 shrink-0" :class="{ 'rotate-180 text-brand-orange': active === 3 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="transition-all duration-300 overflow-hidden" :style="active === 3 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-zinc-100': active === 3 }">
                    <p class="px-6 py-4.5 text-body-sm text-zinc-600 leading-relaxed pl-15">
                        There are four formal levels of accreditation: Level I (formal accreditation), Level II (re-accredited status), Level III (highly re-accredited with instruction and research excellence), and Level IV (outstanding institutional status benchmarked nationally).
                    </p>
                </div>
            </div>

            
            <div class="rounded-2xl transition-all duration-200 overflow-hidden border"
                 :class="active === 4 ? 'bg-white shadow-md border-zinc-300 ring-1 ring-zinc-950/5 border-l-4 border-l-brand-orange' : 'bg-white/80 border-zinc-200/80 hover:border-zinc-300'">
                <button type="button" @click="active === 4 ? active = null : active = 4"
                        class="w-full px-6 py-5 flex items-center justify-between font-bold text-body text-zinc-800 hover:text-primary transition cursor-pointer select-none text-left gap-4">
                    <span class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-brand-orange/10 text-brand-orange flex items-center justify-center text-label-xs font-black shrink-0">04</span>
                        <span>What are the 10 core areas assessed during an accreditation survey visit?</span>
                    </span>
                    <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200 shrink-0" :class="{ 'rotate-180 text-brand-orange': active === 4 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="transition-all duration-300 overflow-hidden" :style="active === 4 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-zinc-100': active === 4 }">
                    <p class="px-6 py-4.5 text-body-sm text-zinc-600 leading-relaxed pl-15">
                        Evaluators review 10 major areas: Area I (VMGO), Area II (Faculty), Area III (Curriculum), Area IV (Support to Students), Area V (Research), Area VI (Extension and Community), Area VII (Library), Area VIII (Physical Plant and Facilities), Area IX (Administration), and Area X (Quality Assurance).
                    </p>
                </div>
            </div>

            
            <div class="rounded-2xl transition-all duration-200 overflow-hidden border"
                 :class="active === 5 ? 'bg-white shadow-md border-zinc-300 ring-1 ring-zinc-950/5 border-l-4 border-l-brand-orange' : 'bg-white/80 border-zinc-200/80 hover:border-zinc-300'">
                <button type="button" @click="active === 5 ? active = null : active = 5"
                        class="w-full px-6 py-5 flex items-center justify-between font-bold text-body text-zinc-800 hover:text-primary transition cursor-pointer select-none text-left gap-4">
                    <span class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-brand-orange/10 text-brand-orange flex items-center justify-center text-label-xs font-black shrink-0">05</span>
                        <span>How frequently do university programs undergo quality audits?</span>
                    </span>
                    <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200 shrink-0" :class="{ 'rotate-180 text-brand-orange': active === 5 }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="transition-all duration-300 overflow-hidden" :style="active === 5 ? 'max-height: 300px;' : 'max-height: 0px;'" :class="{ 'border-t border-zinc-100': active === 5 }">
                    <p class="px-6 py-4.5 text-body-sm text-zinc-600 leading-relaxed pl-15">
                        Programs undergo internal quality audits annually, while formal AACCUP survey visits occur every 3 to 5 years depending on the level of accreditation status granted.
                    </p>
                </div>
            </div>
        </div>

        
        <div class="mt-4 p-6 rounded-3xl bg-surface-subtle border border-zinc-200/80 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-primary-dark text-white flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-body font-bold text-zinc-900">Have questions regarding accreditation submission?</h4>
                    <p class="text-label text-zinc-500 mt-0.5">Reach out to the Bicol University Internal Quality Assurance Office team directly.</p>
                </div>
            </div>
            <a href="mailto:bu-iqao@bicol-u.edu.ph" class="px-5 py-2.5 rounded-xl bg-white hover:bg-zinc-50 border border-zinc-300 text-body-sm font-bold text-zinc-800 shadow-2xs hover:border-zinc-400 transition shrink-0 select-none">
                Contact IQA Office
            </a>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/partials/landing/faq.blade.php ENDPATH**/ ?>