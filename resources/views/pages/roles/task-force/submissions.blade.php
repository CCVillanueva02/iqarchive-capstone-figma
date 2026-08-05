@php
    $user = auth()->user();

    // ── Live DB Submissions ───────────────────────────────────────────
    $dbDocs = \App\Models\Document::with(['program', 'category', 'uploader', 'reviews.reviewer'])
        ->orderBy('created_at', 'desc')
        ->get();

    // ── Mock Submissions ──────────────────────────────────────────────
    $mockDocs = collect([
        (object)[
            'id'          => 601,
            'title'       => 'S.1 Vision & Mission Determination System',
            'category'    => (object)['name' => 'Area I – Vision, Mission, Goals & Objectives'],
            'program'     => (object)['name' => 'BS Information Technology', 'code' => 'BSIT'],
            'uploader'    => (object)['name' => 'Prof. Maria Santos'],
            'status'      => 'approved',
            'created_at'  => now()->subDays(12),
            'latestRemark'=> 'Verified and endorsed by IQA Committee.',
        ],
        (object)[
            'id'          => 602,
            'title'       => 'S.2 Faculty Credentials & Academic Eligibility Matrix 2025',
            'category'    => (object)['name' => 'Area II – Faculty & Staff'],
            'program'     => (object)['name' => 'BS Computer Science', 'code' => 'BSCS'],
            'uploader'    => (object)['name' => 'Dr. Alex Rivera'],
            'status'      => 'pending',
            'created_at'  => now()->subHours(6),
            'latestRemark'=> null,
        ],
    ]);

    $displayDocs = $dbDocs->concat($mockDocs);

    $totalCount   = $displayDocs->count();
    $pendingCount = $displayDocs->where('status', 'pending')->count();
    $approvedCount= $displayDocs->where('status', 'approved')->count();

    $categories = \App\Models\DocumentCategory::orderBy('name')->get();
    if ($categories->isEmpty()) {
        $categories = collect([
            (object)['id' => 1, 'name' => 'Area I – Vision, Mission, Goals & Objectives'],
            (object)['id' => 2, 'name' => 'Area II – Faculty & Staff'],
            (object)['id' => 3, 'name' => 'Area III – Curriculum & Instruction'],
        ]);
    }
    $programs = \App\Models\Program::orderBy('name')->get();
@endphp

<x-layouts::app :title="__('QA Task Force Submissions')">
<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen font-sans"
     x-data="{
        showUploadModal: false,
        filterStatus: 'all'
     }">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs">
        <div>
            <h1 class="text-2xl font-bold text-[#002B61]">QA Task Force Submissions</h1>
            <p class="text-xs text-zinc-500 mt-1">
                QA Task Force Portal &bull; Submit and track accreditation area documents
            </p>
        </div>
        <button
            type="button"
            @click="showUploadModal = true"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#F47920] hover:bg-[#d96910] text-white text-sm font-bold shadow-sm transition-all cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Submit Document
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-5 py-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-3xs flex flex-col">
        <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-100">
            <div>
                <h2 class="text-base font-bold text-[#002B61]">Task Force Submissions</h2>
                <p class="text-xs text-zinc-400 mt-0.5">Accreditation documents uploaded by team members</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider border-b border-zinc-100">
                        <th class="px-6 py-3 w-8">#</th>
                        <th class="px-6 py-3">Document Title</th>
                        <th class="px-6 py-3">Category / Area</th>
                        <th class="px-6 py-3">Program</th>
                        <th class="px-6 py-3">Submitted By</th>
                        <th class="px-6 py-3">Submitted Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">File Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($displayDocs as $i => $doc)
                        @php
                            $isRealDoc = ($doc instanceof \App\Models\Document);
                            $docTitle  = $doc->title ?? '—';
                            $docCat    = is_object($doc->category ?? null) ? $doc->category->name : '—';
                            $docProg   = is_object($doc->program ?? null)  ? ($doc->program->code ?? $doc->program->name)  : '—';
                            $uploaderName = is_object($doc->uploader ?? null) ? ($doc->uploader->name ?? $doc->uploader->first_name ?? '—') : 'Task Force Member';
                            $docStatus = $doc->status ?? 'pending';
                            $docDate   = $doc->created_at instanceof \Carbon\Carbon
                                ? $doc->created_at
                                : \Carbon\Carbon::parse($doc->created_at);

                            $statusConfig = match($docStatus) {
                                'approved' => ['label'=>'Approved', 'class'=>'bg-emerald-50 text-emerald-700 border-emerald-100'],
                                'returned' => ['label'=>'Returned', 'class'=>'bg-amber-50 text-amber-700 border-amber-100'],
                                'denied'   => ['label'=>'Denied',   'class'=>'bg-rose-50 text-rose-700 border-rose-100'],
                                default    => ['label'=>'Pending',  'class'=>'bg-zinc-100 text-zinc-600 border-zinc-200'],
                            };
                        @endphp
                        <tr class="hover:bg-zinc-50/70 transition-colors {{ $isRealDoc ? 'bg-amber-50/20' : '' }}">
                            <td class="px-6 py-4 text-xs text-zinc-300 font-semibold">{{ $i + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-[#002B61] block max-w-[220px] truncate">{{ $docTitle }}</span>
                                @if($isRealDoc)
                                    <span class="px-1.5 py-0.2 rounded bg-emerald-100 text-emerald-800 font-bold text-[9px]">LIVE</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-zinc-600 max-w-[160px] truncate">{{ $docCat }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-zinc-700">{{ $docProg }}</td>
                            <td class="px-6 py-4 text-xs font-semibold text-zinc-700">{{ $uploaderName }}</td>
                            <td class="px-6 py-4 text-xs text-zinc-500">{{ $docDate->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusConfig['class'] }}">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($isRealDoc && $doc->file_path)
                                    <a href="{{ route('documents.serve', $doc->id) }}" target="_blank" class="text-xs font-bold text-[#F47920] hover:underline">
                                        View File &rarr;
                                    </a>
                                @else
                                    <span class="text-xs text-zinc-400">Sample</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Upload Modal (INSIDE X-DATA) --}}
    <div x-show="showUploadModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showUploadModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden z-10">
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-zinc-100">
                <h2 class="text-lg font-bold text-[#002B61]">Submit Area Document</h2>
                <button type="button" @click="showUploadModal = false" class="text-zinc-400 hover:text-zinc-700">&times;</button>
            </div>
            <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-5 flex flex-col gap-4">
                @csrf
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">Document Title *</label>
                    <input name="title" type="text" required placeholder="e.g. Area III Curriculum Compliance Report" class="w-full border border-zinc-200 rounded-xl px-4 py-2 text-sm" />
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">Program</label>
                    <select name="program_id" class="w-full border border-zinc-200 rounded-xl px-4 py-2 text-sm bg-white">
                        <option value="">Institution-wide</option>
                        @foreach($programs as $prog)
                            <option value="{{ $prog->id }}">{{ $prog->name }} ({{ $prog->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">Category / Area *</label>
                    <select name="category_id" required class="w-full border border-zinc-200 rounded-xl px-4 py-2 text-sm bg-white">
                        <option value="" disabled selected>Select category...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">File Upload *</label>
                    <input name="file" type="file" required accept=".pdf,.docx,.xlsx,.doc,.xls" class="w-full border border-zinc-200 rounded-xl px-3 py-2 text-xs bg-zinc-50" />
                </div>
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-zinc-100">
                    <button type="button" @click="showUploadModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-zinc-600 bg-zinc-100">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#F47920]">Submit Document</button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts::app>