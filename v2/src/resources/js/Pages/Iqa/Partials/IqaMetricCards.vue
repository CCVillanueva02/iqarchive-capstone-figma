<!--
================================================================================
IQArchive v2 — IQA Key Operational Metric Cards
================================================================================
File: resources/js/Pages/Iqa/Partials/IqaMetricCards.vue
Role: Renders 4 primary KPI cards (Pending, Upcoming, Complied, Overall Rate).
================================================================================
-->

<script setup>
import { AlertCircle, Clock, CheckCircle2, PieChart } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            pending_compliance: 0,
            upcoming_expirations: 0,
            complied: 0,
            overall_compliance_rate: 0,
        }),
    },
});
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- Card 1: Pending -->
        <div class="card card-border bg-base-100 shadow-xs p-5 rounded-xl flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    Pending
                </div>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <AlertCircle class="w-4 h-4" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-slate-900 tabular-nums">
                    {{ stats.pending_compliance }}
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1">
                    Awaiting for compliance
                </div>
            </div>
        </div>

        <!-- Card 2: Upcoming Compliance -->
        <div class="card card-border bg-base-100 shadow-xs p-5 rounded-xl flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    Upcoming Compliance
                </div>
                <div class="w-8 h-8 rounded-lg bg-orange-50 text-bu-orange-500 flex items-center justify-center">
                    <Clock class="w-4 h-4" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-slate-900 tabular-nums">
                    {{ stats.upcoming_expirations }}
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1">
                    Accreditation is about to expire
                </div>
            </div>
        </div>

        <!-- Card 3: Complied -->
        <div class="card card-border bg-base-100 shadow-xs p-5 rounded-xl flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    Complied
                </div>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <CheckCircle2 class="w-4 h-4" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-slate-900 tabular-nums">
                    {{ stats.complied }}
                </div>
                <div class="text-xs text-emerald-700 font-medium mt-1">
                    Accreditation met
                </div>
            </div>
        </div>

        <!-- Card 4: Overall Compliance Rate -->
        <div class="card card-border bg-base-100 shadow-xs p-5 rounded-xl flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    Overall Compliance
                </div>
                <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                    <PieChart class="w-4 h-4" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-slate-900 tabular-nums">
                    {{ stats.overall_compliance_rate }}%
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1">
                    Total university compliance rate
                </div>
            </div>
        </div>
    </div>
</template>
