<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Degree Programs -->
    <div class="bg-surface-card border border-slate-200/80 rounded-xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted block">Degree Programs</span>
            <span class="text-heading-lg font-bold text-primary-dark block mt-1">
                {{ $kpiMetrics['totalPrograms'] }}
            </span>
            <span class="text-label-xs text-slate-500 mt-0.5 block">
                {{ $kpiMetrics['accreditedPrograms'] }} Accredited Status
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
    </div>

    <!-- Active Accreditation Visits -->
    <div class="bg-surface-card border border-slate-200/80 rounded-xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted block">Active Cycles</span>
            <span class="text-heading-lg font-bold text-brand-orange block mt-1">
                {{ $kpiMetrics['activeVisits'] }}
            </span>
            <span class="text-label-xs text-slate-500 mt-0.5 block">
                Under Survey Preparation
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-brand-orange/10 text-brand-orange flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>

    <!-- Active Task Forces -->
    <div class="bg-surface-card border border-slate-200/80 rounded-xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted block">Active Task Forces</span>
            <span class="text-heading-lg font-bold text-primary-dark block mt-1">
                {{ $kpiMetrics['activeTaskForces'] }}
            </span>
            <span class="text-label-xs text-slate-500 mt-0.5 block">
                Mobilized Faculty Teams
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
    </div>

    <!-- Pending Dean Actions -->
    <div class="bg-surface-card border {{ $kpiMetrics['pendingActions'] > 0 ? 'border-amber-300/80 bg-amber-50/20' : 'border-slate-200/80' }} rounded-xl p-5 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold uppercase tracking-wider {{ $kpiMetrics['pendingActions'] > 0 ? 'text-amber-800' : 'text-primary-muted' }} block">Action Required</span>
            <span class="text-heading-lg font-bold {{ $kpiMetrics['pendingActions'] > 0 ? 'text-amber-800' : 'text-slate-400' }} block mt-1">
                {{ $kpiMetrics['pendingActions'] }}
            </span>
            <span class="text-label-xs text-slate-500 mt-0.5 block">
                {{ $kpiMetrics['pendingProposals'] }} Nomination · {{ $kpiMetrics['pendingVerifications'] }} Verification
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl {{ $kpiMetrics['pendingActions'] > 0 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
    </div>
</div>
