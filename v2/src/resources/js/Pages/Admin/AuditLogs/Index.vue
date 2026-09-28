<!--
================================================================================
IQArchive v2 — Audit Trail & Compliance Ledger Master Page
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Index.vue
Role: System Administration & IQA audit trail workstation view.
UI Standard: DaisyUI card, badge, btn; Lucide icons.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import AuditMetricsStrip from './Partials/AuditMetricsStrip.vue';
import AuditFilterBar from './Partials/AuditFilterBar.vue';
import AuditLogsTable from './Partials/AuditLogsTable.vue';
import AuditDetailDrawer from './Partials/AuditDetailDrawer.vue';
import { Download, ShieldCheck } from 'lucide-vue-next';

const props = defineProps({
    auditLogs: {
        type: Object,
        required: true,
    },
    colleges: {
        type: Array,
        default: () => [],
    },
    metrics: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    isUniversityWide: {
        type: Boolean,
        default: true,
    },
});

const selectedLog = ref(null);
const isDrawerOpen = ref(false);

function openDrawer(log) {
    selectedLog.value = log;
    isDrawerOpen.value = true;
}

function closeDrawer() {
    isDrawerOpen.value = false;
}

function handleFilter(filterParams) {
    router.get('/admin/audit-logs', filterParams, {
        preserveState: true,
        preserveScroll: true,
    });
}

function handleReset() {
    router.get('/admin/audit-logs', {}, {
        preserveState: true,
        preserveScroll: true,
    });
}

function handlePaginate(url) {
    if (url) {
        router.visit(url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
}

function exportAuditReport() {
    // Generate downloadable CSV formatted client-side from active page or trigger backend export
    const rows = props.auditLogs.data || [];
    if (rows.length === 0) return;

    const headers = ['ID', 'Timestamp', 'Actor', 'Action', 'Target_Type', 'Target_ID', 'IP_Address', 'College'];
    const csvContent = [
        headers.join(','),
        ...rows.map((r) => [
            r.id,
            `"${r.created_at}"`,
            `"${r.user?.name || 'System'}"`,
            `"${r.action}"`,
            `"${r.target_type}"`,
            `"${r.target_id || ''}"`,
            `"${r.ip_address || ''}"`,
            `"${r.college?.code || 'Univ-Wide'}"`,
        ].join(',')),
    ].join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.setAttribute('href', url);
    link.setAttribute('download', `IQArchive_Audit_Log_${new Date().toISOString().slice(0, 10)}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<template>
    <Head title="Audit Trail & Compliance Ledger — IQArchive" />

    <AppShell :breadcrumbs="[{ label: 'Administration', href: '/admin' }, { label: 'System Audit Trail' }]">
        <div class="h-[calc(100vh-5rem)] flex flex-col space-y-3.5 max-w-7xl mx-auto w-full">
            <!-- Header Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0 pb-1">
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                        Audit Trail & Compliance Ledger
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Immutable operational activity records and regulatory verification history.
                    </p>
                </div>

                <div class="flex items-center gap-2.5">
                    <!-- Live feed pulse indicator -->
                    <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200/60 text-emerald-700 text-xs">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="font-medium text-[11px]">Audit Engine Active</span>
                    </div>

                    <!-- Export Report Button -->
                    <button
                        type="button"
                        @click="exportAuditReport"
                        class="btn btn-sm btn-outline border-sidebar-blue text-sidebar-blue hover:bg-sidebar-blue hover:border-sidebar-blue hover:text-white gap-1.5 text-xs font-semibold"
                        title="Download active compliance audit log records"
                    >
                        <Download class="w-3.5 h-3.5" />
                        <span>Export CSV</span>
                    </button>
                </div>
            </div>

            <!-- Top Metric Cards Strip -->
            <AuditMetricsStrip :metrics="metrics" />

            <!-- Core Table Card with Filter Toolbar -->
            <div class="card card-border bg-base-100 shadow-xs flex-1 min-h-0 flex flex-col overflow-hidden">
                <AuditFilterBar
                    :filters="filters"
                    :colleges="colleges"
                    :is-university-wide="isUniversityWide"
                    @filter="handleFilter"
                    @reset="handleReset"
                />

                <AuditLogsTable
                    :logs="auditLogs.data || []"
                    :pagination="auditLogs"
                    :selected-log-id="selectedLog?.id"
                    @select-log="openDrawer"
                    @paginate="handlePaginate"
                />
            </div>
        </div>

        <!-- Detail Inspection Drawer Modal -->
        <AuditDetailDrawer
            :is-open="isDrawerOpen"
            :log="selectedLog"
            @close="closeDrawer"
        />
    </AppShell>
</template>
