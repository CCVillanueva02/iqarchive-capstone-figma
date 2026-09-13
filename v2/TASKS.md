# IQArchive v2 — 8-Week Task Breakdown & Roadmap
**Target Milestone:** Capstone Defense  
**Stack:** Laravel 13 MVC Core · Inertia.js · Vue 3 · Tailwind CSS v4 · OCR Pipeline

---

## Week 1: Foundation Setup & Design System Architecture
- [ ] **1.1 Workspace & Dependencies**
  - [ ] Initialize clean Laravel 13 + Inertia.js + Vue 3 in `v2`.
  - [ ] Configure Vite with `@vitejs/plugin-vue` and `@inertiajs/vue3`.
  - [ ] Install and configure Tailwind CSS v4 with `@theme` design tokens (BU Navy, Brand Orange, Zinc).
  - [ ] Install and configure `shadcn-vue`, `radix-vue`, and `lucide-vue-next` icons.
  - [ ] Install `vue-sonner` (toast notification engine replacing SweetAlert2).
- [ ] **1.2 Core Shell & Global Layouts**
  - [ ] Build `AppLayout.vue` with responsive persistent sidebar and header.
  - [ ] Implement desktop-only viewport guard (`<DesktopOnlyGuard.vue>`) for viewports $< 1024px$.
  - [ ] Build interactive Dev Login role-switcher bar for rapid local role testing without credential friction.
  - [ ] Setup global Inertia shared props middleware (authenticated user, roles, permissions, flash notifications).

---

## Week 2: Normalized Schema, Authentication & RBAC
- [ ] **2.1 Database & Schema Refactoring**
  - [ ] Refactor `task_forces` schema: remove raw JSON `proposed_members` column.
  - [ ] Create normalized `task_force_members` table with status tracking (`proposed`, `approved`, `active`, `archived`) and role designations.
  - [ ] Normalize role-permission matrix and seed standard 7 roles (System Admin, IQA Staff, College Dean, Program Chair, Task Force, Accreditor, Executive).
- [ ] **2.2 Authentication & Security**
  - [ ] Configure Google Workspace OAuth 2.0 (`@bicol-u.edu.ph` institutional domain gate).
  - [ ] Implement session-based role switching for multi-role faculty.
  - [ ] Integrate Sonner toast alerts with Laravel flash session events.

---

## Week 3: Document Workspace & Repository
- [ ] **3.1 Architectural Route Separation**
  - [ ] Decouple monolithic workspace into 3 dedicated controllers & pages:
    - [ ] `/documents/common` — University-wide institutional policies, syllabi, memos.
    - [ ] `/documents/program` — 126 programs $\times$ 7 colleges $\times$ 10 AACCUP areas.
    - [ ] `/documents/institutional` — Institutional self-survey and compliance reports.
- [ ] **3.2 Filtering & Document Interactions**
  - [ ] Build multi-filter toolbar (College, Program, Accreditation Stage, Status).
  - [ ] Implement slide-over `<DetailDrawer.vue>` using shadcn `<Sheet>` for inspecting document metadata, versions, and criteria links.
  - [ ] Build drag-and-drop batch file uploader (5–20 files) with client-side mime/size validation and upload progress bars.

---

## Week 4: Task Force & 9-Stage Accreditation Pipeline
- [ ] **4.1 Task Force Management**
  - [ ] Build `<TaskForceManagement.vue>` with cascading selectors (College $\rightarrow$ Program $\rightarrow$ Members).
  - [ ] Implement multi-select member assignment modal with role designations (Chair, Member, Document Custodian).
  - [ ] Implement Dean proposal $\rightarrow$ IQA verification approval workflow.
- [ ] **4.2 9-Stage Accreditation Pipeline**
  - [ ] Build interactive 9-stage progress indicator with status badges per program.
  - [ ] Implement stage-gated validation (e.g. Stage 3 to 4 requires Dean sign-off).
  - [ ] Build Accreditation Visits scheduling modal with date-conflict checks.

---

## Week 5: AACCUP Instrument Builder & Dean QC Verification
- [ ] **5.1 Instrument Builder**
  - [ ] Build hierarchical Instrument Tree Editor: Area $\rightarrow$ Criterion $\rightarrow$ Parameter $\rightarrow$ Sub-parameter.
  - [ ] Implement parameter weighting and benchmark score definitions.
- [ ] **5.2 Dean Quality Review Workspace**
  - [ ] Build 4-section evaluation matrix: Systems, Implementation, Outcomes, Best Practices.
  - [ ] Implement inline document flagging for revisions with remarks.
  - [ ] Build formal Dean QC digital sign-off dialog with audit log piping.

---

## Week 6: OCR Document Verification Pipeline
- [ ] **6.1 Asynchronous Backend Pipeline**
  - [ ] Create `document_ocr_results` table (`document_id`, `status`, `extracted_scores`, `confidence_score`).
  - [ ] Implement queued background job (`ProcessDocumentOcrJob`) interfacing with OCR engine (Tesseract local / Google Cloud Vision).
- [ ] **6.2 Human-in-the-Loop Verification Workspace**
  - [ ] Build `<OcrVerification.vue>` split-screen viewer:
    - [ ] Left pane: High-resolution PDF/image viewer with zoom/pan controls.
    - [ ] Right pane: Reactive editable form fields mapped via `v-model`.
  - [ ] Implement one-click "Confirm & Bind" to map verified OCR scores directly into the AACCUP instrument ratings.

---

## Week 7: Executive Analytics & Quality Assurance
- [ ] **7.1 Analytics Dashboard**
  - [ ] Build BU Executive Dashboard with accreditation rate cards, college comparison charts, and pipeline bottleneck indicators.
  - [ ] Build IQA Staff Audit Trail viewer with filterable event logs and actor tracking.
- [ ] **7.2 Testing & Quality Assurance**
  - [ ] Write Pest feature tests for stage transitions, document permissions, and OCR job dispatching.
  - [ ] Write Playwright end-to-end browser tests verifying primary user flows.

---

## Week 8: Defense Rehearsal & Presentation Polish
- [ ] **8.1 Demonstration Seeding**
  - [ ] Seed comprehensive database: all 126 programs across 7 colleges, diverse accreditation levels, and sample OCR-processed rating sheets.
- [ ] **8.2 Defense Packaging**
  - [ ] Prepare offline demo backup database and local storage fallback.
  - [ ] Create step-by-step role-based demonstration script for the panel presentation.
  - [ ] Dry-run defense walkthrough ensuring $< 15$ minute end-to-end flow.
