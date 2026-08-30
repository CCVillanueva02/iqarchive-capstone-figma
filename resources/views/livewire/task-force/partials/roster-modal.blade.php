<flux:modal wire:model="showRosterModal" class="max-w-2xl md:min-w-2xl no-scrollbar scrollbar-none" @close="closeRosterModal">
    @if($selectedTaskForce)
    <div class="space-y-5">
        <!-- Header -->
        <div class="border-b border-slate-200 pb-4">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-bold {{ $selectedTaskForce->status === 'pending_approval' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-surface-subtle text-primary-dark border border-primary/15' }}">
                    {{ ucfirst(str_replace('_', ' ', $selectedTaskForce->status)) }}
                </span>
            </div>
            <h2 class="text-heading font-bold text-primary tracking-tight">
                {{ $selectedTaskForce->name }}
            </h2>
            <p class="text-body-sm text-slate-500 mt-0.5">
                {{ $selectedTaskForce->college->name }} @if($selectedTaskForce->program) &bull; {{ $selectedTaskForce->program->name }} @endif
            </p>
        </div>

        <!-- Details Metadata Grid -->
        <div class="grid grid-cols-3 gap-3 text-body-sm bg-surface-subtle p-3.5 rounded-xl border border-slate-200/70">
            <div>
                <span class="text-slate-400 block text-label-xs font-semibold uppercase tracking-wider">Created By</span>
                <span class="font-bold text-primary text-label">{{ $selectedTaskForce->creator->name ?? 'Dean Office / System' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-label-xs font-semibold uppercase tracking-wider">Date Recorded</span>
                <span class="font-bold text-primary text-label">{{ $selectedTaskForce->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-label-xs font-semibold uppercase tracking-wider">Current Cycle</span>
                <span class="font-bold text-brand-orange text-label">{{ $selectedTaskForce->program ? 'Accreditation Ready' : 'Quality Assurance' }}</span>
            </div>
        </div>

        <!-- Member Roster List -->
        <div>
            <div class="flex items-center justify-between mb-2.5">
                <h4 class="text-body-sm font-bold text-primary">
                    @if($selectedTaskForce->status === 'pending_approval')
                        Nominated Roster Members ({{ is_array($selectedTaskForce->proposed_members) ? count($selectedTaskForce->proposed_members) : 0 }})
                    @else
                        Official Assigned Roster ({{ $selectedTaskForce->members->count() }})
                    @endif
                </h4>
                @if($selectedTaskForce->status === 'pending_approval')
                <span class="text-label-xs text-amber-700 font-semibold flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Awaiting IQA Formalization
                </span>
                @endif
            </div>

            <div class="divide-y divide-slate-100 border border-slate-200/80 rounded-2xl overflow-hidden bg-white shadow-2xs">
                @if($selectedTaskForce->status === 'pending_approval' && is_array($selectedTaskForce->proposed_members))
                    @foreach($selectedTaskForce->proposed_members as $member)
                    @php
                        $memberStatus = $this->getProposedMemberStatus($member['email'] ?? '');
                        $words = explode(' ', trim($member['name'] ?? ''));
                        $initials = count($words) > 1 
                            ? strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1))
                            : strtoupper(substr($words[0] ?? 'TF', 0, 2));
                    @endphp
                    <div class="p-3.5 flex items-center justify-between gap-3 text-body-sm hover:bg-slate-50/70 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-linear-to-br from-primary/10 to-primary/20 text-primary font-bold flex items-center justify-center text-label-xs shrink-0 select-none shadow-2xs border border-primary/15">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0 space-y-0.5">
                                <h5 class="font-bold text-primary truncate">{{ $member['name'] ?? '' }}</h5>
                                <p class="text-label-xs text-slate-500 font-mono flex items-center gap-1.5">
                                    <span>{{ $member['email'] ?? '' }}</span>
                                    @if(!empty($member['phone']))
                                    <span class="text-slate-300">&bull;</span>
                                    <span>{{ $member['phone'] }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="shrink-0 text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-semibold border {{ $memberStatus['class'] }}">
                                {{ $memberStatus['label'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach($selectedTaskForce->members as $member)
                    <div class="p-3.5 flex items-center justify-between gap-3 text-body-sm hover:bg-slate-50/70 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($member->avatar_url)
                                <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="w-9 h-9 rounded-xl object-cover border border-slate-200 shadow-2xs shrink-0" referrerpolicy="no-referrer" />
                            @else
                                <div class="w-9 h-9 rounded-xl bg-linear-to-br from-slate-100 to-slate-200 border border-slate-200 text-primary font-bold flex items-center justify-center text-label-xs shrink-0 shadow-2xs">
                                    {{ $member->initials() }}
                                </div>
                            @endif
                            <div class="min-w-0 space-y-0.5">
                                <h5 class="font-bold text-primary truncate">{{ $member->name }}</h5>
                                <p class="text-label-xs text-slate-500 font-mono">{{ $member->email }}</p>
                            </div>
                        </div>

                        <div class="shrink-0 text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-semibold {{ ($member->pivot->role_in_team ?? '') === 'lead' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-surface-subtle text-primary-dark border border-primary/10' }}">
                                {{ ($member->pivot->role_in_team ?? '') === 'lead' ? 'Task Force Lead (Dean)' : 'Task Force Member' }}
                            </span>
                            <span class="block text-label-xs text-slate-400 mt-0.5">
                                Assigned {{ \Carbon\Carbon::parse($member->pivot->assigned_at)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <flux:button variant="outline" wire:click="closeRosterModal">
                {{ __('Close') }}
            </flux:button>

            @if($selectedTaskForce->status === 'pending_approval' && $this->canManage)
            <!-- 1-Click Approve & Pre-list Action -->
            <button 
                type="button" 
                wire:click="approveTaskForce({{ $selectedTaskForce->id }})" 
                class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-body-sm transition-colors shadow-xs flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Approve &amp; Pre-list Roster</span>
            </button>
            @endif
        </div>
    </div>
    @endif
</flux:modal>
