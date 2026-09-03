<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <x-ui.stat-card
        label="Total Recorded Visits"
        :value="$totalVisits"
        sub="Across all academic programs"
        status="active"
    >
        <x-slot:icon>
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        label="Scheduled / Awaiting TF"
        :value="$scheduledCount"
        sub="Pending task force formation"
        status="warning"
    >
        <x-slot:icon>
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        label="In Active Preparation"
        :value="$inProgressCount"
        sub="Instrument, uploads & reviews"
        status="brand"
    >
        <x-slot:icon>
            <svg class="w-5 h-5 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        label="Submitted & Reviewed"
        :value="$completedCount"
        sub="Handed over to IQA Office"
        status="success"
    >
        <x-slot:icon>
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>
</div>
