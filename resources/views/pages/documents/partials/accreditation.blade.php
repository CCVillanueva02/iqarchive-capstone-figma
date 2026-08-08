<!-- ================= TAB: ACCREDITATION ================= -->
<div x-show="activeTab === 'accreditation'" x-transition class="flex flex-col gap-6">

    <!-- Breadcrumbs Nav for Accreditation -->
    @include('pages.documents.partials.accreditation.breadcrumbs')

    <!-- LEVEL 1: ACCREDITATION LEVEL SELECT -->
    @include('pages.documents.partials.accreditation.level-select')

    <!-- LEVEL 1.5: COLLEGE SELECTION UI -->
    @include('pages.documents.partials.accreditation.colleges-grid')

    <!-- LEVEL 1.6: PROGRAM SELECTION UI -->
    @include('pages.documents.partials.accreditation.programs-grid')

    <!-- LEVEL 2: ACCREDITATION SUB-CATEGORY SELECT -->
    @include('pages.documents.partials.accreditation.category-cards')

    <!-- LEVEL 3A: SUPPORTING DOCUMENTS WORKSPACE -->
    @include('pages.documents.partials.accreditation.supporting-docs')

    <!-- LEVEL 3B: SELF SURVEY VIEW -->
    @include('pages.documents.partials.accreditation.self-survey-matrix')

    <!-- LEVEL 3C: COMPLIANCE REPORTS VIEW & ADD PROGRAM MODAL -->
    @include('pages.documents.partials.accreditation.compliance-reports')

</div>