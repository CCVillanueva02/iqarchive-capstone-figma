<div class="w-full px-4 sm:px-8 py-6 flex flex-col gap-6 bg-surface-subtle min-h-screen font-sans">
    <!-- Header -->
    @include('livewire.configuration.partials.instruments.header')

    <!-- 3 Core Instrument Categories (Supporting Documents, Self-Survey, Compliance Reports) -->
    @include('livewire.configuration.partials.instruments.stats-bar')

    <!-- Main Workspace (Split Grid: Area/Parameter Tree Left, Criteria Editor Right) -->
    <div class="flex flex-col lg:flex-row gap-6 items-start w-full">
        <!-- Left: Area & Parameter Accordion -->
        @include('livewire.configuration.partials.instruments.area-accordion')

        <!-- Right: Parameter 4-Section Criteria Editor -->
        @include('livewire.configuration.partials.instruments.parameter-editor')
    </div>

    <!-- Modals Container -->
    @include('livewire.configuration.partials.instruments.modals')
</div>
