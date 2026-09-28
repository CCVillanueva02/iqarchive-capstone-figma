# Program Accreditation Documents — Task Plan & Implementation Log

## Plan
- High-level goal: Implement the complete 3-tier Program Accreditation module under Documents for IQA Staff / Members (Desktop-only ≥1024px), featuring College Selection (17 BU Colleges), Degree Programs Selection, and 5 Accreditation Document Types (Supporting Documents, Self-Survey, Compliance Reports, PPP for Levels 1–2, Narrative Profile for Levels 3–4) with file uploads and evidence linking.
- Scope:
  - **In Scope**:
    - Role focus: Strictly IQA Staff / Member (and System Administrator) workflows.
    - Level 1: 17 BU Academic Colleges card grid with search, logos, and campus tags.
    - Level 2: Degree Programs grid for selected college with level badges, instrument status, search, and "+ Add New Program" modal for IQA.
    - Level 3: Document Type Hub displaying 5 document types dynamically adapted to the program's accreditation level (Candidate, Level 1, Level 2, Level 3, Level 4).
    - Level 4: Workspaces for:
      - 1. Supporting Documents (Areas I–X, Parameters A–C, Criteria S/I/O/BP, file uploads & evidence linking).
      - 2. Self-Survey Matrix (Spreadsheet rating rows, system/implementation/outcome/parameter/area automated mean calculations, best practices, sign-off).
      - 3. Compliance Reports (Official compliance records, action reports, certificates).
      - 4. Program Performance Profile (PPP) (for Levels 1 & 2).
      - 5. Narrative Profile (for Levels 3 & 4).
    - Backend: Migration to enrich `colleges` with `campus` and `logo_image`, seeders for 17 Colleges, Degree Programs, and AACCUP Master Instrument (10 areas, parameters, criteria), `ProgramAccreditationController`, `ProgramAccreditationService`, and authorization policies.
    - Frontend: Vue 3 Inertia SPA in `resources/js/Pages/Documents/Program-Accreditation/` adhering strictly to DaisyUI and modular file size limits (< 150–200 lines per component).
    - Testing: Feature tests in `tests/Feature/ProgramAccreditationTest.php` covering college listing, program scoping, document category resolution by level, file uploads, and IQA access.
  - **Out of Scope (for now)**:
    - Task Force Member and College Dean scoped locked views (explicitly deferred by user: "specifically for the IQA for now, don't bother with the other roles yet").
    - External accreditor evaluation rating forms.

- Key decisions:
  - Multi-tenancy & Security: Multi-tenant scoping and explicit policy checks (`DocumentPolicy` / `ProgramPolicy`) on every endpoint.
  - Navigation routing: Seamless query state (`/documents?tab=program-accreditation&college_id=...&program_id=...&category=...`) preserving Inertia SPA state without full reloads, matching the existing `navigation.js`.
  - Component Architecture: Strict sub-component extraction to satisfy the 150–200 line cap rule.
  - UI Standard: DaisyUI components (`btn`, `card`, `badge`, `modal`, `tabs`, `table`, `input`, `select`) styled with `DESIGN.md` tokens (Navy `#0B1B3D`, BU Blue `#0038A8`, BU Orange `#F26522`).

- Phases:
  - **Phase 1: Foundation & Data Layer** — Migration for college logo/campus, seed 17 BU colleges, degree programs, and AACCUP Master Instrument (10 Areas, Parameters, Benchmarks).
  - **Phase 2: Backend Controller & Service** — `ProgramAccreditationController` & `ProgramAccreditationService` handling college listing, program resolution, document category filtering by level, and document uploads.
  - **Phase 3: Frontend Core Shell & Navigation** — `Index.vue`, `CollegeGrid.vue`, `ProgramGrid.vue`, breadcrumb hierarchy, and "+ Add New Program" modal.
  - **Phase 4: Document Type Hub & Category Workspaces** — `DocumentTypeHub.vue`, `SupportingDocsView.vue`, `SelfSurveyView.vue`, `ComplianceReportsView.vue`, and `ProfileDocumentsView.vue` (PPP & Narrative Profile).
  - **Phase 5: Testing, Build & Visual Verification** — Feature tests with PHPUnit/Pest, Vite build verification, and Playwright screenshots.

## Implementation Progress
### [2026-09-25 — Planning & Office Hours]
- [x] Conducted `/office-hours` and `/design-consultation` architectural review of v1 legacy code vs v2 design system.
- [x] Created implementation plan and task ledger (`v2/tasks/program-accreditation-documents.md`).
- [x] Phase 1: Database migration & seeders for 17 Colleges, Degree Programs, and AACCUP Master Instrument.
- [x] Phase 2: Controller, Service, and Routes for Program Accreditation.
- [x] Phase 3: College Selection Grid & Degree Programs Selection Grid.
- [x] Phase 4: Document Type Hub & 5 Category Workspaces.
- [x] Phase 5: Verification, automated tests, and Vite build.

### [2026-09-25 — Phase 1: Foundation & Data Layer]
- [x] Created migration `2026_09_25_000001_add_campus_and_logo_to_colleges_table.php` adding `campus` and `logo_image` to the `colleges` table.
- [x] Updated `2026_09_20_000011_create_instrument_criteria_table.php` to include `'best_practice'` in the criteria `type` enum.
- [x] Updated `app/Models/College.php` with `campus`, `logo_image` in `$fillable` and an accessor `logo_url` pointing to `asset('logos/' . ...)`.
- [x] Implemented `database/seeders/CollegeSeeder.php` with all 17 Bicol University academic units and satellite campuses matching official logos in `public/logos/`.
- [x] Implemented `database/seeders/ProgramSeeder.php` seeding 127 academic degree programs across the 17 colleges with realistic accreditation levels (Candidate Status, Levels 1–4).
- [x] Implemented `database/seeders/AaccupMasterInstrumentSeeder.php` seeding the complete AACCUP Undergraduate Master Instrument (`INST-AACCUP-UG`) with 10 Areas, 15 Parameters, and 47 Benchmark criteria across Systems, Implementation, Outcomes, and Best Practices.
- [x] Registered `CollegeSeeder`, `ProgramSeeder`, `AaccupMasterInstrumentSeeder`, and `ComplianceUserSeeder` in `DatabaseSeeder.php`.
- [x] Ran database migrations and seeds cleanly; verified record counts: 17 colleges, 127 programs, 10 areas, 15 parameters, 47 criteria.
- [x] Verified full test suite passes (41/41 tests passing, 234 assertions).

### [2026-09-25 — Phase 2: Backend Controller & Service Layer]
- [x] Implemented `ProgramAccreditationService` (`app/Services/ProgramAccreditationService.php`) (169 lines):
  - College listing with program counts and search filtering.
  - Program listing for selected college with document counts and search.
  - AACCUP instrument hierarchy resolution (10 areas, parameters, criteria).
  - Accreditation level-adaptive document types resolver (Supporting docs, Self-survey, Compliance reports for all; PPP for Levels 1–2; Narrative profile for Levels 3–4).
  - Degree program registration and accreditation document upload handling.
- [x] Implemented `ProgramAccreditationController` (`app/Http/Controllers/ProgramAccreditationController.php`) (191 lines):
  - 3-tier Inertia navigation endpoint (`documents.program-accreditation`).
  - Gated strictly to IQA staff, IQA members, and sysadmins (`authorizeIqaAccess`).
  - `storeProgram` and `storeDocument` endpoints with audit logging.
- [x] Registered `/documents/program-accreditation` routes in `routes/web.php` and updated `DocumentController` redirect for `tab=program-accreditation`.
- [x] Updated `User::hasRole(string|array)` in `app/Models/User.php`.
- [x] Created `tests/Feature/ProgramAccreditationTest.php` with 8 comprehensive test cases (70 assertions, 100% passing).
- [x] Created `resources/js/Pages/Documents/Program-Accreditation/Index.vue` foundation shell (< 90 lines).
- [x] Verified zero regressions across entire test suite: 49/49 tests passing, 304 assertions.

### [2026-09-25 — Phase 3: Frontend Selection Grids & Navigation]
- [x] Implemented `Partials/CollegeGrid.vue` (141 lines):
  - 17 BU academic units card grid across 4 campus clusters.
  - Official high-res logo display with alt tags, campus badges, and program count badges.
  - Search filtering by college name, code, and campus with instant clear button.
  - Primary workstation action buttons (`View Academic Programs →`) styled in `--color-sidebar-blue`.
- [x] Implemented `Partials/ProgramGrid.vue` (183 lines):
  - Degree programs grid for the selected college with program code badges and campus location.
  - AACCUP accreditation level pills (`Candidate Status`, `Level 1–4`) mapped to DaisyUI semantic badges (`badge-info`, `badge-success`, `badge-neutral`).
  - Document count indicators and search filtering.
  - "+ Add New Program" action button styled in official Bicol University Orange (`--color-bu-orange-500`).
- [x] Implemented `Partials/AddProgramModal.vue` (158 lines):
  - DaisyUI modal dialog with validation error feedback for code, title, and accreditation level.
- [x] Updated `Index.vue` (169 lines):
  - Top-level tier orchestrator and breadcrumb navigation bar with back buttons (`←`).
  - Seamless Inertia router integration with preserved scroll.
- [x] Verified in browser with subagent:
  - Dev login via `/dev/login/iqa-staff`.
  - Tier 1 navigation, search filtering for "GUBAT", and clear search verified.
  - Tier 2 navigation to BU GUBAT degree programs verified.
  - Add Program modal open and dismiss verified.
  - Screenshots captured: `tier_1_college_grid` and `tier_2_program_grid`.
- [x] Verified `npm run build` (< 1s) and `php artisan test` (49/49 tests passing).

### [2026-09-25 — Phase 4: Document Type Hub & 5 Category Workspaces]
- [x] Implemented `Partials/DocumentTypeHub.vue` (155 lines):
  - 5 dynamic document type cards conditioned by program accreditation level.
  - Supporting Documents, Self-Survey, Compliance Reports for all levels.
  - Program Performance Profile (PPP) for Levels 1–2.
  - Narrative Profile for Levels 3–4.
  - Program header banner with logo, code, title, level pill, and quick upload action.
- [x] Implemented `Partials/SupportingDocsView.vue` (188 lines):
  - 10 Area navigation tabs (Areas I–X).
  - Parameters sidebar with benchmark counters.
  - Benchmark tabs (Systems, Implementation, Outcomes, Best Practices) and criteria checklist.
  - File upload trigger per criterion benchmark.
- [x] Implemented `Partials/SelfSurveyView.vue` (160 lines):
  - Numerical rating matrix with dropdowns (1.0 to 5.0).
  - Real-time reactive calculation of System Mean, Implementation Mean, Outcome Mean, and Parameter Mean.
  - Best practices notes area and surveyor sign-off input.
- [x] Implemented `Partials/ComplianceReportsView.vue` (105 lines):
  - Compliance records table with upload and download actions.
- [x] Implemented `Partials/ProfileDocumentsView.vue` (118 lines):
  - Shared repository view for PPP and Narrative Profile files.
- [x] Implemented `Partials/UploadDocumentModal.vue` (166 lines):
  - DaisyUI modal supporting drag/drop and file selection for PDF, DOCX, XLSX, PNG, JPG (up to 50MB).
- [x] Updated `Index.vue` (161 lines):
  - Multi-tier router coordinating Tier 1 (Colleges), Tier 2 (Programs), Tier 3 (Document Hub), and Tier 4 (Workspaces).
  - Dynamic breadcrumb trails with back navigation.
- [x] Verified in browser with subagent:
  - Tier 3 Hub card navigation.
  - Supporting Documents 10-Area workstation navigation.
  - Self-Survey matrix with real-time recalculations.
  - Upload modal open and dismiss.
  - Screenshots captured: `supporting_docs_workspace` and `self_survey_workspace`.
- [x] Verified `npm run build` (1.04s) and `php artisan test` (49/49 tests passing, 304 assertions).

## Final Status
- Completed: 2026-09-25
- Tests: ✓ 49/49 passing (304 assertions)
- Security review: ✓ Multi-tenancy college scoping & IQA authorization gates in place.
- Commits:
  - `55e9d1c8` feat(accreditation): add college branding migration, degree programs, and AACCUP master seeders
  - `f23ecdc3` feat(accreditation): implement ProgramAccreditationService, controller, and routes
  - `879e5680` feat(accreditation): implement CollegeGrid, ProgramGrid, and AddProgramModal components
  - `897734ea` feat(accreditation): implement DocumentTypeHub, category workspaces, and UploadDocumentModal
  - `b13c8617` fix(ui): fix thick native browser scrollbars caused by DaisyUI scrollbar-color
  - `42a31147` refactor(ui): streamline CollegeGrid search input and remove redundant styling
  - `a8325a18` style(accreditation): streamline program grid and document hub headers and cards
