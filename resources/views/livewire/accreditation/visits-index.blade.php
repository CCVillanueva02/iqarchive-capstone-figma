<div class="w-full px-6 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- Header Banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-heading-lg font-bold text-primary-dark tracking-tight leading-none">
                        Accreditation Visits
                    </h1>
                    <p class="text-body-sm text-primary-muted mt-1">
                        Record, schedule, and track end-to-end accreditation visit preparation and milestones.
                    </p>
                </div>
            </div>
        </div>

        @if(in_array(auth()->user()->role ?? '', ['iqa-staff', 'iqa-admin', 'system-administrator']))
        <div>
            <button x-on:click="$flux.modal('schedule-accreditation').show()" class="bg-brand-orange text-white text-body-sm px-4 py-2.5 rounded-xl shadow-xs hover:bg-brand-orange-hover flex items-center gap-2 font-semibold transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Record New Visit</span>
            </button>
        </div>
        @endif
    </div>

    <!-- 1. Stats Bar Partial -->
    @include('livewire.accreditation.partials.stats-bar')

    <!-- 2. Search and Filter Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="w-full sm:max-w-md">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by program name, code, or college..." icon="magnifying-glass" />
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400">Filter Stage:</span>
            <flux:select wire:model.live="statusFilter" size="sm" class="min-w-40">
                <flux:select.option value="all">All Stages</flux:select.option>
                <flux:select.option value="scheduled">Scheduled / TF Setup</flux:select.option>
                <flux:select.option value="in_progress">In Active Preparation</flux:select.option>
                <flux:select.option value="completed">Completed / Submitted</flux:select.option>
                <flux:select.option value="cancelled">Cancelled</flux:select.option>
            </flux:select>
        </div>
    </div>

    <!-- 3. Table Partial -->
    @include('livewire.accreditation.partials.table')

    <!-- 4. Interactive Timeline Drawer Modal Partial -->
    @include('livewire.accreditation.partials.timeline-modal')

    <!-- 5. Schedule Accreditation Modal Component -->
    @livewire('monitoring.schedule-accreditation')

    <!-- SweetAlert Event Listener -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                const data = event[0] || event;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: data.icon || 'success',
                        title: data.title || '',
                        text: data.text || '',
                        confirmButtonColor: '#f27224',
                        customClass: {
                            popup: 'rounded-2xl border border-slate-200 font-sans',
                            confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white'
                        }
                    });
                }
            });
        });
    </script>
</div>
