<!-- ================= SUBTAB: COMMON DOCUMENTS ================= -->
<div x-show="activeTab === 'common-documents' || activeTab === 'common'" class="flex flex-col gap-6">
    <!-- State 0: Office Showcase Grid -->
    <?php echo $__env->make('pages.documents.partials.common-documents.office-grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- State 1: Category Showcase Grid -->
    <?php echo $__env->make('pages.documents.partials.common-documents.category-grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- State 2: Category Detail Document Table -->
    <?php echo $__env->make('pages.documents.partials.common-documents.document-table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Modal: Create New Category -->
    <?php echo $__env->make('pages.documents.partials.common-documents.create-category-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Modal: Upload Common Document -->
    <?php echo $__env->make('pages.documents.partials.common-documents.upload-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/partials/common-documents.blade.php ENDPATH**/ ?>