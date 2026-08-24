{{--
    LEVEL 3C / 4C: PROGRAM ACCREDITATION COMPLIANCE & ACCREDITATION REPORTS
    
    Security & Authorization Context:
    - Access to program-level compliance reports and supporting evidence is gated
      by role-based permissions (IQA Staff, College Heads, Task Force Members, Accreditors, SysAdmin).
    - Exhibits and certificates are previewed through the secured document slide-over drawer
      with audit-logging of preview actions.
--}}
<div x-show="accredCategory === 'Compliance Reports' && (currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified)"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="flex flex-col gap-6 w-full">

    <!-- 1. Program Context Header & Action Bar -->
    @include('pages.documents.partials.program-accreditation.compliance-reports.context-header')

    <!-- 2. AACCUP 10-Area Selector Horizontal Cards (matches Institutional) -->
    @include('pages.documents.partials.program-accreditation.compliance-reports.area-tabs')

    <!-- 3. Summary Statistics Bar (matches Institutional) -->
    @include('pages.documents.partials.program-accreditation.compliance-reports.stats-overview')

    <!-- 4. Area Recommendations & Action Plan Workspace (matches Institutional) -->
    @include('pages.documents.partials.program-accreditation.compliance-reports.recommendations-list')

    <!-- 5. AACCUP Certificates & Survey Audit Modal -->
    @include('pages.documents.partials.program-accreditation.compliance-reports.certificates-modal')

</div>
