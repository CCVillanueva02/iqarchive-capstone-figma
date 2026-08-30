<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Active Task Forces -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
        <div>
            <span class="text-label-xs text-slate-500 font-semibold uppercase tracking-wider block">Active Task Forces</span>
            <span class="text-heading-lg font-extrabold text-primary mt-1 block">{{ $totalActiveCount }}</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-surface-subtle text-primary flex items-center justify-center font-bold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Pending Approval -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
        <div>
            <span class="text-label-xs text-slate-500 font-semibold uppercase tracking-wider block">Pending Approval</span>
            <span class="text-heading-lg font-extrabold text-amber-600 mt-1 block">{{ $totalPendingCount }}</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Active Members Assigned -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
        <div>
            <span class="text-label-xs text-slate-500 font-semibold uppercase tracking-wider block">Active Members</span>
            <span class="text-heading-lg font-extrabold text-brand-orange mt-1 block">{{ $totalMembersAssignedCount }}</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-brand-orange/10 text-brand-orange flex items-center justify-center font-bold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Completed Task Forces -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
        <div>
            <span class="text-label-xs text-slate-500 font-semibold uppercase tracking-wider block">Completed</span>
            <span class="text-heading-lg font-extrabold text-emerald-600 mt-1 block">{{ $totalCompletedCount }}</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
    </div>
</div>
