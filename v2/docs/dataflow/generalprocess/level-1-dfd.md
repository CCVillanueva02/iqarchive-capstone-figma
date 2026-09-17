<!--
===================================================================================
IQARCHIVE V2 — LEVEL 1 DATA FLOW SPECIFICATION (GENERAL PROCESS)
===================================================================================
Architectural Layer: Documentation / Architectural Diagrams / Data Flow Engine
Target System: Bicol University Internal Quality Assurance (IQA) Office
Security Context: Multi-Tenant College Isolation, Google SSO OAuth 2.0, RBAC Matrix
Associated Diagram Files:
  - Source XML: v2/docs/dataflow/generalprocess/lvl1-dfd.drawio.xml
  - Vector SVG: v2/docs/dataflow/generalprocess/lvl1-dfd.drawio.svg
  - Standard SVG: v2/docs/dataflow/generalprocess/lvl1-dfd.svg
Parent Catalog: v2/docs/dataflow/iqarchive-data-flows.yaml
===================================================================================
-->

# IQArchive v2 — Level 1 Data Flow Diagram (DFD) Specification

This document provides the architectural specification, process dictionaries, and data flow descriptions for the **Level 1 General Process** diagram of the IQArchive accreditation management platform.

---

## 1. Visual Diagram Representation

- **Vector SVG Diagram:** [`lvl1-dfd.drawio.svg`](file:///c:/Users/janss/Herd/iqarchive/v2/docs/dataflow/generalprocess/lvl1-dfd.drawio.svg) | [`lvl1-dfd.svg`](file:///c:/Users/janss/Herd/iqarchive/v2/docs/dataflow/generalprocess/lvl1-dfd.svg)
- **Source Draw.io XML:** [`lvl1-dfd.drawio.xml`](file:///c:/Users/janss/Herd/iqarchive/v2/docs/dataflow/generalprocess/lvl1-dfd.drawio.xml)

---

## 2. Core Macro Processes (1.0 to 7.0)

The Level 1 diagram orchestrates the entire accreditation lifecycle across 7 primary processes:

| Process ID | Process Name | Responsible Roles / Actors | Primary Data Stores Accessed | Description |
| :---: | :--- | :--- | :--- | :--- |
| **1.0** | **Google SSO Authentication and Scoping** | All Institutional Users, Google Workspace IdP | `D1: User & Roles`, `D4: Accreditations & Stage`, `D7: Regulatory Audit Trail` | Handles OAuth 2.0 code exchange, `@bicol-u.edu.ph` institutional domain gate, JIT user provisioning, multi-tenant college scoping, and Dean Task Force Lead elevation. |
| **2.0** | **Document Submissions, Linking & OCR** | Task Force Members, Tesseract OCR Engine | `D2: Documents & Links`, `D3: Reviews & OCR`, `D6: Notifications`, `D7: Audit Trail`, `D8: Cloud Storage` | Manages evidence upload, SHA-256 deduplication, private S3 storage write, inline synchronous Tesseract OCR token extraction, low-confidence token flagging ($\theta < 0.65$), split-screen validation via 15-minute temporary pre-signed URL, and AACCUP criteria linking. |
| **3.0** | **Document Review & Dean Verification** | College Dean (Tier 1), IQA Staff (Tier 2), Task Force Members | `D2: Documents & Links`, `D3: Reviews & OCR`, `D6: Notifications`, `D7: Audit Trail` | Enforces two-tier approval workflow (College Dean approval $\to$ Central IQA consolidation signoff) with immutable decision logging in `document_reviews`. |
| **4.0** | **Accreditation Pipeline & Stage Governance** | IQA Staff (Pipeline Administrator), University Stakeholders | `D2: Documents & Links`, `D4: Accreditations & Stage`, `D5: Advisory Comments`, `D6: Notifications`, `D7: Audit Trail` | Manages the linear 9-stage state machine from *Draft* to *Accredited*, evaluating automated stage pre-conditions (100% compliant evidence, zero open deficits) and unlocking Stage 8 External Accreditor read-only access. |
| **5.0** | **Quality Assurance & Advisory Review** | Internal Accreditors, Task Force Area Chairs, IQA Staff | `D2: Documents & Links`, `D5: Advisory Comments`, `D6: Notifications`, `D7: Audit Trail`, `D8: Cloud Storage` | Powers pre-submission mock surveys during Stages 5–7, evidence streaming via temporary 15-minute pre-signed URLs, advisory remarks logging into `compliance_comments`, deficit alerts, and resolution sign-offs. |
| **6.0** | **Notification Management** | System Event Dispatcher, All Users | `D6: System Notifications` | Pulls and dispatches in-app alerts for pending reviews, deficit remediation requests, stage transitions, and Dean assignments. |
| **7.0** | **Executive Analytics & Audit Reporting** | BU Executives, System Administrators, IQA Staff | `D1: User & Roles`, `D2: Documents & Links`, `D4: Accreditations & Stage`, `D7: Regulatory Audit Trail` | Aggregates university-wide progress dashboards, cross-college completion matrices, and regulatory audit trail inspection logs. |

---

## 3. Data Store Mapping (D1 to D7 + D8)

| Store ID | Data Store Name | Underpinning Database Tables / Cloud Storage | Purpose |
| :---: | :--- | :--- | :--- |
| **D1** | **User & Roles** | `users`, `roles`, `user_roles`, `colleges`, `programs` | Identity management, RBAC capability assignment, and multi-tenant college scoping boundaries. |
| **D2** | **Documents & Evidence Links** | `documents`, `document_categories`, `accreditation_document_links`, `compliance_requirements` | Master evidence metadata catalog, criteria checklist matrix, and taxonomy links. |
| **D3** | **Reviews & OCR Validation** | `ocr_results`, `document_reviews` | Inline Tesseract OCR bounding boxes, confidence metrics, human text edits, and multi-tier Dean/IQA review verdicts. |
| **D4** | **Accreditations & Stage History** | `accreditations`, `accreditation_stage_histories`, `task_forces`, `task_force_members`, `instruments`, `instrument_areas`, `instrument_parameters`, `instrument_criteria` | State machine progression across the 9 stages, committee rosters, and AACCUP 10-Area survey instrument trees. |
| **D5** | **Advisory Comments & Feedback** | `compliance_comments` | Advisory observations, deficit flags, and mock survey feedback from Internal Accreditors. |
| **D6** | **System Notifications** | `notifications` | In-app user notifications and workflow transition alerts. |
| **D7** | **Regulatory Audit Trail** | `audit_logs` | Append-only immutable log of all mutations, logins, reviews, uploads, and stage shifts. |
| **D8** | **Cloud Object Storage (S3)** | Private S3 Bucket (`evidence/{college_id}/{program_id}/{file_hash}.pdf`) | Encrypted PDF binary evidence blobs streamed strictly via 15-minute temporary pre-signed URLs. |

---

## 4. Associated Decompositions

For the detailed Level 2 decomposition of each core process, consult:
- [Level 2 DFD Specification & Sub-Process Decomposition](file:///c:/Users/janss/Herd/iqarchive/v2/docs/dataflow/generalprocess/level-2-dfd.md)
- [IQArchive Data Flow Master Catalog (YAML)](file:///c:/Users/janss/Herd/iqarchive/v2/docs/dataflow/iqarchive-data-flows.yaml)
