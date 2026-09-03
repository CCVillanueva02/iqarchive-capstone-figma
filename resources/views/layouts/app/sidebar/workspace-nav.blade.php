{{--
    IQArchive Sidebar: Workspace Navigation
    Primary everyday workspace navigation: Dashboard, Documents, and Accreditation Monitoring.
    Subtabs feature generous spacing, comfortable typography (text-body-sm), timeline connector, and clear icons.
--}}

<div class="px-6 pb-1 pt-1">
    <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Workspace</span>
</div>

{{-- 1. Dashboard --}}
@if (in_array($role, ['iqa-staff', 'system-administrator', 'task-force-member', 'college-head', 'university-administrator', 'accreditor']))
<a href="{{ route('dashboard.' . $role) }}"
    class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
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

{{-- 2. Documents (Collapsible with Spacious Subtabs) --}}
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
        class="group flex items-center justify-between px-6 py-3.5 border-l-4 text-body-sm font-semibold transition-all cursor-pointer {{ $isDocsRoute ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}">
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

    <!-- Documents Spacious Subtabs -->
    <div x-show="docsOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="flex flex-col py-2.5 bg-black/15">
        <div class="relative pl-10 pr-4 flex flex-col gap-1">
            <!-- Timeline connecting line -->
            <div class="absolute left-6 top-4 bottom-4 w-[1.5px] bg-white/20"></div>

            @if ($canSeeCommonDocs)
            @php $isCommon = ($currentDocTab === 'common-documents' && $isDocsRoute); @endphp
            <a href="{{ route('documents.' . $role, ['tab' => 'common-documents']) }}"
                class="relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-body-sm transition-all {{ $isCommon ? 'bg-white/12 text-white font-bold' : 'text-white/75 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-[1.5px] {{ $isCommon ? 'bg-brand-orange border-brand-orange shadow-xs' : 'bg-white/20 border-white/40' }}"></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isCommon ? 'text-brand-orange' : 'text-white/50' }}">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                <span class="leading-snug">Common Documents</span>
            </a>
            @endif

            @php $isProg = ($currentDocTab === 'program-accreditation' && $isDocsRoute); @endphp
            <a href="{{ route('documents.' . $role, ['tab' => 'program-accreditation']) }}"
                class="relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-body-sm transition-all {{ $isProg ? 'bg-white/12 text-white font-bold' : 'text-white/75 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-[1.5px] {{ $isProg ? 'bg-brand-orange border-brand-orange shadow-xs' : 'bg-white/20 border-white/40' }}"></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isProg ? 'text-brand-orange' : 'text-white/50' }}">
                    <path d="M3 21h18"></path>
                    <path d="M5 21V7l7-4 7 4v14"></path>
                    <path d="M9 21v-4h6v4"></path>
                    <path d="M10 10h4"></path>
                </svg>
                <span class="leading-snug">Program Accreditation</span>
            </a>

            @if ($canSeeInstitutionalDocs)
            @php $isInst = ($currentDocTab === 'institutional-accreditation' && $isDocsRoute); @endphp
            <a href="{{ route('documents.' . $role, ['tab' => 'institutional-accreditation']) }}"
                class="relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-body-sm transition-all {{ $isInst ? 'bg-white/12 text-white font-bold' : 'text-white/75 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-[1.5px] {{ $isInst ? 'bg-brand-orange border-brand-orange shadow-xs' : 'bg-white/20 border-white/40' }}"></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isInst ? 'text-brand-orange' : 'text-white/50' }}">
                    <rect x="4" y="10" width="16" height="11" rx="1"></rect>
                    <path d="M8 10V6a4 4 0 0 1 8 0v4"></path>
                    <path d="M8 14h2"></path>
                    <path d="M14 14h2"></path>
                    <path d="M8 18h2"></path>
                    <path d="M14 18h2"></path>
                </svg>
                <span class="leading-snug">Institutional Accreditation</span>
            </a>
            @endif
        </div>
    </div>
</div>
@endif

{{-- 3. Monitoring (Collapsible with Spacious Subtabs) --}}
@if (in_array($role, ['task-force-member', 'college-head', 'iqa-staff']))
@php
    $currentMonTab = request()->query('tab', 'dashboard');
    $isMonRoute = request()->routeIs('monitoring.*');
@endphp

<div class="flex flex-col" x-data="{ monOpen: {{ $isMonRoute ? 'true' : 'false' }} }">
    <button type="button"
        @click="monOpen = !monOpen"
        class="group flex items-center justify-between px-6 py-3.5 border-l-4 text-body-sm font-semibold transition-all cursor-pointer {{ $isMonRoute ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}">
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

    <!-- Monitoring Spacious Subtabs -->
    <div x-show="monOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="flex flex-col py-2.5 bg-black/15">
        <div class="relative pl-10 pr-4 flex flex-col gap-1">
            <div class="absolute left-6 top-4 bottom-4 w-[1.5px] bg-white/20"></div>

            @php $isMonDash = ($currentMonTab === 'dashboard' && $isMonRoute); @endphp
            <a href="{{ route('monitoring.index', ['tab' => 'dashboard']) }}"
                class="relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-body-sm transition-all {{ $isMonDash ? 'bg-white/12 text-white font-bold' : 'text-white/75 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-[1.5px] {{ $isMonDash ? 'bg-brand-orange border-brand-orange shadow-xs' : 'bg-white/20 border-white/40' }}"></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isMonDash ? 'text-brand-orange' : 'text-white/50' }}">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                <span class="leading-snug">Dashboard</span>
            </a>

            @php $isMonSumm = ($currentMonTab === 'summary' && $isMonRoute); @endphp
            <a href="{{ route('monitoring.index', ['tab' => 'summary']) }}"
                class="relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-body-sm transition-all {{ $isMonSumm ? 'bg-white/12 text-white font-bold' : 'text-white/75 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-[1.5px] {{ $isMonSumm ? 'bg-brand-orange border-brand-orange shadow-xs' : 'bg-white/20 border-white/40' }}"></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isMonSumm ? 'text-brand-orange' : 'text-white/50' }}">
                    <path d="M3 3v18h18"></path>
                    <path d="m19 9-5 5-4-4-3 3"></path>
                </svg>
                <span class="leading-snug">Summary Report</span>
            </a>

            @php $isMonProg = ($currentMonTab === 'programs' && $isMonRoute); @endphp
            <a href="{{ route('monitoring.index', ['tab' => 'programs']) }}"
                class="relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-body-sm transition-all {{ $isMonProg ? 'bg-white/12 text-white font-bold' : 'text-white/75 hover:text-white hover:bg-white/5 font-medium' }}"
                wire:navigate>
                <span class="absolute -left-4 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-[1.5px] {{ $isMonProg ? 'bg-brand-orange border-brand-orange shadow-xs' : 'bg-white/20 border-white/40' }}"></span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isMonProg ? 'text-brand-orange' : 'text-white/50' }}">
                    <path d="M8 6h13"></path>
                    <path d="M8 12h13"></path>
                    <path d="M8 18h13"></path>
                    <path d="M3 6h.01"></path>
                    <path d="M3 12h.01"></path>
                    <path d="M3 18h.01"></path>
                </svg>
                <span class="leading-snug">Programs</span>
            </a>
        </div>
    </div>
</div>
@endif
