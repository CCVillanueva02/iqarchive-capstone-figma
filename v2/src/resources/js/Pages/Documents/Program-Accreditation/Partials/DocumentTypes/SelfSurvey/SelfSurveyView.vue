<!--
================================================================================
IQArchive v2 — Self-Survey Matrix & Ratings Guide (Tier 4)
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/DocumentTypes/SelfSurvey/SelfSurveyView.vue
Role: Internal QA self-evaluation spreadsheet with automated mean calculations.
UI Standard: DaisyUI table, select, card, badge, btn (< 170 lines).
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { FileCheck } from 'lucide-vue-next';

const props = defineProps({
    program: { type: Object, required: true },
    college: { type: Object, required: true },
});

const emit = defineEmits(['backToHub']);

const ratings = ref({
    s1: 4,
    i1: 4,
    i2: 3,
    o1: 4,
    o2: 4,
});

const bestPractices = ref('');
const preparedBy = ref('');

const systemMean = computed(() => Number(ratings.value.s1 || 0).toFixed(2));
const implementationMean = computed(() => {
    const total = Number(ratings.value.i1 || 0) + Number(ratings.value.i2 || 0);
    return (total / 2).toFixed(2);
});
const outcomeMean = computed(() => {
    const total = Number(ratings.value.o1 || 0) + Number(ratings.value.o2 || 0);
    return (total / 2).toFixed(2);
});

const parameterMean = computed(() => {
    const sum = Number(systemMean.value) + Number(implementationMean.value) + Number(outcomeMean.value);
    return (sum / 3).toFixed(2);
});

const totalRatingSum = computed(() => {
    return Object.values(ratings.value).reduce((a, b) => Number(a) + Number(b), 0);
});
</script>

<template>
    <div class="space-y-5">
        <!-- Self-Survey Header Card -->
        <div class="card card-border bg-base-100 border-slate-200 p-5 rounded-2xl shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <span class="text-xs font-bold text-bu-orange-500 uppercase tracking-wider">AACCUP Self-Survey Instrument</span>
                    <h2 class="text-base font-bold text-slate-900 mt-0.5">Numerical Rating Matrix — Parameter A: Statement of VMGO</h2>
                </div>
                <span class="badge badge-warning badge-soft text-xs font-semibold px-2.5 py-1">
                    Parameter Mean: <span class="tabular-nums font-mono ml-1 font-bold">{{ parameterMean }}</span>
                </span>
            </div>

            <!-- Rating Matrix Table -->
            <div class="divide-y divide-slate-100 text-xs mt-3">
                <!-- SYSTEM -->
                <div class="py-3 space-y-2">
                    <div class="font-bold text-slate-500 uppercase text-[10px] tracking-wider">Systems — Inputs & Processes</div>
                    <div class="flex items-center justify-between gap-4 p-2 bg-slate-50 rounded-lg">
                        <span class="text-slate-700">S.1 The institution has a system of determining its Vision and Mission.</span>
                        <select v-model="ratings.s1" class="select select-bordered select-xs w-20 bg-white">
                            <option v-for="n in 5" :key="n" :value="n">{{ n }}.0</option>
                        </select>
                    </div>
                    <div class="text-right text-slate-500 font-medium pr-2">System Mean: <span class="font-bold text-slate-900 tabular-nums font-mono">{{ systemMean }}</span></div>
                </div>

                <!-- IMPLEMENTATION -->
                <div class="py-3 space-y-2">
                    <div class="font-bold text-slate-500 uppercase text-[10px] tracking-wider">Implementation</div>
                    <div class="flex items-center justify-between gap-4 p-2 bg-slate-50 rounded-lg">
                        <span class="text-slate-700">I.1 The institutional plan is implemented, monitored, and evaluated.</span>
                        <select v-model="ratings.i1" class="select select-bordered select-xs w-20 bg-white">
                            <option v-for="n in 5" :key="n" :value="n">{{ n }}.0</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between gap-4 p-2 bg-slate-50 rounded-lg">
                        <span class="text-slate-700">I.2 Resources are allocated according to the institutional plan.</span>
                        <select v-model="ratings.i2" class="select select-bordered select-xs w-20 bg-white">
                            <option v-for="n in 5" :key="n" :value="n">{{ n }}.0</option>
                        </select>
                    </div>
                    <div class="text-right text-slate-500 font-medium pr-2">Implementation Mean: <span class="font-bold text-slate-900 tabular-nums font-mono">{{ implementationMean }}</span></div>
                </div>

                <!-- OUTCOMES -->
                <div class="py-3 space-y-2">
                    <div class="font-bold text-slate-500 uppercase text-[10px] tracking-wider">Outcome/s</div>
                    <div class="flex items-center justify-between gap-4 p-2 bg-slate-50 rounded-lg">
                        <span class="text-slate-700">O.1 Goals and targets in the institutional plan are achieved.</span>
                        <select v-model="ratings.o1" class="select select-bordered select-xs w-20 bg-white">
                            <option v-for="n in 5" :key="n" :value="n">{{ n }}.0</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between gap-4 p-2 bg-slate-50 rounded-lg">
                        <span class="text-slate-700">O.2 The institution is responsive to changes in its external environment.</span>
                        <select v-model="ratings.o2" class="select select-bordered select-xs w-20 bg-white">
                            <option v-for="n in 5" :key="n" :value="n">{{ n }}.0</option>
                        </select>
                    </div>
                    <div class="text-right text-slate-500 font-medium pr-2">Outcome Mean: <span class="font-bold text-slate-900 tabular-nums font-mono">{{ outcomeMean }}</span></div>
                </div>
            </div>

            <!-- Best Practices Textarea -->
            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Best Practices Recorded
                </label>
                <textarea
                    v-model="bestPractices"
                    rows="2"
                    placeholder="Enter benchmark best practices or institutional strengths..."
                    class="textarea textarea-bordered w-full text-xs"
                ></textarea>
            </div>

            <!-- Calculation Banner -->
            <div class="mt-4 p-3 bg-emerald-600 text-white rounded-xl flex items-center justify-between text-xs font-bold shadow-xs">
                <span>TOTAL RATING (Sum): <span class="tabular-nums font-mono">{{ totalRatingSum }}</span></span>
                <span>PARAMETER MEAN: <span class="tabular-nums font-mono">{{ parameterMean }}</span></span>
                <span>AREA I MEAN: <span class="tabular-nums font-mono">{{ parameterMean }}</span></span>
            </div>

            <!-- Sign-Off & Submission -->
            <div class="mt-4 pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-600">PREPARED BY:</span>
                    <input
                        v-model="preparedBy"
                        type="text"
                        placeholder="Enter full name of surveyor..."
                        class="input input-bordered input-xs w-64 text-xs"
                    />
                </div>
                <button
                    type="button"
                    class="btn btn-sm bg-emerald-600 hover:bg-emerald-700 text-white border-none gap-1.5"
                >
                    <FileCheck class="w-4 h-4" />
                    <span>Save Self-Survey Ratings</span>
                </button>
            </div>
        </div>
    </div>
</template>
