@php
    $totalInstruments = \App\Models\Instrument::count();
    $userId = auth()->id();
    $approvedRequests = \App\Models\DocumentAccessRequest::where('requested_by', $userId)->where('status', 'approved')->count();
    $pendingRequests = \App\Models\DocumentAccessRequest::where('requested_by', $userId)->where('status', 'pending')->count();
    
    // Categories with document counts
    $categories = \App\Models\DocumentCategory::withCount('documents')->get();
    
    // Recently accessed / granted documents
    $grantedRequests = \App\Models\DocumentAccessRequest::with(['document.uploader', 'document.program', 'document.category'])
        ->where('requested_by', $userId)
        ->where('status', 'approved')
        ->orderBy('updated_at', 'desc')
        ->take(5)
        ->get();
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#002B61]">Accreditor Dashboard</h1>
                <p class="text-xs text-zinc-500 mt-1">AACCUP External Quality Review Workspace</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-zinc-400 font-medium">Session Active &bull; External Reviewer</span>
            </div>
        </div>

        <!-- Three Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Instruments Count -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Accreditation Instruments</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalInstruments }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5 flex items-center gap-1">
                        Active AACCUP criteria guidelines
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638" />
                    </svg>
                </div>
            </div>

            <!-- Approved Access Requests -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Granted Documents</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $approvedRequests }}</span>
                    <span class="text-[11px] text-emerald-600 font-medium mt-1.5">
                        Accessible restricted files
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Pending Access</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $pendingRequests }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Awaiting IQA approval</span>
                </div>
                <div class="p-3.5 rounded-xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Granted Access Files -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#002B61]">Recently Granted Documents</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Files approved for your evaluation</p>
                    </div>
                    <a href="{{ route('documents.accreditor') }}" class="text-xs font-semibold text-[#F47920] hover:underline" wire:navigate>
                        Browse Files &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead>
                            <tr class="text-xs font-semibold text-zinc-400 border-b border-zinc-100 pb-2">
                                <th class="pb-3">Title</th>
                                <th class="pb-3">Category</th>
                                <th class="pb-3">Program</th>
                                <th class="pb-3">Access Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse($grantedRequests as $req)
                                @if($req->document)
                                    <tr>
                                        <td class="py-3 font-semibold text-[#002B61]">
                                            {{ $req->document->title }}
                                        </td>
                                        <td class="py-3 text-xs text-zinc-500">
                                            {{ $req->document->category?->name }}
                                        </td>
                                        <td class="py-3 text-xs font-bold text-zinc-600">
                                            {{ $req->document->program?->code ?? 'General' }}
                                        </td>
                                        <td class="py-3">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold border bg-emerald-50 text-emerald-700 border-emerald-100">
                                                GRANTED
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-zinc-400 text-sm">
                                        You have not been granted access to any restricted documents yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Col: Categories Browser -->
            <div class="flex flex-col gap-6">
                <!-- Quick Navigation -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-xs font-bold text-[#002B61] uppercase tracking-wider">Evaluation Hub</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('documents.accreditor') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-[#002B61] text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Browse All Folders</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Explore files cataloged by AACCUP criteria</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Document Categories counts -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-xs font-bold text-[#002B61] uppercase tracking-wider">Documents by Category</h3>
                    <div class="flex flex-col gap-2.5">
                        @forelse($categories as $cat)
                            <div class="flex items-center justify-between text-xs font-semibold text-zinc-600 border-b border-zinc-50 pb-2">
                                <span class="truncate max-w-[170px]">{{ $cat->name }}</span>
                                <span class="bg-[#002B61]/5 text-[#002B61] px-2 py-0.5 rounded-full text-[10px] font-bold">{{ $cat->documents_count }} files</span>
                            </div>
                        @empty
                            <div class="text-center py-4 text-zinc-400 text-xs">
                                No categories found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>