<!--
================================================================================
IQArchive v2 — System Architecture Diagram Explainer (Panelist Guide)
================================================================================
File: v2/docs/system-architecture/architecture-diagram-expl.md
Purpose: Comprehensive explanation of the IQArchive system architecture diagram
         for capstone panelists, accreditors, and engineering reviewers.
Pattern: Modern Monolithic 3-Tier Architecture (Inertia.js Server-Driven SPA)
Platform: Laravel Cloud (Managed MySQL 8 + Managed Object Storage S3)
================================================================================
-->

# IQArchive v2 — System Architecture Explained

## Overview
IQArchive is built on a **modern cloud monolithic 3-tier architecture** (Inertia.js server-driven SPA) deployed on Laravel Cloud. The architecture is represented by **5 foundational visual components** working together:

---

## **1. User / Workstation Browser**
**Target Hardware:** Desktop & Laptop Workstations ($\ge 1024$px / `lg`+)  
**Security Transport:** Encrypted TLS 1.3 (HTTPS)

The entry point for all academic stakeholders across Bicol University. It supports **7 distinct institutional roles**:
1. **System Administrator:** Global account provisioning and audit log oversight.
2. **IQA Staff / Member:** Central quality assurance coordinator; exclusively initiates and authorizes all 9 stage transitions.
3. **College Dean:** Approves college-level evidence uploads; automatically elevated to Task Force Lead for their college.
4. **Task Force Member:** Subject-matter experts who assess AACCUP criteria, upload evidence, and validate OCR text extractions.
5. **Internal Accreditor:** Mock evaluation reviewer; provides advisory commentary during Stages 5–7 before real submission.
6. **BU Executive:** University leadership with read-only macro analytics and executive dashboards.
7. **External Accreditor:** Formal AACCUP evaluation team; granted read-only access strictly upon Stage 8 (Formal Submission).

*Policy Note:* IQArchive is engineered strictly for desktop viewports ($\ge 1024$px) due to dense accreditation matrices, split-screen OCR validation, and multi-document compliance reviews.

---

## **2. Tier 1: What Users See (Frontend SPA)**
**Technology:** Inertia.js · Vue 3 (Composition API with `<script setup>`) · Tailwind CSS v4

The interface your users interact with:
- **Role-Scoped Persistent Layouts:** Sidebar and navigation persist smoothly across page transitions and adapt dynamically to the logged-in role (e.g., a Dean sees college-wide metrics; an Accreditor sees the compliance tree).
- **Centralized Shared Props:** The server automatically shares `auth.user`, `auth.roles`, `auth.permissions`, and alerts on every request without requiring client-side API requests.
- **Interactive Workspaces:**
  - *AACCUP Tree:* Hierarchical navigation across the 10 accreditation areas, parameters, and criteria.
  - *Document Linking:* Interactive drag-and-drop linking of evidentiary documents onto compliance criteria.
  - *OCR Preview (Split-Screen: PDF + Extracted Text):* Side-by-side workspace displaying the uploaded PDF evidence alongside extracted text.
- **Human-in-the-Loop Confidence Preview:** Embedded validation subsystem that evaluates per-word OCR confidence scores, flags words with confidence $< 0.65$ with visual bounding boxes, and forces human inspection and verification before text is committed to the official record.

*Communication Protocol:* Uses encrypted, `httpOnly` cookie-sessions and Inertia partial reloads to update only the changed components on navigation.

---

## **3. Tier 2: The Brain (Backend Application Core)**
**Technology:** Laravel 13 MVC + PHP 8.3+

The engine that powers all business logic, security policies, and accreditation state machines:
- **Controller → Service → Eloquent Pipeline:** Strict separation where controllers handle HTTP orchestration, services encapsulate complex logic, and policies enforce server-side RBAC.
- **Multi-Tenant College Isolation:** Every database query and storage path is strictly scoped by `college_id`. Deans and Task Forces from one college can never inspect another college's non-public data.
- **Accreditation Engine (9-Stage Pipeline):** Manages the full accreditation lifecycle as a strict state machine with enforceable pre-conditions. Stage advancement authority is restricted exclusively to IQA Staff.
- **Tesseract OCR Engine:** Inline text extraction powered by Tesseract OCR dedicated strictly to **accreditation results** (AACCUP certificates, rating sheets, and board resolutions of 1–3 pages). Processing completes in **1.5 to 3 seconds**, eliminating queue worker complexity while providing instant validation feedback.
- **ACID Transactions:** Multi-step writes (document creation + OCR extraction + audit logging) are wrapped in database transactions to guarantee data integrity.

---

## **4. Tier 3: Database & Storage (Data Layer)**
**Technology:** Laravel Cloud Managed MySQL 8 (InnoDB) + Laravel Cloud Managed Storage (S3-Compatible)

The data layer is anchored by **four foundational pillars**:
1. **Normalized Schema (Strict 3NF):** 22 normalized relational tables modeling the university hierarchy, user roles, accreditation surveys, and document links.
2. **JSON Columns:** Native MySQL `JSON` columns on `ocr_results` (`confidence_metrics` and `pages_data`) store variable-length word bounding boxes, per-word confidence scores, and page layout dimensions.
3. **Audit Trail:** Immutable append-only log (`audit_logs`) capturing all uploads, reviews, approvals, and stage transitions for regulatory AACCUP compliance.
4. **Protected Storage (Private S3 Bucket):** All PDF evidence files reside in a private cloud storage bucket at `evidence/{college_id}/{program_id}/{file_hash}.pdf`. All views stream via authorized, time-limited **15-minute pre-signed URLs**, offloading file transfer from application servers.

---

## **5. External Services Layer**

Third-party integrations that extend system capabilities:
- **Google Workspace OAuth 2.0:** Single sign-on gated strictly to `@bicol-u.edu.ph` institutional accounts. Disabling an account in BU IT immediately severs access to IQArchive.
- **Cloud OCR Provider (Google Cloud Vision API):** High-accuracy cloud text recognition natively aligned with Bicol University's Google ecosystem (with local Tesseract 5.x fallback for offline development).

---

## **Data Flow (How It Works)**

```
1. User logs in via Google SSO (@bicol-u.edu.ph)
        ↓
2. Tier 1 (Frontend) renders their role-scoped dashboard
        ↓
3. Task Force Member uploads an accreditation result PDF (1–3 pages)
        ↓
4. Tier 2 (Backend) saves PDF to private S3 bucket & executes ProcessDocumentOcrService (Tesseract OCR) synchronously (< 3s)
        ↓
5. Tier 3 (Database) stores extracted text + per-word confidence metrics in MySQL JSON columns
        ↓
6. Tier 1 (Frontend) immediately redirects to Split-Screen Canvas (PDF via 15m Pre-Signed URL + OCR Text)
        ↓
7. User verifies, corrects flagged low-confidence words (< 0.65), and submits for Dean review
```

---

## **Why This Architecture?**

| Architectural Choice | Why It Matters |
| :--- | :--- |
| **Monolithic 3-Tier SPA** | Combines the security of server-side RBAC with the fluid UX of a SPA, avoiding API boilerplate for a focused team. |
| **Tesseract OCR Pipeline** | Because OCR is targeted strictly at standardized accreditation results (1–3 pages), inline processing ($< 3$s) eliminates background queue worker infrastructure and failed job monitoring. |
| **Colocated Managed Cloud** | Laravel Cloud Managed MySQL 8 and private S3 storage ensure high availability, automatic point-in-time backups, and zero local disk dependency. |
| **Expiring Pre-Signed URLs** | 15-minute temporary URLs stream binary PDFs directly from cloud storage to desktop browsers, protecting documents and offloading web server memory. |
| **Multi-Tenant College Isolation** | Prevents cross-college data leaks at the query and storage level, complying with RA 10173 (Data Privacy Act of 2012). |
| **Institutional Google Synergy** | Google Workspace SSO and Google Cloud Vision OCR seamlessly integrate with Bicol University's enterprise IT infrastructure. |

---

## **Quick Summary for Panelists**

> IQArchive follows a **modern cloud 3-tier architecture** organized into 5 foundational components: institutional users access the system via desktop browsers → interact with a role-aware Inertia/Vue frontend featuring split-screen OCR preview → supported by an authorized Laravel backend that enforces multi-tenant college isolation and runs synchronous inline Tesseract OCR on accreditation results → backed by colocated managed MySQL and private S3 storage with 15-minute pre-signed URLs → and gated strictly to Bicol University Google Workspace accounts.