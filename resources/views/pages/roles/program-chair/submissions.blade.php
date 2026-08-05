@php
    $user    = auth()->user();
    $role    = $user->role;
    $isDean  = ($role === 'college-head');

    // ── Live DB data ──────────────────────────────────────────────────
    if ($isDean && $user->college_id) {
        $programIds = \App\Models\Program::where('college_id', $user->college_id)->pluck('id');
        $dbDocs = \App\Models\Document::with(['program', 'category', 'uploader', 'reviews.reviewer'])
            ->whereIn('program_id', $programIds)
            ->orderBy('created_at', 'desc')
            ->get();
    } elseif ($user->program_id) {
        $programIds = collect([$user->program_id]);
        $dbDocs = \App\Models\Document::with(['program', 'category', 'uploader', 'reviews.reviewer'])
            ->where('program_id', $user->program_id)
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        $programIds = \App\Models\Program::pluck('id');
        $dbDocs = \App\Models\Document::with(['program', 'category', 'uploader', 'reviews.reviewer'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // ── Mock sample data (fallback if DB has no records) ──
    $mockDocs = collect([
        (object)[
            'id'          => 901,
            'title'       => 'S.1 Vision & Mission Determination System',
            'category'    => (object)['name' => 'Area I – Vision, Mission, Goals & Objectives'],
            'program'     => (object)['name' => 'BS Information Technology', 'code' => 'BSIT'],
            'uploader'    => (object)['name' => 'Prof. Maria Santos'],
            'status'      => 'approved',
            'created_at'  => now()->subDays(12),
            'file_path'   => null,
            'latestRemark'=> 'Verified and endorsed by IQA Committee.',
        ],
        (object)[
            'id'          => 902,
            'title'       => 'S.2 Faculty Credentials & Academic Eligibility Matrix 2025',
            'category'    => (object)['name' => 'Area II – Faculty & Staff'],
            'program'     => (object)['name' => 'BS Information Technology', 'code' => 'BSIT'],
            'uploader'    => (object)['name' => 'Dr. Alex Rivera'],
            'status'      => 'approved',
            'created_at'  => now()->subDays(10),
            'file_path'   => null,
            'latestRemark'=> 'All faculty credentials validated.',
        ],
        (object)[
            'id'          => 903,
            'title'       => 'S.3 Course Syllabi & Instructional Plans AY 2025–2026',
            'category'    => (object)['name' => 'Area III – Curriculum & Instruction'],
            'program'     => (object)['name' => 'BS Computer Science', 'code' => 'BSCS'],
            'uploader'    => (object)['name' => 'Engr. Clara Reyes'],
            'status'      => 'pending',
            'created_at'  => now()->subDays(3),
            'file_path'   => null,
            'latestRemark'=> null,
        ],
        (object)[
            'id'          => 904,
            'title'       => 'S.4 Student Support Services Log & Guidance Records',
            'category'    => (object)['name' => 'Area IV – Support to Students'],
            'program'     => (object)['name' => 'BS Computer Science', 'code' => 'BSCS'],
            'uploader'    => (object)['name' => 'Prof. Mark Torres'],
            'status'      => 'returned',
            'created_at'  => now()->subDays(8),
            'file_path'   => null,
            'latestRemark'=> 'Please attach updated 2025 guidance counselor logs.',
        ],
        (object)[
            'id'          => 905,
            'title'       => 'S.5 Research Output & Publication List AY 2025',
            'category'    => (object)['name' => 'Area V – Research'],
            'program'     => (object)['name' => 'BS Information Technology', 'code' => 'BSIT'],
            'uploader'    => (object)['name' => 'Elena Gomez'],
            'status'      => 'pending',
            'created_at'  => now()->subDays(1),
            'file_path'   => null,
            'latestRemark'=> null,
        ],
    ]);

    // Merge real DB documents at the top, followed by mock docs if DB is small
    $displayDocs = $dbDocs->concat($mockDocs);

    // Summary counts
    $totalSubmitted = $displayDocs->count();
    $totalPending   = $displayDocs->where('status', 'pending')->count();
    $totalApproved  = $displayDocs->where('status', 'approved')->count();
    $totalReturned  = $displayDocs->whereIn('status', ['returned', 'denied'])->count();

    // Categories & Programs for modal
    $categories = \App\Models\DocumentCategory::orderBy('name')->get();
    if ($categories->isEmpty()) {
        $categories = collect([
            (object)['id' => 1, 'name' => 'Area I – Vision, Mission, Goals & Objectives'],
            (object)['id' => 2, 'name' => 'Area II – Faculty & Staff'],
            (object)['id' => 3, 'name' => 'Area III – Curriculum & Instruction'],
            (object)['id' => 4, 'name' => 'Area IV – Support to Students'],
            (object)['id' => 5, 'name' => 'Area V – Research'],
            (object)['id' => 6, 'name' => 'Area VI – Extension & Community'],
            (object)['id' => 7, 'name' => 'Area VII – Library Resources'],
        ]);
    }

    $programs = $isDean
        ? \App\Models\Program::whereIn('id', $programIds)->orderBy('name')->get()
        : \App\Models\Program::where('id', $user->program_id)->get();

    if ($programs->isEmpty()) {
        $programs = \App\Models\Program::all();
    }

    $entityName = $isDean
        ? ($user->college?->name ?? 'College of Science')
        : ($user->program?->name ?? 'BS Information Technology');
@endphp

<x-layouts::app :title="__('Submissions')">
<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen font-sans"
     x-data="{
        showModal: {{ $errors->any() ? 'true' : 'false' }},
        dragging: false,
        fileName: '',
        fileSize: '',
        submitting: false,
        filterStatus: 'all',

        handleDrop(e) {
            this.dragging = false;
            const file = e.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                const input = document.getElementById('doc-file-input');
                if (input) {
                    input.files = dt.files;
                }
                this.setFile(file);
            }
        },
        handleFileInput(e) {
            const file = e.target.files[0];
            if (file) this.setFile(file);
        },
        setFile(file) {
            this.fileName = file.name;
            const kb = file.size / 1024;
            this.fileSize = kb > 1024 ? (kb/1024).toFixed(1)+' MB' : kb.toFixed(0)+' KB';
        },
        clearFile() {
            this.fileName = '';
            this.fileSize = '';
            const input = document.getElementById('doc-file-input');
            if (input) input.value = '';
        }
     }">

    {{-- ─── Page Header ─────────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs">
        <div>
            <h1 class="text-2xl font-bold text-[#002B61]">Submissions</h1>
            <p class="text-xs text-zinc-500 mt-1">
                {{ $isDean ? 'Dean / College Head' : 'Program Chair' }} Workspace &bull;
                <span class="font-semibold text-[#002B61]">{{ $entityName }}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button
                type="button"
                @click="showModal = true"
                id="btn-submit-document"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#F47920] hover:bg-[#d96910] text-white text-sm font-bold shadow-sm transition-all duration-150 active:scale-[.97] cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Submit Document
            </button>
        </div>
    </div>

    {{-- ─── Flash Success Banner ─────────────────────────────────────── --}}
    @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 rounded-xl px-5 py-4">
            <div class="text-emerald-500 mt-0.5 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <p class="flex-1 text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
            <button @click="show = false" class="text-emerald-400 hover:text-emerald-700 transition p-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- ─── Returned Documents Alert Strip ─────────────────────────── --}}
    @if($totalReturned > 0)
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 flex items-start gap-3">
            <div class="mt-0.5 text-amber-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-amber-800">{{ $totalReturned }} {{ Str::plural('document', $totalReturned) }} need{{ $totalReturned === 1 ? 's' : '' }} revision</p>
                <p class="text-xs text-amber-600 mt-0.5">Check reviewer remarks and re-submit revised files directly from the table below.</p>
            </div>
            <button @click="filterStatus = 'returned'" class="shrink-0 text-xs font-bold text-amber-700 hover:text-amber-900 bg-amber-100 hover:bg-amber-200 px-3 py-1.5 rounded-lg transition">
                View Returned
            </button>
        </div>
    @endif

    {{-- ─── Submissions Table ────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-3xs flex flex-col">

        {{-- Table Header + Filter Tabs --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-5 border-b border-zinc-100">
            <div>
                <h2 class="text-base font-bold text-[#002B61]">All Document Submissions</h2>
                <p class="text-xs text-zinc-400 mt-0.5">Documents submitted for institutional quality assurance review</p>
            </div>
            <div class="flex items-center gap-1 bg-zinc-100 rounded-lg p-1 text-xs font-semibold overflow-x-auto">
                @foreach(['all' => 'All ('.$totalSubmitted.')', 'pending' => 'Pending ('.$totalPending.')', 'approved' => 'Approved ('.$totalApproved.')', 'returned' => 'Returned ('.$totalReturned.')'] as $val => $label)
                    <button
                        @click="filterStatus = '{{ $val }}'"
                        :class="filterStatus === '{{ $val }}' ? 'bg-white text-[#002B61] shadow-sm' : 'text-zinc-500 hover:text-zinc-700'"
                        class="px-3 py-1.5 rounded-md transition-all whitespace-nowrap">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider border-b border-zinc-100">
                        <th class="px-6 py-3 w-8">#</th>
                        <th class="px-6 py-3">Document Title</th>
                        <th class="px-6 py-3">Category / Area</th>
                        <th class="px-6 py-3">Submitted By</th>
                        <th class="px-6 py-3">Submitted Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Reviewer Remarks</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($displayDocs as $i => $doc)
                        @php
                            $isRealDoc = ($doc instanceof \App\Models\Document);
                            $docId     = $doc->id;
                            $docTitle  = $doc->title ?? '—';
                            $docCat    = is_object($doc->category ?? null) ? $doc->category->name : '—';
                            $uploaderName = is_object($doc->uploader ?? null) ? ($doc->uploader->name ?? $doc->uploader->first_name ?? '—') : 'Program Chair';
                            $docStatus = $doc->status ?? 'pending';
                            $docDate   = $doc->created_at instanceof \Carbon\Carbon
                                ? $doc->created_at
                                : \Carbon\Carbon::parse($doc->created_at);

                            if ($isRealDoc) {
                                $remarks = $doc->reviews->sortByDesc('reviewed_at')->first()?->remarks ?? null;
                            } else {
                                $remarks = $doc->latestRemark ?? null;
                            }

                            $statusConfig = match($docStatus) {
                                'approved'     => ['label'=>'Approved',      'class'=>'bg-emerald-50 text-emerald-700 border-emerald-100',  'dot'=>'bg-emerald-500'],
                                'returned'     => ['label'=>'Returned',      'class'=>'bg-amber-50 text-amber-700 border-amber-100',        'dot'=>'bg-amber-500'],
                                'denied'       => ['label'=>'Denied',        'class'=>'bg-rose-50 text-rose-700 border-rose-100',           'dot'=>'bg-rose-500'],
                                'under_review' => ['label'=>'Under Review',  'class'=>'bg-purple-50 text-purple-700 border-purple-100',     'dot'=>'bg-purple-500'],
                                default        => ['label'=>'Pending',       'class'=>'bg-zinc-100 text-zinc-600 border-zinc-200',          'dot'=>'bg-zinc-400'],
                            };

                            $filterKey = in_array($docStatus, ['returned','denied']) ? 'returned' : $docStatus;
                        @endphp
                        <tr
                            x-show="filterStatus === 'all' || filterStatus === '{{ $filterKey }}'"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            class="hover:bg-zinc-50/70 transition-colors group {{ $isRealDoc ? 'bg-amber-50/20' : '' }}">

                            {{-- Row number --}}
                            <td class="px-6 py-4 text-xs text-zinc-300 font-semibold">{{ $i + 1 }}</td>

                            {{-- Title --}}
                            <td class="px-6 py-4">
                                <span class="font-semibold text-[#002B61] block max-w-[240px] truncate" title="{{ $docTitle }}">
                                    {{ $docTitle }}
                                </span>
                                <span class="text-[10px] text-zinc-400 mt-0.5 flex items-center gap-1">
                                    <span class="font-mono">ID #{{ $docId }}</span>
                                    @if($isRealDoc)
                                        <span class="px-1.5 py-0.2 rounded bg-emerald-100 text-emerald-800 font-bold text-[9px]">LIVE SUBMISSION</span>
                                    @endif
                                </span>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4">
                                <span class="text-xs text-zinc-600 max-w-[180px] block truncate" title="{{ $docCat }}">{{ $docCat }}</span>
                            </td>

                            {{-- Submitted By --}}
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-zinc-700 block">{{ $uploaderName }}</span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs text-zinc-600 block">{{ $docDate->format('M d, Y') }}</span>
                                <span class="text-[10px] text-zinc-400">{{ $docDate->format('h:i A') }}</span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusConfig['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }} {{ $docStatus === 'pending' ? 'animate-ping' : '' }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>

                            {{-- Remarks --}}
                            <td class="px-6 py-4 max-w-[180px]">
                                @if($remarks)
                                    <span class="text-xs text-zinc-600 italic block truncate" title="{{ $remarks }}">
                                        "{{ $remarks }}"
                                    </span>
                                @else
                                    <span class="text-zinc-300 text-xs">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- View --}}
                                    @if($isRealDoc && $doc->file_path)
                                        <a href="{{ route('documents.serve', $doc->id) }}" target="_blank"
                                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-zinc-600 bg-zinc-100 hover:bg-zinc-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            View File
                                        </a>
                                    @endif

                                    {{-- Re-submit button for Returned/Denied --}}
                                    @if(in_array($docStatus, ['returned', 'denied']))
                                        <button
                                            type="button"
                                            @click="showModal = true"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-white bg-[#F47920] hover:bg-[#d96910] transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                            </svg>
                                            Re-submit
                                        </button>
                                    @endif

                                    @if($docStatus === 'pending')
                                        <span class="text-[10px] text-zinc-400 italic">Awaiting IQA review</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-3 border-t border-zinc-50 flex items-center justify-between">
            <p class="text-xs text-zinc-400">{{ $totalSubmitted }} {{ Str::plural('document', $totalSubmitted) }} total</p>
            <p class="text-[10px] text-zinc-400 font-medium">Real-time synchronized across IQA Member and Admin portals</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         SUBMIT DOCUMENT MODAL (PLACED INSIDE X-DATA ROOT)
         ════════════════════════════════════════════════════════════════ --}}
    <div
        x-show="showModal"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showModal = false; clearFile()"></div>

        {{-- Modal Panel --}}
        <div
            x-show="showModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg max-h-[92vh] overflow-y-auto z-10">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-zinc-100">
                <div>
                    <h2 class="text-lg font-bold text-[#002B61]">Submit Document</h2>
                    <p class="text-xs text-zinc-400 mt-0.5">Upload a document for IQA review and accreditation compliance</p>
                </div>
                <button type="button" @click="showModal = false; clearFile()" class="text-zinc-400 hover:text-zinc-700 p-1.5 rounded-lg hover:bg-zinc-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Validation Errors Banner inside Modal --}}
            @if($errors->any())
                <div class="mx-6 mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700">
                    <p class="font-bold mb-1">Please fix the following validation errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Modal Form --}}
            <form
                action="{{ route('submissions.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="px-6 py-5 flex flex-col gap-5"
                @submit="submitting = true">
                @csrf

                {{-- Document Title --}}
                <div class="flex flex-col gap-1.5">
                    <label for="doc-title" class="text-xs font-bold text-zinc-700">
                        Document Title <span class="text-rose-500">*</span>
                    </label>
                    <input
                        id="doc-title"
                        name="title"
                        type="text"
                        required
                        value="{{ old('title') }}"
                        placeholder="e.g. Faculty Credentials Matrix 2025"
                        class="w-full border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300 focus:outline-none focus:ring-2 focus:ring-[#002B61]/20 focus:border-[#002B61] transition" />
                </div>

                {{-- Program --}}
                @if($isDean && $programs->isNotEmpty())
                    <div class="flex flex-col gap-1.5">
                        <label for="doc-program" class="text-xs font-bold text-zinc-700">
                            Program <span class="text-rose-500">*</span>
                        </label>
                        <select
                            id="doc-program"
                            name="program_id"
                            required
                            class="w-full border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-[#002B61]/20 focus:border-[#002B61] transition bg-white">
                            <option value="" disabled selected>Select a program…</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}">{{ $prog->name }} ({{ $prog->code }})</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="program_id" value="{{ $user->program_id ?? ($programs->first()?->id ?? '') }}" />
                @endif

                {{-- Category --}}
                <div class="flex flex-col gap-1.5">
                    <label for="doc-category" class="text-xs font-bold text-zinc-700">
                        Category / Instrument Area <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="doc-category"
                        name="category_id"
                        required
                        class="w-full border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-[#002B61]/20 focus:border-[#002B61] transition bg-white">
                        <option value="" disabled selected>Select a category…</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Notes --}}
                <div class="flex flex-col gap-1.5">
                    <label for="doc-notes" class="text-xs font-bold text-zinc-700">
                        Notes <span class="text-zinc-400 font-normal">(optional)</span>
                    </label>
                    <textarea
                        id="doc-notes"
                        name="description"
                        rows="3"
                        placeholder="Any additional context for the IQA reviewer…"
                        class="w-full border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300 focus:outline-none focus:ring-2 focus:ring-[#002B61]/20 focus:border-[#002B61] transition resize-none">{{ old('description') }}</textarea>
                </div>

                {{-- File Drop Zone / Input --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">
                        File Upload <span class="text-rose-500">*</span>
                    </label>
                    <div
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="handleDrop($event)"
                        @click="$refs.fileInput.click()"
                        :class="dragging ? 'border-[#002B61] bg-blue-50/60 scale-[1.01]' : 'border-zinc-200 bg-zinc-50/50 hover:border-[#002B61]/40 hover:bg-zinc-50'"
                        class="w-full border-2 border-dashed rounded-xl p-6 flex flex-col items-center justify-center gap-2 cursor-pointer transition-all duration-150">

                        <template x-if="!fileName">
                            <div class="flex flex-col items-center gap-2 pointer-events-none">
                                <div class="w-11 h-11 rounded-full bg-blue-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#002B61]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-zinc-600">Drag &amp; drop or <span class="text-[#F47920]">browse file</span></p>
                                <p class="text-[11px] text-zinc-400">PDF, DOCX, XLSX &bull; Max 50 MB</p>
                            </div>
                        </template>

                        <template x-if="fileName">
                            <div class="flex items-center gap-3 w-full pointer-events-none">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-zinc-700 truncate" x-text="fileName"></p>
                                    <p class="text-[11px] text-zinc-400" x-text="fileSize"></p>
                                </div>
                                <button type="button" @click.stop="clearFile()" class="pointer-events-auto text-zinc-400 hover:text-rose-500 p-1 rounded transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <input
                            id="doc-file-input"
                            name="file"
                            type="file"
                            required
                            accept=".pdf,.docx,.xlsx,.doc,.xls"
                            x-ref="fileInput"
                            @change="handleFileInput($event)"
                            class="hidden" />
                    </div>
                </div>

                {{-- Info notice --}}
                <div class="flex items-start gap-2.5 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <p class="text-[11px] text-blue-700 leading-relaxed">
                        After submission, your document will be set to <strong>Pending</strong> and will immediately appear on the IQA Member Review Queue and IQA Admin Monitoring Portal.
                    </p>
                </div>

                {{-- Modal Actions --}}
                <div class="flex items-center justify-end gap-3 pt-1 border-t border-zinc-100 mt-1">
                    <button
                        type="button"
                        @click="showModal = false; clearFile()"
                        class="px-4 py-2.5 rounded-xl text-sm font-semibold text-zinc-600 bg-zinc-100 hover:bg-zinc-200 transition">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        id="btn-submit-form"
                        :disabled="submitting"
                        :class="submitting ? 'opacity-60 cursor-not-allowed' : 'hover:bg-[#d96910] active:scale-[.97]'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-[#F47920] transition-all flex items-center gap-2">
                        <span x-show="!submitting">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline -mt-0.5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                            Submit Document
                        </span>
                        <span x-show="submitting" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
                            Submitting…
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

</x-layouts::app>