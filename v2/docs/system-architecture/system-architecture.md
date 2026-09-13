# IQArchive v2 — System Architecture

**Pattern:** Modern monolithic 3-tier architecture (Inertia.js server-driven SPA)

---

## Overview

IQArchive is a Document Management and Monitoring System supporting Bicol University's AACCUP accreditation process. The architecture is a single Laravel application split into three tiers plus an external services layer, chosen for simplicity given a small team and tightly coupled features (OCR, documents, and accreditation stage all interact).

---

## 1. User / Workstation Browser

**Roles (7 total):**

| Role | Purpose |
|------|---------|
| System Administrator | Manages accounts, configuration, audit access |
| IQA Staff / IQA Member | Central coordinator — owns all 9 stage transitions, consolidates evidence |
| College Dean | Approves college-level evidence uploads; automatically elevated to Task Force lead for their college |
| Task Force Member | Subject-matter experts who assess AACCUP criteria and manage evidence per program |
| Internal Accreditor | Mock/rehearsal reviewer — reads and comments on evidence as an external accreditor would, before real submission. No approval or veto power. |
| BU Executive | University-wide read-only dashboard |
| External Accreditor | The real AACCUP panel; read-only access, granted only after formal submission |

Access is via desktop browser (≥1024px) only — mobile is intentionally excluded to reduce risk of insecure document viewing.

---

## 2. HTTPS

All traffic between browser and server is encrypted (TLS). This protects accreditation evidence, session cookies, and SSO tokens in transit — required given the compliance-sensitive nature of the data.

---

## 3. Tier 1 — Frontend SPA (Presentation Layer)

**Stack:** Inertia.js · Vue 3 · Tailwind CSS v4

Inertia is used instead of a REST API + SPA framework because RBAC gates run server-side and can't be bypassed client-side, and it avoids API boilerplate while still feeling like a SPA.

**Key features:**
- **Role-scoped persistent layouts** — sidebar and navigation persist across pages and change based on the logged-in role (e.g., a Dean sees "My College" and college-wide status; a Task Force member sees their assigned program's AACCUP areas).
- **Centralized shared props** — every page automatically receives `auth.user`, `auth.roles`, `auth.permissions`, and flash alerts from the server, so the frontend never has to separately ask "can I do this?"
- **Interactive workspaces:**
  - *AACCUP Tree* — hierarchical navigation of the 10 accreditation areas and their criteria
  - *Document Linking* — drag evidence documents onto criteria
  - *OCR Preview* — split-screen validation UI
- **Split-screen: PDF + Extracted Text** — original PDF on one side, editable OCR output on the other, with low-confidence words flagged for the user's attention.

---

## 4. Cookie-Session + Partial Reloads

The frontend/backend communication protocol:
- **Cookie-session:** the user's session is stored in an encrypted, httpOnly cookie — not exposed to JavaScript, not stored client-side as raw data.
- **Partial reloads:** Inertia only re-renders the component that changed on navigation, rather than reloading the full page — keeping the sidebar and layout stable and reducing bandwidth.

---

## 5. Tier 2 — Backend Application Core (Business & Logic Layer)

**Stack:** Laravel 13 MVC

**Request pipeline:** `Controller → Service → Eloquent Model/Policy`
- Controllers handle HTTP concerns only
- Services hold business logic (e.g., `ProcessDocumentOcrService`)
- Policies decide authorization (e.g., can this user approve this document?)

**Security & RBAC:**
- **Multi-tenant college isolation** — nearly every query is scoped by `college_id`, so a Dean or Task Force member from one college can never see another college's data.
- **Role gatekeeper** — every controller action calls `$this->authorize()` before running any logic.
- **Forced gates** — certain actions can never be automatic: OCR approval requires an explicit human action, and stage transitions require explicit approval (they don't auto-progress).

**Stage transition authority:** All 9 stage transitions (Draft → ... → Accredited) are initiated and approved by **IQA Staff only**. College Deans gate evidence uploads at the college level before IQA consolidates it. Internal Accreditors can comment during later stages (Feedback Integration through Revision) but their comments are advisory — they don't block or approve anything.

**Accreditation Engine:** Implements the 9-stage pipeline as a state machine, with per-stage requirements (e.g., Evidence Collection requires at least one document per area) and an audit trail of every transition.

**ProcessDocumentOcrService (synchronous):** OCR now runs inline during the upload request rather than on a background queue. This was chosen because document volume doesn't require async processing yet, and users get immediate feedback rather than waiting on a job to complete. Timeouts are estimated from file size (roughly 2–3 seconds per MB, capped at 120 seconds).

---

## 6. Eloquent ORM / ACID Transactions

Laravel's Eloquent ORM maps PHP objects to MySQL tables and manages relationships (e.g., a Document belongs to a Program and has one OcrResult). Multi-step writes — such as creating a Document record and its OCR result together — are wrapped in database transactions so that a failure midway rolls back everything rather than leaving orphaned or inconsistent records.

---

## 7. Tier 3 — Database & Storage (Data Layer)

**Stack:** MySQL 8 (InnoDB) + protected local disk storage

**Why split storage:** MySQL is efficient for querying structured metadata (RBAC, audit logs, confidence scores); local disk is better suited to storing and streaming large binary PDFs, which would bloat a database table.

- **Strict 3NF schema** — normalized tables for colleges, programs, documents, OCR results, AACCUP areas/criteria, and the `task_force_members` pivot table that is the authoritative source of RBAC assignment.
- **JSON columns** — `confidence_metrics` and `pages_data` on `ocr_results` store variable-length OCR confidence data (per-word scores, per-page breakdowns) without needing a separate table per word.
- **Audit trail** — an immutable, append-only activity log records every meaningful action (uploads, approvals, stage transitions) with who, what, and when, for AACCUP compliance.
- **Protected disk storage** — PDFs live at `/mnt/storage/iqarchive/protected/{college}/{program}/`, outside the web root. Files are never served by direct URL; every download goes through an authorization check in `DocumentController` before streaming bytes.

---

## 8. HTTPS / PDF Stream + OCR Sync

The backend's outbound connections to external and local services:
- **PDF streaming** — reads a file from protected disk and streams it to the browser only after confirming the requesting user is authorized for that college/program.
- **OCR sync** — Tesseract runs as a local binary invoked directly by the Laravel service; there's no external network call, so this arrow represents an internal process call rather than a remote API request.

---

## 9. External & Async Services Layer

**Google Workspace OAuth 2.0** — Single sign-on gated strictly to `@bicol-u.edu.ph` addresses. There is no local password flow; if a user's Google Workspace account is disabled by university IT, their IQArchive access is automatically revoked too.

**Tesseract OCR** — Chosen over a cloud OCR API (e.g., Google Cloud Vision) because it's free at scale, keeps data on-prem for compliance, and has no network dependency. Trade-off: somewhat lower accuracy (~85–92%) than a cloud API, which is why human validation is required.

**Human-in-the-Loop Confidence Preview** — No OCR text is committed to the database automatically. The extracted text is shown next to the source PDF, low-confidence words are flagged (below a 0.65 threshold), and a person must review and approve — or edit and then approve — before the text becomes part of the official evidence record.

---

## Design Principles Reflected in This Architecture

- **Compliance-first:** immutable audit trail, mandatory human approval before OCR data is trusted
- **Cost-conscious:** self-hosted Tesseract instead of a metered API, local disk instead of cloud storage
- **University-controlled:** everything runs on-prem, no vendor lock-in, SSO tied to institutional identity
- **Role-based and multi-tenant:** 7 distinct roles, college-scoped data isolation enforced at the query level
- **Right-sized for scale:** synchronous processing and MySQL are simpler to operate than async queues and PostgreSQL, and are sufficient at current document volumes; both can be revisited if volume grows significantly