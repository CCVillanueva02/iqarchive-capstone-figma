<!-- ================= SUBTAB: INSTITUTIONAL ACCREDITATION DOCUMENTS ================= -->
<div x-show="activeTab === 'institutional-accreditation'" x-transition class="flex flex-col gap-6">

    <!-- Breadcrumbs Nav for Institutional Accreditation -->
    <?php echo $__env->make('pages.documents.partials.institutional-accreditation.breadcrumbs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 1: ACCREDITATION SUB-CATEGORY SELECT -->
    <?php echo $__env->make('pages.documents.partials.institutional-accreditation.category-cards', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 2A: SUPPORTING DOCUMENTS WORKSPACE -->
    <?php echo $__env->make('pages.documents.partials.institutional-accreditation.supporting-docs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 2B: SELF SURVEY VIEW -->
    <?php echo $__env->make('pages.documents.partials.institutional-accreditation.self-survey-matrix', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 2C: COMPLIANCE REPORTS VIEW -->
    <?php echo $__env->make('pages.documents.partials.institutional-accreditation.compliance-reports', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 2D: NARRATIVE PROFILE VIEW -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.narrative-profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- LEVEL 2E: PROGRAM PERFORMANCE PORTFOLIO (PPP) VIEW -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.ppp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/partials/institutional-accreditation.blade.php ENDPATH**/ ?>