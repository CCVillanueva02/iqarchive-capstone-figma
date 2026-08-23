<x-layouts::app :title="__('Dean Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen font-sans">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-heading-lg font-bold text-primary-dark">Dean Dashboard</h1>
                <p class="text-body-sm text-zinc-500 mt-1">College Quality Assurance & Accreditation Overview</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-body-sm text-zinc-400 font-medium">System Time: {{ now()->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        @livewire('college-head.task-force-setup')
    </div>
</x-layouts::app>
