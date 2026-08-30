# RBAC: System Administrator

This reference document specifies the capabilities, authorization gates, and operational boundaries of the `system-administrator` role.

---

## 1. Role Summary

- **Role Identifier:** `system-administrator`
- **Display Name:** System Administrator
- **Primary Domain:** Global system operations, user lifecycle, and audit compliance.

---

## 2. Capabilities & Permissions

| Capability Domain | Allowed Actions | Enforcement Mechanism |
| :--- | :--- | :--- |
| **User Management** | Pre-register users, assign roles, deactivate accounts, force password resets | `UserPolicy`, `Livewire\SystemAdministrator\Accounts` |
| **Audit Trails** | Inspect global chronological audit logs across all users and documents | `App\Models\AuditLog`, System Admin Dashboard |
| **Colleges & Programs** | Configure academic units and degree programs | Gate `manageCollegesAndPrograms` |
| **Task Force Roster** | View all task forces across colleges | Gate `viewTaskForceRoster` |
| **System Diagnostics** | Inspect queue status, failed jobs, and cache health | Artisan CLI / Admin Panel |

---

## 3. Route & UI Access

- **Default Landing Route:** `route('dashboard.system-administrator')`
- **Protected Middleware:** `middleware(['auth', 'verified'])` + `User::hasRole('system-administrator')`
- **Navigation Shell:** Full system administration sidebar navigation with account controls and log viewers.

---

## 4. Security Constraints

- **Least Privilege Principle:** System Administrators manage identity and platform health but do not grade accreditation instruments or approve academic compliance evidence.
- **Audit Logging:** Every user pre-registration or status change triggered by a System Administrator is logged with action `CREATE_USER` or `UPDATE_USER`.

---

## 5. Cross-Quadrant Links

- **Related Roles:** [RBAC: IQA Staff](./rbac-iqa-staff.md)
- **How-To Guide:** [User Onboarding Flow](../how-to/user-onboarding-flow.md)
- **Schema Reference:** [Authentication & Security Schema](./database-schema-auth-security.md)
