<!--
================================================================================
IQArchive v2 — Master AppSidebar
================================================================================
File: resources/js/Layouts/Partials/AppSidebar.vue
Responsibility: Persistent deep navy aside navigation with centered BU Seal logo,
                DaisyUI menu, cleanly centered collapsed rail, and middle expand toggle.
================================================================================
-->

<script setup>
import { Link } from '@inertiajs/vue3';
import { ChevronRight, ChevronLeft } from 'lucide-vue-next';
import SidebarMenuItem from '@/Layouts/Partials/SidebarMenuItem.vue';

defineProps({
    isCollapsed: {
        type: Boolean,
        default: false,
    },
    roleMeta: {
        type: Object,
        required: true,
    },
    sections: {
        type: Array,
        required: true,
    },
    isUrlActive: {
        type: Function,
        required: true,
    },
});

defineEmits(['toggleCollapse']);
</script>

<template>
    <aside
        :class="[
            'relative bg-[#0B1B3D] border-r border-[#15264a] text-slate-200 flex flex-col justify-between shrink-0 transition-all duration-200 z-30 select-none shadow-xl',
            isCollapsed ? 'w-20' : 'w-64'
        ]"
    >
        <!-- Expand Toggle: Floating button in the middle edge of the collapsed sidebar -->
        <button
            v-if="isCollapsed"
            type="button"
            @click="$emit('toggleCollapse')"
            class="absolute -right-3.5 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-[#0E214A] hover:bg-bu-orange-500 text-slate-300 hover:text-white border border-bu-orange-500 hover:border-bu-orange-500 shadow-xl flex items-center justify-center cursor-pointer transition-all duration-150 z-50 group"
            title="Expand sidebar"
            aria-label="Expand sidebar"
        >
            <ChevronRight class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
        </button>

        <!-- 1. Header & Institutional Wordmark with Centered BU Seal Logo -->
        <div :class="[
            'h-16 border-b border-white/10 flex items-center shrink-0 bg-[#081530] transition-all',
            isCollapsed ? 'justify-center px-0' : 'justify-between px-4'
        ]">
            <Link
                href="/"
                :class="[
                    'flex items-center overflow-hidden transition-all',
                    isCollapsed ? 'justify-center w-full' : 'gap-3'
                ]"
            >
                <div class="w-9 h-9 rounded-lg bg-white/10 p-0.5 flex items-center justify-center shrink-0 shadow-xs ring-1 ring-white/10 overflow-hidden">
                    <img src="/bulogo.png" alt="Bicol University Seal" class="w-full h-full object-contain" />
                </div>
                <div v-if="!isCollapsed" class="leading-tight truncate">
                    <div class="font-bold text-base tracking-tight text-white flex items-center gap-1.5">
                        <span>IQArchive</span>
                    </div>
                    <div class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase truncate">
                        {{ roleMeta.officeLabel }}
                    </div>
                </div>
            </Link>

            <button
                v-if="!isCollapsed"
                type="button"
                @click="$emit('toggleCollapse')"
                class="p-1.5 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors cursor-pointer"
                title="Collapse sidebar"
                aria-label="Collapse sidebar"
            >
                <ChevronLeft class="w-4 h-4" />
            </button>
        </div>

        <!-- 2. Navigation Area: DaisyUI Menu with Flyout Support -->
        <div :class="['flex-1 px-2 py-3 space-y-4 scrollbar-none', isCollapsed ? 'overflow-visible' : 'overflow-y-auto overflow-x-hidden']">
            <div v-for="section in sections" :key="section.title" class="space-y-1">
                <!-- Section Header Title -->
                <div
                    v-if="!isCollapsed"
                    class="px-3 pt-2 pb-1 text-[10px] font-extrabold uppercase tracking-[1.5px] text-slate-400"
                >
                    {{ section.title }}
                </div>

                <ul class="menu menu-sm w-full gap-0.5 p-0">
                    <SidebarMenuItem
                        v-for="item in section.items"
                        :key="item.name"
                        :item="item"
                        :is-collapsed="isCollapsed"
                        :is-url-active="isUrlActive"
                    />
                </ul>
            </div>
        </div>

        <!-- 3. Sidebar Footer Slot -->
        <slot name="footer" />
    </aside>
</template>
