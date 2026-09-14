<!-- ================= SUBTAB: PROGRAM ACCREDITATION DOCUMENTS ================= -->
<div x-show="activeTab === 'program-accreditation'" x-transition class="flex flex-col gap-6">

    <!-- Breadcrumbs Nav for Program Accreditation -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.breadcrumbs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 1: COLLEGE SELECTION UI -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.colleges-grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 2: PROGRAM SELECTION UI -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.programs-grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 3: ACCREDITATION SUB-CATEGORY SELECT -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.category-cards', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 4A: SUPPORTING DOCUMENTS WORKSPACE -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.supporting-docs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 4B: SELF SURVEY VIEW -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.self-survey-matrix', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 4C: COMPLIANCE REPORTS VIEW & ADD PROGRAM MODAL -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.compliance-reports', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 4D: NARRATIVE PROFILE VIEW -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.narrative-profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 4E: PROGRAM PERFORMANCE PORTFOLIO (PPP) VIEW -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.ppp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- STEP 5 MODALS: EVIDENCE UPLOAD & SUBMISSION -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.modals.upload-evidence-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('pages.documents.partials.program-accreditation.modals.submit-to-dean-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/partials/program-accreditation.blade.php ENDPATH**/ ?>