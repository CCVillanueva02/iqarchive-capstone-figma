<!--
================================================================================
IQArchive v2 — Common Documents Workspace
================================================================================
File: resources/js/Pages/Documents/CommonDocuments.vue
Role: Central repository for university-wide Common Documents and office policies.
UI Standard: DaisyUI tabs, card, badge, btn.
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
import { FileText, FolderKanban, Building2, ChevronRight } from 'lucide-vue-next';

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
    <Head title="Common Documents — IQArchive" />

    <AppShell>
        <div class="space-y-5 max-w-7xl mx-auto">
            <!-- Header & Breadcrumbs -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-1">
                        <span>Documents</span>
                        <ChevronRight class="w-3 h-3 text-slate-400" />
                        <span class="text-orange-600 font-semibold">Common Documents</span>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                        Document Repository
                    </h1>
                </div>
            </div>

            <!-- Tab Bar -->
            <div class="border-b border-slate-200">
                <nav class="flex space-x-6 text-sm">
                    <button
                        type="button"
                        class="pb-3 border-b-2 border-orange-600 text-orange-600 font-bold flex items-center gap-2"
                    >
                        <FileText class="w-4 h-4" />
                        <span>Common Documents</span>
                    </button>

                    <button
                        type="button"
                        class="pb-3 border-b-2 border-transparent text-slate-400 font-medium flex items-center gap-2 cursor-not-allowed"
                        disabled
                    >
                        <FolderKanban class="w-4 h-4" />
                        <span>Program Accreditation</span>
                        <span class="badge badge-xs badge-ghost text-[10px]">Upcoming</span>
                    </button>

                    <button
                        type="button"
                        class="pb-3 border-b-2 border-transparent text-slate-400 font-medium flex items-center gap-2 cursor-not-allowed"
                        disabled
                    >
                        <Building2 class="w-4 h-4" />
                        <span>Institutional Records</span>
                        <span class="badge badge-xs badge-ghost text-[10px]">Upcoming</span>
                    </button>
                </nav>
            </div>

            <!-- Main Two-Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
                <div class="lg:col-span-4">
                    <OfficePanel
                        :offices="offices"
                        :selected-office-id="selectedOfficeId"
                        @select="handleSelectOffice"
                    />
                </div>

                <div class="lg:col-span-8">
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

        <!-- Upload Modal -->
        <UploadCommonDocModal
            :show="isUploadModalOpen"
            :offices="offices"
            :initial-office-id="selectedOfficeId"
            @close="isUploadModalOpen = false"
        />
    </AppShell>
</template>
