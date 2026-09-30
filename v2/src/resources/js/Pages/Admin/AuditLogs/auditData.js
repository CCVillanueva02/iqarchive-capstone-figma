/**
 * ============================================================================
 * IQArchive v2 — Audit Trail Data Definitions & Curated Records
 * ============================================================================
 * File: resources/js/Pages/Admin/AuditLogs/auditData.js
 * Responsibility: Tab definitions, action mappings, severity helpers, and
 *                 standard regulatory audit ledger dataset.
 * UI Standard: Institutional BU Blue (#0038A8) & BU Orange (#F26522).
 * ============================================================================
 */

import {
    LogIn,
    FileUp,
    GitBranch,
    AlertTriangle,
    Users,
    Activity,
    FileCheck2,
} from 'lucide-vue-next';

export const ACTION_LABELS = {
    // Sessions / Auth
    'auth.login': 'User signed in',
    'auth.login.dev': 'Developer sign-in performed',
    'auth.logout': 'User signed out',
    'auth.failed_login': 'Failed sign-in attempt',
    'auth.domain_rejected': 'Sign-in blocked — unrecognised email domain',
    'auth.session_expired': 'Session expired — user timed out',
    'auth.2fa_enabled': 'Two-factor authentication enabled',
    'auth.password_reset': 'Password reset performed',
    'auth.role_assigned': 'Role assigned to user',
    'auth.registered': 'User self-registered',

    // Documents & Evidence
    'document.upload': 'Document uploaded',
    'document.upload.area': 'Area document uploaded',
    'document.upload.common': 'Institutional document uploaded',
    'document.download': 'Document downloaded',
    'document.downloaded': 'Document downloaded',
    'document.submitted': 'Document submitted for review',
    'document.iqa_approved': 'Document approved by IQA',
    'document.dean_approved': 'Document approved by Dean',
    'document.returned': 'Document returned for revision',
    'document.rejected': 'Document rejected',
    'document.updated': 'Document revised / updated',
    'document.deleted': 'Document deleted',
    'document.restored': 'Document restored from trash',
    'evidence.upload': 'Evidence file uploaded',

    // Accounts & Users
    'user.created': 'User account created',
    'user.updated': 'User profile updated',
    'user.deactivated': 'User account deactivated',
    'user.activated': 'User account reactivated',
    'user.password_reset': 'User password reset by admin',
    'role.assigned': 'Role assigned to user',
    'role.revoked': 'Role revoked from user',
    'admin.college_created': 'College created',
    'admin.instrument_uploaded': 'Accreditation instrument uploaded',

    // Accreditation
    'stage.transitioned': 'Accreditation stage advanced',
    'stage.opened': 'Accreditation stage opened',
    'stage.closed': 'Accreditation stage closed',
    'accreditation.deficit.detected': 'Accreditation gap detected',
    'accreditation.submitted': 'College accreditation submitted',
    'accreditation.cycle_created': 'Accreditation cycle created',
    'instrument.added': 'Accreditation instrument added',
    'instrument.updated': 'Accreditation instrument updated',
    'task_force.assigned': 'Task force member assigned',
    'task_force.removed': 'Task force member removed',
    'task_force.formed': 'Task force team organized',
    'taskforce.deficit_flagged': 'Accreditation deficit flagged',

    // System
    'system.backup.completed': 'Scheduled system backup completed',
    'system.config.updated': 'System configuration changed',
    'system.maintenance.enabled': 'Maintenance mode activated',

    // Reports
    'report.generated': 'Compliance report generated',
    'report.exported': 'Report exported',
    'report.scheduled': 'Report scheduled for delivery',
};

export function humanAction(action) {
    if (!action) return 'System Event';
    return (
        ACTION_LABELS[action] ||
        action
            .split('.')
            .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
            .join(' ')
    );
}

export function deriveSeverity(action) {
    if (!action) return 'info';
    if (/reject|deficit|domain_rejected|fail|unauthorized|deleted|deactivated|revoked/.test(action)) {
        return 'security';
    }
    if (/return|returned|maintenance|warning/.test(action)) {
        return 'warning';
    }
    if (
        /approv|upload|endorse|transition|opened|created|activated|assigned|backup|generated|exported|restored|submitted|dean_appr|iqa_appr|formed/.test(
            action
        )
    ) {
        return 'success';
    }
    return 'info';
}

export function initials(name) {
    if (!name) return 'SYS';
    return name
        .split(' ')
        .filter(Boolean)
        .map((w) => w[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
}

export const SEV_BADGE = {
    security: 'bg-red-50 text-red-700 border border-red-200',
    warning: 'bg-amber-50 text-amber-700 border border-amber-200',
    success: 'bg-emerald-50 text-emerald-700 border border-emerald-200',
    info: 'bg-slate-100 text-slate-600 border border-slate-200',
};

export const SEV_LABEL = {
    security: 'Security Alert',
    warning: 'Warning',
    success: 'Completed',
    info: 'Info',
};

export const SEV_ACCENT = {
    security: '#EF4444',
    warning: '#F59E0B',
    success: '#10B981',
    info: '#CBD5E1',
};

export const ACTION_ICONS = {
    auth: LogIn,
    document: FileUp,
    evidence: FileUp,
    stage: GitBranch,
    accreditation: AlertTriangle,
    task_force: Users,
    taskforce: Users,
    user: Users,
    role: Users,
    admin: Users,
    system: Activity,
    report: FileCheck2,
};

export function getActionIcon(action) {
    if (!action) return Activity;
    const prefix = action.split('.')[0];
    return ACTION_ICONS[prefix] || Activity;
}

export const TABS = [
    {
        key: 'all',
        label: 'All',
        match: () => true,
    },
    {
        key: 'documents',
        label: 'Documents',
        match: (a) => a.startsWith('document.') || a.startsWith('evidence.'),
        subtabs: [
            { key: 'all', label: 'All', match: () => true },
            { key: 'uploads', label: 'Uploads', match: (a) => /upload/.test(a) },
            { key: 'downloads', label: 'Downloads', match: (a) => /download/.test(a) },
            { key: 'reviews', label: 'Reviews & Approvals', match: (a) => /approv|submit|return|reject/.test(a) },
            { key: 'changes', label: 'Edits & Deletions', match: (a) => /updated|deleted|restored/.test(a) },
        ],
    },
    {
        key: 'sessions',
        label: 'Sessions',
        match: (a) => a.startsWith('auth.'),
        subtabs: [
            { key: 'all', label: 'All', match: () => true },
            { key: 'signins', label: 'Sign-ins', match: (a) => /login/.test(a) && !/fail|reject/.test(a) },
            { key: 'signouts', label: 'Sign-outs', match: (a) => /logout|session_expired/.test(a) },
            { key: 'blocked', label: 'Failed & Blocked', match: (a) => /fail|domain_rejected|locked/.test(a) },
            { key: 'security', label: 'Security Events', match: (a) => /2fa|password_reset|token|role_assigned/.test(a) },
        ],
    },
    {
        key: 'accounts',
        label: 'Accounts',
        match: (a) => a.startsWith('user.') || a.startsWith('role.') || a.startsWith('admin.'),
        subtabs: [
            { key: 'all', label: 'All', match: () => true },
            { key: 'users', label: 'User Management', match: (a) => a.startsWith('user.') },
            { key: 'roles', label: 'Roles & Permissions', match: (a) => a.startsWith('role.') || a.startsWith('admin.') },
        ],
    },
    {
        key: 'accreditation',
        label: 'Accreditation',
        match: (a) => ['accreditation.', 'stage.', 'instrument.', 'task_force.', 'taskforce.'].some((p) => a.startsWith(p)),
        subtabs: [
            { key: 'all', label: 'All', match: () => true },
            { key: 'stages', label: 'Stages', match: (a) => a.startsWith('stage.') },
            { key: 'areas', label: 'Areas & Instruments', match: (a) => a.startsWith('accreditation.') || a.startsWith('instrument.') },
            { key: 'taskforce', label: 'Task Forces', match: (a) => a.startsWith('task_force.') || a.startsWith('taskforce.') },
        ],
    },
    {
        key: 'system',
        label: 'System',
        match: (a) => a.startsWith('system.'),
    },
    {
        key: 'reports',
        label: 'Reports',
        match: (a) => a.startsWith('report.'),
    },
];

// Curated 39 regulatory audit logs matching the design specifications
export const CURATED_LOGS = [
    // ── Reports ──────────────────────────────────────────────────────────────
    { id: 202, created_at: '2026-09-28T11:30:00', action: 'report.exported', target_type: 'App\\Models\\Report', target_id: '54', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: null, details: { title: 'AACCUP Readiness Dashboard Export', format: 'PDF' } },
    { id: 201, created_at: '2026-09-29T13:00:00', action: 'report.generated', target_type: 'App\\Models\\Report', target_id: '55', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: null, details: { title: 'College Compliance Summary Report — Sep 2026' } },
    // ── System ────────────────────────────────────────────────────────────────
    { id: 102, created_at: '2026-09-27T04:30:00', action: 'system.config.updated', target_type: 'App\\Models\\System', target_id: null, ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { key: 'session_lifetime', before: { value: 120 }, after: { value: 60 } } },
    { id: 101, created_at: '2026-09-28T03:00:00', action: 'system.maintenance.enabled', target_type: 'App\\Models\\System', target_id: null, ip_address: '127.0.0.1', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { window: '03:00–04:30 PHT' } },
    // ── Sessions / Auth ──────────────────────────────────────────────────────
    { id: 35, created_at: '2026-09-29T20:09:43', action: 'auth.login.dev', target_type: 'App\\Models\\User', target_id: '5', ip_address: '127.0.0.1', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: null, details: { reason: 'dev_login', role: 'iqa_staff' } },
    { id: 34, created_at: '2026-09-29T10:15:22', action: 'auth.login', target_type: 'App\\Models\\User', target_id: '14', ip_address: '10.10.4.21', user: { name: 'Dr. Maria Santos', email: 'maria.santos@bicol-u.edu.ph' }, college: { code: 'CS', name: 'College of Science' }, details: null },
    { id: 33, created_at: '2026-09-29T09:01:55', action: 'auth.logout', target_type: 'App\\Models\\User', target_id: '14', ip_address: '10.10.4.21', user: { name: 'Dr. Maria Santos', email: 'maria.santos@bicol-u.edu.ph' }, college: { code: 'CS', name: 'College of Science' }, details: null },
    { id: 32, created_at: '2026-09-28T23:41:10', action: 'auth.failed_login', target_type: 'App\\Models\\User', target_id: null, ip_address: '203.94.17.99', user: null, college: null, details: { email: 'admin@bicol-u.edu.ph', attempts: 5 } },
    { id: 31, created_at: '2026-09-28T16:00:00', action: 'auth.domain_rejected', target_type: 'App\\Models\\User', target_id: null, ip_address: '203.94.17.55', user: null, college: null, details: { email: 'unknown@gmail.com' } },
    { id: 30, created_at: '2026-09-27T08:04:01', action: 'auth.login', target_type: 'App\\Models\\User', target_id: '197', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: null },
    { id: 29, created_at: '2026-09-27T07:55:00', action: 'auth.session_expired', target_type: 'App\\Models\\User', target_id: '197', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { idle_minutes: 30 } },
    { id: 28, created_at: '2026-09-26T08:20:01', action: 'auth.domain_rejected', target_type: 'App\\Models\\User', target_id: null, ip_address: '203.94.17.88', user: null, college: null, details: { email: 'attacker@yahoo.com' } },
    { id: 27, created_at: '2026-09-25T14:10:30', action: 'auth.2fa_enabled', target_type: 'App\\Models\\User', target_id: '42', ip_address: '10.10.1.5', user: { name: 'Prof. J. Abad', email: 'j.abad@bicol-u.edu.ph' }, college: { code: 'OREP', name: 'Office of Research & Extension' }, details: null },
    { id: 26, created_at: '2026-09-24T01:48:16', action: 'auth.login.dev', target_type: 'App\\Models\\User', target_id: '5', ip_address: '127.0.0.1', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: null, details: { reason: 'dev_login', role: 'iqa_staff' } },
    // ── Documents ────────────────────────────────────────────────────────────
    { id: 25, created_at: '2026-09-29T14:05:00', action: 'document.upload', target_type: 'App\\Models\\Document', target_id: '145', ip_address: '10.10.6.10', user: { name: 'Prof. J. Abad', email: 'j.abad@bicol-u.edu.ph' }, college: { code: 'OREP', name: 'Office of Research & Extension' }, details: { title: 'Community Extension Quarterly Report Q3 2026', size: '3.1 MB', file_hash: 'sha256:a3f9c12b74d8e1ff2a0b5c63d4e789ab' } },
    { id: 24, created_at: '2026-09-29T11:30:00', action: 'document.download', target_type: 'App\\Models\\Document', target_id: '131', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: { code: 'BUCS', name: 'BU College of Science' }, details: { title: 'Student Support Services Annual Report.pdf' } },
    { id: 23, created_at: '2026-09-28T16:39:00', action: 'document.iqa_approved', target_type: 'App\\Models\\Document', target_id: '131', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: { code: 'BUCS', name: 'BU College of Science' }, details: { title: 'Student Support Services Annual Report.pdf', before: { status: 'submitted' }, after: { status: 'iqa_approved' } } },
    { id: 22, created_at: '2026-09-28T15:00:00', action: 'document.submitted', target_type: 'App\\Models\\Document', target_id: '131', ip_address: '10.10.3.5', user: { name: 'Dr. Maria Santos', email: 'maria.santos@bicol-u.edu.ph' }, college: { code: 'BUCS', name: 'BU College of Science' }, details: { title: 'Student Support Services Annual Report.pdf', before: { status: 'draft' }, after: { status: 'submitted' } } },
    { id: 21, created_at: '2026-09-27T14:30:00', action: 'document.upload', target_type: 'App\\Models\\Document', target_id: '132', ip_address: '10.10.5.32', user: { name: 'Prof. J. Abad', email: 'j.abad@bicol-u.edu.ph' }, college: { code: 'OREP', name: 'Office of Research & Extension' }, details: { title: 'Extension Program Monitoring Report Q3 2026', size: '1.9 MB' } },
    { id: 20, created_at: '2026-09-27T10:20:00', action: 'document.returned', target_type: 'App\\Models\\Document', target_id: '128', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: { code: 'CASS', name: 'College of Arts & Social Sciences' }, details: { title: 'Institutional Research Output 2024.pdf', reason: 'Incomplete benchmarks' } },
    { id: 19, created_at: '2026-09-26T13:45:00', action: 'document.updated', target_type: 'App\\Models\\Document', target_id: '120', ip_address: '10.10.1.5', user: { name: 'Prof. J. Abad', email: 'j.abad@bicol-u.edu.ph' }, college: { code: 'OREP', name: 'Office of Research & Extension' }, details: { title: 'Faculty Research Output 2023–2024.docx', before: { version: 2 }, after: { version: 3 } } },
    { id: 18, created_at: '2026-09-26T09:00:00', action: 'document.deleted', target_type: 'App\\Models\\Document', target_id: '115', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { title: 'Outdated Accreditation Template v1.docx' } },
    { id: 17, created_at: '2026-09-25T11:00:00', action: 'document.restored', target_type: 'App\\Models\\Document', target_id: '110', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { title: 'BU QMS Manual 2023.pdf' } },
    { id: 16, created_at: '2026-09-25T09:30:00', action: 'evidence.upload', target_type: 'App\\Models\\Evidence', target_id: '88', ip_address: '10.10.4.21', user: { name: 'Dr. Maria Santos', email: 'maria.santos@bicol-u.edu.ph' }, college: { code: 'CS', name: 'College of Science' }, details: { title: 'CS Faculty Development Certificate 2026', size: '820 KB' } },
    { id: 15, created_at: '2026-09-24T15:00:00', action: 'document.rejected', target_type: 'App\\Models\\Document', target_id: '105', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: { code: 'CASS', name: 'College of Arts & Social Sciences' }, details: { title: 'Social Orientation Plan 2025.pdf', reason: 'Incorrect format' } },
    // ── Accounts / Users ─────────────────────────────────────────────────────
    { id: 14, created_at: '2026-09-29T09:30:00', action: 'user.created', target_type: 'App\\Models\\User', target_id: '210', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { email: 'new.faculty@bicol-u.edu.ph', role: 'college_user' } },
    { id: 13, created_at: '2026-09-28T14:00:00', action: 'user.updated', target_type: 'App\\Models\\User', target_id: '42', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { email: 'j.abad@bicol-u.edu.ph', before: { college_id: 3 }, after: { college_id: 5 } } },
    { id: 12, created_at: '2026-09-27T16:00:00', action: 'user.deactivated', target_type: 'App\\Models\\User', target_id: '80', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { email: 'former.staff@bicol-u.edu.ph', reason: 'Resigned' } },
    { id: 11, created_at: '2026-09-26T10:00:00', action: 'user.activated', target_type: 'App\\Models\\User', target_id: '205', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { email: 'reinstated.faculty@bicol-u.edu.ph' } },
    { id: 10, created_at: '2026-09-26T08:45:00', action: 'user.password_reset', target_type: 'App\\Models\\User', target_id: '55', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { email: 'locked.user@bicol-u.edu.ph' } },
    // ── Roles & Permissions ──────────────────────────────────────────────────
    { id: 9, created_at: '2026-09-29T08:00:00', action: 'role.assigned', target_type: 'App\\Models\\User', target_id: '210', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { email: 'new.faculty@bicol-u.edu.ph', role: 'college_user' } },
    { id: 8, created_at: '2026-09-27T15:00:00', action: 'role.revoked', target_type: 'App\\Models\\User', target_id: '80', ip_address: '10.10.2.14', user: { name: 'Engr. David Ramos', email: 'sysadmin@bicol-u.edu.ph' }, college: null, details: { email: 'former.staff@bicol-u.edu.ph', role: 'college_coordinator' } },
    // ── Accreditation — Stages ───────────────────────────────────────────────
    { id: 7, created_at: '2026-09-28T18:18:01', action: 'stage.transitioned', target_type: 'App\\Models\\Program', target_id: '18', ip_address: '10.10.3.5', user: { name: 'Dr. Maria Santos', email: 'maria.santos@bicol-u.edu.ph' }, college: { code: 'CS', name: 'College of Science' }, details: { before: { stage: 'initial' }, after: { stage: 'formal' } } },
    { id: 6, created_at: '2026-09-27T09:00:00', action: 'stage.opened', target_type: 'App\\Models\\AccreditationCycle', target_id: '3', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: null, details: { title: 'AACCUP 2026 Cycle 3 — Data Collection Phase' } },
    { id: 5, created_at: '2026-09-25T17:00:00', action: 'stage.transitioned', target_type: 'App\\Models\\Program', target_id: '22', ip_address: '10.10.4.21', user: { name: 'Dr. Maria Santos', email: 'maria.santos@bicol-u.edu.ph' }, college: { code: 'CS', name: 'College of Science' }, details: { before: { stage: 'formal' }, after: { stage: 'institutional_self_study' } } },
    // ── Accreditation — Areas & Instruments ─────────────────────────────────
    { id: 4, created_at: '2026-09-29T08:20:01', action: 'accreditation.deficit.detected', target_type: 'App\\Models\\AccreditationArea', target_id: '8', ip_address: '127.0.0.1', user: null, college: { code: 'CASS', name: 'College of Arts & Social Sciences' }, details: { area: 'Area VIII', missing_benchmarks: 3 } },
    { id: 3, created_at: '2026-09-27T11:00:00', action: 'instrument.added', target_type: 'App\\Models\\Instrument', target_id: '9', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: null, details: { title: 'AACCUP Area IX — Research Instrument v2' } },
    // ── Accreditation — Task Forces ──────────────────────────────────────────
    { id: 2, created_at: '2026-09-28T10:00:00', action: 'task_force.assigned', target_type: 'App\\Models\\TaskForce', target_id: '11', ip_address: '10.10.8.14', user: { name: 'IQA Staff User', email: 'iqastaff@example.com' }, college: { code: 'CS', name: 'College of Science' }, details: { email: 'maria.santos@bicol-u.edu.ph', title: 'TF Lead — CS Area VII' } },
    // ── System ───────────────────────────────────────────────────────────────
    { id: 1, created_at: '2026-09-29T02:00:00', action: 'system.backup.completed', target_type: 'App\\Models\\Backup', target_id: null, ip_address: '127.0.0.1', user: null, college: null, details: { size: '4.8 GB', duration_s: 182, storage: 'S3' } },
];
