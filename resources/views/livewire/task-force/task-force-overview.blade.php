<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
    <!-- Page Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#1b355a] flex items-center gap-2.5">
                <svg class="w-7 h-7 text-[#F47920]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm14 10v-2a4 4 0 010 7.75"></path>
                </svg>
                Task Force Management
            </h1>
            <p class="text-xs text-zinc-500 mt-1">Assemble accreditation task forces, submit rosters for IQA Admin approval, and monitor compliance progress.</p>
        </div>

        @if($this->canCreate)
        <div>
            <flux:button variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs hover:opacity-95" icon="plus" wire:click="openCreateModal">
                {{ __('Create Task Force') }}
            </flux:button>
        </div>
        @endif
    </div>

    <!-- Overview Stats Summary Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
            <div>
                <span class="text-xs text-slate-500 font-medium block">Active Task Forces</span>
                <span class="text-2xl font-extrabold text-[#1b355a] mt-1 block">{{ $totalActiveCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
            <div>
                <span class="text-xs text-slate-500 font-medium block">Pending Approval</span>
                <span class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $totalPendingCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
            <div>
                <span class="text-xs text-slate-500 font-medium block">Active Members Assigned</span>
                <span class="text-2xl font-extrabold text-[#F47920] mt-1 block">{{ $totalMembersAssignedCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#F47920] flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 flex items-center justify-between shadow-3xs">
            <div>
                <span class="text-xs text-slate-500 font-medium block">Completed Task Forces</span>
                <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">{{ $totalCompletedCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs p-5 flex flex-col md:flex-row gap-4 justify-between items-center">
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-xl w-full md:w-auto">
            <button type="button" wire:click="$set('statusFilter', 'active')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'active' ? 'bg-[#1b355a] text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                Active <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-bold">{{ $totalActiveCount }}</span>
            </button>
            <button type="button" wire:click="$set('statusFilter', 'pending_approval')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'pending_approval' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                Pending Approval <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-bold">{{ $totalPendingCount }}</span>
            </button>
            <button type="button" wire:click="$set('statusFilter', 'completed')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'completed' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                Completed <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-bold">{{ $totalCompletedCount }}</span>
            </button>
            <button type="button" wire:click="$set('statusFilter', '')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === '' ? 'bg-[#F47920] text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                All
            </button>
        </div>

        <!-- Search & College Dropdown -->
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="w-full sm:w-64">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search task force or mandate..." icon="magnifying-glass" />
            </div>

            <div class="w-full sm:w-56">
                <flux:select wire:model.live="collegeFilter" placeholder="All Colleges">
                    <flux:select.option value="">All Colleges</flux:select.option>
                    @foreach($colleges as $col)
                    <flux:select.option value="{{ $col->id }}">{{ $col->code }} - {{ $col->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>

    <!-- 6.2 Output Screen: Task Force Overview Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($taskForces as $tf)
        @php
            $progress = $tf->progress_percentage;
            $statusClasses = match($tf->status) {
                'active' => 'bg-blue-50 text-blue-700 border-blue-200',
                'pending_approval' => 'bg-amber-50 text-amber-700 border-amber-300 animate-pulse',
                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'disbanded' => 'bg-slate-100 text-slate-600 border-slate-200',
                default => 'bg-slate-50 text-slate-600 border-slate-200',
            };
            $statusLabel = match($tf->status) {
                'pending_approval' => 'Pending Approval',
                default => ucfirst($tf->status),
            };
        @endphp
        <div class="bg-white border border-slate-200/70 rounded-2xl shadow-3xs flex flex-col justify-between overflow-hidden hover:shadow-md transition-shadow group">
            <div class="p-6 flex flex-col gap-4">
                <!-- Top Row: Name & Status Badge -->
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-[#1b355a] border border-slate-200 mb-1.5">
                            {{ $tf->college->code }} @if($tf->program)&bull; {{ $tf->program->code }}@endif
                        </span>
                        <h3 class="text-base font-bold text-[#1b355a] group-hover:text-[#F47920] transition-colors leading-snug line-clamp-2">
                            {{ $tf->name }}
                        </h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border shrink-0 {{ $statusClasses }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                <!-- Purpose / Mandate excerpt removed -->

                <!-- Members Avatars Stack & Roster count -->
                <div>
                    <div class="flex items-center justify-between text-xs mb-2">
                        <span class="text-slate-500 font-semibold">Proposed / Assigned</span>
                        <span class="text-[#1b355a] font-bold">
                            @if($tf->status === 'pending_approval')
                                {{ is_array($tf->proposed_members) ? count($tf->proposed_members) : 0 }} Proposed
                            @else
                                {{ $tf->members->count() }} Users
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Progress Meter / Accreditation Area -->
                <div class="pt-2 border-t border-slate-100">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="text-slate-500 font-medium">Accreditation Area Progress</span>
                        <span class="font-bold text-[#1b355a]">{{ $progress }}%</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 {{ $progress >= 100 ? 'bg-emerald-500' : ($progress >= 50 ? 'bg-[#F47920]' : 'bg-blue-600') }}" style="width: {{ max($progress, 5) }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- Card Actions Footer -->
            <div class="px-6 py-3.5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between gap-3 text-xs">
                <button type="button" wire:click="openRosterModal({{ $tf->id }})" class="font-semibold text-[#1b355a] hover:text-[#F47920] flex items-center gap-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Roster &amp; Mandate
                </button>

                @if($tf->status === 'pending_approval' && $this->canManage)
                <!-- IQA Admin Action: Approve Task Force Roster -->
                <button type="button" wire:click="approveTaskForce({{ $tf->id }})" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition shadow-xs flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Approve Roster
                </button>
                @elseif($this->canManage)
                <flux:dropdown align="end">
                    <button type="button" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 19a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                    <flux:menu>
                        @if($tf->status !== 'active')
                        <flux:menu.item wire:click="updateTaskForceStatus({{ $tf->id }}, 'active')" icon="play" class="text-xs cursor-pointer">
                            Set Active
                        </flux:menu.item>
                        @endif
                        @if($tf->status !== 'completed')
                        <flux:menu.item wire:click="updateTaskForceStatus({{ $tf->id }}, 'completed')" icon="check-circle" class="text-xs cursor-pointer text-emerald-600">
                            Mark as Completed
                        </flux:menu.item>
                        @endif
                        @if($tf->status !== 'disbanded')
                        <flux:menu.item wire:click="updateTaskForceStatus({{ $tf->id }}, 'disbanded')" icon="x-circle" class="text-xs cursor-pointer text-red-600">
                            Disband Task Force
                        </flux:menu.item>
                        @endif
                    </flux:menu>
                </flux:dropdown>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white border border-slate-200/70 rounded-2xl p-12 text-center flex flex-col items-center justify-center gap-3">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm14 10v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                </svg>
            </div>
            <h3 class="text-base font-bold text-[#1b355a]">No Task Forces Found</h3>
            <p class="text-xs text-slate-500 max-w-sm">No task forces match your search criteria. Try clearing filters or create a new task force.</p>
            @if($this->canCreate)
            <flux:button variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs mt-2" icon="plus" wire:click="openCreateModal">
                Create Task Force
            </flux:button>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($taskForces->hasPages())
    <div class="mt-4">
        {{ $taskForces->links() }}
    </div>
    @endif


    <!-- ========================================== -->
    <!-- 6.1 INPUT SCREEN: Create Task Force Modal -->
    <!-- ========================================== -->
    <flux:modal wire:model="showCreateModal" class="max-w-2xl md:min-w-2xl" @close="closeCreateModal">
        <form wire:submit="createTaskForce" class="space-y-6">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-[#F47920] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Create Task Force') }}</flux:heading>
                </div>
                <flux:subheading>{{ __('Assemble a task force for college accreditation tasks and assign eligible faculty members.') }}</flux:subheading>
            </div>

            @if((auth()->user()->role ?? '') === 'college-head')
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 flex items-start gap-3 text-xs text-amber-900">
                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <span class="font-bold">Submitting as College Head (Dean):</span>
                    <p class="mt-0.5">This task force and member roster will be submitted to the <strong>IQA Staff</strong> for review and official account assignment approval.</p>
                </div>
            </div>
            @endif

            <div class="space-y-5">
                <!-- 1. Task Force Name -->
                <div>
                    <flux:input 
                        wire:model="name" 
                        :label="__('Task Force Name')" 
                        required 
                        placeholder="e.g. BSCS AACCUP Level III Task Force" 
                    />
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-[11px] text-slate-400">3 to 150 characters. Must be unique across the system.</span>
                        <span class="text-[11px] font-mono text-slate-400">{{ strlen($name) }}/150</span>
                    </div>

                </div>

                <!-- 2. Assigned College (Defined) & Program Input -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Assigned College (Defined / Locked Scope) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Assigned College <span class="text-slate-400 font-normal ml-1">(Defined)</span>
                        </label>

                        @if($definedCollege)
                        <div class="bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-2.5 flex items-center justify-between text-xs text-[#1b355a] font-bold">
                            <span class="truncate">{{ $definedCollege->name }} ({{ $definedCollege->code }})</span>
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        @else
                        <flux:select wire:model.live="college_id" required placeholder="Select Assigned College">
                            @foreach($colleges as $col)
                                <flux:select.option value="{{ $col->id }}">{{ $col->name }} ({{ $col->code }})</flux:select.option>
                            @endforeach
                        </flux:select>
                        @endif
                    </div>

                    <!-- Program Input -->
                    <div>
                        <flux:select wire:model="program_id" :label="__('Assigned Program')" placeholder="Select Program" required>
                            <flux:select.option value="">Select Program</flux:select.option>
                            @foreach($availablePrograms as $prog)
                                <flux:select.option value="{{ $prog->id }}">{{ $prog->name }} ({{ $prog->code }})</flux:select.option>
                            @endforeach
                        </flux:select>

                    </div>
                </div>

                <!-- 3. Manual Member Entry -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-slate-700">
                            Propose Members <span class="text-red-500">*</span>
                        </label>
                    </div>

                    <!-- Add Member Form -->
                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 flex flex-col gap-3">
                        <h4 class="font-bold text-sm text-primary-dark">Add New Member</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <flux:input wire:model="newName" placeholder="Full Name" />
                            <flux:input wire:model="newEmail" type="email" placeholder="BU Email" />
                            <flux:input wire:model="newPhone" placeholder="Phone Number" />
                        </div>
                        <div class="flex justify-end mt-1">
                            <flux:button type="button" size="sm" variant="primary" wire:click="addMember">
                                Add As Member
                            </flux:button>
                        </div>
                    </div>

                    <!-- List of Added Members -->
                    <div class="mt-4">
                        <h4 class="font-bold text-sm text-primary-dark mb-2">Proposed Members List</h4>
                        @if(empty($proposedMembers))
                            <div class="text-sm text-zinc-500 italic p-3 bg-white border border-slate-100 rounded-lg text-center">
                                No members added yet.
                            </div>
                        @else
                            <ul class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($proposedMembers as $index => $member)
                                    <li class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-lg shadow-sm">
                                        <div class="flex flex-col">
                                            <span class="text-body-sm font-bold text-zinc-800">{{ $member['name'] }}</span>
                                            <span class="text-label-xs text-zinc-500">{{ $member['email'] }} • {{ $member['phone'] }}</span>
                                        </div>
                                        <button type="button" wire:click="removeMember({{ $index }})" class="text-rose-500 hover:text-rose-700 p-1 rounded-full hover:bg-rose-50 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    
                    @error('proposedMembers')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


            <!-- Submit & Cancel Actions -->
            <div class="flex gap-3 justify-end pt-2 border-t border-slate-100">
                <flux:button variant="outline" wire:click="closeCreateModal">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary" style="--color-accent: #F47920; --color-accent-foreground: #ffffff;" class="text-white font-semibold border-none shadow-xs">
                    {{ in_array(auth()->user()->role ?? '', ['college-head', 'program-chair']) ? __('Submit Task Force Proposal') : __('Create Task Force') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- ========================================== -->
    <!-- Member Roster Drawer / Detail View Modal   -->
    <!-- ========================================== -->
    <flux:modal wire:model="showRosterModal" class="max-w-2xl md:min-w-2xl" @close="closeRosterModal">
        @if($selectedTaskForce)
        <div class="space-y-6">
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-[#1b355a] border border-slate-200 mb-2">
                    {{ $selectedTaskForce->college->name }} @if($selectedTaskForce->program) &bull; {{ $selectedTaskForce->program->name }} @endif
                </span>
                <flux:heading size="lg" class="text-[#1b355a] font-bold">{{ $selectedTaskForce->name }}</flux:heading>
                <flux:subheading>Task Force Overview &amp; Member Roster</flux:subheading>
            </div>

            <!-- Details metadata grid -->
            <div class="grid grid-cols-3 gap-3 text-xs bg-slate-50 p-3 rounded-xl border border-slate-200/70 mt-4">
                <div>
                    <span class="text-slate-400 block text-[10px] font-semibold uppercase">Created By</span>
                    <span class="font-semibold text-[#1b355a]">{{ $selectedTaskForce->creator->name ?? 'System Admin' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] font-semibold uppercase">Date Assembled</span>
                    <span class="font-semibold text-[#1b355a]">{{ $selectedTaskForce->created_at->format('M d, Y') }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] font-semibold uppercase">Status</span>
                    <span class="font-bold capitalize text-blue-700">{{ str_replace('_', ' ', $selectedTaskForce->status) }}</span>
                </div>
            </div>

            <!-- Member Roster List -->
            <div>
                <h4 class="text-xs font-bold text-[#1b355a] uppercase tracking-wider mb-3">
                    @if($selectedTaskForce->status === 'pending_approval')
                        Proposed Member Roster ({{ is_array($selectedTaskForce->proposed_members) ? count($selectedTaskForce->proposed_members) : 0 }})
                    @else
                        Assigned Member Roster ({{ $selectedTaskForce->members->count() }})
                    @endif
                </h4>
                <div class="divide-y divide-slate-100 border border-slate-200 rounded-xl overflow-hidden">
                    @if($selectedTaskForce->status === 'pending_approval' && is_array($selectedTaskForce->proposed_members))
                        @foreach($selectedTaskForce->proposed_members as $member)
                        <div class="p-3 bg-white flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#1b355a] text-white font-bold flex items-center justify-center shrink-0">
                                    {{ substr($member['name'] ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#1b355a]">{{ $member['name'] ?? '' }}</h5>
                                    <p class="text-[11px] text-slate-500 font-mono">{{ $member['email'] ?? '' }} • {{ $member['phone'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-100">
                                    Proposed
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach($selectedTaskForce->members as $member)
                        <div class="p-3 bg-white flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#1b355a] text-white font-bold flex items-center justify-center shrink-0">
                                    {{ $member->initials() }}
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#1b355a]">{{ $member->name }}</h5>
                                    <p class="text-[11px] text-slate-500 font-mono">{{ $member->email }}</p>
                                </div>
                            </div>

                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-800 border border-blue-100">
                                    {{ $member->roleRelation->description ?? $member->role }}
                                </span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Assigned {{ \Carbon\Carbon::parse($member->pivot->assigned_at)->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                @if($selectedTaskForce->status === 'pending_approval' && $this->canManage)
                <button type="button" wire:click="approveTaskForce({{ $selectedTaskForce->id }})" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition shadow-xs flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Approve Task Force &amp; Members
                </button>
                @endif
                <flux:button variant="outline" wire:click="closeRosterModal">{{ __('Close') }}</flux:button>
            </div>
        </div>
        @endif
    </flux:modal>

    <!-- SweetAlert Event Listener -->
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
