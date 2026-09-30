<!--
================================================================================
IQArchive v2 — Audit Filter Bar Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditFilterBar.vue
Role: Segmented subtabs, search input, severity status chips, count & reset.
UI Standard: DaisyUI / Institutional BU Blue (#0038A8). Line count < 140.
================================================================================
-->

<script setup>
import { Search, X, RotateCcw } from 'lucide-vue-next';

defineProps({
    subtabs: {
        type: Array,
        default: null,
    },
    activeSubKey: {
        type: String,
        default: 'all',
    },
    subTabCounts: {
        type: Object,
        default: () => ({}),
    },
    search: {
        type: String,
        default: '',
    },
    sevFilter: {
        type: String,
        default: '',
    },
    resultCount: {
        type: Number,
        default: 0,
    },
    hasFilters: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'selectSubtab',
    'update:search',
    'update:sevFilter',
    'clearFilters',
]);

const SEVERITY_OPTIONS = [
    { value: '', label: 'All', color: '#0038A8' },
    { value: 'security', label: 'Security Alert', color: '#EF4444' },
    { value: 'warning', label: 'Warning', color: '#F59E0B' },
    { value: 'success', label: 'Completed', color: '#10B981' },
    { value: 'info', label: 'Info', color: '#94A3B8' },
];
</script>

<template>
    <div class="flex items-center gap-2.5 px-6 py-2.5 border-b border-slate-100 shrink-0 overflow-x-auto bg-white">
        <!-- Subtabs as segmented control (only when active tab has subtabs) -->
        <template v-if="subtabs && subtabs.length">
            <div class="flex items-center bg-slate-100 rounded-lg p-0.5 shrink-0">
                <button
                    v-for="sub in subtabs"
                    :key="sub.key"
                    type="button"
                    @click="emit('selectSubtab', sub.key)"
                    :class="[
                        'flex items-center gap-1 text-[11px] font-semibold px-2.5 py-1 rounded-md whitespace-nowrap transition-all cursor-pointer',
                        activeSubKey === sub.key
                            ? 'bg-white text-slate-800 shadow-xs'
                            : 'text-slate-500 hover:text-slate-700'
                    ]"
                >
                    <span>{{ sub.label }}</span>
                    <span
                        :class="[
                            'text-[10px] tabular-nums font-semibold',
                            activeSubKey === sub.key ? 'text-slate-500' : 'text-slate-400'
                        ]"
                    >
                        {{ subTabCounts[sub.key] ?? 0 }}
                    </span>
                </button>
            </div>
            <span class="w-px h-4 bg-slate-200 shrink-0" />
        </template>

        <!-- Search input -->
        <label class="flex items-center gap-2 flex-1 min-w-[150px] max-w-[240px] border border-slate-200 rounded-lg bg-slate-50 px-3 py-[5px] focus-within:border-[#0038A8]/40 focus-within:bg-white focus-within:ring-2 focus-within:ring-[#0038A8]/8 transition-all">
            <Search :size="11" class="text-slate-400 shrink-0" />
            <input
                type="text"
                :value="search"
                @input="emit('update:search', $event.target.value)"
                placeholder="Search events, people…"
                class="grow text-xs outline-none bg-transparent placeholder:text-slate-400 text-slate-700 border-none focus:outline-none focus:ring-0 p-0"
            />
            <button
                v-if="search"
                type="button"
                @click="emit('update:search', '')"
                class="text-slate-300 hover:text-slate-500 shrink-0 cursor-pointer"
                aria-label="Clear search"
            >
                <X :size="10" />
            </button>
        </label>

        <!-- Status filter — dot + label chips -->
        <div class="flex items-center gap-1 shrink-0">
            <button
                v-for="opt in SEVERITY_OPTIONS"
                :key="opt.value"
                type="button"
                @click="emit('update:sevFilter', opt.value)"
                :style="sevFilter === opt.value ? { backgroundColor: opt.color } : {}"
                :class="[
                    'flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-md transition-all cursor-pointer',
                    sevFilter === opt.value
                        ? 'text-white shadow-xs'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-100'
                ]"
            >
                <span
                    v-if="opt.value"
                    class="w-1.5 h-1.5 rounded-full shrink-0"
                    :style="{ backgroundColor: sevFilter === opt.value ? 'rgba(255,255,255,0.9)' : opt.color }"
                />
                <span>{{ opt.label }}</span>
            </button>
        </div>

        <!-- Result count + reset -->
        <div class="flex items-center gap-2 ml-auto shrink-0">
            <span class="text-[11px] text-slate-400 tabular-nums">
                <span class="font-semibold text-slate-600">{{ resultCount }}</span>
                result{{ resultCount !== 1 ? 's' : '' }}
            </span>
            <button
                v-if="hasFilters"
                type="button"
                @click="emit('clearFilters')"
                class="flex items-center gap-1 text-[11px] text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                title="Reset filters"
            >
                <RotateCcw :size="9" />
                <span>Reset</span>
            </button>
        </div>
    </div>
</template>
