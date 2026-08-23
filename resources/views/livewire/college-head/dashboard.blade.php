<div class="space-y-8">
    @if(session('status'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center justify-between text-emerald-800 text-body-sm shadow-xs">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    </div>
    @endif

    <!-- 1. College QA Identity & Health Banner -->
    @include('livewire.college-head.partials.college-banner')

    <!-- 2. High-Level KPI Summary Metrics -->
    @include('livewire.college-head.partials.kpi-metrics')

    <!-- 3. Action Required Queue (Task Force Nominations & Verification Queue) -->
    @include('livewire.college-head.partials.action-required')

    <!-- 4. Active Degree Programs Accreditation Visits & Survey Matrix (Only active cycles) -->
    @include('livewire.college-head.partials.programs-table')

    <!-- 5. College Programs Master Directory & Validity Status (Monitoring format) -->
    @include('livewire.college-head.partials.monitoring-programs-table')

    <!-- 6. Task Force Proposal Modal -->
    @include('livewire.college-head.partials.propose-tf-modal')

    <!-- 7. Accreditation Preparation Lifecycle Timeline Modal -->
    @include('livewire.college-head.partials.timeline-modal')

    <!-- 8. Program Accreditation History Modal -->
    @include('livewire.college-head.partials.history-modal')
</div>
