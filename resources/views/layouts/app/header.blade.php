<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 flex items-center justify-between">
    <div class="flex items-center gap-2">
        <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />
        <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

        @php
            $role = auth()->user()?->role;
            if ($role === 'college-head') {
                $role = 'program-chair';
            }
        @endphp
        @if($role && !in_array($role, ['system-administrator', 'iqa-admin', 'iqa-member']))
            <nav class="hidden lg:flex items-center gap-6 ml-8">
                <a href="{{ route('dashboard.' . $role) }}" class="text-sm font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'text-[#002B61] border-b-2 border-[#F47920] pb-1' : 'text-zinc-500 hover:text-[#002B61] pb-1 border-b-2 border-transparent' }}" wire:navigate>Dashboard</a>
                <a href="{{ route('documents.' . $role) }}" class="text-sm font-semibold transition-all {{ request()->routeIs('documents.' . $role) ? 'text-[#002B61] border-b-2 border-[#F47920] pb-1' : 'text-zinc-500 hover:text-[#002B61] pb-1 border-b-2 border-transparent' }}" wire:navigate>Documents</a>
                <a href="{{ route('submissions.' . $role) }}" class="text-sm font-semibold transition-all {{ request()->routeIs('submissions.' . $role) ? 'text-[#002B61] border-b-2 border-[#F47920] pb-1' : 'text-zinc-500 hover:text-[#002B61] pb-1 border-b-2 border-transparent' }}" wire:navigate>Submissions</a>
                <a href="{{ route('reports.' . $role) }}" class="text-sm font-semibold transition-all {{ request()->routeIs('reports.' . $role) ? 'text-[#002B61] border-b-2 border-[#F47920] pb-1' : 'text-zinc-500 hover:text-[#002B61] pb-1 border-b-2 border-transparent' }}" wire:navigate>Reports</a>
            </nav>
        @endif
    </div>

    <flux:spacer />

    <x-desktop-user-menu />
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header>
        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
        <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
    </flux:sidebar.header>

    @if(isset($role) && $role && !in_array($role, ['system-administrator', 'iqa-admin', 'iqa-member']))
        <div class="flex flex-col gap-1 mt-4 px-2">
            <a href="{{ route('dashboard.' . $role) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-[#002B61]/10 text-[#002B61]' : 'text-zinc-600 hover:bg-zinc-100' }}" wire:navigate>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('documents.' . $role) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('documents.' . $role) ? 'bg-[#002B61]/10 text-[#002B61]' : 'text-zinc-600 hover:bg-zinc-100' }}" wire:navigate>
                <span>Documents</span>
            </a>
            <a href="{{ route('submissions.' . $role) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('submissions.' . $role) ? 'bg-[#002B61]/10 text-[#002B61]' : 'text-zinc-600 hover:bg-zinc-100' }}" wire:navigate>
                <span>Submissions</span>
            </a>
            <a href="{{ route('reports.' . $role) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('reports.' . $role) ? 'bg-[#002B61]/10 text-[#002B61]' : 'text-zinc-600 hover:bg-zinc-100' }}" wire:navigate>
                <span>Reports</span>
            </a>
        </div>
    @endif
</flux:sidebar>

{{ $slot }}