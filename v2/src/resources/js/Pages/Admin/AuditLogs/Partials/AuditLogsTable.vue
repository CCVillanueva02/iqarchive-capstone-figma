<!--
================================================================================
IQArchive v2 — Audit Logs Table Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditLogsTable.vue
Role: Displays immutable audit records in a pinned-header DaisyUI data table.
UI Standard: DaisyUI table, badge, btn; Lucide icons.
Line count target: < 190 lines.
================================================================================
-->

<script setup>
import { Eye, ShieldCheck, ChevronLeft, ChevronRight } from 'lucide-vue-next';

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
        <!-- Pinned Header Table Container -->
        <div class="overflow-x-auto overflow-y-auto flex-1 min-h-0">
            <table class="table table-zebra table-sm table-pin-rows w-full">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase bg-slate-50/90 tracking-wider">
                        <th class="py-3 pl-4">Timestamp</th>
                        <th>Initiated By</th>
                        <th>Event / Action</th>
                        <th>Target Entity</th>
                        <th>College</th>
                        <th>IP Address</th>
                        <th>Severity</th>
                        <th class="text-right pr-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="log in logs"
                        :key="log.id"
                        @click="emit('selectLog', log)"
                        :class="[
                            'cursor-pointer transition-colors',
                            selectedLogId === log.id ? 'bg-primary/5 font-medium' : 'hover:bg-slate-50/80'
                        ]"
                    >
                        <!-- Timestamp -->
                        <td class="py-3 pl-4 font-mono text-xs tabular-nums text-slate-600 whitespace-nowrap">
                            <div>{{ formatDate(log.created_at).date }}</div>
                            <div class="text-[11px] text-slate-400">{{ formatDate(log.created_at).time }}</div>
                        </td>

                        <!-- Initiated By -->
                        <td class="text-xs">
                            <div v-if="log.user" class="space-y-0.5">
                                <div class="font-bold text-slate-800 line-clamp-1">{{ log.user.name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ log.user.email }}</div>
                            </div>
                            <div v-else class="text-slate-400 italic font-mono text-[11px]">
                                System / Unauthenticated
                            </div>
                        </td>

                        <!-- Event / Action -->
                        <td>
                            <div class="space-y-0.5">
                                <span class="badge badge-xs font-mono font-semibold text-slate-700 bg-slate-100 border border-slate-200">
                                    {{ log.action }}
                                </span>
                                <div class="text-[11px] text-slate-500 line-clamp-1">
                                    {{ formatActionTitle(log.action) }}
                                </div>
                            </div>
                        </td>

                        <!-- Target Entity -->
                        <td class="text-xs">
                            <span class="font-medium text-slate-700">
                                {{ getEntityName(log.target_type) }} #{{ log.target_id || 'N/A' }}
                            </span>
                            <div v-if="log.details?.title" class="text-[11px] text-slate-400 line-clamp-1">
                                {{ log.details.title }}
                            </div>
                        </td>

                        <!-- College Scope -->
                        <td>
                            <span v-if="log.college" class="badge badge-xs badge-ghost font-semibold text-slate-600">
                                {{ log.college.code }}
                            </span>
                            <span v-else class="badge badge-xs badge-neutral badge-soft text-slate-400">
                                Univ-Wide
                            </span>
                        </td>

                        <!-- IP Address -->
                        <td class="font-mono text-[11px] tabular-nums text-slate-500 whitespace-nowrap">
                            {{ log.ip_address || '—' }}
                        </td>

                        <!-- Severity -->
                        <td>
                            <span :class="['badge badge-xs font-semibold capitalize', getSeverityBadge(log.severity)]">
                                {{ log.severity }}
                            </span>
                        </td>

                        <!-- Action Inspect Button -->
                        <td class="text-right pr-4">
                            <button
                                type="button"
                                @click.stop="emit('selectLog', log)"
                                class="btn btn-xs btn-ghost text-slate-500 hover:text-primary gap-1"
                                title="Inspect audit entry details"
                            >
                                <Eye class="w-3.5 h-3.5" />
                                <span>Inspect</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Empty State -->
                    <tr v-if="logs.length === 0">
                        <td colspan="8" class="py-14 text-center">
                            <div class="flex flex-col items-center justify-center space-y-2 max-w-sm mx-auto">
                                <ShieldCheck class="w-10 h-10 text-slate-300" />
                                <p class="text-xs font-bold text-slate-700">No audit records found</p>
                                <p class="text-[11px] text-slate-400 leading-relaxed">
                                    No compliance logs match the selected filters. Clear the search or date query to view all entries.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pinned Pagination Footer -->
        <div
            v-if="pagination && pagination.total > 0"
            class="px-4 py-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 bg-slate-50/50 shrink-0"
        >
            <div class="tabular-nums">
                Showing <span class="font-bold text-slate-700">{{ pagination.from || 0 }}</span> to
                <span class="font-bold text-slate-700">{{ pagination.to || 0 }}</span> of
                <span class="font-bold text-slate-700">{{ pagination.total }}</span> events
            </div>

            <div class="flex items-center gap-1.5">
                <button
                    v-for="(link, i) in pagination.links"
                    :key="i"
                    type="button"
                    :disabled="!link.url || link.active"
                    @click="link.url && emit('paginate', link.url)"
                    :class="[
                        'btn btn-xs',
                        link.active ? 'btn-primary text-white' : 'btn-ghost text-slate-600',
                        !link.url ? 'btn-disabled opacity-40' : ''
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </div>
</template>
