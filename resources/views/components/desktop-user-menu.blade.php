<flux:dropdown position="bottom" align="start">
    <flux:sidebar.profile
        :name="auth()->user()->name"
        :initials="auth()->user()->initials()"
        :avatar="auth()->user()->avatar_url"
        icon:trailing="chevrons-up-down"
        data-test="sidebar-menu-button"
    />

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <flux:avatar
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                :src="auth()->user()->avatar_url"
            />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        @php
            $currentUser = auth()->user();
            $userRoles = $currentUser ? $currentUser->assignedRoles() : collect();
            $activeRole = $currentUser?->role;
        @endphp

        @if($userRoles->count() > 1)
            <flux:menu.separator />
            <div class="px-2 py-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Switch Role Dashboard</span>
            </div>
            @foreach($userRoles as $r)
                @php
                    $roleCode = $r->role_name;
                    $roleTitle = match($roleCode) {
                        'task-force' => 'QA Task Force Lead',
                        'task-force-member' => 'QA Task Force Member',
                        'system-administrator' => 'System Administrator',
                        'iqa-admin' => 'IQA Admin',
                        'iqa-member' => 'IQA Staff Member',
                        'accreditor' => 'AACCUP Accreditor',
                        'university-administrator' => 'BU Executive Admin',
                        'college-head' => 'College Head (Dean)',
                        'program-chair' => 'Program Chair',
                        default => ucwords(str_replace('-', ' ', $roleCode))
                    };
                    $isActive = ($roleCode === $activeRole);
                @endphp
                <form method="POST" action="{{ route('switch-role') }}" class="w-full">
                    @csrf
                    <input type="hidden" name="role" value="{{ $roleCode }}" />
                    <button type="submit" class="w-full text-left px-2 py-1.5 rounded-lg flex items-center justify-between text-xs font-medium hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors {{ $isActive ? 'text-[#F47920] font-bold bg-orange-50/50' : 'text-zinc-700 dark:text-zinc-300' }}">
                        <span>{{ $roleTitle }}</span>
                        @if($isActive)
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#F47920] text-white">Active</span>
                        @endif
                    </button>
                </form>
            @endforeach
        @endif

        <flux:menu.separator />
        <flux:menu.radio.group>
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
