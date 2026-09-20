/**
 * ============================================================================
 * IQArchive v2 — Master Navigation Sections Registry
 * ============================================================================
 * File: resources/js/Layouts/navigation.js
 * Role: Provides role-scoped navigation hierarchies conforming to legacy v1 specs.
 * Security: UI navigation menu structure; actual routes gated server-side.
 * ============================================================================
 */

import {
    LayoutDashboard,
    FolderKanban,
    FileText,
    Award,
    ShieldCheck,
    Users,
    Settings,
    Building2,
    BarChart3,
    BookOpen,
    Calendar,
    UserCheck,
    Layers,
} from 'lucide-vue-next';

export function getNavigationSections(role) {
    if (role === 'iqa_staff' || role === 'iqa_member') {
        return [
            {
                title: 'WORKSPACE',
                items: [
                    { name: 'Dashboard', href: '/iqa', icon: LayoutDashboard },
                    {
                        name: 'Documents',
                        icon: FolderKanban,
                        isOpen: true,
                        children: [
                            { name: 'Common Documents', href: '/documents?tab=common-documents', icon: FileText },
                            { name: 'Program Accreditation', href: '/documents?tab=program-accreditation', icon: FolderKanban },
                            { name: 'Institutional Records', href: '/documents?tab=institutional-records', icon: Building2 },
                        ],
                    },
                    {
                        name: 'Monitoring',
                        icon: ShieldCheck,
                        isOpen: false,
                        children: [
                            { name: 'Monitoring Board', href: '/iqa/monitoring', icon: BarChart3 },
                            { name: 'Summary Reports', href: '/iqa/reports', icon: BookOpen },
                            { name: 'Programs Progress', href: '/iqa/progress', icon: Award },
                        ],
                    },
                ],
            },
            {
                title: 'OPERATIONS',
                items: [
                    { name: 'Accreditation Visits', href: '/iqa/visits', icon: Calendar },
                    { name: 'Task Forces', href: '/iqa/task-forces', icon: Users },
                    { name: 'Submissions Review', href: '/iqa/submissions', icon: ShieldCheck,},
                    { name: 'Compliance Analytics', href: '/iqa/analytics', icon: BarChart3 },
                ],
            },
            {
                title: 'ADMINISTRATION',
                items: [
                    { name: 'Colleges & Programs', href: '/admin/colleges', icon: Building2 },
                    { name: 'Master Instruments', href: '/iqa/instruments', icon: Layers },
                    { name: 'User Accounts', href: '/admin/users', icon: UserCheck },
                    { name: 'Audit Trail Logs', href: '/admin/audit-logs', icon: ShieldCheck },
                ],
            },
        ];
    }

    if (role === 'system_admin') {
        return [
            {
                title: 'WORKSPACE',
                items: [
                    { name: 'Admin Dashboard', href: '/admin', icon: LayoutDashboard },
                    { name: 'Document Repository', href: '/documents', icon: FolderKanban },
                ],
            },
            {
                title: 'ADMINISTRATION',
                items: [
                    { name: 'User Management', href: '/admin/users', icon: Users },
                    { name: 'Colleges & Programs', href: '/admin/colleges', icon: Building2 },
                    { name: 'System Audit Trail', href: '/admin/audit-logs', icon: ShieldCheck },
                    { name: 'System Configuration', href: '/admin/settings', icon: Settings },
                ],
            },
        ];
    }

    if (role === 'college_dean') {
        return [
            {
                title: 'WORKSPACE',
                items: [
                    { name: 'Dean Dashboard', href: '/dean', icon: LayoutDashboard },
                    { name: 'Evidence Endorsements', href: '/dean/endorsements', icon: ShieldCheck, badge: 'Gate 1', badgeClass: 'badge-info' },
                    { name: 'College Documents', href: '/documents', icon: FolderKanban },
                ],
            },
            {
                title: 'OPERATIONS',
                items: [
                    { name: 'College Programs', href: '/dean/programs', icon: Building2 },
                    { name: 'Task Force Rosters', href: '/dean/task-force', icon: Users },
                    { name: 'Accreditation Status', href: '/dean/accreditation', icon: Award },
                ],
            },
        ];
    }

    if (role === 'task_force') {
        return [
            {
                title: 'WORKSPACE',
                items: [
                    { name: 'Task Force Dashboard', href: '/task-force', icon: LayoutDashboard },
                    { name: '10-Area Criteria Matrix', href: '/task-force/areas', icon: Layers },
                    { name: 'Document Evidence', href: '/task-force/evidence', icon: FileText },
                ],
            },
            {
                title: 'OPERATIONS',
                items: [
                    { name: 'Self-Survey Reports', href: '/task-force/ssr', icon: BookOpen },
                    { name: 'Area Gap Analysis', href: '/task-force/gaps', icon: BarChart3 },
                ],
            },
        ];
    }

    if (role === 'bu_executive') {
        return [
            {
                title: 'WORKSPACE',
                items: [
                    { name: 'Executive Overview', href: '/executive', icon: LayoutDashboard },
                    { name: 'University Compliance', href: '/executive/compliance', icon: BarChart3 },
                ],
            },
            {
                title: 'OPERATIONS',
                items: [
                    { name: 'College Comparisons', href: '/executive/colleges', icon: Building2 },
                    { name: 'Accreditation Archive', href: '/executive/archive', icon: Award },
                ],
            },
        ];
    }

    // Accreditor fallback
    return [
        {
            title: 'WORKSPACE',
            items: [
                { name: 'AACCUP Survey Portal', href: '/external-accreditor', icon: LayoutDashboard },
                { name: 'Submitted Evidence', href: '/external-accreditor/packages', icon: FolderKanban },
                { name: 'Criteria Verification', href: '/external-accreditor/criteria', icon: ShieldCheck },
            ],
        },
    ];
}
