<div>
    <h2 class="text-heading-sm font-bold text-primary-dark border-b border-slate-200 pb-2 mb-4">Action Required: Setup Task Forces</h2>
    
    @if($pendingAccreditations->isEmpty())
        <div class="bg-white border border-slate-200 rounded-xl p-6 text-center shadow-sm">
            <p class="text-zinc-500">No scheduled accreditations require task force setup at this time.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach($pendingAccreditations as $acc)
                <div class="bg-white border border-rose-200 rounded-xl p-5 shadow-sm flex flex-col gap-3 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-rose-500"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-label-xs font-bold text-rose-500 uppercase tracking-wider mb-1 block">Pending Setup</span>
                            <h3 class="font-bold text-primary-dark text-heading-sm">{{ $acc->program->name }}</h3>
                            <p class="text-body-sm text-zinc-500">Target Date: {{ $acc->target_date ? $acc->target_date->format('M d, Y') : 'TBD' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-2 pt-4 border-t border-slate-100 flex justify-end">
                        <flux:button 
                            size="sm" 
                            variant="primary" 
                            wire:click="selectAccreditation({{ $acc->id }})"
                            x-on:click="$flux.modal('propose-task-force').show()"
                        >
                            Propose Task Force
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Task Force Proposal Modal -->
    <flux:modal name="propose-task-force" class="w-full max-w-xl">
        <form wire:submit.prevent="submitProposal" class="space-y-6">
            <div>
                <flux:heading size="lg">Propose Task Force Members</flux:heading>
                <flux:subheading>Add faculty members to assign to this program's accreditation task force. This will be sent to IQA for official assignment.</flux:subheading>
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
            <div>
                <h4 class="font-bold text-sm text-primary-dark mb-2">Proposed Members</h4>
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
                                    <span class="text-label-xs text-zinc-500">{{ $member['email'] }}{{ $member['phone'] ? ' • ' . $member['phone'] : '' }}</span>
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

            <!-- Action Buttons -->

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" x-on:click="$flux.modal('propose-task-force').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" x-on:click="$flux.modal('propose-task-force').close()">Submit Proposal</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
