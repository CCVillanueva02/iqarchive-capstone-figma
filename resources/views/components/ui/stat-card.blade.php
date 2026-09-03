@props([
    'label' => '',
    'value' => '0',
    'sub' => null,
    'status' => 'default', // default, brand, active, success, warning, danger
    'icon' => null,
])

@php
    $statusClasses = match($status) {
        'brand' => 'border-l-4 border-l-brand-orange',
        'active' => 'border-l-4 border-l-primary',
        'success' => 'border-l-4 border-l-emerald-500',
        'warning' => 'border-l-4 border-l-amber-500',
        'danger' => 'border-l-4 border-l-rose-500',
        default => 'border-l-4 border-l-zinc-300',
    };

    $valueColor = match($status) {
        'brand' => 'text-brand-orange',
        'active' => 'text-primary',
        'success' => 'text-emerald-600',
        'warning' => 'text-amber-600',
        'danger' => 'text-rose-600',
        default => 'text-primary-dark',
    };
@endphp

<div {{ $attributes->merge(['class' => "bg-white rounded-2xl p-5 border border-zinc-200/80 shadow-3xs flex flex-col justify-between transition hover:shadow-2xs {$statusClasses}"]) }}>
    <div class="flex items-start justify-between gap-3">
        <span class="text-label uppercase tracking-wider font-bold text-zinc-500 truncate">{{ $label }}</span>
        @if($icon)
            <div class="text-zinc-400 shrink-0">
                {{ $icon }}
            </div>
        @endif
    </div>

    <div class="mt-2">
        <div class="text-heading-lg font-black tracking-tight {{ $valueColor }}">
            {{ $value }}
        </div>
        @if($sub)
            <p class="text-label-xs text-zinc-400 mt-1 truncate">{{ $sub }}</p>
        @endif
    </div>
</div>
