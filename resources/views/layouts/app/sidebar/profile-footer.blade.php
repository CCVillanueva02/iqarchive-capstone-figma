{{--
    IQArchive Sidebar: User Profile & Account Footer
    Interactive user account drawer with role switcher, profile settings, and session termination.
--}}

@php
    $user = auth()->user();
    $roleLabel = match($user?->role) {
        'system-administrator' => 'System Admin',
        'iqa-staff', 'iqa-admin', 'iqa-member' => 'IQA Member',
        'accreditor' => 'Accreditor',
        'university-administrator' => 'BU Executive',
        'task-force-member', 'task-force' => 'Task Force Member',
        'college-head' => 'College Head',
        default => 'User'
    };
    $userAssignedRoles = $user ? $user->assignedRoles() : collect();
@endphp

<div class="px-4 py-3.5 border-t border-white/10 mt-auto bg-black/15">
    <flux:dropdown position="top" align="start" class="w-full">
        <button type="button"
            class="w-full text-left p-2 rounded-xl hover:bg-white/10 transition-all cursor-pointer flex items-center justify-between gap-3 group focus:outline-none select-none">
            <div class="flex items-center gap-3 min-w-0 flex-1">
                @if($user?->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover border-2 border-white/80 shrink-0" />
                @else
                <div class="w-9 h-9 rounded-full bg-brand-orange border-2 border-white/80 text-white font-bold flex items-center justify-center text-xs shrink-0">
                    {{ $user?->initials() }}
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="text-body-sm font-bold text-white truncate leading-tight group-hover:text-white">
                        {{ $user?->name }}
                    </div>
                    <div class="text-label text-white/60 truncate flex items-center gap-1.5 mt-0.5">
                        <span>{{ $roleLabel }}</span>
                        @if($userAssignedRoles->count() > 1)
                        <span class="text-label-xs bg-brand-orange px-1.5 py-0.5 rounded-full text-white font-bold">Multi</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Visible Interactive Affordance (Chevron Up) -->
            <div class="p-1 rounded-lg text-white/40 group-hover:text-white group-hover:bg-white/10 transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
                </svg>
            </div>
        </button>

        <flux:menu>
            @if($userAssignedRoles->count() > 1)
            <div class="px-2 py-1">
                <span class="text-label font-bold uppercase tracking-wider text-zinc-400">Switch Role View</span>
            </div>
            @foreach($userAssignedRoles as $r)
            @php
                $code = $r->role_name;
                $title = match($code) {
                    'system-administrator' => 'System Administrator',
                    'iqa-staff', 'iqa-admin', 'iqa-member' => 'IQA Member',
                    'accreditor' => 'AACCUP Accreditor',
                    'university-administrator' => 'BU Executive',
                    'college-head' => 'College Head (Dean)',
                    'task-force-member', 'task-force' => 'Task Force Member',
                    default => ucwords(str_replace('-', ' ', $code))
                };
                $isActiveRole = ($code === $user?->role);
            @endphp
            <form method="POST" action="{{ route('switch-role') }}" class="w-full">
                @csrf
                <input type="hidden" name="role" value="{{ $code }}" />
                <button type="submit" class="w-full text-left px-2 py-1.5 rounded-lg flex items-center justify-between text-body-sm font-medium hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors {{ $isActiveRole ? 'text-brand-orange font-bold bg-brand-orange/10' : 'text-zinc-700 dark:text-zinc-300' }}">
                    <span>{{ $title }}</span>
                    @if($isActiveRole)
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-label-xs font-bold bg-brand-orange text-white">Active</span>
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
                    class="w-full cursor-pointer text-xs text-rose-600 hover:text-rose-700">
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</div>
