@props([
    'placeholder' => 'Search records...',
    'searchModel' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl p-4 border border-zinc-200/80 shadow-3xs flex flex-col md:flex-row md:items-center justify-between gap-3 mb-6']) }}>
    <div class="relative flex-1 max-w-md">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input
            type="text"
            placeholder="{{ $placeholder }}"
            @if($searchModel) wire:model.live.debounce.300ms="{{ $searchModel }}" @endif
            class="w-full pl-10 pr-4 py-2 bg-surface-subtle border border-zinc-200 rounded-xl text-body-sm text-zinc-800 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition"
        >
    </div>

    @if($slot->isNotEmpty())
        <div class="flex items-center flex-wrap gap-2.5">
            {{ $slot }}
        </div>
    @endif
</div>
