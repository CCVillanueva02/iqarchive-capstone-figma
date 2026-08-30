{{--
    Program Accreditation Compliance Reports: Recommendation Cards
    Matches Institutional Accreditation Compliance Reports design.
--}}
<div class="flex flex-col gap-4">
    <template x-for="rec in activeProgramComplianceArea?.recommendations || []" :key="rec.id">
        <div class="bg-white border border-slate-200/60 rounded-xl shadow-3xs overflow-hidden">

            <!-- Recommendation Header -->
            <div class="flex items-start justify-between gap-4 p-5 pb-0">
                <div class="flex items-start gap-3 flex-1">
                    <span class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-extrabold"
                          :class="{
                              'bg-emerald-50 text-emerald-700': rec.status === 'Fully complied',
                              'bg-amber-50 text-amber-700': rec.status === 'Partial',
                              'bg-rose-50 text-rose-600': rec.status === 'Not started'
                          }"
                          x-text="rec.id"></span>
                    <p class="text-sm font-semibold text-primary leading-relaxed pt-1" x-text="rec.text"></p>
                </div>
                <span class="shrink-0 px-3 py-1 rounded-full text-label-xs font-bold whitespace-nowrap"
                      :class="{
                          'bg-emerald-50 text-emerald-700 border border-emerald-200': rec.status === 'Fully complied',
                          'bg-amber-50 text-amber-700 border border-amber-200': rec.status === 'Partial',
                          'bg-rose-50 text-rose-600 border border-rose-200': rec.status === 'Not started'
                      }"
                      x-text="rec.status"></span>
            </div>

            <!-- Actions Taken & Supporting Documents -->
            <div class="p-5 pt-4">
                <div class="flex flex-col lg:flex-row gap-6">

                    <!-- Actions Taken Column -->
                    <div class="flex-1 min-w-0" x-show="rec.actions && rec.actions.length > 0">
                        <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block mb-2">Actions Taken</span>
                        <ul class="space-y-1.5">
                            <template x-for="(action, idx) in rec.actions" :key="idx">
                                <li class="flex items-start gap-2 text-sm text-zinc-600 leading-relaxed">
                                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-300 shrink-0 mt-1.75"></span>
                                    <span x-text="action"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <!-- Supporting Documents Column -->
                    <div class="flex-1 min-w-0">
                        <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block mb-2"
                              x-text="'Supporting Documents (' + (rec.documents ? rec.documents.length : 0) + ')'"></span>

                        <template x-if="rec.documents && rec.documents.length > 0">
                            <div class="flex flex-col gap-2">
                                <!-- Show first 2 documents always -->
                                <template x-for="(doc, dIdx) in (programComplianceExpandedDocs[rec.id] ? rec.documents : rec.documents.slice(0, 2))" :key="doc.name">
                                    <div @click="openDoc(doc)" class="flex items-center justify-between p-3 bg-slate-50/60 border border-slate-150 rounded-lg text-sm gap-3 cursor-pointer hover:bg-slate-100/70 transition">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-rose-400 shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                            <span class="font-semibold text-primary truncate" x-text="doc.name"></span>
                                        </div>
                                        <span class="shrink-0 px-2 py-0.5 rounded-full text-label-xs font-bold"
                                              :class="doc.status === 'Verified' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100'"
                                              x-text="doc.status"></span>
                                    </div>
                                </template>

                                <!-- +N more toggle -->
                                <template x-if="rec.documents.length > 2">
                                    <button type="button"
                                        class="text-xs font-bold text-primary hover:text-primary-hover cursor-pointer border border-slate-200 rounded-lg px-3 py-1.5 bg-white hover:bg-slate-50 transition w-fit"
                                        @click="toggleProgramDocExpand(rec.id)"
                                        x-text="programComplianceExpandedDocs[rec.id] ? 'Show less' : '+' + (rec.documents.length - 2) + ' more'">
                                    </button>
                                </template>
                            </div>
                        </template>

                        <!-- Empty state -->
                        <template x-if="!rec.documents || rec.documents.length === 0">
                            <div class="text-xs text-zinc-400 italic py-2">No supporting documents attached yet.</div>
                        </template>
                    </div>

                </div>
            </div>

            <!-- Remarks Section -->
            <div class="px-5 pb-5 -mt-1" x-show="rec.remarks">
                <div class="bg-slate-50 border border-slate-150 rounded-lg p-3.5">
                    <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block mb-1">Remarks</span>
                    <p class="text-sm text-zinc-600 leading-relaxed" x-text="rec.remarks"></p>
                </div>
            </div>

        </div>
    </template>
</div>
