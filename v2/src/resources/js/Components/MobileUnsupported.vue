<!--
================================================================================
IQArchive v2 — Mobile & Tablet Viewport Barrier Component
================================================================================
File: resources/js/Components/MobileUnsupported.vue
Purpose: Enforces the mandatory >= 1024px desktop workstation requirement.
         Blocks access on smaller viewports with a clear institutional notice.
Design System Ref: v2/docs/design-system.md (Section 1.1)
================================================================================
-->

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Monitor, AlertTriangle } from 'lucide-vue-next';

const isMobile = ref(false);
const currentWidth = ref(0);

const checkViewport = () => {
    if (typeof window !== 'undefined') {
        currentWidth.value = window.innerWidth;
        isMobile.value = window.innerWidth < 1024;
    }
};

onMounted(() => {
    checkViewport();
    window.addEventListener('resize', checkViewport);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkViewport);
});
</script>

<template>
    <div
        v-if="isMobile"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-900 text-white p-6 text-center"
    >
        <div class="max-w-md bg-slate-800 border border-slate-700 rounded-2xl p-8 shadow-2xl flex flex-col items-center">
            <!-- Icon with BU Orange accent ring -->
            <div class="w-16 h-16 rounded-full bg-orange-500/10 border border-orange-500/30 flex items-center justify-center mb-6 text-orange-500">
                <Monitor class="w-8 h-8" />
            </div>

            <!-- Title & Wordmark -->
            <div class="text-xs uppercase tracking-widest font-semibold text-orange-400 mb-1">
                Bicol University · IQArchive v2
            </div>
            <h1 class="text-xl font-bold text-white mb-3">
                Workstation Desktop Display Required
            </h1>

            <!-- Description -->
            <p class="text-sm text-slate-300 leading-relaxed mb-6">
                IQArchive accreditation tools, 10-area evidence matrices, and document verification interfaces require a minimum screen width of <strong>1024px</strong>. Please access this portal from a desktop workstation or laptop computer.
            </p>

            <!-- Viewport Diagnostic Pill -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900/80 border border-slate-700 text-xs text-slate-400 font-mono">
                <AlertTriangle class="w-3.5 h-3.5 text-amber-400" />
                <span>Current: <strong class="text-amber-300">{{ currentWidth }}px</strong> · Required: <strong class="text-emerald-400">&ge; 1024px</strong></span>
            </div>
        </div>
    </div>
</template>
