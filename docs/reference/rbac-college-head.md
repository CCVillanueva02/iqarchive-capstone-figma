# RBAC: College Head

This reference document specifies the capabilities, authorization gates, and contextual leadership privileges of the `college-head` role (College Deans and Academic Directors).

---

## 1. Role Summary

- **Role Identifier:** `college-head`
- **Display Name:** College Head / Dean
- **Primary Domain:** College-wide accreditation supervision, verification of submitted portfolios, and task force leadership.

---

## 2. Capabilities & Permissions

| Capability Domain | Allowed Actions | Enforcement Mechanism |
| :--- | :--- | :--- |
| **College Oversight** | View all degree programs, faculty rosters, and accreditations under their college | Scope `college_id = user.college_id` |
| **Task Force Leadership** | Automatic assignment as Task Force Lead for college task forces | Observer on `TaskForce::created` |
| **Dean Verification** | Review and formally endorse program evidence packages before IQA submission | `Livewire\CollegeHead\DeanVerification` |
| **Instrument Customization** | Adjust parameters and weights within program accreditation instruments | `Livewire\CollegeHead\InstrumentCustomization` |
| **Task Force Rosters** | View team rosters for all task forces within their college | Gate `viewTaskForceRoster` |

---

## 3. Contextual Elevation Mechanics

When a `TaskForce` is registered with a matching `college_id`, an Eloquent observer automatically creates a `task_force_members` record elevating the College Dean to `role_in_team = 'lead'`. This grants executive signing and verification authority without requiring manual role reassignment.

---

## 4. Route & UI Access

- **Default Landing Route:** `route('dashboard.college-head')`
- **Protected Middleware:** `middleware(['auth', 'verified'])` + `User::hasRole('college-head')`
- **UI Workspace:** College accreditation command center, verification queue, and program status cards.

---

## 5. Cross-Quadrant Links

- **Explanation:** [College Head Contextual Elevation](../explanation/head-contextual-elevation.md)
- **Pivot Reference:** [Task Force Members Pivot](./rbac-task-force-members-pivot.md)
- **Hierarchy Schema:** [Organizational Hierarchy Schema](./database-schema-organizational-hierarchy.md)
