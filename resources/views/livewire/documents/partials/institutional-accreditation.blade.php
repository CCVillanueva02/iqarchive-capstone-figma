<div class="p-6 space-y-6">
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

                        <!-- Best Practices Textarea -->
                        <div class="pt-4 border-t border-zinc-100">
                            <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-1.5">
                                Best Practices Observed for Parameter {{ $param->code }}
                            </label>
                            <textarea wire:blur="saveBestPractices({{ $param->id }}, $event.target.value)"
                                class="w-full text-xs p-3 border border-zinc-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-zinc-800 placeholder:text-zinc-400"
                                rows="2" placeholder="Record noteworthy practices or strengths observed in this parameter...">{{ $param->best_practices }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
