@php
    $user = auth()->user();
    $program = $user->program;
    
    // Total documents uploaded by this user
    $userUploadsCount = \App\Models\Document::where('uploaded_by', $user->id)->count();
    
    // Compliance tasks for program
    $programReqsCount = 0;
    $programCompliedCount = 0;
    $programReqs = collect();
    
    if ($user->program_id) {
        $programReqs = \App\Models\ComplianceRequirement::with('instrument')
            ->where('program_id', $user->program_id)
            ->orderBy('due_date', 'asc')
            ->get();
            
        $programReqsCount = $programReqs->count();
        $programCompliedCount = $programReqs->where('status', 'complied')->count();
    }
    
    $complianceRate = $programReqsCount > 0 ? round(($programCompliedCount / $programReqsCount) * 100) : 0;
    
    // User's recent uploads with review status
    $userRecentUploads = \App\Models\Document::with(['category', 'reviews'])
        ->where('uploaded_by', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#002B61]">QA Task Force Dashboard</h1>
                @if($program)
                    <p class="text-xs text-zinc-500 mt-1">Assigned Program: <span class="font-bold text-[#002B61]">{{ $program->name }} ({{ $program->code }})</span></p>
                @else
                    <p class="text-xs text-zinc-500 mt-1">Assigned Program: <span class="font-bold text-zinc-400">None Assigned</span></p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-zinc-400 font-medium">Task Force Workspace</span>
            </div>
        </div>

        <!-- Three Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Program Compliance Completion Rate -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Program Compliance</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $complianceRate }}%</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">
                        {{ $programCompliedCount }} of {{ $programReqsCount }} requirements met
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043A3.745 3.745 0 0 1 3 12Z" />
                    </svg>
                </div>
            </div>

            <!-- Total Uploads by User -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Your Uploads</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $userUploadsCount }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">
                        Documents archived by you
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                    </svg>
                </div>
            </div>

            <!-- Quick Action button -->
            <div class="bg-[#002B61] p-6 rounded-2xl border border-white/5 shadow-3xs hover:shadow-xs transition duration-200 flex flex-col justify-between text-white">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-white/60 uppercase tracking-wider">QA Task Actions</span>
                    <span class="text-sm font-bold mt-1">Need to submit a file?</span>
                </div>
                <a href="{{ route('documents.task-force') }}" class="mt-4 px-4 py-2 bg-[#F47920] hover:bg-[#d86512] transition-colors rounded-xl text-xs font-bold text-center text-white" wire:navigate>
                    Upload Compliance Document
                </a>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: User's Recent Uploads -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#002B61]">Your Recent Uploads</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Track status and review reviews for files you submitted</p>
                    </div>
                    <a href="{{ route('submissions.task-force') }}" class="text-xs font-semibold text-[#F47920] hover:underline" wire:navigate>
                        View Submissions &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead>
                            <tr class="text-xs font-semibold text-zinc-400 border-b border-zinc-100 pb-2">
                                <th class="pb-3">Title</th>
                                <th class="pb-3">Category</th>
                                <th class="pb-3">Review Status</th>
                                <th class="pb-3">Remarks / Feedback</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse($userRecentUploads as $doc)
                                <tr>
                                    <td class="py-3 font-semibold text-[#002B61] max-w-[200px] truncate">
                                        {{ $doc->title }}
                                    </td>
                                    <td class="py-3 text-xs text-zinc-500">
                                        {{ $doc->category?->name }}
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
                                    <td class="py-3 text-xs text-zinc-400 max-w-[200px] truncate">
                                        {{ $doc->reviews->last()?->remarks ?? 'No feedback yet' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-zinc-400 text-sm">
                                        You have not uploaded any documents yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Col: Compliance Tasks List -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="border-b border-zinc-100 pb-2">
                    <h3 class="text-xs font-bold text-[#002B61] uppercase tracking-wider">Compliance Checklist</h3>
                </div>
                <div class="flex flex-col gap-3.5 max-h-[350px] overflow-y-auto pr-1">
                    @forelse($programReqs as $req)
                        <div class="flex flex-col p-3 bg-zinc-50 border border-zinc-100 rounded-xl">
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-xs font-semibold text-zinc-800 line-clamp-2 leading-snug">{{ $req->description }}</span>
                                @php
                                    $reqStatusClass = match($req->status) {
                                        'complied' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'overdue' => 'bg-rose-50 text-rose-700 border-rose-100',
                                        'in_progress' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        default => 'bg-zinc-100 text-zinc-600 border-zinc-200'
                                    };
                                @endphp
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold border shrink-0 {{ $reqStatusClass }}">
                                    {{ strtoupper(str_replace('_', ' ', $req->status)) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-[10px] text-zinc-400 font-medium mt-2">
                                <span>Instrument: {{ $req->instrument?->code }}</span>
                                <span class="{{ $req->due_date && $req->due_date->isPast() && $req->status !== 'complied' ? 'text-rose-500 font-semibold' : '' }}">
                                    Due: {{ $req->due_date ? $req->due_date->format('M d, Y') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-zinc-400 text-xs">
                            No compliance tasks configured for your program.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>