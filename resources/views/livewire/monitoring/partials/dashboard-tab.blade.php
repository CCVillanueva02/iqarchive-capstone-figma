<div class="flex flex-col gap-6">
    <!-- Top KPI Overview Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Monitored Programs -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-label-xs font-bold uppercase tracking-wider text-primary-muted">Monitored Programs</span>
                <h3 class="text-heading-lg font-bold text-primary-dark mt-1">{{ $totalProgramsCount }}</h3>
                <span class="text-label-xs text-slate-400 mt-0.5 block">Across all academic colleges</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>

        <!-- Attention Required -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-label-xs font-bold uppercase tracking-wider text-rose-600">Attention Required</span>
                <h3 class="text-heading-lg font-bold text-rose-700 mt-1">3</h3>
                <span class="text-label-xs text-rose-600/80 mt-0.5 block">Expired or nearing expiry</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>

        <!-- In Progress Visits -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-label-xs font-bold uppercase tracking-wider text-primary">Active Preparations</span>
                <h3 class="text-heading-lg font-bold text-primary-dark mt-1">{{ $activeAccreditations->count() }}</h3>
                <span class="text-label-xs text-primary/80 mt-0.5 block">Visits currently in progress</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-surface-subtle text-primary border border-primary/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
        </div>

        <!-- Level IV / III Advanced Status -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-label-xs font-bold uppercase tracking-wider text-emerald-600">High Level Status</span>
                <h3 class="text-heading-lg font-bold text-emerald-800 mt-1">
                    {{ $levelDistribution['Level IV'] + $levelDistribution['Level III'] }}
                </h3>
                <span class="text-label-xs text-emerald-600/80 mt-0.5 block">Level III &amp; IV accredited</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Main Dual Grid: Attention Required & In Progress -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Expiring & Expired Programs (Attention Required) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs flex flex-col overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 bg-slate-50/70 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-primary-dark text-heading-sm flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Attention Required
                    </h2>
                    <p class="text-label text-primary-muted mt-0.5">Programs nearing validity expiration or already expired.</p>
                </div>
                <span class="bg-rose-100 text-rose-700 text-label-xs font-bold px-2.5 py-1 rounded-full border border-rose-200">
                    3 Programs
                </span>
            </div>

            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left text-body-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 text-label uppercase tracking-wider font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">College &amp; Program</th>
                            <th class="px-4 py-3">Validity Period</th>
                            <th class="px-4 py-3 text-right">Time Left / Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer group" wire:click="switchTab('programs')">
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-primary text-label-xs px-2 py-0.5 rounded bg-primary/10 mr-1.5">BUCAL</span>
                                <span class="font-semibold text-primary-dark group-hover:text-brand-orange transition-colors">Master of Arts in Literature</span>
                            </td>
                            <td class="px-4 py-3.5 text-label-xs font-mono text-slate-600">
                                Dec 16, 2023 - Dec 15, 2024
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-bold uppercase bg-rose-100 text-rose-700 border border-rose-200">
                                    Expired &bull; Late
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer group" wire:click="switchTab('programs')">
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-primary text-label-xs px-2 py-0.5 rounded bg-primary/10 mr-1.5">BUCE</span>
                                <span class="font-semibold text-primary-dark group-hover:text-brand-orange transition-colors">BSEd Major in Science</span>
                            </td>
                            <td class="px-4 py-3.5 text-label-xs font-mono text-slate-600">
                                Nov 01, 2022 - Oct 30, 2026
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-bold uppercase bg-amber-100 text-amber-800 border border-amber-200">
                                    2 mos left
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer group" wire:click="switchTab('programs')">
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-primary text-label-xs px-2 py-0.5 rounded bg-primary/10 mr-1.5">CENG</span>
                                <span class="font-semibold text-primary-dark group-hover:text-brand-orange transition-colors">BS Civil Engineering</span>
                            </td>
                            <td class="px-4 py-3.5 text-label-xs font-mono text-slate-600">
                                Jan 13, 2023 - Jan 12, 2027
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-xs font-bold uppercase bg-amber-100 text-amber-800 border border-amber-200">
                                    5 mos left
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-3 bg-slate-50/70 border-t border-slate-200 text-center">
                <button type="button" wire:click="switchTab('programs')" class="text-body-sm font-semibold text-brand-orange hover:text-brand-orange-hover flex items-center justify-center gap-1.5 w-full cursor-pointer">
                    <span>View all degree programs in Master Directory</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Active In-Progress Accreditations -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs flex flex-col overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 bg-slate-50/70 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-primary-dark text-heading-sm flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        In Progress Accreditations
                    </h2>
                    <p class="text-label text-primary-muted mt-0.5">Programs currently undergoing survey preparation.</p>
                </div>
                <span class="bg-surface-subtle text-primary-dark text-label-xs font-bold px-2.5 py-1 rounded-full border border-primary/15">
                    {{ $activeAccreditations->count() }} Programs
                </span>
            </div>

            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left text-body-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 text-label uppercase tracking-wider font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">College &amp; Program</th>
                            <th class="px-4 py-3">Current Stage</th>
                            <th class="px-4 py-3 text-right">Target Visit Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($activeAccreditations as $activeAcc)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer group" wire:click="viewProgramHistory({{ $activeAcc->program_id }})">
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-primary text-label-xs px-2 py-0.5 rounded bg-primary/10 mr-1.5">
                                    {{ $activeAcc->program->college->code ?? 'N/A' }}
                                </span>
                                <span class="font-semibold text-primary-dark group-hover:text-brand-orange transition-colors">
                                    {{ $activeAcc->program->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="text-label-xs font-bold text-primary uppercase tracking-wider block">
                                    {{ str_replace('_', ' ', $activeAcc->status) }}
                                </span>
                                <span class="text-label-xs text-slate-400">
                                    {{ $activeAcc->taskForce->name ?? 'Task force pending' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right font-mono text-label-xs text-slate-600">
                                {{ $activeAcc->target_date ? \Carbon\Carbon::parse($activeAcc->target_date)->format('M d, Y') : 'Date TBD' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-slate-500 text-body-sm">
                                No active in-progress accreditations at this moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-3 bg-slate-50/70 border-t border-slate-200 text-center">
                <a href="{{ route('visits.index') }}" class="text-body-sm font-semibold text-primary hover:text-primary-hover flex items-center justify-center gap-1.5 w-full cursor-pointer" wire:navigate>
                    <span>Manage all visits in Record a Visit</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Level Distribution Strip -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-heading-sm font-bold text-primary-dark">
                University Accreditation Level Distribution
            </h4>
            <span class="text-label-xs text-primary-muted">100% Institutional Compliance Scope</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            @foreach($levelDistribution as $level => $count)
            <div class="bg-surface-card border border-slate-200/80 rounded-xl p-4 text-center">
                <span class="text-label-xs font-bold uppercase tracking-wider text-slate-400 block">{{ $level }}</span>
                <span class="text-heading font-black text-primary-dark mt-1 block">{{ $count }}</span>
                <span class="text-label-xs text-primary-muted mt-0.5 block">
                    {{ $totalProgramsCount > 0 ? round(($count / $totalProgramsCount) * 100) : 0 }}% of programs
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
