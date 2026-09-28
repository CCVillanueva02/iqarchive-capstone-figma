<!--
================================================================================
IQArchive v2 — Audit Logs Table Partial (Distilled Minimalist View)
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditLogsTable.vue
Role: Displays immutable audit records in a clean, highly scannable data table.
UI Standard: DaisyUI table-pin-rows, badge-soft; minimal visual noise.
Line count target: < 175 lines.
================================================================================
-->

<script setup>
import { ShieldCheck, ChevronRight } from 'lucide-vue-next';

defineProps({
    logs: {
        type: Array,
        required: true,
    },
    pagination: {
        type: Object,
        default: () => ({}),
    },
    selectedLogId: {
        type: [Number, String],
        default: null,
    },
});

const emit = defineEmits(['selectLog', 'paginate']);

function formatDate(dateStr) {
    if (!dateStr) return { date: '—', time: '' };
    const d = new Date(dateStr);
    return {
        date: d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }),
        time: d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }),
    };
}

function getEntityName(targetType) {
    if (!targetType) return 'Entity';
    const parts = targetType.split('\\');
    return parts[parts.length - 1];
}

function formatActionTitle(action) {
    if (!action) return 'System Event';
    return action
        .split('.')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' · ');
}

function getSeverityBadge(severity) {
    switch (severity) {
        case 'security':
        case 'error':
            return 'badge-error badge-soft';
        case 'warning':
            return 'badge-warning badge-soft';
        case 'success':
            return 'badge-success badge-soft';
        default:
            return 'badge-info badge-soft';
    }
}
</script>

<template>
    <div class="card card-border bg-base-100 shadow-xs flex flex-col flex-1 min-h-0 overflow-hidden">
        <!-- Pinned Header Table -->
        <div class="overflow-x-auto overflow-y-auto flex-1 min-h-0">
            <table class="table table-zebra table-sm table-pin-rows w-full">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase bg-slate-50/90 tracking-wider">
                        <th class="py-3 pl-4 w-36">Timestamp</th>
                        <th class="w-48">Initiated By</th>
                        <th class="w-64">Event / Action</th>
                        <th>Target Entity</th>
                        <th class="w-24 text-center">College</th>
                        <th class="w-24 text-center">Severity</th>
                        <th class="w-10 pr-4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="log in logs"
                        :key="log.id"
                        @click="emit('selectLog', log)"
                        :class="[
                            'group cursor-pointer transition-colors',
                            selectedLogId === log.id ? 'bg-primary/5 font-medium' : 'hover:bg-slate-50/80'
                        ]"
                    >
                        <!-- Timestamp -->
                        <td class="py-2.5 pl-4 font-mono text-xs tabular-nums text-slate-600 whitespace-nowrap">
                            <div class="font-medium text-slate-700">{{ formatDate(log.created_at).date }}</div>
                            <div class="text-[11px] text-slate-400">{{ formatDate(log.created_at).time }}</div>
                        </td>

                        <!-- Initiated By -->
                        <td class="text-xs">
                            <div v-if="log.user" class="space-y-0.5">
                                <div class="font-semibold text-slate-800 line-clamp-1">{{ log.user.name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono truncate max-w-[180px]">{{ log.user.email }}</div>
                            </div>
                            <div v-else class="text-slate-400 italic font-mono text-[11px]">
                                System Process
                            </div>
                        </td>

                        <!-- Event / Action (Plain title with action code subtext) -->
                        <td class="text-xs">
                            <div class="font-medium text-slate-800 line-clamp-1">
                                {{ formatActionTitle(log.action) }}
                            </div>
                            <div class="font-mono text-[11px] text-slate-400">
                                {{ log.action }}
                            </div>
                        </td>

                        <!-- Target Entity -->
                        <td class="text-xs">
                            <div class="font-medium text-slate-700">
                                {{ getEntityName(log.target_type) }} #{{ log.target_id || 'N/A' }}
                            </div>
                            <div v-if="log.details?.title" class="text-[11px] text-slate-400 truncate max-w-sm">
                                {{ log.details.title }}
                            </div>
                        </td>

                        <!-- College Scope -->
                        <td class="text-center">
                            <span v-if="log.college" class="badge badge-xs badge-ghost font-semibold text-slate-600">
                                {{ log.college.code }}
                            </span>
                            <span v-else class="badge badge-xs badge-neutral badge-soft text-slate-400">
                                Univ
                            </span>
                        </td>

                        <!-- Severity -->
                        <td class="text-center">
                            <span :class="['badge badge-xs font-semibold capitalize', getSeverityBadge(log.severity)]">
                                {{ log.severity }}
                            </span>
                        </td>

                        <!-- Trailing Row Indicator -->
                        <td class="text-right pr-4">
                            <ChevronRight class="w-4 h-4 text-slate-300 group-hover:text-primary transition-colors inline-block" />
                        </td>
                    </tr>

                    <!-- Minimalist Empty State -->
                    <tr v-if="logs.length === 0">
                        <td colspan="7" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-1.5 max-w-xs mx-auto">
                                <ShieldCheck class="w-8 h-8 text-slate-300" />
                                <p class="text-xs font-semibold text-slate-700">No audit records found</p>
                                <p class="text-[11px] text-slate-400">
                                    No records match your active search or filters.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Compact Pinned Footer -->
        <div
            v-if="pagination && pagination.total > 0"
            class="px-4 py-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 bg-slate-50/50 shrink-0"
        >
            <div class="tabular-nums">
                Showing <span class="font-semibold text-slate-700">{{ pagination.from || 0 }}</span>–<span class="font-semibold text-slate-700">{{ pagination.to || 0 }}</span> of
                <span class="font-semibold text-slate-700">{{ pagination.total }}</span>
            </div>

            <div class="flex items-center gap-1">
                <button
                    v-for="(link, i) in pagination.links"
                    :key="i"
                    type="button"
                    :disabled="!link.url || link.active"
                    @click="link.url && emit('paginate', link.url)"
                    :class="[
                        'btn btn-xs',
                        link.active ? 'btn-primary text-white' : 'btn-ghost text-slate-600',
                        !link.url ? 'btn-disabled opacity-30' : ''
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </div>
</template>
