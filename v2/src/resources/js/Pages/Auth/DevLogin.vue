<!--
================================================================================
IQArchive v2 — Developer Sandbox Console
================================================================================
File: resources/js/Pages/Auth/DevLogin.vue
Security Context: Strictly rendered during local or testing environments.
                  Provides 1-click authentication for dev personas.
================================================================================
-->

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MobileUnsupported from '@/Components/MobileUnsupported.vue';
import { AlertTriangle, ChevronRight, ArrowRight, Shield } from 'lucide-vue-next';

defineProps({
    roles: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Developer Sandbox" />

    <!-- Desktop Viewport Guard -->
    <MobileUnsupported />

    <div class="min-h-screen bg-slate-950 bg-linear-to-br from-slate-950 via-slate-900 to-zinc-950 flex flex-col justify-center items-center p-6 text-slate-100 font-sans antialiased">
        <div class="w-full max-w-xl bg-slate-900/90 backdrop-blur-2xl border border-slate-800 rounded-3xl shadow-2xl p-6 md:p-8 flex flex-col gap-6 my-auto">

            <!-- Sandbox Header -->
            <div class="flex flex-col items-center text-center">
                <!-- Sandbox Warning Pill -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-wider mb-3">
                    <AlertTriangle class="w-3.5 h-3.5 text-amber-400 shrink-0" />
                    <span>Local Sandbox Mode</span>
                </div>

                <h1 class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-linear-to-r from-amber-400 via-amber-300 to-yellow-200 tracking-tight">
                    IQArchive Dev Switcher
                </h1>
                <p class="text-sm text-slate-400 mt-2 max-w-sm leading-relaxed">
                    Instantly log in as any role without credentials. Exclusively available in local environment.
                </p>
            </div>

            <hr class="border-slate-800" />

            <!-- Single Role Accounts Section -->
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <span>Single Role Accounts</span>
                    </h2>
                    <span class="text-xs font-medium bg-slate-800 border border-slate-700 text-slate-300 px-2.5 py-0.5 rounded-full">
                        6 Core Roles
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a
                        v-for="role in roles.single"
                        :key="role.slug"
                        :href="`/dev/login/${role.slug}`"
                        class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-800/80 hover:shadow-lg hover:shadow-amber-500/5 active:scale-[0.98] transition-all duration-150"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-slate-100 group-hover:text-amber-400 transition-colors">
                                {{ role.title }}
                            </span>
                            <ChevronRight class="w-4 h-4 text-slate-600 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" />
                        </div>
                        <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-1.5 font-mono">
                            {{ role.email }}
                        </span>
                    </a>
                </div>
            </div>

            <hr class="border-slate-800" />

            <!-- Multi-Role Accounts Section -->
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-xs font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                        <span>Multi-Role Accounts (Role Switcher Demo)</span>
                    </h2>
                    <span class="text-xs font-semibold bg-amber-500/10 border border-amber-500/30 text-amber-300 px-2.5 py-0.5 rounded-full">
                        Multi View
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a
                        v-for="role in roles.multi"
                        :key="role.slug"
                        :href="`/dev/login/${role.slug}`"
                        class="group flex flex-col justify-between p-3.5 bg-slate-900/90 border border-amber-500/30 rounded-2xl hover:border-amber-400 hover:bg-slate-800/80 hover:shadow-lg hover:shadow-amber-500/10 active:scale-[0.98] transition-all duration-150"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-amber-400">{{ role.primary }}</span>
                                <span class="text-xs text-slate-200 font-medium">+ {{ role.secondary }}</span>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/40 px-1.5 py-0.5 rounded">
                                {{ role.badge }}
                            </span>
                        </div>
                        <span class="text-xs text-slate-400 group-hover:text-slate-300 mt-2 font-mono truncate">
                            {{ role.email }}
                        </span>
                    </a>
                </div>
            </div>

            <hr class="border-slate-800" />

            <!-- Bottom Navigation -->
            <div class="flex justify-between items-center text-xs text-slate-400 pt-1">
                <span>&copy; 2026 Bicol University</span>
                <Link
                    href="/login"
                    class="inline-flex items-center gap-1.5 text-slate-400 hover:text-amber-300 transition-colors font-medium"
                >
                    <span>Standard Login</span>
                    <ArrowRight class="w-3.5 h-3.5" />
                </Link>
            </div>

        </div>
    </div>
</template>
