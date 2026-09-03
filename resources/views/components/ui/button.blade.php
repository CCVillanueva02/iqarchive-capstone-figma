@props([
    'variant' => 'primary', // primary, brand, secondary, outline, danger, subtle
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'icon' => null,
    'loading' => null,
])

@php
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-label gap-1.5 rounded-lg',
        'lg' => 'px-6 py-3 text-body font-bold gap-2.5 rounded-xl',
        default => 'px-4 py-2 text-body-sm font-bold gap-2 rounded-xl',
    };

    $variantClasses = match($variant) {
        'brand' => 'bg-brand-orange text-white hover:bg-brand-orange-hover shadow-2xs focus-visible:ring-brand-orange',
        'secondary' => 'bg-surface-subtle text-primary-dark hover:bg-zinc-200 border border-zinc-200/80 focus-visible:ring-primary',
        'outline' => 'bg-transparent text-zinc-700 hover:bg-zinc-100 border border-zinc-300 focus-visible:ring-zinc-400',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 shadow-2xs focus-visible:ring-rose-500',
        'subtle' => 'bg-transparent text-primary hover:bg-primary/10 focus-visible:ring-primary',
        default => 'bg-primary text-white hover:bg-primary-hover shadow-2xs focus-visible:ring-primary',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center font-bold tracking-tight transition-all duration-150 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 {$sizeClasses} {$variantClasses}"]) }}
    @if($loading) wire:loading.attr="disabled" wire:target="{{ $loading }}" @endif
>
    @if($loading)
        <svg wire:loading wire:target="{{ $loading }}" class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif

    @if($icon)
        <span class="shrink-0">{{ $icon }}</span>
    @endif

    <span>{{ $slot }}</span>
</button>
