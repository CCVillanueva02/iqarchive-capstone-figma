# IQArchive v2 — Master Relational Database Dictionary

This directory contains the detailed data dictionary specifications for all **22 relational tables** comprising the **IQArchive v2** database schema for Bicol University's AACCUP Accreditation Management System, organized by functional schema zone.

Every table specification adheres strictly to the required schema standard:
```
Field Name | Data Type | Constraint | Description / Relationship
```

---

## Schema Zones & Table Index

### 🔵 [Zone 1: Multi-Tenancy, Identity & Access Control](./zone-1-identity-and-access/)
Foundational tables governing institutional tenancy, user identity, Google Workspace OAuth, role-based authorization, audit logging, and operational alerts.

1. [`colleges`](./zone-1-identity-and-access/colleges.md) — Root multi-tenant boundary representing academic colleges and university units.
2. [`programs`](./zone-1-identity-and-access/programs.md) — Degree-granting academic programs undergoing AACCUP accreditation.
3. [`users`](./zone-1-identity-and-access/users.md) — Institutional faculty, staff, and accreditor accounts authenticated via Google OAuth.
4. [`roles`](./zone-1-identity-and-access/roles.md) — The 7 institutional roles governing access permissions.
5. [`user_roles`](./zone-1-identity-and-access/user_roles.md) — Many-to-many junction binding users to roles (supports Dean dual role).
6. [`audit_logs`](./zone-1-identity-and-access/audit_logs.md) — Immutable, append-only compliance audit trail.
7. [`notifications`](./zone-1-identity-and-access/notifications.md) — In-app operational alerts and task assignments.

---

### 🟢 [Zone 2: AACCUP Survey Instrument Master Hierarchy](./zone-2-instruments-and-criteria/)
Hierarchical evaluation templates, areas, parameters, and benchmark criteria structured according to the official AACCUP survey instrument.

8. [`instruments`](./zone-2-instruments-and-criteria/instruments.md) — Master survey instruments (Undergraduate, Graduate, Institutional).
9. [`instrument_areas`](./zone-2-instruments-and-criteria/instrument_areas.md) — The 10 standard evaluation areas (Areas I through X).
10. [`instrument_parameters`](./zone-2-instruments-and-criteria/instrument_parameters.md) — Sub-sections within an accreditation area (Parameters A, B, etc.).
11. [`instrument_criteria`](./zone-2-instruments-and-criteria/instrument_criteria.md) — Individual benchmarks and evidence requirements.

---

### 🟠 [Zone 3: Accreditation Pipeline & Task Force Management](./zone-3-accreditation-pipeline/)
Accreditation lifecycle management, task force committees, 9-stage progression, compliance tracking, and internal audit notes.

12. [`task_forces`](./zone-3-accreditation-pipeline/task_forces.md) — Program accreditation committee formed per academic cycle.
13. [`task_force_members`](./zone-3-accreditation-pipeline/task_force_members.md) — Faculty assignments to specific AACCUP areas.
14. [`accreditations`](./zone-3-accreditation-pipeline/accreditations.md) — Formal program accreditation survey cycle instances.
15. [`accreditation_stage_histories`](./zone-3-accreditation-pipeline/accreditation_stage_histories.md) — State machine transition audit log for the 9-stage pipeline.
16. [`compliance_requirements`](./zone-3-accreditation-pipeline/compliance_requirements.md) — Compliance checklist item per criterion.
17. [`compliance_comments`](./zone-3-accreditation-pipeline/compliance_comments.md) — Internal accreditor gap analysis and advisory notes.

---

### 🟣 [Zone 4: Evidence Document Storage, Review & OCR Engine](./zone-4-documents-and-ocr/)
Evidence file exhibits, private cloud storage keys, cryptographic SHA-256 hashes, Tesseract OCR text extraction, and multi-tier approval workflows.

18. [`document_categories`](./zone-4-documents-and-ocr/document_categories.md) — Taxonomy classifications (Institutional, College, Program).
19. [`documents`](./zone-4-documents-and-ocr/documents.md) — Master evidence registry with SHA-256 integrity hashes.
20. [`accreditation_document_links`](./zone-4-documents-and-ocr/accreditation_document_links.md) — Many-to-many junction linking evidence files to compliance criteria.
21. [`ocr_results`](./zone-4-documents-and-ocr/ocr_results.md) — Synchronous Tesseract OCR extraction output and confidence metrics.
22. [`document_reviews`](./zone-4-documents-and-ocr/document_reviews.md) — Two-tier review records (Dean endorsement, IQA approval, Internal Accreditor notes).
