<div class="flex flex-col gap-6">
    <!-- Tabbed Navigation Control (3 Tabs: Access & Sessions, Account Creations, File Modifications) -->
    <div class="flex border-b border-slate-150 gap-6 select-none bg-white px-6 pt-4 rounded-2xl border border-slate-200/60 shadow-3xs -mb-2">
        <button 
            wire:click="$set('tab', 'sessions')" 
            class="pb-3.5 text-xs font-bold uppercase tracking-wider border-b-2 cursor-pointer transition focus:outline-none flex items-center gap-2 {{ $tab === 'sessions' ? 'border-brand-orange text-primary' : 'border-transparent text-zinc-400 hover:text-zinc-600' }}"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
            Access &amp; Sessions
        </button>
        <button 
            wire:click="$set('tab', 'accounts')" 
            class="pb-3.5 text-xs font-bold uppercase tracking-wider border-b-2 cursor-pointer transition focus:outline-none flex items-center gap-2 {{ $tab === 'accounts' ? 'border-brand-orange text-primary' : 'border-transparent text-zinc-400 hover:text-zinc-600' }}"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Account Creations
        </button>
        <button 
            wire:click="$set('tab', 'files')" 
            class="pb-3.5 text-xs font-bold uppercase tracking-wider border-b-2 cursor-pointer transition focus:outline-none flex items-center gap-2 {{ $tab === 'files' ? 'border-brand-orange text-primary' : 'border-transparent text-zinc-400 hover:text-zinc-600' }}"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            File Modifications
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 w-full">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                label="Search" 
                placeholder="Search actor or action detail..." 
                icon="magnifying-glass" 
            />
        </div>

        @if($tab !== 'sessions')
        <div class="w-full md:w-64">
            <flux:select wire:model.live="actionType" label="Action Type">
                <option value="">All Actions</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}">{{ str_replace('_', ' ', $act) }}</option>
                @endforeach
            </flux:select>
        </div>
        @else
        <div class="w-full md:w-64 invisible"></div>
        @endif

        @if($search || $actionType)
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
            @if($tab === 'sessions')
                <!-- TAB 1: ACCESS & SESSIONS (2 columns for Login and Logout, paired in one row) -->
                <table class="w-full text-left border-collapse font-sans text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-zinc-400 font-bold uppercase tracking-wider select-none text-[11px]">

                            <th class="py-3.5 px-6">Login Time</th>
                            <th class="py-3.5 px-6">Logout Time</th>
                            <th class="py-3.5 px-6">Session Duration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 font-medium">
                        @forelse($logs as $loginLog)
                            @php
                                $logoutLog = $loginLog->logout_log;
                                $loginTime = $loginLog->timestamp;
                                $logoutTime = $logoutLog ? $logoutLog->timestamp : null;

                                $durationText = 'Ongoing';
                                if ($logoutTime) {
                                    $diffMins = $loginTime->diffInMinutes($logoutTime);
                                    if ($diffMins < 60) {
                                        $durationText = $diffMins . ' mins';
                                    } else {
                                        $hours = floor($diffMins / 60);
                                        $mins = $diffMins % 60;
                                        $durationText = $hours . 'h ' . ($mins > 0 ? $mins . 'm' : '');
                                    }
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/40 transition text-slate-700">

                                <!-- Login Time Column -->
                                <td class="py-4 px-6 font-mono text-slate-600 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 text-emerald-700 font-semibold">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"></path></svg>
                                        {{ $loginTime->format('M d, Y') }} &bull; {{ $loginTime->format('h:i:s A') }}
                                    </div>
                                </td>

                                <!-- Logout Time Column -->
                                <td class="py-4 px-6 font-mono text-slate-600 whitespace-nowrap">
                                    @if($logoutTime)
                                        <div class="flex items-center gap-1.5 text-slate-600 font-semibold">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"></path></svg>
                                            {{ $logoutTime->format('M d, Y') }} &bull; {{ $logoutTime->format('h:i:s A') }}
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Active Session
                                        </span>
                                    @endif
                                </td>

                                <!-- Duration Column -->
                                <td class="py-4 px-6 whitespace-nowrap font-semibold">
                                    @if($logoutTime)
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $durationText }}
                                        </span>
                                    @else
                                        <span class="text-emerald-600 text-xs font-bold">In Progress</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 px-6 text-center text-zinc-400">
                                    No access or session records found matching your query.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif($tab === 'accounts')
                <!-- TAB 2: ACCOUNT CREATIONS & MANAGEMENT (No Target Resource column) -->
                <table class="w-full text-left border-collapse font-sans text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-zinc-400 font-bold uppercase tracking-wider select-none text-[11px]">
                            <th class="py-3.5 px-6">Timestamp</th>

                            <th class="py-3.5 px-6">Action</th>
                            <th class="py-3.5 px-6">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 font-medium text-slate-700">
                        @forelse($logs as $log)
                            @php
                                $badgeColor = match ($log->action) {
                                    'CREATE_USER', 'account_create' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    'UPDATE_USER', 'account_update' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'DEACTIVATE_USER' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                    'ACTIVATE_USER' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                    default => 'bg-slate-100 text-slate-700 border border-slate-200'
                                };

                                $actionLabel = match ($log->action) {
                                    'CREATE_USER' => 'User Pre-Registered',
                                    'UPDATE_USER' => 'Account Details Updated',
                                    'DEACTIVATE_USER' => 'Account Deactivated',
                                    'ACTIVATE_USER' => 'Account Activated',
                                    'account_create' => 'Account Created',
                                    'account_update' => 'Account Updated',
                                    'password_reset' => 'Password Reset',
                                    default => str_replace('_', ' ', $log->action)
                                };

                                $detailsText = match ($log->action) {
                                    'CREATE_USER' => 'Pre-registered institutional identity awaiting user Google Workspace sign-in.',
                                    'UPDATE_USER' => 'Updated role or organizational college/department affiliations.',
                                    'DEACTIVATE_USER' => 'Deactivated user account access while preserving historical records.',
                                    'ACTIVATE_USER' => 'Reactivated user account access.',
                                    default => 'Account management action performed in the system.'
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-4 px-6 text-zinc-500 font-mono text-[11px] whitespace-nowrap">
                                    {{ $log->timestamp->format('M d, Y') }} &bull; {{ $log->timestamp->format('h:i:s A') }}
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide inline-block {{ $badgeColor }}">
                                        {{ $actionLabel }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-zinc-600 text-xs">
                                    {{ $detailsText }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 px-6 text-center text-zinc-400">
                                    No account creation or management logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <!-- TAB 3: FILE MODIFICATIONS & APPROVALS (No Target Resource column) -->
                <table class="w-full text-left border-collapse font-sans text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-zinc-400 font-bold uppercase tracking-wider select-none text-[11px]">
                            <th class="py-3.5 px-6">Timestamp</th>

                            <th class="py-3.5 px-6">Action</th>
                            <th class="py-3.5 px-6">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-150 font-medium text-slate-700">
                        @forelse($logs as $log)
                            @php
                                $badgeColor = match (true) {
                                    str_contains($log->action, 'upload') => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    str_contains($log->action, 'approve') => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                    str_contains($log->action, 'reject') => 'bg-rose-50 text-rose-700 border border-rose-200',
                                    str_contains($log->action, 'delete') => 'bg-slate-100 text-slate-700 border border-slate-200',
                                    default => 'bg-amber-50 text-amber-700 border border-amber-200'
                                };

                                $actionLabel = match ($log->action) {
                                    'document_upload' => 'Document Uploaded',
                                    'document_approve' => 'Document Approved',
                                    'document_reject' => 'Document Rejected',
                                    'document_delete' => 'Document Deleted',
                                    'document_update' => 'Document Modified',
                                    default => str_replace('_', ' ', $log->action)
                                };

                                $detailsText = match ($log->action) {
                                    'document_upload' => 'Uploaded a new accreditation compliance document.',
                                    'document_approve' => 'Approved uploaded accreditation document after IQA verification.',
                                    'document_reject' => 'Rejected accreditation document with compliance remarks.',
                                    'document_delete' => 'Archived/Removed document entry from workspace repository.',
                                    default => 'Document modification performed.'
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="py-4 px-6 text-zinc-500 font-mono text-[11px] whitespace-nowrap">
                                    {{ $log->timestamp->format('M d, Y') }} &bull; {{ $log->timestamp->format('h:i:s A') }}
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide inline-block {{ $badgeColor }}">
                                        {{ $actionLabel }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-zinc-600 text-xs">
                                    {{ $detailsText }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 px-6 text-center text-zinc-400">
                                    No file modification or approval logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>

        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
