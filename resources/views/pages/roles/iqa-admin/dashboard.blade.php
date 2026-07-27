@php
    $pendingReview = \App\Models\Document::where('status', 'pending')->count();
    $totalRequirements = \App\Models\ComplianceRequirement::count();
    $compliedRequirements = \App\Models\ComplianceRequirement::where('status', 'complied')->count();
    $overdueRequirements = \App\Models\ComplianceRequirement::where('status', 'overdue')->count();
    $activeUsers = \App\Models\User::where('status', 'active')->count();
    
    // OCR status
    $ocrPending = \App\Models\DocumentOCRValidation::where('validation_status', 'pending')->count();
    $ocrValidated = \App\Models\DocumentOCRValidation::where('validation_status', 'validated')->count();
    $ocrFailed = \App\Models\DocumentOCRValidation::where('validation_status', 'failed')->count();
    
    // Access requests
    $pendingAccess = \App\Models\DocumentAccessRequest::where('status', 'pending')->count();
    
    // Recent uploads
    $recentUploads = \App\Models\Document::with(['uploader', 'program', 'category'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        
    $complianceRate = $totalRequirements > 0 ? round(($compliedRequirements / $totalRequirements) * 100) : 0;
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-[#f4f6fa] min-h-screen">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#002B61]">IQA Administrator Dashboard</h1>
                <p class="text-xs text-zinc-500 mt-1">Institutional Quality Assurance Portal Overview</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-zinc-400 font-medium">System Time: {{ now()->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <!-- Four Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pending Reviews -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Awaiting Review</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $pendingReview }}</span>
                    <span class="text-[11px] text-amber-600 font-medium mt-1.5 flex items-center gap-1">
                        <span class="inline-block h-2 w-2 rounded-full bg-amber-500 animate-ping"></span> 
                        Requires action
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>

            <!-- Compliance Rate -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Overall Compliance</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $complianceRate }}%</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">
                        {{ $compliedRequirements }} / {{ $totalRequirements }} Complied
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-[#002B61]/5 text-[#002B61]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.75 3.75 0 0 1 21 12Z" />
                    </svg>
                </div>
            </div>

            <!-- Document Access Requests -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Access Requests</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $pendingAccess }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Pending approval</span>
                </div>
                <div class="p-3.5 rounded-xl bg-orange-50 text-[#F47920]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>
                </div>
            </div>

            <!-- Active User Accounts -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Active Accounts</span>
                    <span class="text-3xl font-extrabold text-[#002B61] mt-2">{{ $activeUsers }}</span>
                    <span class="text-[11px] text-zinc-500 mt-1.5">Registered staff & chairs</span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Recent Document Submissions -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#002B61]">Recent Document Submissions</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Newly archived program compliance documents</p>
                    </div>
                    <a href="{{ route('documents.iqa-admin') }}" class="text-xs font-semibold text-[#F47920] hover:underline" wire:navigate>
                        Manage All Files &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead>
                            <tr class="text-xs font-semibold text-zinc-400 border-b border-zinc-100 pb-2">
                                <th class="pb-3">Title</th>
                                <th class="pb-3">Program</th>
                                <th class="pb-3">Uploader</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse($recentUploads as $doc)
                                <tr>
                                    <td class="py-3 max-w-[200px] truncate font-semibold text-zinc-800">
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
                                    <td class="py-3 text-xs text-zinc-400">
                                        {{ $doc->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-zinc-400 text-sm">
                                        No recent document uploads found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Col: OCR Status and Actions -->
            <div class="flex flex-col gap-6">
                <!-- Actions Grid -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-sm font-bold text-[#002B61] uppercase tracking-wider">Quick Actions</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('documents.iqa-admin') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-[#002B61] text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c2.917 0 5.747.294 8.5.862m-21 1.402L3 9.75m0 0 3 3m-3-3 3-3M3 16.5a2.25 2.25 0 0 0 2.25 2.25H13.5m-3-16.5h.008v.008H10.5V3Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Review Pending Submissions</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Approve/reject uploads</span>
                            </div>
                        </a>
                        <a href="{{ route('accounts.iqa-admin') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-orange-500 text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002c-.072 0-.143-.001-.215-.002-.136-.002-.27-.006-.404-.012l-.014-.001a11.384 11.384 0 0 1-4.46-1.334 4.123 4.123 0 0 1-1.422-2.58l-.004-.013c-.015-.062-.03-.124-.043-.187L3.48 16a9.09 9.09 0 0 1-.412-2.72c0-1.87.525-3.6 1.437-5.07a4.125 4.125 0 0 1 7.159 2.502M15 9.128a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM2.25 12h19.5" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Manage User Accounts</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Manage and check staff & deans</span>
                            </div>
                        </a>
                        <a href="{{ route('audit-trail.iqa-admin') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition font-semibold text-[#002B61] text-xs" wire:navigate>
                            <div class="p-2 bg-purple-600 text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">IQA Audit Trail logs</span>
                                <span class="block text-[10px] text-zinc-400 font-normal mt-0.5">Track system activity logs</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- OCR validation status widget -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-sm font-bold text-[#002B61] uppercase tracking-wider">OCR Processing Queue</h3>
                    
                    <div class="flex flex-col gap-3 mt-1">
                        <div>
                            <div class="flex justify-between text-xs font-semibold text-zinc-600 mb-1">
                                <span>Validated Texts</span>
                                <span>{{ $ocrValidated }} validated</span>
                            </div>
                            <div class="w-full bg-zinc-100 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ ($ocrValidated + $ocrPending + $ocrFailed) > 0 ? round(($ocrValidated / ($ocrValidated + $ocrPending + $ocrFailed)) * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold text-zinc-600 mb-1">
                                <span>Pending OCR Extraction</span>
                                <span>{{ $ocrPending }} queued</span>
                            </div>
                            <div class="w-full bg-zinc-100 rounded-full h-2">
                                <div class="bg-amber-500 h-2 rounded-full" style="width: {{ ($ocrValidated + $ocrPending + $ocrFailed) > 0 ? round(($ocrPending / ($ocrValidated + $ocrPending + $ocrFailed)) * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold text-zinc-600 mb-1">
                                <span>Failed Scans</span>
                                <span>{{ $ocrFailed }} failed</span>
                            </div>
                            <div class="w-full bg-zinc-100 rounded-full h-2">
                                <div class="bg-rose-500 h-2 rounded-full" style="width: {{ ($ocrValidated + $ocrPending + $ocrFailed) > 0 ? round(($ocrFailed / ($ocrValidated + $ocrPending + $ocrFailed)) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>