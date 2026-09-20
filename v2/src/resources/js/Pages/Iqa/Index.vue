<!--
================================================================================
IQArchive v2 — IQA Office Management Console
================================================================================
File: resources/js/Pages/Iqa/Index.vue
Role Scope: role == 'iqa_member'
Design Reference: v2/v1-design-screenshots/03-iqa-staff/01-dashboard.png
UI Component Standard: DaisyUI 5 (card, table, badge, stats, alert, btn)
Architecture: Composed modular dashboard partials under the 150-line rule.
================================================================================
-->

<script setup>
import { Head } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import IqaPendingBanner from '@/Pages/Iqa/Partials/IqaPendingBanner.vue';
import IqaMetricCards from '@/Pages/Iqa/Partials/IqaMetricCards.vue';
import IqaSubmissionsTable from '@/Pages/Iqa/Partials/IqaSubmissionsTable.vue';
import IqaQuickActions from '@/Pages/Iqa/Partials/IqaQuickActions.vue';
import IqaPerformanceLevels from '@/Pages/Iqa/Partials/IqaPerformanceLevels.vue';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            pending_verification: 0,
            pending_compliance: 3,
            upcoming_expirations: 127,
            complied: 0,
            overall_compliance_rate: 0,
        }),
    },
    recentSubmissions: {
        type: Array,
        default: () => [],
    },
    performance: {
        type: Object,
        default: () => ({
            level_iv: 11,
            level_iii: 32,
            level_ii: 35,
            level_i: 38,
            candidate: 4,
            total_accredited: 116,
        }),
    },
});
</script>

<template>
    <Head title="IQA Staff Dashboard — IQArchive" />

    <AppShell>
        <div class="space-y-6 max-w-7xl mx-auto">
            <!-- 1. Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2">
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                        IQA Staff Dashboard
                    </h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        Institutional Quality Assurance Portal Overview
                    </p>
                </div>
            </div>

            <!-- 2. Action Banner: Pending Verification Alert -->
            <IqaPendingBanner :pending-count="stats.pending_verification" />

            <!-- 3. Key Operational Metric Cards -->
            <IqaMetricCards :stats="stats" />

            <!-- 4. Two-Column Workspace Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Recent Document Submissions Table -->
                <div class="lg:col-span-2 space-y-6">
                    <IqaSubmissionsTable :submissions="recentSubmissions" />
                </div>

                <!-- Right Column: Quick Actions & Program Level Distribution -->
                <div class="space-y-6">
                    <IqaQuickActions />
                    <IqaPerformanceLevels :performance="performance" />
                </div>
            </div>
        </div>
    </AppShell>
</template>
