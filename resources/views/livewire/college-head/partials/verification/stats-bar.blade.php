<!-- KPI Stats Bar for Dean Verification -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
    <!-- Total Areas -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-4 shadow-3xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block">Areas</span>
            <span class="text-heading font-extrabold text-primary block mt-0.5">{{ $stats['totalAreas'] }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-surface-subtle text-primary flex items-center justify-center shrink-0">
            <x-lucide-folder-kanban class="w-5 h-5" />
        </div>
    </div>

    <!-- Total Documents Uploaded -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-4 shadow-3xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block">Total Uploads</span>
            <span class="text-heading font-extrabold text-zinc-800 block mt-0.5">{{ $stats['totalDocs'] }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-slate-100 text-zinc-600 flex items-center justify-center shrink-0">
            <x-lucide-file-text class="w-5 h-5" />
        </div>
    </div>

    <!-- Verified Documents -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-4 shadow-3xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold text-emerald-700 uppercase tracking-wider block">Dean Verified</span>
            <span class="text-heading font-extrabold text-emerald-700 block mt-0.5">{{ $stats['verifiedDocs'] }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <x-lucide-badge-check class="w-5 h-5" />
        </div>
    </div>

    <!-- Needs Revision / Flagged -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-4 shadow-3xs flex items-center justify-between">
        <div>
            <span class="text-label-xs font-bold text-rose-600 uppercase tracking-wider block">Needs Revision</span>
            <span class="text-heading font-extrabold text-rose-600 block mt-0.5">{{ $stats['flaggedDocs'] }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <x-lucide-alert-triangle class="w-5 h-5" />
        </div>
    </div>

    <!-- Readiness Percentage -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-4 shadow-3xs flex flex-col justify-between col-span-2 sm:col-span-1">
        <div class="flex items-center justify-between">
            <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider">Readiness</span>
            <span class="text-body-sm font-extrabold text-primary">{{ $stats['readinessPct'] }}%</span>
        </div>
        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden mt-2">
            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $stats['readinessPct'] }}%"></div>
        </div>
    </div>
</div>
