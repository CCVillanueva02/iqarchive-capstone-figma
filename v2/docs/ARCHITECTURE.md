<!--
================================================================================
IQArchive v2 — Master Architecture Specification
================================================================================
File: v2/docs/ARCHITECTURE.md
Purpose: Master architectural specification and system topology for Bicol
         University's AACCUP Accreditation Document Management & Monitoring System.
Pattern: Modern Monolithic 3-Tier Architecture (Inertia.js Server-Driven SPA)
Platform: Laravel 13 MVC, Vue 3, Tailwind CSS v4, MySQL 8 3NF, Cloud Storage S3
Security Context: Multi-tenant college isolation (college_id scoping), Google SSO 
                  (@bicol-u.edu.ph domain gate), 15-minute temporary pre-signed URLs,
                  and 7-role server-side authorization policies.
Associated Docs:
  - System Architecture: v2/docs/system-architecture/system-architecture.md
  - Relational Database: v2/docs/db-design/database-design.md
  - Data Flow Diagrams:  v2/docs/dataflow/generalprocess/level-2-dfd.md
  - System Modules:      v2/docs/MODULES.md
  - Product PRD:         v2/docs/PRD.md
================================================================================
-->

# IQArchive v2 — Master Architecture Specification

## 1. Architectural Pattern & High-Level Topology

IQArchive is architected as a **Modern Monolithic 3-Tier Server-Driven SPA** using Inertia.js, Laravel 13, Vue 3, and MySQL 8, with binary assets backed by encrypted Cloud Object Storage (S3-compatible).

```
[User / Workstation Browser]  (Strictly Desktop-Only >= 1024px)
   (IQA Staff · College Dean · Task Force · Internal Accreditor · External Accreditor · BU Exec · Admin)
       │
       ▼
[Tier 1 — Frontend SPA (Inertia.js · Vue 3 · Tailwind CSS v4)]
   • Role-scoped persistent layouts
   • Shared Inertia props (auth user, roles, permissions, flash alerts)
   • Interactive workspaces: AACCUP Criteria Tree, Document Linking, OCR Split-Screen
   • Global <MobileUnsupported /> viewport enforcement barrier
       │
       ▼
[Tier 2 — Backend Application Core (Laravel 13 MVC)]
   • Controllers (Orchestration only) → Services (Business logic) → Eloquent Policies
   • Multi-tenant college_id scoping & dynamic Dean Lead elevation
   • Two-Tier Document Approval Engine (Dean Gatekeeper → IQA Consolidation)
   • Inline Tesseract OCR Engine (Dual-driver adapter with Google Cloud Vision readiness)
   • Automated Notification & Pipeline State Machine Engine
       │
       ├──────────────────────────────────────────┐
       ▼                                          ▼
[Tier 3 — Relational Database]         [Tier 3 — Object Storage]      [External Services]
(Managed MySQL 8 InnoDB)               (Private S3-Compatible Bucket) • Google Workspace SSO
   • 3NF Relational Metadata              • evidence/programs/...        (Strict @bicol-u.edu.ph)
   • JSON Columns (OCR confidence metrics)• evidence/institutional/... • Local Tesseract / Vision
   • Append-only Audit Trail              • evidence/common/...
   • Multi-tenant indexed college_id      • 15-minute Pre-Signed URLs
```

---

## 2. Core Architectural Pillars

### 2.1 Tier 1: Frontend SPA (Inertia.js + Vue 3 + Tailwind CSS v4)
- **Server-Driven SPA:** Eliminates the latency, security overhead, and API duplication of a detached REST/GraphQL frontend. Laravel controllers return Inertia page components directly with typed, server-validated props.
- **Composition API:** Built with Vue 3 `<script setup>` syntax for modular reactivity and component composability.
- **Workstation Viewport Policy (Strict Desktop-Only):** Accreditation matrices and split-screen document verification require screen real estate $\ge 1024$px. Viewports below $1024$px are guarded by `<MobileUnsupported />`.

### 2.2 Tier 2: Backend Application Core (Laravel 13 MVC)
- **Controller-Service-Policy Pipeline:** Controllers handle request validation and response dispatching. Complex domain operations (e.g., OCR text extraction, stage transitions, evidence consolidation) are encapsulated in dedicated Service classes (e.g., `ProcessDocumentOcrService`, `AccreditationPipelineService`).
- **Strict Server-Side Authorization:** Every controller endpoint enforces explicit Eloquent policies (e.g., `$this->authorize('endorse', $document)`). Client-side UI hiding is never treated as a security boundary.
- **Multi-Tenant Scoping:** All queries for program evidence, task force activities, and reviews enforce `college_id` scoping to isolate colleges while granting global views to IQA and BU Executives.

### 2.3 Tier 3: Split-Storage Model (MySQL 8 + Private S3)
- **Structured Relational Metadata:** MySQL 8 3NF schema manages user roles, colleges, programs, AACCUP criteria trees, and compliance records. Variable-length OCR metrics (bounding boxes, word confidences) reside in native MySQL `JSON` columns.
- **Binary Evidence Storage:** PDF files are stored in private cloud object storage. Direct public file URLs are completely disabled.
- **15-Minute Temporary Pre-Signed URLs:** Authorized file view requests mint a short-lived (15 min) cryptographically signed URL, preventing link-sharing and unauthorized access.

### 2.4 External Services & OCR Pipeline
- **Google Workspace OAuth 2.0:** Gated strictly to verified institutional accounts (`@bicol-u.edu.ph`) with Just-In-Time (JIT) provisioning.
- **Tesseract OCR (Human-in-the-Loop):** Processes official accreditation result certificates and score sheets. Extracted text is presented in a split-screen interface for mandatory review and confirmation by IQA personnel before saving.

---

## 3. Subsystem Cross-Reference Map

| Subsystem | Documentation File | Core Implementation Focus |
| :--- | :--- | :--- |
| **Product Requirements (PRD)** | [`v2/docs/PRD.md`](file:///c:/Users/crljs/OneDrive/Documents/GitHub/iqarchive-capstone/v2/docs/PRD.md) | Business goals, 7 personas, user stories, ISO 25010 evaluation, and problem statement. |
| **System Modules** | [`v2/docs/MODULES.md`](file:///c:/Users/crljs/OneDrive/Documents/GitHub/iqarchive-capstone/v2/docs/MODULES.md) | MOD-01 Document Repository (Program, Institutional, Common) and roadmap for MOD-02 through MOD-07. |
| **Relational Database** | [`v2/docs/db-design/database-design.md`](file:///c:/Users/crljs/OneDrive/Documents/GitHub/iqarchive-capstone/v2/docs/db-design/database-design.md) | 3NF normalized schema, table definitions, foreign keys, and ERD diagrams. |
| **Data Flow Diagrams (Level 2)** | [`v2/docs/dataflow/generalprocess/level-2-dfd.md`](file:///c:/Users/crljs/OneDrive/Documents/GitHub/iqarchive-capstone/v2/docs/dataflow/generalprocess/level-2-dfd.md) | Sub-process dictionaries and Mermaid data flow charts for Processes 1.0 to 7.0. |
| **Accreditation Pipeline** | [`v2/docs/accre-pipeline/accreditation-stages.md`](file:///c:/Users/crljs/OneDrive/Documents/GitHub/iqarchive-capstone/v2/docs/accre-pipeline/accreditation-stages.md) | Accreditation state transitions and 2-tier approval workflow. |
| **RBAC & Role Scoping** | [`v2/docs/rbac/roles.md`](file:///c:/Users/crljs/OneDrive/Documents/GitHub/iqarchive-capstone/v2/docs/rbac/roles.md) | The 7 institutional roles, Dean Lead elevation, and permission boundaries. |
