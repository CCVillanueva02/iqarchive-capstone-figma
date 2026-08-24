<div class="w-full px-4 sm:px-8 py-6 flex flex-col gap-6 bg-surface-subtle min-h-screen font-sans">
    <!-- Top Header: Title, Status, Back button, and Finalize CTA -->
    @include('livewire.college-head.partials.instrument.header')

    <!-- 3 Core Instrument Categories (Supporting Documents, Self-Survey, Compliance Reports) & Metadata Bar -->
    @include('livewire.college-head.partials.instrument.stats-bar')

    @if ($selectedInstrument)
    <!-- Main Workspace (Split Grid: Area/Parameter Tree Left, Benchmark Criteria Editor Right) -->
    <div class="flex flex-col lg:flex-row gap-6 items-start w-full">
        <!-- Left Pane: Area & Parameter Accordion Tree -->
        @include('livewire.college-head.partials.instrument.area-accordion')

        <!-- Right Pane: 4-Section Benchmark Criteria Editor with #EvidenceTags -->
        @include('livewire.college-head.partials.instrument.parameter-editor')
    </div>
    @endif

    <!-- Modals Container -->
    @include('livewire.college-head.partials.instrument.modals')
</div>
