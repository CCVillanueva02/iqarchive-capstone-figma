<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

    <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

    <flux:spacer />

    <x-desktop-user-menu />
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header>
        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
        <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
    </flux:sidebar.header>
</flux:sidebar>

{{ $slot }}