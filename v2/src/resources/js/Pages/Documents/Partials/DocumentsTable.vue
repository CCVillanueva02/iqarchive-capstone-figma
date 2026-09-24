<!--
================================================================================
IQArchive v2 — Common Documents Table Partial
================================================================================
File: resources/js/Pages/Documents/Partials/DocumentsTable.vue
Role: Displays filterable table of documents for the active office.
UI Standard: DaisyUI table, badge, btn, input, select.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { ref } from 'vue';
import { FileText, Download, UploadCloud, Search, ExternalLink } from 'lucide-vue-next';

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
    <div class="card card-border bg-base-100 shadow-xs flex flex-col h-full">
        <!-- Office Header & Toolbar -->
        <div class="card-body p-4 space-y-4 border-b border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span>{{ selectedOffice ? selectedOffice.name : 'All Common Documents' }}</span>
                        <span class="badge badge-sm badge-outline tabular-nums font-mono">
                            {{ documents.length }} files
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">
                        {{ selectedOffice?.description || 'Central repository of university-wide policies and regulatory documents.' }}
                    </p>
                </div>

                <button
                    v-if="canUpload"
                    type="button"
                    @click="emit('openUpload')"
                    class="btn btn-sm bg-orange-600 hover:bg-orange-700 text-white border-none shrink-0 cursor-pointer shadow-xs gap-1.5"
                >
                    <UploadCloud class="w-4 h-4" />
                    <span>Upload Document</span>
                </button>
            </div>

            <!-- Toolbar Filters -->
            <div class="flex flex-col sm:flex-row items-center gap-2">
                <div class="relative flex-1 w-full">
                    <Search class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="searchQuery"
                        @input="handleSearchChange"
                        type="text"
                        placeholder="Search document title or filename..."
                        class="input input-sm input-bordered w-full pl-8 text-xs rounded-lg"
                    />
                </div>
                <select
                    v-model="statusFilter"
                    @change="handleSearchChange"
                    class="select select-sm select-bordered w-full sm:w-40 text-xs rounded-lg"
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
        <div class="overflow-x-auto flex-1">
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
                                <FileText class="w-4 h-4 text-orange-600 shrink-0 mt-0.5" />
                                <div class="space-y-0.5">
                                    <div class="text-xs font-bold text-slate-800 hover:text-orange-600 transition line-clamp-1">
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
                                class="btn btn-xs btn-ghost text-slate-600 hover:text-orange-600 hover:bg-orange-50 gap-1 cursor-pointer"
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
                                    class="btn btn-xs btn-outline border-slate-300 text-slate-700 hover:bg-slate-100 mt-2"
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
