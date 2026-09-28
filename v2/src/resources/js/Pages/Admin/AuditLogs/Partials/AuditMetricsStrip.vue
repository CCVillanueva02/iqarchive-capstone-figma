<!--
================================================================================
IQArchive v2 — Audit Metrics Strip Partial (Distilled Minimalist View)
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditMetricsStrip.vue
Role: Displays compact, high-contrast 24h operational KPIs.
UI Standard: DaisyUI card, tabular numerals; zero decorative clutter.
Line count target: < 60 lines.
================================================================================
-->

<script setup>
defineProps({
    metrics: {
        type: Object,
        default: () => ({
            total_today: 0,
            document_mutations: 0,
            security_events: 0,
            active_tenants: 0,
        }),
    },
});
</script>

<template>
    <div class="card card-border bg-base-100 shadow-xs py-2.5 px-5 grid grid-cols-2 lg:grid-cols-4 gap-4 divide-y lg:divide-y-0 lg:divide-x divide-slate-100 shrink-0">
        <!-- 1. 24h Activity -->
        <div class="flex flex-col justify-center">
            <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">24h Activity</span>
            <div class="text-lg font-bold text-slate-900 tabular-nums">
                {{ (metrics.total_today || 0).toLocaleString() }}
            </div>
        </div>

        <!-- 2. Document Mutations -->
        <div class="flex flex-col justify-center pt-2 lg:pt-0 lg:pl-5">
            <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Document Events</span>
            <div class="text-lg font-bold text-primary tabular-nums">
                {{ (metrics.document_mutations || 0).toLocaleString() }}
            </div>
        </div>

        <!-- 3. Security Events -->
        <div class="flex flex-col justify-center pt-2 lg:pt-0 lg:pl-5">
            <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Security & Access</span>
            <div class="text-lg font-bold text-slate-800 tabular-nums">
                {{ (metrics.security_events || 0).toLocaleString() }}
            </div>
        </div>

        <!-- 4. Active Colleges -->
        <div class="flex flex-col justify-center pt-2 lg:pt-0 lg:pl-5">
            <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Active Colleges</span>
            <div class="text-lg font-bold text-slate-800 tabular-nums">
                {{ metrics.active_tenants || 0 }}
            </div>
        </div>
    </div>
</template>
