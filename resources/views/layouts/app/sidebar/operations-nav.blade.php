{{--
    IQArchive Sidebar: Operations Navigation
    Operational coordination, accreditation visits, task forces, and institutional reporting.
--}}

@php
    $hasOperationsItems = in_array($role, ['iqa-staff', 'system-administrator', 'university-administrator', 'college-head']);
@endphp

@if ($hasOperationsItems)
<div class="px-6 pb-1 pt-3">
    <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Operations</span>
</div>

{{-- 1. Accreditation Visits --}}
@if (in_array($role, ['iqa-staff']))
<a href="{{ route('visits.index') }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('visits.*') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
        <path d="m9 16 2 2 4-4"></path>
    </svg>
    <span>Accreditation Visits</span>
</a>
@endif

{{-- 2. Task Forces --}}
@if (in_array($role, ['iqa-staff', 'university-administrator', 'college-head', 'system-administrator']))
<a href="{{ route('task-forces.index') }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('task-forces.*') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    <span>Task Forces</span>
</a>
@endif

{{-- 3. Analytics --}}
@if (in_array($role, ['university-administrator', 'system-administrator', 'iqa-staff']))
<a href="{{ route('analytics.university-administrator') }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('analytics.university-administrator') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
        <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
    </svg>
    <span>Analytics</span>
</a>
@endif

{{-- 4. Reports --}}
@if (in_array($role, ['university-administrator', 'system-administrator', 'iqa-staff']))
<a href="{{ route('reports.university-administrator') }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('reports.university-administrator') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <line x1="16" y1="13" x2="8" y2="13"></line>
        <line x1="16" y1="17" x2="8" y2="17"></line>
        <polyline points="10 9 9 9 8 9"></polyline>
    </svg>
    <span>Reports</span>
</a>
@endif

{{-- 5. Dean Active Cycle Instruments --}}
@if ($role === 'college-head')
@php
    $deanUser = auth()->user();
    $activeDeanAccreditation = $deanUser && $deanUser->college_id
        ? \App\Models\Accreditation::whereHas('program', fn($q) => $q->where('college_id', $deanUser->college_id))
            ->whereIn('status', ['task_force_approved', 'instrument_building', 'document_preparation', 'uploading', 'dean_verification'])
            ->latest()
            ->first()
        : null;
    $deanNeedsInstrumentAction = $activeDeanAccreditation && in_array($activeDeanAccreditation->status, ['task_force_approved', 'instrument_building']);
@endphp
@if ($activeDeanAccreditation)
<a href="{{ route('accreditation.instrument', $activeDeanAccreditation->id) }}"
    class="group flex items-center justify-between px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('accreditation.instrument') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <div class="flex items-center gap-3.5">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <path d="m9 15 2 2 4-4"></path>
        </svg>
        <span>Instruments</span>
    </div>
    @if ($deanNeedsInstrumentAction)
    <span class="w-2 h-2 rounded-full bg-brand-orange animate-pulse shrink-0" title="Action Required"></span>
    @endif
</a>
@endif
@endif
@endif
