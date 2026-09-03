{{--
    IQArchive Institutional Accreditation Workspace
    Level 1: 5 Color-Coded Category Cards (Self-Survey, Compliance Reports, Supporting Docs, Narrative Profile, PPP)
    Level 2: Selected Category Workspace with Area navigation, formulas, and "Back to Categories" button.
--}}

<div class="p-6 space-y-6">
    @if(!$institutionalCategory)
        {{-- LEVEL 1: CATEGORY CARDS LANDING SCREEN (Reference Image 1) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
            <!-- 1. Self-Survey Documents Card (Amber) -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-primary">Self-Survey Documents</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="selectInstitutionalCategory('Self-Survey Documents')"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                    <span>Open Self-Survey</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

            <!-- 2. Compliance Reports Card (Emerald) -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-primary">Compliance Reports</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            Official compliance logs, AACCUP evaluations, corrective action reports, and certificates of accreditation.
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="selectInstitutionalCategory('Compliance Reports')"
                    class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                    <span>Open Reports</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

            <!-- 3. Supporting Documents Card (Navy) -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-surface-subtle text-primary flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-primary">Supporting Documents</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            Checklist criteria link inputs for inputs (Systems), implementation details, outcomes, and best practices.
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="selectInstitutionalCategory('Supporting Documents')"
                    class="w-full bg-primary hover:bg-primary-dark-hover text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                    <span>Open Supporting Docs</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

            <!-- 4. Narrative Profile Card (Violet) -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-primary">Narrative Profile</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            AACCUP Level 3 narrative profile templates organized by area with direct in-app editing and formatting.
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="selectInstitutionalCategory('Narrative Profile')"
                    class="w-full bg-violet-600 hover:bg-violet-700 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                    <span>Open Narrative Profile</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

            <!-- 5. Performance Portfolio (PPP) Card (Teal) -->
            <div class="bg-white border border-slate-200/70 rounded-2xl p-6 shadow-3xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between gap-5">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-primary">Performance Portfolio (PPP)</h3>
                        <p class="text-sm text-zinc-500 mt-2 leading-relaxed">
                            Institutional performance evidence portfolios and documentation templates organized by area for in-app compilation.
                        </p>
                    </div>
                </div>
                <button type="button" wire:click="selectInstitutionalCategory('PPP')"
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-lg font-bold text-sm shadow-3xs transition cursor-pointer flex items-center justify-center gap-2">
                    <span>Open PPP</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

    @else
        {{-- LEVEL 2: ACTIVE CATEGORY WORKSPACE (with "Back to Categories" button) --}}
        <div class="flex items-center justify-between gap-4 pb-2 border-b border-zinc-200">
            <div class="flex items-center gap-3">
                <button type="button" wire:click="clearInstitutionalCategory"
                    class="px-3.5 py-2 rounded-xl bg-white border border-zinc-300 text-zinc-700 hover:bg-zinc-50 text-xs font-bold transition shadow-3xs flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Back to Categories</span>
                </button>
                <div class="h-5 w-px bg-zinc-200"></div>
                <span class="text-sm font-bold text-primary">{{ $institutionalCategory }}</span>
            </div>
        </div>

        @if($institutionalCategory === 'Self-Survey Documents')
            <!-- Area Tabs Navigation Strip -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
                @foreach($surveyAreas as $area)
                    @php
                        $pct = $this->calculateAreaCompletionPct($area);
                    @endphp
                    <button wire:click="selectSurveyArea({{ $area->id }})"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all border shrink-0 flex items-center gap-2.5 {{ $surveyActiveAreaId === $area->id ? 'bg-primary text-white border-primary shadow-xs' : 'bg-white text-zinc-700 border-zinc-200 hover:border-zinc-300 hover:bg-zinc-50' }}">
                        <span>{{ $area->label }}: {{ Str::limit($area->title, 20) }}</span>
                        <span class="px-1.5 py-0.5 rounded-full text-label-xs font-black {{ $surveyActiveAreaId === $area->id ? 'bg-white/20 text-white' : 'bg-zinc-100 text-zinc-600' }}">
                            {{ $pct }}%
                        </span>
                    </button>
                @endforeach
            </div>

            <!-- Active Area Card Header -->
            @if($surveyActiveArea)
                <div class="bg-white rounded-2xl border border-zinc-200 p-5 shadow-3xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <span class="text-xs font-extrabold text-primary uppercase tracking-wider">{{ $surveyActiveArea->label }}</span>
                        <h2 class="text-base font-bold text-zinc-900 mt-0.5">{{ $surveyActiveArea->title }}</h2>
                    </div>
                    <div class="flex items-center gap-6">
                        <div>
                            <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400">Area Progress</span>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-24 bg-zinc-100 rounded-full h-2 overflow-hidden border border-zinc-200">
                                    <div class="bg-primary h-2 rounded-full transition-all duration-300" style="width: {{ $this->calculateAreaCompletionPct($surveyActiveArea) }}%"></div>
                                </div>
                                <span class="text-xs font-black text-zinc-800">{{ $this->calculateAreaCompletionPct($surveyActiveArea) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parameters & Sections Loop -->
                <div class="space-y-6">
                    @foreach($surveyActiveArea->parameters as $param)
                        @php
                            $paramMean = $this->calculateParameterMean($param);
                        @endphp
                        <div class="bg-white rounded-2xl border border-zinc-200 shadow-3xs overflow-hidden">
                            <!-- Parameter Header -->
                            <div class="px-6 py-4 bg-zinc-50 border-b border-zinc-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <span class="text-xs font-extrabold text-zinc-500 uppercase tracking-wider">Parameter {{ $param->code }}</span>
                                    <h3 class="text-xs font-bold text-zinc-900 mt-0.5">{{ $param->title }}</h3>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="text-xs text-zinc-500 font-semibold">Parameter Mean:</span>
                                    <span class="text-sm font-black px-2.5 py-0.5 rounded-lg {{ $paramMean !== null ? 'bg-primary/10 text-primary border border-primary/20' : 'bg-zinc-200 text-zinc-500' }}">
                                        {{ $paramMean !== null ? number_format($paramMean, 2) : '—' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Sections (System, Implementation, Outcome) -->
                            <div class="p-6 space-y-6">
                                @foreach([
                                    'system' => ['label' => 'System – Inputs & Processes', 'indicators' => $param->systemIndicators],
                                    'implementation' => ['label' => 'Implementation', 'indicators' => $param->implementationIndicators],
                                    'outcome' => ['label' => 'Outcomes', 'indicators' => $param->outcomeIndicators],
                                ] as $secKey => $secData)
                                    @php
                                        $secMean = $this->calculateSectionMean($secData['indicators']);
                                    @endphp
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between border-b border-zinc-100 pb-2">
                                            <h4 class="text-xs font-bold text-zinc-700 uppercase tracking-wider flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-primary"></span>
                                                {{ $secData['label'] }}
                                            </h4>
                                            <span class="text-xs font-bold text-zinc-600">
                                                Section Mean: <strong class="text-zinc-900 font-black">{{ $secMean !== null ? number_format($secMean, 2) : '—' }}</strong>
                                            </span>
                                        </div>

                                        <div class="divide-y divide-zinc-100 border border-zinc-200 rounded-xl overflow-hidden bg-white">
                                            @foreach($secData['indicators'] as $ind)
                                                <div class="p-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-zinc-50/60 transition-colors">
                                                    <div class="flex items-start gap-3">
                                                        <span class="px-2 py-0.5 rounded text-label-xs font-black bg-zinc-100 text-zinc-700 border border-zinc-200 shrink-0">
                                                            {{ $ind->code }}
                                                        </span>
                                                        <p class="text-xs text-zinc-800 leading-relaxed">{{ $ind->statement }}</p>
                                                    </div>

                                                    <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                                        <select wire:change="updateSurveyRating({{ $ind->id }}, $event.target.value)"
                                                            class="text-xs border border-zinc-300 rounded-lg px-2.5 py-1 bg-white text-zinc-800 font-bold focus:ring-2 focus:ring-primary/20 focus:border-primary">
                                                            <option value="" @selected(!isset($surveyRatings[$ind->id]))>Select</option>
                                                            <option value="NA" @selected(($surveyRatings[$ind->id] ?? null) === 'NA')>NA</option>
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <option value="{{ $i }}" @selected(($surveyRatings[$ind->id] ?? null) === (string)$i)>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @else
            <!-- Placeholder workspace for other categories -->
            <div class="bg-white rounded-2xl border border-zinc-200 p-12 text-center shadow-3xs flex flex-col items-center justify-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-surface-subtle text-primary flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-primary">{{ $institutionalCategory }}</h3>
                    <p class="text-xs text-zinc-500 max-w-md mx-auto mt-1 leading-relaxed">
                        Institutional records and reports for this section are maintained by the Institutional Quality Assurance (IQA) Office.
                    </p>
                </div>
            </div>
        @endif
    @endif
</div>
