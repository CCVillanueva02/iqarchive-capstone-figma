<!--
================================================================================
IQArchive v2 — IQA Program Performance Level Distribution
================================================================================
File: resources/js/Pages/Iqa/Partials/IqaPerformanceLevels.vue
Role: Renders accredited program distribution breakdown by AACCUP levels.
================================================================================
-->

<script setup>
defineProps({
    performance: {
        type: Object,
        default: () => ({
            level_iv: 0,
            level_iii: 0,
            level_ii: 0,
            level_i: 0,
            candidate: 0,
            total_accredited: 0,
        }),
    },
});
</script>

<template>
    <div class="card card-border bg-base-100 shadow-xs rounded-2xl p-5 space-y-4">
        <div class="flex items-center justify-between">
            <div class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                Program Performance
            </div>
            <!-- Filter Pill Badges -->
            <div class="join">
                <button type="button" class="join-item btn btn-xs btn-active bg-[#0B1B3D] text-white border-0 text-[10px]">
                    Levels
                </button>
                <button type="button" class="join-item btn btn-xs btn-ghost text-slate-500 text-[10px]">
                    Degrees
                </button>
                <button type="button" class="join-item btn btn-xs btn-ghost text-slate-500 text-[10px]">
                    Status
                </button>
            </div>
        </div>

        <!-- 2x3 Grid of Levels -->
        <div class="grid grid-cols-2 gap-3">
            <div class="card bg-slate-50/80 border border-slate-200/70 p-3 rounded-xl text-center">
                <div class="text-xl font-extrabold text-slate-900 tabular-nums">
                    {{ performance.level_iv }}
                </div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">
                    Level IV
                </div>
            </div>

            <div class="card bg-slate-50/80 border border-slate-200/70 p-3 rounded-xl text-center">
                <div class="text-xl font-extrabold text-slate-900 tabular-nums">
                    {{ performance.level_iii }}
                </div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">
                    Level III
                </div>
            </div>

            <div class="card bg-slate-50/80 border border-slate-200/70 p-3 rounded-xl text-center">
                <div class="text-xl font-extrabold text-slate-900 tabular-nums">
                    {{ performance.level_ii }}
                </div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">
                    Level II
                </div>
            </div>

            <div class="card bg-slate-50/80 border border-slate-200/70 p-3 rounded-xl text-center">
                <div class="text-xl font-extrabold text-slate-900 tabular-nums">
                    {{ performance.level_i }}
                </div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">
                    Level I
                </div>
            </div>

            <div class="card bg-slate-50/80 border border-slate-200/70 p-3 rounded-xl text-center">
                <div class="text-xl font-extrabold text-slate-900 tabular-nums">
                    {{ performance.candidate }}
                </div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">
                    Candidate
                </div>
            </div>

            <div class="card bg-orange-50/80 border border-orange-200/80 p-3 rounded-xl text-center">
                <div class="text-xl font-extrabold text-bu-orange-500 tabular-nums">
                    {{ performance.total_accredited }}
                </div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-orange-700 mt-0.5">
                    Total Accredited
                </div>
            </div>
        </div>
    </div>
</template>
