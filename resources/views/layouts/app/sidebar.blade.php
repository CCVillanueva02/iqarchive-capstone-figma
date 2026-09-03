{{--
    IQArchive Global Desktop & Mobile Navigation Shell
    Modular desktop workstation sidebar adhering to 3-tier IA (Workspace, Operations, Administration)
--}}

<flux:sidebar sticky collapsible="mobile" class="border-none text-white flex flex-col gap-0 p-0! min-h-screen h-screen no-scrollbar" style="background: linear-gradient(180deg, var(--color-primary-dark) 0%, var(--color-primary-hover) 100%) !important;">
    <!-- Brand / Institution Header -->
    <flux:sidebar.header class="flex flex-col gap-3 px-5 py-6 border-b border-white/10">
        <div class="flex items-center justify-start gap-3 mr-auto text-left w-full">
            <img src="/bulogo.png" alt="BU Logo" class="w-10 h-10 object-contain shrink-0 select-none" />
            <div class="flex flex-col">
                <span class="block font-bold text-heading tracking-[0.5px] leading-tight text-white">IQArchive</span>
                <span class="block text-label text-white/70 font-semibold uppercase tracking-wider mt-0.5 select-none">IQA Office &bull; BU</span>
            </div>
        </div>
    </flux:sidebar.header>

    @php
    $role = auth()->user()?->role;
    if (in_array($role, ['iqa-admin', 'iqa-member'])) {
        $role = 'iqa-staff';
    }
    @endphp

    <!-- Scrollable Navigation Area -->
    <div class="relative flex-1 min-h-0 flex flex-col">
        <div class="flex flex-col gap-1 flex-1 py-4 overflow-y-auto no-scrollbar relative">
            <!-- 1. Everyday Workspace Navigation -->
            @include('layouts.app.sidebar.workspace-nav')

            <!-- 2. Operations & Coordination Navigation -->
            @include('layouts.app.sidebar.operations-nav')

            <!-- 3. Central System Administration Navigation -->
            @include('layouts.app.sidebar.administration-nav')
        </div>
    </div>

    <!-- User Profile & Account Footer -->
    @include('layouts.app.sidebar.profile-footer')
</flux:sidebar>

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