<!--
================================================================================
IQArchive v2 — Audit Primary Tabs Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditTabs.vue
Role: Renders primary navigation tabs with real-time audit record counts.
UI Standard: DaisyUI / Institutional BU Blue (#0038A8). Line count < 100.
================================================================================
-->

<script setup>
defineProps({
    tabs: {
        type: Array,
        required: true,
    },
    activeTabKey: {
        type: String,
        required: true,
    },
    tabCounts: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(['selectTab']);
</script>

<template>
    <div class="flex items-center border-b border-slate-100 px-6 shrink-0 overflow-x-auto bg-white">
        <button
            v-for="tab in tabs"
            :key="tab.key"
            type="button"
            @click="emit('selectTab', tab.key)"
            :class="[
                'flex items-center gap-1.5 px-3 py-2.5 text-xs font-semibold whitespace-nowrap border-b-2 -mb-px transition-all cursor-pointer',
                activeTabKey === tab.key
                    ? 'border-[#0038A8] text-[#0038A8]'
                    : 'text-slate-400 border-transparent hover:text-slate-700 hover:border-slate-200'
            ]"
        >
            <span>{{ tab.label }}</span>
            <span
                :class="[
                    'text-[10px] font-bold px-1.5 py-px rounded-full tabular-nums transition-colors',
                    activeTabKey === tab.key
                        ? 'bg-[#0038A8]/10 text-[#0038A8]'
                        : 'bg-slate-100 text-slate-400'
                ]"
            >
                {{ tabCounts[tab.key] ?? 0 }}
            </span>
        </button>
    </div>
</template>
