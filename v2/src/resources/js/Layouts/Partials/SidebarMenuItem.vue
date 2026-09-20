<!--
================================================================================
IQArchive v2 — Master SidebarMenuItem
================================================================================
File: resources/js/Layouts/Partials/SidebarMenuItem.vue
Responsibility: Renders a single sidebar item with speech-bubble callout flyout
                (zero-gap hover bridge + left pointer arrow), accordion, or link.
================================================================================
-->

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    item: {
        type: Object,
        required: true,
    },
    isCollapsed: {
        type: Boolean,
        default: false,
    },
    isUrlActive: {
        type: Function,
        required: true,
    },
});
</script>

<template>
    <li class="relative">
        <div
            v-if="isCollapsed && item.children"
            class="relative group/flyout w-full flex justify-center p-0"
        >
            <button
                type="button"
                :class="[
                    'py-2 w-full rounded-lg text-xs font-medium transition-colors flex justify-center items-center cursor-pointer focus-visible:ring-2 focus-visible:ring-bu-orange-500/50 focus-visible:outline-none',
                    item.children.some(c => isUrlActive(c.href))
                        ? 'bg-bu-orange-500 text-white shadow-xs font-semibold'
                        : 'text-slate-300 hover:bg-white/10 hover:text-white'
                ]"
                :aria-label="item.name"
            >
                <component
                    :is="item.icon"
                    :class="[
                        'w-4 h-4 shrink-0',
                        item.children.some(c => isUrlActive(c.href)) ? 'text-white' : 'text-slate-400 group-hover/flyout:text-white'
                    ]"
                />
            </button>

            <!-- Zero-gap speech bubble flyout container with left pointer caret -->
            <div class="absolute left-full top-0 pl-3 z-50 transition-all duration-150 opacity-0 pointer-events-none scale-95 group-hover/flyout:opacity-100 group-hover/flyout:pointer-events-auto group-hover/flyout:scale-100">
                <!-- Speech Bubble Box with Rotated Notch on Left Border -->
                <div class="relative bg-[#0F172A] border border-slate-700/90 rounded-xl p-2.5 shadow-2xl shadow-black/60 w-60 text-slate-200">
                    <!-- Left Pointer Caret (Reference Design Rotated to Point Left) -->
                    <div
                        class="absolute -left-1.5 top-3.5 w-3 h-3 bg-[#0F172A] border-l border-b border-slate-700/90 rotate-45 pointer-events-none"
                        aria-hidden="true"
                    ></div>

                    <!-- Category Title Header -->
                    <div class="px-2 pb-2 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-800">
                        {{ item.name }}
                    </div>

                    <!-- Submenu Links (nav container avoids DaisyUI .menu li ul tree indentation) -->
                    <nav class="pt-1.5 space-y-1 w-full flex flex-col" :aria-label="`${item.name} submenu`">
                        <Link
                            v-for="child in item.children"
                            :key="child.name"
                            :href="child.href"
                            :class="[
                                'w-full py-2 px-2.5 rounded-lg text-xs font-medium transition-all flex items-center gap-2.5 focus-visible:ring-2 focus-visible:ring-bu-orange-500/50 focus-visible:outline-none',
                                isUrlActive(child.href)
                                    ? 'bg-bu-orange-500 text-white font-semibold shadow-xs'
                                    : 'text-slate-300 hover:text-white hover:bg-white/10'
                            ]"
                        >
                            <component :is="child.icon" class="w-4 h-4 shrink-0 opacity-80" />
                            <span class="truncate flex-1 min-w-0">{{ child.name }}</span>
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <!-- 2. Expanded Mode: Nested Collapsible Accordion -->
        <details v-else-if="!isCollapsed && item.children" :open="item.isOpen">
            <summary
                :class="[
                    'py-2 px-3 rounded-lg text-xs font-medium transition-colors hover:bg-white/10 hover:text-white',
                    item.children.some(c => isUrlActive(c.href)) ? 'text-white font-semibold bg-white/5' : 'text-slate-300'
                ]"
            >
                <div class="flex items-center gap-3 min-w-0">
                    <component :is="item.icon" class="w-4 h-4 shrink-0 text-slate-400 group-hover:text-white" />
                    <span class="truncate">{{ item.name }}</span>
                </div>
            </summary>
            <ul class="before:bg-slate-700/60 ml-2 pl-2 mt-1 space-y-0.5">
                <li v-for="child in item.children" :key="child.name">
                    <Link
                        :href="child.href"
                        :class="[
                            'py-1.5 px-2.5 rounded-md text-[11px] font-medium transition-all flex items-center gap-2',
                            isUrlActive(child.href)
                                ? 'bg-bu-orange-500 text-white font-semibold shadow-xs'
                                : 'text-slate-400 hover:text-white hover:bg-white/10'
                        ]"
                    >
                        <component :is="child.icon" class="w-3.5 h-3.5 shrink-0 opacity-70" />
                        <span class="truncate">{{ child.name }}</span>
                    </Link>
                </li>
            </ul>
        </details>

        <!-- 3. Single Top-level Link -->
        <Link
            v-else
            :href="item.href"
            :class="[
                'py-2 px-3 rounded-lg text-xs font-medium transition-all flex items-center group',
                isCollapsed ? 'justify-center px-0' : 'justify-between',
                isUrlActive(item.href)
                    ? 'bg-bu-orange-500 text-white font-semibold shadow-xs'
                    : 'text-slate-300 hover:text-white hover:bg-white/10'
            ]"
            :title="isCollapsed ? item.name : undefined"
        >
            <div :class="['flex items-center', isCollapsed ? 'justify-center' : 'gap-3 min-w-0']">
                <component
                    :is="item.icon"
                    :class="[
                        'w-4 h-4 shrink-0 transition-colors',
                        isUrlActive(item.href) ? 'text-white' : 'text-slate-400 group-hover:text-white'
                    ]"
                />
                <span v-if="!isCollapsed" class="truncate">{{ item.name }}</span>
            </div>
            <span
                v-if="item.badge && !isCollapsed"
                :class="['badge badge-xs font-bold shrink-0', item.badgeClass || 'badge-warning']"
            >
                {{ item.badge }}
            </span>
        </Link>
    </li>
</template>
