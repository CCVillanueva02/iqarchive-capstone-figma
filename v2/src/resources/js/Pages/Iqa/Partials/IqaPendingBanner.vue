<!--
================================================================================
IQArchive v2 — IQA Pending Verification Action Banner
================================================================================
File: resources/js/Pages/Iqa/Partials/IqaPendingBanner.vue
Role: Highlights pending common documents awaiting IQA staff review.
================================================================================
-->

<script setup>
import { Link } from '@inertiajs/vue3';
import { AlertCircle, ArrowRight } from 'lucide-vue-next';

defineProps({
    pendingCount: {
        type: Number,
        default: 0,
    },
});
</script>

<template>
    <div class="card bg-[#0B1B3D] text-white p-6 shadow-sm border border-slate-800 rounded-2xl">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5 ring-1 ring-amber-500/30">
                    <AlertCircle class="w-5 h-5" />
                </div>
                <div class="space-y-1">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h2 class="text-base font-bold text-white">
                            Pending Common Documents Verification
                        </h2>
                        <span class="badge badge-warning badge-sm font-bold tabular-nums">
                            {{ pendingCount }} Pending
                        </span>
                    </div>
                    <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                        There are {{ pendingCount }} common document(s) uploaded by staff awaiting verification. Review uploaded files, manage approval status, or flag documents.
                    </p>
                </div>
            </div>

            <Link
                href="/documents?tab=common-documents"
                class="btn bg-bu-orange-500 hover:bg-bu-orange-600 text-white border-0 btn-sm gap-2 shadow-sm shrink-0 px-4 self-start lg:self-center font-semibold"
            >
                <span>Review Pending Documents</span>
                <ArrowRight class="w-4 h-4" />
            </Link>
        </div>
    </div>
</template>
