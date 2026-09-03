# IQArchive Full Project Audit (Read-Only)

**Date:** 2026-09-03  
**Branch:** `document-jans`  
**Platform:** Laravel 12 (Livewire 4, Flux UI, Tailwind v4)  
**Auditor Mode:** Read-Only Diagnostic Architecture & Structural Audit  

---

## Prerequisite: Run `/health` First

```
Composite Code Health Score: 5.0 / 10.0 (NEEDS WORK)

Tests:        10/10 CLEAN  — 83 passed, 0 failures, 345 assertions (Pest v4)
Client Build: 10/10 CLEAN  — Vite bundled 25 modules, no errors
Lint / Style:  0/10 CRITICAL — 74 files flagged by Laravel Pint (pure formatting,
               no runtime risk). Affects Livewire components, Eloquent models,
               9 migrations, 10 seeders, 19 feature test files.
Type Safety:   0/10 CRITICAL — 988 issues from Larastan at Level 7. Categories:
               missing return/parameter types on controllers & helpers;
               Larastan unable to infer dynamic Eloquent relation methods
               (e.g. Program::accreditations()); Model|Collection union access;
               nullable paths passed to basename()/FilesystemAdapter::url()
               without null-coalescing guards.

Status as of this audit: Pint fix has NOT yet been run. PHPStan baseline has
NOT yet been generated. Treat the 74 style files and 988 type issues as known,
already-catalogued debt — do not re-list individual files/errors in this
report. The one category worth flagging if you encounter it again in your own
read of the code: nullable-path-into-basename() is a real bug pattern, not
just a missing docblock — call it out specifically if you see it, don't fold
it into the generic "type safety debt" bucket.
```

---

## 1. Backend Architecture Inventory

### 1.1 Class Catalog

#### Controllers (`app/Http/Controllers/` — 8 classes)
1. [`AccreditationEvidenceController.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/AccreditationEvidenceController.php) (346 lines): Evidence document uploading, JSON API serving, and Stage 5 submission to Dean.
2. [`DocumentCategoryController.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/DocumentCategoryController.php) (346 lines): Common repository documents, category taxonomy, office assignment endpoints.
3. [`ProgramController.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/ProgramController.php) (246 lines): Program CRUD, accreditation level assignment, college retrieval endpoints.
4. [`SubmissionController.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/SubmissionController.php) (170 lines): Submission lifecycle actions, document downloads/serving, status transitions.
5. [`GoogleAuthController.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/GoogleAuthController.php) (145 lines): Google Workspace SSO redirect, callback handling, domain restriction, user auto-provisioning.
6. [`SelfSurveyController.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/SelfSurveyController.php) (76 lines): Self-survey rating retrieval and persistence for Institutional Accreditation.
7. [`CollegeController.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/CollegeController.php) (36 lines): College CRUD endpoints.
8. [`Controller.php`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/Controller.php) (6 lines): Base controller.

#### Livewire Components (`app/Livewire/` — 17 classes)
1. [`Configuration/Instruments.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/Instruments.php) (878 lines): Master AACCUP instrument builder, area/parameter/criterion hierarchy management, template cloning.
2. [`IqaAdmin/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/Accounts.php) (583 lines): User management for IQA Staff (filters out System Administrators).
3. [`SystemAdministrator/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/SystemAdministrator/Accounts.php) (544 lines): User management for System Administrator (all roles visible).
4. [`CollegeHead/Dashboard.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/Dashboard.php) (542 lines): Dean workspace for visit oversight, task force approvals, review queues.
5. [`TaskForce/TaskForceOverview.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/TaskForce/TaskForceOverview.php) (536 lines): Task force list, member roster modals, team assembly.
6. [`CollegeHead/InstrumentCustomization.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/InstrumentCustomization.php) (530 lines): Dean parameter customization, criteria weight adjustments.
7. [`Configuration/CollegesPrograms.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/CollegesPrograms.php) (505 lines): Academic unit CRUD, soft deletes, campus assignments.
8. [`CollegeHead/DeanVerification.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/DeanVerification.php) (410 lines): Step 6 quality control, evidence approval, return-for-revision actions.
9. [`Accreditation/VisitsIndex.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/VisitsIndex.php) (404 lines): Scheduled accreditation visits, timeline modal, cancellation.
10. [`TaskForce/TaskForceDashboard.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/TaskForce/TaskForceDashboard.php) (223 lines): Task force member area workspace, progress tracking, criteria evidence linkage.
11. [`Accreditation/ScheduleAccreditation.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php) (184 lines): Visit scheduling modal and dispatching Dean notification.
12. [`Monitoring/MonitoringOverview.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Monitoring/MonitoringOverview.php) (180 lines): University-wide accreditation monitoring directory and metrics.
13. [`IqaAdmin/AuditTrail.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/AuditTrail.php) (144 lines): Audit log inspection for IQA Staff.
14. [`SystemAdministrator/AuditTrail.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/SystemAdministrator/AuditTrail.php) (136 lines): Audit log inspection for System Administrator.
15. [`CollegeHead/TaskForceSetup.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/TaskForceSetup.php) (73 lines): Task force nomination view.
16. [`Actions/Logout.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Actions/Logout.php) (19 lines): Livewire session termination action.
17. [`IqaAdmin/MatrixBuilder.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/MatrixBuilder.php) (14 lines): Unused stub component returning orphaned view.

#### Models (`app/Models/` — 22 classes)
`Accreditation`, `AccreditationDocumentLink`, `AuditLog`, `College`, `ComplianceRequirement`, `Document`, `DocumentAccessRequest`, `DocumentCategory`, `DocumentOCRValidation`, `DocumentReview`, `Instrument`, `InstrumentArea`, `InstrumentCriterion`, `InstrumentParameter`, `Notification`, `Office`, `Program`, `Role`, `TaskForce`, `TaskForceAssignment`, `TaskForceMember`, `User`.

#### Observers & Policies
- **Observers:** Zero dedicated observer classes in `app/Observers/`. Model lifecycle events are defined inline inside [`app/Providers/AppServiceProvider.php`](file:///c:/Users/janss/Herd/iqarchive/app/Providers/AppServiceProvider.php#L91-L132) (`Document::created`, `Document::updated`, `Document::deleted`) and [`AppServiceProvider.php`](file:///c:/Users/janss/Herd/iqarchive/app/Providers/AppServiceProvider.php#L167-L187) (`TaskForce::created`).
- **Policies:** Zero dedicated policy classes in `app/Policies/`. Only 4 Gates are declared in [`AppServiceProvider.php`](file:///c:/Users/janss/Herd/iqarchive/app/Providers/AppServiceProvider.php#L140-L164).

#### Service / Action Classes
- Zero domain service classes in `app/Services/`.
- Only Fortify boilerplate actions exist: [`app/Actions/Fortify/CreateNewUser.php`](file:///c:/Users/janss/Herd/iqarchive/app/Actions/Fortify/CreateNewUser.php) and [`app/Actions/Fortify/ResetUserPassword.php`](file:///c:/Users/janss/Herd/iqarchive/app/Actions/Fortify/ResetUserPassword.php).

---

### 1.2 Analysis of Livewire Components Over ~150 Lines

Every Livewire component over 150 lines acts as a "fat controller," embedding data querying, input validation, multi-table database transactions, audit log writes, notifications, and workflow state changes directly inside component methods:

1. **[`Instruments.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/Instruments.php#L220-L310) (878 lines):**
   Handles deep recursive cloning of entire AACCUP instrument trees (`Instrument` $\rightarrow$ `InstrumentArea` $\rightarrow$ `InstrumentParameter` $\rightarrow$ `InstrumentCriterion`). All recursion, database transactions (`DB::transaction`), manual permission guards, and audit trail insertions live entirely within the Livewire class.
2. **[`IqaAdmin/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/Accounts.php) (583 lines) & [`SystemAdministrator/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/SystemAdministrator/Accounts.php) (544 lines):**
   Handles user provisioning, activation toggles, password hashing, multi-role syncing, college/program associations, and audit trail recording. 95% of the logic is duplicated verbatim between these two files; the only divergence is that `IqaAdmin/Accounts` hides the System Administrator role.
3. **[`CollegeHead/Dashboard.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/Dashboard.php#L320-L480) (542 lines):**
   Manages Dean-level approval gates, task force proposal acceptance/rejection, visit timeline views, and notification dispatches without delegating to any domain service.
4. **[`TaskForce/TaskForceOverview.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/TaskForce/TaskForceOverview.php#L280-L450) (536 lines):**
   Executes task force CRUD, member roster additions/deletions, lead assignments, program association validation, and audit logging.
5. **[`CollegeHead/InstrumentCustomization.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/InstrumentCustomization.php#L180-L360) (530 lines):**
   Directly mutates parameters, area weights, and criteria applicability for programs in accreditation Stage 4.
6. **[`Configuration/CollegesPrograms.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/CollegesPrograms.php#L210-L390) (505 lines):**
   Executes academic hierarchy CRUD, soft deletes, restore operations, campus code mapping, and audit logging.
7. **[`CollegeHead/DeanVerification.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/DeanVerification.php#L180-L320) (410 lines):**
   Implements Stage 6 review logic: verifies evidence files, flags criteria for revisions, transitions accreditation status to `under_review` or `verified`, and logs reviews.
8. **[`Accreditation/VisitsIndex.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/VisitsIndex.php#L59-L115) (404 lines):**
   Handles visit filtering, date calculations, and the cancellation workflow (updating status, creating audit logs, dispatching alerts).
9. **[`TaskForce/TaskForceDashboard.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/TaskForce/TaskForceDashboard.php#L40-L120) (223 lines):**
   Resolves active accreditations via fallback heuristics, computes evidence completion percentages across criteria, and handles Stage 5 submissions to the Dean.
10. **[`Accreditation/ScheduleAccreditation.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php#L99-L164) (184 lines):**
    Validates target dates, instantiates `Accreditation` records, locates college deans, writes audit entries, and dispatches notifications.
11. **[`Monitoring/MonitoringOverview.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Monitoring/MonitoringOverview.php#L120-L175) (180 lines):**
    Executes heavy aggregation queries across programs and accreditations to compute institutional readiness metrics.

---

### 1.3 RBAC Implementation: Practice vs. Conventions

The RBAC architecture exhibits significant inconsistency across the 7 application roles:

1. **Absence of Policies:** There are no Policy classes mapping models (`AccreditationPolicy`, `DocumentPolicy`, `TaskForcePolicy`).
2. **Minimal Gates:** Only 4 Gates are defined in [`AppServiceProvider.php`](file:///c:/Users/janss/Herd/iqarchive/app/Providers/AppServiceProvider.php#L140-L164):
   - `manageCollegesAndPrograms`
   - `viewCollegesAndPrograms`
   - `manageTaskForceMembers`
   - `viewTaskForceRoster`
3. **Inconsistent Component Guards:**
   - Some components check `$user->hasRole(...)`: e.g. [`AuditTrail.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/AuditTrail.php#L28).
   - Other components check legacy string attribute `in_array($user->role, [...])`: e.g. [`ScheduleAccreditation.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php#L102), [`VisitsIndex.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/VisitsIndex.php#L56).
   - This creates a defect where a user with multiple roles via the `role_user` pivot table might fail checks using `$user->role` if their `session('active_role')` is not set or defaults to a secondary role.
4. **Ad-Hoc Route Middleware:**
   - In [`routes/web.php`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L111-L158), route closures check `$user->role !== 'accreditor'` or `$user->hasRole(...)` inline and call `abort(403)`.
   - Loops for roles (`system-administrator`, `iqa-staff`, `task-force-member`, `college-head`) in [`routes/web.php`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L187-L259) duplicate identical closure authorization checks 20+ times.

---

### 1.4 Code & Query Logic Duplication

1. **AuditLog Insertion:**
   Every controller and Livewire component manually constructs identical `AuditLog::create([ 'user_id' => ..., 'action' => ..., 'target_type' => ..., 'target_id' => ..., 'timestamp' => now() ])` calls. There is no central service or trait.
2. **College Dean Resolution:**
   Locating the Dean for a given college/program is re-implemented in multiple ways:
   - [`ScheduleAccreditation.php:L82-L89`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php#L82-L89) queries `User::where('college_id', ...)->where('role_id', $deanRole->id)`.
   - [`AppServiceProvider.php:L171-L177`](file:///c:/Users/janss/Herd/iqarchive/app/Providers/AppServiceProvider.php#L171-L177) queries both `role_id` and the `roles` relation.
   - [`CollegeHead/Dashboard.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/CollegeHead/Dashboard.php) queries by authenticated user college.
3. **Active Accreditation Lookup Heuristic:**
   Because multiple accreditations can exist per program, components independently guess the active one:
   - [`TaskForceDashboard.php:L54`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/TaskForce/TaskForceDashboard.php#L54): `Accreditation::where('program_id', $user->program_id)->latest()->first()`
   - [`TaskForceDashboard.php:L70`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/TaskForce/TaskForceDashboard.php#L70): `Accreditation::latest()->first()`
4. **Duplicate Route Name Collision:**
   In [`routes/web.php`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L311) and [`routes/web.php`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L332):
   - Line 311: `Route::get('documents/{id}/serve', [SubmissionController::class, 'serveDocument'])->name('documents.serve');`
   - Line 332: `Route::get('documents/{id}/view', [DocumentCategoryController::class, 'serveDocument'])->name('documents.serve');`
   Both routes claim the route name `'documents.serve'`, causing non-deterministic URL generation when using `route('documents.serve', ...)`.
5. **Runtime Bug: Nullable Path Passed to `basename()`:**
   - [`AccreditationEvidenceController.php:L205`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/AccreditationEvidenceController.php#L205): `basename($filePath)` where `$filePath = $uploadedFile->storeAs(...)` can return `false` on storage failure.
   - [`AccreditationEvidenceController.php:L260`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/AccreditationEvidenceController.php#L260): `basename($doc->file_path)` where `file_path` is nullable.
   - [`SubmissionController.php:L119, L130`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/SubmissionController.php#L119): `'Content-Disposition' => 'inline; filename="'.basename($document->file_path).'"'` where `file_path` can be null. Passing null to `basename()` is deprecated in PHP 8.1+ and triggers warnings or crashes.

---

### Flags (Section 1)
- **[High]** Route name collision on `documents.serve` between [`routes/web.php:L311`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L311) and [`routes/web.php:L332`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L332).
- **[High]** Nullable/boolean arguments passed into `basename()` in [`AccreditationEvidenceController.php:L205, L260`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/AccreditationEvidenceController.php#L205) and [`SubmissionController.php:L119, L130`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/SubmissionController.php#L119).
- **[High]** Discrepancy between single-role checks (`$user->role`) and multi-role checks (`$user->hasRole()`) risking privilege lockout.
- **[Medium]** Near-100% duplicate code between [`IqaAdmin/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/Accounts.php) and [`SystemAdministrator/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/SystemAdministrator/Accounts.php).
- **[Medium]** Complete absence of Policy classes; only 4 Gates defined.
- **[Low]** Duplicated manual `AuditLog::create()` calls scattered across ~15 classes.

---

## 2. File Structure Inventory & Redundancy (Backend + Frontend)

### 2.1 Directory Tree

```
app/
├── Actions/
│   └── Fortify/
│       ├── CreateNewUser.php
│       └── ResetUserPassword.php
├── Concerns/
│   ├── PasswordValidationRules.php
│   └── ProfileValidationRules.php
├── Console/
│   └── Commands/                   <-- [EMPTY DIRECTORY]
├── Http/
│   └── Controllers/
│       ├── AccreditationEvidenceController.php
│       ├── CollegeController.php
│       ├── Controller.php
│       ├── DocumentCategoryController.php
│       ├── GoogleAuthController.php
│       ├── ProgramController.php
│       ├── SelfSurveyController.php
│       └── SubmissionController.php
├── Livewire/
│   ├── Accreditation/
│   │   ├── ScheduleAccreditation.php
│   │   └── VisitsIndex.php
│   ├── Actions/
│   │   └── Logout.php
│   ├── CollegeHead/
│   │   ├── Dashboard.php
│   │   ├── DeanVerification.php
│   │   ├── InstrumentCustomization.php
│   │   └── TaskForceSetup.php
│   ├── Configuration/
│   │   ├── CollegesPrograms.php
│   │   └── Instruments.php
│   ├── Documents/                  <-- [EMPTY DIRECTORY]
│   ├── IqaAdmin/
│   │   ├── Accounts.php
│   │   ├── AuditTrail.php
│   │   └── MatrixBuilder.php       <-- [ORPHANED COMPONENT]
│   ├── Monitoring/
│   │   └── MonitoringOverview.php
│   ├── SystemAdministrator/
│   │   ├── Accounts.php
│   │   └── AuditTrail.php
│   └── TaskForce/
│       ├── TaskForceDashboard.php
│       └── TaskForceOverview.php
├── Models/
│   ├── Accreditation.php
│   ├── AccreditationDocumentLink.php
│   ├── AuditLog.php
│   ├── College.php
│   ├── ComplianceRequirement.php
│   ├── Document.php
│   ├── DocumentAccessRequest.php
│   ├── DocumentCategory.php
│   ├── DocumentOCRValidation.php
│   ├── DocumentReview.php
│   ├── Instrument.php
│   ├── InstrumentArea.php
│   ├── InstrumentCriterion.php
│   ├── InstrumentParameter.php
│   ├── Notification.php
│   ├── Office.php
│   ├── Program.php
│   ├── Role.php
│   ├── TaskForce.php
│   ├── TaskForceAssignment.php     <-- [ORPHANED MODEL]
│   ├── TaskForceMember.php
│   └── User.php
└── Providers/
    ├── AppServiceProvider.php
    └── FortifyServiceProvider.php

resources/
├── css/
│   ├── app.css
│   └── token-mapping.md
├── js/
│   ├── app.js
│   ├── bootstrap.js
│   ├── iqa-documents.js
│   ├── iqa-submissions.js
│   └── passkeys.js
└── views/
    ├── components/
    │   ├── accreditation/
    │   ├── layouts/
    │   └── monitoring/
    ├── flux/
    │   ├── icon/
    │   └── navlist/
    ├── layouts/
    │   ├── app/
    │   └── auth/
    ├── livewire/
    │   ├── accreditation/
    │   ├── admin/
    │   ├── college-head/
    │   ├── configuration/
    │   ├── documents/              <-- [EMPTY DIRECTORY]
    │   ├── iqa-admin/
    │   ├── monitoring/
    │   ├── system-administrator/
    │   └── task-force/
    ├── pages/
    │   ├── auth/
    │   ├── documents/
    │   ├── roles/
    │   ├── settings/               <-- Contains Volt components with ⚡ prefix
    │   └── workspace/
    └── partials/
```

---

### 2.2 Redundancies, Misplacements, and Anomalies

1. **Empty / Ghost Directories:**
   - [`app/Console/Commands/`](file:///c:/Users/janss/Herd/iqarchive/app/Console/Commands) is empty.
   - [`app/Livewire/Documents/`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Documents) is empty.
   - [`resources/views/livewire/documents/`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/documents) is empty.
   Document management was implemented in standard Blade pages (`resources/views/pages/documents/`) rather than Livewire components, leaving behind empty folders.
2. **Orphaned Component & View:**
   - [`app/Livewire/IqaAdmin/MatrixBuilder.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/MatrixBuilder.php) (14 lines) and [`resources/views/livewire/iqa-admin/matrix-builder.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/iqa-admin/matrix-builder.blade.php) (93 lines) are not registered in routes, not included in any view, and contain hardcoded mock inputs superseded by [`Instruments.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/Instruments.php).
3. **Special Character Filenames in Settings (Volt Components):**
   - Files in [`resources/views/pages/settings/`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/settings):
     - `⚡profile.blade.php`
     - `⚡delete-user-form.blade.php`
     - `⚡delete-user-modal.blade.php`
     - `⚡two-factor-setup-modal.blade.php`
     - `two-factor/⚡recovery-codes.blade.php`
   - These use the UTF-8 lightning bolt (`\xE2\x9A\xA1`) prefix required by Livewire Volt single-file components. In non-UTF8 terminals or standard Windows tooling, these appear as `?profile.blade.php`.
   - In [`routes/settings.php:L12`](file:///c:/Users/janss/Herd/iqarchive/routes/settings.php#L12), `Route::livewire('settings/appearance', 'pages::settings.appearance')` references an appearance view that does not exist in `resources/views/pages/settings/`.
4. **Component Sizing Anomalies:**
   - [`Instruments.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Configuration/Instruments.php) is 878 lines.
   - Six additional Livewire components exceed 500 lines: `IqaAdmin/Accounts.php` (583), `SystemAdministrator/Accounts.php` (544), `CollegeHead/Dashboard.php` (542), `TaskForceOverview.php` (536), `InstrumentCustomization.php` (530), and `CollegesPrograms.php` (505).

---

### Flags (Section 2)
- **[Medium]** Dead route in [`routes/settings.php:L12`](file:///c:/Users/janss/Herd/iqarchive/routes/settings.php#L12) referencing non-existent `pages::settings.appearance`.
- **[Medium]** Orphaned component [`MatrixBuilder.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/MatrixBuilder.php) and view.
- **[Low]** Empty ghost directories (`app/Livewire/Documents/`, `resources/views/livewire/documents/`, `app/Console/Commands/`).
- **[Low]** Seven Livewire classes exceed 500 lines of code.

---

## 3. Database Design Review

### 3.1 Migration Inventory & Schema Mapping

The database schema is constructed across 23 migration files resulting in 36 total tables:

| Migration File | Primary Tables Created / Modified | Notable Features / Constraints |
| :--- | :--- | :--- |
| `0001_01_01_000000_create_users_table.php` | `users`, `password_reset_tokens`, `sessions` | Core user identity, email unique |
| `0001_01_01_000001_create_cache_table.php` | `cache`, `cache_locks` | Framework cache |
| `0001_01_01_000002_create_jobs_table.php` | `jobs`, `job_batches`, `failed_jobs` | Framework queue |
| `2024_01_01_000000_create_passkeys_table.php` | `passkeys` | WebAuthn credentials |
| `2025_08_14_170933_add_two_factor_columns...` | `users` | 2FA secret, recovery codes |
| `2026_07_19_000000_create_iqarchive_core_tables.php` | `roles`, `colleges`, `programs`, `document_categories`, `documents`, `document_ocr_validations`, `document_reviews`, `instruments`, `compliance_requirements`, `accreditation_document_links`, `task_force_assignments`, `notifications`, `audit_logs`, `document_access_requests` | Foundation schema (14 domain tables) |
| `2026_07_20_171337_remove_faculty_member_role...` | `roles`, `users` | Purges deprecated role |
| `2026_07_27_175023_add_google_id_to_users...` | `users` | `google_id` column |
| `2026_07_28_000000_create_task_forces_tables.php` | `task_forces`, `task_force_members` | Re-architected task force subsystem |
| `2026_07_30_000001_create_role_user_table...` | `role_user` | M:N pivot table for multi-role support |
| `2026_08_04_000000_add_accreditation_level...` | `programs` | `accreditation_level` enum/string |
| `2026_08_04_000001_add_avatar_to_users_table.php` | `users` | Local avatar path |
| `2026_08_07_090000_create_self_survey_tables.php` | `self_survey_areas`, `self_survey_parameters`, `self_survey_indicators`, `self_survey_ratings` | Institutional self-survey subsystem (4 tables) |
| `2026_08_08_000000_add_google_avatar_to_users...` | `users` | Google profile picture URL |
| `2026_08_18_141902_create_offices_table.php` | `offices` | Institutional administrative units |
| `2026_08_18_141907_add_office_id_to_documents...` | `documents` | FK to `offices` |
| `2026_08_19_000000_refactor_roles_and_task_force...` | `roles`, `users` | Migrates legacy role IDs |
| `2026_08_19_000001_add_soft_deletes_to_colleges...`| `colleges`, `programs` | Adds `deleted_at` timestamp |
| `2026_08_19_000002_add_campus_column_to_colleges...`| `colleges` | Campus location string |
| `2026_08_23_141853_create_accreditations_table.php` | `accreditations` | Accreditation visit records |
| `2026_08_23_143657_add_proposed_members_to_accred...`| `accreditations` | Denormalized `proposed_members` JSON |
| `2026_08_23_150550_add_proposed_members_to_task...`| `task_forces` | Denormalized `proposed_members` JSON |
| `2026_08_24_000001_create_dynamic_instrument_tables.php` | `instrument_areas`, `instrument_parameters`, `instrument_criteria` | Re-architected dynamic instrument hierarchy |

---

### 3.2 Comparison with ERD Reference (`docs/reference/database-schema-erd.md`)

1. **Dead Schema Entity: `task_force_assignments`:**
   Created in [`2026_07_19_000000_create_iqarchive_core_tables.php:L90`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php#L90). It was superseded when [`2026_07_28_000000_create_task_forces_tables.php`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_07_28_000000_create_task_forces_tables.php) created `task_forces` and `task_force_members`. The table remains in the database and model relations exist, but no application logic uses it. It is missing from the global ERD diagram.
2. **Dual Instrument Subsystems in DB:**
   - Subsystem 1: `instruments`, `instrument_areas`, `instrument_parameters`, `instrument_criteria` (Dynamic AACCUP instruments).
   - Subsystem 2: `self_survey_areas`, `self_survey_parameters`, `self_survey_indicators`, `self_survey_ratings` (Institutional Self-Survey).
   The global ERD diagram illustrates Subsystem 1, but omits Subsystem 2 entirely.
3. **Triple Denormalization of Task Force Rosters:**
   Task force member associations are stored in three different formats concurrently:
   - Relational pivot table: `task_force_members` (`task_force_id`, `user_id`, `role_in_team`).
   - JSON column on `task_forces`: `task_forces.proposed_members`.
   - JSON column on `accreditations`: `accreditations.proposed_members`.
   This leads to synchronization drift between the relational table and the JSON arrays.

---

### 3.3 Missing Constraints, Indexes, and Soft Deletes

1. **No "One Active Accreditation" Constraint:**
   In [`database/migrations/2026_08_23_141853_create_accreditations_table.php`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_23_141853_create_accreditations_table.php), `program_id` is defined as a standard foreign key with NO unique constraint. There is no partial unique index on `(program_id, status)`. Furthermore, [`ScheduleAccreditation::save()`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php#L111) executes `Accreditation::create(...)` without querying for an existing active visit. The "one active accreditation per program" rule is completely un-enforced at both DB and application levels.
2. **Missing Indexes on High-Traffic Tables:**
   - `audit_logs`: [`2026_07_19_000000_create_iqarchive_core_tables.php:L109-L120`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php#L109-L120) has no indexes on `timestamp`, `action`, or `(target_type, target_id)`. The audit trail queries `where('action', ...)->orderBy('timestamp', 'desc')` which will degrade into full table scans.
   - `accreditations`: No index on `status`.
   - `documents`: No index on `status` or `category_id`.
3. **Missing Soft Deletes:**
   - [`colleges`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_19_000001_add_soft_deletes_to_colleges_and_programs_tables.php) and [`programs`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_19_000001_add_soft_deletes_to_colleges_and_programs_tables.php) have soft deletes.
   - However, [`documents`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php#L22-L33) and [`accreditations`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_23_141853_create_accreditations_table.php#L14-L22) lack soft deletes. Hard deleting records destroys historical audit trails and evidence linkages.

---

### Flags (Section 3)
- **[High]** "One active accreditation record per program" rule is NOT enforced at either the database layer (missing unique constraint) or application layer.
- **[High]** `documents` and `accreditations` lack `softDeletes()`, risking permanent compliance record loss on deletion.
- **[Medium]** Dead legacy table `task_force_assignments` remains in the schema.
- **[Medium]** `audit_logs` table lacks indexes on `timestamp`, `action`, and polymorphic targets (`target_type`, `target_id`).
- **[Medium]** Triple denormalization of task force rosters across `task_force_members`, `task_forces.proposed_members`, and `accreditations.proposed_members`.

---

## 4. Frontend Redundancy Audit

### 4.1 Blade View Summary
The frontend consists of **164 Blade view files** partitioned into `components/`, `flux/`, `layouts/`, `livewire/`, `pages/`, and `partials/`.

---

### 4.2 Near-Duplicate Components & Views

1. **Institutional vs. Program Accreditation Views:**
   The entire directory [`resources/views/pages/documents/partials/institutional-accreditation/`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/institutional-accreditation) is a near-identical duplicate of [`resources/views/pages/documents/partials/program-accreditation/`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/program-accreditation):
   - [`institutional-accreditation/self-survey-matrix.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/institutional-accreditation/self-survey-matrix.blade.php) vs [`program-accreditation/self-survey-matrix.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/program-accreditation/self-survey-matrix.blade.php): **99.5% identical (only 4 lines differ across the entire file)**.
   - `category-cards.blade.php`, `compliance-reports.blade.php`, and `supporting-docs.blade.php` duplicate breadcrumbs, tab styling, and grid layouts between institutional and program views rather than parameterizing a shared component.
2. **Audit Trail Views:**
   [`resources/views/livewire/iqa-admin/audit-trail.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/iqa-admin/audit-trail.blade.php) and [`resources/views/livewire/system-administrator/audit-trail.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/system-administrator/audit-trail.blade.php) are 100% duplicate files differing only by the placement of `text-slate-700` in a table body row.
3. **Accounts View Sharing Anomaly:**
   [`IqaAdmin/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/Accounts.php) and [`SystemAdministrator/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/SystemAdministrator/Accounts.php) both load [`resources/views/livewire/admin/accounts.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/admin/accounts.blade.php), yet maintain two separate controller implementations that do identical pagination, search, and validation.

---

### 4.3 Inconsistent Use of Flux UI vs. Hand-Rolled Markup

The UI displays a sharp divide between official Flux UI components and custom Tailwind markup:

1. **Modals:**
   - **15 modals** use `<flux:modal>` (e.g. [`schedule-accreditation.blade.php:L2`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/accreditation/schedule-accreditation.blade.php#L2), [`task-force/partials/create-modal.blade.php:L1`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/task-force/partials/create-modal.blade.php#L1), [`admin/partials/create-modal.blade.php:L1`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/admin/partials/create-modal.blade.php#L1)).
   - **18+ modals** use hand-rolled Alpine overlays: `<div x-show class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs ...">` (e.g. [`college-head/partials/instrument/modals/area-modal.blade.php:L3`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/college-head/partials/instrument/modals/area-modal.blade.php#L3), [`verification/modals/submit-to-iqa-modal.blade.php:L3`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/college-head/partials/verification/modals/submit-to-iqa-modal.blade.php#L3), [`common-documents/upload-modal.blade.php:L11`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/common-documents/upload-modal.blade.php#L11)).
2. **Buttons:**
   - Some views use `<flux:button>` but inject CSS variable hacks to force custom brand orange styling:
     e.g. [`configuration/partials/modals.blade.php:L34`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/partials/modals.blade.php#L34):
     `<flux:button variant="primary" style="--color-accent: var(--color-brand-orange); --color-accent-foreground: #ffffff;" ...>`
   - Other views bypass Flux entirely with hand-rolled buttons:
     `<button class="bg-primary-light text-white px-5 py-2.5 rounded-xl font-bold ...">`
3. **Form Inputs:**
   - Settings views use `<flux:input>`, `<flux:field>`, and `<flux:select>`.
   - Accreditation and document views use raw `<input class="w-full rounded-xl border-slate-200 focus:ring-brand-orange ...">`.

---

### Flags (Section 4)
- **[High]** Near-duplicate view duplication between `institutional-accreditation` and `program-accreditation` (including 99.5% identical `self-survey-matrix.blade.php`).
- **[High]** Duplicate audit trail views in [`livewire/iqa-admin/audit-trail.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/iqa-admin/audit-trail.blade.php) and [`livewire/system-administrator/audit-trail.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/system-administrator/audit-trail.blade.php).
- **[Medium]** Inconsistent modal patterns: 15 Flux modals vs. 18+ hand-rolled Alpine overlays.
- **[Low]** Inline CSS variable workarounds on `<flux:button>` to force brand colors.

---

## 5. Design System Compliance

### 5.1 Test Coverage Analysis (`tests/Feature/DesignSystemComplianceTest.php`)

[`tests/Feature/DesignSystemComplianceTest.php`](file:///c:/Users/janss/Herd/iqarchive/tests/Feature/DesignSystemComplianceTest.php) currently passes (1 test, 1 assertion):
- **What it checks:**
  - `FORBIDDEN_COLOR_PREFIXES`: `['gray', 'neutral', 'blue', 'orange']` preceded by utility prefixes (`bg-`, `text-`, `border-`, `ring-`, etc.).
  - `FORBIDDEN_UTILITY_PREFIXES`: `['bg', 'text', 'border', 'ring', 'from', 'via', 'to', 'divide', 'outline', 'decoration', 'placeholder', 'caret']`.
  - Hex values in utility brackets: `\b(utility)-\[#[0-9a-fA-F]{3,6}\]`.
  - Arbitrary font size brackets: `text-\[\d+px\]`.
  - Hardcoded exemptions list for 7 specific files/lines.
- **What it ignores (Blind Spots):**
  - **`slate` color palette is completely excluded from checking** (acknowledged in test comments as deferred debt).
  - Arbitrary brackets for spacing, sizing, radius, and blur (e.g. `min-h-[75vh]`, `rounded-[2.5rem]`, `backdrop-blur-[2px]`) are not evaluated.
  - Colors outside the 4 forbidden prefixes (e.g. raw `amber-*`, `red-*`, `green-*`, `emerald-*`, `yellow-*`) are permitted without checking against design tokens.
  - Raw hex codes inside inline `style="..."` attributes are not caught.

---

### 5.2 Scans of Views for Non-Tokenized Utilities

1. **`slate` Usage Count:**
   - Running regex scan `\bslate-\d+` across all Blade views yields **1,770 instances** of raw `slate` classes (e.g. `bg-slate-50`, `text-slate-600`, `border-slate-200/60`).
2. **Raw Hex Color Occurrences:**
   - **56 instances** of raw hex colors exist within Blade views. Examples:
     - [`welcome.blade.php:L59`](file:///c:/Users/janss/Herd/iqarchive/resources/views/welcome.blade.php#L59): `bg-[#7c3a00]`
     - Inline SVG logos, Chart.js palettes, and progress bars.
3. **Arbitrary Bracket Usage:**
   - **39 instances** of arbitrary bracket values exist in class strings. Examples:
     - [`welcome.blade.php:L33`](file:///c:/Users/janss/Herd/iqarchive/resources/views/welcome.blade.php#L33): `min-h-[75vh]`, `rounded-[2.5rem] md:rounded-[4rem]`, `leading-[1.1]`
     - [`dev-login.blade.php:L78`](file:///c:/Users/janss/Herd/iqarchive/resources/views/dev-login.blade.php#L78): `active:scale-[0.98]`
     - [`detail-drawer.blade.php:L13`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/detail-drawer.blade.php#L13): `backdrop-blur-[2px]`

---

### Flags (Section 5)
- **[Medium]** 1,770 instances of `slate-*` utilities bypass the semantic surface tokens defined in `token-mapping.md`.
- **[Low]** 39 arbitrary bracket classes (`rounded-[2.5rem]`, `min-h-[75vh]`, `backdrop-blur-[2px]`) bypass standard Tailwind v4 scale.
- **[Low]** `DesignSystemComplianceTest` has blind spots for non-color bracketed utilities and non-primary color utilities (`amber-*`, `emerald-*`).

---

## 6. External Interfaces / API Surface (Facts Only)

1. **`routes/api.php` Status:**
   - File does NOT exist.
   - No API routes are registered via Laravel's automatic `routes/api.php` discovery mechanism.
2. **API Authentication Packages:**
   - Neither `laravel/sanctum` nor `laravel/passport` is installed in [`composer.json`](file:///c:/Users/janss/Herd/iqarchive/composer.json).
   - No token authentication mechanisms (Bearer tokens, API keys, Personal Access Tokens) exist.
3. **Internal JSON Endpoints in `routes/web.php`:**
   - 16 routes prefixed with `api/` are declared in [`routes/web.php:L314-L343`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L314-L343) returning `JsonResponse` payloads:
     - `api/programs` (CRUD)
     - `api/colleges` (CRUD)
     - `api/offices`
     - `api/categories`
     - `api/common-documents` (CRUD & status updates)
     - `api/self-survey/*` (areas, ratings, best practices)
     - `api/accreditation/evidence/*` (upload, retrieve, submit-to-dean)
   - All 16 endpoints are wrapped by `Route::middleware(['auth', 'verified'])` and rely strictly on web session cookies and CSRF tokens for authentication. There are no public API endpoints and no webhooks.
4. **External Reviewer Access Pattern (ngrok):**
   - External AACCUP accreditors evaluate programs by accessing the standard web interface directly (e.g. through temporary tunnels such as ngrok or hosted domains).
   - Accreditor accounts authenticate through Google SSO (or local `/dev/login/accreditor` in development) and interact through browser sessions; there is no headless or programmatic third-party integration interface.

---

### Flags (Section 6)
- **[Low]** Internal AJAX endpoints use the `api/` URL prefix inside `routes/web.php` rather than standard web route naming conventions, which may cause confusion regarding expected auth mechanisms (session cookie vs. bearer token).

---

## 7. Summary of Flags

| Severity | File Path(s) | Description |
| :--- | :--- | :--- |
| **High** | [`routes/web.php:L311, L332`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L311) | Duplicate route name collision: both `submissions.storeDocument` and `categories.serve` claim name `'documents.serve'`. |
| **High** | [`AccreditationEvidenceController.php:L205, L260`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/AccreditationEvidenceController.php#L205), [`SubmissionController.php:L119, L130`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers/SubmissionController.php#L119) | Runtime bug: nullable/boolean return values passed directly to `basename()`, causing PHP 8.1+ deprecation warnings/errors. |
| **High** | [`database/migrations/2026_08_23_141853_create_accreditations_table.php`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_23_141853_create_accreditations_table.php), [`ScheduleAccreditation.php:L111`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Accreditation/ScheduleAccreditation.php#L111) | "One active accreditation per program" rule is not enforced at DB layer (missing unique constraint) or application code. |
| **High** | [`app/Providers/AppServiceProvider.php`](file:///c:/Users/janss/Herd/iqarchive/app/Providers/AppServiceProvider.php), [`app/Livewire/*`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire) | Inconsistent RBAC: mixing legacy single-role attribute (`$user->role`) with multi-role pivot (`$user->hasRole()`), risking lockout. |
| **High** | [`2026_07_19_000000_create_iqarchive_core_tables.php:L22`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php#L22), [`2026_08_23_141853_create_accreditations_table.php`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_23_141853_create_accreditations_table.php) | Missing `softDeletes()` on `documents` and `accreditations`, allowing permanent deletion of compliance records. |
| **High** | [`resources/views/pages/documents/partials/institutional-accreditation/`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/institutional-accreditation), [`.../program-accreditation/`](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/documents/partials/program-accreditation) | Severe frontend duplication: `self-survey-matrix.blade.php` is 99.5% identical between institutional and program views. |
| **High** | [`resources/views/livewire/iqa-admin/audit-trail.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/iqa-admin/audit-trail.blade.php), [`resources/views/livewire/system-administrator/audit-trail.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/system-administrator/audit-trail.blade.php) | 100% duplicate view markup between IQA Admin and System Administrator audit trails. |
| **Medium** | [`app/Livewire/IqaAdmin/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/Accounts.php), [`app/Livewire/SystemAdministrator/Accounts.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/SystemAdministrator/Accounts.php) | 95% identical code duplicated across two separate 500+ line Livewire components loading the same Blade view. |
| **Medium** | [`database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php:L90`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php#L90), [`TaskForceAssignment.php`](file:///c:/Users/janss/Herd/iqarchive/app/Models/TaskForceAssignment.php) | Dead schema table `task_force_assignments` remains in database and models, unreferenced by application logic. |
| **Medium** | [`database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php:L109-L120`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_07_19_000000_create_iqarchive_core_tables.php#L109-L120) | `audit_logs` lacks indexes on `timestamp`, `action`, and polymorphic targets (`target_type`, `target_id`). |
| **Medium** | [`database/migrations/2026_08_23_143657...`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_23_143657_add_proposed_members_to_accreditations.php), [`2026_08_23_150550...`](file:///c:/Users/janss/Herd/iqarchive/database/migrations/2026_08_23_150550_add_proposed_members_to_task_forces.php) | Triple denormalization of task force rosters: `task_force_members` pivot vs. `task_forces.proposed_members` JSON vs. `accreditations.proposed_members` JSON. |
| **Medium** | [`routes/settings.php:L12`](file:///c:/Users/janss/Herd/iqarchive/routes/settings.php#L12) | Dead route referencing non-existent view `pages::settings.appearance`. |
| **Medium** | [`app/Livewire/IqaAdmin/MatrixBuilder.php`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/IqaAdmin/MatrixBuilder.php), [`resources/views/livewire/iqa-admin/matrix-builder.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/iqa-admin/matrix-builder.blade.php) | Orphaned component and prototype view with hardcoded inputs, completely unreferenced in codebase. |
| **Medium** | [`resources/views/**/*.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views) | Modal design divergence: 15 Flux UI modals vs. 18+ hand-rolled Alpine overlay modals. |
| **Medium** | [`resources/views/**/*.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views) | 1,770 occurrences of `slate-*` classes bypass the design tokens in `token-mapping.md`. |
| **Low** | [`app/Http/Controllers/*`](file:///c:/Users/janss/Herd/iqarchive/app/Http/Controllers), [`app/Livewire/*`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire) | Manual `AuditLog::create()` duplicated in ~15 classes without a centralized logger service or trait. |
| **Low** | [`app/Console/Commands/`](file:///c:/Users/janss/Herd/iqarchive/app/Console/Commands), [`app/Livewire/Documents/`](file:///c:/Users/janss/Herd/iqarchive/app/Livewire/Documents), [`resources/views/livewire/documents/`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/documents) | Empty leftover directories. |
| **Low** | [`resources/views/**/*.blade.php`](file:///c:/Users/janss/Herd/iqarchive/resources/views) | 39 arbitrary bracket classes (`rounded-[2.5rem]`, `min-h-[75vh]`, `backdrop-blur-[2px]`) bypass the token spacing/radius scale. |
| **Low** | [`routes/web.php:L314-L343`](file:///c:/Users/janss/Herd/iqarchive/routes/web.php#L314-L343) | Internal AJAX routes prefixed with `api/` inside `routes/web.php` rely on session cookies without token infrastructure. |
| **Low** | [`resources/views/livewire/configuration/partials/modals.blade.php:L34`](file:///c:/Users/janss/Herd/iqarchive/resources/views/livewire/configuration/partials/modals.blade.php#L34) | Inline CSS variable style hacks on `<flux:button>` to force brand orange colors. |
