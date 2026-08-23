<flux:modal wire:model="showProposeModal" class="max-w-2xl md:min-w-2xl no-scrollbar scrollbar-none" @close="closeProposeModal">
    @if($selectedAccreditation)
    <div class="space-y-5">
        <!-- Modal Header -->
        <div class="border-b border-slate-200 pb-4">
            <div class="flex items-center gap-2">
                <span class="text-label-xs font-bold px-2 py-0.5 rounded bg-brand-orange/10 text-brand-orange border border-brand-orange/20">
                    Stage 2 · Dean Nomination
                </span>
                <span class="text-label-xs font-mono text-slate-500">{{ $selectedAccreditation->program->code }}</span>
            </div>
            <h2 class="text-heading font-bold text-primary-dark tracking-tight mt-1">
                Nominate Task Force Members
            </h2>
            <p class="text-body-sm text-slate-500 mt-0.5">
                Propose faculty members and designate area chairs for {{ $selectedAccreditation->program->name }}. This proposal will be submitted to the IQA Office for official roster formalization.
            </p>
        </div>

        <!-- Add Faculty Member Form Box -->
        <div class="bg-surface-card border border-slate-200 rounded-xl p-4 space-y-3">
            <h4 class="text-body-sm font-bold text-primary-dark flex items-center gap-1.5">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span>Add Faculty Member</span>
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <flux:input wire:model="newName" placeholder="Full Name (e.g. Dr. Jane Doe)" label="Full Name" size="sm" />
                </div>
                <div>
                    <flux:input wire:model="newEmail" type="email" placeholder="BU Institutional Email" label="Institutional Email" size="sm" />
                </div>
                <div>
                    <flux:select wire:model="newRole" label="Designation / Scope" size="sm">
                        <flux:select.option value="Area Chair">Area Chair</flux:select.option>
                        <flux:select.option value="Area Co-Chair">Area Co-Chair</flux:select.option>
                        <flux:select.option value="Task Force Secretary">Task Force Secretary</flux:select.option>
                        <flux:select.option value="Task Force Member">Task Force Member</flux:select.option>
                        <flux:select.option value="Document Custodian">Document Custodian</flux:select.option>
                    </flux:select>
                </div>
                <div>
                    <flux:input wire:model="newPhone" placeholder="Mobile Number (Optional)" label="Contact Number" size="sm" />
                </div>
            </div>

            <div class="flex justify-end pt-1">
                <flux:button type="button" size="sm" variant="primary" wire:click="addMember">
                    + Add to Proposal Roster
                </flux:button>
            </div>
        </div>

        <!-- Proposed Roster Table / List -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-body-sm font-bold text-primary-dark">
                    Proposed Roster ({{ count($proposedMembers) }})
                </h4>
                @if(count($proposedMembers) > 0)
                <span class="text-label-xs text-emerald-700 font-semibold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Ready for submission
                </span>
                @endif
            </div>

            @if(empty($proposedMembers))
            <div class="text-body-sm text-slate-400 italic p-4 bg-surface-subtle border border-slate-200/80 rounded-xl text-center">
                No faculty members added yet. Add at least one member above to submit the nomination.
            </div>
            @else
            <div class="space-y-2 max-h-56 overflow-y-auto no-scrollbar rounded-xl border border-slate-200/80 p-2 bg-white">
                @foreach($proposedMembers as $index => $member)
                <div class="flex items-center justify-between p-2.5 bg-surface-card border border-slate-100 rounded-lg text-body-sm">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-primary-dark">{{ $member['name'] }}</span>
                            <span class="text-label-xs font-semibold px-2 py-0.5 rounded-full bg-primary/10 text-primary border border-primary/20">
                                {{ $member['role'] ?? 'Member' }}
                            </span>
                        </div>
                        <div class="text-label-xs text-slate-500 font-mono">
                            {{ $member['email'] }}{{ !empty($member['phone']) ? ' · ' . $member['phone'] : '' }}
                        </div>
                    </div>
                    <button 
                        type="button" 
                        wire:click="removeMember({{ $index }})" 
                        class="text-rose-500 hover:text-rose-700 p-1.5 rounded-lg hover:bg-rose-50 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeProposeModal">
                Cancel
            </flux:button>

            <flux:button 
                variant="primary" 
                wire:click="submitProposal"
                :disabled="empty($proposedMembers)">
                Submit Proposal to IQA
            </flux:button>
        </div>
    </div>
    @endif
</flux:modal>
