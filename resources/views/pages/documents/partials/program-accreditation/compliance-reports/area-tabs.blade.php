{{--
    Program Accreditation Compliance Reports: Area Selector Horizontal Cards
    Matches Institutional Accreditation Compliance Reports design.
--}}
<div class="flex overflow-x-auto gap-3 pb-2 w-full select-none custom-scrollbar">
    <template x-for="area in programComplianceReports" :key="area.id">
        <button type="button"
            class="flex-1 shrink-0 min-w-50 bg-white rounded-xl border p-4 text-left shadow-3xs transition cursor-pointer flex flex-col justify-between h-24"
            :class="programComplianceActiveAreaId === area.id ? 'border-primary ring-1 ring-primary/30 shadow-xs' : 'border-slate-200/60 hover:border-slate-350'"
            @click="selectProgramComplianceArea(area.id)">
            <div>
                <span class="text-label-xs font-bold text-zinc-400 uppercase tracking-wider block" x-text="area.code"></span>
                <span class="text-body-sm font-bold text-primary mt-1 leading-tight line-clamp-2 block" x-text="area.title"></span>
            </div>
            <div class="w-full mt-2">
                <div class="w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-300"
                         :class="area.progress > 0 ? 'bg-emerald-500' : 'bg-slate-200'"
                         :style="'width: ' + area.progress + '%'"></div>
                </div>
            </div>
        </button>
    </template>
</div>
