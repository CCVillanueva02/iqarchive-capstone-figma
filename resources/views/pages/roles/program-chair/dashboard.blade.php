@php
    $user = auth()->user();
    $role = $user->role;
    
    $isDean = ($role === 'college-head');
    $entityName = '';
    $totalUploads = 0;
    $totalReqs = 0;
    $compliedReqs = 0;
    $recentUploads = collect();
    $taskForceMembers = collect();
    
    if ($isDean && $user->college_id) {
        $college = $user->college;
        $entityName = $college?->name ?? 'College';
        $programIds = \App\Models\Program::where('college_id', $user->college_id)->pluck('id');
        
        $totalUploads = \App\Models\Document::whereIn('program_id', $programIds)->count();
        $totalReqs = \App\Models\ComplianceRequirement::whereIn('program_id', $programIds)->count();
        $compliedReqs = \App\Models\ComplianceRequirement::whereIn('program_id', $programIds)->where('status', 'complied')->count();
        
        $recentUploads = \App\Models\Document::with(['uploader', 'program', 'category'])
            ->whereIn('program_id', $programIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $taskForceMembers = \App\Models\TaskForceAssignment::with('user')
            ->whereIn('program_id', $programIds)
            ->get();
    } elseif ($user->program_id) {
        $program = $user->program;
        $entityName = $program?->name ?? 'Program';
        
        $totalUploads = \App\Models\Document::where('program_id', $user->program_id)->count();
        $totalReqs = \App\Models\ComplianceRequirement::where('program_id', $user->program_id)->count();
        $compliedReqs = \App\Models\ComplianceRequirement::where('program_id', $user->program_id)->where('status', 'complied')->count();
        
        $recentUploads = \App\Models\Document::with(['uploader', 'category'])
            ->where('program_id', $user->program_id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $taskForceMembers = \App\Models\TaskForceAssignment::with('user')
            ->where('program_id', $user->program_id)
            ->get();
    }
    
    $complianceRate = $totalReqs > 0 ? round(($compliedReqs / $totalReqs) * 100) : 0;
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#002B61]">
                    {{ $isDean ? 'College Dean Dashboard' : 'Program Chair Dashboard' }}
                </h1>
                <p class="text-xs text-zinc-500 mt-1">
                    QA Overview: <span class="font-bold text-[#002B61]">{{ $entityName }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-zinc-400 font-medium">Evaluation Workspace</span>
            </div>
        </div>

        <!-- Three Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Compliance Completion Rate -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Compliance Status</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $complianceRate }}%</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5 font-medium">
                        {{ $compliedReqs }} of {{ $totalReqs }} checklist items complied
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12Z" />
                    </svg>
                </div>
            </div>

            <!-- Total Uploads -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Total Uploads</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalUploads }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">
                        Documents archived in total
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25" />
                    </svg>
                </div>
            </div>

            <!-- Task Force Members Count -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">QA Task Force</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $taskForceMembers->count() }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5 font-medium">
                        Assigned team members
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-orange-50 text-[#F47920]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: College/Program Recent Submissions -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#002B61]">Recent Program Submissions</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Files uploaded by your assigned team members</p>
                    </div>
                    @php
                        $chairRole = $isDean ? 'program-chair' : $role;
                    @endphp
                    <a href="{{ route('documents.' . $chairRole) }}" class="text-xs font-semibold text-[#F47920] hover:underline" wire:navigate>
                        Inspect Files &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead>
                            <tr class="text-xs font-semibold text-zinc-400 border-b border-zinc-100 pb-2">
                                <th class="pb-3">Title</th>
                                <th class="pb-3">Category</th>
                                <th class="pb-3">Uploaded By</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse($recentUploads as $doc)
                                <tr>
                                    <td class="py-3 font-semibold text-[#002B61] max-w-[200px] truncate">
                                        {{ $doc->title }}
                                        @if($isDean)
                                            <span class="block text-[10px] text-zinc-400 font-bold mt-0.5">{{ $doc->program?->code }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-xs text-zinc-500">
                                        {{ $doc->category?->name }}
                                    </td>
                                    <td class="py-3 text-xs">
                                        {{ $doc->uploader?->name }}
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $statusClass = match($doc->status) {
                                                'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                                                default => 'bg-amber-50 text-amber-700 border-amber-100'
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold border {{ $statusClass }}">
                                            {{ strtoupper($doc->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-zinc-400 text-sm">
                                        No recent uploads found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Col: Task Force Team Directory -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="border-b border-zinc-100 pb-2 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-[#002B61] uppercase tracking-wider">Assigned Task Force</h3>
                </div>
                <div class="flex flex-col gap-3.5 max-h-[350px] overflow-y-auto pr-1">
                    @forelse($taskForceMembers as $member)
                        @if($member->user)
                            <div class="flex items-center gap-3 p-2.5 bg-zinc-50 border border-zinc-100 rounded-xl">
                                <div class="w-8 h-8 rounded-full bg-[#002B61]/5 border border-[#002B61]/10 text-[#002B61] font-bold text-xs flex items-center justify-center">
                                    {{ $member->user->initials() }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-xs font-semibold text-zinc-800 truncate">{{ $member->user->name }}</span>
                                    <span class="block text-[10px] text-zinc-400 font-medium mt-0.5 truncate">{{ $member->user->email }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-100">
                                    ACTIVE
                                </span>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-8 text-zinc-400 text-xs">
                            No active Task Force members assigned.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>