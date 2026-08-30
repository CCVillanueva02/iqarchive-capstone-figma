<flux:modal wire:model="showCreateModal" class="max-w-2xl md:min-w-2xl no-scrollbar scrollbar-none" @close="closeCreateModal">
    <form wire:submit="createTaskForce" class="space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-brand-orange flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <flux:heading size="lg" class="text-primary font-bold">{{ __('Create Task Force') }}</flux:heading>
            </div>
            <flux:subheading>{{ __('Assemble a task force for college accreditation tasks and assign eligible faculty members.') }}</flux:subheading>
        </div>

        @if((auth()->user()->role ?? '') === 'college-head')
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 flex items-start gap-3 text-body-sm text-amber-900">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <span class="font-bold">Submitting as College Head (Dean):</span>
                <p class="mt-0.5 text-label">This task force proposal and member roster will be submitted to the <strong>IQA Office</strong> for review and official account activation.</p>
            </div>
        </div>
        @endif

        <div class="space-y-4">
            <!-- 1. Task Force Name -->
            <div>
                <flux:input 
                    wire:model="name" 
                    :label="__('Task Force Name')" 
                    required 
                    placeholder="e.g. BSCS AACCUP Level III Task Force" 
                />
            </div>

            <!-- 2. Assigned College & Program -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-label-xs font-semibold text-slate-700 mb-1.5">
                        Assigned College <span class="text-slate-400 font-normal ml-1">(Defined)</span>
                    </label>

                    @if($definedCollege)
                    <div class="bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-2.5 flex items-center justify-between text-body-sm text-primary font-bold">
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

                <div>
                    <flux:select wire:model="program_id" :label="__('Assigned Program')" placeholder="Select Program" required>
                        <flux:select.option value="">Select Program</flux:select.option>
                        @foreach($availablePrograms as $prog)
                            <flux:select.option value="{{ $prog->id }}">{{ $prog->name }} ({{ $prog->code }})</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <!-- 3. Add Member Form -->
            <div class="bg-surface-card p-4 rounded-xl border border-slate-200 flex flex-col gap-3">
                <h4 class="font-bold text-body-sm text-primary flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Add Proposed Member</span>
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <flux:input wire:model="newName" placeholder="Full Name" size="sm" />
                    <flux:input wire:model="newEmail" type="email" placeholder="Institutional Email" size="sm" />
                    <flux:input wire:model="newPhone" placeholder="Contact Phone" size="sm" />
                </div>
                <div class="flex justify-end">
                    <button 
                        type="button" 
                        wire:click="addMember"
                        class="px-3.5 py-1.5 rounded-xl text-body-sm font-bold bg-primary hover:bg-primary-hover text-white transition-colors cursor-pointer shadow-2xs">
                        + Add Member
                    </button>
                </div>
            </div>

            <!-- 4. Proposed Roster List -->
            <div>
                <h4 class="font-bold text-body-sm text-primary mb-2">
                    Proposed Members List ({{ count($proposedMembers) }})
                </h4>
                @if(empty($proposedMembers))
                    <div class="text-body-sm text-slate-400 italic p-4 bg-surface-subtle border border-slate-200/80 rounded-xl text-center">
                        No members added yet.
                    </div>
                @else
                    <div class="space-y-2 max-h-52 overflow-y-auto no-scrollbar rounded-xl border border-slate-200/80 p-2 bg-slate-50/50">
                        @foreach($proposedMembers as $index => $member)
                        <div class="flex items-center justify-between p-2.5 bg-white border border-slate-200/80 rounded-lg text-body-sm shadow-2xs">
                            <div class="flex flex-col">
                                <span class="font-bold text-primary">{{ $member['name'] }}</span>
                                <span class="text-label-xs font-mono text-slate-500">{{ $member['email'] }} • {{ $member['phone'] }}</span>
                            </div>
                            <button 
                                type="button" 
                                wire:click="removeMember({{ $index }})" 
                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                @endif
                @error('proposedMembers')
                    <p class="text-label-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit & Cancel -->
        <div class="flex gap-3 justify-end pt-4 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeCreateModal">{{ __('Cancel') }}</flux:button>
            <button 
                type="submit" 
                class="px-4 py-2 rounded-xl text-body-sm font-bold bg-brand-orange hover:bg-brand-orange-hover text-white transition-colors cursor-pointer shadow-xs">
                {{ in_array(auth()->user()->role ?? '', ['college-head', 'program-chair']) ? __('Submit Task Force Proposal') : __('Create Task Force') }}
            </button>
        </div>
    </form>
</flux:modal>
