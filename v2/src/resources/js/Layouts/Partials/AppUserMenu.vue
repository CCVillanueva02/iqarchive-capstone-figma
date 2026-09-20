<!--
================================================================================
IQArchive v2 — Master AppUserMenu
================================================================================
File: resources/js/Layouts/Partials/AppUserMenu.vue
Responsibility: User profile drawer/dropdown at sidebar bottom with account settings
                and sign-out action.
================================================================================
-->

<script setup>
import { Link } from '@inertiajs/vue3';
import { ChevronDown, Settings, LogOut } from 'lucide-vue-next';

defineProps({
    user: {
        type: Object,
        required: true,
    },
    roleMeta: {
        type: Object,
        required: true,
    },
    userInitials: {
        type: String,
        default: 'U',
    },
    isCollapsed: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="p-3 border-t border-white/10 bg-[#081530] shrink-0">
        <div class="dropdown dropdown-top w-full">
            <button
                tabindex="0"
                type="button"
                :class="[
                    'w-full text-left p-2 rounded-xl hover:bg-white/10 transition-colors flex items-center group focus:outline-hidden cursor-pointer',
                    isCollapsed ? 'justify-center' : 'justify-between gap-3'
                ]"
                title="User account options"
            >
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-bu-orange-500 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs ring-1 ring-white/20">
                        {{ userInitials }}
                    </div>
                    <div v-if="!isCollapsed" class="flex-1 min-w-0 leading-tight">
                        <div class="text-xs font-semibold text-white truncate group-hover:text-white">
                            {{ user.name }}
                        </div>
                        <div class="text-[10px] text-slate-400 truncate mt-0.5 flex items-center gap-1.5">
                            <span>{{ roleMeta.label }}</span>
                        </div>
                    </div>
                </div>
                <ChevronDown v-if="!isCollapsed" class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-transform" />
            </button>

            <!-- Dropdown Content: Account Details, Settings & Sign Out -->
            <ul
                tabindex="0"
                class="dropdown-content menu menu-sm bg-[#0F172A] border border-slate-700/80 rounded-xl z-50 p-2 shadow-2xl w-60 text-slate-200 mb-2 gap-1"
            >
                <li class="menu-title text-slate-400 text-[10px] uppercase font-bold px-2 py-1">
                    {{ roleMeta.label }}
                    <span class="block text-white normal-case font-medium truncate">{{ user.email }}</span>
                </li>

                <div class="divider my-0.5 border-slate-800"></div>

                <li>
                    <Link href="/settings" class="text-xs flex items-center gap-2">
                        <Settings class="w-3.5 h-3.5 text-slate-400" />
                        <span>Profile Settings</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/auth/logout"
                        method="post"
                        as="button"
                        class="text-xs text-rose-400 hover:text-rose-300 hover:bg-rose-950/40 flex items-center gap-2 w-full text-left"
                    >
                        <LogOut class="w-3.5 h-3.5 text-rose-400" />
                        <span>Sign Out</span>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>
