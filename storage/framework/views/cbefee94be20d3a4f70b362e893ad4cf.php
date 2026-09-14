
<div x-show="accredCategory === 'Compliance Reports' && (currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified)"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="flex flex-col gap-6 w-full">

    <!-- 1. Program Context Header & Action Bar -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.compliance-reports.context-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- 2. AACCUP 10-Area Selector Horizontal Cards (matches Institutional) -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.compliance-reports.area-tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- 3. Summary Statistics Bar (matches Institutional) -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.compliance-reports.stats-overview', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- 4. Area Recommendations & Action Plan Workspace (matches Institutional) -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.compliance-reports.recommendations-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- 5. AACCUP Certificates & Survey Audit Modal -->
    <?php echo $__env->make('pages.documents.partials.program-accreditation.compliance-reports.certificates-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/partials/program-accreditation/compliance-reports.blade.php ENDPATH**/ ?>