# RBAC: Accreditor

This reference document specifies the capabilities, security isolation, and evaluation privileges of the `accreditor` role (AACCUP External/Internal Evaluators).

---

## 1. Role Summary

- **Role Identifier:** `accreditor`
- **Display Name:** AACCUP Accreditor
- **Primary Domain:** Objective evaluation of program accreditation submissions, evidence verification, and scoring.

---

## 2. Capabilities & Permissions

| Capability Domain | Allowed Actions | Enforcement Mechanism |
| :--- | :--- | :--- |
| **Evidence Inspection** | View uploaded documents linked to assigned program criteria | `SubmissionController`, `AccreditationEvidenceController` |
| **Access Requests** | Request temporary access for restricted institutional documents | `App\Models\DocumentAccessRequest` |
| **Submission Scoring** | Evaluate parameter compliance and record formal accreditor scores | `routes/web.php` (`submissions.accreditor`) |
| **Isolated UI Shell** | Focused distraction-free workspace (sidebar/header suppressed) | `pages.roles.accreditor.submission` |

---

## 3. Strict Read-Only & Isolation Guarantees

To ensure unbiased and tamper-proof evaluation:
1. **No Upload/Delete Privileges:** Accreditors cannot upload, alter, or delete university documents.
2. **Time-Bounded Access:** Restricted documents require an approved `DocumentAccessRequest` with an `expires_at` timestamp. Expired access is instantly revoked by middleware.
3. **Session Landing Gateway:** Accreditors are directly routed to their assigned submission workspace on login:
   ```php
   if ($role === 'accreditor') {
       return redirect()->route('submissions.accreditor');
   }
   ```

---

## 4. Cross-Quadrant Links

- **Document Management Schema:** [Document Management Reference](./database-schema-document-management.md)
- **Role Reference:** [RBAC: IQA Staff](./rbac-iqa-staff.md)
- **Technical Reference:** [Google SSO Authentication Flow](./auth-google-sso.md)
