<!--
================================================================================
IQArchive v2 — Program Accreditation Master Workspace
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Index.vue
Role: Top-level orchestrator for 3-tier Program Accreditation workspace
UI Standard: DaisyUI + DESIGN.md tokens (< 190 lines)
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import CollegeGrid from './Partials/Navigation/CollegeGrid.vue';
import ProgramGrid from './Partials/Navigation/ProgramGrid.vue';
import TierContextCard from './Partials/Navigation/TierContextCard.vue';
import AddProgramModal from './Partials/Modals/AddProgramModal.vue';
import UploadDocumentModal from './Partials/Modals/UploadDocumentModal.vue';
import DocumentTypeHub from './Partials/Hub/DocumentTypeHub.vue';
import SupportingDocsView from './Partials/DocumentTypes/SupportingDocs/SupportingDocsView.vue';
import SelfSurveyView from './Partials/DocumentTypes/SelfSurvey/SelfSurveyView.vue';
import ComplianceReportsView from './Partials/DocumentTypes/ComplianceReports/ComplianceReportsView.vue';
import PppView from './Partials/DocumentTypes/Ppp/PppView.vue';
import NarrativeProfileView from './Partials/DocumentTypes/NarrativeProfile/NarrativeProfileView.vue';
import { ChevronRight, ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    currentTier: { type: Number, default: 1 },
    colleges: { type: Array, default: () => [] },
    selectedCollege: { type: Object, default: null },
    selectedProgram: { type: Object, default: null },
    programs: { type: Array, default: () => [] },
    documentTypes: { type: Array, default: () => [] },
    activeCategory: { type: String, default: 'hub' },
    instrument: { type: Object, default: null },
    documents: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({ search: '' }) },
});

const isAddProgramOpen = ref(false);
const isUploadDocOpen = ref(false);
const uploadCategory = ref('supporting-documents');
const uploadCriterionId = ref(null);

function handleSelectCollege(collegeId) {
    router.get('/documents/program-accreditation', { college_id: collegeId }, { preserveScroll: true });
}

function handleSelectProgram(programId) {
    router.get('/documents/program-accreditation', { college_id: props.selectedCollege.id, program_id: programId }, { preserveScroll: true });
}

function handleSelectCategory(cat) {
    router.get('/documents/program-accreditation', {
        college_id: props.selectedCollege.id,
        program_id: props.selectedProgram.id,
        category: cat,
    }, { preserveScroll: true });
}

function handleBackToColleges() {
    router.get('/documents/program-accreditation', {}, { preserveScroll: true });
}

function handleBackToPrograms() {
    router.get('/documents/program-accreditation', { college_id: props.selectedCollege.id }, { preserveScroll: true });
}

function handleBackToHub() {
    handleSelectCategory('hub');
}

function handleOpenUpload(cat = 'supporting-documents', critId = null) {
    uploadCategory.value = typeof cat === 'string' ? cat : 'supporting-documents';
    uploadCriterionId.value = critId;
    isUploadDocOpen.value = true;
}

const activeCategoryTitle = computed(() => {
    const item = props.documentTypes.find((t) => t.id === props.activeCategory);
    return item ? item.title : props.activeCategory;
});
</script>

<template>
    <Head title="Program Accreditation — IQArchive" />

    <AppShell :hide-topbar="true" :hide-breadcrumbs="true">
        <div class="h-[calc(100vh-3rem)] lg:h-[calc(100vh-4rem)] flex flex-col space-y-4 max-w-7xl mx-auto">
            <!-- Header bar with breadcrumbs & upper right College Details card -->
            <div class="pb-3 border-b border-slate-200 shrink-0 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-3 flex-1 min-w-0">
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Program Accreditation Documents</h1>

                    <!-- Breadcrumb Navigation Bar -->
                    <div class="py-2 px-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2 text-xs">
                        <button v-if="currentTier === 2" type="button" @click="handleBackToColleges" class="btn btn-ghost btn-xs btn-circle text-slate-500" title="Back to Colleges">
                            <ArrowLeft class="w-3.5 h-3.5" />
                        </button>
                        <button v-else-if="currentTier === 3 && activeCategory === 'hub'" type="button" @click="handleBackToPrograms" class="btn btn-ghost btn-xs btn-circle text-slate-500" title="Back to Programs">
                            <ArrowLeft class="w-3.5 h-3.5" />
                        </button>
                        <button v-else-if="currentTier === 3 && activeCategory !== 'hub'" type="button" @click="handleBackToHub" class="btn btn-ghost btn-xs btn-circle text-slate-500" title="Back to Hub">
                            <ArrowLeft class="w-3.5 h-3.5" />
                        </button>

                        <span class="text-slate-500 font-medium">Documents</span>
                        <ChevronRight class="w-3.5 h-3.5 text-slate-400" />

                        <button type="button" @click="handleBackToColleges" class="font-medium hover:underline text-slate-600" :class="{ 'text-slate-900 font-bold': currentTier === 1 }">
                            Program Accreditation
                        </button>

                        <template v-if="currentTier >= 2 && selectedCollege">
                            <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                            <button type="button" @click="handleBackToPrograms" class="hover:underline flex items-center gap-1 font-medium text-slate-700" :class="{ 'text-slate-900 font-bold': currentTier === 2 }">
                                <span>{{ selectedCollege.code }}</span>
                            </button>
                        </template>

                        <template v-if="currentTier === 3 && selectedProgram">
                            <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                            <button type="button" @click="handleBackToHub" class="font-medium hover:underline" :class="{ 'text-slate-900 font-bold': activeCategory === 'hub' }">
                                {{ selectedProgram.name }}
                            </button>
                        </template>

                        <template v-if="currentTier === 3 && activeCategory !== 'hub'">
                            <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                            <span class="font-bold text-slate-900">{{ activeCategoryTitle }}</span>
                        </template>
                    </div>
                </div>

                <!-- Upper Right: Details Card (Contextual per Tier) -->
                <div class="shrink-0 w-full md:w-72">
                    <TierContextCard
                        :current-tier="currentTier"
                        :active-category="activeCategory"
                        :active-category-title="activeCategoryTitle"
                        :college="selectedCollege"
                        :program="selectedProgram"
                        :programs-count="programs.length"
                        :colleges-count="colleges.length"
                    />
                </div>
            </div>

            <!-- Content Area (Scrollable) -->
            <div class="flex-1 min-h-0 overflow-y-auto pr-1">
                <!-- Tier 1: Colleges -->
                <CollegeGrid v-if="currentTier === 1" :colleges="colleges" :initial-search="filters.search" @select="handleSelectCollege" />

                <!-- Tier 2: Programs -->
                <ProgramGrid v-else-if="currentTier === 2 && selectedCollege" :college="selectedCollege" :programs="programs" :initial-search="filters.search" @select="handleSelectProgram" @open-add-program="isAddProgramOpen = true" />

                <!-- Tier 3: Hub -->
                <DocumentTypeHub v-else-if="currentTier === 3 && activeCategory === 'hub'" :college="selectedCollege" :program="selectedProgram" :document-types="documentTypes" :documents="documents" @select-category="handleSelectCategory" @switch-program="handleBackToPrograms" @open-upload="handleOpenUpload" />

                <!-- Tier 4: The 5 Document Type Workspaces -->
                <SupportingDocsView v-else-if="currentTier === 3 && activeCategory === 'supporting-documents'" :college="selectedCollege" :program="selectedProgram" :instrument="instrument" :documents="documents" @open-upload="handleOpenUpload('supporting-documents', $event)" @back-to-hub="handleBackToHub" />

                <SelfSurveyView v-else-if="currentTier === 3 && activeCategory === 'self-survey'" :college="selectedCollege" :program="selectedProgram" @back-to-hub="handleBackToHub" />

                <ComplianceReportsView v-else-if="currentTier === 3 && activeCategory === 'compliance-reports'" :college="selectedCollege" :program="selectedProgram" :documents="documents" @open-upload="handleOpenUpload('compliance-reports')" @back-to-hub="handleBackToHub" />

                <PppView v-else-if="currentTier === 3 && activeCategory === 'ppp'" :college="selectedCollege" :program="selectedProgram" :documents="documents" @open-upload="handleOpenUpload('ppp')" @back-to-hub="handleBackToHub" />

                <NarrativeProfileView v-else-if="currentTier === 3 && activeCategory === 'narrative-profile'" :college="selectedCollege" :program="selectedProgram" :documents="documents" @open-upload="handleOpenUpload('narrative-profile')" @back-to-hub="handleBackToHub" />
            </div>
        </div>

        <!-- Modals -->
        <AddProgramModal :show="isAddProgramOpen" :college="selectedCollege" @close="isAddProgramOpen = false" />
        <UploadDocumentModal :show="isUploadDocOpen" :program="selectedProgram" :initial-category="uploadCategory" :initial-criterion-id="uploadCriterionId" @close="isUploadDocOpen = false" />
    </AppShell>
</template>
