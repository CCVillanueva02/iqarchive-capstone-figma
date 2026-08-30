<div class="px-6 py-8 w-full min-h-screen bg-surface-subtle flex flex-col gap-6">
    <!-- Header & Subtab Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-heading-lg font-bold text-primary-dark tracking-tight leading-none">
                Accreditation Monitoring
            </h1>
            <p class="text-body-sm text-primary-muted mt-1">
                Institutional tracker for AACCUP Technical Reviews, Program Status, and Board Actions.
            </p>
        </div>

    </div>

    <!-- Active Tab Views -->
    @if($tab === 'dashboard')
        @include('livewire.monitoring.partials.dashboard-tab')
    @elseif($tab === 'summary')
        @include('livewire.monitoring.partials.summary-tab')
    @elseif($tab === 'programs')
        @include('livewire.monitoring.partials.programs-tab')
    @endif

    <!-- Program Survey History Modal -->
    @include('livewire.monitoring.partials.history-modal')
</div>
