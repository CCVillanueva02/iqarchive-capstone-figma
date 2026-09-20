<!--
================================================================================
IQArchive v2 — Master AppShell Layout
================================================================================
File: resources/js/Layouts/AppShell.vue
Purpose: Core persistent workstation shell with 64px topbar, role-scoped sidebar,
         breadcrumbs, flash alerts, and desktop viewport enforcement.
Design System Ref: v2/docs/design-system.md (Section 4)
Security Context: Scopes navigation and tenant context by auth.user.role and
                  auth.user.college_id.
================================================================================
-->

<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import MobileUnsupported from '@/Components/MobileUnsupported.vue';
import AppSidebar from '@/Layouts/Partials/AppSidebar.vue';
import AppTopbar from '@/Layouts/Partials/AppTopbar.vue';
import AppUserMenu from '@/Layouts/Partials/AppUserMenu.vue';
import { getNavigationSections } from '@/Layouts/navigation.js';
import { CheckCircle2, AlertCircle, Info } from 'lucide-vue-next';

const page = usePage();

const user = computed(() => page.props.auth?.user || {
    name: 'Guest User',
    email: 'guest@bicol-u.edu.ph',
    role: 'iqa_member',
    college_id: null,
});

const currentRole = computed(() => user.value.role || 'iqa_member');
const flash = computed(() => page.props.flash || {});

// Persistent sidebar collapse state via localStorage
const isSidebarCollapsed = ref(localStorage.getItem('iq_sidebar_collapsed') === 'true');

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    localStorage.setItem('iq_sidebar_collapsed', isSidebarCollapsed.value ? 'true' : 'false');
};

// Active route helper
const isUrlActive = (href) => {
    const currentUrl = page.url;
    if (href === '/' || href === '/iqa' || href === '/admin' || href === '/dean' || href === '/task-force' || href === '/executive' || href === '/external-accreditor') {
        return currentUrl === href;
    }
    return currentUrl.startsWith(href);
};

// System clock for institutional header
const systemTime = ref('');
let timerInterval = null;

const updateClock = () => {
    const now = new Date();
    systemTime.value = now.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    }) + ' ' + now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
    });
};

onMounted(() => {
    updateClock();
    timerInterval = setInterval(updateClock, 1000);
});

onUnmounted(() => {
    if (timerInterval) clearInterval(timerInterval);
});

// Normalize role string to canonical key for navigation and display
const ROLE_ALIASES = {
    iqa_member: 'iqa_staff', iqa_staff: 'iqa_staff',
    college_head: 'college_dean', dean: 'college_dean', college_dean: 'college_dean',
    task_force: 'task_force', task_force_member: 'task_force', tfmember: 'task_force',
    system_admin: 'system_admin', sysadmin: 'system_admin', system_administrator: 'system_admin',
    bu_executive: 'bu_executive', university_administrator: 'bu_executive',
    accreditor: 'external_accreditor', external_accreditor: 'external_accreditor',
};
const normalizedRole = computed(() => {
    const r = currentRole.value?.replace(/-/g, '_') || 'iqa_staff';
    return ROLE_ALIASES[r] || r;
});

// Role display metadata
const roleMeta = computed(() => {
    switch (normalizedRole.value) {
        case 'system_admin':
            return { label: 'System Admin', officeLabel: 'IT & Systems Office', badgeClass: 'badge-neutral' };
        case 'college_dean':
            return { label: 'College Dean', officeLabel: 'Office of the Dean', badgeClass: 'badge-info' };
        case 'task_force':
            return { label: 'Task Force Member', officeLabel: 'Program Task Force', badgeClass: 'badge-warning' };
        case 'internal_accreditor':
            return { label: 'Internal Accreditor', officeLabel: 'Mock Accreditation Committee', badgeClass: 'badge-secondary' };
        case 'bu_executive':
            return { label: 'BU Executive', officeLabel: 'University Administration', badgeClass: 'badge-primary' };
        case 'external_accreditor':
            return { label: 'External Accreditor', officeLabel: 'AACCUP Survey Team', badgeClass: 'badge-success' };
        case 'iqa_staff':
        default:
            return { label: 'IQA Staff', officeLabel: 'IQA Office · BU', badgeClass: 'badge-warning' };
    }
});

const navigationSections = computed(() => getNavigationSections(normalizedRole.value));

const userInitials = computed(() => {
    if (!user.value.name) return 'U';
    const parts = user.value.name.trim().split(/\s+/);
    if (parts.length >= 2) {
        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    }
    return user.value.name.substring(0, 2).toUpperCase();
});
</script>

<template>
    <!-- Viewport Barrier (< 1024px) -->
    <MobileUnsupported />

    <div class="h-screen bg-slate-50 text-slate-900 flex font-sans antialiased overflow-hidden">
        <!-- Master Sidebar -->
        <AppSidebar
            :is-collapsed="isSidebarCollapsed"
            :role-meta="roleMeta"
            :sections="navigationSections"
            :is-url-active="isUrlActive"
            @toggle-collapse="toggleSidebar"
        >
            <template #footer>
                <AppUserMenu
                    :user="user"
                    :role-meta="roleMeta"
                    :user-initials="userInitials"
                    :is-collapsed="isSidebarCollapsed"
                />
            </template>
        </AppSidebar>

        <!-- Main Workspace Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <AppTopbar
                :user="user"
                :role-meta="roleMeta"
                :system-time="systemTime"
            />

            <!-- Scrollable Canvas Area -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-slate-50">
                <!-- Breadcrumbs -->
                <div class="breadcrumbs text-xs text-slate-500 mb-4 py-0">
                    <ul>
                        <li><Link href="/" class="hover:text-slate-800">Home</Link></li>
                        <li><span class="text-slate-600">{{ roleMeta.label }}</span></li>
                        <li class="text-slate-900 font-semibold">Dashboard</li>
                    </ul>
                </div>

                <!-- Flash Notification Alerts (DaisyUI) -->
                <div v-if="flash.success" class="alert alert-success shadow-xs text-xs mb-6">
                    <CheckCircle2 class="w-4 h-4 shrink-0" />
                    <span>{{ flash.success }}</span>
                </div>
                <div v-if="flash.error" class="alert alert-error shadow-xs text-xs mb-6">
                    <AlertCircle class="w-4 h-4 shrink-0" />
                    <span>{{ flash.error }}</span>
                </div>
                <div v-if="flash.warning" class="alert alert-warning shadow-xs text-xs mb-6">
                    <Info class="w-4 h-4 shrink-0" />
                    <span>{{ flash.warning }}</span>
                </div>

                <!-- Injected Page Content -->
                <slot />
            </main>
        </div>
    </div>
</template>
