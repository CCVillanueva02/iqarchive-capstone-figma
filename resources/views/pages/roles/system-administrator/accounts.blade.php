<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#1b355a]">Accounts</h1>
            <p class="text-xs text-zinc-500 mt-1">Workspace: System Administrator &bull; User Accounts</p>
        </div>

        <div>
            <flux:button variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs" icon="plus" wire:click="openCreateModal">
                {{ __('Create Account') }}
            </flux:button>
        </div>
    </div>

    <!-- Filter panel -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs p-6 flex flex-col gap-4">
        <!-- Top Row: Status Filter Segment -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl self-start">
                <button type="button" wire:click="$set('statusFilter', '')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === '' ? 'bg-white text-[#1b355a] shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ __('All Accounts') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-slate-200/60 text-slate-700 text-[10px] font-bold">{{ $totalCount }}</span>
                </button>
                <button type="button" wire:click="$set('statusFilter', 'active')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'active' ? 'bg-[#1b355a] text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ __('Active') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/10 text-white/80 text-[10px] font-bold">{{ $activeCount }}</span>
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
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-slate-500 font-semibold">
                        <th class="p-4 pl-6">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Department / College</th>
                        <th class="p-4">Status</th>
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
                        <td class="p-4">
                            @if($user->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5"></span>
                                    {{ __('Active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-800 border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-1.5"></span>
                                    {{ __('Deactivated') }}
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="p-4 pr-6 text-right space-x-1">
                            <flux:button variant="ghost" size="sm" icon="pencil" wire:click="openEditModal({{ $user->id }})" class="cursor-pointer text-slate-500 hover:text-blue-600" />
                            @if($user->status === 'active')
                                <flux:button variant="ghost" size="sm" icon="power" wire:click="openDeleteModal({{ $user->id }})" class="cursor-pointer text-amber-500 hover:text-amber-600 hover:bg-amber-50" title="Deactivate Account" />
                            @else
                                <flux:button variant="ghost" size="sm" icon="power" wire:click="openDeleteModal({{ $user->id }})" class="cursor-pointer text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50" title="Activate Account" />
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-zinc-400">
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

    <!-- Create User Account Modal -->
    <flux:modal wire:model="showCreateModal" class="max-w-md md:min-w-md" @close="closeCreateModal">
        <form wire:submit="createAccount" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Create Account') }}</flux:heading>
                <flux:subheading>{{ __('Fill in details to create a new active user account.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:input wire:model="first_name" :label="__('First Name')" required placeholder="Enter first name" />
                <flux:input wire:model="middle_name" :label="__('Middle Name')" placeholder="Enter middle name (optional)" />
                <flux:input wire:model="last_name" :label="__('Last Name')" required placeholder="Enter last name" />
                <flux:input wire:model="email" :label="__('Email Address')" type="email" required placeholder="Enter email address" />
                <flux:input wire:model="password" :label="__('Temporary Password')" type="password" required placeholder="Enter temp password" viewable />
                
                <flux:select wire:model.live="role_id" :label="__('Role')" required placeholder="Select a role">
                    @foreach($roles as $role)
                        <flux:select.option value="{{ $role->id }}">{{ $role->description }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="college_id" :label="__('College (Affiliated)')" placeholder="None (Optional)">
                    <flux:select.option value="">None (Optional)</flux:select.option>
                    @foreach($colleges as $college)
                        <flux:select.option value="{{ $college->id }}">{{ $college->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="program_id" :label="__('Program (Affiliated)')" placeholder="None (Optional)" :disabled="empty($college_id)">
                    <flux:select.option value="">None (Optional)</flux:select.option>
                    @foreach($programs as $program)
                        <flux:select.option value="{{ $program->id }}">{{ $program->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button variant="outline" wire:click="closeCreateModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">{{ __('Create') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit User Account Modal -->
    <flux:modal wire:model="showEditModal" class="max-w-md md:min-w-md" @close="closeEditModal">
        <form wire:submit="updateAccount" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Edit Account') }}</flux:heading>
                <flux:subheading>{{ __('Modify details of the user account.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:input wire:model="first_name" :label="__('First Name')" required placeholder="Enter first name" />
                <flux:input wire:model="middle_name" :label="__('Middle Name')" placeholder="Enter middle name (optional)" />
                <flux:input wire:model="last_name" :label="__('Last Name')" required placeholder="Enter last name" />
                <flux:input wire:model="email" :label="__('Email Address')" type="email" required placeholder="Enter email address" />
                <flux:input wire:model="password" :label="__('New Password')" type="password" placeholder="Leave blank to keep unchanged" viewable />
                
                <flux:select wire:model.live="role_id" :label="__('Role')" required placeholder="Select a role">
                    @foreach($roles as $role)
                        <flux:select.option value="{{ $role->id }}">{{ $role->description }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="college_id" :label="__('College (Affiliated)')" placeholder="None (Optional)">
                    <flux:select.option value="">None (Optional)</flux:select.option>
                    @foreach($colleges as $college)
                        <flux:select.option value="{{ $college->id }}">{{ $college->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="program_id" :label="__('Program (Affiliated)')" placeholder="None (Optional)" :disabled="empty($college_id)">
                    <flux:select.option value="">None (Optional)</flux:select.option>
                    @foreach($programs as $program)
                        <flux:select.option value="{{ $program->id }}">{{ $program->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="flex gap-3 justify-end">
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
                    {{ $targetUserStatus === 'active' ? __('Deactivate Account') : __('Activate Account') }}
                </flux:heading>
                <flux:subheading>
                    {{ $targetUserStatus === 'active' 
                        ? __('Are you sure you want to deactivate this account? Deactivating will hide the account from active views, but preserves the upload history.') 
                        : __('Are you sure you want to reactivate this account? Reactivating will enable the user to log back in and collaborate.') 
                    }}
                </flux:subheading>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button variant="outline" wire:click="closeDeleteModal">{{ __('Cancel') }}</flux:button>
                @if($targetUserStatus === 'active')
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
