<!--
================================================================================
IQArchive v2 — Audit Logs Table Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditLogsTable.vue
Role: Renders immutable audit records with clean, balanced, and even columns.
UI Standard: DaisyUI / Institutional BU Blue (#0038A8). Line count < 180.
================================================================================
-->

<script setup>
import {
    Activity,
    ChevronRight,
    ShieldCheck,
    RotateCcw,
} from 'lucide-vue-next';
import {
    deriveSeverity,
    humanAction,
    initials,
    SEV_BADGE,
    SEV_LABEL,
} from '../auditData.js';

defineProps({
    logs: {
        type: Array,
        required: true,
    },
    total: {
        type: Number,
        default: 0,
    },
    selectedId: {
        type: [Number, String],
        default: null,
    },
    hasFilters: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['selectLog', 'clearFilters']);

function formatTimestamp(ts) {
    if (!ts) return { date: '—', time: '—' };
    const d = new Date(ts);
    return {
        date: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
        time: d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }),
    };
}

function getAffectedText(log) {
    if (log.details?.title) return log.details.title;
    if (log.details?.area) return `Accreditation: ${log.details.area}`;
    if (log.details?.email) return log.details.email;
    const model = (log.target_type || 'Entity').split('\\').pop();
    return `${model} #${log.target_id ?? '—'}`;
}
</script>

<template>
    <div class="flex-1 min-h-0 flex flex-col overflow-hidden bg-white">
        <!-- Table container with fixed layout for balanced, even columns -->
        <div class="overflow-x-auto overflow-y-auto flex-1 min-h-0">
            <table class="table-fixed w-full text-sm border-collapse">
                <thead class="sticky top-0 z-10 bg-white">
                    <tr class="text-[11px] text-slate-400 uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 pl-6 w-36 font-semibold text-left whitespace-nowrap">Timestamp</th>
                        <th class="py-3 px-4 w-52 font-semibold text-left">Performed By</th>
                        <th class="py-3 px-4 w-64 font-semibold text-left">Event</th>
                        <th class="py-3 px-4 font-semibold text-left">Affected</th>
                        <th class="py-3 px-3 w-24 font-semibold text-center">College</th>
                        <th class="py-3 px-3 w-32 font-semibold text-center">Status</th>
                        <th class="py-3 pr-6 w-10 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(log, i) in logs"
                        :key="log.id"
                        @click="emit('selectLog', log)"
                        :class="[
                            'group cursor-pointer border-b border-slate-100 transition-colors',
                            selectedId === log.id
                                ? 'bg-[#0038A8]/5'
                                : (i % 2 === 1 ? 'bg-slate-50/60' : 'bg-white') + ' hover:bg-[#0038A8]/[0.03]'
                        ]"
                    >
                        <!-- Timestamp -->
                        <td class="pl-6 pr-4 py-3.5 align-middle whitespace-nowrap">
                            <div class="font-semibold text-slate-700 text-xs leading-snug">
                                {{ formatTimestamp(log.created_at).date }}
                            </div>
                            <div class="font-mono text-[11px] text-slate-400 tabular-nums mt-0.5">
                                {{ formatTimestamp(log.created_at).time }}
                            </div>
                        </td>

                        <!-- Performed By -->
                        <td class="px-4 py-3.5 align-middle">
                            <div v-if="log.user" class="flex items-center gap-2.5">
                                <div
                                    class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 text-[10px] font-extrabold text-white"
                                    style="background-color: #0038A8;"
                                >
                                    {{ initials(log.user.name) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-800 text-xs truncate">
                                        {{ log.user.name }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono truncate">
                                        {{ log.user.email }}
                                    </div>
                                </div>
                            </div>
                            <span v-else class="flex items-center gap-1.5 text-slate-400 text-xs italic">
                                <Activity :size="12" class="text-slate-300" />
                                <span>System</span>
                            </span>
                        </td>

                        <!-- Event -->
                        <td class="px-4 py-3.5 align-middle">
                            <div class="font-medium text-slate-800 text-xs leading-snug truncate">
                                {{ humanAction(log.action) }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-mono mt-0.5 truncate">
                                {{ log.action }}
                            </div>
                        </td>

                        <!-- Affected -->
                        <td class="px-4 py-3.5 align-middle">
                            <div class="text-xs text-slate-600 truncate" :title="getAffectedText(log)">
                                {{ getAffectedText(log) }}
                            </div>
                        </td>

                        <!-- College -->
                        <td class="px-3 py-3.5 text-center align-middle">
                            <span
                                v-if="log.college"
                                class="text-[10px] font-bold border border-slate-200 text-slate-600 px-2 py-0.5 rounded-md bg-slate-50 inline-block"
                            >
                                {{ log.college.code }}
                            </span>
                            <span v-else class="text-[11px] text-slate-300">—</span>
                        </td>

                        <!-- Status badge -->
                        <td class="px-3 py-3.5 text-center align-middle">
                            <span
                                :class="[
                                    'text-[11px] font-semibold px-2.5 py-0.5 rounded-full whitespace-nowrap inline-block',
                                    SEV_BADGE[deriveSeverity(log.action)]
                                ]"
                            >
                                {{ SEV_LABEL[deriveSeverity(log.action)] }}
                            </span>
                        </td>

                        <!-- Chevron -->
                        <td class="pr-6 pl-2 py-3.5 text-right align-middle">
                            <ChevronRight
                                :size="14"
                                :class="[
                                    'inline-block transition-colors',
                                    selectedId === log.id ? 'text-[#0038A8]' : 'text-slate-200 group-hover:text-slate-400'
                                ]"
                            />
                        </td>
                    </tr>

                    <!-- Empty state -->
                    <tr v-if="logs.length === 0">
                        <td colspan="7" class="py-20 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
                                <ShieldCheck :size="22" class="text-slate-300" />
                            </div>
                            <p class="text-sm font-semibold text-slate-500">No records match</p>
                            <p class="text-xs text-slate-400 mt-0.5">Try adjusting your filters or switching tabs.</p>
                            <button
                                v-if="hasFilters"
                                type="button"
                                @click="emit('clearFilters')"
                                class="text-xs mt-3 flex items-center gap-1 mx-auto font-semibold px-3 py-1.5 rounded-lg border border-slate-200 text-slate-500 hover:border-slate-300 hover:bg-slate-50 transition-all cursor-pointer"
                            >
                                <RotateCcw :size="10" />
                                <span>Clear filters</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination footer -->
        <div class="px-6 py-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 bg-slate-50/50 shrink-0">
            <span class="tabular-nums">
                Showing <span class="font-semibold text-slate-700">1</span>–<span class="font-semibold text-slate-700">{{ logs.length }}</span> of
                <span class="font-semibold text-slate-700">{{ total }}</span>
            </span>
            <div class="flex items-center gap-1">
                <button
                    type="button"
                    disabled
                    class="text-xs px-2 py-1 rounded text-slate-300 cursor-not-allowed"
                >
                    «
                </button>
                <button
                    type="button"
                    class="text-xs px-2.5 py-1 rounded font-bold text-white"
                    style="background-color: #0038A8;"
                >
                    1
                </button>
                <button
                    type="button"
                    disabled
                    class="text-xs px-2 py-1 rounded text-slate-300 cursor-not-allowed"
                >
                    »
                </button>
            </div>
        </div>
    </div>
</template>
