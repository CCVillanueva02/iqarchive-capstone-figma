{{--
    IQArchive Global Desktop & Mobile Navigation Shell
    Modular desktop workstation sidebar adhering to 3-tier IA (Workspace, Operations, Administration)
--}}

@persist('sidebar')
    <livewire:sidebar />
@endpersist

<!-- Mobile Navigation Header -->
<flux:header class="lg:hidden bg-primary-dark! text-white border-none">
    <flux:sidebar.toggle class="lg:hidden text-white" icon="bars-2" inset="left" />
    <flux:spacer />
    <span class="text-body font-bold text-white">IQArchive</span>
    <flux:spacer />
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-body-sm font-semibold text-zinc-300 hover:text-white p-2">Log out</button>
    </form>
</flux:header>

{{ $slot }}