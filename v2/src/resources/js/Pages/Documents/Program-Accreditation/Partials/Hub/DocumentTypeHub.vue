<!--
================================================================================
IQArchive v2 — Program Accreditation Document Type Hub (Tier 3 Hub)
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/Hub/DocumentTypeHub.vue
Role: Displays the 5 accreditation document category cards dynamically conditioned by level.
UI Standard: DaisyUI card, badge, btn (< 150 lines).
================================================================================
-->

<script setup>
import { 
    Files, 
    ClipboardCheck, 
    FileCheck2, 
    BarChart3, 
    BookOpen, 
    ArrowRight
} from 'lucide-vue-next';

const props = defineProps({
    college: { type: Object, required: true },
    program: { type: Object, required: true },
    documentTypes: { type: Array, required: true },
    documents: { type: Array, default: () => [] },
});

const emit = defineEmits(['selectCategory', 'switchProgram']);

function getCategoryIcon(id) {
    switch (id) {
        case 'supporting-documents': return Files;
        case 'self-survey': return ClipboardCheck;
        case 'compliance-reports': return FileCheck2;
        case 'ppp': return BarChart3;
        case 'narrative-profile': return BookOpen;
        default: return Files;
    }
}

function getIconContainerClass(color) {
    switch (color) {
        case 'navy': return 'bg-slate-100 text-sidebar-blue border-slate-200';
        case 'orange': return 'bg-orange-50 text-bu-orange-500 border-orange-200';
        case 'emerald': return 'bg-emerald-50 text-emerald-600 border-emerald-200';
        case 'blue': return 'bg-blue-50 text-bu-blue-600 border-blue-200';
        case 'violet': return 'bg-purple-50 text-purple-600 border-purple-200';
        default: return 'bg-slate-100 text-slate-700 border-slate-200';
    }
}

function getButtonClass(color) {
    switch (color) {
        case 'navy': return 'bg-sidebar-blue hover:bg-sidebar-blue-hover text-white';
        case 'orange': return 'bg-bu-orange-500 hover:bg-bu-orange-600 text-white';
        case 'emerald': return 'bg-emerald-600 hover:bg-emerald-700 text-white';
        case 'blue': return 'bg-bu-blue-600 hover:bg-bu-blue-700 text-white';
        case 'violet': return 'bg-purple-600 hover:bg-purple-700 text-white';
        default: return 'bg-sidebar-blue text-white';
    }
}
</script>

<template>
    <div>
        <!-- 5-Card Hub Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div
                v-for="type in documentTypes"
                :key="type.id"
                class="card card-border bg-base-100 border-slate-200 hover:border-slate-300 hover:shadow-md transition-all duration-200 rounded-2xl flex flex-col justify-between p-5"
            >
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-10 h-10 rounded-xl border flex items-center justify-center"
                            :class="getIconContainerClass(type.color)"
                        >
                            <component :is="getCategoryIcon(type.id)" class="w-5 h-5" />
                        </div>
                        <span class="badge badge-outline border-slate-200 text-slate-600 text-[11px] font-medium">
                            {{ type.badge }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug">
                            {{ type.title }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-3">
                            {{ type.description }}
                        </p>
                    </div>
                </div>

                <div class="pt-4 mt-2 border-t border-slate-100">
                    <button
                        type="button"
                        @click="emit('selectCategory', type.id)"
                        class="btn btn-sm w-full border-none gap-2 font-medium"
                        :class="getButtonClass(type.color)"
                    >
                        <span>Open {{ type.title.split(' ')[0] }}</span>
                        <ArrowRight class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
