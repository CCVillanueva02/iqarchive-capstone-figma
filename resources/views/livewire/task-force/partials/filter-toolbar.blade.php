<div class="bg-white border border-slate-200/80 rounded-2xl shadow-3xs p-4 flex flex-col md:flex-row gap-4 justify-between items-center">
    <!-- Status Tabs -->
    <div class="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-xl w-full md:w-auto">
        <button 
            type="button" 
            wire:click="$set('statusFilter', '')" 
            class="px-3.5 py-1.5 rounded-lg text-label-xs font-bold transition-all cursor-pointer {{ $statusFilter === '' ? 'bg-primary text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
            All <span class="ml-1 px-1.5 py-0.2 rounded-full {{ $statusFilter === '' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }} text-label-xs font-bold">{{ $totalAllCount }}</span>
        </button>
        <button 
            type="button" 
            wire:click="$set('statusFilter', 'pending_approval')" 
            class="px-3.5 py-1.5 rounded-lg text-label-xs font-bold transition-all cursor-pointer {{ $statusFilter === 'pending_approval' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
            Pending Approval <span class="ml-1 px-1.5 py-0.2 rounded-full {{ $statusFilter === 'pending_approval' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-800' }} text-label-xs font-bold">{{ $totalPendingCount }}</span>
        </button>
        <button 
            type="button" 
            wire:click="$set('statusFilter', 'active')" 
            class="px-3.5 py-1.5 rounded-lg text-label-xs font-bold transition-all cursor-pointer {{ $statusFilter === 'active' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
            Active <span class="ml-1 px-1.5 py-0.2 rounded-full {{ $statusFilter === 'active' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }} text-label-xs font-bold">{{ $totalActiveCount }}</span>
        </button>
        <button 
            type="button" 
            wire:click="$set('statusFilter', 'completed')" 
            class="px-3.5 py-1.5 rounded-lg text-label-xs font-bold transition-all cursor-pointer {{ $statusFilter === 'completed' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
            Completed <span class="ml-1 px-1.5 py-0.2 rounded-full {{ $statusFilter === 'completed' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }} text-label-xs font-bold">{{ $totalCompletedCount }}</span>
        </button>
    </div>

    <!-- Search & College Dropdown -->
    <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
        <div class="w-full sm:w-64">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search task force or mandate..." icon="magnifying-glass" size="sm" />
        </div>

        <div class="w-full sm:w-56">
            <flux:select wire:model.live="collegeFilter" placeholder="All Colleges" size="sm">
                <flux:select.option value="">All Colleges</flux:select.option>
                @foreach($colleges as $col)
                <flux:select.option value="{{ $col->id }}">{{ $col->code }} - {{ $col->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>
</div>
