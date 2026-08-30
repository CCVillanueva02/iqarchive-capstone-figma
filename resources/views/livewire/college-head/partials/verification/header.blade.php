<!-- Header Bar for Dean Verification -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs">
    <div class="flex flex-col gap-1.5">
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.college-head') }}" 
                wire:navigate
                class="inline-flex items-center gap-1 text-label-xs font-bold text-zinc-500 hover:text-primary transition cursor-pointer">
                <x-lucide-arrow-left class="w-3.5 h-3.5" />
                <span>Back to Dashboard</span>
            </a>
            <span class="text-zinc-300">•</span>
        </div>

        <div class="flex items-center gap-3 mt-1">
            <h1 class="text-heading font-extrabold text-primary tracking-tight">
                {{ $acc->program->name }}
            </h1>
        </div>

        <div class="flex flex-wrap items-center gap-4 text-body-sm text-zinc-500 mt-0.5">
            <span class="flex items-center gap-1.5">
                <x-lucide-building-2 class="w-4 h-4 text-zinc-400" />
                <strong class="text-zinc-700 font-semibold">{{ $acc->program->college?->name ?? 'College' }}</strong>
            </span>
            <span>•</span>
            <span class="flex items-center gap-1.5">
                <x-lucide-users class="w-4 h-4 text-zinc-400" />
                <span>Task Force: <strong class="text-primary font-bold">{{ $acc->taskForce?->name ?? 'Program Task Force' }}</strong></span>
            </span>
            <span>•</span>
            <span class="flex items-center gap-1.5">
                <x-lucide-calendar class="w-4 h-4 text-zinc-400" />
                <span>Target: <strong class="text-zinc-700 font-semibold">{{ $acc->target_date ? $acc->target_date->format('M d, Y') : 'TBD' }}</strong></span>
            </span>
        </div>
    </div>

    <!-- Dean Primary Decision Handover Actions -->
    <div class="flex items-center gap-3 shrink-0">
        <button type="button" 
            wire:click="openRequestRevisionsModal"
            class="px-4 py-2.5 rounded-xl text-body-sm font-bold bg-white border border-rose-200 text-rose-700 hover:bg-rose-50 shadow-3xs transition cursor-pointer flex items-center gap-2">
            <x-lucide-rotate-ccw class="w-4 h-4 text-rose-600" />
            <span>Request Revisions</span>
        </button>

        <button type="button" 
            wire:click="openSubmitToIqaModal"
            class="px-5 py-2.5 rounded-xl text-body-sm font-bold bg-primary hover:bg-primary-hover text-white shadow-3xs transition cursor-pointer flex items-center gap-2">
            <x-lucide-shield-check class="w-4 h-4 text-emerald-400" />
            <span>Complete &amp; Submit to IQA</span>
        </button>
    </div>
</div>
