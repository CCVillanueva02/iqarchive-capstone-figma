<!--
================================================================================
IQArchive v2 — Audit Trail & Compliance Ledger Master Page
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Index.vue
Role: Main workstation view for System Admin and IQA Staff regulatory audit ledger.
UI Standard: DaisyUI / Institutional BU Blue (#0038A8). Line count < 150.
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import AuditTabs from './Partials/AuditTabs.vue';
import AuditFilterBar from './Partials/AuditFilterBar.vue';
import AuditLogsTable from './Partials/AuditLogsTable.vue';
import AuditDetailDrawer from './Partials/AuditDetailDrawer.vue';
import { Download, ChevronRight } from 'lucide-vue-next';
import {
    TABS,
    CURATED_LOGS,
    humanAction,
    deriveSeverity,
    SEV_LABEL,
} from './auditData.js';

const props = defineProps({
    auditLogs: {
        type: Object,
        default: () => ({ data: [] }),
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

const activeTabKey = ref('all');
const activeSubKey = ref('all');
const search = ref(props.filters?.search || '');
const sevFilter = ref(props.filters?.severity || '');
const selectedLog = ref(null);
const isDrawerOpen = ref(false);

const allLogs = computed(() => {
    if (props.auditLogs?.data && props.auditLogs.data.length > 0) {
        return props.auditLogs.data;
    }
    return CURATED_LOGS;
});

const activeTab = computed(() => TABS.find((t) => t.key === activeTabKey.value) || TABS[0]);
const activeSubTab = computed(() => {
    if (!activeTab.value?.subtabs) return null;
    return activeTab.value.subtabs.find((s) => s.key === activeSubKey.value) || null;
});

function switchTab(key) {
    activeTabKey.value = key;
    activeSubKey.value = 'all';
    search.value = '';
    sevFilter.value = '';
}

function switchSubTab(key) {
    activeSubKey.value = key;
    search.value = '';
    sevFilter.value = '';
}

const tabCounts = computed(() => {
    const counts = {};
    for (const tab of TABS) {
        counts[tab.key] = allLogs.value.filter((l) => tab.match(l.action)).length;
    }
    return counts;
});

const subTabCounts = computed(() => {
    if (!activeTab.value?.subtabs) return {};
    const base = allLogs.value.filter((l) => activeTab.value.match(l.action));
    const counts = {};
    for (const sub of activeTab.value.subtabs) {
        counts[sub.key] = base.filter((l) => sub.match(l.action)).length;
    }
    return counts;
});

const filteredLogs = computed(() => {
    return allLogs.value.filter((log) => {
        if (!activeTab.value.match(log.action)) return false;
        if (activeSubTab.value && !activeSubTab.value.match(log.action)) return false;
        const q = search.value.toLowerCase().trim();
        if (q) {
            const matches = [
                humanAction(log.action),
                log.action,
                log.user?.name || '',
                log.user?.email || '',
                String(log.details?.title || ''),
                String(log.details?.email || ''),
                String(log.details?.area || ''),
                String(log.ip_address || ''),
                String(log.target_id || ''),
            ].some((v) => v.toLowerCase().includes(q));
            if (!matches) return false;
        }
        if (sevFilter.value && deriveSeverity(log.action) !== sevFilter.value) {
            return false;
        }
        return true;
    });
});

const hasFilters = computed(() => Boolean(search.value || sevFilter.value));

function clearFilters() {
    search.value = '';
    sevFilter.value = '';
}

function openDrawer(log) {
    selectedLog.value = log;
    isDrawerOpen.value = true;
}

function closeDrawer() {
    isDrawerOpen.value = false;
}

function exportCSV() {
    const rows = filteredLogs.value.map((r) => [
        r.id,
        `"${new Date(r.created_at).toLocaleString()}"`,
        `"${humanAction(r.action)}"`,
        `"${r.user?.name || 'System'}"`,
        `"${r.details?.title || (r.target_type ? r.target_type.split('\\').pop() : '') || ''}"`,
        `"${r.college?.name || 'University-Wide'}"`,
        `"${SEV_LABEL[deriveSeverity(r.action)] || 'Info'}"`,
    ].join(','));
    const headers = ['ID', 'Date & Time', 'Event', 'Performed By', 'Affected', 'College', 'Status'];
    const csv = [headers.join(','), ...rows].join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `AuditTrail_${activeTabKey.value}_${new Date().toISOString().slice(0, 10)}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>

<template>
    <Head title="Audit Trail & Compliance Ledger — IQArchive" />

    <AppShell :hide-breadcrumbs="true">
        <div class="h-[calc(100vh-6.5rem)] flex flex-col gap-4 max-w-7xl mx-auto w-full">
            <!-- Page Header Outside Card -->
            <div class="shrink-0">
                <nav class="flex items-center gap-1.5 text-xs text-slate-500 mb-2">
                    <span>Administration</span>
                    <ChevronRight :size="11" class="text-slate-400" />
                    <span class="font-semibold text-slate-800">System Audit Trail</span>
                </nav>
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h1 class="text-[22px] font-bold tracking-tight text-slate-900 leading-tight">
                            Audit Trail &amp; Compliance Ledger
                        </h1>
                        <p class="text-xs text-slate-500 mt-1">
                            Immutable operational activity records and regulatory verification history.
                        </p>
                    </div>
                    <button
                        type="button"
                        @click="exportCSV"
                        class="flex items-center gap-1.5 text-xs font-semibold border border-slate-300 text-slate-700 bg-white px-4 py-2 rounded-lg hover:border-slate-400 hover:shadow-xs transition-all shrink-0 mb-0.5 cursor-pointer"
                        title="Export compliance audit records as CSV"
                    >
                        <Download :size="13" />
                        <span>Export CSV</span>
                    </button>
                </div>
            </div>

            <!-- Main Card Container: Tabs + Filter Row + Table + Footer -->
            <div class="flex flex-col flex-1 min-h-0 rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
                <AuditTabs
                    :tabs="TABS"
                    :active-tab-key="activeTabKey"
                    :tab-counts="tabCounts"
                    @select-tab="switchTab"
                />

                <AuditFilterBar
                    :subtabs="activeTab.subtabs || null"
                    :active-sub-key="activeSubKey"
                    :sub-tab-counts="subTabCounts"
                    :search="search"
                    :sev-filter="sevFilter"
                    :result-count="filteredLogs.length"
                    :has-filters="hasFilters"
                    @select-subtab="switchSubTab"
                    @update:search="(val) => (search = val)"
                    @update:sev-filter="(val) => (sevFilter = val)"
                    @clear-filters="clearFilters"
                />

                <AuditLogsTable
                    :logs="filteredLogs"
                    :total="allLogs.length"
                    :selected-id="selectedLog?.id || null"
                    :has-filters="hasFilters"
                    @select-log="openDrawer"
                    @clear-filters="clearFilters"
                />
            </div>
        </div>

        <!-- Slide-over Detail Drawer -->
        <AuditDetailDrawer
            :is-open="isDrawerOpen"
            :log="selectedLog"
            @close="closeDrawer"
        />
    </AppShell>
</template>
