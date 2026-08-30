<!-- Task Force Dashboard Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs">
    <div class="flex flex-col gap-1.5">
        <div class="flex items-center gap-3 mt-1">
            <h1 class="text-heading font-extrabold text-primary tracking-tight">
                {{ $acc->program->name }}
            </h1>
            <span class="px-2.5 py-1 rounded-lg text-label-xs font-bold bg-slate-100 text-zinc-700">
                {{ $acc->program->accreditation_level ?: 'Candidate Status' }}
            </span>
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

</div>
