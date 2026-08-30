# RBAC: IQA Staff

This reference document specifies the capabilities, authorization gates, and operational boundaries of the consolidated `iqa-staff` role.

---

## 1. Role Summary

- **Role Identifier:** `iqa-staff` (Consolidates legacy `iqa-admin` and `iqa-member` roles)
- **Display Name:** IQA Staff / Member
- **Primary Domain:** Internal Quality Assurance Office accreditation lifecycle management, document verification, and task force orchestration.

---

## 2. Capabilities & Permissions

| Capability Domain | Allowed Actions | Enforcement Mechanism |
| :--- | :--- | :--- |
| **Colleges & Programs** | Create, edit, and soft-delete colleges and degree programs | Gate `manageCollegesAndPrograms` |
| **Task Force Rosters** | Create task forces, add/remove members, designate team leads | Gate `manageTaskForceMembers` |
| **Master Instruments** | Create, update, and publish master AACCUP instrument templates | `Livewire\Configuration\Instruments` |
| **Document Review** | Approve or reject uploaded compliance evidence; provide revision remarks | `App\Models\DocumentReview`, `Document::status` |
| **Access Approvals** | Approve or deny time-bounded document access requests from accreditors | `App\Models\DocumentAccessRequest` |
| **Program Monitoring** | Monitor accreditation progress, deadlines, and compliance ratios | `Livewire\Monitoring\MonitoringOverview` |

---

## 3. Route & UI Access

- **Default Landing Route:** `route('dashboard.iqa-staff')`
- **Protected Middleware:** `middleware(['auth', 'verified'])` + `User::hasRole('iqa-staff')`
- **Dashboard Features:** Real-time compliance radar, document review inbox, instrument manager, and program directory.

---

## 4. Security Constraints

- **Document Review Isolation:** Document status changes require formal review submission recording decision (`approved`/`rejected`), reviewer user ID, and timestamp.
- **Pre-Registration Capability:** IQA Staff can pre-register departmental users in `pending_activation` status for upcoming accreditation cycles.

---

## 5. Cross-Quadrant Links

- **Explanation:** [IQA Staff Role Consolidation](file:///c:/Users/janss/Herd/iqarchive/docs/explanation/iqa-staff-role-consolidation.md)
- **Document Management Schema:** [Document Management Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-document-management.md)
- **Dynamic Instruments Schema:** [Dynamic Instruments Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-dynamic-instruments.md)
