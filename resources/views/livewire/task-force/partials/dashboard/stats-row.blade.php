<!-- Task Force Dashboard Stats Row -->
<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
    <!-- Total Uploaded Documents -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400">Total Uploads</span>
            <div class="w-8 h-8 rounded-xl bg-surface-subtle text-primary flex items-center justify-center">
                <x-lucide-file-text class="w-4 h-4 text-primary" />
            </div>
        </div>
        <div class="mt-3">
            <span class="text-heading-lg font-extrabold text-primary">{{ $stats['totalDocs'] }}</span>
            <span class="text-label-xs text-zinc-400 block mt-0.5">Evidence files attached</span>
        </div>
    </div>

    <!-- Dean Verified Documents -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400">Dean Verified</span>
            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <x-lucide-check-circle-2 class="w-4 h-4 text-emerald-600" />
            </div>
        </div>
        <div class="mt-3">
            <span class="text-heading-lg font-extrabold text-emerald-600">{{ $stats['verifiedDocs'] }}</span>
            <span class="text-label-xs text-zinc-400 block mt-0.5">Approved compliance items</span>
        </div>
    </div>

    <!-- Needs Revision / Flagged -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400">Needs Revision</span>
            <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <x-lucide-alert-circle class="w-4 h-4 text-rose-600" />
            </div>
        </div>
        <div class="mt-3">
            <span class="text-heading-lg font-extrabold {{ $stats['flaggedDocs'] > 0 ? 'text-rose-600' : 'text-zinc-700' }}">
                {{ $stats['flaggedDocs'] }}
            </span>
            <span class="text-label-xs text-zinc-400 block mt-0.5">Rework requested</span>
        </div>
    </div>

    <!-- Pending Dean Review -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400">Pending Review</span>
            <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <x-lucide-clock class="w-4 h-4 text-amber-600" />
            </div>
        </div>
        <div class="mt-3">
            <span class="text-heading-lg font-extrabold text-amber-700">{{ $stats['pendingDocs'] }}</span>
            <span class="text-label-xs text-zinc-400 block mt-0.5">Awaiting verification</span>
        </div>
    </div>

    <!-- Overall Verification Readiness -->
    <div class="col-span-2 sm:col-span-2 md:col-span-4 lg:col-span-1 bg-white border border-slate-200/70 rounded-2xl p-5 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400">Readiness</span>
            <span class="text-body-sm font-extrabold text-primary">{{ $stats['readinessPct'] }}%</span>
        </div>
        <div class="mt-3">
            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $stats['readinessPct'] }}%"></div>
            </div>
            <span class="text-label-xs text-zinc-400 block mt-2">
                {{ $stats['verifiedDocs'] }} of {{ $stats['totalDocs'] }} items verified
            </span>
        </div>
    </div>
</div>
