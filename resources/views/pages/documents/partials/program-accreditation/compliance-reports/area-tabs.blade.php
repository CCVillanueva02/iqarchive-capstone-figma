{{--
    Program Accreditation Compliance Reports: Area Selector Horizontal Cards
    Enables switching between the 10 AACCUP accreditation areas with progress indicators.
--}}
<div class="flex overflow-x-auto gap-3 pb-2 w-full select-none custom-scrollbar">
    <template x-for="area in programComplianceReports" :key="area.id">
        <button type="button"
                class="flex-1 shrink-0 min-w-52.5 max-w-60 bg-white rounded-xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24 relative"
                :class="programComplianceActiveAreaId === area.id ? 'border-primary ring-2 ring-primary/20 bg-primary/2 shadow-xs' : 'border-slate-200/70 hover:border-slate-350 hover:bg-slate-50/50'"
                @click="selectProgramComplianceArea(area.id)">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                    <span class="text-label-xs font-extrabold px-1.5 py-0.5 rounded"
                          :class="programAreaStats(area).complied === programAreaStats(area).total ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-zinc-600'"
                          x-text="programAreaStats(area).complied + '/' + programAreaStats(area).total + ' Complied'"></span>
                </div>
                <span class="text-body-sm font-bold text-primary mt-1 leading-tight line-clamp-2 block" x-text="area.title"></span>
            </div>
            <div class="w-full mt-2">
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-300"
                         :style="'width: ' + area.progress + '%'"></div>
                </div>
            </div>
        </button>
    </template>
</div>
