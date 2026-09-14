

<div class="p-6 space-y-6">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$selectedOfficeId): ?>
        
        <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-surface-subtle border border-primary/10 flex items-center justify-center text-primary shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-primary">Select Administrative Office</h2>
                    <p class="text-sm text-zinc-500 mt-0.5">
                        Select a university office below to browse its document folders, policies, and official records.
                    </p>
                </div>
            </div>
            <div class="shrink-0">
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-slate-100 text-zinc-600 border border-slate-200 text-xs font-bold whitespace-nowrap">
                    Offices: <strong class="text-primary font-black"><?php echo e($offices->count()); ?></strong>
                </span>
            </div>
        </div>

        <!-- Search Bar for Offices -->
        <div class="relative w-full max-w-md">
            <input type="text"
                wire:model.live.debounce.250ms="officeSearch"
                placeholder="Search administrative office or code..."
                class="w-full text-xs border border-slate-200 rounded-xl pl-10 pr-4 py-3 bg-white text-zinc-800 placeholder-zinc-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-3xs transition" />
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <!-- Offices Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $offices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5 group">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-surface-subtle border border-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary/10 transition-colors">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <span class="text-label-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-zinc-600 border border-slate-200">
                                <?php echo e($office->documents_count); ?> Documents
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-primary group-hover:text-primary-hover transition mt-4">
                            <?php echo e($office->name); ?>

                        </h3>
                        <p class="text-xs text-zinc-500 mt-1">
                            <?php echo e($office->code ? 'Office Code: ' . $office->code : 'Central Administration'); ?>

                        </p>
                    </div>

                    <button type="button" wire:click="selectOffice(<?php echo e($office->id); ?>)"
                        class="w-full bg-primary hover:bg-primary-dark-hover text-white py-2.5 rounded-xl font-bold text-xs shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                        <span>Browse Categories</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-full bg-white rounded-2xl border border-zinc-200 p-12 text-center text-zinc-500 shadow-3xs">
                    No offices found matching your search.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

    <?php elseif(!$selectedCategoryName): ?>
        
        <!-- Search & Action Toolbar matching Image 3 -->
        <div class="bg-white border border-slate-200/60 rounded-xl p-4 shadow-3xs">
            <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                <div class="relative w-full max-w-md">
                    <input type="text"
                        wire:model.live.debounce.250ms="categorySearch"
                        placeholder="Search document categories..."
                        class="w-full text-xs border border-slate-200 rounded-lg pl-9 pr-3 py-2.5 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-slate-50/50" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <!-- Back to Offices Button -->
                    <button type="button" wire:click="clearOffice"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-3xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        <span>Back to Offices</span>
                    </button>

                    <!-- Upload Document Button -->
                    <button type="button" wire:click="openCommonUploadModal"
                        class="bg-brand-orange hover:bg-brand-orange-hover text-white text-xs font-bold px-4 py-2.5 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-3xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Upload Document</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 3-Column Folder Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div wire:click="selectCategory('<?php echo e($cat->name); ?>')"
                    class="bg-white border border-slate-200/90 rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:border-primary/30 hover:shadow-md cursor-pointer group">
                    <div>
                        <div class="flex items-start justify-between">
                            <!-- Folder Icon Container with Counter Badge -->
                            <div class="relative w-12 h-12 rounded-2xl bg-surface-subtle border border-primary/10 flex items-center justify-center shrink-0 transition-colors group-hover:bg-primary/10">
                                <svg class="w-6 h-6 text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <!-- Badge for Document Count -->
                                <div class="absolute -top-1.5 -right-1.5 w-5.5 h-5.5 rounded-full flex items-center justify-center text-label transition-colors shadow-2xs <?php echo e(($cat->docCount ?? 0) > 0 ? 'bg-primary text-white font-bold' : 'bg-slate-200 text-slate-500 font-semibold'); ?>">
                                    <span><?php echo e($cat->docCount ?? 0); ?></span>
                                </div>
                            </div>

                            <span class="text-label font-bold text-slate-400 tracking-wider uppercase mt-1 select-none">CATEGORY</span>
                        </div>

                        <h3 class="font-bold text-sm text-primary group-hover:text-brand-orange transition-colors mt-4">
                            <?php echo e($cat->name); ?>

                        </h3>
                        <p class="text-xs text-slate-500 mt-1 leading-normal">
                            <?php echo e($cat->description ?? 'Official administrative records and compliance files.'); ?>

                        </p>
                    </div>

                    <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-end">
                        <span class="text-xs font-bold text-brand-orange flex items-center gap-1.5 select-none transition-transform group-hover:translate-x-1">
                            <span>Open folder</span>
                            <span class="text-sm leading-none">&rarr;</span>
                        </span>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-full bg-white rounded-2xl border border-zinc-200 p-12 text-center text-zinc-500 shadow-3xs">
                    No categories found.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

    <?php else: ?>
        
        <!-- Navigation & Action Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-zinc-200 shadow-3xs">
            <div class="flex flex-wrap items-center gap-3 flex-1">
                <!-- Back to Categories Button -->
                <button type="button" wire:click="clearCategory"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3.5 py-2 rounded-lg flex items-center gap-1.5 transition cursor-pointer shadow-3xs mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    <span>Back to Categories</span>
                </button>

                <!-- Search Input -->
                <div class="relative w-full max-w-xs">
                    <input wire:model.live.debounce.300ms="searchQuery" type="text" placeholder="Search title or uploader..."
                        class="w-full pl-9 pr-3 py-1.5 text-xs bg-zinc-50 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-900 placeholder:text-zinc-400">
                    <svg class="w-4 h-4 text-zinc-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <!-- Status Filter -->
                <select wire:model.live="statusFilter" class="text-xs bg-zinc-50 border border-zinc-300 rounded-lg px-2.5 py-1.5 text-zinc-700 font-medium">
                    <option value="all">All Statuses</option>
                    <option value="Verified">Verified</option>
                    <option value="Pending">Pending</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            <!-- Upload Button -->
            <button wire:click="openCommonUploadModal" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-orange hover:bg-brand-orange-hover text-white text-xs font-semibold rounded-lg shadow-3xs transition shrink-0 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Upload Document</span>
            </button>
        </div>

        <!-- Documents Table -->
        <?php if (isset($component)) { $__componentOriginal793d2b22631f88b8a3d00569a12acf88 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal793d2b22631f88b8a3d00569a12acf88 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.table','data' => ['headers' => ['Document', 'Office / Category', 'Uploader', 'Status', 'Date', 'Actions'],'pagination' => $commonDocuments->hasPages() ? $commonDocuments->links() : null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Document', 'Office / Category', 'Uploader', 'Status', 'Date', 'Actions']),'pagination' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($commonDocuments->hasPages() ? $commonDocuments->links() : null)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $commonDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr class="hover:bg-zinc-50/80 transition-colors">
                    <!-- Document Info -->
                    <td class="py-3 px-6">
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-0.5 rounded text-label-xs font-black shrink-0 <?php echo e($doc->file_extension === 'PDF' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-primary/10 text-primary border border-primary/20'); ?>">
                                <?php echo e($doc->file_extension ?? 'PDF'); ?>

                            </span>
                            <div class="min-w-0 max-w-xs">
                                <button wire:click="viewDocumentDetails(<?php echo e($doc->id); ?>)" class="text-body-sm font-semibold text-zinc-900 hover:text-primary transition truncate block text-left">
                                    <?php echo e($doc->title); ?>

                                </button>
                                <span class="text-xs text-zinc-400"><?php echo e($doc->file_size ?? 'N/A'); ?></span>
                            </div>
                        </div>
                    </td>

                    <!-- Office / Category -->
                    <td class="py-3 px-6">
                        <div class="text-xs font-medium text-zinc-800"><?php echo e($doc->office?->name ?? 'General Office'); ?></div>
                        <div class="text-xs text-zinc-500"><?php echo e($doc->category?->name ?? 'Uncategorized'); ?></div>
                    </td>

                    <!-- Uploader -->
                    <td class="py-3 px-6">
                        <div class="text-xs text-zinc-700 font-medium"><?php echo e($doc->uploader?->full_name ?? 'System'); ?></div>
                    </td>

                    <!-- Status -->
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

                    <!-- Date -->
                    <td class="py-3 px-6 text-xs text-zinc-500">
                        <?php echo e($doc->created_at?->format('M d, Y') ?? '—'); ?>

                    </td>

                    <!-- Actions -->
                    <td class="py-3 px-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button wire:click="viewDocumentDetails(<?php echo e($doc->id); ?>)" class="p-1.5 text-zinc-500 hover:text-primary rounded-lg hover:bg-zinc-100 transition" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <a href="<?php echo e(Storage::disk('public')->url($doc->file_path)); ?>" target="_blank" class="p-1.5 text-zinc-500 hover:text-primary rounded-lg hover:bg-zinc-100 transition" title="Open File">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalaaf02fb0527142d03a30d716b5489b8d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaaf02fb0527142d03a30d716b5489b8d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.table-empty','data' => ['colSpan' => '6','title' => 'No documents found','message' => 'No common documents match your criteria.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.table-empty'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colSpan' => '6','title' => 'No documents found','message' => 'No common documents match your criteria.']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaaf02fb0527142d03a30d716b5489b8d)): ?>
<?php $attributes = $__attributesOriginalaaf02fb0527142d03a30d716b5489b8d; ?>
<?php unset($__attributesOriginalaaf02fb0527142d03a30d716b5489b8d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaaf02fb0527142d03a30d716b5489b8d)): ?>
<?php $component = $__componentOriginalaaf02fb0527142d03a30d716b5489b8d; ?>
<?php unset($__componentOriginalaaf02fb0527142d03a30d716b5489b8d); ?>
<?php endif; ?>
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
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/livewire/documents/partials/common-documents.blade.php ENDPATH**/ ?>