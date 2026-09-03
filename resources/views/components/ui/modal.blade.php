@props([
    'name' => null,
    'title' => null,
    'subtitle' => null,
    'maxWidth' => '2xl', // sm, md, lg, xl, 2xl, 3xl, 4xl
    'footer' => null,
])

@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'max-w-sm md:min-w-sm',
        'md' => 'max-w-md md:min-w-md',
        'lg' => 'max-w-lg md:min-w-lg',
        'xl' => 'max-w-xl md:min-w-xl',
        '3xl' => 'max-w-3xl md:min-w-3xl',
        '4xl' => 'max-w-4xl md:min-w-4xl',
        default => 'max-w-2xl md:min-w-2xl',
    };
@endphp

<flux:modal
    @if($name) name="{{ $name }}" @endif
    {{ $attributes->merge(['class' => "{$maxWidthClass} no-scrollbar scrollbar-none"]) }}
>
    <div class="flex flex-col gap-5 p-1">
        @if($title)
            <div class="flex items-start justify-between pb-3 border-b border-zinc-100">
                <div>
                    <flux:heading size="lg" class="font-extrabold text-primary-dark">{{ $title }}</flux:heading>
                    @if($subtitle)
                        <flux:subheading class="text-zinc-500 text-body-sm mt-0.5">{{ $subtitle }}</flux:subheading>
                    @endif
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-4 text-body-sm text-zinc-700">
            {{ $slot }}
        </div>

        @if($footer)
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100 mt-2">
                {{ $footer }}
            </div>
        @endif
    </div>
</flux:modal>
