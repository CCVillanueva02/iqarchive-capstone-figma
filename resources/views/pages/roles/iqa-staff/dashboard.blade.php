@php
    $pendingReview = \App\Models\Document::where('status', 'pending')->count();
    $totalRequirements = \App\Models\ComplianceRequirement::count();
    $compliedRequirements = \App\Models\ComplianceRequirement::where('status', 'complied')->count();
    $waitingCompliance = \App\Models\ComplianceRequirement::whereIn('status', ['pending', 'in_progress'])->count();
    $activeUsers = \App\Models\User::where('status', 'active')->count();
    
    // Recent uploads
    $recentUploads = \App\Models\Document::with(['uploader', 'program', 'category'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // Pending Common Documents
    $pendingCommonDocsCount = \App\Models\Document::whereNull('program_id')->where('status', 'Pending')->count();
    $recentPendingCommonDocs = \App\Models\Document::with(['uploader', 'category'])
        ->whereNull('program_id')
        ->where('status', 'Pending')
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();
        
    $complianceRate = $totalRequirements > 0 ? round(($compliedRequirements / $totalRequirements) * 100) : 0;
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen font-sans">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-heading-lg font-bold text-primary-dark">IQA Staff Dashboard</h1>
                <p class="text-body-sm text-zinc-500 mt-1">Institutional Quality Assurance Portal Overview</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-body-sm text-zinc-400 font-medium">System Time: {{ now()->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        <!-- Pending Common Documents Quick Access Alert Widget -->
        <div class="bg-gradient-to-r from-primary-dark to-primary-hover text-white rounded-2xl p-6 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-5 border border-primary-dark/40">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-amber-500/20 border border-amber-400/30 rounded-xl text-amber-300 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-heading-sm font-bold text-white">Pending Common Documents Verification</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-body-sm font-black bg-amber-400 text-amber-950 shadow-2xs">
                            {{ $pendingCommonDocsCount }} Pending
                        </span>
                    </div>
                    <p class="text-body-sm text-white/90 mt-1 max-w-2xl leading-relaxed">
                        There {{ $pendingCommonDocsCount === 1 ? 'is' : 'are' }} {{ $pendingCommonDocsCount }} common document(s) uploaded by staff awaiting verification. Review uploaded files, manage approval status, or flag documents.
                    </p>
                </div>
            </div>
            <a href="{{ route('documents.iqa-staff', ['status' => 'Pending']) }}" class="px-5 py-3 bg-brand-orange hover:bg-brand-orange-hover text-white font-bold text-body-sm rounded-xl shadow-md transition shrink-0 flex items-center gap-2 select-none cursor-pointer" wire:navigate>
                <span>Review Pending Documents</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        <!-- Four Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Accreditation Pending -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-body-sm font-semibold text-zinc-400 uppercase tracking-wider">Pending</span>
                    <span class="text-heading-lg font-extrabold text-primary-dark mt-2">{{ $pendingReview }}</span>
                    <span class="text-label text-amber-600 font-medium mt-1.5 flex items-center gap-1">
                        <span class="inline-block h-2 w-2 rounded-full bg-amber-500 animate-ping"></span> 
                        Awaiting for compliance
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>

            <!-- Waiting for Compliance -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-body-sm font-semibold text-zinc-400 uppercase tracking-wider">Upcoming Compliance</span>
                    <span class="text-heading-lg font-extrabold text-primary-dark mt-2">{{ $waitingCompliance }}</span>
                    <span class="text-label text-zinc-500 mt-1.5 font-medium">
                        Accreditation is about to expire
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-brand-orange/10 text-brand-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>

            <!-- Compliance Okay -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-body-sm font-semibold text-zinc-400 uppercase tracking-wider">Complied</span>
                    <span class="text-heading-lg font-extrabold text-primary-dark mt-2">{{ $compliedRequirements }}</span>
                    <span class="text-label text-emerald-600 font-medium mt-1.5">
                        Accreditation met
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12Z" />
                    </svg>
                </div>
            </div>

            <!-- Overall Compliance Rate -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-body-sm font-semibold text-zinc-400 uppercase tracking-wider">Overall Compliance</span>
                    <span class="text-heading-lg font-extrabold text-primary-dark mt-2">{{ $complianceRate }}%</span>
                    <span class="text-label text-zinc-500 mt-1.5 font-medium">
                        Total university compliance rate
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-surface-subtle text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
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
                        <h2 class="text-heading-sm font-bold text-primary-dark">Recent Document Submissions</h2>
                        <p class="text-body-sm text-zinc-400 mt-0.5">Newly archived program compliance documents</p>
                    </div>
                    <a href="{{ route('documents.iqa-staff') }}" class="text-body-sm font-semibold text-brand-orange hover:underline" wire:navigate>
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
                                        <span class="block text-label-xs text-zinc-400 font-normal mt-0.5 truncate">{{ $doc->category?->name }}</span>
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
                                        <span class="px-2 py-0.5 rounded text-label-xs font-semibold border {{ $statusClass }}">
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

            <!-- Right Col: Program Overview and Actions -->
            <div class="flex flex-col gap-6">
                <!-- Actions Grid -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4">
                    <h3 class="text-body-sm font-bold text-primary-dark uppercase tracking-wider">Quick Actions</h3>
                    <div class="flex flex-col gap-3 font-semibold text-body-sm text-primary-dark">
                        <!-- First action: Monitoring (leads to submissions tab) -->
                        <a href="{{ route('submissions.iqa-staff') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition" wire:navigate>
                            <div class="p-2 bg-primary-dark text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Monitoring</span>
                                <span class="block text-label text-zinc-400 font-normal mt-0.5">Track and evaluate program compliance</span>
                            </div>
                        </a>
                        <a href="{{ route('accounts.iqa-staff') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition" wire:navigate>
                            <div class="p-2 bg-brand-orange text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.08l-.014-.002c-.072 0-.143-.001-.215-.002-.136-.002-.27-.006-.404-.012l-.014-.001a11.384 11.384 0 0 1-4.46-1.334 4.123 4.123 0 0 1-1.422-2.58l-.004-.013c-.015-.062-.03-.124-.043-.187L3.48 16a9.09 9.09 0 0 1-.412-2.72c0-1.87.525-3.6 1.437-5.07a4.125 4.125 0 0 1 7.159 2.502M15 9.128a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM2.25 12h19.5" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">Manage User Accounts</span>
                                <span class="block text-label text-zinc-400 font-normal mt-0.5">Manage and check staff & deans</span>
                            </div>
                        </a>
                        <a href="{{ route('audit-trail.iqa-staff') }}" class="flex items-center gap-3 p-3.5 bg-zinc-50 hover:bg-zinc-100 border border-zinc-100 rounded-xl transition" wire:navigate>
                            <div class="p-2 bg-purple-600 text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="block">IQA Audit Trail logs</span>
                                <span class="block text-label text-zinc-400 font-normal mt-0.5">Track system activity logs</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Program performance statistics -->
                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs flex flex-col gap-4" x-data="{ tab: 'levels' }">
                    <div class="flex flex-col gap-2.5">
                        <div class="flex justify-between items-center">
                            <h3 class="text-body-sm font-bold text-primary-dark uppercase tracking-wider">Program Performance</h3>
                        </div>
                        
                        <!-- Tab Selector Buttons -->
                        <div class="flex bg-zinc-100 p-0.5 rounded-lg border border-zinc-200/60 self-start">
                            <button type="button" @click="tab = 'levels'" :class="tab === 'levels' ? 'bg-primary-dark text-white shadow-2xs' : 'text-zinc-600 hover:text-primary-dark'" class="px-2.5 py-1 rounded text-label-xs font-bold uppercase tracking-wider transition cursor-pointer select-none">
                                Levels
                            </button>
                            <button type="button" @click="tab = 'degrees'" :class="tab === 'degrees' ? 'bg-primary-dark text-white shadow-2xs' : 'text-zinc-600 hover:text-primary-dark'" class="px-2.5 py-1 rounded text-label-xs font-bold uppercase tracking-wider transition cursor-pointer select-none">
                                Degrees
                            </button>
                            <button type="button" @click="tab = 'accredited'" :class="tab === 'accredited' ? 'bg-primary-dark text-white shadow-2xs' : 'text-zinc-600 hover:text-primary-dark'" class="px-2.5 py-1 rounded text-label-xs font-bold uppercase tracking-wider transition cursor-pointer select-none">
                                Status
                            </button>
                        </div>
                    </div>

                    <!-- Tab 1: Accreditation Levels -->
                    <div x-show="tab === 'levels'" class="grid grid-cols-2 gap-3 transition-all duration-200">
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-brand-orange mb-0.5">11</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Level IV</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-brand-orange mb-0.5">32</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Level III</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-primary-dark mb-0.5">35</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Level II</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-primary-dark mb-0.5">38</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Level I</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-zinc-500 mb-0.5">4</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Candidate</span>
                        </div>
                        <div class="bg-primary-dark/5 border border-primary-dark/10 p-3.5 rounded-xl text-center flex flex-col justify-center select-none">
                            <span class="block text-heading-lg font-extrabold text-brand-orange mb-0.5">116</span>
                            <span class="text-label-xs text-primary-dark font-bold uppercase tracking-wider">Total Accredited</span>
                        </div>
                    </div>

                    <!-- Tab 2: Programs by Degree -->
                    <div x-show="tab === 'degrees'" class="grid grid-cols-2 gap-3 transition-all duration-200" style="display: none;">
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-brand-orange mb-0.5">80</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Baccalaureate</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-primary-dark mb-0.5">39</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Master's</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-primary-dark mb-0.5">7</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Doctoral</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-zinc-500 mb-0.5">2</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Post Bacc</span>
                        </div>
                        <div class="bg-primary-dark/5 border border-primary-dark/10 p-3.5 rounded-xl text-center flex flex-col justify-center col-span-2 select-none">
                            <span class="block text-heading-lg font-extrabold text-primary-dark mb-0.5">126</span>
                            <span class="text-label-xs text-primary-dark font-bold uppercase tracking-wider">Total Programs</span>
                        </div>
                    </div>

                    <!-- Tab 3: Accreditation Status -->
                    <div x-show="tab === 'accredited'" class="grid grid-cols-2 gap-3 transition-all duration-200" style="display: none;">
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-brand-orange mb-0.5">74</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Undergraduate</span>
                        </div>
                        <div class="bg-zinc-50 border border-zinc-100 p-3.5 rounded-xl text-center shadow-3xs select-none">
                            <span class="block text-heading-lg font-extrabold text-primary-dark mb-0.5">42</span>
                            <span class="text-label-xs text-zinc-400 font-semibold uppercase tracking-wider">Graduate</span>
                        </div>
                        <div class="bg-primary-dark/5 border border-primary-dark/10 p-3.5 rounded-xl text-center flex flex-col justify-center col-span-2 select-none">
                            <span class="block text-heading-lg font-extrabold text-brand-orange mb-0.5">116</span>
                            <span class="text-label-xs text-primary-dark font-bold uppercase tracking-wider">Total Accredited</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
