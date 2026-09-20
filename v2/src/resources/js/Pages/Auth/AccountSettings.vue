<!--
================================================================================
IQArchive v2 — User Account & Profile Settings
================================================================================
File: resources/js/Pages/Auth/AccountSettings.vue
Role Scope: Available to all authenticated roles
================================================================================
-->

<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import { User, Shield, Building2, Mail, Lock } from 'lucide-vue-next';

const page = usePage();
const user = page.props.auth?.user || {};
</script>

<template>
    <Head title="Account Settings" />

    <AppShell>
        <div class="max-w-4xl mx-auto space-y-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Account Settings</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage your institutional profile and authenticated role access.</p>
            </div>

            <!-- Profile Summary Card -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-6">
                <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-2xl bg-orange-50 border border-orange-200 text-orange-600 flex items-center justify-center font-bold text-xl">
                        {{ user.name?.charAt(0) || 'U' }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ user.name || 'Faculty Member' }}</h2>
                        <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                            <Mail class="w-3.5 h-3.5 text-slate-400" />
                            <span>{{ user.email || 'user@bicol-u.edu.ph' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Attributes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <Shield class="w-3.5 h-3.5 text-orange-600" />
                            <span>Assigned Role</span>
                        </div>
                        <div class="text-sm font-bold text-slate-800 mt-2 capitalize">
                            {{ user.role?.replace('_', ' ') || 'IQA Member' }}
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <Building2 class="w-3.5 h-3.5 text-orange-600" />
                            <span>College Multi-Tenant Scope</span>
                        </div>
                        <div class="text-sm font-bold text-slate-800 mt-2">
                            {{ user.college_id ? `College ID #${user.college_id}` : 'University-Wide Access (IQA / Admin)' }}
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-amber-50/70 border border-amber-200 text-amber-900 text-xs flex items-center gap-3">
                    <Lock class="w-4 h-4 text-amber-600 shrink-0" />
                    <span>Identity and password policies are governed centrally by Bicol University Google Workspace. Account profile updates must be processed through the BU ICTO.</span>
                </div>
            </div>
        </div>
    </AppShell>
</template>
