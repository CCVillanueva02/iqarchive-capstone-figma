# Explanation: IQA Staff Role Consolidation

This architectural explanation document details the rationale and design decisions behind merging the legacy `iqa-admin` and `iqa-member` roles into a unified `iqa-staff` role.

---

## 1. Background & The Split-Role Problem

In initial iterations of the IQArchive system, the Internal Quality Assurance Office access control was split into two discrete roles:
1. **`iqa-admin`**: Intended for senior coordinators to manage colleges, assign degree programs, and publish master accreditation instruments.
2. **`iqa-member`**: Intended for junior staff to review uploaded documents, verify OCR text extractions, and issue compliance remarks.

### Operational Reality in Bicol University
In practical institutional operations at Bicol University's IQA Office:
- The same QA staff members frequently orchestrate the entire lifecycle of an accreditation cycle—from provisioning new degree programs to reviewing syllabi and verifying compliance documents.
- The artificial division created significant operational friction: staff members with `iqa-member` roles were blocked from updating task force rosters or managing program metadata during intensive accreditation preparations.

---

## 2. Codebase Friction & Anti-Patterns

The split roles introduced technical redundancy across the application:

- **Redundant Route & Gateway Checks:** Controllers and route gateways repeatedly had to verify both roles simultaneously:
  ```php
  // Pre-consolidation workaround
  if (in_array($user->role, ['iqa-staff', 'iqa-admin', 'iqa-member'])) {
      return redirect()->route('dashboard.iqa-staff');
  }
  ```
- **Duplicate Livewire Component Logic:** Admin screens and reviewer screens duplicated UI components with minor capability toggles.

---

## 3. The Consolidation Solution

On August 19, 2026, migration `2026_08_19_000000_refactor_roles_and_task_force_members.php` formally merged all IQA accounts:

```
┌──────────────┐
│  iqa-admin   │──────┐
└──────────────┘      │
                      ▼
┌──────────────┐  Consolidated into   ┌─────────────┐
│  iqa-member  │─────────────────────►│  iqa-staff  │
└──────────────┘                      └─────────────┘
```

### Architectural Benefits
1. **Single Source of Truth:** One unified role identity simplifies Laravel authorization gates (`manageCollegesAndPrograms`, `manageTaskForceMembers`).
2. **Seamless Workflow:** IQA personnel can effortlessly switch between high-level program monitoring and granular document approvals in a single dashboard workspace.
3. **Clean Migration Path:** Existing database accounts and `role_user` pivot entries were mapped non-destructively to the canonical `iqa-staff` role ID.

---

## 4. Cross-Quadrant Links

- **Role Specification:** [RBAC: IQA Staff Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-iqa-staff.md)
- **Database Schema:** [Authentication & Security Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-auth-security.md)
- **System Architecture:** [System Architecture Overview](file:///c:/Users/janss/Herd/iqarchive/docs/reference/architecture-overview.md)
