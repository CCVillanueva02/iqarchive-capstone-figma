<!-- Main Dean Verification Shell (Step 6) -->
<div class="w-full px-6 lg:px-10 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- Header Section -->
    @include('livewire.college-head.partials.verification.header')

    <!-- Verification Stats KPI Bar -->
    @include('livewire.college-head.partials.verification.stats-bar')

    <!-- Horizontal Area I-X Selector Tabs -->
    @include('livewire.college-head.partials.verification.area-tabs')

    <!-- Criteria & Document Review Workspace -->
    @include('livewire.college-head.partials.verification.checklist-review')

    <!-- Modals -->
    @include('livewire.college-head.partials.verification.modals.flag-revision-modal')
    @include('livewire.college-head.partials.verification.modals.request-revisions-modal')
    @include('livewire.college-head.partials.verification.modals.submit-to-iqa-modal')
</div>
