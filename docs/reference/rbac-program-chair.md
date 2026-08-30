# RBAC: Program Chair & Department Head

This reference document specifies the capabilities, authorization gates, and program-level responsibilities of the `program-chair` role.

---

## 1. Role Summary

- **Role Identifier:** `program-chair` (or contextual departmental head)
- **Display Name:** Program Chair / Department Head
- **Primary Domain:** Program-level compliance monitoring, task force member coordination, and evidence curriculum alignment.

---

## 2. Capabilities & Permissions

| Capability Domain | Allowed Actions | Enforcement Mechanism |
| :--- | :--- | :--- |
| **Program Oversight** | View accreditation cycle, criteria checklist, and compliance status for own degree program | Scope `program_id = user.program_id` |
| **Task Force Coordination**| Review criteria assignments, verify assigned faculty contributions | Scope `TaskForce` linked to `program_id` |
| **Evidence Contribution** | Upload, categorize, and link syllabi, faculty profiles, and board resolutions to criteria | `Livewire\Documents\Upload` |
| **Compliance Tracking** | Inspect overdue requirements, missing evidence indicators, and parameter weights | `Livewire\TaskForce\TaskForceOverview` |

---

## 3. Organizational Scoping

Program Chairs operate within strict departmental boundaries:
- A Program Chair for `BSCS` can only inspect and link documents associated with the Computer Science program.
- Cross-departmental files (e.g. university-wide policies) are accessible via the central `offices` and `document_categories` repository.

---

## 4. Route & UI Access

- **Default Landing Route:** `route('dashboard.program-chair')` or `route('dashboard.task-force')`
- **Protected Middleware:** `middleware(['auth', 'verified'])` + `User::hasAnyRole(['program-chair', 'task-force-member'])`
- **Workspace:** Program compliance dashboard, Area I–X progress checklist, and evidence link tracker.

---

## 5. Cross-Quadrant Links

- **Related Role:** [RBAC: Task Force Member](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-task-force-member.md)
- **Pivot Reference:** [Task Force Members Pivot](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-task-force-members-pivot.md)
- **Hierarchy Schema:** [Organizational Hierarchy Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-organizational-hierarchy.md)
