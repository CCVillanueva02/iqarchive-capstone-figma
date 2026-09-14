<div class="space-y-6">
    <!-- Area Navigation Strip -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($instrument && $instrument->areas->isNotEmpty()): ?>
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $instrument->areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <button wire:click="selectArea(<?php echo e($area->id); ?>)"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all border shrink-0 flex items-center gap-2 <?php echo e($activeAreaId === $area->id ? 'bg-primary text-white border-primary shadow-xs' : 'bg-white text-zinc-700 border-zinc-200 hover:border-zinc-300 hover:bg-zinc-50'); ?>">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-label-xs <?php echo e($activeAreaId === $area->id ? 'bg-white/20 text-white' : 'bg-zinc-100 text-zinc-600'); ?>">
                        <?php echo e($loop->iteration); ?>

                    </span>
                    <span><?php echo e($area->code); ?>: <?php echo e(Str::limit($area->name, 24)); ?></span>
                </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Main Workspace Grid: Parameters Sidebar + Evidence Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Parameters Navigation Sidebar -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-zinc-200 shadow-3xs p-4 space-y-3">
            <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-500">Parameters</h3>
                <span class="text-xs font-semibold text-primary bg-primary/10 px-2 py-0.5 rounded">
                    <?php echo e($activeArea?->code ?? 'Area'); ?>

                </span>
            </div>

            <div class="space-y-1.5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeArea && $activeArea->parameters->isNotEmpty()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeArea->parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <button wire:click="selectParameter(<?php echo e($param->id); ?>)"
                            class="w-full text-left p-3 rounded-xl text-xs font-semibold transition-all border <?php echo e($activeParameterId === $param->id ? 'bg-primary/5 text-primary border-primary/30 shadow-xs' : 'text-zinc-700 border-transparent hover:bg-zinc-50 hover:border-zinc-200'); ?>">
                            <div class="flex items-center justify-between">
                                <span class="font-bold"><?php echo e($param->code); ?></span>
                                <span class="text-label-xs text-zinc-400"><?php echo e($param->criteria->count()); ?> criteria</span>
                            </div>
                            <p class="text-label-xs font-normal text-zinc-600 mt-1 line-clamp-2"><?php echo e($param->name); ?></p>
                        </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php else: ?>
                    <p class="text-xs text-zinc-400 py-4 text-center">No parameters found for this area.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Evidence & Criteria Panel -->
        <div class="lg:col-span-8 space-y-4">
            <!-- Section Tabs Bar (Systems, Implementation, Outcomes) -->
            <div class="flex items-center gap-2 border-b border-zinc-200 pb-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['systems' => 'Systems', 'implementation' => 'Implementation', 'outcomes' => 'Outcomes', 'best_practices' => 'Best Practices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sKey => $sLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <button wire:click="selectSection('<?php echo e($sKey); ?>')"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors <?php echo e($activeSection === $sKey ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100'); ?>">
                        <?php echo e($sLabel); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <!-- Active Criteria & Upload Triggers -->
            <?php
                $criteria = match($activeSection) {
                    'systems' => $activeParameter?->systemsCriteria ?? collect(),
                    'implementation' => $activeParameter?->implementationCriteria ?? collect(),
                    'outcomes' => $activeParameter?->outcomesCriteria ?? collect(),
                    default => $activeParameter?->bestPracticesCriteria ?? collect(),
                };
            ?>

            <div class="space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="bg-white rounded-xl border border-zinc-200 p-4 shadow-3xs space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-2.5">
                                <span class="px-2 py-0.5 rounded text-xs font-black bg-zinc-100 text-zinc-800 border border-zinc-200 shrink-0">
                                    <?php echo e($crit->code); ?>

                                </span>
                                <div>
                                    <p class="text-xs font-bold text-zinc-900"><?php echo e($crit->statement); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($crit->description): ?>
                                        <p class="text-xs text-zinc-500 mt-0.5"><?php echo e($crit->description); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <button wire:click="openEvidenceUploadModal(<?php echo e($crit->id); ?>, '<?php echo e($crit->code); ?>')"
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-primary/10 text-primary hover:bg-primary/20 text-xs font-semibold shrink-0 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Attach Evidence
                            </button>
                        </div>

                        <!-- Attached Evidence Documents for this Criterion -->
                        <?php
                            $attachedDocs = $evidenceDocuments->filter(function($doc) use ($crit) {
                                return $doc->accreditationLinks->contains(fn($link) => $link->complianceRequirement?->instrument_criterion_id === $crit->id);
                            });
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attachedDocs->isNotEmpty()): ?>
                            <div class="pt-2 border-t border-zinc-100 space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $attachedDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal4f0b892a331780fdf32b35e36b0aa151 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4f0b892a331780fdf32b35e36b0aa151 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.document-chip','data' => ['title' => $adoc->title,'size' => $adoc->file_size,'type' => $adoc->file_extension,'date' => $adoc->created_at?->format('M d, Y'),'uploader' => $adoc->uploader?->full_name,'status' => $adoc->status,'downloadUrl' => Storage::url($adoc->file_path),'wire:click' => 'viewDocumentDetails('.e($adoc->id).')','class' => 'cursor-pointer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.document-chip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($adoc->title),'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($adoc->file_size),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($adoc->file_extension),'date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($adoc->created_at?->format('M d, Y')),'uploader' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($adoc->uploader?->full_name),'status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($adoc->status),'downloadUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Storage::url($adoc->file_path)),'wire:click' => 'viewDocumentDetails('.e($adoc->id).')','class' => 'cursor-pointer']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4f0b892a331780fdf32b35e36b0aa151)): ?>
<?php $attributes = $__attributesOriginal4f0b892a331780fdf32b35e36b0aa151; ?>
<?php unset($__attributesOriginal4f0b892a331780fdf32b35e36b0aa151); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4f0b892a331780fdf32b35e36b0aa151)): ?>
<?php $component = $__componentOriginal4f0b892a331780fdf32b35e36b0aa151; ?>
<?php unset($__componentOriginal4f0b892a331780fdf32b35e36b0aa151); ?>
<?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <!-- Fallback: Display general uploaded documents for this program -->
                    <div class="bg-white rounded-xl border border-zinc-200 p-6 text-center shadow-3xs">
                        <p class="text-xs text-zinc-500">No specific benchmark criteria configured for this section.</p>
                        <button wire:click="openEvidenceUploadModal" class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Upload General Program Evidence
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/livewire/documents/partials/program/supporting-documents.blade.php ENDPATH**/ ?>