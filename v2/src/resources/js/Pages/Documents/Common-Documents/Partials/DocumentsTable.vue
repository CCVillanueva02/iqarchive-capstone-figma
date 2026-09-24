<!--
================================================================================
IQArchive v2 — Common Documents Table Partial
================================================================================
File: resources/js/Pages/Documents/Common-Documents/Partials/DocumentsTable.vue
Role: Displays filterable table of documents for the active office.
UI Standard: DaisyUI table, badge, btn, input, select.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { ref } from 'vue';
import { FileText, Download, UploadCloud, Search } from 'lucide-vue-next';

const props = defineProps({
    documents: {
        type: Array,
        required: true,
    },
    selectedOffice: {
        type: Object,
        default: null,
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

const emit = defineEmits(['filter', 'openUpload']);

const searchQuery = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || '');
const downloadingId = ref(null);

function handleSearchChange() {
    emit('filter', {
        search: searchQuery.value,
        status: statusFilter.value,
    });
}

function formatBytes(bytes) {
    if (!bytes || bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
}

function formatDate(dateStr) {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
}

async function downloadDocument(doc) {
    downloadingId.value = doc.id;
    try {
        const response = await fetch(`/documents/${doc.id}/download`);
        const data = await response.json();
        if (data.url) {
            window.open(data.url, '_blank');
        }
    } catch (err) {
        console.error('Download failed:', err);
    } finally {
        downloadingId.value = null;
    }
}
</script>

<template>
    <div class="card card-border bg-base-100 shadow-xs flex flex-col h-full min-h-0">
        <!-- Office Header & Toolbar -->
        <div class="p-4 space-y-3 border-b border-slate-100 shrink-0">
            <div class="min-w-0">
                <h3 class="text-base font-bold text-slate-900 leading-snug">
                    {{ selectedOffice ? selectedOffice.name : 'All Common Documents' }}
                </h3>
                <p
                    v-if="selectedOffice?.description"
                    class="text-xs text-slate-500 mt-1 leading-relaxed max-w-3xl"
                >
                    {{ selectedOffice.description }}
                </p>
            </div>

            <!-- Toolbar Filters -->
            <div class="flex flex-col sm:flex-row items-center gap-2">
                <label class="input input-sm input-bordered flex items-center gap-2 flex-1 w-full rounded-lg">
                    <Search class="w-3.5 h-3.5 text-slate-400 shrink-0" />
                    <input
                        v-model="searchQuery"
                        @input="handleSearchChange"
                        type="text"
                        placeholder="Search document title or filename..."
                        class="grow text-xs"
                    />
                </label>
                <select
                    v-model="statusFilter"
                    @change="handleSearchChange"
                    class="select select-sm select-bordered w-full sm:w-40 text-xs rounded-lg shrink-0"
                >
                    <option value="">All Statuses</option>
                    <option value="draft">Draft</option>
                    <option value="dean_appr">Dean Approved</option>
                    <option value="iqa_appr">IQA Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>

        <!-- Documents Table -->
        <div class="overflow-x-auto overflow-y-auto flex-1 min-h-0">
            <table class="table table-zebra table-sm w-full">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase bg-slate-50/80">
                        <th class="py-3 pl-4">Document</th>
                        <th>Uploader</th>
                        <th>Date Uploaded</th>
                        <th>Status</th>
                        <th class="text-right pr-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="doc in documents" :key="doc.id" class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3 pl-4">
                            <div class="flex items-start gap-2.5">
                                <FileText class="w-4 h-4 text-primary shrink-0 mt-0.5" />
                                <div class="space-y-0.5">
                                    <div class="text-xs font-bold text-slate-800 hover:text-primary transition line-clamp-1">
                                        {{ doc.title }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 font-mono tabular-nums">
                                        {{ doc.original_filename }} &bull; {{ formatBytes(doc.file_size_bytes) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-xs text-slate-600">
                            {{ doc.uploader?.name || 'System Admin' }}
                        </td>
                        <td class="text-xs text-slate-500 font-mono tabular-nums">
                            {{ formatDate(doc.created_at) }}
                        </td>
                        <td>
                            <span v-if="doc.status === 'iqa_appr'" class="badge badge-xs badge-success badge-soft font-semibold">IQA Approved</span>
                            <span v-else-if="doc.status === 'dean_appr'" class="badge badge-xs badge-info badge-soft font-semibold">Dean Approved</span>
                            <span v-else-if="doc.status === 'rejected'" class="badge badge-xs badge-error badge-soft font-semibold">Rejected</span>
                            <span v-else class="badge badge-xs badge-warning badge-soft font-semibold">Draft</span>
                        </td>
                        <td class="text-right pr-4">
                            <button
                                type="button"
                                @click="downloadDocument(doc)"
                                :disabled="downloadingId === doc.id"
                                class="btn btn-xs btn-ghost text-slate-600 hover:text-primary hover:bg-primary/10 gap-1 cursor-pointer"
                            >
                                <span v-if="downloadingId === doc.id" class="loading loading-spinner loading-xs"></span>
                                <Download v-else class="w-3.5 h-3.5" />
                                <span>View / Get</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Empty State -->
                    <tr v-if="documents.length === 0">
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-2 max-w-sm mx-auto">
                                <FileText class="w-10 h-10 text-slate-300" />
                                <p class="text-xs font-bold text-slate-700">No documents found</p>
                                <p class="text-[11px] text-slate-400">
                                    No records match this office filter. Check back later or upload new policies.
                                </p>
                                <button
                                    v-if="canUpload"
                                    type="button"
                                    @click="emit('openUpload')"
                                    class="btn btn-xs btn-outline border-sidebar-blue text-sidebar-blue hover:bg-sidebar-blue hover:border-sidebar-blue hover:text-white gap-1.5 mt-2"
                                >   
                                    Upload First Document
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
