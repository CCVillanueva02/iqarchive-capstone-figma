<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Visits -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted">Total Recorded Visits</span>
            <h3 class="text-heading-lg font-bold text-primary-dark mt-1">{{ $totalVisits }}</h3>
            <span class="text-label-xs text-slate-400 mt-0.5 block">Across all academic programs</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
    </div>

    <!-- Scheduled -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider text-amber-600">Scheduled / Awaiting TF</span>
            <h3 class="text-heading-lg font-bold text-amber-800 mt-1">{{ $scheduledCount }}</h3>
            <span class="text-label-xs text-amber-600/70 mt-0.5 block">Pending task force formation</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
    </div>

    <!-- In Progress -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider text-blue-600">In Active Preparation</span>
            <h3 class="text-heading-lg font-bold text-blue-800 mt-1">{{ $inProgressCount }}</h3>
            <span class="text-label-xs text-blue-600/70 mt-0.5 block">Instrument, uploads &amp; reviews</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
    </div>

    <!-- Completed / Submitted -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider text-green-600">Submitted &amp; Reviewed</span>
            <h3 class="text-heading-lg font-bold text-green-800 mt-1">{{ $completedCount }}</h3>
            <span class="text-label-xs text-green-600/70 mt-0.5 block">Handed over to IQA Office</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 border border-green-100 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>
