@php
$role = auth()->user()?->role;
$htmlClass = 'light';
$bodyClass = 'min-h-screen bg-surface-subtle antialiased text-zinc-800';
@endphp

<x-layouts::html :title="$title ?? null" :html-class="$htmlClass" :body-class="$bodyClass">
    @if($role === 'accreditor')
        <!-- Blank layout for External Evaluator Accreditors (No Sidebar, No Header/Footer) -->
        <main class="w-full min-h-screen bg-surface-subtle">
            {{ $slot }}
        </main>
    @elseif(in_array($role, ['iqa-staff', 'iqa-admin', 'system-administrator', 'university-administrator', 'task-force-member', 'college-head']))
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
                <div class="text-label-xs bg-white/20 px-2 py-0.5 rounded font-mono uppercase tracking-wider">
                    System Admin Panel
                </div>
            </div>
            @endif
            <flux:main>
                {{ $slot }}
            </flux:main>
        </x-layouts::app.sidebar>

        @persist('sidebar-loader')
            <div x-data="{
                    loading: false,
                    startTime: 0,
                    timer: null,
                    safetyTimer: null,
                    showLoader() {
                        if (this.timer) clearTimeout(this.timer);
                        if (this.safetyTimer) clearTimeout(this.safetyTimer);
                        this.startTime = Date.now();
                        this.loading = true;
                        this.safetyTimer = setTimeout(() => {
                            this.loading = false;
                        }, 3000);
                    },
                    hideLoader() {
                        if (this.safetyTimer) clearTimeout(this.safetyTimer);
                        const elapsed = Date.now() - this.startTime;
                        const remaining = Math.max(0, 400 - elapsed);
                        this.timer = setTimeout(() => {
                            this.loading = false;
                        }, remaining);
                    }
                 }"
                 x-init="
                    document.addEventListener('pointerdown', (e) => {
                        if (e.target.closest('a[wire\\:navigate]')) {
                            showLoader();
                        }
                    }, true);
                    document.addEventListener('click', (e) => {
                        if (e.target.closest('a[wire\\:navigate]')) {
                            showLoader();
                        }
                    }, true);
                    document.addEventListener('livewire:navigating', () => showLoader());
                    document.addEventListener('livewire:navigated', () => hideLoader());
                 "
                 x-show="loading"
                 x-cloak
                 x-transition:enter="transition-opacity ease-out duration-75"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-y-0 right-0 left-0 lg:left-64 z-9999 flex items-center justify-center bg-surface-subtle select-none"
                 style="display: none;">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xl flex flex-col items-center gap-4 max-w-xs w-full mx-4">
                    <!-- Animated Dual-Ring Spinner -->
                    <div class="relative w-12 h-12 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full border-3 border-slate-100"></div>
                        <div class="absolute inset-0 rounded-full border-3 border-primary-dark border-t-transparent animate-spin"></div>
                        <div class="absolute w-7 h-7 rounded-full border-2 border-brand-orange border-b-transparent animate-spin" style="animation-direction: reverse; animation-duration: 0.6s;"></div>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <span class="text-xs font-extrabold text-primary-dark tracking-wider uppercase">Loading Workspace</span>
                        <span class="text-label text-zinc-400 font-medium mt-0.5">Please wait...</span>
                    </div>
                </div>
            </div>
        @endpersist
    @else
        <x-layouts::app.header>
            <flux:main class="min-h-[calc(100vh-64px)] flex flex-col justify-between p-0!">
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