# IQArchive — Accreditation Preparation & Management Implementation Plan

> **Status Overview & Roadmap Tracker**
> **Last Updated:** August 2026
> **Architecture Compliance:** Follows [.agents/AGENTS.md](file:///c:/Users/janss/Herd/iqarchive/.agents/AGENTS.md) design tokens, 7 finalized roles, Google OAuth 2.0/OIDC auth flow, M:N document links, and strict audit logging.

---

## Progress Summary

| Phase / Module | Lead Actor | Status | Key Artifacts |
| :--- | :--- | :--- | :--- |
| **1. Accreditation Initiation & Monitoring** | IQA Staff | ✅ **Completed** | [Accreditation.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/Accreditation.php), [VisitsIndex.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/VisitsIndex.php), [ScheduleAccreditation.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Monitoring/ScheduleAccreditation.php), [MonitoringOverview.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Monitoring/MonitoringOverview.php) |
| **2. Task Force Nomination** | College Dean | ✅ **Completed** | [TaskForceSetup.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/TaskForceSetup.php), [task-force-setup.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/college-head/task-force-setup.blade.php) |
| **3. Task Force Official Assignment & Activation** | IQA & Dean | ✅ **Completed** | 1-Click Member Pre-registration & Reactivation, Dean Auto-Lead Assignment |
| **4. Dynamic Instrument Builder & Customization** | Dean / IQA | ✅ **Completed** | [Instruments.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/Instruments.php), [InstrumentCustomization.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/InstrumentCustomization.php), [Instrument.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/Instrument.php), [InstrumentArea.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/InstrumentArea.php), [InstrumentParameter.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/InstrumentParameter.php), [InstrumentCriterion.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/InstrumentCriterion.php) |
| **5. Area Workspace & Evidence Uploading** | Task Force & Lead | ⏳ **Upcoming (Next Priority)** | Area I–X Folders, Batch File Uploader, Metadata & Tagging, Document Reuse |
| **6. Dean Verification & Compliance Locking** | College Dean | ⏳ **Upcoming** | Completeness Verification, Rework Feedback, Pre-evaluation Seal |
| **7. Accreditation Submission & Accreditor Evaluation** | IQA & Accreditors | ⏳ **Upcoming** | Submission Handover, Lockouts, Accreditor Scoring Portal |

---

## Detailed Roadmap & Module Breakdown

### Module 1: Accreditation Initiation & Monitoring (IQA Module) — ✅ COMPLETED
**Goal:** Allow the IQA Office to schedule and monitor accreditation visits across colleges and academic programs.
- **Database & Models:**
  - Created [Accreditation.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/Accreditation.php) with migration `accreditations` tracking statuses (`scheduled`, `task_force_setup`, `task_force_approved`, `instrument_building`, `document_preparation`, `uploading`, `dean_verification`, `submitted`, `completed`, `cancelled`).
  - Linked to `programs`, `task_forces`, and `users` (`created_by`).
- **Livewire Components & Views:**
  - [ScheduleAccreditation.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php): Modal dialog to select program, assign target visit date, initialize task force container, and emit notification to the relevant Dean.
  - [VisitsIndex.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/VisitsIndex.php): Unified accreditation visits registry with KPI cards, multi-stage timeline modal ([timeline-modal.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/accreditation/partials/timeline-modal.blade.php)), filtering, and visit cancellation workflow.
  - [MonitoringOverview.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Monitoring/MonitoringOverview.php): High-level executive monitoring dashboard, institutional level distributions, college-level summaries, and program master directory.
- **Security & Audit:**
  - Role check restricted to `iqa-staff`, `iqa-admin`, `system-administrator`.
  - Cancellation writes to [AuditLog.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/AuditLog.php) and dispatches in-app cancellation notification to College Dean.

---

### Module 2: Notification & Task Force Nomination (Dean Module) — ✅ COMPLETED
**Goal:** Notify the College Dean of scheduled visits and allow structured faculty nomination for the program task force.
- **Backend & Notifications:**
  - Automated in-app notification sent to the College Head/Dean when an accreditation is scheduled.
- **UI & Workflows:**
  - [TaskForceSetup.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/TaskForceSetup.php) embedded in Dean Dashboard ([dashboard.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/roles/college-head/dashboard.blade.php)).
  - Dynamic faculty proposal form (name, institutional email, contact number).
  - Submits proposal payload directly into `accreditations.proposed_members` and advances status to `task_force_setup`.
- **Security & Audit:**
  - Query scope restricted to Dean's assigned college (`$user->college_id`).
  - Submissions logged in [AuditLog.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/AuditLog.php).

---

### Module 3: Task Force Official Assignment & Activation (IQA & Dean) — ✅ COMPLETED
**Goal:** Formalize the Task Force roster, auto-assign the Dean as Task Force Lead, and activate membership permissions with 1-click batch pre-registration.
- **Backend & Workflows:**
  - **1-Click Pre-Listing & Reactivation:** In [TaskForceOverview.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/TaskForce/TaskForceOverview.php), IQA approves nominations by automatically pre-listing unlisted emails as `pending_activation` (Google OAuth compliant) and reactivating previously deactivated accounts (`status = 'active'`).
  - **Enforce Lead Assignment:** Automatically assigns the College Dean as `lead` in `task_force_members`.
  - **Accreditation Progression:** Advances linked `Accreditation` status to `task_force_approved`.
  - **Audit Trail & Notifications:** Automated alerts to Dean and faculty members with complete `AuditLog` logging.
- **Modular Views:**
  - Spliced [task-force-overview.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/task-force-overview.blade.php) into clean partials: [header.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/partials/header.blade.php), [stats-row.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/partials/stats-row.blade.php), [filter-toolbar.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/partials/filter-toolbar.blade.php), [task-force-cards.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/partials/task-force-cards.blade.php), [create-modal.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/partials/create-modal.blade.php), and [roster-modal.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/partials/roster-modal.blade.php).

---

### Module 4: Dynamic Instrument Builder & Customization (Dean / IQA Module) — ✅ COMPLETED
**Goal:** Provide an interactive UI for tailoring AACCUP accreditation instruments to program-specific parameters and required document tags, with full Master-first inspection and Dean editing capabilities.
- **Detailed Specification:** See [instruments_module_context.md](file:///c:/Users/janss/Herd/iqarchive/context/instruments_module_context.md).
- **Database & Architecture:**
  - Enhanced [Instrument.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/Instrument.php), [InstrumentArea.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/InstrumentArea.php), created [InstrumentParameter.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/InstrumentParameter.php), [InstrumentCriterion.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/InstrumentCriterion.php), and linked to [ComplianceRequirement.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/ComplianceRequirement.php).
  - Implemented `cloneForProgram(Program $program, ?Accreditation $accreditation = null, ?User $actor = null)`: deep clones master template hierarchy into program instance.
  - Seeded 6 clean Master Templates (3 Program [10 Areas] & 3 Institutional [9 Areas]) via [AaccupMasterInstrumentSeeder.php](file:///c:/Users/janss/Herd/iqarchive/database/seeders/AaccupMasterInstrumentSeeder.php).
- **IQA Staff Experience (Configuration Tab &rarr; Instruments):**
  - Built [Instruments.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/Instruments.php) with Scope Separator (Program vs. Institutional) and 3 Categories (**Supporting Documents**, **Self-Survey**, **Compliance Reports**).
  - Master-First inspection pattern: Inspect any degree program with an intuitive empty state and 1-click **[ 📋 Clone Master Instrument for this Program ]** action.
  - Duplicate Modal with targeted **"Duplicate for Program"** selector.
  - Spliced into modular partials: [header.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/partials/instruments/header.blade.php), [stats-bar.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/partials/instruments/stats-bar.blade.php), [area-accordion.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/partials/instruments/area-accordion.blade.php), [parameter-editor.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/partials/instruments/parameter-editor.blade.php), and [modals.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/partials/instruments/modals.blade.php).
- **Dean Experience (Configuration Access & Stage 4 Customization):**
  - Activated Configuration &rarr; Instruments link in [sidebar.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/layouts/app/sidebar.blade.php) for `college-head` with automated college scoping (`$user->college_id`).
  - Full CRUD authority over areas, parameters, criteria statements, and `#EvidenceTags` for their college's programs.
  - Built [InstrumentCustomization.php](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/InstrumentCustomization.php) for Dean active cycle tailoring, with instant edit/delete on parameters and criteria cards.
  - Finalizing instrument advances accreditation status to `document_preparation` and notifies Task Force members.
- **Automated Tests:**
  - Verified via [InstrumentBuilderTest.php](file:///c:/Users/janss/Herd/iqarchive/tests/Feature/InstrumentBuilderTest.php) (9/9 tests passing; 70/70 passing across full repository).

---

### Module 5: Document Upload & Evidence Repository (Task Force Module) — ⏳ UPCOMING (NEXT PRIORITY)
**Goal:** Secure, structured document repository matching the customized instrument for Task Force members to upload evidence.
- **Security & Access Control:**
  - Laravel Policies guaranteeing that *only* assigned Task Force members can view/upload evidence to their assigned program repository.
  - Upload access strictly active while accreditation status is `document_preparation` or `uploading`.
- **UI & Functionality:**
  - Dedicated Area-by-Area tabbed workspace inside [documents/index.blade.php](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/index.blade.php).
  - Multi-file drag-and-drop uploader with parameter tagging and metadata input.
  - Linkage via [AccreditationDocumentLink.php](file:///c:/Users/janss/Herd/iqarchive/app/Models/AccreditationDocumentLink.php) (M:N relationship allowing single evidence to satisfy multiple criteria).

---

### Module 6: Two-Stage Dean Verification & Quality Control — ⏳ UPCOMING
**Goal:** Provide the College Dean with a rigorous two-tier review pipeline prior to official university handover.
- **Stage 1 (Error & Quality Review):**
  - Dean reviews uploaded artifacts, document clarity, and tag correctness.
  - Dean can flag specific documents for revision with inline comments; flagged items notify the responsible Task Force member.
- **Stage 2 (Completeness & Readiness Audit):**
  - System audits 100% parameter coverage against the active Instrument requirements.
  - Visual completion tracker (e.g. 10/10 areas completed, 45/45 parameters evidenced).
  - Formal digital sign-off by the Dean to lock TF uploads.

---

### Module 7: Accreditation Handover & Accreditor Evaluation — ⏳ UPCOMING
**Goal:** Lock final preparation, submit to IQA Office, and provide external accreditors with a streamlined evaluation portal.
- **Submission Handover:**
  - Dean triggers "Submit to IQA" action.
  - Accreditation status updates to `submitted` / `completed`.
  - Repository enters read-only freeze state for Task Force members.
- **Accreditor Evaluation Portal:**
  - Accreditors log in via Google OAuth into clean, focused review interface ([roles/accreditor/submission](file:///c:/Users/janss/Herd/iqarchive/routes/web.php)).
  - Benchmark score sheets, area ratings, and recommendation notes generation.
  - IQA Office generates the final accreditation summary report.

---

## Next Immediate Steps

1. **Module 5: Evidence Repository & Uploader Integration:**
   - Link customized instrument criteria and `#Tags` directly into the Area I–X upload workspace.
   - Implement multi-file drag-and-drop uploader attaching files via `AccreditationDocumentLink` to `ComplianceRequirement`.


