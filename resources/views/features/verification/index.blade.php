<!-- Main Dean Verification Shell (Step 6 Quality Review) -->
<div class="w-full px-6 lg:px-10 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- Header Section -->
    @include('features.verification.partials.header')

    <!-- Verification Stats KPI Bar -->
    @include('features.verification.partials.stats-bar')

    <!-- Horizontal Area I-X Selector Tabs -->
    @include('features.verification.partials.area-tabs')

    <!-- Criteria & Document Review Workspace -->
    @include('features.verification.partials.checklist-review')

    <!-- Standardized Modals (Flag, Request Revisions, Submit to IQA) -->
    @include('features.verification.partials.modals')
</div>
