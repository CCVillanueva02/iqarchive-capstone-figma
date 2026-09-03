{{--
    IQArchive Sidebar: Administration Navigation
    System configuration, institutional structure, user management, and security audit logs.
--}}

@php
    $hasAdminItems = in_array($role, ['iqa-staff', 'system-administrator', 'university-administrator']);
@endphp

@if ($hasAdminItems)
<div class="px-6 pb-1 pt-3">
    <span class="text-label-xs font-bold uppercase tracking-[1.5px] text-white/40">Administration</span>
</div>

{{-- 1. Colleges & Programs --}}
<a href="{{ route('configuration.colleges-programs') }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('configuration.colleges-programs') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
    </svg>
    <span>Colleges &amp; Programs</span>
</a>

{{-- 2. Master Instruments --}}
<a href="{{ route('configuration.instruments') }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('configuration.instruments*') ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <path d="m9 15 2 2 4-4"></path>
    </svg>
    <span>Master Instruments</span>
</a>

{{-- 3. User Accounts --}}
@if (in_array($role, ['iqa-staff', 'system-administrator']))
<a href="{{ route('accounts.' . $role) }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ request()->routeIs('accounts.' . $role) ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    <span>User Accounts</span>
</a>
@endif

{{-- 4. Audit Trail --}}
@if (in_array($role, ['system-administrator', 'iqa-staff']))
@php
    $auditTrailRoute = ($role === 'iqa-staff') ? route('audit-trail.iqa-staff') : route('reports.system-administrator');
    $isAuditTrailActive = request()->routeIs('audit-trail.*') || request()->routeIs('reports.system-administrator');
@endphp
<a href="{{ $auditTrailRoute }}"
    class="group flex items-center gap-3.5 px-6 py-3 border-l-4 text-body-sm font-semibold transition-all {{ $isAuditTrailActive ? 'bg-white/10 text-white border-l-brand-orange' : 'text-white/70 hover:text-white hover:bg-white/5 border-l-transparent' }}"
    wire:navigate>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <circle cx="12" cy="12" r="10"></circle>
        <polyline points="12 6 12 12 16 14"></polyline>
    </svg>
    <span>Audit Trail</span>
</a>
@endif
@endif
