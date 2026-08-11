<!-- ================= SUBTAB: PROGRAM ACCREDITATION DOCUMENTS ================= -->
<div x-show="activeTab === 'program-accreditation'" x-transition class="flex flex-col gap-6">

    <!-- Breadcrumbs Nav for Program Accreditation -->
    @include('pages.documents.partials.program-accreditation.breadcrumbs')

    <!-- LEVEL 1: COLLEGE SELECTION UI -->
    @include('pages.documents.partials.program-accreditation.colleges-grid')

    <!-- LEVEL 2: PROGRAM SELECTION UI -->
    @include('pages.documents.partials.program-accreditation.programs-grid')

    <!-- LEVEL 3: ACCREDITATION SUB-CATEGORY SELECT -->
    @include('pages.documents.partials.program-accreditation.category-cards')

    <!-- LEVEL 4A: SUPPORTING DOCUMENTS WORKSPACE -->
    @include('pages.documents.partials.program-accreditation.supporting-docs')

    <!-- LEVEL 4B: SELF SURVEY VIEW -->
    @include('pages.documents.partials.program-accreditation.self-survey-matrix')

    <!-- LEVEL 4C: COMPLIANCE REPORTS VIEW & ADD PROGRAM MODAL -->
    @include('pages.documents.partials.program-accreditation.compliance-reports')

</div>
