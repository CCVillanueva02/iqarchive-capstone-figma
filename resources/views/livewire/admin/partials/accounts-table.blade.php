<div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-body-sm whitespace-nowrap">
            <thead>
                <tr class="border-b border-slate-200/80 bg-surface-subtle text-slate-500 font-bold uppercase tracking-wider text-label-xs">
                    <th class="py-3.5 px-4 pl-6">Institutional User</th>
                    <th class="py-3.5 px-4">Email Address</th>
                    <th class="py-3.5 px-4">Role Assignment</th>
                    <th class="py-3.5 px-4">College / Program</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4">Registered Date</th>
                    <th class="py-3.5 px-4 pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($users as $user)
                <tr wire:key="user-row-{{ $user->id }}" class="hover:bg-slate-50/70 transition-colors group">
                    <!-- Name & Identity -->
                    <td class="py-3.5 px-4 pl-6">
                        <div class="flex items-center gap-3">
                            <div class="relative shrink-0 select-none">
                                @if($user->avatar_url)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-xl object-cover border border-slate-200 shadow-xs" referrerpolicy="no-referrer" />
                                @else
                                    <div class="w-9 h-9 rounded-xl bg-linear-to-br from-slate-100 to-slate-200 border border-slate-200/80 text-primary font-bold flex items-center justify-center text-body-sm shadow-2xs">
                                        {{ $user->initials() }}
                                    </div>
                                @endif
                                @if($user->status === 'active')
                                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                @elseif($user->status === 'pending_activation')
                                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-amber-500 ring-2 ring-white"></span>
                                @else
                                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-slate-400 ring-2 ring-white"></span>
                                @endif
                            </div>

                            <div class="flex flex-col">
                                <span class="font-bold text-primary-dark group-hover:text-brand-orange transition-colors">
                                    {{ $user->name }}
                                </span>
                                @if($user->status === 'pending_activation')
                                    <span class="text-label-xs text-amber-700 font-medium">Awaiting first sign-in</span>
                                @elseif($user->is_super_admin ?? false)
                                    <span class="text-label-xs text-purple-700 font-semibold">Super Admin</span>
                                @endif
                            </div>
                        </div>
                    </td>

                    <!-- Institutional Email -->
                    <td class="py-3.5 px-4">
                        <span class="font-mono text-label text-slate-600 select-all">
                            {{ $user->email }}
                        </span>
                    </td>

                    <!-- Role Assignment -->
                    <td class="py-3.5 px-4">
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($user->assignedRoles() as $assignedRole)
                                @php
                                    $roleBadge = match($assignedRole->role_name) {
                                        'system-administrator' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'iqa-staff', 'iqa-admin' => 'bg-primary/10 text-primary border-primary/20',
                                        'college-head' => 'bg-surface-subtle text-primary-dark border-primary/15',
                                        'task-force-member' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'accreditor' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'university-administrator' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-semibold border {{ $roleBadge }}">
                                    {{ $assignedRole->description }}
                                </span>
                            @endforeach
                        </div>
                    </td>

                    <!-- College / Program Code Affiliation -->
                    <td class="py-3.5 px-4">
                        @if($user->program)
                            <span class="inline-flex items-center gap-1 font-mono text-label-xs font-bold text-slate-700 bg-surface-subtle px-2 py-0.5 rounded border border-slate-200" title="{{ $user->college?->name ? $user->college->name . ' — ' : '' }}{{ $user->program->name }}">
                                @if($user->college)
                                    <img src="{{ $user->college->logo }}" alt="Logo" class="w-4 h-4 object-contain shrink-0" onerror="this.style.display='none'">
                                    <span class="text-primary">{{ $user->college->code }}</span>
                                    <span class="text-slate-300">/</span>
                                @endif
                                <span>{{ $user->program->code }}</span>
                            </span>
                        @elseif($user->college)
                            <span class="inline-flex items-center gap-1 font-mono text-label-xs font-bold text-primary bg-primary/10 px-2 py-0.5 rounded border border-primary/20" title="{{ $user->college->name }}">
                                <img src="{{ $user->college->logo }}" alt="Logo" class="w-4 h-4 object-contain shrink-0" onerror="this.style.display='none'">
                                {{ $user->college->code }}
                            </span>
                        @else
                            <span class="text-label-xs text-slate-400 italic">Institutional</span>
                        @endif
                    </td>

                    <!-- Status Badge -->
                    <td class="py-3.5 px-4 text-center">
                        @if($user->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        @elseif($user->status === 'pending_activation')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-amber-50 text-amber-700 border border-amber-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Pending Activation
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-label-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                Deactivated
                            </span>
                        @endif
                    </td>

                    <!-- Registered Date -->
                    <td class="py-3.5 px-4">
                        <div class="flex flex-col text-label-xs">
                            <span class="font-semibold text-slate-700">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                            </span>
                            @if($user->created_at)
                                <span class="text-slate-400 font-normal">{{ $user->created_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </td>

                    <!-- Row Actions -->
                    <td class="py-3.5 px-4 pr-6 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <!-- Edit Account -->
                            <button 
                                type="button" 
                                wire:click="openEditModal({{ $user->id }})" 
                                title="Edit User Identity & Roles"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-primary hover:bg-slate-100 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <!-- Activate / Deactivate Toggle -->
                            <button 
                                type="button" 
                                wire:click="openDeleteModal({{ $user->id }})" 
                                title="{{ $user->status === 'active' || $user->status === 'pending_activation' ? 'Deactivate Account' : 'Activate Account' }}"
                                class="p-1.5 rounded-lg transition-colors cursor-pointer {{ $user->status === 'active' || $user->status === 'pending_activation' ? 'text-rose-500 hover:text-rose-700 hover:bg-rose-50' : 'text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50' }}">
                                @if($user->status === 'active' || $user->status === 'pending_activation')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-slate-500">
                        <div class="max-w-sm mx-auto space-y-2">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-body-sm font-bold text-slate-700">No accounts found</p>
                            <p class="text-label-xs text-slate-400">Try adjusting your filters, searching for another keyword, or pre-registering a new user.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-surface-subtle/50">
        {{ $users->links() }}
    </div>
    @endif
</div>
