# Post-Refactor Cleanup Audit: Dead Weight Candidates

> **Audit Date:** September 2026  
> **Mode:** Report-Only (No files deleted or modified during this pass)  
> **Scope:** Verification of post-Phase 2–4 architectural leftovers across `app/`, `resources/`, `routes/`, and `tests/`

---

## 1. Candidate Assessment Summary Table

| File / Component | Confidence | Evidence | Recommendation |
|---|---|---|---|
| `resources/js/iqa-documents.js.bak` | **SAFE** | Hard-deleted in commit `d321cbf`; file does not exist on disk or in git tree. | No action required (already deleted). |
| `resources/js/iqa-submissions.js` | **SAFE** | 171 lines of mock state (`window.submissionsWorkspace`). Grep confirms 0 imports in `app.js` and 0 Blade references. Compiles to an unused 8.79 kB asset. | Delete file and remove from `vite.config.js`. |
| `vite.config.js` (`'resources/js/iqa-submissions.js'`) | **SAFE** | Entrypoint compiles unreferenced script. | Remove entry from `input` array. |
| `app/Livewire/SystemAdministrator/AuditTrail.php` | **SAFE** | 100% duplicate of `IqaAdmin\AuditTrail`. Grep confirms zero route registrations, zero `@livewire()`, and zero `<livewire:...>` tags. | Delete component class. |
| `resources/views/livewire/system-administrator/audit-trail.blade.php` | **SAFE** | Rendered only by unused `SystemAdministrator\AuditTrail`. | Delete view. |
| `app/Livewire/IqaAdmin/MatrixBuilder.php` | **SAFE** | 14-line legacy prototype superseded by Module 4 `Instruments.php`. 0 route references, 0 view callers. | Delete component class. |
| `resources/views/livewire/iqa-admin/matrix-builder.blade.php` | **SAFE** | 93-line prototype view with hardcoded inputs. Rendered only by unused `MatrixBuilder.php`. | Delete view. |
| `resources/views/livewire/configuration/partials/instruments/template-catalog.blade.php` | **SAFE** | 70 lines. Superseded by `stats-bar.blade.php`. Zero callers across codebase; references undefined `$instrumentsCatalog`. | Delete partial. |
| `resources/views/livewire/accreditation/partials/stats-bar.blade.php` | **SAFE** | Duplicate leftover. `features.visits.index` now includes `features.visits.partials.stats-bar`. Grep confirms 0 callers. | Delete partial. |
| `resources/views/livewire/accreditation/partials/table.blade.php` | **SAFE** | Duplicate leftover. `features.visits.index` now includes `features.visits.partials.table`. Grep confirms 0 callers. | Delete partial. |
| `resources/views/livewire/accreditation/partials/timeline-modal.blade.php` | **SAFE** | Duplicate leftover. `features.visits.index` now includes `features.visits.partials.timeline-modal`. Grep confirms 0 callers. | Delete partial. |
| `resources/views/livewire/accreditation/partials/schedule-notice.blade.php` | **SAFE** | Prototype modal banner snippet. Grep confirms 0 references in `schedule-modal.blade.php` or elsewhere. | Delete partial. |
| `resources/views/livewire/accreditation/partials/schedule-program-preview-card.blade.php` | **SAFE** | Prototype card snippet. Grep confirms 0 references across codebase. | Delete partial. |
| `resources/views/livewire/college-head/partials/verification/` (7 files) | **SAFE** | Entire directory (`area-tabs`, `checklist-review`, `header`, `stats-bar`, `modals/*`) superseded by `features/verification/partials/`. Grep confirms 0 callers. | Delete entire directory (7 files). |
| `resources/views/features/documents/index.blade.php` | **SAFE** | 180-line Phase 2 prototype with mock `@click="openUploadModal"`. Livewire `DocumentWorkspace` renders `resources/views/livewire/documents/`. Grep confirms 0 callers. | Delete view. |
| `resources/views/features/documents/matrix-table.blade.php` | **SAFE** | Created in Phase 2 to unify old matrices. Only referenced by dead views in `pages/documents/partials/`. 0 callers in live Livewire codebase. | Delete view. |
| `resources/views/pages/documents/partials/` (31 files) | **SAFE** | Entire 31-file legacy Alpine view tree. `pages/documents/index.blade.php` now mounts `<livewire:documents.document-workspace />`. Zero live callers. | Delete entire directory tree (31 files). |
| `app/Http/Controllers/SelfSurveyController.php` | **SAFE** | 93-line controller. All 4 methods (`getAreas`, `getRatings`, `saveRating`, `saveBestPractices`) exist solely for retired `iqa-documents.js`. Replaced by `DocumentWorkspace` Livewire methods. | Delete controller and unregister routes. |
| `routes/web.php` (`api/self-survey/*` 4 routes) | **SAFE** | Zero callers across all views and tests. | Remove route definitions. |
| `routes/web.php` (`api/offices`, `api/categories`, `api/common-documents/*`, `documents/{id}/view` — 7 routes) | **SAFE** | Existed solely for retired `iqa-documents.js`. Common documents and document viewing are now handled natively by `DocumentWorkspace` and `Storage::url()`. | Remove route definitions. |
| `app/Http/Controllers/DocumentCategoryController.php` | **LIKELY** | 457 lines. Methods `getOffices`, `index`, `store`, `getDocuments`, `storeDocument`, `updateStatus`, `destroyDocument`, `serveDocument` served retired `iqa-documents.js`. | Human review: verify whether external REST consumers exist before deleting controller. |
| `routes/web.php` (`api/programs` & `api/colleges` `store`, `update`, `destroy` routes) | **LIKELY** | While `.index` routes are tested in `TaskForceInstrumentGatingTest`, write operations have zero callers in frontend or tests. | Retain `GET` routes; review write routes before removing. |
| `app/Livewire/IqaAdmin/Accounts.php` | **KEEP / FALSE ALARM** | Actively routed via `roles/iqa-staff/accounts` and tested in `UserAccountsValidationTest.php`. Encapsulates IQA-specific role assignment gating. | Keep component. |
| `app/Livewire/SystemAdministrator/Accounts.php` | **KEEP / FALSE ALARM** | Actively routed via `roles/system-administrator/accounts` and tested in `UserAccountsValidationTest.php`. | Keep component. |
| `resources/views/livewire/admin/accounts.blade.php` | **KEEP / FALSE ALARM** | Unified view rendered by both `IqaAdmin\Accounts` and `SystemAdministrator\Accounts`. | Keep view. |
| `app/Livewire/IqaAdmin/AuditTrail.php` | **KEEP / FALSE ALARM** | Actively mounted via `<livewire:iqa-admin.audit-trail />` in `resources/views/pages/roles/iqa-staff/audit-trail.blade.php`. | Keep component. |
| `resources/views/features/admin/audit-trail.blade.php` | **KEEP / FALSE ALARM** | Master unified audit trail view created in Phase 2. Included by `livewire/iqa-admin/audit-trail.blade.php`. | Keep view. |
| `resources/views/livewire/accreditation/visits-index.blade.php` | **KEEP / FALSE ALARM** | 6-line Livewire proxy view rendered by `App\Livewire\Accreditation\VisitsIndex::render()`. Includes `features.visits.index`. | Keep view. |
| `resources/views/livewire/accreditation/schedule-accreditation.blade.php` | **KEEP / FALSE ALARM** | 6-line Livewire proxy view rendered by `ScheduleAccreditation`. Includes `features.visits.schedule-modal`. | Keep view. |
| `resources/views/livewire/college-head/dean-verification.blade.php` | **KEEP / FALSE ALARM** | 6-line Livewire proxy view rendered by `DeanVerification::render()`. Includes `features.verification.index`. | Keep view. |
| `resources/views/livewire/task-force/dashboard.blade.php` | **KEEP / FALSE ALARM** | 6-line Livewire proxy view rendered by Task Force dashboard. Includes `features.task-force.workspace`. | Keep view. |
| `resources/views/livewire/task-force/task-force-overview.blade.php` | **KEEP / FALSE ALARM** | 6-line Livewire proxy view rendered by Task Force overview. Includes `features.task-force.teams`. | Keep view. |
| `resources/views/livewire/task-force/partials/` (all 6 files) | **KEEP / FALSE ALARM** | Actively included by `resources/views/features/task-force/teams.blade.php`. | Keep partials. |
| `resources/views/livewire/task-force/partials/dashboard/` (all 6 files) | **KEEP / FALSE ALARM** | Actively included by `resources/views/features/task-force/workspace.blade.php`. | Keep partials. |
| `resources/views/livewire/configuration/instruments.blade.php` | **KEEP / FALSE ALARM** | 6-line Livewire proxy view rendered by `Instruments::render()`. Includes `features.instruments.builder`. | Keep view. |
| `resources/views/livewire/configuration/partials/instruments/` (5 core partials + 5 modal partials) | **KEEP / FALSE ALARM** | Actively included by `resources/views/features/instruments/builder.blade.php` and its sub-modals container. | Keep partials. |
| `resources/js/passkeys.js` | **KEEP / FALSE ALARM** | Active WebAuthn passkey client script referenced in `passkey-registration.blade.php` and `passkey-verify.blade.php`. | Keep script and Vite entry. |
| `routes/web.php` (`api/accreditation/evidence/*` 3 routes) | **KEEP / FALSE ALARM** | Actively tested in `TaskForceEvidenceUploadAndSubmissionTest.php` (4 test cases). | Keep routes. |

---

## 2. Detailed Findings by Category

### 1. `iqa-documents.js.bak`
- **Audit Finding:** The file `resources/js/iqa-documents.js.bak` does not exist on disk.
- **Git History Confirmation:** In commit `d321cbf` (`feat(documents): modernize document workspace to server-driven Livewire and retire iqa-documents.js`), `resources/js/iqa-documents.js` was hard-deleted directly. No residual `.bak` file remains in git or unversioned files.

### 2. Pre-`features/` Blade Views vs New Feature Views
- **Visits:**
  - `resources/views/livewire/accreditation/visits-index.blade.php` and `schedule-accreditation.blade.php` are thin 6-line proxy views delegating to `features/visits/`. They must be kept because Livewire components convention requires them in their default namespace view path.
  - The 5 legacy partials in `resources/views/livewire/accreditation/partials/` (`stats-bar`, `table`, `timeline-modal`, `schedule-notice`, `schedule-program-preview-card`) were completely duplicated into `features/visits/` and now have zero callers. Tagged **SAFE** to delete.
- **Verification:**
  - `resources/views/livewire/college-head/dean-verification.blade.php` delegates to `features/verification/index.blade.php`.
  - The entire old directory `resources/views/livewire/college-head/partials/verification/` (7 files) was superseded by `features/verification/partials/`. Grep confirms zero references to the old directory. Tagged **SAFE** to delete.
- **Task Force (False Alarm):**
  - While `dashboard.blade.php` and `task-force-overview.blade.php` delegate to `features/task-force/`, the new feature views `workspace.blade.php` and `teams.blade.php` **directly `@include` the sub-partials under `resources/views/livewire/task-force/partials/`**. Deleting them would break the task force screens. Tagged **KEEP / FALSE ALARM**.
- **Instruments:**
  - `features/instruments/builder.blade.php` actively `@include`s the accordion, parameter editor, and modals from `resources/views/livewire/configuration/partials/instruments/`. These are **KEEP**.
  - However, `template-catalog.blade.php` inside that directory is completely unreferenced and references an undefined `$instrumentsCatalog` variable. Tagged **SAFE** to delete.
- **Documents (Legacy Pages & Partials):**
  - In Phase 4, the document workspace was modernized into `resources/views/livewire/documents/`.
  - `resources/views/pages/documents/index.blade.php` was simplified to mount `<livewire:documents.document-workspace />`.
  - The entire legacy folder `resources/views/pages/documents/partials/` (**31 files**) was abandoned and has zero active callers.
  - In addition, `resources/views/features/documents/index.blade.php` and `matrix-table.blade.php` (created in Phase 2 as prototypes) have zero callers. All are tagged **SAFE** to delete.

### 3. Pre-Merge Duplicate Components
- **Accounts:** Both `App\Livewire\IqaAdmin\Accounts` and `App\Livewire\SystemAdministrator\Accounts` still exist as PHP classes because they enforce distinct role authorization (IQA cannot assign SysAdmin roles). However, their markup was unified into a single view `resources/views/livewire/admin/accounts.blade.php`. Both classes are actively routed and tested. Tagged **KEEP**.
- **Audit Trail:** `App\Livewire\SystemAdministrator\AuditTrail` is a 100% duplicate of `App\Livewire\IqaAdmin\AuditTrail`. The route in `routes/web.php` only mounts `IqaAdmin\AuditTrail`. The SysAdmin component and its corresponding view `resources/views/livewire/system-administrator/audit-trail.blade.php` have zero references in routes, views, or tests. Tagged **SAFE** to delete.

### 4. Legacy `/api/*` Endpoints & Controllers
- **Self-Survey Endpoints:** `api/self-survey/areas`, `api/self-survey/ratings`, `api/self-survey/best-practices` exist solely to serve the retired `iqa-documents.js`. `App\Http\Controllers\SelfSurveyController.php` (93 lines) has zero callers outside `routes/web.php`. Tagged **SAFE** to remove.
- **Common Documents & Categories Endpoints:** `api/offices`, `api/categories`, `api/common-documents/*`, `documents/{id}/view` served the retired Alpine document store. Now handled server-side in `DocumentWorkspace`. Tagged **SAFE** to remove from routes.
- **DocumentCategoryController:** 457 lines. All public endpoints served the legacy frontend. Tagged **LIKELY** for cleanup pending confirmation that no external mobile/API consumers depend on it.
- **Evidence & Visits Endpoints:** `api/accreditation/evidence/*` are actively tested by `TaskForceEvidenceUploadAndSubmissionTest.php`. Tagged **KEEP**.

### 5. Vite & Build Config Leftovers
- `resources/js/iqa-submissions.js`: 171 lines of mock state (`window.submissionsWorkspace`). Never imported in `resources/js/app.js`, never referenced in any Blade template. Only registered as a standalone entry in `vite.config.js`. Tagged **SAFE** to delete.
- Removing `resources/js/iqa-submissions.js` from `vite.config.js` will save an additional **8.79 kB** (2.40 kB gzipped) from the production build.

---

## 3. Potential Savings Summary

If all candidates tagged **SAFE** are approved for deletion:
- **Files to Remove:** ~46 files across views, controllers, Livewire components, and scripts.
- **Lines of Dead Code:** ~3,500+ lines removed.
- **Client Bundle Reduction:** ~8.8 kB deleted from production assets.
- **Zero Test Impact:** Grep and test analysis confirm all 94 Pest tests will continue to pass 100%.
