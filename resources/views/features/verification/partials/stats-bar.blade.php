<!-- KPI Stats Bar for Dean Verification -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
    <x-ui.stat-card
        label="Areas"
        :value="$stats['totalAreas']"
        status="active"
    >
        <x-slot:icon>
            <x-lucide-folder-kanban class="w-5 h-5 text-primary" />
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        label="Total Uploads"
        :value="$stats['totalDocs']"
    >
        <x-slot:icon>
            <x-lucide-file-text class="w-5 h-5 text-zinc-400" />
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        label="Dean Verified"
        :value="$stats['verifiedDocs']"
        status="success"
    >
        <x-slot:icon>
            <x-lucide-badge-check class="w-5 h-5 text-emerald-500" />
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        label="Needs Revision"
        :value="$stats['flaggedDocs']"
        status="danger"
    >
        <x-slot:icon>
            <x-lucide-alert-triangle class="w-5 h-5 text-rose-500" />
        </x-slot:icon>
    </x-ui.stat-card>

    <!-- Readiness Percentage Card -->
    <div class="bg-white border border-zinc-200/80 rounded-2xl p-4 shadow-3xs flex flex-col justify-between col-span-2 sm:col-span-1 border-l-4 border-l-emerald-500">
        <div class="flex items-center justify-between">
            <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider">Readiness</span>
            <span class="text-heading-sm font-black text-emerald-600">{{ $stats['readinessPct'] }}%</span>
        </div>
        <div class="w-full h-2 bg-zinc-100 rounded-full overflow-hidden mt-2">
            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $stats['readinessPct'] }}%"></div>
        </div>
    </div>
</div>
