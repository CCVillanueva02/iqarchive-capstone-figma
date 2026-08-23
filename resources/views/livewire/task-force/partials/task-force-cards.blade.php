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
    <div wire:key="tf-card-{{ $tf->id }}" class="bg-white border border-slate-200/80 rounded-2xl shadow-3xs flex flex-col justify-between overflow-hidden hover:shadow-xs transition-shadow group">
        <div class="p-6 flex flex-col gap-4">
            <!-- Top Row: Code Badge & Status Badge -->
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-label-xs font-mono font-bold bg-slate-100 text-primary border border-slate-200 mb-1.5">
                        {{ $tf->college->code }}@if($tf->program) / {{ $tf->program->code }}@endif
                    </span>
                    <h3 class="text-heading-sm font-bold text-primary group-hover:text-brand-orange transition-colors leading-snug line-clamp-2">
                        {{ $tf->name }}
                    </h3>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-label-xs font-bold border shrink-0 {{ $statusClasses }}">
                    {{ $statusLabel }}
                </span>
            </div>

            <!-- Members Count -->
            <div>
                <div class="flex items-center justify-between text-body-sm mb-2">
                    <span class="text-slate-500 font-medium">Roster Composition</span>
                    <span class="text-primary font-bold">
                        @if($tf->status === 'pending_approval')
                            <span class="text-amber-700 font-bold">{{ is_array($tf->proposed_members) ? count($tf->proposed_members) : 0 }} Nominated</span>
                        @else
                            {{ $tf->members->count() }} Assigned
                        @endif
                    </span>
                </div>
            </div>

            <!-- Progress Meter -->
            <div class="pt-2 border-t border-slate-100">
                <div class="flex items-center justify-between text-label-xs mb-1.5">
                    <span class="text-slate-500 font-medium">Accreditation Area Progress</span>
                    <span class="font-bold text-primary">{{ $progress }}%</span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $progress >= 100 ? 'bg-emerald-500' : ($progress >= 50 ? 'bg-brand-orange' : 'bg-primary') }}" style="width: {{ max($progress, 5) }}%;"></div>
                </div>
            </div>
        </div>

        <!-- Card Actions Footer -->
        <div class="px-6 py-3.5 bg-surface-subtle border-t border-slate-100 flex items-center justify-between gap-3 text-body-sm">
            <button 
                type="button" 
                wire:click="openRosterModal({{ $tf->id }})" 
                class="font-bold text-primary hover:text-brand-orange flex items-center gap-1.5 transition-colors cursor-pointer text-label">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>View Roster &amp; Details</span>
            </button>

            @if($tf->status === 'pending_approval' && $this->canManage)
            <!-- IQA Action: 1-Click Approve & Pre-register Roster -->
            <button 
                type="button" 
                wire:click="approveTaskForce({{ $tf->id }})" 
                class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-2xs flex items-center gap-1.5 cursor-pointer text-label">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Approve &amp; Pre-list</span>
            </button>
            @elseif($this->canManage)
            <flux:dropdown align="end">
                <button type="button" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 19a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                </button>
                <flux:menu>
                    @if($tf->status !== 'active')
                    <flux:menu.item wire:click="updateTaskForceStatus({{ $tf->id }}, 'active')" icon="play" class="text-body-sm cursor-pointer">
                        Set Active
                    </flux:menu.item>
                    @endif
                    @if($tf->status !== 'completed')
                    <flux:menu.item wire:click="updateTaskForceStatus({{ $tf->id }}, 'completed')" icon="check-circle" class="text-body-sm cursor-pointer text-emerald-600">
                        Mark as Completed
                    </flux:menu.item>
                    @endif
                    @if($tf->status !== 'disbanded')
                    <flux:menu.item wire:click="updateTaskForceStatus({{ $tf->id }}, 'disbanded')" icon="x-circle" class="text-body-sm cursor-pointer text-rose-600">
                        Disband Task Force
                    </flux:menu.item>
                    @endif
                </flux:menu>
            </flux:dropdown>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white border border-slate-200/80 rounded-2xl p-12 text-center flex flex-col items-center justify-center gap-3 shadow-3xs">
        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm14 10v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
            </svg>
        </div>
        <h3 class="text-heading-sm font-bold text-primary">No Task Forces Found</h3>
        <p class="text-label text-slate-500 max-w-sm">No task forces match your search criteria. Try clearing filters or create a new task force.</p>
        @if($this->canCreate)
        <button 
            type="button" 
            wire:click="openCreateModal"
            class="mt-2 px-4 py-2 rounded-xl text-body-sm font-bold bg-brand-orange hover:bg-brand-orange-hover text-white transition-colors cursor-pointer shadow-xs">
            Create Task Force
        </button>
        @endif
    </div>
    @endforelse
</div>
