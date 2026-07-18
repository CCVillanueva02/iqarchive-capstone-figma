@php
    $role = auth()->user()?->role;
    $htmlClass = $role === 'iqa-admin' ? 'light' : null;
    $bodyClass = 'min-h-screen bg-[#f4f6fa] antialiased text-zinc-800';
@endphp

<x-layouts::html :title="$title ?? null" :html-class="$htmlClass" :body-class="$bodyClass">
    @if($role === 'iqa-admin')
        <x-layouts::app.sidebar>
            <flux:main>
                {{ $slot }}
            </flux:main>
        </x-layouts::app.sidebar>
    @else
        <x-layouts::app.header>
            <flux:main class="min-h-[calc(100vh-64px)] flex flex-col justify-between !p-0">
                <div class="flex-1 w-full app-layout-content">
                    {{ $slot }}
                </div>
                @include('partials.footer')
            </flux:main>
        </x-layouts::app.header>

        <style>
            /* Override child min-h-screen inside layout container to prevent layout height overflow */
            .app-layout-content > div {
                min-height: auto !important;
            }
        </style>
    @endif
</x-layouts::html>