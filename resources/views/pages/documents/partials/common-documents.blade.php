<!-- ================= SUBTAB: COMMON DOCUMENTS ================= -->
<div x-show="activeTab === 'common-documents' || activeTab === 'common'" class="flex flex-col gap-6">
    <!-- State 1: Category Showcase Grid -->
    @include('pages.documents.partials.common-documents.category-grid')

    <!-- State 2: Category Detail Document Table -->
    @include('pages.documents.partials.common-documents.document-table')

    <!-- Modal: Create New Category -->
    @include('pages.documents.partials.common-documents.create-category-modal')

    <!-- Modal: Upload Common Document -->
    @include('pages.documents.partials.common-documents.upload-modal')
</div>
