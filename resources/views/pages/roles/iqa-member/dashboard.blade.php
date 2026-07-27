@php
    $pendingReview = \App\Models\Document::where('status', 'pending')->count();
    $myAuditsCount = \App\Models\DocumentReview::where('reviewed_by', auth()->id())->count();
    $totalDocuments = \App\Models\Document::count();
    
    // OCR pending list or general recent uploads
    $ocrPendingList = \App\Models\DocumentOCRValidation::with('document')
        ->where('validation_status', 'pending')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        
    // Recent submissions
    $recentSubmissions = \App\Models\Document::with(['uploader', 'program', 'category'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#002B61]">IQA Staff Dashboard</h1>
                <p class="text-xs text-zinc-500 mt-1">Quality Assurance Operations & Document Verification</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-zinc-400 font-medium">System Time: {{ now()->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <!-- Three Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pending Reviews -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Awaiting Verification</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $pendingReview }}</span>
                    <span class="text-[11px] text-amber-600 font-medium mt-1.5 flex items-center gap-1">
                        <span class="inline-block h-2 w-2 rounded-full bg-amber-500 animate-ping"></span> 
                        Requires verification
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>

            <!-- My Audited Documents -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">My Audited Documents</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $myAuditsCount }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">
                        Reviews completed by you
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043A3.745 3.745 0 0 1 3 12Z" />
                    </svg>
                </div>
            </div>

            <!-- Total Uploaded Documents -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Archived Documents</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $totalDocuments }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Total institutional files</span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A9 9 0 0 1 12 3v0a9 9 0 0 1 9 9v.75m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0V17.25a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25V14" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Submissions List -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#002B61]">Recent Submissions Queue</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Submissions awaiting review and text verification</p>
                    </div>
                    <a href="{{ route('documents.iqa-member') }}" class="text-xs font-semibold text-[#F47920] hover:underline" wire:navigate>
                        View Verification Queue &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead>
                            <tr class="text-xs font-semibold text-zinc-400 border-b border-zinc-100 pb-2">
                                <th class="pb-3">Document Title</th>
                                <th class="pb-3">Program</th>
                                <th class="pb-3">Uploader</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse($recentSubmissions as $doc)
                                <tr>
                                    <td class="py-3 max-w-[250px] truncate font-semibold text-zinc-800">
                                        {{ $doc->title }}
                                        <span class="block text-[10px] text-zinc-400 font-normal mt-0.5 truncate">{{ $doc->category?->name }}</span>
                                    </td>
                                    <td class="py-3 text-xs font-bold text-zinc-600">
                                        {{ $doc->program?->code ?? 'General' }}
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
                                        No recent submissions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Col: OCR validation queue and actions -->
            <div class="flex flex-col gap-6">
                <!-- Actions -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-sm font-bold text-[#002B61] uppercase tracking-wider">IQA Tasks</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('documents.iqa-member') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-[#002B61] text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.75 3.75 0 0 1 21 12Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Verify Compliance Files</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Scan and cross-examine uploads</span>
                            </div>
                        </a>
                        <a href="{{ route('submissions.iqa-member') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-orange-500 text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Submissions List</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Detailed table of submissions</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- OCR Pending Queue -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-xs font-bold text-[#002B61] uppercase tracking-wider">Awaiting OCR Scan</h3>
                    <div class="flex flex-col gap-3">
                        @forelse($ocrPendingList as $ocr)
                            <div class="flex items-center justify-between p-2.5 bg-zinc-50 border border-zinc-100 rounded-lg">
                                <div class="min-w-0">
                                    <span class="block text-xs font-semibold text-zinc-800 truncate">{{ $ocr->document?->title }}</span>
                                    <span class="block text-[10px] text-zinc-400 font-medium mt-0.5">Uploaded {{ $ocr->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">QUEUED</span>
                            </div>
                        @empty
                            <div class="text-center py-6 text-zinc-400 text-xs">
                                No files currently waiting in OCR queue.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>