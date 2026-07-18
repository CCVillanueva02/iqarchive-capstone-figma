<div class="flex flex-col gap-6">
    <!-- Tabbed Navigation Control -->
    <div class="flex border-b border-slate-150 gap-6 select-none bg-white px-6 pt-4 rounded-2xl border border-slate-200/60 shadow-3xs -mb-2">
        <button 
            wire:click="$set('tab', 'general')" 
            class="pb-3.5 text-xs font-bold uppercase tracking-wider border-b-2 cursor-pointer transition focus:outline-none {{ $tab === 'general' ? 'border-[#F47920] text-[#1b355a]' : 'border-transparent text-zinc-400 hover:text-zinc-600' }}"
        >
            General Logs
        </button>
        <button 
            wire:click="$set('tab', 'authentication')" 
            class="pb-3.5 text-xs font-bold uppercase tracking-wider border-b-2 cursor-pointer transition focus:outline-none {{ $tab === 'authentication' ? 'border-[#F47920] text-[#1b355a]' : 'border-transparent text-zinc-400 hover:text-zinc-600' }}"
        >
            Access & Sessions
        </button>
        <button 
            wire:click="$set('tab', 'documents')" 
            class="pb-3.5 text-xs font-bold uppercase tracking-wider border-b-2 cursor-pointer transition focus:outline-none {{ $tab === 'documents' ? 'border-[#F47920] text-[#1b355a]' : 'border-transparent text-zinc-400 hover:text-zinc-600' }}"
        >
            File Modifications & Approvals
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 w-full">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                label="Search" 
                placeholder="Search action or target..." 
                icon="magnifying-glass" 
            />
        </div>

        <div class="w-full md:w-64">
            <flux:select wire:model.live="userId" label="User / Actor">
                <option value="">All Users</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </flux:select>
        </div>

        <div class="w-full md:w-64">
            <flux:select wire:model.live="actionType" label="Action Type">
                <option value="">All Actions</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}">{{ $act }}</option>
                @endforeach
            </flux:select>
        </div>

        @if($search || $userId || $actionType)
            <div class="w-full md:w-auto">
                <flux:button 
                    wire:click="clearFilters" 
                    variant="subtle" 
                    icon="x-mark"
                    class="w-full md:w-auto"
                >
                    Clear
                </flux:button>
            </div>
        @endif
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans text-sm">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100 text-zinc-400 font-bold uppercase tracking-wider select-none text-[11px]">
                        <th class="py-3.5 px-6">Timestamp</th>
                        <th class="py-3.5 px-6">User (Actor)</th>
                        <th class="py-3.5 px-6">Action</th>
                        <th class="py-3.5 px-6">Target Resource</th>
                        <th class="py-3.5 px-6">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 font-medium">
                    @forelse($logs as $log)
                        @php
                            $badgeColor = match (true) {
                                str_contains($log->action, 'login') => 'bg-blue-50 text-blue-700 border border-blue-200/50',
                                str_contains($log->action, 'logout') => 'bg-slate-50 text-slate-700 border border-slate-250',
                                str_contains($log->action, 'upload') || str_contains($log->action, 'approve') => 'bg-emerald-50 text-emerald-700 border border-emerald-250',
                                str_contains($log->action, 'delete') || str_contains($log->action, 'reject') => 'bg-rose-50 text-rose-700 border border-rose-250',
                                default => 'bg-amber-50 text-amber-700 border border-amber-250'
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/40 transition">
                            <!-- Timestamp -->
                            <td class="py-4 px-6 text-zinc-400 font-semibold text-xs whitespace-nowrap">
                                {{ $log->timestamp->format('Y-m-d H:i:s') }}
                            </td>
                            <!-- User -->
                            <td class="py-4 px-6">
                                @if($log->user)
                                    <div class="flex flex-col">
                                        <span class="font-bold text-[#1b355a] text-sm">{{ $log->user->name }}</span>
                                        <span class="text-zinc-400 text-[10px]">{{ $log->user->email }}</span>
                                    </div>
                                @else
                                    <span class="text-zinc-400 italic">System / Unknown</span>
                                @endif
                            </td>
                            <!-- Action Badge -->
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide inline-block {{ $badgeColor }}">
                                    {{ str_replace('_', ' ', $log->action) }}
                                </span>
                            </td>
                            <!-- Target -->
                            <td class="py-4 px-6 text-zinc-600 text-sm whitespace-nowrap">
                                @if($log->target_type)
                                    <span class="font-bold text-[#1b355a]">{{ class_basename($log->target_type) }}</span>
                                    @if($log->target_id)
                                        <span class="text-zinc-400 font-semibold">#{{ $log->target_id }}</span>
                                    @endif
                                @else
                                    <span class="text-zinc-400">-</span>
                                @endif
                            </td>
                            <!-- Details/Description -->
                            <td class="py-4 px-6 text-zinc-500 text-xs">
                                {{ ucfirst(str_replace('_', ' ', $log->action)) }} performed on 
                                {{ $log->target_type ? class_basename($log->target_type) : 'the system' }}
                                {{ $log->target_id ? 'with ID ' . $log->target_id : '' }}.
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 px-6 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <x-lucide-info class="w-8 h-8 text-zinc-300" />
                                    <span class="text-sm text-zinc-400 font-medium">No audit logs found matching the active filters.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
