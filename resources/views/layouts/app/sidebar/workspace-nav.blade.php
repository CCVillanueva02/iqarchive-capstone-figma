{{--
    IQArchive Sidebar: Workspace Navigation
    Primary everyday workspace navigation: Dashboard, Documents, and Accreditation Monitoring.
--}}

<div class="px-6 pb-1 pt-1">
    <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Workspace</span>
</div>

{{-- 1. Dashboard --}}
@if (in_array($role, ['iqa-staff', 'system-administrator', 'task-force-member', 'college-head', 'university-administrator', 'accreditor']))
<a href="{{ route('dashboard.' . $role) }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <rect x="3" y="3" width="7" height="9"></rect>
        <rect x="14" y="3" width="7" height="5"></rect>
        <rect x="14" y="12" width="7" height="9"></rect>
        <rect x="3" y="16" width="7" height="5"></rect>
    </svg>
    <span>Dashboard</span>
</a>
@endif

{{-- 2. Documents (Collapsible with Clean Hairline Subtabs) --}}
@if (in_array($role, ['task-force-member', 'college-head', 'iqa-staff', 'system-administrator']))
@php
    $canSeeCommonDocs = in_array($role, ['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);
    $canSeeInstitutionalDocs = in_array($role, ['iqa-staff', 'system-administrator']);
    $defaultTabForRole = 'common-documents';
    $currentDocTab = $currentDocTab ?? request()->query('tab', $defaultTabForRole);
    $isDocsRoute = request()->routeIs('documents.' . $role);
@endphp

<div class="flex flex-col" x-data="{ docsOpen: {{ $isDocsRoute ? 'true' : 'false' }} }">
    <button type="button"
        @click="docsOpen = !docsOpen"
        class="group flex items-center justify-between px-6 py-3 border-l-4 text-body-sm font-semibold transition-all cursor-pointer {{ $isDocsRoute ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}">
        <div class="flex items-center gap-3.5">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Documents</span>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-200"
            :class="docsOpen ? 'rotate-180 text-white' : 'text-white/40 group-hover:text-white/70'">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>

    <!-- Documents Clean Subtabs -->
    <div x-show="docsOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="flex flex-col py-1.5 bg-black/10">
        <div class="border-l border-white/15 ml-9 my-0.5 pl-2.5 flex flex-col gap-0.5">
            @if ($canSeeCommonDocs)
            @php $isCommon = ($currentDocTab === 'common-documents' && $isDocsRoute); @endphp
            <a href="{{ route('documents.' . $role, ['tab' => 'common-documents']) }}"
                class="group flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-all {{ $isCommon ? 'bg-white/12 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ $isCommon ? 'bg-brand-orange ring-2 ring-brand-orange/30' : 'bg-white/20 group-hover:bg-white/50' }}"></span>
                <span>Common Documents</span>
            </a>
            @endif

            @php $isProg = ($currentDocTab === 'program-accreditation' && $isDocsRoute); @endphp
            <a href="{{ route('documents.' . $role, ['tab' => 'program-accreditation']) }}"
                class="group flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-all {{ $isProg ? 'bg-white/12 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ $isProg ? 'bg-brand-orange ring-2 ring-brand-orange/30' : 'bg-white/20 group-hover:bg-white/50' }}"></span>
                <span>Program Accreditation</span>
            </a>

            @if ($canSeeInstitutionalDocs)
            @php $isInst = ($currentDocTab === 'institutional-accreditation' && $isDocsRoute); @endphp
            <a href="{{ route('documents.' . $role, ['tab' => 'institutional-accreditation']) }}"
                class="group flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-all {{ $isInst ? 'bg-white/12 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ $isInst ? 'bg-brand-orange ring-2 ring-brand-orange/30' : 'bg-white/20 group-hover:bg-white/50' }}"></span>
                <span>Institutional Accreditation</span>
            </a>
            @endif
        </div>
    </div>
</div>
@endif

{{-- 3. Monitoring (Collapsible with Clean Hairline Subtabs) --}}
@if (in_array($role, ['task-force-member', 'college-head', 'iqa-staff']))
@php
    $currentMonTab = request()->query('tab', 'dashboard');
    $isMonRoute = request()->routeIs('monitoring.*');
@endphp

<div class="flex flex-col" x-data="{ monOpen: {{ $isMonRoute ? 'true' : 'false' }} }">
    <button type="button"
        @click="monOpen = !monOpen"
        class="group flex items-center justify-between px-6 py-3 border-l-4 text-body-sm font-semibold transition-all cursor-pointer {{ $isMonRoute ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}">
        <div class="flex items-center gap-3.5">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>Monitoring</span>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-200"
            :class="monOpen ? 'rotate-180 text-white' : 'text-white/40 group-hover:text-white/70'">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>

    <!-- Monitoring Clean Subtabs -->
    <div x-show="monOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="flex flex-col py-1.5 bg-black/10">
        <div class="border-l border-white/15 ml-9 my-0.5 pl-2.5 flex flex-col gap-0.5">
            @php $isMonDash = ($currentMonTab === 'dashboard' && $isMonRoute); @endphp
            <a href="{{ route('monitoring.index', ['tab' => 'dashboard']) }}"
                class="group flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-all {{ $isMonDash ? 'bg-white/12 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ $isMonDash ? 'bg-brand-orange ring-2 ring-brand-orange/30' : 'bg-white/20 group-hover:bg-white/50' }}"></span>
                <span>Overview</span>
            </a>

            @php $isMonSumm = ($currentMonTab === 'summary' && $isMonRoute); @endphp
            <a href="{{ route('monitoring.index', ['tab' => 'summary']) }}"
                class="group flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-all {{ $isMonSumm ? 'bg-white/12 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ $isMonSumm ? 'bg-brand-orange ring-2 ring-brand-orange/30' : 'bg-white/20 group-hover:bg-white/50' }}"></span>
                <span>Summary Report</span>
            </a>

            @php $isMonProg = ($currentMonTab === 'programs' && $isMonRoute); @endphp
            <a href="{{ route('monitoring.index', ['tab' => 'programs']) }}"
                class="group flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-all {{ $isMonProg ? 'bg-white/12 text-white font-bold' : 'text-white/60 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors {{ $isMonProg ? 'bg-brand-orange ring-2 ring-brand-orange/30' : 'bg-white/20 group-hover:bg-white/50' }}"></span>
                <span>Programs Progress</span>
            </a>
        </div>
    </div>
</div>
@endif
