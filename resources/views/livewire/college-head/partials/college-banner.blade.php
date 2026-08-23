<div class="relative overflow-hidden rounded-2xl bg-linear-to-r from-primary-dark via-primary to-primary-light p-6 md:p-8 text-white shadow-md">
    <!-- Background Watermark Pattern -->
    <div class="absolute -right-8 -bottom-10 opacity-10 pointer-events-none">
        <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
        </svg>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-2">

            </div>

            <h1 class="text-heading-lg font-bold text-white tracking-tight">
                {{ $college?->name ?? 'Academic College' }} ({{ $college?->code ?? 'UNIT' }})
            </h1>
            <p class="text-body-sm text-white/80 max-w-2xl leading-relaxed">
                Oversee degree program accreditation cycles, mobilize faculty task forces, and review evidence artifacts prior to institutional quality assurance submission.
            </p>
        </div>

        <!-- College Accreditation Health Badge -->
        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/15 shrink-0 flex flex-col gap-2 min-w-56">
            <div class="flex items-center justify-between text-label-xs font-bold uppercase tracking-wider text-white/90">
                <span>Accreditation Rate</span>
                <span class="text-brand-orange font-mono text-body-sm font-bold">{{ $kpiMetrics['accreditationRate'] }}%</span>
            </div>
            <!-- Progress Bar -->
            <div class="w-full bg-black/20 rounded-full h-2 overflow-hidden">
                <div class="bg-brand-orange h-2 rounded-full transition-all duration-500" style="width: {{ $kpiMetrics['accreditationRate'] }}%;"></div>
            </div>
            <div class="flex items-center justify-between text-label-xs text-white/70">
                <span>{{ $kpiMetrics['accreditedPrograms'] }} of {{ $kpiMetrics['totalPrograms'] }} Accredited</span>
                <span class="text-emerald-300 font-semibold">{{ $kpiMetrics['activeVisits'] }} Active Cycle(s)</span>
            </div>
        </div>
    </div>
</div>