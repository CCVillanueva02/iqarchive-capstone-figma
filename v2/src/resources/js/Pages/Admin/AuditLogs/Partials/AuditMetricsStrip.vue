<!--
================================================================================
IQArchive v2 — Audit Metrics Strip Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditMetricsStrip.vue
Role: Displays high-level 24h operational KPIs and event rollups.
UI Standard: DaisyUI card, badge; Lucide icons.
Line count target: < 100 lines.
================================================================================
-->

<script setup>
import { Activity, FileCheck, ShieldAlert, Building2 } from 'lucide-vue-next';

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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 shrink-0">
        <!-- 1. Total Daily Activity -->
        <div class="card card-border bg-base-100 shadow-xs p-4 flex flex-row items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-xs font-medium text-slate-500">24h Event Volume</span>
                <div class="text-xl font-bold text-slate-900 tabular-nums">
                    {{ (metrics.total_today || 0).toLocaleString() }}
                </div>
                <span class="text-[11px] text-slate-400">Total recorded events today</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                <Activity class="w-5 h-5" />
            </div>
        </div>

        <!-- 2. Document & Evidence Mutations -->
        <div class="card card-border bg-base-100 shadow-xs p-4 flex flex-row items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-xs font-medium text-slate-500">Document Mutations</span>
                <div class="text-xl font-bold text-primary tabular-nums">
                    {{ (metrics.document_mutations || 0).toLocaleString() }}
                </div>
                <span class="text-[11px] text-slate-400">Uploads, endorsements, reviews</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <FileCheck class="w-5 h-5" />
            </div>
        </div>

        <!-- 3. Security & Access Events -->
        <div class="card card-border bg-base-100 shadow-xs p-4 flex flex-row items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-xs font-medium text-slate-500">Security & Access</span>
                <div class="text-xl font-bold text-amber-600 tabular-nums">
                    {{ (metrics.security_events || 0).toLocaleString() }}
                </div>
                <span class="text-[11px] text-slate-400">Logins, domain gates, alerts</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <ShieldAlert class="w-5 h-5" />
            </div>
        </div>

        <!-- 4. Active Tenant Colleges -->
        <div class="card card-border bg-base-100 shadow-xs p-4 flex flex-row items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-xs font-medium text-slate-500">Active College Tenants</span>
                <div class="text-xl font-bold text-sky-600 tabular-nums">
                    {{ metrics.active_tenants || 0 }}
                </div>
                <span class="text-[11px] text-slate-400">Colleges with activity today</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <Building2 class="w-5 h-5" />
            </div>
        </div>
    </div>
</template>
