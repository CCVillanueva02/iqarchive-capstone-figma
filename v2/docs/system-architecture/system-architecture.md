<!--
================================================================================
IQArchive v2 — System Architecture Specification
================================================================================
File: v2/docs/system-architecture/system-architecture.md
Purpose: Authoritative architectural specification for Bicol University's AACCUP
         Accreditation Document Management and Monitoring System.
Pattern: Modern Monolithic 3-Tier Architecture (Inertia.js Server-Driven SPA)
Platform: Laravel Cloud (Managed MySQL 8 + Managed Object Storage S3)
Security Context: Multi-tenant college isolation, Google Workspace SSO, RBAC
                  gatekeeper across 7 institutional roles, 15m pre-signed URLs.
================================================================================
-->

# IQArchive v2 — System Architecture

**Pattern:** Modern monolithic 3-tier architecture (Inertia.js server-driven SPA)  
**Host Environment:** Laravel Cloud (Colocated Managed MySQL 8 + Managed Object Storage S3)  

---

## Overview

IQArchive is a Document Management and Monitoring System supporting Bicol University's AACCUP accreditation process. The architecture is a single Laravel application organized into three tiers plus a workstation access layer and external services layer. This modern monolithic approach was chosen for simplicity, maintainability, and rapid development by a focused team, while delivering enterprise-grade multi-tenancy, immutable compliance auditing, and Tesseract OCR text recognition on accreditation results.

The architecture comprises **5 foundational components** directly reflecting the system architecture diagram:

```
[User / Workstation Browser]
  (IQA Staff · College Dean · Task Force · External Accreditor · Internal Accreditor · BU Executive · System Admin)
       │
       ▼
[Tier 1 — Frontend SPA (Inertia.js · Vue 3 · Tailwind CSS v4)]
  • Role-scoped persistent layouts
  • Centralized Inertia shared props (Auth user, roles, permissions, alerts)
  • Interactive workspaces: AACCUP Tree, Document Linking, OCR Preview
    (Split-screen: PDF + Extracted Text)
  • Human-in-the-Loop Confidence Preview
       │
       ▼
[Tier 2 — Backend Application Core (Laravel 13 MVC)]
  • Controllers → Services → Eloquent Models & Policies
  • Security & RBAC: Multi-tenant college isolation, Role gatekeeper & forced gates
  • 9-stage Accreditation pipeline
  • Tesseract OCR
       │
       ├──────────────────────────────────────────┐
       ▼                                          ▼
[Tier 3 — Database & Storage]             [External Services]
(Managed MySQL 8 + Cloud Storage S3)       • Google Workspace OAuth 2.0
  • Normalized Schema                        (Gated to @bicol-u.edu.ph)
  • JSON Columns
  • Audit Trail
  • Protected Storage (15m Pre-Signed URLs)
```

---

## 1. User / Workstation Browser

**Institutional Roles (7 total):**

| Role | Responsibility & Authority |
| :--- | :--- |
| **System Administrator** | System configuration, user account provisioning, and audit log oversight. |
| **IQA Staff / IQA Member** | Central quality assurance coordinator — exclusively owns and authorizes all 9 stage transitions; consolidates university-wide evidence packages. |
| **College Dean** | Approves college-level evidence uploads; automatically elevated to Task Force Lead for their academic unit. |
| **Task Force Member** | Program-level subject-matter experts (SMEs) who assess AACCUP criteria, upload evidence, and validate OCR text extractions. |
| **Internal Accreditor** | Mock/rehearsal reviewer — inspects evidence during Stages 5–7 and provides advisory feedback as an external accreditor would, before formal submission. No approval or veto power. |
| **BU Executive** | University leadership (President, VPs) with read-only access to macro analytics and institutional completion dashboards. |
| **External Accreditor** | Formal AACCUP evaluation team; granted read-only access strictly upon Stage 8 (Formal Submission). |

### Workstation Viewport & Security Policy
- **Desktop-Only Workstation Focus:** Access is engineered strictly for desktop/laptop displays ($\ge 1024$px / `lg`+). Mobile layouts are intentionally excluded due to complex multi-level accreditation matrices, split-screen OCR validation canvases, and side-by-side document compliance inspections.
- **Transport Layer Security (HTTPS):** All browser-to-server traffic is encrypted in transit via TLS 1.3, protecting accreditation evidence, session cookies, and SSO tokens.

---

## 2. Tier 1 — Frontend SPA (Presentation Layer)

**Stack:** Inertia.js · Vue 3 (Composition API with `<script setup>`) · Tailwind CSS v4

Inertia.js replaces traditional REST API + SPA separation. RBAC gates run securely on the server and cannot be bypassed client-side, eliminating API boilerplate while maintaining a smooth single-page application user experience.

### Core Frontend Capabilities:
- **Role-Scoped Persistent Layouts:** Sidebar and navigation persist across page navigations and dynamically adjust to the authenticated role (e.g., a Dean sees "My College" and college-wide status; a Task Force member sees assigned program criteria).
- **Centralized Inertia Shared Props:** Every page automatically receives `auth.user`, `auth.roles`, `auth.permissions`, active college context, and flash alerts from the server, so the frontend never has to make separate authorization requests.
- **Interactive Workspaces:**
  - *AACCUP Tree:* Hierarchical navigation of the 10 accreditation areas, parameters, and criteria.
  - *Document Linking:* Interactive drag-and-drop linking of evidentiary documents onto compliance criteria.
  - *OCR Preview (Split-Screen: PDF + Extracted Text):* Side-by-side workspace displaying the uploaded PDF evidence on one side and the extracted text on the other.
- **Human-in-the-Loop Confidence Preview:** Active validation subsystem embedded directly in the OCR preview that evaluates token confidence scores, highlights low-confidence words ($< 0.65$) in visual bounding boxes, and enforces explicit human verification and manual corrections before an accreditation result is submitted for Dean review.

### Communication Protocol: Cookie-Session + Partial Reloads
- **Encrypted Session Cookie:** User sessions are stored in an encrypted, `httpOnly`, `SameSite=Lax` cookie — inaccessible to client-side JavaScript, mitigating XSS token theft.
- **Inertia Partial Reloads:** On page transitions, Inertia re-renders only the changed component props rather than performing full document reloads, preserving layout state and minimizing bandwidth consumption.

---

## 3. Tier 2 — Backend Application Core (Business & Logic Layer)

**Stack:** Laravel 13 MVC

**Request Pipeline:** `Controller → Service → Eloquent Model / Policy`
- **Controllers:** Handle HTTP request validation, route authorization, and Inertia response orchestration only.
- **Services:** Encapsulate complex business logic and domain workflows (e.g., `ProcessDocumentOcrService`).
- **Policies:** Enforce fine-grained server-side authorization gates before any business logic executes.

### Core Backend Capabilities:
- **Security & Multi-Tenant Scoping:**
  - *College Isolation:* Academic units are strictly isolated at the query level. Every document, program, and audit query includes `where('college_id', $user->college_id)`.
  - *Role Gatekeeper:* Every controller action explicitly calls `$this->authorize()` before executing domain logic.
  - *Forced Gates:* Critical actions require explicit human approval (OCR validation cannot auto-commit; stage advancement requires explicit IQA signoff).
- **Accreditation Engine (9-Stage State Machine):**
  - Manages the full accreditation lifecycle: *Draft → Candidate Status → Self-Survey Preparation → Evidence Collection → Internal Mock Review → Feedback Integration → Revision & Signoff → Formal Submission → Accredited*.
  - Enforces per-stage pre-conditions (e.g., Evidence Collection requires at least one document per area; Revision requires resolving all advisory deficits).
  - *Stage Transition Authority:* All 9 stage transitions are initiated and approved exclusively by **IQA Staff**.
- **Tesseract OCR Processing (`ProcessDocumentOcrService`):**
  - In IQArchive, OCR text extraction is powered by Tesseract OCR (with an adaptable cloud vision driver for production) targeted strictly at **accreditation results** (official AACCUP certificates, evaluation summary rating sheets, and board resolutions).
  - Because these documents are standardized and short (typically 1–3 pages), OCR executes **synchronously inline** within the upload request cycle in 1.5 to 3 seconds.
  - This eliminates the infrastructure overhead, failed job tables, and monitoring complexity of background queue workers and WebSockets, delivering an instantaneous response that redirects the user directly to the Split-Screen Validation canvas with highlighted low-confidence tokens.
- **Data Persistence & ACID Transactions:**
  - Eloquent ORM manages relationships across tables. Multi-step operations (e.g., storing a document record, saving initial OCR results, and logging the upload event) are wrapped in database transactions to guarantee all-or-nothing consistency.

---

## 4. Tier 3 — Database & Storage (Data Layer)

**Stack:** Laravel Cloud Managed MySQL 8 (InnoDB) + Laravel Cloud Managed Storage (S3-Compatible)

**Split-Storage Architecture:** Managed MySQL 8 handles relational metadata, RBAC, and audit logs; managed cloud object storage stores binary PDF evidence files. This prevents database bloat and offloads heavy file streaming from application containers.

The data tier is anchored by **four foundational pillars**:
1. **Normalized Schema (Strict 3NF):** 22 normalized relational tables modeling colleges, programs, task forces, accreditation surveys, survey instruments, criteria, documents, reviews, and audit logs.
2. **JSON Columns:** Native MySQL `JSON` columns on `ocr_results` (`confidence_metrics` and `pages_data`) store variable-length word bounding boxes, per-word confidence scores, and page layout dimensions without needing millions of child rows.
3. **Audit Trail:** An immutable, append-only activity log (`audit_logs`) records every meaningful system action (uploads, views, approvals, stage transitions) with user ID, IP address, user agent, timestamp, and college scope for regulatory AACCUP compliance.
4. **Protected Storage (Private S3 Bucket):**
   - PDF evidence files reside in a strictly private cloud storage bucket using the structured key convention `evidence/{college_id}/{program_id}/{file_hash}.pdf`.
   - Direct public web access is completely blocked. Every document view or download is authorized server-side by `DocumentController` policy checks before minting a temporary **15-minute pre-signed URL** with `Content-Disposition: inline`.
   - The desktop browser streams the PDF directly from cloud storage, offloading all binary transfer from Laravel application containers.

---

## 5. External Services Layer

**Google Workspace OAuth 2.0:**
- Single sign-on gated strictly to `@bicol-u.edu.ph` institutional accounts.
- Eliminates local passwords and password reset vulnerabilities. If an employee's institutional Google account is suspended by Bicol University IT, their IQArchive access is immediately severed.

**Cloud OCR Adapter (`OcrEngineInterface`):**
- Implements an adaptable dual-driver strategy:
  - *Google Cloud Vision API (Production Cloud Driver):* Natively aligns with Bicol University's enterprise Google Workspace ecosystem. Delivers $> 96\%$ extraction accuracy on academic certificates, seals, stamps, and tabular evaluation rating sheets with zero server binary dependencies.
  - *Tesseract OCR 5.x (Local Dev Fallback Driver):* Preserves local offline development capabilities on Laravel Herd / Windows / Linux workstations without incurring external API requirements.

---

## Design Principles Reflected in This Architecture

- **Compliance & Privacy First:** Immutable audit trail, mandatory human approval before OCR data is trusted, and AES-256 encrypted private cloud storage with time-limited pre-signed URLs adhering to RA 10173 (Data Privacy Act of 2012).
- **Institutional Ecosystem Fit:** Cloud OCR and single sign-on natively leverage Bicol University's enterprise Google Workspace identity infrastructure.
- **PaaS Scalability & Zero-Downtime:** Ephemeral container architecture on Laravel Cloud with automated point-in-time database backups, health checks, and zero-downtime deployment pipelines.
- **Role-Based and Multi-Tenant:** 7 distinct institutional roles, college-scoped data isolation enforced at the Eloquent query and storage path level.
- **Lean Tesseract OCR Pipeline:** Because OCR is targeted strictly at standardized accreditation results (certificates and rating sheets of 1–3 pages), processing executes synchronously in 1.5–3 seconds, eliminating queue worker overhead and delivering instantaneous split-screen validation feedback.