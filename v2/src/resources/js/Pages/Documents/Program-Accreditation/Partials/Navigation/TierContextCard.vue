<!--
================================================================================
IQArchive v2 — Tier Context Card (Tier 1–4 Upper-Right Details Component)
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/Navigation/TierContextCard.vue
Role: Renders adaptive contextual details in the upper-right corner per tier:
      - Tier 1: Program Accreditation overview (17 colleges, AACCUP scope)
      - Tier 2: Selected College details (logo, code, campus, programs count)
      - Tier 3: Selected Program details (code, title, accreditation level)
      - Tier 4: Active Workspace details (category title, target program, mode)
UI Standard: DaisyUI card, badge (< 190 lines).
================================================================================
-->

<script setup>
import { computed } from 'vue';
import { GraduationCap, FolderOpen } from 'lucide-vue-next';

const props = defineProps({
    currentTier: { type: Number, required: true },
    activeCategory: { type: String, default: 'hub' },
    activeCategoryTitle: { type: String, default: '' },
    college: { type: Object, default: null },
    program: { type: Object, default: null },
    programsCount: { type: Number, default: 0 },
    collegesCount: { type: Number, default: 0 },
});

const totalColleges = computed(() => props.collegesCount || 17);
const totalPrograms = computed(() => props.programsCount || props.college?.programs_count || 0);

function getWorkspaceMode(category) {
    switch (category) {
        case 'supporting-documents': return '10 Areas & Evidence';
        case 'self-survey': return 'Evaluation Matrix';
        case 'compliance-reports': return 'Official Reports';
        case 'ppp': return 'Performance Profile';
        case 'narrative-profile': return 'Narrative Profile';
        default: return 'Accreditation Workspace';
    }
}
</script>

<template>
    <!-- Tier 1: Program Accreditation Overview -->
    <div
        v-if="currentTier === 1"
        class="card card-border bg-base-100 border-slate-200 p-3 rounded-2xl shadow-xs flex flex-row items-center justify-between gap-2.5 min-h-24"
    >
        <!-- Left Side: Logo & Program Identity -->
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/80 p-1 flex items-center justify-center shrink-0">
                <img
                    src="/logos/aaccup-logo.png"
                    alt="AACCUP"
                    class="w-full h-full object-contain"
                />
            </div>
            <div class="min-w-0">
                <div class="text-xs font-bold text-slate-900 tracking-tight whitespace-nowrap">
                    AACCUP Accreditation
                </div>
                <div class="text-[11px] font-medium text-slate-500 mt-0.5">
                    AY 2025–2026
                </div>
            </div>
        </div>

        <!-- Right Side: Colleges Stat Counter -->
        <div class="text-right shrink-0 pl-2.5 pr-1.5 border-l border-slate-100">
            <div class="text-lg font-black text-slate-900 tabular-nums leading-none">
                {{ totalColleges }}
            </div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">
                Colleges
            </div>
        </div>
    </div>

    <!-- Tier 2: Selected College Details -->
    <div
        v-else-if="currentTier === 2 && college"
        class="card card-border bg-base-100 border-slate-200 p-3 rounded-2xl shadow-xs flex flex-row items-center justify-between gap-2.5 min-h-24"
    >
        <!-- Left Side: College Logo & Identity -->
        <div class="flex items-center gap-2.5 min-w-0 flex-1">
            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/80 p-1 flex items-center justify-center shrink-0">
                <img
                    v-if="college.logo_url"
                    :src="college.logo_url"
                    :alt="college.code"
                    class="w-full h-full object-contain"
                />
                <GraduationCap v-else class="w-5 h-5 text-bu-blue-700" />
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold text-slate-900 tracking-tight leading-snug line-clamp-3" :title="college.name">
                    {{ college.name }}
                </div>
            </div>
        </div>

        <!-- Right Side: Programs Stat Counter -->
        <div class="text-right shrink-0 pl-2.5 pr-1.5 border-l border-slate-100">
            <div class="text-lg font-black text-slate-900 tabular-nums leading-none">
                {{ totalPrograms }}
            </div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">
                {{ totalPrograms === 1 ? 'Program' : 'Programs' }}
            </div>
        </div>
    </div>

    <!-- Tier 3: Selected Program Details (Hub View) -->
    <div
        v-else-if="currentTier === 3 && activeCategory === 'hub' && program"
        class="card card-border bg-base-100 border-slate-200 p-3 rounded-2xl shadow-xs flex flex-row items-center gap-2.5 min-h-24"
    >
        <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/80 p-1 flex items-center justify-center shrink-0">
            <img
                v-if="college?.logo_url"
                :src="college.logo_url"
                :alt="college.code"
                class="w-full h-full object-contain"
            />
            <GraduationCap v-else class="w-5 h-5 text-bu-blue-700" />
        </div>
        <div class="min-w-0 flex-1">
            <div class="text-xs font-bold text-slate-900 tracking-tight leading-snug line-clamp-2" :title="program.name">
                {{ program.name }}
            </div>
            <div class="text-[11px] font-medium text-slate-500 mt-0.5 truncate" :title="college?.name">
                {{ college?.name || college?.code }}
            </div>
        </div>
    </div>

    <!-- Tier 4: Selected Workspace Details -->
    <div
        v-else-if="currentTier === 3 && activeCategory !== 'hub'"
        class="card card-border bg-base-100 border-slate-200 p-3.5 rounded-2xl shadow-xs flex flex-col justify-between space-y-2"
    >
        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
            <div class="flex items-center gap-2 min-w-0">
                <div class="w-7 h-7 rounded-lg bg-orange-50 border border-orange-100 flex items-center justify-center text-bu-orange-500 shrink-0">
                    <FolderOpen class="w-4 h-4" />
                </div>
                <span class="text-xs font-bold text-slate-900 tracking-tight truncate max-w-32.5" :title="activeCategoryTitle">
                    {{ activeCategoryTitle }}
                </span>
            </div>
            <span class="badge badge-warning badge-soft text-[10px] font-semibold px-2 py-0.5">Workspace</span>
        </div>
        <div class="space-y-1 text-xs">
            <div class="flex items-center justify-between gap-2">
                <span class="text-slate-500 shrink-0">Target Program:</span>
                <span class="font-bold font-mono text-sidebar-blue text-right">{{ program?.code }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-slate-500 shrink-0">Mode:</span>
                <span class="font-semibold text-slate-800 text-right">{{ getWorkspaceMode(activeCategory) }}</span>
            </div>
        </div>
    </div>
</template>
