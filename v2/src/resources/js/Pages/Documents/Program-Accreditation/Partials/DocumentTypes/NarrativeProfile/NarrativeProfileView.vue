<!--
================================================================================
IQArchive v2 — Narrative Profile Workspace (Tier 4)
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/DocumentTypes/NarrativeProfile/NarrativeProfileView.vue
Role: Repository for Narrative Profile qualitative program exhibits & summaries.
UI Standard: DaisyUI table, badge, btn (< 150 lines).
================================================================================
-->

<script setup>
import { computed } from 'vue';
import { BookOpen, UploadCloud, Download } from 'lucide-vue-next';

const props = defineProps({
    program: { type: Object, required: true },
    college: { type: Object, required: true },
    documents: { type: Array, default: () => [] },
});

const emit = defineEmits(['openUpload', 'backToHub']);

const narrativeDocs = computed(() => {
    return props.documents.filter((d) =>
        (d.category?.name || '').toLowerCase().includes('narrative') ||
        (d.title || '').toLowerCase().includes('narrative')
    );
});
</script>

<template>
    <div class="space-y-4">
        <!-- Header Banner -->
        <div class="card card-border bg-base-100 border-slate-200 p-5 rounded-2xl shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl border flex items-center justify-center shrink-0 bg-purple-50 text-purple-600 border-purple-200">
                        <BookOpen class="w-5 h-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Narrative Profile</h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Comprehensive qualitative narratives, executive summaries, and institutional advancement evidence (Levels 3 & 4).
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    @click="emit('openUpload', 'narrative-profile')"
                    class="btn btn-sm text-white border-none gap-1.5 shadow-xs bg-purple-600 hover:bg-purple-700"
                >
                    <UploadCloud class="w-4 h-4" />
                    <span>Upload Document</span>
                </button>
            </div>
        </div>

        <!-- Documents Table -->
        <div class="card card-border bg-base-100 border-slate-200 rounded-2xl overflow-hidden shadow-xs">
            <div v-if="narrativeDocs.length > 0" class="overflow-x-auto">
                <table class="table table-sm w-full text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600">
                            <th>Document Title</th>
                            <th>Original Filename</th>
                            <th>Uploader</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="doc in narrativeDocs" :key="doc.id" class="hover:bg-slate-50/50">
                            <td class="font-bold text-slate-900">{{ doc.title }}</td>
                            <td class="text-slate-500">{{ doc.original_filename }}</td>
                            <td class="text-slate-600">{{ doc.uploader?.name || 'System' }}</td>
                            <td>
                                <span class="badge badge-success badge-soft text-[10px] font-semibold">
                                    Approved
                                </span>
                            </td>
                            <td class="text-right">
                                <a
                                    :href="`/documents/${doc.id}/download`"
                                    class="btn btn-ghost btn-xs text-sidebar-blue hover:bg-blue-50 gap-1 font-semibold"
                                >
                                    <Download class="w-3.5 h-3.5" />
                                    <span>Download</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div v-else class="p-12 text-center text-slate-400 text-xs">
                <BookOpen class="w-10 h-10 text-slate-300 mx-auto mb-2" />
                <p class="font-bold text-slate-700">No Narrative Profile documents uploaded</p>
                <p class="mt-1">Upload the official narrative exhibit to attach it to this degree program.</p>
            </div>
        </div>
    </div>
</template>
