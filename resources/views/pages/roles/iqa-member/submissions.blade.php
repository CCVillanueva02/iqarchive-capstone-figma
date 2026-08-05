@php
    $user = auth()->user();

    // ── Live DB Submissions ───────────────────────────────────────────
    $dbDocs = \App\Models\Document::with(['program', 'category', 'uploader', 'reviews.reviewer'])
        ->orderBy('created_at', 'desc')
        ->get();

    // ── Fallback sample submissions if DB has none or few ──────────────
    $mockDocs = collect([
        (object)[
            'id'          => 801,
            'title'       => 'S.1 Vision & Mission Determination System',
            'category'    => (object)['name' => 'Area I – Vision, Mission, Goals & Objectives'],
            'program'     => (object)['name' => 'BS Information Technology', 'code' => 'BSIT'],
            'uploader'    => (object)['name' => 'Prof. Maria Santos'],
            'status'      => 'pending',
            'created_at'  => now()->subHours(4),
            'file_path'   => null,
            'latestRemark'=> null,
        ],
        (object)[
            'id'          => 802,
            'title'       => 'S.2 Faculty Credentials & Academic Eligibility Matrix 2025',
            'category'    => (object)['name' => 'Area II – Faculty & Staff'],
            'program'     => (object)['name' => 'BS Computer Science', 'code' => 'BSCS'],
            'uploader'    => (object)['name' => 'Dr. Alex Rivera'],
            'status'      => 'pending',
            'created_at'  => now()->subHours(12),
            'file_path'   => null,
            'latestRemark'=> null,
        ],
        (object)[
            'id'          => 803,
            'title'       => 'S.3 Course Syllabi & Instructional Plans AY 2025–2026',
            'category'    => (object)['name' => 'Area III – Curriculum & Instruction'],
            'program'     => (object)['name' => 'BS Information Technology', 'code' => 'BSIT'],
            'uploader'    => (object)['name' => 'Engr. Clara Reyes'],
            'status'      => 'approved',
            'created_at'  => now()->subDays(3),
            'file_path'   => null,
            'latestRemark'=> 'Verified and endorsed by IQA Committee.',
        ],
        (object)[
            'id'          => 804,
            'title'       => 'S.4 Student Support Services Log & Guidance Records',
            'category'    => (object)['name' => 'Area IV – Support to Students'],
            'program'     => (object)['name' => 'BS Computer Science', 'code' => 'BSCS'],
            'uploader'    => (object)['name' => 'Prof. Mark Torres'],
            'status'      => 'returned',
            'created_at'  => now()->subDays(5),
            'file_path'   => null,
            'latestRemark'=> 'Please attach updated guidance counselor logs.',
        ],
    ]);

    // Show real DB docs first, concatenated with sample docs
    $allSubmissions = $dbDocs->concat($mockDocs);

    $pendingDocs  = $allSubmissions->where('status', 'pending');
    $reviewedDocs = $allSubmissions->whereIn('status', ['approved', 'returned', 'denied']);

    // Categories & Programs for Upload Modal
    $categories = \App\Models\DocumentCategory::orderBy('name')->get();
    if ($categories->isEmpty()) {
        $categories = collect([
            (object)['id' => 1, 'name' => 'Area I – Vision, Mission, Goals & Objectives'],
            (object)['id' => 2, 'name' => 'Area II – Faculty & Staff'],
            (object)['id' => 3, 'name' => 'Area III – Curriculum & Instruction'],
            (object)['id' => 4, 'name' => 'Area IV – Support to Students'],
            (object)['id' => 5, 'name' => 'Area V – Research'],
        ]);
    }
    $programs = \App\Models\Program::orderBy('name')->get();
@endphp

<x-layouts::app :title="__('IQA Submissions & Review Queue')">
<div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen font-sans"
     x-data="{
        showUploadModal: false,
        reviewModalDoc: null,
        reviewDecision: 'approved',
        reviewRemarks: '',
        fileName: '',
        fileSize: '',
        submitting: false,
        activeTab: 'queue',

        openReview(doc) {
            this.reviewModalDoc = doc;
            this.reviewDecision = 'approved';
            this.reviewRemarks = '';
        },
        closeReview() {
            this.reviewModalDoc = null;
        },
        setFile(file) {
            this.fileName = file.name;
            const kb = file.size / 1024;
            this.fileSize = kb > 1024 ? (kb/1024).toFixed(1)+' MB' : kb.toFixed(0)+' KB';
        },
        clearFile() {
            this.fileName = '';
            this.fileSize = '';
            const input = document.getElementById('iqa-doc-file-input');
            if (input) input.value = '';
        }
     }">

    {{-- ─── Page Header ─────────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs">
        <div>
            <h1 class="text-2xl font-bold text-[#002B61]">Document Review & Submissions</h1>
            <p class="text-xs text-zinc-500 mt-1">
                IQA Staff Member Workspace &bull; Review incoming submissions from Program Chairs and Task Forces
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button
                type="button"
                @click="showUploadModal = true"
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

    {{-- ─── Flash Info Banner (e.g. mock doc review attempt) ────────── --}}
    @if(session('info'))
        <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl px-5 py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
        </div>
    @endif

    {{-- ─── Main Submissions Card ────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-3xs flex flex-col">

        {{-- Navigation Tabs --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100">
            <div class="flex items-center gap-2">
                <button
                    @click="activeTab = 'queue'"
                    :class="activeTab === 'queue' ? 'bg-[#002B61] text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping" x-show="activeTab === 'queue'"></span>
                    Review Queue ({{ $pendingDocs->count() }})
                </button>
                <button
                    @click="activeTab = 'history'"
                    :class="activeTab === 'history' ? 'bg-[#002B61] text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
                    Review History ({{ $reviewedDocs->count() }})
                </button>
            </div>
            <p class="text-xs text-zinc-400">Click <strong>Review</strong> to verify and evaluate a submission</p>
        </div>

        {{-- Queue Table --}}
        <div class="overflow-x-auto" x-show="activeTab === 'queue'">
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
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @forelse($pendingDocs as $i => $doc)
                        @php
                            $isRealDoc = ($doc instanceof \App\Models\Document);
                            $docId     = $doc->id;
                            $docTitle  = $doc->title ?? '—';
                            $docCat    = is_object($doc->category ?? null) ? $doc->category->name : '—';
                            $docProg   = is_object($doc->program ?? null)  ? ($doc->program->code ?? $doc->program->name)  : '—';
                            $uploaderName = is_object($doc->uploader ?? null) ? ($doc->uploader->name ?? $doc->uploader->first_name ?? '—') : 'Program Chair';
                            $docDate   = $doc->created_at instanceof \Carbon\Carbon
                                ? $doc->created_at
                                : \Carbon\Carbon::parse($doc->created_at);
                        @endphp
                        <tr class="hover:bg-zinc-50/70 transition-colors {{ $isRealDoc ? 'bg-amber-50/30' : '' }}">
                            <td class="px-6 py-4 text-xs text-zinc-300 font-semibold">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-[#002B61] block max-w-[240px] truncate" title="{{ $docTitle }}">
                                    {{ $docTitle }}
                                </span>
                                <span class="text-[10px] text-zinc-400 mt-0.5 flex items-center gap-1 font-mono">
                                    ID #{{ $docId }}
                                    @if($isRealDoc)
                                        <span class="px-1.5 py-0.2 rounded bg-amber-100 text-amber-800 font-bold text-[9px]">LIVE PENDING</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-zinc-600 max-w-[180px] truncate">{{ $docCat }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-zinc-700">{{ $docProg }}</td>
                            <td class="px-6 py-4 text-xs text-zinc-700 font-medium">{{ $uploaderName }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-zinc-500">
                                {{ $docDate->format('M d, Y') }}<br>
                                <span class="text-[10px] text-zinc-400">{{ $docDate->format('h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border bg-amber-50 text-amber-700 border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                    Pending Review
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <button
                                    type="button"
                                    @click="openReview({
                                        id: '{{ $docId }}',
                                        title: '{{ addslashes($docTitle) }}',
                                        category: '{{ addslashes($docCat) }}',
                                        program: '{{ addslashes($docProg) }}',
                                        uploader: '{{ addslashes($uploaderName) }}',
                                        filePath: '{{ $isRealDoc && $doc->file_path ? route('documents.serve', $doc->id) : '' }}'
                                    })"
                                    class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-lg text-xs font-bold text-white bg-[#002B61] hover:bg-[#001d42] transition shadow-xs cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Review Submission
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center text-zinc-400 text-sm">
                                No pending document submissions in queue.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Review History Table --}}
        <div class="overflow-x-auto" x-show="activeTab === 'history'" style="display:none">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider border-b border-zinc-100">
                        <th class="px-6 py-3 w-8">#</th>
                        <th class="px-6 py-3">Document Title</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Program</th>
                        <th class="px-6 py-3">Submitted By</th>
                        <th class="px-6 py-3">Decision</th>
                        <th class="px-6 py-3">Review Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @forelse($reviewedDocs as $i => $doc)
                        @php
                            $isRealDoc = ($doc instanceof \App\Models\Document);
                            $docTitle  = $doc->title ?? '—';
                            $docCat    = is_object($doc->category ?? null) ? $doc->category->name : '—';
                            $docProg   = is_object($doc->program ?? null)  ? ($doc->program->code ?? $doc->program->name)  : '—';
                            $uploaderName = is_object($doc->uploader ?? null) ? ($doc->uploader->name ?? $doc->uploader->first_name ?? '—') : 'Program Chair';
                            $docStatus = $doc->status ?? 'approved';

                            if ($isRealDoc) {
                                $remarks = $doc->reviews->sortByDesc('reviewed_at')->first()?->remarks ?? 'Verified';
                            } else {
                                $remarks = $doc->latestRemark ?? 'Verified';
                            }

                            $statusConfig = match($docStatus) {
                                'approved' => ['label'=>'Approved', 'class'=>'bg-emerald-50 text-emerald-700 border-emerald-100'],
                                'returned' => ['label'=>'Returned', 'class'=>'bg-amber-50 text-amber-700 border-amber-100'],
                                'denied'   => ['label'=>'Denied',   'class'=>'bg-rose-50 text-rose-700 border-rose-100'],
                                default    => ['label'=>'Verified', 'class'=>'bg-blue-50 text-blue-700 border-blue-100'],
                            };
                        @endphp
                        <tr class="hover:bg-zinc-50/70 transition-colors">
                            <td class="px-6 py-4 text-xs text-zinc-300 font-semibold">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-semibold text-[#002B61] max-w-[240px] truncate">{{ $docTitle }}</td>
                            <td class="px-6 py-4 text-xs text-zinc-600 max-w-[180px] truncate">{{ $docCat }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-zinc-700">{{ $docProg }}</td>
                            <td class="px-6 py-4 text-xs text-zinc-700">{{ $uploaderName }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusConfig['class'] }}">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-zinc-600 italic max-w-[200px] truncate">"{{ $remarks }}"</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-zinc-400 text-sm">
                                No review history available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         REVIEW SUBMISSION MODAL (INSIDE X-DATA)
         ════════════════════════════════════════════════════════════════ --}}
    <div
        x-show="reviewModalDoc !== null"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="closeReview()"></div>

        <div
            x-show="reviewModalDoc !== null"
            class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden z-10">

            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-zinc-100 bg-zinc-50">
                <div>
                    <h2 class="text-lg font-bold text-[#002B61]">Evaluate Submission</h2>
                    <p class="text-xs text-zinc-400 mt-0.5">Verify document details and submit your review decision</p>
                </div>
                <button type="button" @click="closeReview()" class="text-zinc-400 hover:text-zinc-700 p-1.5 rounded-lg hover:bg-zinc-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <template x-if="reviewModalDoc !== null">
                <form
                    :action="'/submissions/' + reviewModalDoc.id + '/review'"
                    method="POST"
                    class="px-6 py-5 flex flex-col gap-4">
                    @csrf

                    {{-- Document details preview card --}}
                    <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-4 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600" x-text="reviewModalDoc.category"></span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800" x-text="reviewModalDoc.program"></span>
                        </div>
                        <h3 class="text-sm font-bold text-[#002B61]" x-text="reviewModalDoc.title"></h3>
                        <p class="text-xs text-zinc-500">Submitted by: <strong class="text-zinc-700" x-text="reviewModalDoc.uploader"></strong></p>

                        <template x-if="reviewModalDoc.filePath">
                            <a :href="reviewModalDoc.filePath" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#F47920] hover:underline mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25" />
                                </svg>
                                View & Open Submitted File &rarr;
                            </a>
                        </template>
                    </div>

                    {{-- Decision Selector --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-zinc-700">Review Decision <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-3 gap-2">
                            <label
                                :class="reviewDecision === 'approved' ? 'border-emerald-500 bg-emerald-50 text-emerald-800 font-bold' : 'border-zinc-200 bg-white text-zinc-600'"
                                class="border rounded-xl p-3 text-xs flex flex-col items-center gap-1 cursor-pointer transition text-center">
                                <input type="radio" name="decision" value="approved" x-model="reviewDecision" class="hidden" />
                                <span class="text-base">✅</span>
                                Approve
                            </label>
                            <label
                                :class="reviewDecision === 'returned' ? 'border-amber-500 bg-amber-50 text-amber-800 font-bold' : 'border-zinc-200 bg-white text-zinc-600'"
                                class="border rounded-xl p-3 text-xs flex flex-col items-center gap-1 cursor-pointer transition text-center">
                                <input type="radio" name="decision" value="returned" x-model="reviewDecision" class="hidden" />
                                <span class="text-base">↩️</span>
                                Return
                            </label>
                            <label
                                :class="reviewDecision === 'denied' ? 'border-rose-500 bg-rose-50 text-rose-800 font-bold' : 'border-zinc-200 bg-white text-zinc-600'"
                                class="border rounded-xl p-3 text-xs flex flex-col items-center gap-1 cursor-pointer transition text-center">
                                <input type="radio" name="decision" value="denied" x-model="reviewDecision" class="hidden" />
                                <span class="text-base">❌</span>
                                Deny
                            </label>
                        </div>
                    </div>

                    {{-- Remarks --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="review-remarks" class="text-xs font-bold text-zinc-700">Review Remarks / Feedback</label>
                        <textarea
                            id="review-remarks"
                            name="remarks"
                            x-model="reviewRemarks"
                            rows="3"
                            placeholder="Add review observations, feedback, or justification for return/denial..."
                            class="w-full border border-zinc-200 rounded-xl px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-300 focus:outline-none focus:ring-2 focus:ring-[#002B61]/20 focus:border-[#002B61] transition resize-none"></textarea>
                    </div>

                    {{-- Modal Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-zinc-100">
                        <button
                            type="button"
                            @click="closeReview()"
                            class="px-4 py-2 rounded-xl text-xs font-semibold text-zinc-600 bg-zinc-100 hover:bg-zinc-200 transition">
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#002B61] hover:bg-[#001d42] transition shadow-xs">
                            Confirm Review Decision
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         SUBMIT DOCUMENT MODAL (INSIDE X-DATA)
         ════════════════════════════════════════════════════════════════ --}}
    <div
        x-show="showUploadModal"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showUploadModal = false; clearFile()"></div>

        <div
            x-show="showUploadModal"
            class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg max-h-[92vh] overflow-y-auto z-10">

            <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-zinc-100">
                <div>
                    <h2 class="text-lg font-bold text-[#002B61]">Submit Document</h2>
                    <p class="text-xs text-zinc-400 mt-0.5">Upload a document for quality assurance repository</p>
                </div>
                <button type="button" @click="showUploadModal = false; clearFile()" class="text-zinc-400 hover:text-zinc-700 p-1.5 rounded-lg hover:bg-zinc-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form
                action="{{ route('submissions.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="px-6 py-5 flex flex-col gap-4"
                @submit="submitting = true">
                @csrf

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">Document Title <span class="text-rose-500">*</span></label>
                    <input
                        name="title"
                        type="text"
                        required
                        placeholder="e.g. Institutional QA Guidelines 2025"
                        class="w-full border border-zinc-200 rounded-xl px-4 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 focus:ring-[#002B61]/20 focus:border-[#002B61] transition" />
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">Program</label>
                    <select
                        name="program_id"
                        class="w-full border border-zinc-200 rounded-xl px-4 py-2 text-sm text-zinc-700 bg-white">
                        <option value="">Institution-wide (General)</option>
                        @foreach($programs as $prog)
                            <option value="{{ $prog->id }}">{{ $prog->name }} ({{ $prog->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">Category / Area <span class="text-rose-500">*</span></label>
                    <select
                        name="category_id"
                        required
                        class="w-full border border-zinc-200 rounded-xl px-4 py-2 text-sm text-zinc-700 bg-white">
                        <option value="" disabled selected>Select category...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-zinc-700">File Upload <span class="text-rose-500">*</span></label>
                    <input
                        id="iqa-doc-file-input"
                        name="file"
                        type="file"
                        required
                        accept=".pdf,.docx,.xlsx,.doc,.xls"
                        class="w-full border border-zinc-200 rounded-xl px-3 py-2 text-xs text-zinc-600 bg-zinc-50" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-zinc-100 mt-2">
                    <button
                        type="button"
                        @click="showUploadModal = false; clearFile()"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-zinc-600 bg-zinc-100 hover:bg-zinc-200 transition">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#F47920] hover:bg-[#d96910] transition">
                        Submit Document
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

</x-layouts::app>