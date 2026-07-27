@php
    $totalPrograms = \App\Models\Program::count();
    $totalCompliantDocs = \App\Models\Document::where('status', 'approved')->count();
    
    // Compliance requirements stats
    $totalReqs = \App\Models\ComplianceRequirement::count();
    $compliedReqs = \App\Models\ComplianceRequirement::where('status', 'complied')->count();
    $inProgressReqs = \App\Models\ComplianceRequirement::where('status', 'in_progress')->count();
    $overdueReqs = \App\Models\ComplianceRequirement::where('status', 'overdue')->count();
    
    $complianceRate = $totalReqs > 0 ? round(($compliedReqs / $totalReqs) * 100) : 0;
    
    // Get college breakdown
    $colleges = \App\Models\College::withCount('programs')->get()->map(function ($college) {
        $college->uploads_count = \App\Models\Document::whereHas('program', function ($q) use ($college) {
            $q->where('college_id', $college->id);
        })->count();
        
        $college->complied_count = \App\Models\ComplianceRequirement::where('status', 'complied')
            ->whereHas('program', function ($q) use ($college) {
                $q->where('college_id', $college->id);
            })->count();
            
        $college->total_reqs = \App\Models\ComplianceRequirement::whereHas('program', function ($q) use ($college) {
            $q->where('college_id', $college->id);
        })->count();
        
        $college->compliance_rate = $college->total_reqs > 0 
            ? round(($college->complied_count / $college->total_reqs) * 100) 
            : 0;
            
        return $college;
    });
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#002B61]">University Executive Dashboard</h1>
                <p class="text-xs text-zinc-500 mt-1">Bicol University Institutional Quality Assurance Analytics</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-zinc-400 font-medium">Academic Year 2026-2027</span>
            </div>
        </div>

        <!-- Three Analytics Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Overall Compliance -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Institutional Compliance</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $complianceRate }}%</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5 flex items-center gap-1">
                        {{ $compliedReqs }} of {{ $totalReqs }} requirements met
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12Z" />
                    </svg>
                </div>
            </div>

            <!-- Compliant Documents -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Accredited Programs</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalPrograms }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">
                        Active monitored programs
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.99 5.99 0 0 1 12 3.453a5.99 5.99 0 0 1 4.543 5.881 50.58 50.58 0 0 0-2.658.813m-9.227 0L12 13.545l3.878-3.4m-7.756 0a48.36 48.36 0 0 1 7.756 0" />
                    </svg>
                </div>
            </div>

            <!-- Total Uploaded Documents -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Compliance Assets</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalCompliantDocs }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Approved compliance uploads</span>
                </div>
                <div class="p-3.5 rounded-xl bg-orange-50 text-[#F47920]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: College Compliance Breakdown Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="border-b border-zinc-100 pb-4">
                    <h2 class="text-lg font-bold text-[#002B61]">College Quality Assurance Performance</h2>
                    <p class="text-xs text-zinc-400 mt-0.5">High-level comparison across Bicol University colleges</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead>
                            <tr class="text-xs font-semibold text-zinc-400 border-b border-zinc-100 pb-2">
                                <th class="pb-3">College</th>
                                <th class="pb-3 text-center">Programs</th>
                                <th class="pb-3 text-center">Archived Files</th>
                                <th class="pb-3 text-center">Compliance Tasks Met</th>
                                <th class="pb-3 text-right">Compliance Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50 font-medium">
                            @forelse($colleges as $college)
                                <tr>
                                    <td class="py-3.5">
                                        <span class="block text-sm font-semibold text-zinc-800">{{ $college->name }}</span>
                                        <span class="block text-[10px] text-zinc-400 font-mono mt-0.5">{{ $college->code }} Code</span>
                                    </td>
                                    <td class="py-3.5 text-center text-zinc-600">
                                        {{ $college->programs_count }}
                                    </td>
                                    <td class="py-3.5 text-center text-zinc-600">
                                        {{ $college->uploads_count }}
                                    </td>
                                    <td class="py-3.5 text-center text-zinc-500 text-xs">
                                        {{ $college->complied_count }} / {{ $college->total_reqs }}
                                    </td>
                                    <td class="py-3.5 text-right font-bold text-[#002B61]">
                                        {{ $college->compliance_rate }}%
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-zinc-400 text-sm">
                                        No colleges seeded in the database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Col: Requirements Summary & Quick reports link -->
            <div class="flex flex-col gap-6">
                <!-- Navigation -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-xs font-bold text-[#002B61] uppercase tracking-wider">Executive Actions</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('reports.university-administrator') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-[#002B61] text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h7.5m-7.5 3h7.5m-7.5 3h7.5m-.75 6h7.5M3 3h18v18H3V3Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">View University Reports</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Generate print-ready audit summaries</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Compliance Breakdown Widget -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-xs font-bold text-[#002B61] uppercase tracking-wider">Compliance Tasks Overview</h3>
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between items-center text-xs font-semibold text-zinc-600">
                            <span class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Complied
                            </span>
                            <span>{{ $compliedReqs }} tasks</span>
                        </div>
                        <div class="flex justify-between items-center text-xs font-semibold text-zinc-600">
                            <span class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span> In Progress
                            </span>
                            <span>{{ $inProgressReqs }} tasks</span>
                        </div>
                        <div class="flex justify-between items-center text-xs font-semibold text-zinc-600">
                            <span class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span> Overdue
                            </span>
                            <span class="text-rose-600">{{ $overdueReqs }} overdue</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>