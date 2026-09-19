<!--
================================================================================
IQArchive v2 — Architecture Essentials
================================================================================
File: v2/docs/ARCHITECTURE-ESSENTIALS.md
Purpose: Plain-language architectural quick reference and core rules for 
         developers building IQArchive v2.
Architecture: Inertia.js (Vue 3) + Laravel 13 MVC + MySQL 8 (3NF) + Private S3
Security Context: Multi-tenant college_id scoping, 7-role server-side policies,
                  private S3 storage with 15-minute temporary signed URLs,
                  and Google Workspace OAuth (@bicol-u.edu.ph only).
Associated Docs:
  - Project Rules: .agents/rules/general-rules.md
  - Master Architecture: v2/docs/ARCHITECTURE.md
  - Product PRD: v2/docs/PRD.md
  - Database Schema: v2/docs/db-design/database-design.md
  - System Modules: v2/docs/MODULES.md
  - RBAC Matrix: v2/docs/rbac/roles.md
  - Design System: v2/docs/design-system.md
================================================================================
-->

# IQArchive v2 — Architecture Essentials

This guide explains the foundational architectural rules and patterns for IQArchive v2 in plain, direct English. Every developer working on this codebase must follow these principles.

For mandatory testing requirements, commit conventions, and development philosophy, see [.agents/rules/general-rules.md](file:///c:/Users/janss/Herd/iqarchive/.agents/rules/general-rules.md).

---

## 1. System Overview & The Monolithic Choice

IQArchive is built as a **Modern Monolithic Server-Driven SPA** using:
- **Backend:** Laravel 13 (PHP 8.4+)
- **Frontend:** Inertia.js + Vue 3 (Composition API `<script setup>`) + Tailwind CSS v4
- **Database:** MySQL 8 in strict 3rd Normal Form (3NF)
- **File Storage:** Private S3-compatible cloud object storage
- **Authentication:** Google Workspace OAuth 2.0 (`@bicol-u.edu.ph` email domain only)

### Why Inertia.js instead of a separate API + frontend SPA?
1. **No duplicate API layer:** Laravel controllers pass validated data straight to Vue page components as typed props. We do not write separate REST endpoints or manage client-side authentication tokens.
2. **Single security boundary:** Authentication, session management, and authorization gates live strictly on the Laravel backend, while users still get the fast, smooth feel of a single-page app.

---

## 2. The Golden Rules of Security & Multi-Tenancy

### Rule 1: Always Scope by `college_id`
Bicol University has multiple colleges (such as the College of Science, College of Medicine, and College of Engineering). 
- Evidence files, academic programs, and task force assignments belong to a specific college.
- **Every database query for college-level resources MUST filter by `college_id`**.
- Only users with university-wide roles (**System Administrator**, **IQA Staff**, **BU Executive**) may view records across all colleges.
- College Deans and Task Force Members can **never** view or modify records from another college.

### Rule 2: Authorize on the Server, Never Just in Vue
Hiding a button in the Vue interface is a visual convenience, not security.
- Every controller method must call `$this->authorize('action-name', $model)` before performing any work.
- If an unauthorized user sends a request directly to an endpoint, the backend must stop it and return an HTTP 403 Forbidden response.
- For mandatory security reasoning docblock standards on all gates and policies, see [.agents/rules/general-rules.md](file:///c:/Users/janss/Herd/iqarchive/.agents/rules/general-rules.md).

### Rule 3: Private Storage & 15-Minute Pre-Signed URLs
- Uploaded PDFs (evidence documents, reports, syllabi) are stored in private S3 buckets. Direct public web access to files is blocked.
- When an authorized user requests a file, the server checks their permissions and creates a **temporary link that expires after 15 minutes**.
- Users cannot share links with unauthorized persons because expired links fail immediately.

---

## 3. Backend Code Structure: Controller → Service → Model/Policy

To keep code clean, testable, and maintainable, we separate responsibilities into three distinct layers:

```
[HTTP Request]
      │
      ▼
1. Controller (app/Http/Controllers/)
   • Validates incoming input using Form Requests
     (validated input objects that encapsulate request validation rules)
   • Calls authorization gate ($this->authorize)
   • Delegates heavy work to a Service
   • Returns Inertia::render() response
      │
      ▼
2. Service (app/Services/)
   • Contains pure business logic
   • Example: Uploading files to S3, triggering OCR, logging audit records
   • Reusable across HTTP requests, CLI commands, and queued jobs
      │
      ▼
3. Eloquent Model & Policy (app/Models/, app/Policies/)
   • Defines data relationships, multi-tenant scopes, and role permissions
```

---

## 4. The 7 Roles & Permission Boundaries

IQArchive recognizes seven institutional roles with distinct boundaries. (See [v2/docs/rbac/roles.md](file:///c:/Users/janss/Herd/iqarchive/v2/docs/rbac/roles.md) for complete role definitions and permission boundaries.)

| Role | Operational Scope | Core Responsibilities & Limits |
| :--- | :--- | :--- |
| **1. System Administrator** | System-wide | Manages user accounts, institutional settings, and monitors system logs. **No authority** to approve or modify accreditation content. |
| **2. IQA Staff / Member** | University-wide | Drives the AACCUP accreditation calendar, initiates all stage transitions (Stages 1–9), consolidates evidence across colleges, and manages the shared Common Documents repository. |
| **3. College Dean** | College-scoped | Acts as the primary gatekeeper for their college. Approves task force evidence uploads before IQA sees them. **Contextual elevation:** Automatically serves as Task Force Lead for their college. |
| **4. Task Force Member** | College & Program | Subject-matter faculty assigned to specific AACCUP areas (Areas 1–10). Uploads evidence and writes self-survey narrative responses. |
| **5. Internal Accreditor** | Assigned Programs | Faculty conducting mock accreditation reviews. Can annotate and comment on documents to flag gaps prior to official submission. Does not block the pipeline. |
| **6. BU Executive** | University-wide | University President, Vice Presidents, and Deans viewing macro dashboards. **Strictly read-only access** to progress metrics and compliance charts. |
| **7. External Accreditor** | Assigned Programs | Official AACCUP survey team. Granted **read-only access** to finalized evidence packages exclusively during Stage 8 (Submitted). |

---

## 5. The Two-Tier Document Approval Workflow

Evidence uploaded by faculty does not enter the official accreditation package automatically. It must pass two verification checkpoints:

```
Step 1: Faculty / Task Force Member uploads evidence file
        ↓
Step 2: College Dean reviews and endorses (College Gate)
        ↓
Step 3: IQA Staff reviews and consolidates (University Gate)
        ↓
Step 4: Evidence becomes part of the final AACCUP survey package
```

- **Rejection at any step:** Returns the document to `Draft` status with mandatory feedback notes, alerting the uploader to correct or replace the file.

---

## 6. Optical Character Recognition (OCR)

When physical or scanned documents are uploaded, the backend extracts text using Tesseract OCR. Human staff verify and confirm extracted data in a split-screen interface before storing it. See `tasks/ocr-validation.tasks` for implementation details.

---

## 7. Workstation Policy (Desktop-Only >= 1024px)

Accreditation instruments, 10-area evidence matrices, split-screen PDF viewers, and compliance charts require significant display real estate.
- **IQArchive is strictly optimized for desktop workstations (screen width >= 1024px).**
- Any viewport smaller than 1024px renders a clean, full-screen `<MobileUnsupported />` view explaining that accreditation tasks must be performed on a desktop or laptop computer.

---

## 8. Development & Verification Checklist

Before opening a pull request or declaring a task complete, verify:
- [ ] All database queries filter by `college_id` (except global IQA/Admin operations).
- [ ] Every controller endpoint has an explicit policy authorization check (`$this->authorize`).
- [ ] Non-obvious logic includes security reasoning docblocks (see [.agents/rules/general-rules.md](file:///c:/Users/janss/Herd/iqarchive/.agents/rules/general-rules.md)).
- [ ] Code comments and specifications use plain, direct language with no unexplained jargon.
- [ ] Implementation avoided unnecessary abstractions (applied ponytail mode; see [.agents/rules/general-rules.md](file:///c:/Users/janss/Herd/iqarchive/.agents/rules/general-rules.md)).
- [ ] File uploads use the private S3 disk and temporary pre-signed URLs.
- [ ] Automated verification passes: `php artisan test` (backend) and `npm run build` (frontend assets).
