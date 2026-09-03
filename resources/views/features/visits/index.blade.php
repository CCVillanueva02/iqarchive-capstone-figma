<div class="w-full px-6 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- 1. Unified Page Header -->
    <x-ui.page-header
        title="Accreditation Visits"
        subtitle="Record, schedule, and track end-to-end accreditation visit preparation and milestones."
        :breadcrumbs="[
            ['label' => 'Quality Assurance', 'url' => '#'],
            ['label' => 'Accreditation Visits']
        ]"
    >
        @if(in_array(auth()->user()->role ?? '', ['iqa-staff', 'iqa-admin', 'system-administrator']))
            <x-slot:actions>
                <x-ui.button
                    variant="brand"
                    x-on:click="$flux.modal('schedule-accreditation').show()"
                >
                    <x-slot:icon>
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </x-slot:icon>
                    Record New Visit
                </x-ui.button>
            </x-slot:actions>
        @endif
    </x-ui.page-header>

    <!-- 2. Standard Metric KPI Row -->
    @include('features.visits.partials.stats-bar')

    <!-- 3. Unified Filter Toolbar -->
    <x-ui.filter-bar
        placeholder="Search by program name, code, or college..."
        searchModel="search"
    >
        <div class="flex items-center gap-2 shrink-0">
            <span class="text-label uppercase tracking-wider font-extrabold text-zinc-500">Stage:</span>
            <select
                wire:model.live="statusFilter"
                class="px-3 py-2 bg-surface-subtle border border-zinc-200 rounded-xl text-body-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-primary/20 transition cursor-pointer"
            >
                <option value="all">All Stages</option>
                <option value="scheduled">Scheduled</option>
                <option value="in_progress">In Active Preparation</option>
                <option value="completed">Completed / Submitted</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </x-ui.filter-bar>

    <!-- 4. Standard Data Table -->
    @include('features.visits.partials.table')

    <!-- 5. Interactive Timeline Drawer Modal -->
    @include('features.visits.partials.timeline-modal')

    <!-- 6. Schedule Accreditation Modal Component -->
    @livewire('accreditation.schedule-accreditation')

    <!-- SweetAlert & Notification Event Listeners -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('swal', event => {
                const data = event.detail[0] || event.detail;
                if (window.Swal) {
                    Swal.fire({
                        icon: data.icon || 'success',
                        title: data.title || 'Notification',
                        text: data.text || '',
                        confirmButtonColor: '#1b355a',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-sm'
                        }
                    });
                }
            });
        });

        function confirmCancel(id, name) {
            if (window.Swal) {
                Swal.fire({
                    title: 'Cancel Accreditation Visit?',
                    text: `Are you sure you want to cancel the accreditation visit for "${name}"? This will halt task force preparations and notify the College Dean.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, cancel visit',
                    cancelButtonText: 'Keep Active',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-4 py-2 font-bold text-sm',
                        cancelButton: 'rounded-xl px-4 py-2 font-bold text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.cancelAccreditation(id);
                    }
                });
            } else {
                if (confirm(`Are you sure you want to cancel the visit for "${name}"?`)) {
                    @this.cancelAccreditation(id);
                }
            }
        }
    </script>
</div>
