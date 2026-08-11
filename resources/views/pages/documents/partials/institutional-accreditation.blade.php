<!-- ================= SUBTAB: INSTITUTIONAL ACCREDITATION DOCUMENTS ================= -->
<div x-show="activeTab === 'institutional-accreditation'" x-transition class="flex flex-col gap-6">

    <!-- Breadcrumbs Nav for Institutional Accreditation -->
    @include('pages.documents.partials.institutional-accreditation.breadcrumbs')

    <!-- LEVEL 1: ACCREDITATION SUB-CATEGORY SELECT -->
    @include('pages.documents.partials.institutional-accreditation.category-cards')

    <!-- LEVEL 2A: SUPPORTING DOCUMENTS WORKSPACE -->
    @include('pages.documents.partials.institutional-accreditation.supporting-docs')

    <!-- LEVEL 2B: SELF SURVEY VIEW -->
    @include('pages.documents.partials.institutional-accreditation.self-survey-matrix')

    <!-- LEVEL 2C: COMPLIANCE REPORTS VIEW -->
    @include('pages.documents.partials.institutional-accreditation.compliance-reports')

</div>
