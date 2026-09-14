<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showEvidenceUploadModal): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="evidence-modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-zinc-900/40 backdrop-blur-xs transition-opacity" wire:click="closeEvidenceUploadModal"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-zinc-200">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900" id="evidence-modal-title">Upload Program Evidence</h3>
                        <p class="text-xs text-zinc-500 mt-0.5">Program: <?php echo e($selectedProgram?->name); ?></p>
                    </div>
                    <button wire:click="closeEvidenceUploadModal" class="text-zinc-400 hover:text-zinc-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Form Body -->
                <form wire:submit="uploadEvidenceDocument" class="p-6 space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($evidenceCriterionCode): ?>
                        <div class="p-3 bg-primary/5 rounded-xl border border-primary/20 flex items-center justify-between">
                            <div>
                                <span class="text-label-xs font-bold uppercase tracking-wider text-primary">Target Benchmark</span>
                                <p class="text-xs font-bold text-zinc-900">Criterion: <?php echo e($evidenceCriterionCode); ?></p>
                            </div>
                            <span class="text-label-xs bg-primary/10 text-primary font-bold px-2 py-0.5 rounded">Linked</span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- File Input -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 mb-1">Evidence File (PDF, DOCX, XLSX up to 25MB)</label>
                        <input type="file" wire:model="evidenceFile" class="block w-full text-xs text-zinc-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer border border-zinc-300 rounded-lg p-1.5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['evidenceFile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div wire:loading wire:target="evidenceFile" class="text-xs text-primary mt-1 font-medium">Uploading file preview...</div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 mb-1">Evidence Title</label>
                        <input type="text" wire:model="evidenceTitle" placeholder="e.g. Faculty Syllabi Compliance Audit 2026" class="w-full text-xs px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-900">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['evidenceTitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-700 mb-1">Verification Remarks / Annotation (Optional)</label>
                        <textarea wire:model="evidenceDescription" rows="2" placeholder="Provide context on how this file fulfills the accreditation benchmark..." class="w-full text-xs px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-900"></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['evidenceDescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-3 border-t border-zinc-100 flex items-center justify-end gap-2">
                        <button type="button" wire:click="closeEvidenceUploadModal" class="px-4 py-2 text-xs font-semibold text-zinc-600 hover:bg-zinc-100 rounded-lg transition">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 transition shadow-sm flex items-center gap-1.5">
                            <span wire:loading.remove wire:target="uploadEvidenceDocument">Submit Evidence</span>
                            <span wire:loading wire:target="uploadEvidenceDocument">Submitting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/livewire/documents/partials/modals/upload-evidence-modal.blade.php ENDPATH**/ ?>