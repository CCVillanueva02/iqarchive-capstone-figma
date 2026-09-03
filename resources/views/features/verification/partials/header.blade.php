<!-- Header Bar for Dean Verification -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-zinc-200/80 rounded-2xl p-6 shadow-3xs">
    <div class="flex flex-col gap-1.5">
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.college-head') }}"
                wire:navigate
                class="inline-flex items-center gap-1 text-label-xs font-bold text-zinc-500 hover:text-primary transition cursor-pointer">
                <x-lucide-arrow-left class="w-3.5 h-3.5" />
                <span>Back to Dashboard</span>
            </a>
            <span class="text-zinc-300">•</span>
            <span class="text-label-xs font-bold text-primary uppercase tracking-wider">Step 6: Dean Quality Review</span>
        </div>

        <div class="flex items-center gap-3 mt-1">
            <h1 class="text-heading font-extrabold text-primary-dark tracking-tight">
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
        <x-ui.button
            type="button"
            variant="outline"
            size="md"
            wire:click="openRequestRevisionsModal"
            class="text-rose-700 border-rose-200 hover:bg-rose-50"
        >
            <x-slot:icon>
                <x-lucide-rotate-ccw class="w-4 h-4 text-rose-600 mr-1.5" />
            </x-slot:icon>
            Request Revisions
        </x-ui.button>

        <x-ui.button
            type="button"
            variant="primary"
            size="md"
            wire:click="openSubmitToIqaModal"
        >
            <x-slot:icon>
                <x-lucide-shield-check class="w-4 h-4 text-emerald-400 mr-1.5" />
            </x-slot:icon>
            Complete &amp; Submit to IQA
        </x-ui.button>
    </div>
</div>
