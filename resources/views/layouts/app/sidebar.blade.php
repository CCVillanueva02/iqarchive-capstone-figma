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
    if ($role === 'college-head') {
    $role = 'program-chair';
    }
    @endphp
    <!-- Navigation Links -->
    <div class="flex flex-col gap-[6px] flex-1 py-6">

        @if ($role === 'iqa-admin' || $role === 'iqa-member' || $role === 'system-administrator')
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
        @endif

        @if ($role === 'university-administrator')
        <!-- University Executive: Analytics -->
        <div class="px-6 pt-2 pb-1">
            <span class="text-[9px] font-bold uppercase tracking-[1.5px] text-white/40">Overview</span>
        </div>
        <a href="{{ route('analytics.university-administrator') }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('analytics.university-administrator') ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
            </svg>
            <span>Analytics</span>
        </a>

        <div class="px-6 pt-5 pb-1">
            <span class="text-[9px] font-bold uppercase tracking-[1.5px] text-white/40">Accreditation</span>
        </div>
        <!-- University Executive: Reports -->
        <a href="{{ route('reports.university-administrator') }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('reports.university-administrator') ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Reports</span>
        </a>
        @endif

        @if ($role === 'task-force' || $role === 'task-force-member' || $role === 'program-chair')
        <!-- Task Force / Task Force Member / Program Chair / College Head -->
        <a href="{{ route('dashboard.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9"></rect>
                <rect x="14" y="3" width="7" height="5"></rect>
                <rect x="14" y="12" width="7" height="9"></rect>
                <rect x="3" y="16" width="7" height="5"></rect>
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('documents.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('documents.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Documents</span>
        </a>
        <a href="{{ route('submissions.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('submissions.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>Submissions</span>
        </a>
        <a href="{{ route('reports.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('reports.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
            <span>Reports</span>
        </a>
        @endif

        @if ($role === 'iqa-admin' || $role === 'iqa-member')
        <!-- Document -->
        <a href="{{ route('documents.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('documents.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Document</span>
        </a>
        @endif

        @if ($role === 'iqa-admin' || $role === 'iqa-member')
        <!-- Submissions -->
        <a href="{{ route('submissions.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('submissions.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>Submissions</span>
        </a>
        @endif



        @if ($role === 'system-administrator')
        <!-- Audit Trail (System Administrator) -->
        <a href="{{ route('reports.system-administrator') }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('reports.system-administrator') ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span>Audit Trail</span>
        </a>
        @endif

        @if ($role === 'iqa-admin')
        <!-- Audit Trail (IQA Admin) -->
        <a href="{{ route('audit-trail.iqa-admin') }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('audit-trail.iqa-admin') ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span>Audit Trail</span>
        </a>
        @endif

        @if ($role === 'iqa-admin' || $role === 'system-administrator')
        <!-- Accounts -->
        <a href="{{ route('accounts.' . $role) }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('accounts.' . $role) ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Accounts</span>
        </a>

        <!-- Task Forces -->
        <a href="{{ route('task-forces.index') }}" class="group flex items-center gap-[14px] px-6 py-[14px] border-l-[4px] text-sm font-semibold transition-all {{ request()->routeIs('task-forces.*') ? 'bg-white/10 text-white border-l-[#F47920]' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}" wire:navigate>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Task Forces</span>
        </a>
        @endif


    </div>

    @php
    $user = auth()->user();
    $roleLabel = match($user?->role) {
        'system-administrator' => 'System Admin',
        'iqa-admin' => 'IQA Admin',
        'iqa-member' => 'IQA Staff',
        'accreditor' => 'Accreditor',
        'university-administrator' => 'BU Admin/Exec',
        'task-force' => 'Task Force Lead',
        'task-force-member' => 'Task Force Member',
        'program-chair' => 'Program Chair',
        'college-head' => 'College Head',
        default => 'User'
    };
    $userAssignedRoles = $user ? $user->assignedRoles() : collect();
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
                    <div class="text-[11px] text-white/60 truncate flex items-center gap-1">
                        <span>{{ $roleLabel }}</span>
                        @if($userAssignedRoles->count() > 1)
                            <span class="text-[9px] bg-[#F47920] px-1.5 py-0.2 rounded text-white font-bold">Multi</span>
                        @endif
                    </div>
                </div>
            </button>

            <flux:menu>
                @if($userAssignedRoles->count() > 1)
                    <div class="px-2 py-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Switch Role View</span>
                    </div>
                    @foreach($userAssignedRoles as $r)
                        @php
                            $code = $r->role_name;
                            $title = match($code) {
                                'task-force' => 'QA Task Force Lead',
                                'task-force-member' => 'QA Task Force Member',
                                'system-administrator' => 'System Administrator',
                                'iqa-admin' => 'IQA Admin',
                                'iqa-member' => 'IQA Staff Member',
                                'accreditor' => 'AACCUP Accreditor',
                                'university-administrator' => 'BU Executive Admin',
                                'college-head' => 'College Head (Dean)',
                                'program-chair' => 'Program Chair',
                                default => ucwords(str_replace('-', ' ', $code))
                            };
                            $isActiveRole = ($code === $user?->role);
                        @endphp
                        <form method="POST" action="{{ route('switch-role') }}" class="w-full">
                            @csrf
                            <input type="hidden" name="role" value="{{ $code }}" />
                            <button type="submit" class="w-full text-left px-2 py-1.5 rounded-lg flex items-center justify-between text-xs font-medium hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors {{ $isActiveRole ? 'text-[#F47920] font-bold bg-orange-50/50' : 'text-zinc-700 dark:text-zinc-300' }}">
                                <span>{{ $title }}</span>
                                @if($isActiveRole)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#F47920] text-white">Active</span>
                                @endif
                            </button>
                        </form>
                    @endforeach
                    <flux:menu.separator />
                @endif

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