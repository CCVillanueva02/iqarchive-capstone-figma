# Implementation Plan: IQArchive Clean Feature Architecture & Modernization

A comprehensive, phased roadmap to transition IQArchive into a **clean, feature-based Livewire 4 architecture** with a formalized atomic UI component kit and a strictly organized view structure.

---

## Architecture Overview: The New Clean Directory Structure

All views are being migrated out of tangled role silos and into intuitive, self-contained feature directories under `resources/views/features/`:

```
resources/views/
├── components/ui/       # Canonical Atomic UI Component Kit (<x-ui.*>)
├── layouts/             # Application frame (app shell, sidebar, header)
└── features/            # Feature-Based Modules (The New Standard)
    ├── visits/          # [COMPLETED] Accreditation Visits & Milestone Tracking
    ├── admin/           # [COMPLETED] Accounts Management & Audit Trail
    ├── verification/    # [PENDING] Dean Step 6 Quality Review
    ├── task-force/      # [PENDING] Task Force Area Workspace & Teams
    ├── instruments/     # [PENDING] Master AACCUP Instrument Builder (Module 4)
    └── documents/       # [PENDING] Self-Survey Matrix & Document Repository
```

---

## Implementation Status & Checklist

### Phase 0: Safety, Branching & Environment Guard
- [x] **Branch Isolation:** Created and switched to isolated branch `v2` (derived from `document-jans`).
- [x] **Quality Baseline:** Verified 83/83 passing Pest tests (345 assertions) and clean Vite build.
- [x] **Lint & Style Baseline:** Ran Laravel Pint across the codebase, resolving all 74 style debt files.
- [x] **Type Safety Baseline:** Generated `phpstan-baseline.neon` for Larastan Level 7 debt tracking.
- [x] **Safety Boundary Armed:** Activated `/guard` mode with edit boundary locked to `resources/views/`.

---

### Phase 1: Formalized Design System & Atomic UI Component Kit
- [x] **Page Header (`<x-ui.page-header>`):** Standardized title, subtitle, breadcrumb trail, and action slots ([`page-header.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/page-header.blade.php)).
- [x] **Stat Card (`<x-ui.stat-card>`):** Uniform KPI metric cards with status accents and icons ([`stat-card.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/stat-card.blade.php)).
- [x] **Status Badge (`<x-ui.status-badge>`):** Standardized status pills for `scheduled`, `in_progress`, `pending`, `verified`, `needs_revision`, `completed`, `cancelled` ([`status-badge.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/status-badge.blade.php)).
- [x] **Buttons (`<x-ui.button>`):** Canonical button component supporting `primary` (navy), `brand` (orange), `secondary`, `outline`, `danger`, `subtle` with Livewire `wire:loading` spinner integration ([`button.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/button.blade.php)).
- [x] **Modal Wrapper (`<x-ui.modal>`):** Unified wrapper over Flux UI modal with consistent header, body, and action footer ([`modal.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/modal.blade.php)).
- [x] **Table Shell (`<x-ui.table>` & `<x-ui.table-empty>`):** Uniform data table with hover states, zebra styling, and centered empty-state illustrations ([`table.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/table.blade.php), [`table-empty.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/table-empty.blade.php)).
- [x] **Filter Toolbar (`<x-ui.filter-bar>`):** Unified search bar with debouncing and dropdown slots ([`filter-bar.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/filter-bar.blade.php)).
- [x] **Document Chip (`<x-ui.document-chip>`):** Standard file attachment preview chip ([`document-chip.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/components/ui/document-chip.blade.php)).
- [x] **Live Component Showcase:** Created visual reference page at [`dev-components.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/dev-components.blade.php).
- [x] **Token Compliance Pass:** Verified zero forbidden color prefixes in `DesignSystemComplianceTest`.

---

### Phase 2: Feature-Based Reorganization (Screen Rebuilds)

#### Feature 2.1: Accreditation Visits & Milestones (`features/visits/`)
- [x] **Master Screen:** Created clean [`features/visits/index.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/features/visits/index.blade.php) using `<x-ui.page-header>` and `<x-ui.filter-bar>`.
- [x] **Metric Row:** Created [`features/visits/partials/stats-bar.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/features/visits/partials/stats-bar.blade.php) using `<x-ui.stat-card>`.
- [x] **Data Table:** Created [`features/visits/partials/table.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/features/visits/partials/table.blade.php) using `<x-ui.table>` and `<x-ui.status-badge>`.
- [x] **Lifecycle Drawer:** Created clean [`features/visits/partials/timeline-modal.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/features/visits/partials/timeline-modal.blade.php) using standard zinc/primary tokens.
- [x] **Schedule Modal:** Created [`features/visits/schedule-modal.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/features/visits/schedule-modal.blade.php) with program preview card and Dean alert.
- [x] **Delegation Bridge:** Linked `livewire/accreditation/visits-index.blade.php` and `schedule-accreditation.blade.php` to clean feature files.

#### Feature 2.2: Administration & Security (`features/admin/`)
- [x] **Consolidate Duplicate Audit Trail:** Merged `livewire/iqa-admin/audit-trail.blade.php` and `livewire/system-administrator/audit-trail.blade.php` (100% duplicate) into single master template [`features/admin/audit-trail.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/features/admin/audit-trail.blade.php).
- [x] **Accounts Management Master:** Created clean [`features/admin/accounts.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/features/admin/accounts.blade.php) with `<x-ui.page-header>`.
- [x] **Delegation Bridge:** Linked `livewire/admin/accounts.blade.php`, `livewire/iqa-admin/audit-trail.blade.php`, and `livewire/system-administrator/audit-trail.blade.php` to feature templates.

#### Feature 2.3: Dean Quality Review & Verification (`features/verification/`)
- [ ] **Master Review Screen:** Rebuild [`DeanVerification.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/DeanVerification.php) view into `features/verification/index.blade.php` using `<x-ui.page-header>` and `<x-ui.document-chip>`.
- [ ] **Eliminate Hand-Rolled Alpine Overlays:** Replace the custom fixed-inset revision request overlays with canonical `<x-ui.modal>` or `<flux:modal>`.
- [ ] **Criteria Parameter Cards:** Standardize compliance status indicators (`verified`, `needs_revision`).

#### Feature 2.4: Task Force Area Workspace (`features/task-force/`)
- [ ] **Member Criteria Workspace:** Rebuild [`task-force-dashboard.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/task-force-dashboard.blade.php) into `features/task-force/workspace.blade.php`.
- [ ] **Team Management Overview:** Rebuild [`task-force-overview.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/task-force-overview.blade.php) into `features/task-force/teams.blade.php`.
- [ ] **Standardize Modals:** Transition Task Force member nomination and dean submission modals to `<x-ui.modal>`.

#### Feature 2.5: Master AACCUP Instruments (`features/instruments/`)
- [ ] **Instruments Builder Screen:** Rebuild [`instruments.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/instruments.blade.php) into `features/instruments/builder.blade.php`.
- [ ] **Area & Criteria Tree:** Modernize the 10-Area accordion hierarchy with clean semantic tokens.

#### Feature 2.6: Self-Survey Matrix & Documents (`features/documents/`)
- [ ] **Deduplicate Matrix Views:** Consolidate `institutional-accreditation/self-survey-matrix.blade.php` and `program-accreditation/self-survey-matrix.blade.php` (99.5% duplicate) into single parameter-driven `features/documents/matrix-table.blade.php`.
- [ ] **Clean Repository Master:** Create `features/documents/index.blade.php` using `<x-ui.table>` and `<x-ui.document-chip>`.

---

### Phase 3: High-Severity Architectural & Bug Fixes
- [ ] **Fix Route Collision:** Resolve duplicate route name `'documents.serve'` in [`routes/web.php:311, 332`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L311).
- [ ] **Guard `basename()` Runtime Bug:** Add null-safety guards in [`AccreditationEvidenceController.php:205`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/AccreditationEvidenceController.php#L205) and [`SubmissionController.php:119`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/SubmissionController.php#L119).
- [ ] **Enforce Active Visit Constraint:** Add database unique constraint and application guard preventing multiple active visits for the same program in [`ScheduleAccreditation.php:111`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php#L111).
- [ ] **Add Soft Deletes:** Add `softDeletes()` to `documents` and `accreditations` tables.
- [ ] **RBAC Harmonization:** Standardize multi-role permission checks using `$user->hasRole(...)`.

---

### Phase 4: Document Workspace Livewire Modernization
- [ ] **Retire Untyped Client Store:** Completely delete the 3,905-line [`resources/js/iqa-documents.js`](file:///c:/Users/janss/Herd/iqarchive/resources/js/iqa-documents.js) file.
- [ ] **Native Livewire Document Management:** Implement clean Livewire upload pipeline using `WithFileUploads` and server-side state.

---

### Phase 5: Final Quality Verification & Health Score
- [ ] **Pint Style Check:** Run `php vendor/bin/pint --test`.
- [ ] **PHPStan Level 7 Analysis:** Run `php -d memory_limit=1G vendor/bin/phpstan analyse`.
- [ ] **Full Pest Test Suite:** Run `php artisan test` (must remain 100% passing).
- [ ] **Vite Production Bundle:** Run `npm run build`.
- [ ] **Final `/health` Run:** Confirm composite score reaches **10.0 / 10.0**.

---

## Verification Plan

### Automated Verification Commands
```powershell
# 1. Run Pest test suite
php artisan test

# 2. Compile client production bundle
cmd /c npm run build

# 3. Code style verification
php vendor/bin/pint --test

# 4. Static type safety check
php -d memory_limit=1G vendor/bin/phpstan analyse
```

### Visual & Browser Verification
- **Component Showcase:** `http://iqarchive.test/dev/components` (visually preview all buttons, badges, tables, and chips).
- **Visits Screen:** `http://iqarchive.test/visits` (test scheduling, timeline drawer, and status filtering).
- **Accounts Screen:** `http://iqarchive.test/roles/system-administrator/accounts` (test user search, role filter, and pre-register modal).
- **Audit Trail Screen:** `http://iqarchive.test/roles/iqa-admin/audit-trail` (test session, accounts, and file modification tabs).
