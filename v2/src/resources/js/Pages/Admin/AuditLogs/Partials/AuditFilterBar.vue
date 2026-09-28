<!--
================================================================================
IQArchive v2 — Audit Filter Bar Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditFilterBar.vue
Role: Controls search query, category, tenant college, and severity filters.
UI Standard: DaisyUI input, select, badge, btn; Lucide icons.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Search, RotateCcw, X } from 'lucide-vue-next';

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({
            search: '',
            category: '',
            college_id: '',
            severity: '',
            date_range: '',
        }),
    },
    colleges: {
        type: Array,
        default: () => [],
    },
    isUniversityWide: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['filter', 'reset']);

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');
const collegeId = ref(props.filters.college_id || '');
const severity = ref(props.filters.severity || '');
const dateRange = ref(props.filters.date_range || '');

const hasActiveFilters = computed(() => {
    return Boolean(search.value || category.value || collegeId.value || severity.value || dateRange.value);
});

function applyFilter() {
    emit('filter', {
        search: search.value,
        category: category.value,
        college_id: collegeId.value,
        severity: severity.value,
        date_range: dateRange.value,
    });
}

function handleReset() {
    search.value = '';
    category.value = '';
    collegeId.value = '';
    severity.value = '';
    dateRange.value = '';
    emit('reset');
}
</script>

<template>
    <div class="p-4 space-y-3 border-b border-slate-100 shrink-0">
        <!-- Main Controls Grid -->
        <div class="flex flex-col md:flex-row items-center gap-2.5">
            <!-- Search input -->
            <label class="input input-sm input-bordered flex items-center gap-2 flex-1 w-full rounded-lg bg-base-100">
                <Search class="w-3.5 h-3.5 text-slate-400 shrink-0" />
                <input
                    v-model="search"
                    @input="applyFilter"
                    type="text"
                    placeholder="Search by actor name, email, action, entity ID, or IP..."
                    class="grow text-xs"
                />
                <button
                    v-if="search"
                    type="button"
                    @click="search = ''; applyFilter();"
                    class="btn btn-ghost btn-xs btn-circle text-slate-400 hover:text-slate-600"
                >
                    <X class="w-3 h-3" />
                </button>
            </label>

            <!-- Dropdown Selectors Group -->
            <div class="flex items-center gap-2 w-full md:w-auto flex-wrap sm:flex-nowrap">
                <!-- Category -->
                <select
                    v-model="category"
                    @change="applyFilter"
                    class="select select-sm select-bordered text-xs rounded-lg w-full sm:w-36 bg-base-100"
                >
                    <option value="">All Categories</option>
                    <option value="auth">Authentication</option>
                    <option value="document">Documents</option>
                    <option value="accreditation">Accreditation</option>
                    <option value="admin">System Admin</option>
                </select>

                <!-- College Scope (University-wide only) -->
                <select
                    v-if="isUniversityWide"
                    v-model="collegeId"
                    @change="applyFilter"
                    class="select select-sm select-bordered text-xs rounded-lg w-full sm:w-40 bg-base-100"
                >
                    <option value="">All Colleges</option>
                    <option v-for="col in colleges" :key="col.id" :value="col.id">
                        {{ col.code }} — {{ col.name }}
                    </option>
                </select>

                <!-- Severity Level -->
                <select
                    v-model="severity"
                    @change="applyFilter"
                    class="select select-sm select-bordered text-xs rounded-lg w-full sm:w-32 bg-base-100"
                >
                    <option value="">All Severities</option>
                    <option value="info">Info</option>
                    <option value="success">Success</option>
                    <option value="warning">Warning</option>
                    <option value="security">Security</option>
                </select>

                <!-- Date Range -->
                <select
                    v-model="dateRange"
                    @change="applyFilter"
                    class="select select-sm select-bordered text-xs rounded-lg w-full sm:w-32 bg-base-100"
                >
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="7days">Last 7 Days</option>
                    <option value="30days">Last 30 Days</option>
                </select>

                <!-- Reset Button -->
                <button
                    v-if="hasActiveFilters"
                    type="button"
                    @click="handleReset"
                    class="btn btn-sm btn-ghost text-xs text-slate-500 hover:text-slate-800 gap-1 shrink-0"
                    title="Clear all filters"
                >
                    <RotateCcw class="w-3.5 h-3.5" />
                    <span>Reset</span>
                </button>
            </div>
        </div>
    </div>
</template>
