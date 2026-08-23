<div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-3xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div class="flex items-start gap-3.5">
        <a href="{{ route('dashboard.college-head') }}" 
            class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-primary transition mt-0.5 cursor-pointer"
            wire:navigate
            title="Back to Dashboard">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div class="flex flex-col">
            <div class="flex items-center gap-2">
            </div>
            <h1 class="text-heading font-extrabold text-primary tracking-tight mt-0.5">
                {{ $accreditation->program->name }}
            </h1>
            <p class="text-body-sm text-zinc-500 mt-0.5">
                Customize benchmark parameters and evidence tag requirements before opening the evidence upload repository.
            </p>
        </div>
    </div>

    <!-- Finalize CTA Button -->
    <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
        <button type="button"
            wire:click="openFinalizeModal"
            class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-body-sm shadow-md transition cursor-pointer">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Finalize &amp; Unlock Evidence Repository</span>
        </button>
    </div>
</div>
