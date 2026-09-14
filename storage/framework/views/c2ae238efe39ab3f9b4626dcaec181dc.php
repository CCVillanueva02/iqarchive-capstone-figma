<!-- LEVEL 3B: SELF SURVEY VIEW -->
<div x-show="accredCategory === 'Self-Survey Documents' && (currentUserRole !== 'task-force-member' || !accredProgram || accredProgram.instrument_verified)"
     x-init="$watch('accredCategory', val => { if (val === 'Self-Survey Documents' && !selfSurveyActiveAreaId && institutionalSurveyAreas.length) selectSurveyArea(institutionalSurveyAreas[0].id); })"
     x-transition class="flex flex-col gap-5 w-full">

    <!-- ── SURVEY TABLE ──────────────────────────── -->
    <div class="flex flex-col gap-5">

        <!-- ── HORIZONTAL AREA TAB STRIP (matches Supporting Documents style) ── -->
        <div class="flex overflow-x-auto gap-3 pb-2 w-full select-none">
            <template x-for="area in institutionalSurveyAreas" :key="area.id">
                <button type="button"
                    class="flex-1 shrink-0 min-w-50 bg-white rounded-xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24"
                    :class="selfSurveyActiveAreaId === area.id ? 'border-primary ring-1 ring-primary/30 shadow-xs' : 'border-slate-200/60 hover:border-slate-350'"
                    @click="selectSurveyArea(area.id)">
                    <div>
                        <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                        <span class="text-sm font-bold text-primary mt-1 leading-tight line-clamp-2 block" x-text="area.title"></span>
                    </div>
                    <div class="w-full mt-2">
                        <div class="w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" :style="'width: ' + (areaMeanPct(area)) + '%'"></div>
                        </div>
                    </div>
                </button>
            </template>
        </div>

        <!-- RATING SCALE LEGEND — collapsible dropdown -->
        <details class="group bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
            <summary class="flex items-center justify-between px-5 py-3 cursor-pointer select-none list-none bg-slate-50 hover:bg-slate-100 transition">
                <span class="text-xs font-extrabold text-primary uppercase tracking-widest">Rating Scale Reference</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                    class="w-4 h-4 text-zinc-400 transition-transform duration-200 group-open:rotate-180">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="overflow-x-auto border-t border-slate-200">
                <table class="w-full text-xs text-center border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-3 py-2.5 font-extrabold text-zinc-500 border-r border-slate-200 w-20">NA</th>
                            <th class="px-3 py-2.5 font-extrabold text-zinc-500 border-r border-slate-200 w-16">0</th>
                            <th class="px-3 py-2.5 font-extrabold text-zinc-700 border-r border-slate-200">1</th>
                            <th class="px-3 py-2.5 font-extrabold text-zinc-700 border-r border-slate-200">2</th>
                            <th class="px-3 py-2.5 font-extrabold text-primary border-r border-slate-200">3</th>
                            <th class="px-3 py-2.5 font-extrabold text-primary border-r border-slate-200">4</th>
                            <th class="px-3 py-2.5 font-extrabold text-emerald-700">5</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-100">
                            <td class="px-3 py-2 text-zinc-500 font-semibold border-r border-slate-100">–</td>
                            <td class="px-3 py-2 text-zinc-500 font-semibold border-r border-slate-100">–</td>
                            <td class="px-3 py-2 text-zinc-700 font-bold border-r border-slate-100">Poor</td>
                            <td class="px-3 py-2 text-zinc-700 font-bold border-r border-slate-100">Fair</td>
                            <td class="px-3 py-2 text-primary font-bold border-r border-slate-100">Satisfactory</td>
                            <td class="px-3 py-2 text-primary font-bold border-r border-slate-100">Very Satisfactory</td>
                            <td class="px-3 py-2 text-emerald-700 font-bold">Excellent</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2.5 text-zinc-400 italic leading-relaxed border-r border-slate-100 align-top">Not Applicable</td>
                            <td class="px-3 py-2.5 text-zinc-400 italic leading-relaxed border-r border-slate-100 align-top">Missing</td>
                            <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is met minimally in some respects, but much improvement is needed to overcome weaknesses<br><span class="italic">(75% lesser than the standards)</span></td>
                            <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is met in most respects, but some improvement is needed to overcome weaknesses<br><span class="italic">(50% lesser than the standards)</span></td>
                            <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is met in all respects<br><span class="italic">(100% compliance with the standards)</span></td>
                            <td class="px-3 py-2.5 text-zinc-500 leading-relaxed border-r border-slate-100 align-top">Criterion is fully met in all respects, at a level that demonstrates good practice<br><span class="italic">(50% greater than the standards)</span></td>
                            <td class="px-3 py-2.5 text-zinc-500 leading-relaxed align-top">Criterion is fully met with substantial number of good practices, at a level that provides a model for others<br><span class="italic">(75% greater than the standards)</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </details>

        <!-- SURVEY TABLE -->
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-3xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm" style="table-layout:fixed; min-width:820px;">
                    <colgroup>
                        <col>
                        <col style="width:100px;">
                        <col style="width:170px;">
                        <col style="width:120px;">
                    </colgroup>
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="px-5 py-3 text-left text-xs font-extrabold text-primary border-r border-slate-200">Indicators</th>
                            <th class="border-r border-slate-200 py-3 px-2 text-center w-25 min-w-25 max-w-25">
                                <div class="text-label font-extrabold text-primary uppercase tracking-wider leading-snug">Item Rating</div>
                                <div class="text-label-xs text-zinc-400 font-semibold mt-0.5 leading-tight">IR</div>
                            </th>
                            <th class="border-r border-slate-200 py-3 px-2 text-center w-42.5 min-w-42.5 max-w-42.5">
                                <div class="text-label font-extrabold text-primary uppercase tracking-wider leading-snug">System – Implementation – Outcome Mean</div>
                                <div class="text-label-xs text-zinc-400 font-semibold mt-0.5 leading-tight">SIOM</div>
                            </th>
                            <th class="py-3 px-2 text-center w-30 min-w-30 max-w-30">
                                <div class="text-label font-extrabold text-primary uppercase tracking-wider leading-snug">Parameter Mean</div>
                                <div class="text-label-xs text-zinc-400 font-semibold mt-0.5 leading-tight">PM</div>
                            </th>
                        </tr>
                    </thead>

                    <template x-for="(param, pIdx) in institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId)?.parameters" :key="param.id">
                        <tbody class="border-b-2 border-slate-300">
                            <tr class="bg-primary">
                                <td colspan="4" class="px-5 py-2.5 text-xs font-extrabold text-white uppercase tracking-wide">
                                    <span x-text="'PARAMETER ' + param.code + ': ' + param.title"></span>
                                </td>
                            </tr>

                            <tr class="bg-slate-100 border-b border-slate-200">
                                <td colspan="4" class="px-5 py-1.5 text-label font-extrabold text-zinc-600 uppercase tracking-wider">SYSTEM – INPUTS AND PROCESSES</td>
                            </tr>
                            <template x-for="ind in param.sections.system" :key="ind.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3 text-sm text-primary border-r border-slate-200">
                                        <div class="flex items-start gap-3">
                                            <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                            <span class="leading-relaxed" x-text="ind.statement"></span>
                                        </div>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-25 min-w-25 max-w-25">
                                        <select
                                            @change="saveRating(ind.id, $event.target.value)"
                                            :value="selfSurveyRatings[ind.id] ?? ''"
                                            class="w-14 mx-auto text-center text-xs font-bold text-primary bg-slate-100 border border-slate-200 rounded-lg py-1 hover:bg-white focus:ring-2 focus:ring-primary/50 block cursor-pointer transition">
                                            <option value=""></option>
                                            <option value="NA">N/A</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-42.5 min-w-42.5 max-w-42.5"></td>
                                    <td class="text-center p-1 w-30 min-w-30 max-w-30"></td>
                                </tr>
                            </template>
                            <tr class="bg-blue-50/60 border-b border-slate-200">
                                <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200 text-right">System mean</td>
                                <td class="border-r border-slate-200 text-center p-1 w-25 min-w-25 max-w-25"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-42.5 min-w-42.5 max-w-42.5">
                                    <span class="text-sm font-extrabold text-primary" x-text="sectionMean(param.sections.system) ?? ''"></span>
                                </td>
                                <td class="text-center p-1 w-30 min-w-30 max-w-30"></td>
                            </tr>

                            <tr class="bg-slate-100 border-b border-slate-200">
                                <td colspan="4" class="px-5 py-1.5 text-label font-extrabold text-zinc-600 uppercase tracking-wider">IMPLEMENTATION</td>
                            </tr>
                            <template x-for="ind in param.sections.implementation" :key="ind.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3 text-sm text-primary border-r border-slate-200">
                                        <div class="flex items-start gap-3">
                                            <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                            <span class="leading-relaxed" x-text="ind.statement"></span>
                                        </div>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-25 min-w-25 max-w-25">
                                        <select
                                            @change="saveRating(ind.id, $event.target.value)"
                                            :value="selfSurveyRatings[ind.id] ?? ''"
                                            class="w-14 mx-auto text-center text-xs font-bold text-primary bg-slate-100 border border-slate-200 rounded-lg py-1 hover:bg-white focus:ring-2 focus:ring-primary/50 block cursor-pointer transition">
                                            <option value=""></option>
                                            <option value="NA">N/A</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-42.5 min-w-42.5 max-w-42.5"></td>
                                    <td class="text-center p-1 w-30 min-w-30 max-w-30"></td>
                                </tr>
                            </template>
                            <tr class="bg-surface-subtle/60 border-b border-slate-200">
                                <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200 text-right">Implementation mean</td>
                                <td class="border-r border-slate-200 text-center p-1 w-25 min-w-25 max-w-25"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-42.5 min-w-42.5 max-w-42.5">
                                    <span class="text-sm font-extrabold text-primary" x-text="sectionMean(param.sections.implementation) ?? ''"></span>
                                </td>
                                <td class="text-center p-1 w-30 min-w-30 max-w-30"></td>
                            </tr>

                            <tr class="bg-slate-100 border-b border-slate-200">
                                <td colspan="4" class="px-5 py-1.5 text-label font-extrabold text-zinc-600 uppercase tracking-wider">OUTCOME/S</td>
                            </tr>
                            <template x-for="ind in param.sections.outcome" :key="ind.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3 text-sm text-primary border-r border-slate-200">
                                        <div class="flex items-start gap-3">
                                            <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                            <span class="leading-relaxed" x-text="ind.statement"></span>
                                        </div>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-25 min-w-25 max-w-25">
                                        <select
                                            @change="saveRating(ind.id, $event.target.value)"
                                            :value="selfSurveyRatings[ind.id] ?? ''"
                                            class="w-14 mx-auto text-center text-xs font-bold text-primary bg-slate-100 border border-slate-200 rounded-lg py-1 hover:bg-white focus:ring-2 focus:ring-primary/50 block cursor-pointer transition">
                                            <option value=""></option>
                                            <option value="NA">N/A</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-42.5 min-w-42.5 max-w-42.5"></td>
                                    <td class="text-center p-1 w-30 min-w-30 max-w-30"></td>
                                </tr>
                            </template>
                            <tr class="bg-surface-subtle/60 border-b border-slate-200">
                                <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200 text-right">Outcome mean</td>
                                <td class="border-r border-slate-200 text-center p-1 w-25 min-w-25 max-w-25"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-42.5 min-w-42.5 max-w-42.5">
                                    <span class="text-sm font-extrabold text-primary" x-text="sectionMean(param.sections.outcome) ?? ''"></span>
                                </td>
                                <td class="text-center p-1 w-30 min-w-30 max-w-30"></td>
                            </tr>

                            <tr class="bg-emerald-50/80 border-b border-slate-200">
                                <td class="px-5 py-2.5 text-xs font-bold text-zinc-500 border-r border-slate-200 italic">
                                    Parameter Mean —
                                    <span class="text-primary not-italic font-extrabold" x-text="'Parameter ' + param.code + ': ' + param.title"></span>
                                </td>
                                <td class="border-r border-slate-200 text-center p-1 w-25 min-w-25 max-w-25"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-42.5 min-w-42.5 max-w-42.5"></td>
                                <td class="text-center p-1 w-30 min-w-30 max-w-30">
                                    <span class="text-sm font-extrabold text-emerald-700" x-text="paramMean(param) ?? ''"></span>
                                </td>
                            </tr>

                            <tr class="border-b border-slate-200 bg-amber-50/30">
                                <td colspan="4" class="px-5 py-3">
                                    <div class="flex flex-col gap-1.5">
                                        <span class="text-xs font-extrabold text-zinc-500 uppercase tracking-wide">Best Practices:</span>
                                        <textarea
                                            :id="'bp_' + param.id"
                                            x-model="selfSurveyBestPractices[param.id]"
                                            @change="saveBestPractice(param.id, $event.target.value)"
                                            rows="3"
                                            placeholder="No best practices recorded for this parameter."
                                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-zinc-700 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition leading-relaxed">
                                        </textarea>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </template>

                    <tfoot>
                        <tr class="bg-primary/10 border-t-2 border-primary/30">
                            <td class="px-5 py-3 text-xs font-extrabold text-primary uppercase tracking-wide border-r border-slate-200 text-right">
                                Total Rating
                                <span class="text-zinc-400 font-normal normal-case text-label-xs ml-1">(sum of all IR)</span>
                            </td>
                            <td class="border-r border-slate-200 text-center p-2 w-25 min-w-25 max-w-25">
                                <span class="text-base font-extrabold text-primary"
                                    x-text="(() => { const area = institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId); if (!area) return ''; let total = 0; area.parameters.forEach(p => { [...(p.sections.system||[]),...(p.sections.implementation||[]),...(p.sections.outcome||[])].forEach(ind => { const v = parseFloat(selfSurveyRatings[ind.id]); if (!isNaN(v)) total += v; }); }); return total; })()">
                                </span>
                            </td>
                            <td class="border-r border-slate-200 text-center p-2 w-42.5 min-w-42.5 max-w-42.5"></td>
                            <td class="text-center p-2 w-30 min-w-30 max-w-30"></td>
                        </tr>
                        <tr class="bg-emerald-600 text-white">
                            <td class="px-5 py-3 text-xs font-extrabold uppercase tracking-wide border-r border-emerald-500 text-right">
                                Area Mean
                                <span class="font-normal normal-case text-emerald-100 text-label-xs ml-1">(mean of all parameter means)</span>
                            </td>
                            <td class="border-r border-emerald-500 text-center p-2 w-25 min-w-25 max-w-25"></td>
                            <td class="border-r border-emerald-500 text-center p-2 w-42.5 min-w-42.5 max-w-42.5"></td>
                            <td class="text-center p-2 w-30 min-w-30 max-w-30">
                                <span class="text-base font-extrabold"
                                    x-text="(() => { const area = institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId); if (!area) return ''; const means = area.parameters.map(p => paramMean(p)).filter(v => v !== null && v !== undefined && v !== ''); if (!means.length) return ''; return (means.reduce((a,b) => a + parseFloat(b), 0) / means.length).toFixed(2); })()">
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-2">
            <!-- Left: Prepared By -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <span class="text-sm font-extrabold text-zinc-500 uppercase tracking-wide shrink-0">Prepared By:</span>
                <input type="text"
                    x-model="selfSurveyPreparedBy"
                    placeholder="Enter your name..."
                    class="w-full md:w-72 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-primary placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition shadow-3xs" />
            </div>
            
            <!-- Right: Submit Button -->
            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                <button type="button"
                    @click="submitSelfSurvey()"
                    :disabled="!isAreaComplete(selfSurveyActiveAreaId) || !selfSurveyPreparedBy?.trim()"
                    :class="(!isAreaComplete(selfSurveyActiveAreaId) || !selfSurveyPreparedBy?.trim()) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-emerald-700 cursor-pointer'"
                    class="px-5 py-2.5 bg-emerald-600 text-white font-bold text-sm rounded-xl transition shadow-3xs flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" /></svg>
                    Submit Self-Survey
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\crljs\OneDrive\Documents\GitHub\iqarchive-capstone\resources\views/pages/documents/partials/program-accreditation/self-survey-matrix.blade.php ENDPATH**/ ?>