<!--
================================================================================
IQArchive v2 — Internal Accreditor Evaluation Portal
================================================================================
File: resources/js/Pages/InternalAccreditor/Index.vue
Role Scope: role == 'internal_accreditor'
================================================================================
-->

<script setup>
import { Head } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import { Construction } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <Head title="Internal Accreditor Portal" />

    <AppShell>
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center p-6">
            <div class="card card-border bg-base-100 shadow-sm max-w-md w-full p-8 flex flex-col items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-warning/10 text-warning flex items-center justify-center">
                    <Construction class="w-6 h-6" />
                </div>
                <div class="space-y-1">
                    <h1 class="text-xl font-bold tracking-tight text-base-content">Site is in progress</h1>
                    <p class="text-xs text-base-content/60">The Internal Accreditor mock-survey portal is currently under active development.</p>
                </div>
                <div class="badge badge-warning badge-soft text-xs font-semibold">
                    Work in progress
                </div>
            </div>
        </div>
    </AppShell>
</template>
