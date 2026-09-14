

<section class="relative w-full max-w-7xl mx-auto px-6 py-12">
    <div class="relative w-full bg-gradient-to-br from-primary-dark via-primary to-primary-dark text-white rounded-[2.5rem] p-8 lg:p-14 shadow-2xl overflow-hidden border border-white/10">
        
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-brand-orange/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-primary-light/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col gap-10">
            
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-6 border-b border-white/10">
                <div class="max-w-2xl flex flex-col gap-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-label-xs font-bold uppercase tracking-widest text-brand-orange self-start">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0H9.496m5.004 0a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H9.496a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25" />
                        </svg>
                        <span>AACCUP Benchmark Distribution</span>
                    </div>

                    <h2 class="text-heading-lg lg:text-hero font-extrabold tracking-tight leading-[1.1] text-white">
                        Every accreditation, <span class="text-brand-orange">one verified record</span> away.
                    </h2>

                    <p class="text-body text-zinc-300 leading-relaxed">
                        IQArchive tracks <?php echo e($totalPrograms); ?> programs across Bicol University against rigorous AACCUP standards &mdash; from Candidate status to Level IV &mdash; so compliance evidence is always structured, verified, and ready for audit.
                    </p>
                </div>

                
                <div class="flex items-center gap-4 bg-white/5 border border-white/10 p-4 rounded-2xl backdrop-blur-sm self-start lg:self-auto">
                    <div class="w-12 h-12 rounded-xl bg-brand-orange/20 border border-brand-orange/40 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-heading font-extrabold text-white leading-none">
                            <?php echo e($totalAccredited); ?> <span class="text-body-sm font-normal text-zinc-400">/ <?php echo e($totalPrograms); ?></span>
                        </span>
                        <span class="text-label text-zinc-400 mt-1">Accredited Programs (<?php echo e($accreditationRate); ?>%)</span>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-4 gap-6">
                
                <div class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-orange/40 rounded-2xl p-5 backdrop-blur-sm transition-all duration-200 group flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-label font-bold uppercase tracking-wider text-brand-orange">Level IV</span>
                        <span class="px-2 py-0.5 rounded-full text-label-xs font-extrabold bg-brand-orange/20 text-brand-orange border border-brand-orange/30">
                            Highest
                        </span>
                    </div>
                    <div>
                        <div class="text-hero font-black text-white leading-none group-hover:scale-105 transition-transform duration-200 origin-left">
                            <?php echo e($levelIV); ?>

                        </div>
                        <div class="text-label text-zinc-400 mt-2">
                            Outstanding Institutional Impact
                        </div>
                    </div>
                </div>

                
                <div class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-orange/40 rounded-2xl p-5 backdrop-blur-sm transition-all duration-200 group flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-label font-bold uppercase tracking-wider text-amber-400">Level III</span>
                        <span class="px-2 py-0.5 rounded-full text-label-xs font-extrabold bg-amber-400/20 text-amber-300 border border-amber-400/30">
                            Re-Accredited
                        </span>
                    </div>
                    <div>
                        <div class="text-hero font-black text-white leading-none group-hover:scale-105 transition-transform duration-200 origin-left">
                            <?php echo e($levelIII); ?>

                        </div>
                        <div class="text-label text-zinc-400 mt-2">
                            Instruction &amp; Research Focus
                        </div>
                    </div>
                </div>

                
                <div class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-orange/40 rounded-2xl p-5 backdrop-blur-sm transition-all duration-200 group flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-label font-bold uppercase tracking-wider text-sky-400">Level II</span>
                        <span class="px-2 py-0.5 rounded-full text-label-xs font-extrabold bg-sky-400/20 text-sky-300 border border-sky-400/30">
                            Affirmed
                        </span>
                    </div>
                    <div>
                        <div class="text-hero font-black text-white leading-none group-hover:scale-105 transition-transform duration-200 origin-left">
                            <?php echo e($levelII); ?>

                        </div>
                        <div class="text-label text-zinc-400 mt-2">
                            Quality Standards Met
                        </div>
                    </div>
                </div>

                
                <div class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-brand-orange/40 rounded-2xl p-5 backdrop-blur-sm transition-all duration-200 group flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-label font-bold uppercase tracking-wider text-emerald-400">Level I / Cand.</span>
                        <span class="px-2 py-0.5 rounded-full text-label-xs font-extrabold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                            Progressing
                        </span>
                    </div>
                    <div>
                        <div class="text-hero font-black text-white leading-none group-hover:scale-105 transition-transform duration-200 origin-left">
                            <?php echo e($levelI + $candidate); ?>

                        </div>
                        <div class="text-label text-zinc-400 mt-2">
                            <?php echo e($levelI); ?> Level I &bull; <?php echo e($candidate); ?> Candidate
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-12 gap-8 items-center pt-4">
                
                <div class="col-span-12 lg:col-span-7 bg-primary/70 border border-white/10 rounded-3xl p-6 backdrop-blur-md">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-body-sm font-bold text-zinc-200 uppercase tracking-wider">
                            Accreditation Level Distribution
                        </span>
                        <span class="text-label-xs text-zinc-400 font-medium">
                            Live Database Metrics
                        </span>
                    </div>

                    <?php
                        $maxCount = max(1, $levelIV, $levelIII, $levelII, $levelI, $candidate);
                        $hIV = round(($levelIV / $maxCount) * 100);
                        $hIII = round(($levelIII / $maxCount) * 100);
                        $hII = round(($levelII / $maxCount) * 100);
                        $hI = round(($levelI / $maxCount) * 100);
                        $hCand = round(($candidate / $maxCount) * 100);
                    ?>

                    <div class="h-56 flex items-end justify-between gap-4 px-2 pt-4 pb-2">
                        
                        <div class="flex-1 flex flex-col items-center h-full justify-end group">
                            <div class="w-full bg-zinc-700/70 border border-zinc-500/30 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-125 shadow-md relative" style="height: <?php echo e(max(18, $hCand)); ?>%;">
                                <span class="text-body-sm font-bold text-white"><?php echo e($candidate); ?></span>
                            </div>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">Candidate</span>
                        </div>

                        
                        <div class="flex-1 flex flex-col items-center h-full justify-end group">
                            <div class="w-full bg-brand-orange-hover/80 border border-brand-orange/30 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-125 shadow-md relative" style="height: <?php echo e(max(18, $hI)); ?>%;">
                                <span class="text-body-sm font-bold text-white"><?php echo e($levelI); ?></span>
                            </div>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">Level I</span>
                        </div>

                        
                        <div class="flex-1 flex flex-col items-center h-full justify-end group">
                            <div class="w-full bg-brand-orange-hover border border-brand-orange/40 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-125 shadow-md relative" style="height: <?php echo e(max(18, $hII)); ?>%;">
                                <span class="text-body-sm font-bold text-white"><?php echo e($levelII); ?></span>
                            </div>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">Level II</span>
                        </div>

                        
                        <div class="flex-1 flex flex-col items-center h-full justify-end group">
                            <div class="w-full bg-brand-orange-hover border border-brand-orange/50 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-125 shadow-md relative" style="height: <?php echo e(max(18, $hIII)); ?>%;">
                                <span class="text-body-sm font-bold text-white"><?php echo e($levelIII); ?></span>
                            </div>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">Level III</span>
                        </div>

                        
                        <div class="flex-1 flex flex-col items-center h-full justify-end group">
                            <div class="w-full bg-brand-orange border border-amber-400 rounded-xl flex items-center justify-center font-bold text-white transition-all duration-300 group-hover:brightness-125 shadow-lg shadow-brand-orange/30 relative" style="height: <?php echo e(max(18, $hIV)); ?>%;">
                                <span class="text-body-sm font-bold text-white"><?php echo e($levelIV); ?></span>
                            </div>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider mt-3">Level IV</span>
                        </div>
                    </div>
                </div>

                
                <div class="col-span-12 lg:col-span-5 flex flex-col gap-4">
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-body-sm font-bold text-white">Overall Accreditation Index</span>
                            <span class="text-heading-sm font-extrabold text-brand-orange"><?php echo e($accreditationRate); ?>%</span>
                        </div>
                        <div class="w-full bg-white/10 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-500 to-brand-orange h-2.5 rounded-full transition-all duration-500" style="width: <?php echo e($accreditationRate); ?>%;"></div>
                        </div>
                        <p class="text-label text-zinc-400 mt-3 leading-relaxed">
                            <?php echo e($totalAccredited); ?> out of <?php echo e($totalPrograms); ?> active academic programs have formally attained Level I, II, III, or IV accreditation certificates.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <div class="text-label text-zinc-300">
                            <span class="font-bold text-white">Continuous Institutional Quality Monitoring</span>
                            <br>Synchronized across 10 colleges and specialized campuses.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/partials/landing/metrics.blade.php ENDPATH**/ ?>