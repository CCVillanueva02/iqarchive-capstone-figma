<!-- Summary Stats Bar -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
    <!-- 1. Colleges & Satellites Simple Count Card -->
    <div class="lg:col-span-3 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-primary flex items-center justify-center font-bold shrink-0">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
            </svg>
        </div>
        <div class="flex flex-col">
            <span class="text-label text-slate-500 font-medium uppercase tracking-wider">Colleges &amp; Satellites</span>
            <span class="text-heading font-bold text-primary mt-0.5">{{ $totalColleges }}</span>
        </div>
    </div>

    <!-- 2. Degree Programs Simple Count Card -->
    <div class="lg:col-span-3 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-orange-50 text-brand-orange flex items-center justify-center font-bold shrink-0">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
        </div>
        <div class="flex flex-col">
            <span class="text-label text-slate-500 font-medium uppercase tracking-wider">Degree Programs</span>
            <span class="text-heading font-bold text-primary mt-0.5">{{ $totalPrograms }}</span>
        </div>
    </div>

    <!-- 3. Accreditation Progress Visualization Card -->
    <div class="lg:col-span-6 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-3xs flex flex-col justify-between">
        <div class="flex items-center justify-between gap-2 mb-2">
            <span class="text-label text-slate-500 font-medium uppercase tracking-wider">Accreditation Progress</span>
            <span class="text-label font-bold text-slate-600">{{ $totalPrograms }} {{ Str::plural('program', $totalPrograms) }} total</span>
        </div>

        <!-- Segmented Progress Bar -->
        <div class="w-full h-3.5 bg-slate-100 rounded-full overflow-hidden flex shadow-inner">
            @foreach($levelBreakdown as $levelKey => $data)
                @php
                    $pct = $totalPrograms > 0 ? ($data['count'] / $totalPrograms) * 100 : 0;
                @endphp
                @if($pct > 0)
                <div class="{{ $data['barColor'] }} h-full transition-all duration-300" style="width: {{ $pct }}%;" title="{{ $data['label'] }}: {{ $data['count'] }} ({{ round($pct, 1) }}%)"></div>
                @endif
            @endforeach
            @if($totalPrograms === 0)
                <div class="bg-slate-200 h-full w-full" title="No programs"></div>
            @endif
        </div>

        <!-- Legend Swatches -->
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-3 text-label font-medium text-slate-600">
            @foreach($levelBreakdown as $levelKey => $data)
            <div class="flex items-center gap-1.5" title="{{ $levelKey }}">
                <span class="w-2.5 h-2.5 rounded-full {{ $data['dotColor'] }} shrink-0"></span>
                <span>{{ $data['label'] }}</span>
                <span class="font-bold text-slate-800">({{ $data['count'] }})</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
