<div class="flex flex-col gap-6">
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs flex flex-col overflow-hidden">
        <!-- Header & Year Filter -->
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/70 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-primary-dark text-heading-sm">
                    AACCUP Technical Review Summary
                </h2>
                <p class="text-body-sm text-primary-muted mt-0.5">
                    College-by-college breakdown of survey visits, timeliness compliance, and accreditation results for {{ $reportYear }}.
                </p>
            </div>

            <!-- Year Selector Tabs -->
            <div class="flex bg-slate-200/70 p-1 rounded-xl border border-slate-300/60 self-stretch md:self-auto">
                @foreach(['2026', '2025', '2024', '2023'] as $yr)
                <button type="button" 
                    wire:click="$set('reportYear', '{{ $yr }}')" 
                    class="px-4 py-1.5 rounded-lg text-body-sm font-semibold transition-all cursor-pointer {{ $reportYear === $yr ? 'bg-white text-primary-dark shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    {{ $yr }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Condensed Summary Matrix Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-primary-dark text-white text-label uppercase tracking-wider">
                        <th rowspan="2" class="px-5 py-3 font-bold border-r border-white/20">College / Academic Unit</th>
                        <th rowspan="2" class="px-4 py-3 text-center border-r border-white/20 bg-primary font-bold">Total<br>Visits</th>
                        <th colspan="2" class="px-4 py-2 text-center border-b border-white/20 bg-primary-hover font-bold">Timeliness</th>
                        <th colspan="3" class="px-4 py-2 text-center border-b border-white/20 bg-primary font-bold">Board Results</th>
                        <th colspan="2" class="px-4 py-2 text-center border-b border-white/20 bg-primary-light font-bold">Pending Actions</th>
                    </tr>
                    <tr class="text-white text-label-xs font-bold tracking-wider">
                        <th class="px-3 py-2 text-center bg-primary-hover border-r border-white/10">Timely</th>
                        <th class="px-3 py-2 text-center bg-primary-hover border-r border-white/20">Late</th>
                        <th class="px-3 py-2 text-center bg-primary border-r border-white/10">Passed</th>
                        <th class="px-3 py-2 text-center bg-primary border-r border-white/10">Deferred</th>
                        <th class="px-3 py-2 text-center bg-primary border-r border-white/20">Revisit</th>
                        <th class="px-3 py-2 text-center bg-primary-light border-r border-white/10">Count</th>
                        <th class="px-3 py-2 text-center bg-primary-light">Target Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-body-sm text-slate-700">
                    @php
                        $grandTotal = 0;
                        $grandTimely = 0;
                        $grandLate = 0;
                        $grandPassed = 0;
                        $grandDeferred = 0;
                        $grandRevisit = 0;
                        $grandPending = 0;
                    @endphp

                    @foreach($summaryColleges as $item)
                    @php
                        $grandTotal += $item['total_visits'];
                        $grandTimely += $item['timely'];
                        $grandLate += $item['late'];
                        $grandPassed += $item['passed'];
                        $grandDeferred += $item['deferred'];
                        $grandRevisit += $item['revisit'];
                        $grandPending += $item['pending_count'];
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3 font-bold text-primary border-r border-slate-200">
                            <div class="flex items-center gap-3">
                                <img src="{{ (new \App\Models\College(['code' => $item['college_code']]))->logo }}" alt="Logo" class="w-6 h-6 object-contain shrink-0" onerror="this.style.display='none'">
                                <div class="flex flex-col">
                                    <span class="text-primary-dark font-extrabold">{{ $item['college_code'] }}</span>
                                    <span class="text-label-xs text-primary-muted font-normal hidden lg:block">{{ $item['college_name'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center font-black text-body text-slate-800 bg-slate-50 border-r border-slate-200">
                            {{ $item['total_visits'] }}
                        </td>
                        <td class="px-3 py-3 text-center font-bold text-emerald-600 bg-emerald-50/25 border-r border-slate-200">
                            {{ $item['timely'] }}
                        </td>
                        <td class="px-3 py-3 text-center font-bold text-amber-600 bg-amber-50/25 border-r border-slate-200">
                            {{ $item['late'] }}
                        </td>
                        <td class="px-3 py-3 text-center font-bold text-emerald-600 bg-emerald-50/25 border-r border-slate-200">
                            {{ $item['passed'] }}
                        </td>
                        <td class="px-3 py-3 text-center font-bold {{ $item['deferred'] > 0 ? 'text-amber-600' : 'text-slate-300' }} border-r border-slate-200">
                            {{ $item['deferred'] }}
                        </td>
                        <td class="px-3 py-3 text-center font-bold {{ $item['revisit'] > 0 ? 'text-rose-600' : 'text-slate-300' }} border-r border-slate-200">
                            {{ $item['revisit'] }}
                        </td>
                        <td class="px-3 py-3 text-center font-bold text-primary border-r border-slate-200">
                            {{ $item['pending_count'] }}
                        </td>
                        <td class="px-3 py-3 text-center text-label-xs text-slate-500 font-mono">
                            {{ $item['target'] }}
                        </td>
                    </tr>
                    @endforeach

                    <!-- Grand Totals Row -->
                    <tr class="divide-x divide-slate-300 bg-slate-100/90 border-t-2 border-slate-300 font-bold">
                        <td class="px-5 py-3.5 text-primary-dark font-extrabold uppercase tracking-wider text-label">
                            Grand Totals ({{ $reportYear }})
                        </td>
                        <td class="px-4 py-3.5 text-center font-black text-heading-sm text-slate-900 bg-slate-200/80">
                            {{ $grandTotal }}
                        </td>
                        <td class="px-3 py-3.5 text-center text-emerald-700 bg-emerald-100/40">
                            {{ $grandTimely }}
                        </td>
                        <td class="px-3 py-3.5 text-center text-amber-800 bg-amber-100/40">
                            {{ $grandLate }}
                        </td>
                        <td class="px-3 py-3.5 text-center text-emerald-700 bg-emerald-100/40">
                            {{ $grandPassed }}
                        </td>
                        <td class="px-3 py-3.5 text-center text-amber-700 bg-slate-200/60">
                            {{ $grandDeferred }}
                        </td>
                        <td class="px-3 py-3.5 text-center text-rose-700 bg-rose-100/40">
                            {{ $grandRevisit }}
                        </td>
                        <td class="px-3 py-3.5 text-center text-primary text-body font-black bg-slate-200/80">
                            {{ $grandPending }}
                        </td>
                        <td class="px-3 py-3.5 text-center text-label-xs text-slate-400 font-mono">
                            Institutional Tracker
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
