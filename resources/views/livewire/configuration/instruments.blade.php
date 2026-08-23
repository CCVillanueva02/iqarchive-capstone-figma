<div class="w-full px-4 sm:px-8 py-6 flex flex-col gap-6 bg-surface-subtle min-h-screen font-sans">
    <!-- Header -->
    @include('livewire.configuration.partials.instruments.header')

    <!-- 3 Core Instrument Categories (Supporting Documents, Self-Survey, Compliance Reports) -->
    @include('livewire.configuration.partials.instruments.stats-bar')

    @if ($selectedInstrument)
        <!-- Main Workspace (Split Grid: Area/Parameter Tree Left, Criteria Editor Right) -->
        <div class="flex flex-col lg:flex-row gap-6 items-start w-full">
            <!-- Left: Area & Parameter Accordion -->
            @include('livewire.configuration.partials.instruments.area-accordion')

            <!-- Right: Parameter 4-Section Criteria Editor -->
            @include('livewire.configuration.partials.instruments.parameter-editor')
        </div>
    @elseif ($selectedProgram)
        <!-- Program Custom Instrument Empty State with Clone CTA -->
        <div class="bg-white border border-slate-200/80 rounded-xl p-10 shadow-3xs flex flex-col items-center justify-center text-center max-w-2xl mx-auto my-6 gap-4">
            <div class="w-14 h-14 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            
            <div class="flex flex-col gap-1">
                <span class="text-label-xs font-extrabold px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-700 uppercase tracking-wider mx-auto">
                    {{ $selectedProgram->college->code ?? 'BU' }} &bull; {{ $selectedProgram->code }}
                </span>
                <h3 class="text-heading-sm font-extrabold text-primary mt-1">
                    No Custom Instrument for {{ $selectedProgram->name }}
                </h3>
                <p class="text-body-sm text-slate-500 max-w-lg mt-1 leading-relaxed">
                    This degree program currently follows the standard <strong>Master Template</strong>. You can clone the master template to tailor specific parameters, criteria statements, or evidence tags specifically for this program.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button"
                    wire:click="clearProgramFilter"
                    class="px-4 py-2.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-body-sm transition cursor-pointer">
                    Back to Master Template
                </button>
                <button type="button"
                    wire:click="cloneMasterForProgram"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-brand-orange hover:bg-brand-orange-hover text-white font-semibold text-body-sm shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                    </svg>
                    <span>Clone Master Instrument for this Program</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Modals Container -->
    @include('livewire.configuration.partials.instruments.modals')
</div>
