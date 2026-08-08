<!-- LEVEL 3B: SELF SURVEY VIEW -->
<div x-show="(accredLevel === 'institutional' || (accredLevel === 'program' && accredProgram !== null)) && accredCategory === 'Self-Survey Documents'"
     x-init="$watch('accredCategory', val => { if (val === 'Self-Survey Documents' && !selfSurveyActiveAreaId && institutionalSurveyAreas.length) selectSurveyArea(institutionalSurveyAreas[0].id); })"
     x-transition class="flex flex-col gap-5 w-full">

    <!-- ── SURVEY TABLE ──────────────────────────── -->
    <div class="flex flex-col gap-5">

        <!-- ── HORIZONTAL AREA TAB STRIP (matches Supporting Documents style) ── -->
        <div class="flex overflow-x-auto gap-3 pb-2 w-full select-none">
            <template x-for="area in institutionalSurveyAreas" :key="area.id">
                <button type="button"
                    class="flex-1 shrink-0 min-w-[200px] bg-white rounded-xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24"
                    :class="selfSurveyActiveAreaId === area.id ? 'border-[#1b355a] ring-1 ring-[#1b355a]/30 shadow-xs' : 'border-slate-200/60 hover:border-slate-350'"
                    @click="selectSurveyArea(area.id)">
                    <div>
                        <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                        <span class="text-sm font-bold text-[#1b355a] mt-1 leading-tight line-clamp-2 block" x-text="area.title"></span>
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
                <span class="text-xs font-extrabold text-[#1b355a] uppercase tracking-widest">Rating Scale Reference</span>
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
                            <th class="px-3 py-2.5 font-extrabold text-[#1b355a] border-r border-slate-200">3</th>
                            <th class="px-3 py-2.5 font-extrabold text-blue-700 border-r border-slate-200">4</th>
                            <th class="px-3 py-2.5 font-extrabold text-emerald-700">5</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-100">
                            <td class="px-3 py-2 text-zinc-500 font-semibold border-r border-slate-100">–</td>
                            <td class="px-3 py-2 text-zinc-500 font-semibold border-r border-slate-100">–</td>
                            <td class="px-3 py-2 text-zinc-700 font-bold border-r border-slate-100">Poor</td>
                            <td class="px-3 py-2 text-zinc-700 font-bold border-r border-slate-100">Fair</td>
                            <td class="px-3 py-2 text-[#1b355a] font-bold border-r border-slate-100">Satisfactory</td>
                            <td class="px-3 py-2 text-blue-700 font-bold border-r border-slate-100">Very Satisfactory</td>
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
                    <!-- Column widths -->
                    <colgroup>
                        <col>
                        <col style="width:100px;">
                        <col style="width:170px;">
                        <col style="width:120px;">
                    </colgroup>
                    <!-- Column Headers — HORIZONTAL (not rotated) -->
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <!-- Indicators -->
                            <th class="px-5 py-3 text-left text-xs font-extrabold text-[#1b355a] border-r border-slate-200">Indicators</th>
                            <!-- IR -->
                            <th class="border-r border-slate-200 py-3 px-2 text-center w-[100px] min-w-[100px] max-w-[100px]">
                                <div class="text-[11px] font-extrabold text-[#1b355a] uppercase tracking-wider leading-snug">Item Rating</div>
                                <div class="text-[10px] text-zinc-400 font-semibold mt-0.5 leading-tight">IR</div>
                            </th>
                            <!-- SIOM -->
                            <th class="border-r border-slate-200 py-3 px-2 text-center w-[170px] min-w-[170px] max-w-[170px]">
                                <div class="text-[11px] font-extrabold text-[#1b355a] uppercase tracking-wider leading-snug">System – Implementation – Outcome Mean</div>
                                <div class="text-[10px] text-zinc-400 font-semibold mt-0.5 leading-tight">SIOM</div>
                            </th>
                            <!-- PM -->
                            <th class="py-3 px-2 text-center w-[120px] min-w-[120px] max-w-[120px]">
                                <div class="text-[11px] font-extrabold text-[#1b355a] uppercase tracking-wider leading-snug">Parameter Mean</div>
                                <div class="text-[10px] text-zinc-400 font-semibold mt-0.5 leading-tight">PM</div>
                            </th>
                        </tr>
                    </thead>

                    <template x-for="(param, pIdx) in institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId)?.parameters" :key="param.id">
                        <tbody class="border-b-2 border-slate-300">
                            <!-- PARAMETER HEADER ROW -->
                            <tr class="bg-[#1b355a]">
                                <td colspan="4" class="px-5 py-2.5 text-xs font-extrabold text-white uppercase tracking-wide">
                                    <span x-text="'PARAMETER ' + param.code + ': ' + param.title"></span>
                                </td>
                            </tr>

                            <!-- ── SYSTEM – INPUTS AND PROCESSES ── -->
                            <tr class="bg-slate-100 border-b border-slate-200">
                                <td colspan="4" class="px-5 py-1.5 text-[11px] font-extrabold text-zinc-600 uppercase tracking-wider">SYSTEM – INPUTS AND PROCESSES</td>
                            </tr>
                            <template x-for="ind in param.sections.system" :key="ind.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3 text-sm text-[#1b355a] border-r border-slate-200">
                                        <div class="flex items-start gap-3">
                                            <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                            <span class="leading-relaxed" x-text="ind.statement"></span>
                                        </div>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]">
                                        <select
                                            disabled
                                            :value="selfSurveyRatings[ind.id] ?? ''"
                                            class="w-14 mx-auto text-center text-xs font-bold text-[#1b355a] bg-slate-100 border border-slate-200 rounded-lg py-1 cursor-not-allowed opacity-80 block">
                                            <option value=""></option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-[170px] min-w-[170px] max-w-[170px]"></td>
                                    <td class="text-center p-1 w-[120px] min-w-[120px] max-w-[120px]"></td>
                                </tr>
                            </template>
                            <!-- System mean row — label RIGHT-ALIGNED -->
                            <tr class="bg-blue-50/60 border-b border-slate-200">
                                <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200 text-right">System mean</td>
                                <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-[170px] min-w-[170px] max-w-[170px]">
                                    <span class="text-sm font-extrabold text-[#1b355a]" x-text="sectionMean(param.sections.system) ?? ''"></span>
                                </td>
                                <td class="text-center p-1 w-[120px] min-w-[120px] max-w-[120px]"></td>
                            </tr>

                            <!-- ── IMPLEMENTATION ── -->
                            <tr class="bg-slate-100 border-b border-slate-200">
                                <td colspan="4" class="px-5 py-1.5 text-[11px] font-extrabold text-zinc-600 uppercase tracking-wider">IMPLEMENTATION</td>
                            </tr>
                            <template x-for="ind in param.sections.implementation" :key="ind.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3 text-sm text-[#1b355a] border-r border-slate-200">
                                        <div class="flex items-start gap-3">
                                            <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                            <span class="leading-relaxed" x-text="ind.statement"></span>
                                        </div>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]">
                                        <select
                                            disabled
                                            :value="selfSurveyRatings[ind.id] ?? ''"
                                            class="w-14 mx-auto text-center text-xs font-bold text-[#1b355a] bg-slate-100 border border-slate-200 rounded-lg py-1 cursor-not-allowed opacity-80 block">
                                            <option value=""></option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-[170px] min-w-[170px] max-w-[170px]"></td>
                                    <td class="text-center p-1 w-[120px] min-w-[120px] max-w-[120px]"></td>
                                </tr>
                            </template>
                            <!-- Implementation mean row — label RIGHT-ALIGNED -->
                            <tr class="bg-blue-50/60 border-b border-slate-200">
                                <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200 text-right">Implementation mean</td>
                                <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-[170px] min-w-[170px] max-w-[170px]">
                                    <span class="text-sm font-extrabold text-[#1b355a]" x-text="sectionMean(param.sections.implementation) ?? ''"></span>
                                </td>
                                <td class="text-center p-1 w-[120px] min-w-[120px] max-w-[120px]"></td>
                            </tr>

                            <!-- ── OUTCOME/S ── -->
                            <tr class="bg-slate-100 border-b border-slate-200">
                                <td colspan="4" class="px-5 py-1.5 text-[11px] font-extrabold text-zinc-600 uppercase tracking-wider">OUTCOME/S</td>
                            </tr>
                            <template x-for="ind in param.sections.outcome" :key="ind.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-3 text-sm text-[#1b355a] border-r border-slate-200">
                                        <div class="flex items-start gap-3">
                                            <span class="font-bold shrink-0 text-zinc-500 mt-0.5 w-8" x-text="ind.code + '.'"></span>
                                            <span class="leading-relaxed" x-text="ind.statement"></span>
                                        </div>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]">
                                        <select
                                            disabled
                                            :value="selfSurveyRatings[ind.id] ?? ''"
                                            class="w-14 mx-auto text-center text-xs font-bold text-[#1b355a] bg-slate-100 border border-slate-200 rounded-lg py-1 cursor-not-allowed opacity-80 block">
                                            <option value=""></option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                    <td class="border-r border-slate-200 text-center p-1 w-[170px] min-w-[170px] max-w-[170px]"></td>
                                    <td class="text-center p-1 w-[120px] min-w-[120px] max-w-[120px]"></td>
                                </tr>
                            </template>
                            <!-- Outcome mean row — label RIGHT-ALIGNED -->
                            <tr class="bg-blue-50/60 border-b border-slate-200">
                                <td class="px-5 py-2 text-xs font-semibold text-zinc-400 italic border-r border-slate-200 text-right">Outcome mean</td>
                                <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-[170px] min-w-[170px] max-w-[170px]">
                                    <span class="text-sm font-extrabold text-[#1b355a]" x-text="sectionMean(param.sections.outcome) ?? ''"></span>
                                </td>
                                <td class="text-center p-1 w-[120px] min-w-[120px] max-w-[120px]"></td>
                            </tr>

                            <!-- ── PM row — ABOVE Best Practices ── -->
                            <tr class="bg-emerald-50/80 border-b border-slate-200">
                                <td class="px-5 py-2.5 text-xs font-bold text-zinc-500 border-r border-slate-200 italic">
                                    Parameter Mean —
                                    <span class="text-[#1b355a] not-italic font-extrabold" x-text="'Parameter ' + param.code + ': ' + param.title"></span>
                                </td>
                                <td class="border-r border-slate-200 text-center p-1 w-[100px] min-w-[100px] max-w-[100px]"></td>
                                <td class="border-r border-slate-200 text-center p-1 w-[170px] min-w-[170px] max-w-[170px]"></td>
                                <td class="text-center p-1 w-[120px] min-w-[120px] max-w-[120px]">
                                    <span class="text-sm font-extrabold text-emerald-700" x-text="paramMean(param) ?? ''"></span>
                                </td>
                            </tr>

                            <!-- ── BEST PRACTICES row — BELOW Parameter Mean ── -->
                            <tr class="border-b border-slate-200 bg-amber-50/30">
                                <td colspan="4" class="px-5 py-3">
                                    <div class="flex flex-col gap-1.5">
                                        <span class="text-xs font-extrabold text-zinc-500 uppercase tracking-wide">Best Practices: <span class="text-zinc-400 font-normal normal-case">(read-only)</span></span>
                                        <textarea
                                            readonly
                                            :id="'bp_' + param.id"
                                            x-model="selfSurveyBestPractices[param.id]"
                                            rows="3"
                                            placeholder="No best practices recorded for this parameter."
                                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-zinc-700 placeholder-zinc-400 focus:outline-none cursor-not-allowed opacity-90 resize-none transition leading-relaxed">
                                        </textarea>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </template>

                    <!-- ── TOTAL RATING ROW (sum of all IR in this area) ── -->
                    <tfoot>
                        <tr class="bg-[#1b355a]/10 border-t-2 border-[#1b355a]/30">
                            <td class="px-5 py-3 text-xs font-extrabold text-[#1b355a] uppercase tracking-wide border-r border-slate-200 text-right">
                                Total Rating
                                <span class="text-zinc-400 font-normal normal-case text-[10px] ml-1">(sum of all IR)</span>
                            </td>
                            <td class="border-r border-slate-200 text-center p-2 w-[100px] min-w-[100px] max-w-[100px]">
                                <span class="text-base font-extrabold text-[#1b355a]"
                                    x-text="(() => { const area = institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId); if (!area) return ''; let total = 0; area.parameters.forEach(p => { [...(p.sections.system||[]),...(p.sections.implementation||[]),...(p.sections.outcome||[])].forEach(ind => { const v = parseFloat(selfSurveyRatings[ind.id]); if (!isNaN(v)) total += v; }); }); return total; })()">
                                </span>
                            </td>
                            <td class="border-r border-slate-200 text-center p-2 w-[170px] min-w-[170px] max-w-[170px]"></td>
                            <td class="text-center p-2 w-[120px] min-w-[120px] max-w-[120px]"></td>
                        </tr>
                        <!-- ── AREA MEAN ROW (mean of all Parameter Means) ── -->
                        <tr class="bg-emerald-600 text-white">
                            <td class="px-5 py-3 text-xs font-extrabold uppercase tracking-wide border-r border-emerald-500 text-right">
                                Area Mean
                                <span class="font-normal normal-case text-emerald-100 text-[10px] ml-1">(mean of all parameter means)</span>
                            </td>
                            <td class="border-r border-emerald-500 text-center p-2 w-[100px] min-w-[100px] max-w-[100px]"></td>
                            <td class="border-r border-emerald-500 text-center p-2 w-[170px] min-w-[170px] max-w-[170px]"></td>
                            <td class="text-center p-2 w-[120px] min-w-[120px] max-w-[120px]">
                                <span class="text-base font-extrabold"
                                    x-text="(() => { const area = institutionalSurveyAreas.find(a => a.id === selfSurveyActiveAreaId); if (!area) return ''; const means = area.parameters.map(p => paramMean(p)).filter(v => v !== null && v !== undefined && v !== ''); if (!means.length) return ''; return (means.reduce((a,b) => a + parseFloat(b), 0) / means.length).toFixed(2); })()">
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Print / Submit Actions -->
        <div class="flex items-center justify-end gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <button type="button"
                    onclick="window.print()"
                    class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-[#1b355a] font-bold text-sm rounded-xl transition cursor-pointer shadow-3xs flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                    Print / Export
                </button>
                <!-- Read-Only Badge for IQA Admin -->
                <span class="px-4 py-2 bg-slate-100 border border-slate-200 text-zinc-500 font-bold text-xs rounded-xl flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-zinc-400"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.573 16.49 16.638 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Read-Only View (IQA Admin)
                </span>
            </div>
        </div>
    </div>
</div>
