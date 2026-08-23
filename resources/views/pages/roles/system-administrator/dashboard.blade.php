@php
    $totalUsers = \App\Models\User::count();
    $activeUsers = \App\Models\User::where('status', 'active')->count();
    $inactiveUsers = \App\Models\User::where('status', 'inactive')->count();
    $totalDocuments = \App\Models\Document::count();
    $totalLogs = \App\Models\AuditLog::count();
    $activeSessions = \DB::table('sessions')->count();
    
    // Get recent audit logs
    $recentLogs = \App\Models\AuditLog::with('user')
        ->orderBy('timestamp', 'desc')
        ->take(6)
        ->get();
        
    // Calculate activity breakdown
    $loginCount = \App\Models\AuditLog::where('action', 'login')->count();
    $docCount = \App\Models\AuditLog::where('action', 'like', 'document_%')->count();
    $otherCount = $totalLogs - ($loginCount + $docCount);
    
    $loginPercent = $totalLogs > 0 ? round(($loginCount / $totalLogs) * 100) : 0;
    $docPercent = $totalLogs > 0 ? round(($docCount / $totalLogs) * 100) : 0;
    $otherPercent = $totalLogs > 0 ? round(($otherCount / $totalLogs) * 100) : 0;
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#002B61]">System Administrator Dashboard</h1>
                <p class="text-xs text-zinc-500 mt-1">IQArchive Core Control Center</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold flex items-center gap-1.5 select-none">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    System Online
                </span>
                <span class="text-xs text-zinc-400 font-medium">Server Time: {{ now()->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <!-- Four Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Accounts -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Total Accounts</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalUsers }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5 flex items-center gap-2">
                        <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span> {{ $activeUsers }} Active
                        <span class="inline-block h-2 w-2 rounded-full bg-zinc-300"></span> {{ $inactiveUsers }} Deactivated
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002c-.072 0-.143-.001-.215-.002-.136-.002-.27-.006-.404-.012l-.014-.001a11.384 11.384 0 0 1-4.46-1.334 4.123 4.123 0 0 1-1.422-2.58l-.004-.013c-.015-.062-.03-.124-.043-.187L3.48 16a9.09 9.09 0 0 1-.412-2.72c0-1.87.525-3.6 1.437-5.07a4.125 4.125 0 0 1 7.159 2.502M15 9.128a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM2.25 12h19.5" />
                    </svg>
                </div>
            </div>

            <!-- Archived Documents -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Archived Files</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalDocuments }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Total PDFs & Docs uploaded</span>
                </div>
                <div class="p-3.5 rounded-xl bg-orange-50 text-[#F47920]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
            </div>

            <!-- Active Sessions -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Active Sessions</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $activeSessions }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Live authenticated users</span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                    </svg>
                </div>
            </div>

            <!-- Security Audit Trail Logs -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Audit Log Count</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalLogs }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Total audited events</span>
                </div>
                <div class="p-3.5 rounded-xl bg-purple-50 text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c2.917 0 5.747.294 8.5.862m-21 1.402L3 9.75m0 0 3 3m-3-3 3-3M3 16.5a2.25 2.25 0 0 0 2.25 2.25H13.5m-3-16.5h.008v.008H10.5V3Z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Recent Security Logs -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#002B61]">Recent Audit Trail Logs</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Live monitoring of admin & auth activities</p>
                    </div>
                    <a href="{{ route('reports.system-administrator') }}" class="text-xs font-semibold text-[#F47920] hover:underline" wire:navigate>
                        View Full Trail &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead>
                            <tr class="text-xs font-semibold text-zinc-400 border-b border-zinc-100 pb-2">
                                <th class="pb-3">User</th>
                                <th class="pb-3">Action</th>
                                <th class="pb-3">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse($recentLogs as $log)
                                <tr>
                                    <td class="py-3 flex items-center gap-2">
                                        @if($log->user && $log->user->avatar_url)
                                            <img src="{{ $log->user->avatar_url }}" alt="{{ $log->user->name }}" class="w-7 h-7 rounded-full object-cover border border-[#002B61]/10" referrerpolicy="no-referrer" />
                                        @else
                                            <div class="w-7 h-7 rounded-full bg-[#002B61]/5 border border-[#002B61]/10 text-[#002B61] text-[10px] font-bold flex items-center justify-center">
                                                {{ $log->user ? $log->user->initials() : 'SYS' }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-medium text-zinc-800 block text-xs">{{ $log->user ? $log->user->name : 'System Scheduler' }}</span>
                                            <span class="text-[10px] text-zinc-400 block">{{ $log->user ? ucwords(str_replace('-', ' ', $log->user->role)) : 'System' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $actionClass = match(true) {
                                                str_contains($log->action, 'login') => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                str_contains($log->action, 'logout') => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                                                str_contains($log->action, 'delete') || str_contains($log->action, 'reject') => 'bg-rose-50 text-rose-700 border-rose-100',
                                                str_contains($log->action, 'upload') || str_contains($log->action, 'create') => 'bg-blue-50 text-blue-700 border-blue-100',
                                                default => 'bg-amber-50 text-amber-700 border-amber-100'
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold border {{ $actionClass }}">
                                            {{ strtoupper(str_replace('_', ' ', $log->action)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-xs font-medium text-zinc-500">
                                        {{ $log->timestamp->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-8 text-zinc-400 text-sm">
                                        No recent audit logs found in the database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Col: System Actions & Graph -->
            <div class="flex flex-col gap-6">
                <!-- Quick Tools Card -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-sm font-bold text-[#002B61] uppercase tracking-wider">Quick Actions</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('accounts.system-administrator') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-[#002B61] text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Manage User Accounts</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Provision and toggle status</span>
                            </div>
                        </a>
                        <a href="{{ route('reports.system-administrator') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-purple-600 text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Security Audit Log Center</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Filter, search & inspect activities</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Activity Share breakdown widget -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-sm font-bold text-[#002B61] uppercase tracking-wider">Audit Log Share</h3>
                    
                    <div class="flex flex-col gap-3 mt-1">
                        <!-- Login bar -->
                        <div>
                            <div class="flex justify-between text-xs font-semibold text-zinc-600 mb-1">
                                <span>Logins & Sessions</span>
                                <span>{{ $loginPercent }}% ({{ $loginCount }} events)</span>
                            </div>
                            <div class="w-full bg-zinc-100 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $loginPercent }}%"></div>
                            </div>
                        </div>

                        <!-- Documents bar -->
                        <div>
                            <div class="flex justify-between text-xs font-semibold text-zinc-600 mb-1">
                                <span>Document Actions</span>
                                <span>{{ $docPercent }}% ({{ $docCount }} events)</span>
                            </div>
                            <div class="w-full bg-zinc-100 rounded-full h-2">
                                <div class="bg-[#F47920] h-2 rounded-full" style="width: {{ $docPercent }}%"></div>
                            </div>
                        </div>

                        <!-- Other bar -->
                        <div>
                            <div class="flex justify-between text-xs font-semibold text-zinc-600 mb-1">
                                <span>Other Admin Actions</span>
                                <span>{{ $otherPercent }}% ({{ $otherCount }} events)</span>
                            </div>
                            <div class="w-full bg-zinc-100 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $otherPercent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>