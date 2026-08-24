@php
    $isFinalized = in_array($accreditation->status, ['document_preparation', 'uploading', 'dean_verification', 'submitted', 'completed']);
@endphp

<div class="bg-white border border-slate-200/80 rounded-xl p-6 shadow-3xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div class="flex items-start gap-3.5">
        <a href="{{ route('dashboard.college-head') }}" 
            class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-primary transition mt-0.5 cursor-pointer"
            wire:navigate
            title="Back to Dashboard">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div class="flex flex-col">
            <div class="flex items-center gap-2">
                @if ($isFinalized)
                <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 border border-emerald-200 text-label-xs font-bold uppercase tracking-wider flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>Finalized · Evidence Repository Active</span>
                </span>
                @else
                @endif
            </div>
            <h1 class="text-heading font-extrabold text-primary tracking-tight mt-1">
                {{ $accreditation->program->name }}
            </h1>
            <p class="text-body-sm text-zinc-500 mt-0.5">
                @if ($isFinalized)
                Instrument is finalized and active. Benchmark requirements and #EvidenceTags are available to the Task Force for evidence uploads.
                @else
                Customize benchmark parameters and evidence tag requirements before opening the evidence upload repository.
                @endif
            </p>
        </div>
    </div>

    <!-- Finalize CTA / Active Evidence Repository Button -->
    <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
        @if ($isFinalized)
        <a href="{{ route('documents.college-head', ['tab' => 'program-accreditation']) }}"
            class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white font-semibold text-body-sm shadow-xs transition cursor-pointer"
            wire:navigate>
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
            <span>Open Evidence Repository &rarr;</span>
        </a>
        @else
        <button type="button"
            wire:click="openFinalizeModal"
            class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-body-sm shadow-xs transition cursor-pointer">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Finalize Instrument</span>
        </button>
        @endif
    </div>
</div>
