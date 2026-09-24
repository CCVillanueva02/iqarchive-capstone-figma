<!--
================================================================================
IQArchive v2 — Common Documents Workspace
================================================================================
File: resources/js/Pages/Documents/Common-Documents/Index.vue
Role: Central repository for university-wide Common Documents and office policies.
UI Standard: DaisyUI card, badge, btn.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import OfficePanel from './Partials/OfficePanel.vue';
import DocumentsTable from './Partials/DocumentsTable.vue';
import UploadCommonDocModal from './Partials/UploadCommonDocModal.vue';
import AddOfficeModal from './Partials/AddOfficeModal.vue';
import { Plus, UploadCloud } from 'lucide-vue-next';

const props = defineProps({
    activeTab: {
        type: String,
        default: 'common-documents',
    },
    offices: {
        type: Array,
        required: true,
    },
    selectedOfficeId: {
        type: [Number, String],
        default: null,
    },
    documents: {
        type: Array,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({ search: '', status: '' }),
    },
    canUpload: {
        type: Boolean,
        default: false,
    },
});

const isUploadModalOpen = ref(false);
const isAddOfficeModalOpen = ref(false);

const activeOffice = computed(() => {
    return props.offices.find((o) => Number(o.id) === Number(props.selectedOfficeId)) || props.offices[0] || null;
});

function handleSelectOffice(officeId) {
    router.get(
        '/documents',
        {
            tab: 'common-documents',
            office_id: officeId,
            search: props.filters.search,
            status: props.filters.status,
        },
        { preserveState: true, preserveScroll: true }
    );
}

function handleFilter({ search, status }) {
    router.get(
        '/documents',
        {
            tab: 'common-documents',
            office_id: props.selectedOfficeId,
            search,
            status,
        },
        { preserveState: true, preserveScroll: true }
    );
}
</script>

<template>
    <Head :title="'Common Documents — IQArchive'" />

    <AppShell :hide-topbar="true" :hide-breadcrumbs="true">
        <div class="h-[calc(100vh-3rem)] lg:h-[calc(100vh-4rem)] flex flex-col space-y-4 max-w-7xl mx-auto">
            <!-- Header (shrink-0) -->
            <div class="pb-3 border-b border-slate-200 shrink-0 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                        Common Documents
                    </h1>
                </div>

                <!-- Header Actions (Rightmost) -->
                <div v-if="canUpload" class="flex items-center gap-2">
                    <button
                        type="button"
                        @click="isAddOfficeModalOpen = true"
                        class="btn btn-sm btn-outline border-sidebar-blue text-sidebar-blue hover:bg-sidebar-blue hover:border-sidebar-blue hover:text-white gap-1.5"
                    >
                        <Plus class="w-4 h-4" />
                        <span>Add Office</span>
                    </button>

                    <button
                        type="button"
                        @click="isUploadModalOpen = true"
                        class="btn btn-sm bg-sidebar-blue hover:bg-sidebar-blue-hover text-white border-none gap-1.5"
                    >
                        <UploadCloud class="w-4 h-4" />
                        <span>Upload Document</span>
                    </button>
                </div>
            </div>

            <!-- Main Two-Column Layout (1/4 left, 3/4 right) (full height) -->
            <div class="flex-1 min-h-0 grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
                <div class="lg:col-span-2 h-full min-h-0">
                    <OfficePanel
                        :offices="offices"
                        :selected-office-id="selectedOfficeId"
                        @select="handleSelectOffice"
                    />
                </div>

                <div class="lg:col-span-10 h-full min-h-0">
                    <DocumentsTable
                        :documents="documents"
                        :selected-office="activeOffice"
                        :filters="filters"
                        :can-upload="canUpload"
                        @filter="handleFilter"
                        @open-upload="isUploadModalOpen = true"
                    />
                </div>
            </div>
        </div>

        <!-- Upload Common Document Modal -->
        <UploadCommonDocModal
            :show="isUploadModalOpen"
            :offices="offices"
            :initial-office-id="selectedOfficeId"
            @close="isUploadModalOpen = false"
        />

        <!-- Add Administrative Office Modal -->
        <AddOfficeModal
            :show="isAddOfficeModalOpen"
            @close="isAddOfficeModalOpen = false"
        />
    </AppShell>
</template>
