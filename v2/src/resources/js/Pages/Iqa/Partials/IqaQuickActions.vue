<!--
================================================================================
IQArchive v2 — IQA Quick Actions Card
================================================================================
File: resources/js/Pages/Iqa/Partials/IqaQuickActions.vue
Role: Quick-access links to Monitoring, User Directory, and Audit Logs.
================================================================================
-->

<script setup>
import { Link } from '@inertiajs/vue3';
import { BarChart3, Users, ShieldCheck, ChevronRight } from 'lucide-vue-next';
</script>

<template>
    <div class="card card-border bg-base-100 shadow-xs rounded-2xl p-5 space-y-3">
        <div class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 pb-1">
            Quick Actions
        </div>

        <!-- Action Item: Monitoring -->
        <Link
            href="/iqa/monitoring"
            class="p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-100 flex items-center gap-3.5 transition-all group cursor-pointer"
        >
            <div class="w-9 h-9 rounded-lg bg-[#0B1B3D] text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                <BarChart3 class="w-4 h-4" />
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-xs font-bold text-slate-900 group-hover:text-bu-orange-500 transition-colors">
                    Monitoring
                </div>
                <div class="text-[11px] text-slate-500 truncate">
                    Track and evaluate program compliance
                </div>
            </div>
            <ChevronRight class="w-4 h-4 text-slate-400 group-hover:text-slate-600" />
        </Link>

        <!-- Action Item: User Directory -->
        <Link
            href="/admin/users"
            class="p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-100 flex items-center gap-3.5 transition-all group cursor-pointer"
        >
            <div class="w-9 h-9 rounded-lg bg-bu-orange-500 text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                <Users class="w-4 h-4" />
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-xs font-bold text-slate-900 group-hover:text-bu-orange-500 transition-colors">
                    Manage User Accounts
                </div>
                <div class="text-[11px] text-slate-500 truncate">
                    Manage and check staff &amp; deans
                </div>
            </div>
            <ChevronRight class="w-4 h-4 text-slate-400 group-hover:text-slate-600" />
        </Link>

        <!-- Action Item: Audit Trail -->
        <Link
            href="/admin/audit-logs"
            class="p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-100 flex items-center gap-3.5 transition-all group cursor-pointer"
        >
            <div class="w-9 h-9 rounded-lg bg-purple-600 text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                <ShieldCheck class="w-4 h-4" />
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-xs font-bold text-slate-900 group-hover:text-bu-orange-500 transition-colors">
                    IQA Audit Trail logs
                </div>
                <div class="text-[11px] text-slate-500 truncate">
                    Track system activity logs
                </div>
            </div>
            <ChevronRight class="w-4 h-4 text-slate-400 group-hover:text-slate-600" />
        </Link>
    </div>
</template>
