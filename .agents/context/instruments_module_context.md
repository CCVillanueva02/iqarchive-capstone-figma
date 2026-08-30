# IQArchive — Module 4: Dynamic Instrument System & Builder Context

> **Document Purpose:** Complete architectural, database, UI, and permission specification for the Accreditation Instrument System in IQArchive.
> **Last Updated:** August 2026
> **Applicable Guidelines:** Follows [.agents/AGENTS.md](file:///c:/Users/janss/Herd/iqarchive/.agents/AGENTS.md) design tokens, 7 finalized roles, Google OAuth 2.0/OIDC auth flow, and strict audit logging.

---

## 1. Executive Summary & Core Objectives

The **Accreditation Instrument System** provides the dynamic benchmark criteria, parameter checklists, and evidence tag requirements needed for both **Program Accreditation** (AACCUP 10 Areas) and **Institutional Accreditation** (AACCUP 9 Areas).

### Key Architectural Pillars:
1. **Dynamic & Non-Hardcoded**:
   - Every area, parameter, criterion, and evidence tag is fully editable and stored dynamically in the database to accommodate annual AACCUP revisions and discipline-specific PSG/CMO variations.
2. **Master-First with Program Customization**:
   - Central baseline standards are maintained as **Master Templates** (`is_template = true`).
   - When customizing for a specific degree program, the master template is deep-cloned into an active custom instrument instance (`is_template = false`, `program_id = ?`).
3. **3 Core Instrument Categories per Scope**:
   - **Supporting Documents**: Benchmark criteria, parameter checklists, and required `#EvidenceTags` that link to uploaded PDFs and evidentiary documents.
   - **Self-Survey**: Numerical ratings (1.00–5.00), diagnostic rubrics, and qualitative remarks.
   - **Compliance Reports**: AACCUP recommendations, compliance monitoring status, and corrective action plans.
4. **Dual Access Model**:
   - **IQA Staff / System Admin**: Manage university-wide master templates, switch between Program & Institutional scopes, and inspect/clone instruments across all colleges.
   - **College Head / Dean**: Full editing capabilities over the instruments of degree programs within their college, both via the Configuration tab and the Stage 4 Accreditation Setup wizard.

---

## 2. Database Schema & Data Models

```
┌─────────────────────────────────────────────────────────────┐
│                         instruments                         │
│  - id                                                       │
│  - name: string (e.g. "Program Supporting Documents (AACCUP)") │
│  - code: string UNIQUE (e.g. "INST-PROG-SUPPORTING-DOCS")   │
│  - level: string (e.g. "Level III")                         │
│  - accreditation_type: enum('program', 'institutional')     │
│  - program_id: unsignedBigInteger NULLABLE FK               │
│  - accreditation_id: unsignedBigInteger NULLABLE FK         │
│  - is_template: boolean (default true)                      │
│  - version: string (default "2026.1")                       │
│  - status: enum('active', 'archived', 'draft')              │
│  - description: text NULLABLE                               │
│  - created_by: unsignedBigInteger FK                        │
└──────────────────────────────┬──────────────────────────────┘
                               │ 1:N
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                      instrument_areas                       │
│  - id                                                       │
│  - instrument_id: unsignedBigInteger FK                     │
│  - code: string (e.g. "Area I")                             │
│  - name: string (e.g. "Vision, Mission, Goals, Objectives") │
│  - order: integer (default 1)                               │
│  - weight: decimal(5,2) (e.g. 15.00)                        │
│  - description: text NULLABLE                               │
└──────────────────────────────┬──────────────────────────────┘
                               │ 1:N
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                    instrument_parameters                    │
│  - id                                                       │
│  - instrument_area_id: unsignedBigInteger FK                │
│  - code: string (e.g. "Parameter A")                        │
│  - name: string (e.g. "Statement of VMGO")                  │
│  - description: text NULLABLE                               │
│  - order: integer (default 1)                               │
│  - weight: decimal(5,2) NULLABLE                            │
└──────────────────────────────┬──────────────────────────────┘
                               │ 1:N
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                     instrument_criteria                     │
│  - id                                                       │
│  - instrument_parameter_id: unsignedBigInteger FK          │
│  - section: enum('systems', 'implementation', 'outcomes',   │
│                  'best_practices')                          │
│  - code: string (e.g. "S.1", "I.2", "O.1", "BP.1")          │
│  - statement: text                                          │
│  - description: text NULLABLE                               │
│  - required_tags: json (e.g. ["#BoardResolution", "#Manual"])│
│  - order: integer (default 1)                               │
└──────────────────────────────┬──────────────────────────────┘
                               │ 1:N
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                    compliance_requirements                  │
│  - id                                                       │
│  - accreditation_id: unsignedBigInteger FK                  │
│  - instrument_criterion_id: unsignedBigInteger FK           │
│  - status: enum('pending', 'verified', 'rejected')          │
│  - notes: text NULLABLE                                     │
└─────────────────────────────────────────────────────────────┘
```

### Deep Cloning Pattern:
The `Instrument::cloneForProgram(Program $program, ?Accreditation $accreditation = null, ?User $actor = null)` Eloquent method performs a database transaction that duplicates:
1. The `Instrument` record with `is_template = false` and `program_id = $program->id`.
2. All child `InstrumentArea` records.
3. All child `InstrumentParameter` records.
4. All child `InstrumentCriterion` records (including mapped `#required_tags` JSON arrays).

---

## 3. User Roles & Permission Matrix

| Role | Central Builder (`/configuration/instruments`) | Stage 4 Setup (`/accreditation/{id}/instrument`) | Master Template Editing | Program Customization Scope |
| :--- | :--- | :--- | :--- | :--- |
| **IQA Staff** | ✅ Full Access | 👁️ Audit View | ✅ Yes | 🌐 University-Wide (All Colleges) |
| **System Administrator** | ✅ Full Access | 👁️ Audit View | ✅ Yes | 🌐 University-Wide (All Colleges) |
| **University Administrator** | 👁️ View & Duplicate | 👁️ View Only | ❌ Read Only | 🌐 University-Wide |
| **College Head / Dean** | ✅ Full Access | ✅ Full Access | 🔒 Clone-only (Creates Program Instance) | 🏛️ Scoped to Assigned College (`$user->college_id`) |
| **Accreditor** | ❌ No Access | ❌ No Access | ❌ No Access | ❌ Evaluator Portal Only |
| **Task Force Member** | ❌ No Access | ❌ No Access | ❌ No Access | 📁 Upload Workspace Only (Module 5) |

---

## 4. UI Components & Directory Structure

### A. Central Instruments Builder (IQA & Deans)
- **Livewire Controller**: [`app/Livewire/Configuration/Instruments.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/Instruments.php)
- **Parent Blade View**: [`resources/views/livewire/configuration/instruments.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/instruments.blade.php)
- **Modular Partials**:
  - `header.blade.php`: Scope toggle (Program vs. Institutional), Program Search/Inspector, Duplicate, and New Template buttons.
  - `stats-bar.blade.php`: 3-Category tab switcher (`supporting-docs`, `self-survey`, `compliance-reports`) with contextual counts.
  - `area-accordion.blade.php`: Left-pane Area I–X accordion with parameter count, weights, and quick modal triggers.
  - `parameter-editor.blade.php`: Right-pane 4-section benchmark editor with `#EvidenceTags` input and criterion CRUD.
  - `modals.blade.php`: Modal assembler containing:
    - `template-modal.blade.php`: Master template create & duplicate to program modal.
    - `area-modal.blade.php`: Area code, name, weight, and order modal.
    - `parameter-modal.blade.php`: Parameter code and name modal.
    - `criterion-modal.blade.php`: 4-section criterion statement and tag editor modal.
    - `delete-modal.blade.php`: Universal confirmation dialog with audit logging.

### B. Stage 4 Accreditation Cycle Customization (Deans)
- **Livewire Controller**: [`app/Livewire/CollegeHead/InstrumentCustomization.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/InstrumentCustomization.php)
- **Parent Blade View**: [`resources/views/livewire/college-head/instrument-customization.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/college-head/instrument-customization.blade.php)
- **Modular Partials**:
  - `header.blade.php`: Cycle progress indicator, Finalize & Unlock Stage 5 button.
  - `areas-tabs.blade.php`: Horizontal Area tabs (Area I through Area X).
  - `parameter-view.blade.php`: Left parameter list with add/edit/delete + right criteria checklist with tag management.
  - `modals.blade.php`: Parameter, criterion, and cycle finalization confirmation modals.

---

## 5. Seed Data & Master Baselines

Seeder: [`database/seeders/AaccupMasterInstrumentSeeder.php`](file:///c:/Users/janss/Herd/iqarchive/database/seeders/AaccupMasterInstrumentSeeder.php)

Seeds exactly 6 clean Master Templates:

### Program Accreditation Templates (`accreditation_type = 'program'`):
1. `INST-PROG-SUPPORTING-DOCS`: Supporting Documents Instrument (Areas I–X, benchmark statements, `#EvidenceTags`).
2. `INST-PROG-SELF-SURVEY`: Self-Survey Evaluation Instrument (Areas I–X diagnostic rubrics & numerical matrices).
3. `INST-PROG-COMPLIANCE-REPORT`: Compliance Monitoring Instrument (Recommendations tracker & corrective actions).

### Institutional Accreditation Templates (`accreditation_type = 'institutional'`):
1. `INST-INST-SUPPORTING-DOCS`: Institutional Supporting Documents (Areas I–IX Governance, QMS, Land Use, Research).
2. `INST-INST-SELF-SURVEY`: Institutional Diagnostic Rubrics (SUC Levelling criteria & ratings).
3. `INST-INST-COMPLIANCE-REPORT`: Institutional Recommendations & CHED Action Tracker.

---

## 6. Integration Points with Module 5 (Next Step)

When an accreditation reaches Stage 4 and the Dean finalizes the instrument via `finalizeInstrument()`:
1. `Accreditation` status is updated from `instrument_building` &rarr; `document_preparation`.
2. All Task Force members receive notifications that the Evidence Repository is unlocked.
3. In **Module 5: Area Workspace & Evidence Uploading**, each uploaded PDF/document is mapped via `AccreditationDocumentLink` to the `ComplianceRequirement` records created from these dynamic criteria and `#EvidenceTags`.

---

## 7. Verification & Test Suite

All feature behaviors are verified under `tests/Feature/InstrumentBuilderTest.php`:
- `test_iqa_staff_can_view_instruments_configuration_page`: Status 200.
- `test_iqa_staff_can_create_master_template`: Database assertion on `instruments`.
- `test_iqa_staff_can_duplicate_master_template`: Deep clone of areas, parameters, criteria.
- `test_iqa_staff_can_add_area_parameter_and_criterion_with_tags`: Verification of JSON tags.
- `test_iqa_staff_can_switch_between_program_and_institutional_scopes`: Scope switcher test.
- `test_iqa_staff_can_inspect_program_and_clone_master_instrument`: Empty state & 1-click clone test.
- `test_iqa_staff_can_duplicate_instrument_to_specific_program`: Target program duplicate test.
- `test_college_head_can_access_configuration_instruments_and_edit_programs_in_college`: Dean college-scoped editing test.
- `test_dean_can_access_instrument_customization_for_college_program`: Stage 4 access test.
- `test_dean_can_add_custom_parameter_and_finalize_to_stage_5`: Status transition to `document_preparation`.

**Current Status:** **70 / 70 tests passing** across the test suite (279 assertions).
