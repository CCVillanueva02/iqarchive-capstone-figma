{{--
    IQArchive Document Workspace Header & Breadcrumbs
    Purpose: Displays the domain title, contextual subtitle, and hierarchical wayfinding breadcrumb bar.
    Design: Adheres strictly to the single-line header and card-based navigation architecture from reference designs.
--}}

@php
    // Determine dynamic title & subtitle based on active tab and drill-down state
    if ($activeTab === 'common-documents') {
        if ($selectedOffice && $selectedCategoryName) {
            $pageTitle = $selectedCategoryName;
            $pageSubtitle = 'Common documents under ' . $selectedOffice->name;
        } elseif ($selectedOffice) {
            $pageTitle = $selectedOffice->name;
            $pageSubtitle = ($selectedOffice->categories_count ?? count($categories)) . ' categories • manage documents for this office';
        } else {
            $pageTitle = 'Common Institutional Documents';
            $pageSubtitle = 'Centralized university-wide records, policies, and administrative issuances';
        }
    } elseif ($activeTab === 'program-accreditation') {
        if ($selectedProgram) {
            $pageTitle = $selectedProgram->name . ' (' . $selectedProgram->code . ')';
            $pageSubtitle = ($selectedCollege?->name ?? 'Assigned College') . ' • Degree program accreditation workspace and evidence repository';
        } elseif ($selectedCollege) {
            $pageTitle = $selectedCollege->name . ' (' . $selectedCollege->code . ')';
            $pageSubtitle = 'Select an academic degree program below to view compliance records and evidence';
        } else {
            $pageTitle = 'Program Accreditation Documents';
            $pageSubtitle = 'Manage degree program accreditation files, faculty portfolios, and compliance reports';
        }
    } else {
        if ($institutionalCategory) {
            $pageTitle = $institutionalCategory;
            $pageSubtitle = 'Institutional accreditation self-evaluation, diagnostic records, and compliance metrics';
        } else {
            $pageTitle = 'Institutional Accreditation Documents';
            $pageSubtitle = 'Manage university-wide accreditation, governance, and self-survey compliance files';
        }
    }
@endphp

<div class="px-6 pt-6 pb-2 max-w-7xl w-full mx-auto flex flex-col gap-4">
    <!-- Top Header Row: Section Title & Notification Indicator -->
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-primary tracking-tight leading-tight">{{ $pageTitle }}</h1>
            <p class="text-sm text-zinc-500 mt-1">{{ $pageSubtitle }}</p>
        </div>

        <!-- Right Side Utility Indicator / Notification -->
        <div class="flex items-center gap-3 shrink-0 pt-1">
            @if($isCollegeLocked && $userRole === 'college-head')
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-subtle border border-primary/15 text-xs font-semibold text-primary shadow-3xs">
                    <svg class="w-3.5 h-3.5 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>Scoped to {{ $selectedCollege?->code ?? 'Assigned College' }}</span>
                </span>
            @elseif($isProgramLocked && $userRole === 'task-force-member')
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 shadow-3xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Scoped to {{ $selectedProgram?->code ?? 'Assigned Program' }}</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Breadcrumb Navigation Bar matching original design -->
    <div class="bg-white border border-slate-200/60 rounded-xl px-4 py-3 shadow-3xs flex items-center gap-2 text-xs font-medium text-zinc-500 overflow-x-auto">
        <span>Documents</span>
        <span class="text-zinc-300">&gt;</span>

        @if($activeTab === 'common-documents')
            @if($selectedOffice)
                <button type="button" wire:click="clearOffice" class="hover:text-primary transition font-medium cursor-pointer">Common Documents</button>
                <span class="text-zinc-300">&gt;</span>
                @if($selectedCategoryName)
                    <button type="button" wire:click="clearCategory" class="hover:text-primary transition font-medium cursor-pointer">{{ $selectedOffice->name }}</button>
                    <span class="text-zinc-300">&gt;</span>
                    <span class="font-bold text-primary">{{ $selectedCategoryName }}</span>
                @else
                    <span class="font-bold text-primary">{{ $selectedOffice->name }}</span>
                @endif
            @else
                <span class="font-bold text-primary">Common Documents</span>
            @endif

        @elseif($activeTab === 'program-accreditation')
            @if($selectedCollege)
                @if(!$isCollegeLocked)
                    <button type="button" wire:click="clearCollege" class="hover:text-primary transition font-medium cursor-pointer">Program Accreditation</button>
                    <span class="text-zinc-300">&gt;</span>
                @else
                    <span>Program Accreditation</span>
                    <span class="text-zinc-300">&gt;</span>
                @endif

                @if($selectedProgram)
                    @if(!$isProgramLocked)
                        <button type="button" wire:click="clearProgram" class="hover:text-primary transition font-medium cursor-pointer">{{ $selectedCollege->name }}</button>
                        <span class="text-zinc-300">&gt;</span>
                    @else
                        <span>{{ $selectedCollege->name }}</span>
                        <span class="text-zinc-300">&gt;</span>
                    @endif
                    <span class="font-bold text-primary">{{ $selectedProgram->name }} ({{ $selectedProgram->code }})</span>
                @else
                    <span class="font-bold text-primary">{{ $selectedCollege->name }}</span>
                @endif
            @else
                <span class="font-bold text-primary">Program Accreditation</span>
            @endif

        @else
            @if($institutionalCategory)
                <button type="button" wire:click="clearInstitutionalCategory" class="hover:text-primary transition font-medium cursor-pointer">Institutional Accreditation</button>
                <span class="text-zinc-300">&gt;</span>
                <span class="font-bold text-primary">{{ $institutionalCategory }}</span>
            @else
                <span class="font-bold text-primary">Institutional Accreditation</span>
            @endif
        @endif
    </div>
</div>
