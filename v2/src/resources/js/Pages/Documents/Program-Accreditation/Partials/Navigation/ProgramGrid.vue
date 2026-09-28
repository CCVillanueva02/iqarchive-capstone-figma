<!--
================================================================================
IQArchive v2 — Program Selection List (Tier 2)
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/Navigation/ProgramGrid.vue
Role: Renders degree programs under the selected college as an interactive list with filters.
UI Standard: DaisyUI card, badge, btn, input (< 190 lines).
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Search, ArrowRight, X, GraduationCap, FileText } from 'lucide-vue-next';

const props = defineProps({
    college: {
        type: Object,
        required: true,
    },
    programs: {
        type: Array,
        required: true,
    },
    initialSearch: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['select', 'openAddProgram']);

const searchQuery = ref(props.initialSearch);
const selectedLevel = ref('all');

const levelFilters = computed(() => {
    const counts = {};
    props.programs.forEach((p) => {
        const lvl = p.current_level || 'Candidate Status';
        counts[lvl] = (counts[lvl] || 0) + 1;
    });

    const filters = [{ id: 'all', label: 'All', count: props.programs.length }];
    const standardOrder = ['Candidate Status', 'Level 1', 'Level 2', 'Level 3', 'Level 4'];

    standardOrder.forEach((lvl) => {
        if (counts[lvl]) {
            filters.push({ id: lvl, label: lvl, count: counts[lvl] });
        }
    });

    Object.keys(counts).forEach((lvl) => {
        if (!standardOrder.includes(lvl)) {
            filters.push({ id: lvl, label: lvl, count: counts[lvl] });
        }
    });

    return filters;
});

const filteredPrograms = computed(() => {
    let list = props.programs;

    if (selectedLevel.value !== 'all') {
        list = list.filter((p) => (p.current_level || 'Candidate Status') === selectedLevel.value);
    }

    if (!searchQuery.value) return list;
    const q = searchQuery.value.toLowerCase().trim();
    return list.filter((p) =>
        p.name.toLowerCase().includes(q) ||
        p.code.toLowerCase().includes(q) ||
        (p.current_level && p.current_level.toLowerCase().includes(q))
    );
});

function getLevelBadgeClass(level) {
    const l = (level || '').toLowerCase();
    if (l.includes('level 3') || l.includes('level 4') || l.includes('level iii') || l.includes('level iv')) {
        return 'badge-success badge-soft';
    }
    if (l.includes('level 1') || l.includes('level 2') || l.includes('level i') || l.includes('level ii')) {
        return 'badge-info badge-soft';
    }
    return 'badge-neutral badge-soft text-slate-600 bg-slate-100 border-none';
}
</script>

<template>
    <div class="space-y-4">
        <!-- Filter & Search Toolbar (Sticky) -->
        <div class="sticky top-0 z-20 bg-slate-50 pt-1 pb-3 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Level Filter Tabs -->
            <div class="flex items-center gap-1.5 flex-wrap select-none">
                <button
                    v-for="tab in levelFilters"
                    :key="tab.id"
                    type="button"
                    @click="selectedLevel = tab.id"
                    class="btn btn-xs rounded-lg font-semibold transition-all"
                    :class="selectedLevel === tab.id
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
                    placeholder="Search degree program or code..."
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

        <!-- Degree Programs Structured Table -->
        <div v-if="filteredPrograms.length > 0" class="card card-border bg-base-100 border-slate-200 rounded-2xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 pl-8 pr-3 w-36">Code</th>
                            <th class="py-3.5 px-4">Degree Program</th>
                            <th class="py-3.5 px-4 w-48 text-center">Accreditation Level</th>
                            <th class="py-3.5 px-4 w-36 text-center">Evidence</th>
                            <th class="py-3.5 pl-3 w-28 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="program in filteredPrograms"
                            :key="program.id"
                            @click="emit('select', program.id)"
                            class="hover:bg-slate-50/80 transition-colors cursor-pointer group"
                        >
                            <!-- Program Code -->
                            <td class="py-3.5 pl-6 pr-3 whitespace-nowrap">
                                <span class="badge badge-soft text-xs font-bold font-mono tracking-tight text-sidebar-blue bg-slate-100 px-2.5 py-1">
                                    {{ program.code }}
                                </span>
                            </td>

                            <!-- Program Title -->
                            <td class="py-3.5 px-4">
                                <div class="text-sm font-bold text-slate-900 group-hover:text-sidebar-blue transition-colors">
                                    {{ program.name }}
                                </div>
                            </td>

                            <!-- Accreditation Level (Centered) -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                <span class="badge text-xs font-semibold px-2.5 py-1 inline-flex" :class="getLevelBadgeClass(program.current_level)">
                                    {{ program.current_level || 'Candidate Status' }}
                                </span>
                            </td>

                            <!-- Evidence / Document Count (Centered) -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                <div class="inline-flex items-center gap-1.5 text-xs text-slate-600 font-semibold">
                                    <FileText class="w-3.5 h-3.5 text-bu-blue-600" />
                                    <span class="tabular-nums">{{ program.documents_count ?? 0 }}</span>
                                    <span class="text-slate-400 font-normal">{{ (program.documents_count ?? 0) === 1 ? 'Doc' : 'Docs' }}</span>
                                </div>
                            </td>

                            <!-- Action -->
                            <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap">
                                <span class="btn btn-xs btn-ghost border border-slate-200 text-slate-700 group-hover:bg-sidebar-blue group-hover:text-white group-hover:border-sidebar-blue font-semibold px-2.5 transition-all inline-flex items-center gap-1">
                                    <span>Select</span>
                                    <ArrowRight class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" />
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State matching CollegeGrid format -->
        <div v-else class="card card-border bg-base-100 border-slate-200 p-12 text-center rounded-2xl">
            <GraduationCap class="w-10 h-10 text-slate-300 mx-auto mb-2" />
            <h4 class="text-sm font-bold text-slate-800">No degree programs match your filter</h4>
            <p class="text-xs text-slate-500 mt-0.5">Try clearing the search or switching accreditation levels.</p>
        </div>
    </div>
</template>
