<div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs p-6 flex flex-col gap-4">
    <!-- Top Row: Status Filter Segment -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
        <div class="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-xl self-start">
            <button type="button" wire:click="$set('statusFilter', '')" class="px-3.5 py-1.5 rounded-lg text-body-sm font-semibold transition-all cursor-pointer {{ $statusFilter === '' ? 'bg-white text-primary shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                {{ __('All Accounts') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-slate-200/60 text-slate-700 text-label font-bold">{{ $totalCount }}</span>
            </button>
            <button type="button" wire:click="$set('statusFilter', 'active')" class="px-3.5 py-1.5 rounded-lg text-body-sm font-semibold transition-all cursor-pointer {{ $statusFilter === 'active' ? 'bg-primary text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                {{ __('Active') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/10 text-white/80 text-label font-bold">{{ $activeCount }}</span>
            </button>
            <button type="button" wire:click="$set('statusFilter', 'pending_activation')" class="px-3.5 py-1.5 rounded-lg text-body-sm font-semibold transition-all cursor-pointer {{ $statusFilter === 'pending_activation' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                {{ __('Pending Activation') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/10 text-white/80 text-label font-bold">{{ $pendingCount }}</span>
            </button>
            <button type="button" wire:click="$set('statusFilter', 'inactive')" class="px-3.5 py-1.5 rounded-lg text-body-sm font-semibold transition-all cursor-pointer {{ $statusFilter === 'inactive' ? 'bg-brand-orange text-white shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                {{ __('Deactivated') }} <span class="ml-1.5 px-1.5 py-0.5 rounded-full bg-white/10 text-white/80 text-label font-bold">{{ $inactiveCount }}</span>
            </button>
        </div>
        
        <div class="text-xs text-zinc-400 font-medium">
            {{ __('Showing :count accounts total', ['count' => $users->total()]) }}
        </div>
    </div>

    <!-- Bottom Row: Search & Role Filter -->
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-72">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." icon="magnifying-glass" size="sm" />
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <span class="text-xs text-zinc-400 font-semibold whitespace-nowrap">{{ __('Filter by Role:') }}</span>
            <flux:select wire:model.live="roleFilter" placeholder="All Roles" class="w-full md:w-48" size="sm">
                <flux:select.option value="">All Roles</flux:select.option>
                @foreach($roles as $role)
                <flux:select.option value="{{ $role->role_name }}">{{ $role->description }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>
</div>
