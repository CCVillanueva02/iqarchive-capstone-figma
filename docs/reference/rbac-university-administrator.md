# RBAC: University Administrator

This reference document specifies the capabilities, reporting privileges, and analytics scope of the `university-administrator` role (BU Executives and University Leadership).

---

## 1. Role Summary

- **Role Identifier:** `university-administrator`
- **Display Name:** BU Executive / University Administrator
- **Primary Domain:** University-wide quality assurance analytics, macro accreditation monitoring, and executive summaries.

---

## 2. Capabilities & Permissions

| Capability Domain | Allowed Actions | Enforcement Mechanism |
| :--- | :--- | :--- |
| **Executive Analytics** | View university-wide accreditation rate, Level I–IV distributions, and campus comparisons | `Livewire\Monitoring\MonitoringOverview` |
| **Program Directory** | Inspect accreditation standings across all 17 colleges and campuses | Gate `viewCollegesAndPrograms` |
| **Task Force Rosters** | View composition and leads for any active university task force | Gate `viewTaskForceRoster` |
| **Executive Reports** | Export institutional summary reports for Board of Regents and CHED/AACCUP | `MonitoringSummaryReport` |

---

## 3. Route & UI Access

- **Default Landing Route:** `route('analytics.university-administrator')`
- **Protected Middleware:** `middleware(['auth', 'verified'])` + `User::hasRole('university-administrator')`
- **Executive UI:** Top-level metrics cards (Accreditation Rate %, Level IV/III/II/I counts), campus performance charts, and scheduled visit timelines.

---

## 4. Security Constraints

- **Read-Only Oversight:** University Administrators have complete read visibility across all academic programs but do not modify instrument criteria, upload task force evidence, or alter document statuses.

---

## 5. Cross-Quadrant Links

- **Related Roles:** [RBAC: College Head](./rbac-college-head.md) | [RBAC: IQA Staff](./rbac-iqa-staff.md)
- **Hierarchy Schema:** [Organizational Hierarchy Schema](./database-schema-organizational-hierarchy.md)
- **Architecture Reference:** [System Architecture Overview](./architecture-overview.md)
