<flux:modal wire:model="showProposeModal" class="max-w-2xl md:min-w-2xl no-scrollbar scrollbar-none" @close="closeProposeModal">
    @if($selectedAccreditation)
    <div class="space-y-5">
        <!-- Modal Header -->
        <div class="border-b border-slate-200 pb-4">
            <h2 class="text-heading font-bold text-primary-dark tracking-tight mt-1">
                Nominate Task Force Members
            </h2>
            <p class="text-body-sm text-slate-500 mt-0.5">
                Propose faculty members for {{ $selectedAccreditation->program->name }}. This proposal will be submitted to the IQA Office for official roster formalization.
            </p>
        </div>

        <!-- Add Faculty Member Form Box -->
        <div class="bg-surface-card border border-slate-200 rounded-xl p-4 space-y-3">
            <h4 class="text-body-sm font-bold text-primary-dark flex items-center gap-1.5">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span>Add Task Force Member</span>
            </h4>

            <div class="flex flex-col gap-3">
                <div>
                    <flux:input wire:model="newName" placeholder="Full Name (e.g. Dr. Jane Doe)" label="Full Name" size="sm" />
                </div>
                <div>
                    <flux:input wire:model="newEmail" type="email" placeholder="Institutional Email (e.g. jane.doe@bicol-u.edu.ph)" label="Institutional Email" size="sm" />
                </div>
                <div>
                    <flux:input wire:model="newPhone" placeholder="Mobile / Local Number (Optional)" label="Contact Number" size="sm" />
                </div>
            </div>

            <div class="flex justify-end pt-1">
                <button 
                    type="button" 
                    wire:click="addMember"
                    class="px-3.5 py-1.5 rounded-xl text-body-sm font-bold bg-primary hover:bg-primary-hover text-white transition-colors cursor-pointer shadow-xs">
                    + Add Member
                </button>
            </div>
        </div>

        <!-- Proposed Roster Table / List -->
        <div>
            <div class="flex items-center justify-between mb-2.5">
                <div class="flex items-center gap-2">
                    <h4 class="text-body-sm font-bold text-primary-dark">
                        Proposed Members
                    </h4>
                    <span class="px-2 py-0.5 rounded-full text-label-xs font-bold bg-primary/10 text-primary">
                        {{ count($proposedMembers) }}
                    </span>
                </div>
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
            <div class="text-body-sm text-slate-400 italic p-6 bg-surface-subtle border border-slate-200/80 rounded-2xl text-center space-y-1">
                <p class="font-semibold text-slate-600">No members added to roster yet</p>
                <p class="text-label-xs text-slate-400">Fill the form above and click "+ Add Member" to assemble your nomination roster.</p>
            </div>
            @else
            <div class="space-y-2.5 max-h-64 overflow-y-auto no-scrollbar rounded-2xl border border-slate-200/80 p-2.5 bg-slate-50/50">
                @foreach($proposedMembers as $index => $member)
                @php
                    $words = explode(' ', trim($member['name']));
                    $initials = count($words) > 1 
                        ? strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1))
                        : strtoupper(substr($words[0] ?? 'TF', 0, 2));
                @endphp
                <div wire:key="member-item-{{ $index }}" class="flex items-center justify-between p-3 bg-white border border-slate-200/80 rounded-xl shadow-2xs hover:border-slate-300 transition-all group">
                    <div class="flex items-center gap-3 min-w-0">
                        <!-- Initials Badge -->
                        <div class="w-9 h-9 rounded-xl bg-linear-to-br from-primary/10 to-primary/20 text-primary font-bold flex items-center justify-center text-label-xs shrink-0 select-none shadow-2xs border border-primary/15">
                            {{ $initials }}
                        </div>

                        <!-- Info -->
                        <div class="min-w-0 space-y-0.5">
                            <div class="font-bold text-primary-dark text-body-sm truncate group-hover:text-brand-orange transition-colors">
                                {{ $member['name'] }}
                            </div>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-label-xs text-slate-500 font-mono">
                                <span class="flex items-center gap-1 text-slate-600">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate">{{ $member['email'] }}</span>
                                </span>
                                @if(!empty($member['phone']))
                                <span class="flex items-center gap-1 text-slate-500">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $member['phone'] }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Remove Action -->
                    <button 
                        type="button" 
                        wire:click="removeMember({{ $index }})" 
                        title="Remove from roster"
                        class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all cursor-pointer shrink-0 ml-2">
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

            <button 
                type="button" 
                wire:click="submitProposal"
                @disabled(empty($proposedMembers))
                class="px-4 py-2 rounded-xl text-body-sm font-bold bg-brand-orange hover:bg-brand-orange-hover text-white transition-colors cursor-pointer shadow-xs disabled:opacity-50 disabled:cursor-not-allowed">
                Submit Proposal to IQA
            </button>
        </div>
    </div>
    @endif
</flux:modal>
