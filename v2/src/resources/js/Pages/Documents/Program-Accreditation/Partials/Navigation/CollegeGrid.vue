<!--
================================================================================
IQArchive v2 — College Selection Grid (Tier 1)
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/Navigation/CollegeGrid.vue
Role: Renders the 17 Bicol University academic units with campus filters & polished cards.
UI Standard: DaisyUI card, badge, btn, input (< 150 lines).
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Search, ArrowRight, X, Building2, GraduationCap } from 'lucide-vue-next';

const props = defineProps({
    colleges: { type: Array, required: true },
    initialSearch: { type: String, default: '' },
});

const emit = defineEmits(['select']);

const searchQuery = ref(props.initialSearch);
const selectedCampus = ref('all');

function matchesCampus(college, key) {
    if (key === 'all') return true;
    const c = (college.campus || '').toLowerCase();
    if (key === 'east') return c.includes('east');
    if (key === 'west') return c.includes('west');
    if (key === 'daraga') return c.includes('daraga');
    if (key === 'satellite') return !c.includes('east') && !c.includes('west') && !c.includes('daraga');
    return true;
}

function formatCollegeName(name) {
    if (!name) return '';
    if (name === name.toUpperCase()) {
        return name
            .toLowerCase()
            .replace(/\b([a-z])/g, (m) => m.toUpperCase())
            .replace(/\bBu\b/g, 'BU');
    }
    return name;
}

const campusFilters = computed(() => [
    { id: 'all', label: 'All', count: props.colleges.length },
    { id: 'east', label: 'Legazpi East', count: props.colleges.filter((c) => matchesCampus(c, 'east')).length },
    { id: 'west', label: 'Legazpi West', count: props.colleges.filter((c) => matchesCampus(c, 'west')).length },
    { id: 'daraga', label: 'Daraga', count: props.colleges.filter((c) => matchesCampus(c, 'daraga')).length },
    { id: 'satellite', label: 'Satellites', count: props.colleges.filter((c) => matchesCampus(c, 'satellite')).length },
]);

const filteredColleges = computed(() => {
    let list = props.colleges.filter((c) => matchesCampus(c, selectedCampus.value));
    if (!searchQuery.value) return list;
    const q = searchQuery.value.toLowerCase().trim();
    return list.filter((c) => c.name.toLowerCase().includes(q) || c.code.toLowerCase().includes(q) || (c.campus && c.campus.toLowerCase().includes(q)));
});
</script>

<template>
    <div class="space-y-4">
        <!-- Integrated Workstation Toolbar (Sticky) -->
        <div class="sticky top-0 z-20 bg-slate-50 pt-1 pb-3 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Campus Filter Tabs (select-none to eliminate autoscroll artifacts) -->
            <div class="flex items-center gap-1.5 flex-wrap select-none">
                <button
                    v-for="tab in campusFilters"
                    :key="tab.id"
                    type="button"
                    @click="selectedCampus = tab.id"
                    class="btn btn-xs rounded-lg font-semibold transition-all"
                    :class="selectedCampus === tab.id
                        ? 'bg-sidebar-blue text-white shadow-xs'
                        : 'btn-ghost text-slate-600 hover:bg-slate-100'"
                >
                    <span>{{ tab.label }}</span>
                    <span class="opacity-70 text-[10px] tabular-nums">({{ tab.count }})</span>
                </button>
            </div>

            <!-- Integrated Search Bar with clean brand focus ring -->
            <label class="input input-sm input-bordered flex items-center gap-2 bg-base-100 rounded-xl w-full md:w-80 shadow-xs focus-within:border-sidebar-blue focus-within:ring-2 focus-within:ring-sidebar-blue/20 focus-within:outline-hidden transition-all">
                <Search class="w-4 h-4 text-slate-400 shrink-0" />
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search colleges, codes (e.g. CS, CBEM)..."
                    class="grow text-xs border-none outline-hidden focus:ring-0 bg-transparent"
                />
                <button
                    v-if="searchQuery"
                    type="button"
                    @click="searchQuery = ''"
                    class="btn btn-ghost btn-xs btn-circle text-slate-400 hover:text-slate-700 -mr-1"
                    title="Clear search"
                >
                    <X class="w-3.5 h-3.5" />
                </button>
            </label>
        </div>

        <!-- 3-Column College Card Grid -->
        <div v-if="filteredColleges.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                v-for="college in filteredColleges"
                :key="college.id"
                @click="emit('select', college.id)"
                class="card card-border bg-base-100 border-slate-200 hover:border-sidebar-blue/40 hover:shadow-md transition-all duration-200 rounded-2xl p-4.5 cursor-pointer group flex flex-col justify-between"
            >
                <!-- Top Identity Block: Logo + Vertically Centered Title -->
                <div class="flex items-center gap-3.5 min-h-13">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-200/80 p-1 flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 group-hover:border-bu-blue-200 transition-all duration-200">
                        <img :src="college.logo_url" :alt="college.name" class="w-full h-full object-contain" loading="lazy" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-sidebar-blue transition-colors leading-snug line-clamp-2">
                            {{ formatCollegeName(college.name) }}
                        </h3>
                    </div>
                </div>

                <!-- Bottom Footer Bar: Programs Count & Action Link -->
                <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-1.5 font-semibold text-slate-700">
                        <GraduationCap class="w-3.5 h-3.5 text-bu-blue-600" />
                        <span class="tabular-nums">{{ college.programs_count ?? 0 }}</span>
                        <span class="text-slate-500 font-normal"> {{ college.programs_count === 1 ? 'Program' : 'Programs' }}</span>
                    </div>

                    <span class="inline-flex items-center gap-1 font-semibold text-sidebar-blue group-hover:text-bu-blue-600 transition-colors">
                        <span>View Programs</span>
                        <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                    </span>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="card card-border bg-base-100 border-slate-200 p-12 text-center rounded-2xl">
            <Building2 class="w-10 h-10 text-slate-300 mx-auto mb-2" />
            <h4 class="text-sm font-bold text-slate-800">No colleges match your filter</h4>
            <p class="text-xs text-slate-500 mt-0.5">Try clearing the search or switching campus categories.</p>
        </div>
    </div>
</template>
