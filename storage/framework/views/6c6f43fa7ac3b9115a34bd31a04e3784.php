

<section class="relative w-full max-w-7xl mx-auto px-6 pt-12 pb-16 lg:py-20">
    
    <div class="absolute -top-16 left-1/4 w-96 h-96 bg-brand-orange/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-20 right-10 w-96 h-96 bg-primary-light/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="grid grid-cols-12 gap-12 lg:gap-16 items-center">
        
        <div class="col-span-12 lg:col-span-7 flex flex-col items-start text-left">
            
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-orange/10 border border-brand-orange/30 shadow-2xs mb-6 group cursor-default">
                <span class="w-2 h-2 rounded-full bg-brand-orange animate-pulse"></span>
                <span class="text-label font-extrabold uppercase tracking-widest text-brand-orange-hover">
                    Bicol University &bull; Internal Quality Assurance Office
                </span>
            </div>

            
            <h1 class="text-hero font-extrabold text-primary-dark tracking-tight leading-[1.08] mb-6">
                A Unified Document &amp; Monitoring System for
                <span class="relative inline-block text-transparent bg-clip-text bg-gradient-to-r from-brand-orange to-amber-600">
                    Quality Assurance
                </span>
            </h1>

            
            <p class="text-heading-sm text-zinc-600 font-normal leading-relaxed max-w-2xl mb-8">
                Centralize institutional accreditation archives, verify multi-program compliance in real time, and streamline AACCUP survey readiness across Bicol University colleges.
            </p>

            
            <div class="flex items-center gap-4 mb-10">
                <a href="<?php echo e(route('login')); ?>"
                   class="group relative inline-flex items-center gap-3 px-7 py-3.5 bg-brand-orange hover:bg-brand-orange-hover text-white text-body font-bold rounded-xl shadow-lg shadow-brand-orange/25 hover:shadow-brand-orange/40 hover:-translate-y-0.5 transition-all duration-200 select-none">
                    <span>Access IQA Portal</span>
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>

                <a href="#faq"
                   class="inline-flex items-center gap-2 px-6 py-3.5 bg-white hover:bg-zinc-50 border border-zinc-300 hover:border-zinc-400 text-zinc-700 font-bold rounded-xl shadow-xs text-body transition-all duration-150 select-none">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    <span>Browse FAQ</span>
                </a>
            </div>

            
            <div class="w-full max-w-xl pt-6 border-t border-zinc-200/80 grid grid-cols-3 gap-6">
                <div>
                    <div class="text-heading font-extrabold text-primary-dark tracking-tight">
                        <?php echo e($totalPrograms); ?>

                    </div>
                    <div class="text-label text-zinc-500 font-medium mt-0.5">
                        Academic Programs
                    </div>
                </div>

                <div>
                    <div class="text-heading font-extrabold text-brand-orange tracking-tight">
                        <?php echo e($accreditationRate); ?>%
                    </div>
                    <div class="text-label text-zinc-500 font-medium mt-0.5">
                        Accreditation Rate
                    </div>
                </div>

                <div>
                    <div class="text-heading font-extrabold text-emerald-600 tracking-tight flex items-center gap-1.5">
                        <span>10 / 10</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    </div>
                    <div class="text-label text-zinc-500 font-medium mt-0.5">
                        AACCUP Survey Areas
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-span-12 lg:col-span-5 relative">
            
            <div class="absolute -inset-2 bg-gradient-to-tr from-brand-orange/25 to-primary-light/25 rounded-3xl blur-xl opacity-70"></div>

            
            <div class="relative bg-white/95 backdrop-blur-xl border border-zinc-200/80 rounded-3xl p-6 shadow-2xl ring-1 ring-zinc-950/5 flex flex-col gap-5">
                
                <div class="flex items-center justify-between pb-4 border-b border-zinc-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        <span class="ml-2 text-label font-bold text-zinc-500 uppercase tracking-wider">
                            BU-IQA Matrix Ledger
                        </span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-label-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Live Sync
                    </span>
                </div>

                
                <div class="flex items-center gap-2 bg-zinc-100/80 p-1 rounded-xl text-label font-semibold text-zinc-600">
                    <div class="flex-1 py-1.5 px-3 rounded-lg bg-white shadow-2xs text-primary-dark font-bold text-center">
                        Accreditation Status
                    </div>
                    <div class="flex-1 py-1.5 px-3 rounded-lg hover:text-zinc-900 text-center cursor-default">
                        Evidence Vault
                    </div>
                    <div class="flex-1 py-1.5 px-3 rounded-lg hover:text-zinc-900 text-center cursor-default">
                        Compliance Audit
                    </div>
                </div>

                
                <div class="flex flex-col gap-3">
                    
                    <div class="p-3.5 rounded-2xl bg-surface-subtle border border-zinc-200/60 flex items-center justify-between hover:border-zinc-300 transition-colors">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-body-sm font-bold text-zinc-900">BS in Computer Science</span>
                            <span class="text-label-xs text-zinc-500">College of Science &bull; 10 Areas Audited</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-label-xs font-extrabold uppercase tracking-wide bg-amber-500/10 text-brand-orange-hover border border-brand-orange/20">
                                Level IV
                            </span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </div>
                    </div>

                    
                    <div class="p-3.5 rounded-2xl bg-surface-subtle border border-zinc-200/60 flex items-center justify-between hover:border-zinc-300 transition-colors">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-body-sm font-bold text-zinc-900">BS in Nursing</span>
                            <span class="text-label-xs text-zinc-500">College of Nursing &bull; Self-Survey Verified</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-label-xs font-extrabold uppercase tracking-wide bg-primary/10 text-primary-light border border-primary/20">
                                Level III
                            </span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </div>
                    </div>

                    
                    <div class="p-3.5 rounded-2xl bg-surface-subtle border border-zinc-200/60 flex items-center justify-between hover:border-zinc-300 transition-colors">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-body-sm font-bold text-zinc-900">Bachelor of Elementary Education</span>
                            <span class="text-label-xs text-zinc-500">College of Education &bull; Re-Accredited</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-label-xs font-extrabold uppercase tracking-wide bg-amber-500/10 text-brand-orange-hover border border-brand-orange/20">
                                Level IV
                            </span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </div>
                    </div>
                </div>

                
                <div class="pt-2 flex items-center justify-between text-label-xs text-zinc-500">
                    <div class="flex items-center gap-1.5 font-medium">
                        <svg class="w-3.5 h-3.5 text-primary-muted" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        <span>SHA-256 Audit Trail Protection</span>
                    </div>
                    <span class="font-bold text-primary tracking-wider uppercase">AACCUP Synchronized</span>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/partials/landing/hero.blade.php ENDPATH**/ ?>