<div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-3xs space-y-6">
    <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
        <div>
            <h3 class="text-sm font-bold text-zinc-900">Program Self-Survey Matrix</h3>
            <p class="text-xs text-zinc-500 mt-0.5">Rate indicators on a 1-5 scale or NA (Not Applicable). Mean scores update automatically.</p>
        </div>
        <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-xs font-semibold">
            Program Scope: <?php echo e($selectedProgram?->name ?? 'Select Program'); ?>

        </span>
    </div>

    <!-- Rating Scale Legend -->
    <div class="grid grid-cols-2 sm:grid-cols-6 gap-2 bg-zinc-50 p-3 rounded-xl border border-zinc-200 text-center">
        <div class="text-label-xs font-medium text-zinc-600"><span class="font-bold text-zinc-900">5</span> - Excellent</div>
        <div class="text-label-xs font-medium text-zinc-600"><span class="font-bold text-zinc-900">4</span> - Very Good</div>
        <div class="text-label-xs font-medium text-zinc-600"><span class="font-bold text-zinc-900">3</span> - Good</div>
        <div class="text-label-xs font-medium text-zinc-600"><span class="font-bold text-zinc-900">2</span> - Fair</div>
        <div class="text-label-xs font-medium text-zinc-600"><span class="font-bold text-zinc-900">1</span> - Poor</div>
        <div class="text-label-xs font-medium text-zinc-600"><span class="font-bold text-zinc-900">NA</span> - Excluded</div>
    </div>

    <!-- Self-Survey Area Items (Using Active Area & Parameter) -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeParameter && $activeParameter->criteria->isNotEmpty()): ?>
        <div class="space-y-4">
            <div class="p-3 bg-primary/5 rounded-xl border border-primary/20 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-primary"><?php echo e($activeArea?->code); ?>: <?php echo e($activeParameter->code); ?></span>
                    <h4 class="text-xs font-bold text-zinc-900 mt-0.5"><?php echo e($activeParameter->name); ?></h4>
                </div>
                <div class="text-right">
                    <span class="text-label-xs uppercase font-bold text-zinc-400">Parameter Mean</span>
                    <p class="text-sm font-black text-primary">
                        <?php echo e($this->calculateParameterMean($activeParameter) ?? '—'); ?>

                    </p>
                </div>
            </div>

            <!-- Indicators List with Dropdown Rating -->
            <div class="divide-y divide-zinc-100 border border-zinc-200 rounded-xl overflow-hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeParameter->criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="p-4 bg-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <span class="px-2 py-0.5 rounded text-xs font-black bg-zinc-100 text-zinc-800 border border-zinc-200 shrink-0">
                                <?php echo e($crit->code); ?>

                            </span>
                            <p class="text-xs text-zinc-800 font-medium leading-relaxed"><?php echo e($crit->statement); ?></p>
                        </div>

                        <!-- Rating Selector -->
                        <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                            <label class="text-label-xs font-semibold text-zinc-500">Rating:</label>
                            <select wire:change="updateSurveyRating(<?php echo e($crit->id); ?>, $event.target.value)"
                                class="text-xs border border-zinc-300 rounded-lg px-2.5 py-1 bg-white text-zinc-800 font-bold focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                <option value="" <?php if(!isset($surveyRatings[$crit->id])): echo 'selected'; endif; ?>>Select</option>
                                <option value="NA" <?php if(($surveyRatings[$crit->id] ?? null) === 'NA'): echo 'selected'; endif; ?>>NA</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($i); ?>" <?php if(($surveyRatings[$crit->id] ?? null) === (string)$i): echo 'selected'; endif; ?>><?php echo e($i); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-12 text-zinc-400 text-xs">
            <p>Please select an area and parameter from Supporting Documents to evaluate the self-survey matrix.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/livewire/documents/partials/program/self-survey.blade.php ENDPATH**/ ?>