<div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-3xs space-y-6">
    <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
        <div>
            <h3 class="text-sm font-bold text-zinc-900">Accreditation Compliance Reports</h3>
            <p class="text-xs text-zinc-500 mt-0.5">Summary of verified evidence documents and compliance status for <?php echo e($selectedProgram?->name ?? 'Program'); ?></p>
        </div>
        <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-semibold">
            <?php echo e($evidenceDocuments->where('status', 'Verified')->count()); ?> of <?php echo e($evidenceDocuments->count()); ?> Verified
        </span>
    </div>

    <!-- Compliance Document Table -->
    <?php if (isset($component)) { $__componentOriginal793d2b22631f88b8a3d00569a12acf88 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal793d2b22631f88b8a3d00569a12acf88 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.table','data' => ['headers' => ['Requirement / Title', 'Criterion Code', 'Status', 'Date', 'Action']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Requirement / Title', 'Criterion Code', 'Status', 'Date', 'Action'])]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $evidenceDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                $criterion = $doc->accreditationLinks->first()?->complianceRequirement?->criterion;
            ?>
            <tr class="hover:bg-zinc-50/80 transition-colors">
                <td class="py-3 px-6">
                    <div class="flex items-center gap-2.5">
                        <span class="px-2 py-0.5 rounded text-label-xs font-black <?php echo e($doc->file_extension === 'PDF' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-primary/10 text-primary border border-primary/20'); ?>">
                            <?php echo e($doc->file_extension ?? 'FILE'); ?>

                        </span>
                        <div>
                            <button wire:click="viewDocumentDetails(<?php echo e($doc->id); ?>)" class="text-xs font-bold text-zinc-900 hover:text-primary transition truncate block text-left">
                                <?php echo e($doc->title); ?>

                            </button>
                            <span class="text-label-xs text-zinc-400"><?php echo e($doc->file_size ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </td>

                <td class="py-3 px-6 text-xs font-semibold text-zinc-700">
                    <?php echo e($criterion?->code ?? 'General Benchmark'); ?>

                </td>

                <td class="py-3 px-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc->status === 'Verified'): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-label-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Verified
                        </span>
                    <?php elseif($doc->status === 'Pending'): ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-label-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                            Pending Review
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-label-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            <?php echo e($doc->status ?? 'Draft'); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>

                <td class="py-3 px-6 text-xs text-zinc-500">
                    <?php echo e($doc->created_at?->format('M d, Y') ?? '—'); ?>

                </td>

                <td class="py-3 px-6 text-right">
                    <button wire:click="viewDocumentDetails(<?php echo e($doc->id); ?>)" class="text-xs text-primary hover:underline font-semibold">
                        Review Details
                    </button>
                </td>
            </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="5" class="py-8 text-center text-zinc-400 text-xs">
                    No compliance documents attached for this program yet.
                </td>
            </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal793d2b22631f88b8a3d00569a12acf88)): ?>
<?php $attributes = $__attributesOriginal793d2b22631f88b8a3d00569a12acf88; ?>
<?php unset($__attributesOriginal793d2b22631f88b8a3d00569a12acf88); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal793d2b22631f88b8a3d00569a12acf88)): ?>
<?php $component = $__componentOriginal793d2b22631f88b8a3d00569a12acf88; ?>
<?php unset($__componentOriginal793d2b22631f88b8a3d00569a12acf88); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/livewire/documents/partials/program/compliance-reports.blade.php ENDPATH**/ ?>