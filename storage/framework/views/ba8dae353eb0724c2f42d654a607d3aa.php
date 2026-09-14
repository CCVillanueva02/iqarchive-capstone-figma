<!-- Upload Evidence Modal (Step 5.2) -->
<div x-show="showUploadModal" 
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto" 
    style="display: none;" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div @click.away="closeUploadModal()" 
        class="bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden border border-slate-200/70"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-surface-subtle">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                </div>
                <div>
                    <h3 class="text-heading-sm font-bold text-primary">Upload & Link Evidence</h3>
                    <p class="text-label text-zinc-500 mt-0.5">Attach verifiable documentation to the accreditation checklist.</p>
                </div>
            </div>
            <button @click="closeUploadModal()" class="text-zinc-400 hover:text-zinc-600 transition cursor-pointer p-1">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-x'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            </button>
        </div>

        <!-- Target Context Banner -->
        <div class="px-6 py-3.5 bg-surface-subtle/60 border-b border-primary/10/80 flex flex-col gap-2">
            <div class="flex items-center gap-2 text-label-xs font-bold text-primary">
                <span class="px-2 py-0.5 bg-white border border-primary/15 rounded text-primary" x-text="activeArea?.code || 'Area'"></span>
                <span class="text-zinc-400">•</span>
                <span class="text-zinc-600" x-text="activeParam?.code + ' - ' + (activeParam?.title || '')"></span>
            </div>
            <div class="flex items-start gap-2 text-xs">
                <span class="font-bold text-primary bg-primary/10 px-2 py-0.5 rounded text-label-xs shrink-0" x-text="uploadForm.criterionCode || 'Criterion'"></span>
                <p class="text-xs text-zinc-700 font-medium leading-snug line-clamp-2" x-text="uploadForm.criterionStatement"></p>
            </div>
        </div>

        <!-- Modal Body Form -->
        <form @submit.prevent="submitEvidenceUpload()" class="p-6 flex flex-col gap-4">
            <!-- Document Title -->
            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Evidence Document Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                    x-model="uploadForm.title" 
                    required
                    placeholder="e.g. Board Resolution Approving VMGO Revision 2026"
                    class="w-full text-body-sm border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium" />
            </div>

            <!-- Required & Suggested Tags -->
            <div x-show="uploadForm.suggestedTags && uploadForm.suggestedTags.length > 0">
                <label class="block text-label font-bold text-zinc-500 mb-1.5 uppercase tracking-wider">
                    Suggested Tags (Click to include)
                </label>
                <div class="flex flex-wrap gap-1.5">
                    <template x-for="tag in uploadForm.suggestedTags" :key="tag">
                        <button type="button" 
                            @click="toggleUploadTag(tag)"
                            class="px-2.5 py-1 rounded-lg text-label-xs font-bold transition cursor-pointer flex items-center gap-1 border"
                            :class="uploadForm.selectedTags.includes(tag) ? 'bg-primary text-white border-primary shadow-3xs' : 'bg-slate-100 text-zinc-600 border-slate-200 hover:bg-slate-200'">
                            <span x-text="tag"></span>
                            <span x-show="uploadForm.selectedTags.includes(tag)">✓</span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Optional Description / Remarks -->
            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Remarks / Context Description (Optional)
                </label>
                <textarea x-model="uploadForm.description" 
                    rows="2" 
                    placeholder="Brief description or page reference for accreditors (e.g. See Section 4, pp. 12-15)..."
                    class="w-full text-body-sm border border-slate-200 rounded-xl px-4 py-2 bg-slate-50 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium"></textarea>
            </div>

            <!-- Drag & Drop File Upload Zone -->
            <div>
                <label class="block text-label font-bold text-zinc-600 mb-1.5 uppercase tracking-wider">
                    Attach Evidence File (PDF, DOCX, XLSX up to 50MB) <span class="text-rose-500">*</span>
                </label>
                
                <div class="border-2 border-dashed rounded-xl p-5 text-center transition flex flex-col items-center justify-center gap-2 cursor-pointer relative overflow-hidden"
                    :class="uploadForm.file ? 'border-emerald-300 bg-emerald-50/40' : 'border-slate-300 hover:border-primary bg-slate-50/50 hover:bg-slate-50'"
                    @dragover.prevent="$el.classList.add('border-primary')"
                    @dragleave.prevent="$el.classList.remove('border-primary')"
                    @drop.prevent="handleFileDrop($event)">
                    
                    <input type="file" 
                        x-ref="evidenceFileInput" 
                        @change="handleFileSelect($event)" 
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png,.zip" 
                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" />

                    <template x-if="!uploadForm.file">
                        <div class="flex flex-col items-center gap-1.5 pointer-events-none">
                            <div class="w-10 h-10 rounded-full bg-surface-subtle text-primary flex items-center justify-center">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-cloud-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-primary']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </div>
                            <span class="text-body-sm font-bold text-primary">Choose a file or drag & drop</span>
                            <span class="text-label-xs text-zinc-400">PDF, DOCX, XLSX, JPG, PNG up to 50MB</span>
                        </div>
                    </template>

                    <template x-if="uploadForm.file">
                        <div class="flex items-center justify-between w-full p-2 bg-white rounded-lg border border-emerald-200">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-emerald-600 shrink-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                <div class="text-left overflow-hidden">
                                    <span class="text-body-sm font-bold text-primary block truncate" x-text="uploadForm.file.name"></span>
                                    <span class="text-label-xs text-zinc-400" x-text="(uploadForm.file.size / 1048576).toFixed(2) + ' MB'"></span>
                                </div>
                            </div>
                            <button type="button" @click.stop="uploadForm.file = null; $refs.evidenceFileInput.value = ''" class="text-rose-500 hover:text-rose-700 p-1 transition cursor-pointer" title="Remove File">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-trash-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3 mt-1">
                <button type="button" 
                    @click="closeUploadModal()" 
                    class="px-4 py-2.5 rounded-xl text-body-sm font-bold text-zinc-600 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                    :disabled="isUploading || !uploadForm.file || !uploadForm.title"
                    class="px-5 py-2.5 rounded-xl text-body-sm font-bold text-white bg-primary hover:bg-primary-hover shadow-3xs transition cursor-pointer flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <template x-if="isUploading">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <template x-if="!isUploading">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    </template>
                    <span x-text="isUploading ? 'Uploading & Linking...' : 'Upload & Link Document'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/partials/program-accreditation/modals/upload-evidence-modal.blade.php ENDPATH**/ ?>