# Graph Report - iqarchive  (2026-09-18)

## Corpus Check
- 28 files · ~172,252 words
- Verdict: corpus is large enough that graph structure adds value.
- Unclassified: 12 file(s) not represented in the graph (top: .xml 10, (none) 2)

## Summary
- 116 nodes · 299 edges · 9 communities
- Extraction: 91% EXTRACTED · 9% INFERRED · 0% AMBIGUOUS · INFERRED: 26 edges (avg confidence: 0.93)
- Token cost: 12,500 input · 3,400 output

## Community Hubs (Navigation)
- Database Schema & Tables
- Accreditation Stages & Roles
- Macro Processes & Data Stores
- QA Advisory & Mock Evaluation
- System Architecture & Tiers
- Document Submission & OCR
- Notification Management & Dispatch
- SSO Authentication & Scoping
- Executive Analytics & Auditing

## God Nodes (most connected - your core abstractions)
1. `IQArchive v2 — Level 2 Data Flow Diagrams Specification` - 41 edges
2. `IQArchive v2 — Database Design & System Workflows` - 25 edges
3. `IQArchive Database Schema Explained` - 25 edges
4. `IQArchive Entity-Relationship Diagram (ERD) — IQArchive-ERD.drawio.svg` - 24 edges
5. `IQArchive Entity-Relationship Diagram (ERD) — IQArchive-ERD.svg` - 24 edges
6. `IQArchive v2 — Level 1 Data Flow Diagram Specification` - 19 edges
7. `Process 2.0: Document Submission, Linking & OCR Processing` - 18 edges
8. `Process 4.0: Accreditation Pipeline & Task Force Management` - 17 edges
9. `Level 1 Data Flow Diagram (DFD) — lvl1-dfd.drawio.svg` - 16 edges
10. `Level 1 Data Flow Diagram (DFD) — lvl1-dfd.svg` - 16 edges

## Surprising Connections (you probably didn't know these)
- `Level 2 DFD — Sub-Process 1.0: Google SSO Authentication & Scoping — lvl2-proc1-auth-scoping.svg` --conceptually_related_to--> `IQArchive v2 — Level 2 Data Flow Diagrams Specification`  [EXTRACTED]
  v2/docs/dataflow/subprocess/lvl2-proc1-auth-scoping.svg → v2/docs/dataflow/generalprocess/level-2-dfd.md
- `Level 2 DFD — Sub-Process 1.0: Google SSO Authentication & Scoping — lvl2-proc1-auth-scoping.drawio.svg` --conceptually_related_to--> `IQArchive v2 — Level 2 Data Flow Diagrams Specification`  [EXTRACTED]
  v2/docs/dataflow/subprocess/lvl2-proc1-auth-scoping.drawio.svg → v2/docs/dataflow/generalprocess/level-2-dfd.md
- `Level 2 DFD — Sub-Process 2.0: Document Submissions, Linking & OCR — lvl2-proc2-document-submission-ocr.svg` --conceptually_related_to--> `IQArchive v2 — Level 2 Data Flow Diagrams Specification`  [EXTRACTED]
  v2/docs/dataflow/subprocess/lvl2-proc2-document-submission-ocr.svg → v2/docs/dataflow/generalprocess/level-2-dfd.md
- `Level 2 DFD — Sub-Process 2.0: Document Submissions, Linking & OCR — lvl2-proc2-document-submission-ocr.drawio.svg` --conceptually_related_to--> `IQArchive v2 — Level 2 Data Flow Diagrams Specification`  [EXTRACTED]
  v2/docs/dataflow/subprocess/lvl2-proc2-document-submission-ocr.drawio.svg → v2/docs/dataflow/generalprocess/level-2-dfd.md
- `Level 2 DFD — Sub-Process 3.0: Document Review & Dean Verification — lvl2-proc3-document-review-verification.svg` --conceptually_related_to--> `IQArchive v2 — Level 2 Data Flow Diagrams Specification`  [EXTRACTED]
  v2/docs/dataflow/subprocess/lvl2-proc3-document-review-verification.svg → v2/docs/dataflow/generalprocess/level-2-dfd.md

## Hyperedges (group relationships)
- **7 Institutional Accreditation Roles** — v2_docs_rbac_roles_system_administrator, v2_docs_rbac_roles_iqa_staff, v2_docs_rbac_roles_college_dean, v2_docs_rbac_roles_task_force_member, v2_docs_rbac_roles_internal_accreditor, v2_docs_rbac_roles_bu_executive, v2_docs_rbac_roles_external_accreditor [EXTRACTED 1.00]
- **9 AACCUP Accreditation Pipeline Stages** — v2_docs_accre_pipeline_accreditation_stages_stage_1_preparation, v2_docs_accre_pipeline_accreditation_stages_stage_2_evidence_gathering, v2_docs_accre_pipeline_accreditation_stages_stage_3_dean_endorsement, v2_docs_accre_pipeline_accreditation_stages_stage_4_iqa_initial_review, v2_docs_accre_pipeline_accreditation_stages_stage_5_internal_accreditation, v2_docs_accre_pipeline_accreditation_stages_stage_6_revision_compliance, v2_docs_accre_pipeline_accreditation_stages_stage_7_formal_submission, v2_docs_accre_pipeline_accreditation_stages_stage_8_external_survey, v2_docs_accre_pipeline_accreditation_stages_stage_9_post_survey_monitoring [EXTRACTED 1.00]
- **3-Tier System Architecture + External Services** — v2_docs_system_architecture_system_architecture_workstation_browser, v2_docs_system_architecture_system_architecture_tier_1_frontend_spa, v2_docs_system_architecture_system_architecture_tier_2_backend_core, v2_docs_system_architecture_system_architecture_tier_3_database_storage, v2_docs_system_architecture_system_architecture_external_services_layer [EXTRACTED 1.00]
- **Level 1 DFD Macro Processes (1.0 - 7.0)** — v2_docs_dataflow_generalprocess_level_1_dfd_proc_1_0_sso_scoping, v2_docs_dataflow_generalprocess_level_1_dfd_proc_2_0_document_ocr, v2_docs_dataflow_generalprocess_level_1_dfd_proc_3_0_review_verification, v2_docs_dataflow_generalprocess_level_1_dfd_proc_4_0_accreditation_pipeline, v2_docs_dataflow_generalprocess_level_1_dfd_proc_5_0_qa_advisory_review, v2_docs_dataflow_generalprocess_level_1_dfd_proc_6_0_notification_dispatch, v2_docs_dataflow_generalprocess_level_1_dfd_proc_7_0_executive_analytics [EXTRACTED 1.00]
- **Level 1 DFD Data Stores (D1 - D8)** — v2_docs_dataflow_generalprocess_level_1_dfd_store_d1_users_roles, v2_docs_dataflow_generalprocess_level_1_dfd_store_d2_documents_metadata, v2_docs_dataflow_generalprocess_level_1_dfd_store_d3_cloud_storage, v2_docs_dataflow_generalprocess_level_1_dfd_store_d4_ocr_results, v2_docs_dataflow_generalprocess_level_1_dfd_store_d5_aaccup_instruments, v2_docs_dataflow_generalprocess_level_1_dfd_store_d6_accreditation_pipeline, v2_docs_dataflow_generalprocess_level_1_dfd_store_d7_advisory_feedback, v2_docs_dataflow_generalprocess_level_1_dfd_store_d8_audit_logs [EXTRACTED 1.00]
- **22 Normalized Database Schema Tables** — v2_docs_db_design_database_design_colleges, v2_docs_db_design_database_design_programs, v2_docs_db_design_database_design_users, v2_docs_db_design_database_design_roles, v2_docs_db_design_database_design_user_roles, v2_docs_db_design_database_design_audit_logs, v2_docs_db_design_database_design_notifications, v2_docs_db_design_database_design_instruments, v2_docs_db_design_database_design_instrument_areas, v2_docs_db_design_database_design_instrument_parameters, v2_docs_db_design_database_design_instrument_criteria, v2_docs_db_design_database_design_task_forces, v2_docs_db_design_database_design_task_force_members, v2_docs_db_design_database_design_accreditations, v2_docs_db_design_database_design_accreditation_stage_histories, v2_docs_db_design_database_design_compliance_requirements, v2_docs_db_design_database_design_compliance_comments, v2_docs_db_design_database_design_document_categories, v2_docs_db_design_database_design_documents, v2_docs_db_design_database_design_accreditation_document_links, v2_docs_db_design_database_design_ocr_results, v2_docs_db_design_database_design_document_reviews [EXTRACTED 1.00]

## Communities (9 total, 0 thin omitted)

### Community 0 - "Database Schema & Tables"
Cohesion: 0.29
Nodes (26): Table: accreditation_document_links, Table: accreditation_stage_histories, Table: accreditations, Table: audit_logs, Table: colleges, Table: compliance_comments, Table: compliance_requirements, IQArchive v2 — Database Design & System Workflows (+18 more)

### Community 1 - "Accreditation Stages & Roles"
Cohesion: 0.12
Nodes (18): Document Upload Approval Chain, Accreditation Stages & Approval Pipeline, IQA Exclusive Stage Transition Authority, Stage 1: Preparation & Application, Stage 2: Self-Survey & Document Consolidation, Stage 3: Dean Review & Endorsement, Stage 4: IQA Preliminary Evaluation, Stage 6: Revision & Action Plan Execution (+10 more)

### Community 2 - "Macro Processes & Data Stores"
Cohesion: 0.26
Nodes (17): IQArchive v2 — Level 1 Data Flow Diagram Specification, Process 3.0: Document Review, Verification & Approval, Data Store D1: Users & RBAC Store, Data Store D2: Documents & Metadata Store, Data Store D3: Private S3 Cloud Storage, Data Store D4: OCR Processing Store, Data Store D5: AACCUP Instruments & Criteria Store, Data Store D6: Accreditation Pipeline & Task Force Store (+9 more)

### Community 3 - "QA Advisory & Mock Evaluation"
Cohesion: 0.15
Nodes (14): Stage 5: Mock Accreditation & Advisory Review, Process 5.0: QA Advisory Review & Mock Evaluation, Sub-Process 5.1: Internal Accreditor Rehearsal Review, Sub-Process 5.2: Submit Advisory Comments & Feedback, Sub-Process 5.3: Task Force Remediation Tracking, Level 2 DFD — Sub-Process 5.0: QA Advisory Review & Mock Evaluation — lvl2-proc5-qa-advisory-review.svg, Level 2 DFD — Sub-Process 5.0: QA Advisory Review & Mock Evaluation — lvl2-proc5-qa-advisory-review.drawio.svg, College Dean (+6 more)

### Community 4 - "System Architecture & Tiers"
Cohesion: 0.45
Nodes (11): IQArchive v2 System Architecture Diagram — architecture-diagram.svg, IQArchive v2 — System Architecture Explained, IQArchive v2 — System Architecture Specification, External Services Layer, MobileUnsupported Desktop-Only Guard Policy, Dual-Driver OCR Engine Adapter, 15-Minute Temporary Signed S3 URL Policy, Tier 1: Frontend SPA (Inertia.js + Vue 3) (+3 more)

### Community 5 - "Document Submission & OCR"
Cohesion: 0.25
Nodes (8): Process 2.0: Document Submission, Linking & OCR Processing, Sub-Process 2.1: Ingest Evidence Metadata & Upload File, Sub-Process 2.2: Stream File to S3 Object Storage, Sub-Process 2.3: Execute Synchronous OCR Extraction, Sub-Process 2.4: Human-in-the-Loop OCR Validation, Sub-Process 2.5: Map Document to AACCUP Criteria, Level 2 DFD — Sub-Process 2.0: Document Submissions, Linking & OCR — lvl2-proc2-document-submission-ocr.svg, Level 2 DFD — Sub-Process 2.0: Document Submissions, Linking & OCR — lvl2-proc2-document-submission-ocr.drawio.svg

### Community 6 - "Notification Management & Dispatch"
Cohesion: 0.39
Nodes (8): Process 6.0: Notification Management & Dispatch, IQArchive v2 — Level 2 Data Flow Diagrams Specification, Sub-Process 6.1: Intercept System Domain Events, Sub-Process 6.2: Format Notification Messages, Sub-Process 6.3: Dispatch In-App & Email Alerts, IQArchive v2 — Hierarchical Data Flow Catalog YAML, Level 2 DFD — Sub-Process 6.0: Notification Management & Dispatch — lvl2-proc6-notification-management.svg, Level 2 DFD — Sub-Process 6.0: Notification Management & Dispatch — lvl2-proc6-notification-management.drawio.svg

### Community 7 - "SSO Authentication & Scoping"
Cohesion: 0.29
Nodes (7): Process 1.0: Google SSO Authentication & Multi-Tenancy Scoping, Sub-Process 1.1: Initiate Google OAuth Handshake, Sub-Process 1.2: Validate BU Account & Token Exchange, Sub-Process 1.3: Resolve User Identity & RBAC Roles, Sub-Process 1.4: Enforce College Multi-Tenancy Boundary, Level 2 DFD — Sub-Process 1.0: Google SSO Authentication & Scoping — lvl2-proc1-auth-scoping.svg, Level 2 DFD — Sub-Process 1.0: Google SSO Authentication & Scoping — lvl2-proc1-auth-scoping.drawio.svg

### Community 8 - "Executive Analytics & Auditing"
Cohesion: 0.29
Nodes (7): Process 7.0: Executive Macro Analytics & Audit Logging, Sub-Process 7.1: Aggregate Macro Analytics & Completion Metrics, Sub-Process 7.2: Generate Compliance & Audit Trail Reports, Sub-Process 7.3: Executive Dashboard Visualization, Level 2 DFD — Sub-Process 7.0: Executive Analytics & Compliance Audit — lvl2-proc7-executive-analytics-audit.svg, Level 2 DFD — Sub-Process 7.0: Executive Analytics & Compliance Audit — lvl2-proc7-executive-analytics-audit.drawio.svg, BU Executive

## Knowledge Gaps
- **4 isolated node(s):** `Stage 1: Preparation & Application`, `Stage 6: Revision & Action Plan Execution`, `Stage 9: Post-Survey & Continuous Compliance`, `Dual-Driver OCR Engine Adapter`
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 7 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `IQArchive v2 — Level 2 Data Flow Diagrams Specification` connect `Notification Management & Dispatch` to `Accreditation Stages & Roles`, `Macro Processes & Data Stores`, `QA Advisory & Mock Evaluation`, `Document Submission & OCR`, `SSO Authentication & Scoping`, `Executive Analytics & Auditing`?**
  _High betweenness centrality (0.237) - this node is a cross-community bridge._
- **Why does `Process 4.0: Accreditation Pipeline & Task Force Management` connect `Accreditation Stages & Roles` to `Database Schema & Tables`, `Macro Processes & Data Stores`, `QA Advisory & Mock Evaluation`?**
  _High betweenness centrality (0.154) - this node is a cross-community bridge._
- **Why does `Process 2.0: Document Submission, Linking & OCR Processing` connect `Document Submission & OCR` to `Database Schema & Tables`, `Accreditation Stages & Roles`, `Macro Processes & Data Stores`, `QA Advisory & Mock Evaluation`?**
  _High betweenness centrality (0.127) - this node is a cross-community bridge._
- **What connects `Stage 1: Preparation & Application`, `Stage 6: Revision & Action Plan Execution`, `Stage 9: Post-Survey & Continuous Compliance` to the rest of the system?**
  _4 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Accreditation Stages & Roles` be split into smaller, more focused modules?**
  _Cohesion score 0.12418300653594772 - nodes in this community are weakly interconnected._