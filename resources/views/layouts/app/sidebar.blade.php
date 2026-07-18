<flux:sidebar sticky collapsible="mobile" class="border-none text-white flex flex-col gap-0 !p-0 min-h-screen h-screen" style="background: linear-gradient(180deg, #002B61 0%, #003E8A 100%) !important;">
        <flux:sidebar.header class="flex flex-col gap-3 px-[20px] py-[24px] border-b border-white/10">
            <div class="flex items-center justify-start gap-3 mr-auto text-left w-full">
                <img src="/bulogo.png" alt="BU Logo" class="w-10 h-10 object-contain shrink-0 select-none" />
                <div class="flex flex-col">
                    <span class="block font-bold text-[20px] tracking-[0.5px] leading-tight text-white">IQArchive</span>
                    <span class="block text-[10px] text-white/70 font-semibold uppercase tracking-wider mt-0.5 select-none">IQA Office &bull; BU</span>
                </div>
            </div>
        </flux:sidebar.header>

        @php
        $role = auth()->user()->role;
        @endphp
        <!-- Navigation Links -->
        <div class="flex flex-col gap-[6px] flex-1 py-6">
            <!-- Dashboard -->
            <a href="{{ route('dashboard.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Document -->
            <a href="{{ route('documents.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('documents.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
                <span>Document</span>
            </a>

            <!-- Submissions -->
            <a href="{{ route('submissions.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('submissions.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>Submissions</span>
            </a>

            <!-- Reports -->
            <a href="{{ route('reports.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('reports.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span>Reports</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('settings.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('settings.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                <span>Settings</span>
            </a>
        </div>

        @php
        $user = auth()->user();
        $roleLabel = match($user?->role) {
        'system-administrator' => 'System Admin',
        'iqa-admin' => 'IQA Admin',
        'iqa-member' => 'IQA Staff',
        'accreditor' => 'Accreditor',
        'university-administrator' => 'BU Admin/Exec',
        'task-force' => 'Task Force',
        'program-chair' => 'Program Chair',
        'faculty-member' => 'Faculty Member',
        default => 'User'
        };
        @endphp

        <!-- Profile Dropdown Component matching Mockup -->
        <div class="px-[20px] py-[20px] border-t border-white/10 mt-auto">
            <flux:dropdown position="top" align="start" class="w-full">
                <button type="button" class="w-full text-left p-3 bg-white/8 hover:bg-white/15 border border-white/5 cursor-pointer rounded-xl flex items-center gap-3 transition focus:outline-none">
                    <div class="w-[38px] h-[38px] rounded-full bg-[#F47920] border-2 border-white text-white font-bold flex items-center justify-center text-sm shrink-0 select-none">
                        {{ $user?->initials() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-bold text-white truncate">{{ $user?->name }}</div>
                        <div class="text-[11px] text-white/60 truncate">{{ $roleLabel }}</div>
                    </div>
                </button>

                <flux:menu>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="text-xs cursor-pointer">
                        {{ __('Settings') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer text-xs">
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden !bg-[#0b2545] text-white border-none">
        <flux:sidebar.toggle class="lg:hidden text-white" icon="bars-2" inset="left" />
        <flux:spacer />
        <span class="text-sm font-bold text-white">IQArchive</span>
        <flux:spacer />
        <!-- Simple Logout for Mobile -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-semibold text-zinc-300 hover:text-white p-2">Log out</button>
        </form>
    </flux:header>

    {{ $slot }}