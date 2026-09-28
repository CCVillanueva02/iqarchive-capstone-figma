<!--
================================================================================
IQArchive v2 — Supporting Documents Workspace (Tier 4)
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/DocumentTypes/SupportingDocs/SupportingDocsView.vue
Role: 10-Area tabs, Parameter sidebar, and Criteria benchmark evidence matrix.
UI Standard: DaisyUI tabs, card, badge, btn (< 190 lines).
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { UploadCloud } from 'lucide-vue-next';

const props = defineProps({
    program: { type: Object, required: true },
    college: { type: Object, required: true },
    instrument: { type: Object, default: null },
    documents: { type: Array, default: () => [] },
});

const emit = defineEmits(['openUpload', 'backToHub']);

const areas = computed(() => props.instrument?.areas || []);
const selectedAreaIndex = ref(0);
const selectedParamIndex = ref(0);
const activeBenchmarkType = ref('system');

const currentArea = computed(() => areas.value[selectedAreaIndex.value] || null);
const currentParameters = computed(() => currentArea.value?.parameters || []);
const currentParameter = computed(() => currentParameters.value[selectedParamIndex.value] || null);

const currentCriteria = computed(() => {
    if (!currentParameter.value) return [];
    return currentParameter.value.criteria.filter((c) => c.type === activeBenchmarkType.value);
});

function selectArea(idx) { selectedAreaIndex.value = idx; selectedParamIndex.value = 0; }
function selectParam(idx) { selectedParamIndex.value = idx; }

const benchmarkTabNames = {
    system: 'Systems — Inputs & Processes',
    implementation: 'Implementation',
    outcome: 'Outcomes',
    best_practice: 'Best Practices',
};
</script>

<template>
    <div class="space-y-4">
        <!-- 10-Area Carousel / Tabs Header -->
        <div class="card card-border bg-base-100 border-slate-200 p-3 rounded-2xl shadow-xs overflow-x-auto">
            <div class="flex items-center gap-2 min-w-max">
                <button
                    v-for="(area, idx) in areas"
                    :key="area.id"
                    type="button"
                    @click="selectArea(idx)"
                    class="px-4 py-2.5 rounded-xl text-left border transition-all duration-150 max-w-50"
                    :class="selectedAreaIndex === idx 
                        ? 'bg-sidebar-blue text-white border-sidebar-blue shadow-xs' 
                        : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200'"
                >
                    <div class="text-[10px] uppercase font-bold tracking-wider" :class="selectedAreaIndex === idx ? 'text-blue-200' : 'text-slate-400'">
                        Area {{ area.area_number }}
                    </div>
                    <div class="text-xs font-semibold truncate mt-0.5">
                        {{ area.name }}
                    </div>
                </button>
            </div>
        </div>

        <!-- Main 2-Column Workstation Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
            <!-- Left: Parameters Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-3">
                <div class="card card-border bg-base-100 border-slate-200 p-4 rounded-2xl shadow-xs">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                        Parameters Available ({{ currentParameters.length }})
                    </h3>

                    <div class="space-y-2">
                        <button
                            v-for="(param, idx) in currentParameters"
                            :key="param.id"
                            type="button"
                            @click="selectParam(idx)"
                            class="w-full text-left p-3 rounded-xl border transition-all duration-150"
                            :class="selectedParamIndex === idx
                                ? 'bg-blue-50/60 border-sidebar-blue text-sidebar-blue shadow-xs'
                                : 'bg-slate-50/50 hover:bg-slate-100 border-slate-200 text-slate-700'"
                        >
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold font-mono">
                                    PARAMETER {{ param.parameter_letter }}
                                </span>
                                <span class="badge badge-neutral badge-soft text-[10px] font-semibold tabular-nums">
                                    {{ param.criteria?.length ?? 0 }} Benchmarks
                                </span>
                            </div>
                            <p class="text-xs font-medium text-slate-800 mt-1 line-clamp-1">
                                {{ param.name }}
                            </p>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Criteria Checklist & Evidence Linking (8 cols) -->
            <div class="lg:col-span-8 space-y-4">
                <div class="card card-border bg-base-100 border-slate-200 p-5 rounded-2xl shadow-xs space-y-4">
                    <!-- Parameter Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                Parameter {{ currentParameter?.parameter_letter }}
                            </span>
                            <h2 class="text-base font-bold text-slate-900 mt-0.5">
                                {{ currentParameter?.name }}
                            </h2>
                        </div>
                        <button
                            type="button"
                            @click="emit('openUpload')"
                            class="btn btn-sm bg-bu-orange-500 hover:bg-bu-orange-600 text-white border-none gap-1.5"
                        >
                            <UploadCloud class="w-4 h-4" />
                            <span>Upload Evidence</span>
                        </button>
                    </div>

                    <!-- Benchmark Type Tabs -->
                    <div class="flex items-center gap-1.5 border-b border-slate-200 pb-2 overflow-x-auto text-xs">
                        <button
                            v-for="bType in ['system', 'implementation', 'outcome', 'best_practice']"
                            :key="bType"
                            type="button"
                            @click="activeBenchmarkType = bType"
                            class="px-3 py-1.5 rounded-lg font-semibold transition-colors"
                            :class="activeBenchmarkType === bType
                                ? 'bg-sidebar-blue text-white'
                                : 'text-slate-600 hover:bg-slate-100'"
                        >
                            {{ benchmarkTabNames[bType] }}
                        </button>
                    </div>

                    <!-- Criteria Benchmark Items List -->
                    <div v-if="currentCriteria.length > 0" class="space-y-3">
                        <div
                            v-for="criterion in currentCriteria"
                            :key="criterion.id"
                            class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3"
                        >
                            <div class="flex items-start gap-3">
                                <span class="badge badge-neutral text-xs font-mono font-bold px-2 py-1 shrink-0">
                                    {{ criterion.benchmark_code }}
                                </span>
                                <p class="text-xs font-medium text-slate-800 leading-relaxed flex-1">
                                    {{ criterion.title }}
                                </p>
                            </div>

                            <!-- Attached Evidence Strip -->
                            <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between text-xs text-slate-500">
                                <span class="italic text-[11px]">Supporting documents attached (0)</span>
                                <button
                                    type="button"
                                    @click="emit('openUpload', criterion.id)"
                                    class="btn btn-xs btn-ghost text-sidebar-blue hover:bg-blue-50 gap-1 font-semibold"
                                >
                                    <UploadCloud class="w-3.5 h-3.5" />
                                    <span>+ Add File</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center py-8 text-slate-400 text-xs">
                        No benchmarks recorded under this category.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
