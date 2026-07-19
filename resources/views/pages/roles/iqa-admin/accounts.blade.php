

<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#1b355a]">Accounts</h1>
            <p class="text-xs text-zinc-500 mt-1">Workspace: IQA Administrator &bull; User Accounts</p>
        </div>

        <!-- Button placeholder for next step (Create Account) -->
        <div>
            <flux:button variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs" icon="plus">
                {{ __('Create Account') }}
            </flux:button>
        </div>
    </div>

    <!-- Filter panel -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs p-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-72">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." icon="magnifying-glass" />
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <flux:select wire:model.live="roleFilter" placeholder="All Roles" class="w-full md:w-48">
                <flux:select.option value="">All Roles</flux:select.option>
                @foreach($roles as $role)
                <flux:select.option value="{{ $role->role_name }}">{{ $role->description }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>

    <!-- Accounts Table Card -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-slate-500 font-semibold">
                        <th class="p-4 pl-6">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Department / College</th>
                        <th class="p-4 pr-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/40 transition-colors text-slate-700">
                        <!-- Name -->
                        <td class="p-4 pl-6 font-medium">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-[#586A85] font-bold flex items-center justify-center text-xs shrink-0 select-none">
                                    {{ $user->initials() }}
                                </div>
                                <span class="text-[#1b355a] font-semibold text-sm">{{ $user->name }}</span>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="p-4 text-zinc-600 font-mono text-xs">{{ $user->email }}</td>

                        <!-- Role -->
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-100">
                                {{ $user->roleRelation->description ?? $user->role }}
                            </span>
                        </td>

                        <!-- Program/College -->
                        <td class="p-4 text-zinc-600">
                            @if($user->program)
                            {{ $user->program->name }} ({{ $user->program->code }})
                            @elseif($user->college)
                            {{ $user->college->name }} ({{ $user->college->code }})
                            @else
                            <span class="text-zinc-400 text-xs">—</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="p-4 pr-6">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5"></span>
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-zinc-400">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-zinc-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20M3 11.627a1.018 1.018 0 01.832-.374h.012c.42 0 .783.277.935.671.218.567.49 1.107.809 1.612.336.533.155 1.236-.374 1.56-.527.323-1.224.162-1.56-.362a11.36 11.36 0 01-.659-1.807A1.018 1.018 0 013 11.627zm14.89-.374a1.019 1.019 0 01.828.374c.06.082.109.167.148.256.222.508.417 1.04.58 1.593.18.614-.155 1.258-.756 1.432-.6.174-1.24-.173-1.428-.78a11.352 11.352 0 00-.472-1.392 1.014 1.014 0 01.1-.983 1.019 1.019 0 01.828-.374h-.028z" />
                                    </svg>
                                </div>
                                <p class="font-medium text-sm">No accounts found</p>
                                <p class="text-xs text-zinc-500">Try adjusting your filters or search terms.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>