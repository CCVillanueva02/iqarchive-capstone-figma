@php
$role = auth()->user()?->role;
$htmlClass = 'light';
$bodyClass = 'min-h-screen bg-[#f4f6fa] antialiased text-zinc-800';
@endphp

<x-layouts::html :title="$title ?? null" :html-class="$htmlClass" :body-class="$bodyClass">
    @if($role === 'accreditor')
        <!-- Blank layout for External Evaluator Accreditors (No Sidebar, No Header/Footer) -->
        <main class="w-full min-h-screen bg-[#f4f6fa]">
            {{ $slot }}
        </main>
    @elseif($role === 'iqa-admin' || $role === 'system-administrator' || $role === 'iqa-member' || $role === 'university-administrator')
        <x-layouts::app.sidebar>
            @if($role === 'system-administrator')
            <div class="sticky top-0 z-50 bg-emerald-600 border-b border-emerald-700 text-white text-xs font-semibold py-2 px-6 flex items-center justify-between shadow-xs select-none">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-300"></span>
                    </span>
                    <span>Logged in as <strong>System Administrator</strong> &bull; Superuser Mode</span>
                </div>
                <div class="text-[10px] bg-white/20 px-2 py-0.5 rounded font-mono uppercase tracking-wider">
                    System Admin Panel
                </div>
            </div>
            @endif
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