# RBAC: Task Force Member

This reference document specifies the capabilities, authorization gates, and operational boundaries of the `task-force-member` role.

---

## 1. Role Summary

- **Role Identifier:** `task-force-member`
- **Display Name:** Task Force Member
- **Primary Domain:** Accreditation criteria compliance, evidence uploading, parameter checklist fulfillment, and self-survey rating.

---

## 2. Capabilities & Permissions

| Capability Domain | Allowed Actions | Enforcement Mechanism |
| :--- | :--- | :--- |
| **Evidence Upload** | Upload supporting PDFs (syllabi, faculty credentials, committee minutes) | `App\Models\Document`, `Livewire\Documents\Upload` |
| **Criteria Linking** | Link uploaded evidence documents to specific compliance requirements | `App\Models\AccreditationDocumentLink` |
| **Checklist Tracking** | Mark parameter tasks, verify tags (e.g. `#UniversityManual`), track progress | `Livewire\TaskForce\TaskForceOverview` |
| **Self-Survey Ratings** | Record self-evaluation scores (0 to 5) per indicator | `App\Models\SelfSurveyRating` |
| **Roster Access** | View members of own assigned task forces | Gate `viewTaskForceRoster` |

---

## 3. Dual-Role Architecture

Faculty members often hold a baseline academic identity while being dynamically assigned to one or more active accreditation task forces.
- The `User::roles()` relationship checks the `role_user` pivot table.
- Task force participation is governed by the `task_force_members` pivot table, allowing faculty to participate across multiple programs simultaneously.

---

## 4. Route & UI Access

- **Default Landing Route:** `route('dashboard.task-force')`
- **Protected Middleware:** `middleware(['auth', 'verified'])` + `User::hasRole('task-force-member')`
- **Workspace:** Task Force preparation dashboard, Area I–X criteria accordion, upload drawer, and document tagging tool.

---

## 5. Cross-Quadrant Links

- **Pivot Reference:** [Task Force Members Pivot](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-task-force-members-pivot.md)
- **Dynamic Instruments Schema:** [Dynamic Instruments Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-dynamic-instruments.md)
- **Document Management Schema:** [Document Management Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-document-management.md)
