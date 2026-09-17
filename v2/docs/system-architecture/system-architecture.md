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
  - *OCR Preview* — split-screen validation UI (original PDF alongside extracted text)
- **Human-in-the-Loop Confidence Preview** — interactive split-screen canvas rendering the uploaded PDF via pre-signed URL on one side and editable OCR text on the other, automatically highlighting words with confidence $< 0.65$ for human inspection and correction before submission.

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

**Synchronous OCR Processing (`ProcessDocumentOcrService`):** In IQArchive, OCR text extraction is targeted strictly at **accreditation results** (official AACCUP certificates, evaluation rating sheets, and board resolutions). Because these documents are standardized and short (typically 1–3 pages), OCR executes **synchronously inline** within the upload request cycle in 1.5 to 3 seconds. This design choice eliminates the infrastructure overhead and monitoring complexity of background queue workers and WebSockets, delivering an instantaneous response that redirects the user directly to the Split-Screen Validation canvas with highlighted low-confidence tokens.

---

## 6. Eloquent ORM / ACID Transactions

Laravel's Eloquent ORM maps PHP objects to MySQL tables and manages relationships (e.g., a Document belongs to a Program and has one OcrResult). Multi-step writes — such as creating a Document record and its initial OCR processing result together — are wrapped in database transactions so that a failure midway rolls back everything rather than leaving orphaned or inconsistent records.

---

## 7. Tier 3 — Database & Storage (Data Layer)

**Stack:** Laravel Cloud Managed MySQL 8 (InnoDB) + Laravel Cloud Managed Storage (S3-Compatible)

**Why split storage:** Managed MySQL is efficient for querying structured metadata (RBAC, audit logs, confidence scores); cloud object storage is engineered for high-throughput, encrypted binary PDF persistence and edge delivery, preventing database table bloat.

The data tier is anchored by four foundational pillars:
- **Normalized Schema (Strict 3NF)** — normalized tables for colleges, programs, documents, OCR results, AACCUP areas/criteria, and the `task_force_members` pivot table that is the authoritative source of RBAC assignment.
- **JSON Columns** — `confidence_metrics` and `pages_data` on `ocr_results` store variable-length OCR confidence data (per-word bounding boxes and scores, per-page breakdowns) without needing a separate table per word.
- **Audit Trail** — an immutable, append-only activity log records every meaningful action (uploads, views, approvals, stage transitions) with who, what, and when, for AACCUP compliance.
- **Protected Storage** — PDFs reside in a strictly private cloud storage bucket using the structured key convention `evidence/{college_id}/{program_id}/{file_hash}.pdf`. Direct public web access is completely prohibited; every document view or download is authorized server-side by `DocumentController` policy checks before minting a time-limited pre-signed URL.

---

## 8. Cloud Storage Integration / Pre-Signed Temporary URLs

The backend's connection to cloud storage:
- **Pre-signed temporary URLs (15-minute expiration)** — when an authorized user requests a document stream or preview, `DocumentController` verifies role authorization, records an audit log entry, and mints an S3 pre-signed URL with `Content-Disposition: inline`. The desktop browser streams the PDF directly from cloud storage, offloading all binary transfer from Laravel application containers.
- **Zero Local Disk Dependency** — all uploads write directly to the managed S3-compatible bucket, ensuring seamless operation in ephemeral container environments on Laravel Cloud.

---

## 9. External Services Layer

**Google Workspace OAuth 2.0** — Single sign-on gated strictly to `@bicol-u.edu.ph` addresses. There is no local password flow; if a user's Google Workspace account is disabled by university IT, their IQArchive access is automatically revoked too.

**Cloud OCR Adapter (`OcrEngineInterface`)** — Implements an adaptable dual-driver strategy:
- *Google Cloud Vision API (Production Cloud Driver):* Seamlessly aligns with Bicol University's institutional Google Workspace ecosystem. Provides $> 96\%$ extraction accuracy on complex academic records, stamps, and multi-column syllabi with zero server binary dependencies.
- *Tesseract OCR 5.x (Local Dev Fallback Driver):* Preserves local offline development capabilities on Laravel Herd / Windows / Linux workstations without incurring external API requirements.

---

## Design Principles Reflected in This Architecture

- **Compliance & Privacy First:** Immutable audit trail, mandatory human approval before OCR data is trusted, and AES-256 encrypted private cloud storage with time-limited pre-signed URLs adhering to RA 10173.
- **Institutional Ecosystem Fit:** Cloud OCR and SSO natively leverage Bicol University's enterprise Google Workspace identity.
- **PaaS Scalability & Zero-Downtime:** Ephemeral container architecture on Laravel Cloud with automated point-in-time database backups, health checks, and zero-downtime deployment pipelines.
- **Role-Based and Multi-Tenant:** 7 distinct institutional roles, college-scoped data isolation enforced at the Eloquent query and storage path level.
- **Lean Synchronous OCR Pipeline:** Because OCR is targeted strictly at standardized accreditation results (certificates and rating sheets of 1–3 pages), processing executes synchronously in 1.5–3 seconds, eliminating queue worker overhead and delivering instantaneous split-screen validation feedback.