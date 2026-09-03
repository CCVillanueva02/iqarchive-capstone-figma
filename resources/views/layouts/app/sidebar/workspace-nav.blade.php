{{--
    IQArchive Sidebar: Workspace Navigation
    Primary everyday workspace navigation: Dashboard, Documents repository, and Accreditation Monitoring.
    Subtabs feature a vertical tree hierarchy connector track and circular node indicators (solid brand-orange
    for active state, hollow ring for inactive), with optimized left padding to guarantee zero horizontal overflow.
    Gated by authenticated user role with strict RBAC visibility (IQA Staff, College Head, Task Force Member, Admin).
--}}

<div class="px-6 pb-1 pt-1">
    <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Workspace</span>
</div>

{{-- 1. Dashboard --}}
@if (in_array($role, ['iqa-staff', 'system-administrator', 'task-force-member', 'college-head', 'university-administrator', 'accreditor']))
<a href="{{ route('dashboard.' . $role) }}"
    class="group flex items-center gap-3.5 px-6 py-3.5 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('dashboard.' . $role) ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    :class="currentPath === '{{ parse_url(route('dashboard.' . $role), PHP_URL_PATH) }}' ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent'"
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

{{-- 2. Documents (Collapsible with Full-Label Subtabs) --}}
@if (in_array($role, ['task-force-member', 'college-head', 'iqa-staff', 'system-administrator']))
@php
    $canSeeCommonDocs = in_array($role, ['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);
    $canSeeInstitutionalDocs = in_array($role, ['iqa-staff', 'system-administrator']);
    $defaultTabForRole = 'common-documents';
    $currentDocTab = $currentDocTab ?? request()->query('tab', $defaultTabForRole);
    $isDocsRoute = request()->routeIs('documents.' . $role);
@endphp

<div class="flex flex-col">
    <button type="button"
        @click="toggle('documents')"
        class="group flex items-center justify-between px-6 py-3.5 border-l-4 text-body-sm font-semibold transition-all cursor-pointer {{ $isDocsRoute ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
        :class="isRoute('{{ parse_url(route('documents.' . $role), PHP_URL_PATH) }}') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent'">
        <div class="flex items-center gap-3.5">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Documents</span>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-200"
            :class="isOpen('documents') ? 'rotate-180 text-white' : 'text-white/40 group-hover:text-white/70'">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>

    <!-- Documents Subtabs (Clean Hierarchy with Vertical Tree Connector) -->
    <div x-show="isOpen('documents')"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="relative flex flex-col py-1.5 px-2 bg-black/20 gap-0.5">

        {{-- Continuous Vertical Hierarchy Track (Centered behind node dots at 24.5px) --}}
        <div class="absolute left-[24.5px] top-3.5 bottom-3.5 w-px bg-white/20 pointer-events-none z-0"></div>

        @if ($canSeeCommonDocs)
        @php $isCommon = ($currentDocTab === 'common-documents' && $isDocsRoute); @endphp
        <a href="{{ route('documents.' . $role, ['tab' => 'common-documents']) }}"
            class="group relative z-10 flex items-center gap-2.5 pl-2.5 pr-2.5 py-2.5 rounded-xl text-body-sm transition-all whitespace-nowrap {{ $isCommon ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium' }}"
            :class="isDocTab('common-documents') ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium'"
            wire:navigate>
            {{-- Node Dot Indicator (Solid active brand-orange, hollow inactive ring) --}}
            <div class="shrink-0 w-3.5 h-3.5 flex items-center justify-center relative z-10">
                <span x-show="isDocTab('common-documents')" class="w-2.5 h-2.5 rounded-full bg-brand-orange shadow-[0_0_8px_rgba(244,121,32,0.6)]" @if(!$isCommon) style="display: none;" @endif></span>
                <span x-show="!isDocTab('common-documents')" class="w-2 h-2 rounded-full border-[1.5px] border-white/40 bg-primary-dark group-hover:border-white/80 group-hover:scale-110 transition-all" @if($isCommon) style="display: none;" @endif></span>
            </div>
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isCommon ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80' }}"
                :class="isDocTab('common-documents') ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80'">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
            </svg>
            <span class="whitespace-nowrap">Common Documents</span>
        </a>
        @endif

        @php $isProg = ($currentDocTab === 'program-accreditation' && $isDocsRoute); @endphp
        <a href="{{ route('documents.' . $role, ['tab' => 'program-accreditation']) }}"
            class="group relative z-10 flex items-center gap-2.5 pl-2.5 pr-2.5 py-2.5 rounded-xl text-body-sm transition-all whitespace-nowrap {{ $isProg ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium' }}"
            :class="isDocTab('program-accreditation') ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium'"
            wire:navigate>
            {{-- Node Dot Indicator (Solid active brand-orange, hollow inactive ring) --}}
            <div class="shrink-0 w-3.5 h-3.5 flex items-center justify-center relative z-10">
                <span x-show="isDocTab('program-accreditation')" class="w-2.5 h-2.5 rounded-full bg-brand-orange shadow-[0_0_8px_rgba(244,121,32,0.6)]" @if(!$isProg) style="display: none;" @endif></span>
                <span x-show="!isDocTab('program-accreditation')" class="w-2 h-2 rounded-full border-[1.5px] border-white/40 bg-primary-dark group-hover:border-white/80 group-hover:scale-110 transition-all" @if($isProg) style="display: none;" @endif></span>
            </div>
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isProg ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80' }}"
                :class="isDocTab('program-accreditation') ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80'">
                <path d="M3 21h18"></path>
                <path d="M5 21V7l7-4 7 4v14"></path>
                <path d="M9 21v-4h6v4"></path>
                <path d="M10 10h4"></path>
            </svg>
            <span class="whitespace-nowrap">Program Accreditation</span>
        </a>

        @if ($canSeeInstitutionalDocs)
        @php $isInst = ($currentDocTab === 'institutional-accreditation' && $isDocsRoute); @endphp
        <a href="{{ route('documents.' . $role, ['tab' => 'institutional-accreditation']) }}"
            class="group relative z-10 flex items-center gap-2.5 pl-2.5 pr-2.5 py-2.5 rounded-xl text-body-sm transition-all whitespace-nowrap {{ $isInst ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium' }}"
            :class="isDocTab('institutional-accreditation') ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium'"
            wire:navigate>
            {{-- Node Dot Indicator (Solid active brand-orange, hollow inactive ring) --}}
            <div class="shrink-0 w-3.5 h-3.5 flex items-center justify-center relative z-10">
                <span x-show="isDocTab('institutional-accreditation')" class="w-2.5 h-2.5 rounded-full bg-brand-orange shadow-[0_0_8px_rgba(244,121,32,0.6)]" @if(!$isInst) style="display: none;" @endif></span>
                <span x-show="!isDocTab('institutional-accreditation')" class="w-2 h-2 rounded-full border-[1.5px] border-white/40 bg-primary-dark group-hover:border-white/80 group-hover:scale-110 transition-all" @if($isInst) style="display: none;" @endif></span>
            </div>
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isInst ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80' }}"
                :class="isDocTab('institutional-accreditation') ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80'">
                <rect x="4" y="10" width="16" height="11" rx="1"></rect>
                <path d="M8 10V6a4 4 0 0 1 8 0v4"></path>
                <path d="M8 14h2"></path>
                <path d="M14 14h2"></path>
                <path d="M8 18h2"></path>
                <path d="M14 18h2"></path>
            </svg>
            <span class="whitespace-nowrap">Institutional Accreditation</span>
        </a>
        @endif
    </div>
</div>
@endif

{{-- 3. Monitoring (Collapsible with Full-Label Subtabs & Hierarchy Indicator) --}}
@if (in_array($role, ['task-force-member', 'college-head', 'iqa-staff']))
@php
    $currentMonTab = request()->query('tab', 'dashboard');
    $isMonRoute = request()->routeIs('monitoring.*');
@endphp

<div class="flex flex-col">
    <button type="button"
        @click="toggle('monitoring')"
        class="group flex items-center justify-between px-6 py-3.5 border-l-4 text-body-sm font-semibold transition-all cursor-pointer {{ $isMonRoute ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
        :class="isRoute('{{ parse_url(route('monitoring.index'), PHP_URL_PATH) }}') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent'">
        <div class="flex items-center gap-3.5">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>Monitoring</span>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-200"
            :class="isOpen('monitoring') ? 'rotate-180 text-white' : 'text-white/40 group-hover:text-white/70'">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>

    <!-- Monitoring Subtabs (Clean Hierarchy with Vertical Tree Connector) -->
    <div x-show="isOpen('monitoring')"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="relative flex flex-col py-1.5 px-2 bg-black/20 gap-0.5">

        {{-- Continuous Vertical Hierarchy Track (Centered behind node dots at 24.5px) --}}
        <div class="absolute left-[24.5px] top-3.5 bottom-3.5 w-px bg-white/20 pointer-events-none z-0"></div>

        @php $isMonDash = ($currentMonTab === 'dashboard' && $isMonRoute); @endphp
        <a href="{{ route('monitoring.index', ['tab' => 'dashboard']) }}"
            class="group relative z-10 flex items-center gap-2.5 pl-2.5 pr-2.5 py-2.5 rounded-xl text-body-sm transition-all whitespace-nowrap {{ $isMonDash ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium' }}"
            :class="isMonTab('dashboard') ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium'"
            wire:navigate>
            {{-- Node Dot Indicator (Solid active brand-orange, hollow inactive ring) --}}
            <div class="shrink-0 w-3.5 h-3.5 flex items-center justify-center relative z-10">
                <span x-show="isMonTab('dashboard')" class="w-2.5 h-2.5 rounded-full bg-brand-orange shadow-[0_0_8px_rgba(244,121,32,0.6)]" @if(!$isMonDash) style="display: none;" @endif></span>
                <span x-show="!isMonTab('dashboard')" class="w-2 h-2 rounded-full border-[1.5px] border-white/40 bg-primary-dark group-hover:border-white/80 group-hover:scale-110 transition-all" @if($isMonDash) style="display: none;" @endif></span>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isMonDash ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80' }}"
                :class="isMonTab('dashboard') ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80'">
                <rect x="3" y="3" width="7" height="9"></rect>
                <rect x="14" y="3" width="7" height="5"></rect>
                <rect x="14" y="12" width="7" height="9"></rect>
                <rect x="3" y="16" width="7" height="5"></rect>
            </svg>
            <span class="whitespace-nowrap">Dashboard</span>
        </a>

        @php $isMonSumm = ($currentMonTab === 'summary' && $isMonRoute); @endphp
        <a href="{{ route('monitoring.index', ['tab' => 'summary']) }}"
            class="group relative z-10 flex items-center gap-2.5 pl-2.5 pr-2.5 py-2.5 rounded-xl text-body-sm transition-all whitespace-nowrap {{ $isMonSumm ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium' }}"
            :class="isMonTab('summary') ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium'"
            wire:navigate>
            {{-- Node Dot Indicator (Solid active brand-orange, hollow inactive ring) --}}
            <div class="shrink-0 w-3.5 h-3.5 flex items-center justify-center relative z-10">
                <span x-show="isMonTab('summary')" class="w-2.5 h-2.5 rounded-full bg-brand-orange shadow-[0_0_8px_rgba(244,121,32,0.6)]" @if(!$isMonSumm) style="display: none;" @endif></span>
                <span x-show="!isMonTab('summary')" class="w-2 h-2 rounded-full border-[1.5px] border-white/40 bg-primary-dark group-hover:border-white/80 group-hover:scale-110 transition-all" @if($isMonSumm) style="display: none;" @endif></span>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isMonSumm ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80' }}"
                :class="isMonTab('summary') ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80'">
                <path d="M3 3v18h18"></path>
                <path d="m19 9-5 5-4-4-3 3"></path>
            </svg>
            <span class="whitespace-nowrap">Summary Report</span>
        </a>

        @php $isMonProg = ($currentMonTab === 'programs' && $isMonRoute); @endphp
        <a href="{{ route('monitoring.index', ['tab' => 'programs']) }}"
            class="group relative z-10 flex items-center gap-2.5 pl-2.5 pr-2.5 py-2.5 rounded-xl text-body-sm transition-all whitespace-nowrap {{ $isMonProg ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium' }}"
            :class="isMonTab('programs') ? 'bg-white/12 text-white font-bold shadow-3xs' : 'text-white/70 hover:text-white hover:bg-white/5 font-medium'"
            wire:navigate>
            {{-- Node Dot Indicator (Solid active brand-orange, hollow inactive ring) --}}
            <div class="shrink-0 w-3.5 h-3.5 flex items-center justify-center relative z-10">
                <span x-show="isMonTab('programs')" class="w-2.5 h-2.5 rounded-full bg-brand-orange shadow-[0_0_8px_rgba(244,121,32,0.6)]" @if(!$isMonProg) style="display: none;" @endif></span>
                <span x-show="!isMonTab('programs')" class="w-2 h-2 rounded-full border-[1.5px] border-white/40 bg-primary-dark group-hover:border-white/80 group-hover:scale-110 transition-all" @if($isMonProg) style="display: none;" @endif></span>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ $isMonProg ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80' }}"
                :class="isMonTab('programs') ? 'text-brand-orange' : 'text-white/50 group-hover:text-white/80'">
                <path d="M8 6h13"></path>
                <path d="M8 12h13"></path>
                <path d="M8 18h13"></path>
                <path d="M3 6h.01"></path>
                <path d="M3 12h.01"></path>
                <path d="M3 18h.01"></path>
            </svg>
            <span class="whitespace-nowrap">Programs Progress</span>
        </a>
    </div>
</div>
@endif
