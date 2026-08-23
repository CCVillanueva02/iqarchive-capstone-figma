{{--
    Program Accreditation Compliance Reports: Recommendations List
    Displays recommendation cards for the active AACCUP area with search, filter, actions taken, and supporting document chips.
--}}
<div class="flex flex-col gap-4">
    <!-- Search & Filter Controls -->
    <div class="bg-white border border-slate-200/70 rounded-2xl p-4 shadow-3xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <!-- Area Title Block -->
        <div class="flex items-center gap-2.5">
            <span class="px-2.5 py-1 rounded-lg bg-primary text-white font-extrabold text-label-xs uppercase tracking-wider shrink-0"
                  x-text="activeProgramComplianceArea?.code"></span>
            <h3 class="text-heading-sm font-extrabold text-primary truncate"
                x-text="activeProgramComplianceArea?.title"></h3>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Search Input -->
            <div class="relative min-w-55 flex-1 md:flex-initial">
                <x-lucide-search class="w-4 h-4 text-zinc-400 absolute left-3 top-1/2 -translate-y-1/2" />
                <input type="text"
                       x-model="programComplianceSearch"
                       placeholder="Search actions, files, remarks..."
                       class="w-full pl-9 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-body-sm text-zinc-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" />
                <template x-if="programComplianceSearch">
                    <button type="button" @click="programComplianceSearch = ''" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600">
                        <x-lucide-x class="w-3.5 h-3.5" />
                    </button>
                </template>
            </div>

            <!-- Status Filter Dropdown / Pills -->
            <select x-model="programComplianceFilter"
                    class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-body-sm font-bold text-primary focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition cursor-pointer">
                <option value="all">All Statuses</option>
                <option value="Fully complied">Fully Complied</option>
                <option value="Partial">Partial / In Progress</option>
                <option value="Not started">Not Started</option>
            </select>
        </div>
    </div>

    <!-- Recommendations Cards Loop -->
    <div class="flex flex-col gap-4">
        <template x-for="rec in filteredProgramRecommendations(activeProgramComplianceArea)" :key="rec.id">
            <div class="bg-white border border-slate-200/70 rounded-2xl shadow-3xs overflow-hidden transition hover:shadow-xs">
                <!-- Card Header: Number, Statement, Status Badge -->
                <div class="flex items-start justify-between gap-4 p-5 pb-0">
                    <div class="flex items-start gap-3.5 flex-1">
                        <span class="shrink-0 w-8 h-8 rounded-xl flex items-center justify-center text-body-sm font-extrabold"
                              :class="{
                                  'bg-emerald-50 text-emerald-700 border border-emerald-200': rec.status === 'Fully complied',
                                  'bg-amber-50 text-amber-700 border border-amber-200': rec.status === 'Partial',
                                  'bg-rose-50 text-rose-700 border border-rose-200': rec.status === 'Not started'
                              }"
                              x-text="rec.id"></span>
                        <div>
                            <span class="text-label-xs font-bold uppercase tracking-wider text-zinc-400 block mb-0.5">Recommendation Statement</span>
                            <p class="text-body font-semibold text-primary leading-relaxed" x-text="rec.text"></p>
                        </div>
                    </div>
                    <span class="shrink-0 px-3 py-1 rounded-full text-label-xs font-bold whitespace-nowrap"
                          :class="{
                              'bg-green-100 text-green-700 border border-green-200': rec.status === 'Fully complied',
                              'bg-amber-100 text-amber-800 border border-amber-200': rec.status === 'Partial',
                              'bg-rose-100 text-rose-700 border border-rose-200': rec.status === 'Not started'
                          }"
                          x-text="rec.status"></span>
                </div>

                <!-- Card Body: Actions Taken & Supporting Documents -->
                <div class="p-5 pt-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column: Actions Taken -->
                        <div class="flex flex-col gap-2">
                            <span class="text-label font-bold text-zinc-400 uppercase tracking-wider block">Actions Taken & Implementation</span>
                            <template x-if="rec.actions && rec.actions.length > 0">
                                <ul class="space-y-2">
                                    <template x-for="(action, idx) in rec.actions" :key="idx">
                                        <li class="flex items-start gap-2.5 text-body-sm text-zinc-700 leading-relaxed bg-slate-50/60 p-2.5 rounded-lg border border-slate-150">
                                            <x-lucide-check-circle-2 class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
                                            <span x-text="action"></span>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                            <template x-if="!rec.actions || rec.actions.length === 0">
                                <div class="text-body-sm text-zinc-400 italic py-2">No corrective actions logged yet.</div>
                            </template>
                        </div>

                        <!-- Right Column: Supporting Documents Attached -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <span class="text-label font-bold text-zinc-400 uppercase tracking-wider block"
                                      x-text="'Supporting Documents (' + (rec.documents ? rec.documents.length : 0) + ')'"></span>
                            </div>

                            <template x-if="rec.documents && rec.documents.length > 0">
                                <div class="flex flex-col gap-2">
                                    <!-- Documents List (first 2 or all if expanded) -->
                                    <template x-for="doc in (programComplianceExpandedDocs[rec.id] ? rec.documents : rec.documents.slice(0, 2))" :key="doc.name">
                                        <div class="flex items-center justify-between p-3 bg-white border border-slate-200/80 rounded-xl text-body-sm gap-3 shadow-3xs hover:border-primary/40 transition">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <x-lucide-file-text class="w-4 h-4 text-rose-500 shrink-0" />
                                                <div class="min-w-0">
                                                    <span class="font-bold text-primary truncate block" x-text="doc.name"></span>
                                                    <span class="text-label-xs text-zinc-400 block" x-text="(doc.size || 'PDF') + ' • ' + (doc.date || 'Verified Exhibit')"></span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 shrink-0">
                                                <span class="px-2 py-0.5 rounded-full text-label-xs font-bold"
                                                      :class="doc.status === 'Verified' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-amber-100 text-amber-800 border border-amber-200'"
                                                      x-text="doc.status || 'Verified'"></span>
                                                <!-- Click to open in document slide-over drawer -->
                                                <button type="button"
                                                        @click="openDoc(doc)"
                                                        class="p-1.5 rounded-lg text-primary hover:bg-slate-100 transition cursor-pointer"
                                                        title="View Document Details">
                                                    <x-lucide-eye class="w-4 h-4 text-primary" />
                                                </button>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Expand / Collapse Toggle -->
                                    <template x-if="rec.documents.length > 2">
                                        <button type="button"
                                                @click="toggleProgramDocExpand(rec.id)"
                                                class="text-label font-bold text-primary hover:underline cursor-pointer py-1 w-fit flex items-center gap-1">
                                            <span x-text="programComplianceExpandedDocs[rec.id] ? 'Show fewer documents' : '+ View ' + (rec.documents.length - 2) + ' more attached documents'"></span>
                                        </button>
                                    </template>
                                </div>
                            </template>

                            <template x-if="!rec.documents || rec.documents.length === 0">
                                <div class="text-body-sm text-zinc-400 italic py-2">No supporting documents attached yet.</div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Card Footer: Official Evaluator Remarks -->
                <div class="px-5 pb-5 -mt-1" x-show="rec.remarks">
                    <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-3.5 flex items-start gap-2.5">
                        <x-lucide-message-square class="w-4 h-4 text-primary shrink-0 mt-0.5" />
                        <div class="min-w-0">
                            <span class="text-label-xs font-bold text-primary uppercase tracking-wider block mb-0.5">Assessor & Compliance Remarks</span>
                            <p class="text-body-sm text-zinc-600 leading-relaxed" x-text="rec.remarks"></p>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Empty State when filter or search returns 0 -->
        <template x-if="filteredProgramRecommendations(activeProgramComplianceArea).length === 0">
            <div class="flex flex-col items-center justify-center text-center p-12 bg-white border border-slate-200/70 rounded-2xl shadow-3xs gap-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-zinc-400 flex items-center justify-center">
                    <x-lucide-filter-x class="w-6 h-6" />
                </div>
                <h4 class="text-heading-sm font-extrabold text-primary">No matching recommendations found</h4>
                <p class="text-body-sm text-zinc-500 max-w-md">No compliance recommendations match your search query or filter in this area.</p>
                <button type="button"
                        @click="programComplianceSearch = ''; programComplianceFilter = 'all'"
                        class="mt-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-primary font-bold text-body-sm rounded-xl transition cursor-pointer">
                    Clear Filters
                </button>
            </div>
        </template>
    </div>
</div>
