@php
    // Mock data for analytics (hardcoded for presentation)
    $totalPrograms = 126;
    $totalDocs = 1847;
    $complianceRate = 78;
    $accreditedPrograms = 98;

    // Mock college data
    $collegeData = [
        ['name' => 'College of Science', 'code' => 'CS', 'programs' => 42, 'compliance' => 85, 'docs' => 612, 'level' => 'Level III'],
        ['name' => 'College of Engineering', 'code' => 'CENG', 'programs' => 38, 'compliance' => 72, 'docs' => 534, 'level' => 'Level II'],
        ['name' => 'College of Arts & Letters', 'code' => 'CAL', 'programs' => 28, 'compliance' => 91, 'docs' => 389, 'level' => 'Level IV'],
        ['name' => 'College of Education', 'code' => 'CED', 'programs' => 12, 'compliance' => 68, 'docs' => 201, 'level' => 'Level II'],
        ['name' => 'College of Business & Accountancy', 'code' => 'CBA', 'programs' => 6, 'compliance' => 55, 'docs' => 111, 'level' => 'Level I'],
    ];

    // Mock accreditation level distribution
    $levelDistribution = [
        'Level IV' => 11,
        'Level III' => 32,
        'Level II' => 35,
        'Level I' => 38,
        'Candidate' => 10,
    ];

    // Mock quarterly trends
    $quarterLabels = ['Q1 2025', 'Q2 2025', 'Q3 2025', 'Q4 2025', 'Q1 2026', 'Q2 2026'];
    $quarterCompliance = [52, 58, 65, 70, 74, 78];
    $quarterDocs = [310, 520, 890, 1230, 1560, 1847];

    // Mock area compliance
    $areaLabels = ['Area I', 'Area II', 'Area III', 'Area IV', 'Area V', 'Area VI', 'Area VII', 'Area VIII', 'Area IX', 'Area X'];
    $areaCompliance = [95, 82, 88, 72, 65, 80, 85, 90, 78, 70];
@endphp

<x-layouts::app :title="__('Analytics')">
    <div class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen font-sans">
        <!-- Top header bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-heading-lg font-bold text-primary-dark">Accreditation Analytics</h1>
                <p class="text-body-sm text-zinc-500 mt-1">Bicol University Institutional Quality Assurance Overview</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1.5 rounded-full bg-blue-50 text-primary-dark border border-blue-100 text-label font-bold select-none">Academic Year 2025–2026</span>
            </div>
        </div>

        <!-- Four KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Overall Compliance -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-label font-bold text-zinc-400 uppercase tracking-wider">Institutional Compliance</span>
                    <div class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12Z" /></svg>
                    </div>
                </div>
                <div class="text-heading-lg font-extrabold text-primary-dark">{{ $complianceRate }}%</div>
                <div class="text-label text-emerald-600 font-semibold mt-1">↑ 8% from last quarter</div>
            </div>

            <!-- Total Programs -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-label font-bold text-zinc-400 uppercase tracking-wider">Total Programs</span>
                    <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.99 5.99 0 0 1 12 3.453a5.99 5.99 0 0 1 4.543 5.881 50.58 50.58 0 0 0-2.658.813m-9.227 0L12 13.545l3.878-3.4m-7.756 0a48.36 48.36 0 0 1 7.756 0" /></svg>
                    </div>
                </div>
                <div class="text-heading-lg font-extrabold text-primary-dark">{{ $totalPrograms }}</div>
                <div class="text-label text-zinc-500 mt-1">Across {{ count($collegeData) }} colleges</div>
            </div>

            <!-- Accredited Programs -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-label font-bold text-zinc-400 uppercase tracking-wider">Accredited Programs</span>
                    <div class="p-2 rounded-lg bg-orange-50 text-brand-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.996.178-1.943.442-2.827.787C3.68 5.692 4.784 6.75 6 6.75h.75m0 0h10.5m-10.5 0V4.5m10.5 2.25c1.216 0 2.32-1.058 3.577-1.727-.884-.345-1.831-.609-2.827-.787M15 4.5V2.25" /></svg>
                    </div>
                </div>
                <div class="text-heading-lg font-extrabold text-primary-dark">{{ $accreditedPrograms }}</div>
                <div class="text-label text-zinc-500 mt-1">{{ round(($accreditedPrograms / $totalPrograms) * 100) }}% of total programs</div>
            </div>

            <!-- Compliance Documents -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-3xs hover:shadow-xs transition duration-200">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-label font-bold text-zinc-400 uppercase tracking-wider">Compliance Documents</span>
                    <div class="p-2 rounded-lg bg-violet-50 text-violet-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25" /></svg>
                    </div>
                </div>
                <div class="text-heading-lg font-extrabold text-primary-dark">{{ number_format($totalDocs) }}</div>
                <div class="text-label text-zinc-500 mt-1">Uploaded & archived portfolios</div>
            </div>
        </div>

        <!-- Charts Row 1: Compliance Trend + Accreditation Level Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Compliance Trend Line Chart (2 cols) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-heading-sm font-bold text-primary-dark">Compliance Rate Trend</h2>
                        <p class="text-label text-zinc-400 mt-0.5">Quarterly institutional compliance progress</p>
                    </div>
                    <span class="text-label font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full select-none">+26% YoY</span>
                </div>
                <div class="h-64">
                    <canvas id="complianceTrendChart"></canvas>
                </div>
            </div>

            <!-- Accreditation Level Distribution Doughnut (1 col) -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs">
                <div class="mb-6">
                    <h2 class="text-heading-sm font-bold text-primary-dark">Accreditation Levels</h2>
                    <p class="text-label text-zinc-400 mt-0.5">Program distribution by AACCUP level</p>
                </div>
                <div class="h-48 flex items-center justify-center">
                    <canvas id="levelDistChart"></canvas>
                </div>
                <!-- Legend -->
                <div class="mt-4 flex flex-col gap-2">
                    @foreach($levelDistribution as $level => $count)
                        @php
                            $colorMap = [
                                'Level IV' => 'bg-emerald-500',
                                'Level III' => 'bg-blue-500',
                                'Level II' => 'bg-amber-500',
                                'Level I' => 'bg-orange-500',
                                'Candidate' => 'bg-zinc-400',
                            ];
                        @endphp
                        <div class="flex items-center justify-between text-body-sm font-semibold text-zinc-600">
                            <span class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full {{ $colorMap[$level] ?? 'bg-zinc-300' }}"></span>
                                {{ $level }}
                            </span>
                            <span>{{ $count }} programs</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Charts Row 2: Area Compliance Radar + Document Upload Trend -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Area Compliance Bar Chart -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-heading-sm font-bold text-primary-dark">Compliance by AACCUP Area</h2>
                        <p class="text-label text-zinc-400 mt-0.5">Average compliance rate per accreditation area</p>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="areaComplianceChart"></canvas>
                </div>
            </div>

            <!-- Document Upload Trend Bar Chart -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-heading-sm font-bold text-primary-dark">Document Uploads Over Time</h2>
                        <p class="text-label text-zinc-400 mt-0.5">Cumulative compliance portfolio submissions</p>
                    </div>
                    <span class="text-label font-bold text-violet-600 bg-violet-50 border border-violet-100 px-2.5 py-1 rounded-full select-none">{{ number_format($totalDocs) }} total</span>
                </div>
                <div class="h-64">
                    <canvas id="docUploadChart"></canvas>
                </div>
            </div>
        </div>

        <!-- College Quality Assurance Performance Table -->
        <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-3xs">
            <div class="border-b border-zinc-100 pb-4 mb-4">
                <h2 class="text-heading-sm font-bold text-primary-dark">College Quality Assurance Performance</h2>
                <p class="text-label text-zinc-400 mt-0.5">High-level comparison across Bicol University colleges</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-body text-zinc-600">
                    <thead>
                        <tr class="text-label font-bold text-zinc-400 uppercase tracking-wider border-b border-zinc-100">
                            <th class="pb-3">College</th>
                            <th class="pb-3 text-center">Programs</th>
                            <th class="pb-3 text-center">Archived Files</th>
                            <th class="pb-3 text-center">AACCUP Level</th>
                            <th class="pb-3 text-center">Compliance Rate</th>
                            <th class="pb-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 font-medium">
                        @foreach($collegeData as $college)
                            <tr class="hover:bg-zinc-50/50 transition">
                                <td class="py-4">
                                    <span class="block text-body font-bold text-primary-dark">{{ $college['name'] }}</span>
                                    <span class="block text-label text-zinc-400 font-mono mt-0.5">{{ $college['code'] }}</span>
                                </td>
                                <td class="py-4 text-center font-bold text-zinc-700">{{ $college['programs'] }}</td>
                                <td class="py-4 text-center text-zinc-600">{{ $college['docs'] }}</td>
                                <td class="py-4 text-center">
                                    @php
                                        $levelColor = match($college['level']) {
                                            'Level IV' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                            'Level III' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'Level II' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'Level I' => 'bg-orange-50 text-orange-700 border-orange-100',
                                            default => 'bg-zinc-100 text-zinc-600 border-zinc-200',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 text-label font-bold uppercase rounded-full border {{ $levelColor }}">{{ $college['level'] }}</span>
                                </td>
                                <td class="py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-20 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $college['compliance'] >= 80 ? 'bg-emerald-500' : ($college['compliance'] >= 60 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ $college['compliance'] }}%"></div>
                                        </div>
                                        <span class="text-body-sm font-bold text-primary-dark">{{ $college['compliance'] }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 text-right">
                                    @if($college['compliance'] >= 80)
                                        <span class="text-label font-bold text-emerald-600">On Track</span>
                                    @elseif($college['compliance'] >= 60)
                                        <span class="text-label font-bold text-amber-600">Needs Attention</span>
                                    @else
                                        <span class="text-label font-bold text-rose-600">At Risk</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fontFamily = "'Inter', 'Segoe UI', system-ui, sans-serif";
            const gridColor = 'rgba(0,0,0,0.04)';
            const labelColor = '#94a3b8';

            Chart.defaults.font.family = fontFamily;
            Chart.defaults.font.size = 11;
            Chart.defaults.color = labelColor;

            // 1. Compliance Trend Line Chart
            new Chart(document.getElementById('complianceTrendChart'), {
                type: 'line',
                data: {
                    labels: @json($quarterLabels),
                    datasets: [{
                        label: 'Compliance Rate (%)',
                        data: @json($quarterCompliance),
                        borderColor: '#002B61',
                        backgroundColor: 'rgba(0, 43, 97, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#002B61',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#002B61',
                            titleFont: { weight: 'bold' },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: ctx => ctx.parsed.y + '% compliance'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 40,
                            max: 100,
                            grid: { color: gridColor },
                            ticks: { callback: v => v + '%' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // 2. Accreditation Level Doughnut
            new Chart(document.getElementById('levelDistChart'), {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($levelDistribution)),
                    datasets: [{
                        data: @json(array_values($levelDistribution)),
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#a1a1aa'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#002B61',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: ctx => ctx.label + ': ' + ctx.parsed + ' programs'
                            }
                        }
                    }
                }
            });

            // 3. Area Compliance Bar Chart
            new Chart(document.getElementById('areaComplianceChart'), {
                type: 'bar',
                data: {
                    labels: @json($areaLabels),
                    datasets: [{
                        label: 'Compliance %',
                        data: @json($areaCompliance),
                        backgroundColor: @json($areaCompliance).map(v => v >= 80 ? '#10b981' : v >= 60 ? '#f59e0b' : '#ef4444'),
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 28,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#002B61',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: ctx => ctx.parsed.y + '% compliance'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: gridColor },
                            ticks: { callback: v => v + '%' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // 4. Document Upload Bar Chart
            new Chart(document.getElementById('docUploadChart'), {
                type: 'bar',
                data: {
                    labels: @json($quarterLabels),
                    datasets: [{
                        label: 'Documents',
                        data: @json($quarterDocs),
                        backgroundColor: 'rgba(139, 92, 246, 0.7)',
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 36,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#002B61',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: ctx => ctx.parsed.y.toLocaleString() + ' documents'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: { callback: v => v.toLocaleString() }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts::app>