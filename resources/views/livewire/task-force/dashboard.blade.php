<div class="flex flex-col gap-6 w-full max-w-7xl mx-auto select-none">
    <!-- Success Banner -->
    @if(session()->has('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-body-sm font-semibold flex items-center justify-between shadow-3xs">
            <div class="flex items-center gap-2.5">
                <x-lucide-check-circle-2 class="w-5 h-5 text-emerald-600 shrink-0" />
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($acc)
        <!-- Header & Stage Info -->
        @include('livewire.task-force.partials.dashboard.header')

        <!-- Dean Revisions / Action Required Alert -->
        @include('livewire.task-force.partials.dashboard.revisions-banner')

        <!-- Stats Bar -->
        @include('livewire.task-force.partials.dashboard.stats-row')

        <!-- Main Workspace: Area Matrix & Recent Feedback -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Left 2 Cols: Area-by-Area Matrix -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                @include('livewire.task-force.partials.dashboard.area-matrix')
            </div>

            <!-- Right 1 Col: Recent Dean Reviews & Quick Resources -->
            <div class="flex flex-col gap-6">
                @include('livewire.task-force.partials.dashboard.recent-reviews')
            </div>
        </div>

        <!-- Submit to Dean Modal -->
        @include('livewire.task-force.partials.dashboard.modals/submit-to-dean-modal')
    @else
        <!-- Empty State: No Active Accreditation Assigned -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-12 text-center flex flex-col items-center gap-4 shadow-3xs max-w-lg mx-auto mt-10">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-primary flex items-center justify-center">
                <x-lucide-folder-archive class="w-8 h-8 text-primary" />
            </div>
            <h2 class="text-heading-sm font-bold text-primary">No Active Accreditation Cycle</h2>
            <p class="text-body-sm text-zinc-500 max-w-sm">
                You are not currently assigned to an active program accreditation cycle. Please contact your College Dean or IQA Central Office.
            </p>
        </div>
    @endif
</div>
