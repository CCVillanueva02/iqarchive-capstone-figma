<?php if (isset($component)) { $__componentOriginal81a506f898233b9e7d58286e6bea3c18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal81a506f898233b9e7d58286e6bea3c18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app','data' => ['title' => __('Documents')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Documents'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php
        $user = auth()->user();
        $userRole = $user->role;
        $canSeeCommonDocs = in_array($userRole, ['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);
        $canSeeInstitutionalDocs = in_array($userRole, ['iqa-staff', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);
        $isUnrestricted = in_array($userRole, ['iqa-staff', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);
        
        $userCollege = $user->college ? [
            'id' => $user->college->id,
            'name' => $user->college->name,
            'code' => $user->college->code,
            'campus' => $user->college->campus ?: 'BU Campus',
            'description' => $user->college->campus ?: 'BU Academic Unit',
            'programCount' => $user->college->programs()->count(),
        ] : null;

        $resolvedProgram = $user->program;
        if (!$resolvedProgram && ($user->hasRole('task-force-member') || $user->role === 'task-force-member')) {
            $tf = $user->taskForces()->whereNotNull('program_id')->first();
            $resolvedProgram = $tf?->program;
        }

        $latestAccred = $resolvedProgram ? $resolvedProgram->accreditations()->latest()->first() : null;
        $isInstrumentVerified = $latestAccred && in_array($latestAccred->status, [
            'document_preparation',
            'uploading',
            'ready_for_verification',
            'dean_verification',
            'submitted',
            'completed',
        ]);

        $userProgram = $resolvedProgram ? [
            'id' => $resolvedProgram->id,
            'name' => $resolvedProgram->name,
            'code' => $resolvedProgram->code,
            'college' => $resolvedProgram->college ? $resolvedProgram->college->name : '',
            'collegeCode' => $resolvedProgram->college ? $resolvedProgram->college->code : '',
            'college_id' => $resolvedProgram->college_id,
            'level' => $resolvedProgram->accreditation_level ?: 'Candidate Status',
            'accreditation_id' => $latestAccred?->id,
            'accreditation_status' => $latestAccred?->status ?? 'no_active_accreditation',
            'instrument_verified' => $isInstrumentVerified,
        ] : null;

        $defaultTab = $canSeeCommonDocs ? 'common-documents' : 'program-accreditation';
        $activeTab = request()->query('tab', $defaultTab);
        if (!$canSeeCommonDocs && $activeTab === 'common-documents') {
            $activeTab = 'program-accreditation';
        }
        if (!$canSeeInstitutionalDocs && $activeTab === 'institutional-accreditation') {
            $activeTab = 'program-accreditation';
        }
    ?>
    <div x-data="documentWorkspace({ 
        userId: <?php echo e($user->id); ?>, 
        userRole: '<?php echo e($userRole); ?>', 
        activeTab: '<?php echo e($activeTab); ?>',
        isUnrestricted: <?php echo e($isUnrestricted ? 'true' : 'false'); ?>,
        userCollege: <?php echo e($userCollege ? json_encode($userCollege) : 'null'); ?>,
        userProgram: <?php echo e($userProgram ? json_encode($userProgram) : 'null'); ?>

    })" class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen relative overflow-hidden">
        <?php echo $__env->make('pages.documents.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canSeeCommonDocs): ?>
        <?php echo $__env->make('pages.documents.partials.common-documents', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo $__env->make('pages.documents.partials.program-accreditation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canSeeInstitutionalDocs): ?>
        <?php echo $__env->make('pages.documents.partials.institutional-accreditation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo $__env->make('pages.documents.partials.detail-drawer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal81a506f898233b9e7d58286e6bea3c18)): ?>
<?php $attributes = $__attributesOriginal81a506f898233b9e7d58286e6bea3c18; ?>
<?php unset($__attributesOriginal81a506f898233b9e7d58286e6bea3c18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal81a506f898233b9e7d58286e6bea3c18)): ?>
<?php $component = $__componentOriginal81a506f898233b9e7d58286e6bea3c18; ?>
<?php unset($__componentOriginal81a506f898233b9e7d58286e6bea3c18); ?>
<?php endif; ?>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/index.blade.php ENDPATH**/ ?>