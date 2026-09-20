<!--
================================================================================
IQArchive v2 — IQA Recent Document Submissions Table
================================================================================
File: resources/js/Pages/Iqa/Partials/IqaSubmissionsTable.vue
Role: Renders recent document submissions with program codes, uploaders, and status pills.
================================================================================
-->

<script setup>
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';

defineProps({
    submissions: {
        type: Array,
        default: () => [],
    },
});

// Format document status badge styles
const getStatusBadge = (status) => {
    switch (status?.toLowerCase()) {
        case 'verified':
        case 'approved':
            return { label: 'VERIFIED', class: 'badge-success badge-soft' };
        case 'pending':
            return { label: 'PENDING', class: 'badge-warning badge-soft' };
        case 'deficit':
        case 'rejected':
            return { label: 'DEFICIT', class: 'badge-error badge-soft' };
        default:
            return { label: status?.toUpperCase() || 'DRAFT', class: 'badge-neutral badge-soft' };
    }
};
</script>

<template>
    <div class="card card-border bg-base-100 shadow-xs rounded-2xl overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Recent Document Submissions</h3>
                <p class="text-xs text-slate-500">Newly archived program compliance documents</p>
            </div>
            <Link
                href="/documents"
                class="text-xs font-semibold text-bu-orange-500 hover:text-bu-orange-600 flex items-center gap-1 transition-colors"
            >
                <span>Manage All Files</span>
                <ChevronRight class="w-3.5 h-3.5" />
            </Link>
        </div>

        <!-- Data Table (DaisyUI) -->
        <div class="overflow-x-auto">
            <table class="table table-zebra table-sm w-full">
                <thead>
                    <tr class="text-[11px] uppercase tracking-wider text-slate-400 bg-slate-50/70 border-b border-slate-200/60">
                        <th class="py-3 px-6">Title</th>
                        <th class="py-3 px-4">Program</th>
                        <th class="py-3 px-4">Uploader</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-6 text-right">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="doc in submissions"
                        :key="doc.id"
                        class="hover:bg-slate-50/80 transition-colors group cursor-pointer"
                    >
                        <td class="py-3.5 px-6 max-w-xs">
                            <div class="font-semibold text-xs text-slate-900 truncate group-hover:text-bu-orange-500 transition-colors">
                                {{ doc.title }}
                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5">
                                Supporting Documents
                            </div>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-xs font-semibold text-slate-700">
                            {{ doc.program }}
                        </td>
                        <td class="py-3.5 px-4 text-xs text-slate-600">
                            {{ doc.uploader }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span :class="['badge badge-xs font-bold', getStatusBadge(doc.status).class]">
                                {{ getStatusBadge(doc.status).label }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-right text-xs font-mono tabular-nums text-slate-500">
                            {{ doc.created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
