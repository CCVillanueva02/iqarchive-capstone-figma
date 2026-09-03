@props([
    'title' => '',
    'subtitle' => null,
    'breadcrumbs' => [],
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-4 mb-6']) }}>
    @if(!empty($breadcrumbs))
        <nav class="flex items-center gap-2 text-label font-medium text-zinc-500">
            @foreach($breadcrumbs as $crumb)
                @if(!$loop->first)
                    <svg class="w-3.5 h-3.5 text-zinc-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                @endif
                @if(isset($crumb['url']) && !$loop->last)
                    <a href="{{ $crumb['url'] }}" class="hover:text-primary transition-colors">{{ $crumb['label'] }}</a>
                @else
                    <span class="text-zinc-800 font-semibold truncate">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-heading font-extrabold text-primary-dark tracking-tight">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-body-sm text-zinc-500 mt-1">{{ $subtitle }}</p>
            @endif
        </div>

        @if(isset($actions))
            <div class="flex items-center flex-wrap gap-2.5 shrink-0">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
