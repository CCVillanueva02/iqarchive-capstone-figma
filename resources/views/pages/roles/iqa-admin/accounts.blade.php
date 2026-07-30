<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#1b355a]">Accounts Management</h1>
            <p class="text-xs text-zinc-500 mt-1">Workspace: IQA Administrator &bull; Pre-register institutional identities &amp; roles</p>
        </div>

        <div>
            <flux:button variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs" icon="plus" wire:click="openCreateModal">
                {{ __('Add User') }}
            </flux:button>
        </div>
    </div>

    <!-- Filter panel -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs p-6 flex flex-col gap-4">
        <!-- Top Row: Status Filter Segment -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-xl self-start">
                <button type="button" wire:click="$set('statusFilter', '')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === '' ? 'bg-white text-[#1b355a] shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ __('All Accounts') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-slate-200/60 text-slate-700 text-[10px] font-bold">{{ $totalCount }}</span>
                </button>
                <button type="button" wire:click="$set('statusFilter', 'active')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'active' ? 'bg-[#1b355a] text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ __('Active') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/10 text-white/80 text-[10px] font-bold">{{ $activeCount }}</span>
                </button>
                <button type="button" wire:click="$set('statusFilter', 'pending_activation')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'pending_activation' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ __('Pending Activation') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/10 text-white/80 text-[10px] font-bold">{{ $pendingCount }}</span>
                </button>
                <button type="button" wire:click="$set('statusFilter', 'inactive')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'inactive' ? 'bg-[#F47920] text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ __('Deactivated') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/10 text-white/80 text-[10px] font-bold">{{ $inactiveCount }}</span>
                </button>
            </div>
            
            <div class="text-xs text-zinc-400 font-medium">
                {{ __('Showing :count accounts total', ['count' => $users->total()]) }}
            </div>
        </div>

        <!-- Bottom Row: Search & Role Filter -->
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="w-full md:w-72">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." icon="magnifying-glass" />
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('Filter by Role:') }}</span>
                <flux:select wire:model.live="roleFilter" placeholder="All Roles" class="w-full md:w-48">
                    <flux:select.option value="">All Roles</flux:select.option>
                    @foreach($roles as $role)
                    <flux:select.option value="{{ $role->role_name }}">{{ $role->description }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>

    <!-- Accounts Table Card -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-slate-500 font-semibold">
                        <th class="p-4 pl-6">Name</th>
                        <th class="p-4">Institutional Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">College / Department</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Registered Date</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($users as $user)
                    <tr wire:key="user-row-{{ $user->id }}" class="hover:bg-slate-50/40 transition-colors text-slate-700">
                        <!-- Name -->
                        <td class="p-4 pl-6 font-medium">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-[#586A85] font-bold flex items-center justify-center text-xs shrink-0 select-none">
                                    {{ $user->initials() }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[#1b355a] font-semibold text-xs">{{ $user->name }}</span>
                                    @if($user->status === 'pending_activation')
                                    <span class="text-[10px] text-amber-600 font-medium">Awaiting first sign-in</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="p-4 text-zinc-600 font-mono text-[11px]">{{ $user->email }}</td>

                        <!-- Role -->
                        <td class="p-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->assignedRoles() as $assignedRole)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-800 border border-blue-100">
                                        {{ $assignedRole->description }}
                                    </span>
                                @endforeach
                            </div>
                        </td>

                        <!-- Program/College -->
                        <td class="p-4 text-zinc-600">
                            @if($user->program)
                            {{ $user->program->name }} ({{ $user->program->code }})
                            @elseif($user->college)
                            {{ $user->college->name }} ({{ $user->college->code }})
                            @else
                            <span class="text-zinc-400">—</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="p-4">
                            @if($user->status === 'active')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Active
                            </span>
                            @elseif($user->status === 'pending_activation')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-300">
                                Pending Activation
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                Deactivated
                            </span>
                            @endif
                        </td>

                        <!-- Created At -->
                        <td class="p-4 text-zinc-500 text-[11px]">
                            {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                        </td>

                        <!-- Actions -->
                        <td class="p-4 pr-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button variant="ghost" size="sm" icon="pencil-square" wire:click="openEditModal({{ $user->id }})" title="Edit Account" />
                                <flux:button 
                                    variant="ghost" 
                                    size="sm" 
                                    icon="{{ $user->status === 'active' || $user->status === 'pending_activation' ? 'no-symbol' : 'check-circle' }}" 
                                    class="{{ $user->status === 'active' || $user->status === 'pending_activation' ? 'text-red-500 hover:text-red-700' : 'text-emerald-600 hover:text-emerald-700' }}"
                                    wire:click="openDeleteModal({{ $user->id }})" 
                                    title="{{ $user->status === 'active' || $user->status === 'pending_activation' ? 'Deactivate Account' : 'Activate Account' }}" 
                                />
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-zinc-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
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

    <!-- 3.1 PRE-REGISTRATION MODAL: Add / Pre-Register User -->
    <flux:modal wire:model="showCreateModal" class="max-w-md md:min-w-md" @close="closeCreateModal">
        <form wire:submit="createAccount" class="space-y-6">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#1b355a] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Pre-Register User') }}</flux:heading>
                </div>
                <flux:subheading class="mt-1 text-xs text-slate-500">
                    {{ __('Pre-registers institutional identity and role assignment. Account authentication is completed by the user via Google Workspace.') }}
                </flux:subheading>
            </div>

            <div class="space-y-4">
                <!-- 1. Institutional Email -->
                <div>
                    <flux:input 
                        wire:model="email" 
                        :label="__('Institutional Email')" 
                        type="email" 
                        required 
                        placeholder="user@bicol-u.edu.ph" 
                    />
                    <p class="text-[11px] text-slate-400 mt-1">Must match official Google Workspace domain (@bicol-u.edu.ph).</p>
                    @error('email')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- 2. Primary Role Selector -->
                <div>
                    <flux:select wire:model.live="role_id" :label="__('Primary Role')" required placeholder="Select primary role">
                        <flux:select.option value="">Select primary role</flux:select.option>
                        @foreach($roles as $role)
                            <flux:select.option value="{{ $role->id }}">{{ $role->description }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('role_id')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Roles (Multi-Role Support) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __('Additional Assigned Roles (Optional)') }}</label>
                    <div class="grid grid-cols-2 gap-2 bg-slate-50 p-3 rounded-xl border border-slate-200">
                        @foreach($roles as $role)
                            @if((string)$role->id !== (string)$role_id)
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer select-none hover:text-[#002B61]">
                                    <input type="checkbox" wire:model.live="selected_role_ids" value="{{ $role->id }}" class="rounded border-slate-300 text-[#F47920] focus:ring-[#F47920]">
                                    <span>{{ $role->description }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Check any additional roles held by this user (e.g. Task Force Lead/Member).</p>
                </div>

                <!-- 3. College / Department (Conditional Required) -->
                <div>
                    <flux:select wire:model.live="college_id" :label="__('College / Department') . ($this->isCollegeRequired() ? ' *' : '')" placeholder="Select College / Department" :required="$this->isCollegeRequired()">
                        <flux:select.option value="">Select College / Department</flux:select.option>
                        @foreach($colleges as $college)
                            <flux:select.option value="{{ $college->id }}">{{ $college->name }} ({{ $college->code }})</flux:select.option>
                        @endforeach
                    </flux:select>
                    @if($this->isCollegeRequired())
                        <p class="text-[11px] font-semibold text-amber-600 mt-1">Required for College Head, Program Chair, and IQA Member roles.</p>
                    @else
                        <p class="text-[11px] text-slate-400 mt-1">Required for College/Dept Head, Program Chair, and IQA Members.</p>
                    @endif
                    @error('college_id')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program (Optional) -->
                <div>
                    <flux:select wire:model="program_id" :label="__('Program (Optional)')" placeholder="None (Optional)" :disabled="empty($college_id)">
                        <flux:select.option value="">None (Optional)</flux:select.option>
                        @foreach($programs as $program)
                            <flux:select.option value="{{ $program->id }}">{{ $program->name }} ({{ $program->code }})</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

            </div>

            <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
                <flux:button variant="outline" wire:click="closeCreateModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">
                    {{ __('Pre-Register User') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit User Account Modal -->
    <flux:modal wire:model="showEditModal" class="max-w-md md:min-w-md" @close="closeEditModal">
        <form wire:submit="updateAccount" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Edit User Account') }}</flux:heading>
                <flux:subheading class="mt-1 text-xs text-slate-500">{{ __('Modify role and affiliation assignments for this user.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <flux:input wire:model="first_name" :label="__('First Name')" placeholder="First Name" />
                    </div>
                    <div>
                        <flux:input wire:model="last_name" :label="__('Last Name')" placeholder="Last Name" />
                    </div>
                </div>

                <div>
                    <flux:input 
                        wire:model="email" 
                        :label="__('Institutional Email Address')" 
                        type="email" 
                        required 
                        placeholder="user@bicol-u.edu.ph" 
                    />
                    @error('email')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <flux:select wire:model.live="role_id" :label="__('Primary Role')" required placeholder="Select primary role">
                        @foreach($roles as $role)
                            <flux:select.option value="{{ $role->id }}">{{ $role->description }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('role_id')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __('Additional Assigned Roles (Optional)') }}</label>
                    <div class="grid grid-cols-2 gap-2 bg-slate-50 p-3 rounded-xl border border-slate-200">
                        @foreach($roles as $role)
                            @if((string)$role->id !== (string)$role_id)
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer select-none hover:text-[#002B61]">
                                    <input type="checkbox" wire:model.live="selected_role_ids" value="{{ $role->id }}" class="rounded border-slate-300 text-[#F47920] focus:ring-[#F47920]">
                                    <span>{{ $role->description }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Check any additional roles held by this user (e.g. Task Force Lead/Member).</p>
                </div>

                <div>
                    <flux:select wire:model.live="college_id" :label="__('College / Department') . ($this->isCollegeRequired() ? ' *' : '')" placeholder="Select College / Department" :required="$this->isCollegeRequired()">
                        <flux:select.option value="">Select College / Department</flux:select.option>
                        @foreach($colleges as $college)
                            <flux:select.option value="{{ $college->id }}">{{ $college->name }} ({{ $college->code }})</flux:select.option>
                        @endforeach
                    </flux:select>
                    @if($this->isCollegeRequired())
                        <p class="text-[11px] font-semibold text-amber-600 mt-1">Required for College Head, Program Chair, and IQA Member roles.</p>
                    @endif
                    @error('college_id')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:select wire:model="program_id" :label="__('Program (Optional)')" placeholder="None (Optional)" :disabled="empty($college_id)">
                        <flux:select.option value="">None (Optional)</flux:select.option>
                        @foreach($programs as $program)
                            <flux:select.option value="{{ $program->id }}">{{ $program->name }} ({{ $program->code }})</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
                <flux:button variant="outline" wire:click="closeEditModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">{{ __('Save Changes') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Deactivate/Activate User Account Modal -->
    <flux:modal wire:model="showDeleteModal" class="max-w-md md:min-w-md" @close="closeDeleteModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $targetUserStatus === 'active' || $targetUserStatus === 'pending_activation' ? __('Deactivate Account') : __('Activate Account') }}
                </flux:heading>
                <flux:subheading class="mt-1 text-xs text-slate-500">
                    {{ $targetUserStatus === 'active' || $targetUserStatus === 'pending_activation'
                        ? __('Are you sure you want to deactivate this account? Deactivating preserves referential integrity and historical document logs.') 
                        : __('Are you sure you want to reactivate this account? Reactivating enables the user to log back in via Google Workspace.') 
                    }}
                </flux:subheading>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button variant="outline" wire:click="closeDeleteModal">{{ __('Cancel') }}</flux:button>
                @if($targetUserStatus === 'active' || $targetUserStatus === 'pending_activation')
                    <flux:button type="button" variant="danger" wire:click="toggleAccountStatus">{{ __('Deactivate Account') }}</flux:button>
                @else
                    <flux:button type="button" variant="primary" style="--color-accent: #10b981; --color-accent-foreground: #ffffff;" class="text-white border-none shadow-xs" wire:click="toggleAccountStatus">{{ __('Activate Account') }}</flux:button>
                @endif
            </div>
        </div>
    </flux:modal>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                const data = event[0];
                Swal.fire({
                    icon: data.icon || 'success',
                    title: data.title || '',
                    text: data.text || '',
                    confirmButtonColor: '#F47920',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200/60 shadow-lg font-sans',
                        title: 'text-[#1b355a] font-bold text-xl',
                        confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white'
                    }
                });
            });
        });
    </script>
</div>