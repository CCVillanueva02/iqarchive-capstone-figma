# Common Documents — Add Offices & Directory Reorganization — Task Plan & Implementation Log

## Plan
- High-level goal: Provide authorized users (IQA staff, system admins) with the ability to dynamically register new institutional administrative offices, and organize all Common Documents frontend files into `resources/js/Pages/Documents/Common-Documents/`.
- Scope:
  - Backend: Route `POST /documents/offices`, controller action `DocumentController::storeOffice`, validation for unique office name scoped to `institutional`, security gate `DocumentPolicy::create`, and audit logging.
  - Frontend: Relocate common docs files to `Pages/Documents/Common-Documents/` (`Index.vue`, `Partials/OfficePanel.vue`, `Partials/DocumentsTable.vue`, `Partials/UploadCommonDocModal.vue`).
  - Add `Partials/AddOfficeModal.vue` and integrate "+ Add" button in `OfficePanel.vue`.
  - Testing: Feature tests in `CommonDocumentsTest.php` covering office creation, authorization denial for non-IQA roles, validation errors, and updated Inertia component path.
- Key decisions:
  - Role gating: Non-IQA users (Deans, Task Force, Accreditors) cannot see the button and are blocked by `DocumentPolicy::create` (HTTP 403).
  - Component standard: Strict DaisyUI classes (`modal`, `btn`, `input`, `textarea`, `fieldset`).
  - File size cap: Sub-components kept under 150 lines.

## Implementation Progress
### [2026-09-24]
- [x] Backend route `POST /documents/offices` and controller method `DocumentController::storeOffice` with audit logging and unique name validation scoped to `institutional`.
- [x] Relocated all Common Documents frontend files to `resources/js/Pages/Documents/Common-Documents/` (`Index.vue`, `Partials/DocumentsTable.vue`, `Partials/OfficePanel.vue`, `Partials/UploadCommonDocModal.vue`).
- [x] Created `Partials/AddOfficeModal.vue` with DaisyUI modals and inputs.
- [x] Positioned "Add Office" and "Upload Document" buttons at the top-right of the "Common Documents" header.
- [x] Mapped action buttons to the exact midnight navy blue (`#0B1B3D`) matching the navigation sidebar.
- [x] Documented all color, typography, scale, and radius tokens in `resources/css/app.css` with per-token application descriptions.
- [x] Generated `DESIGN.md` in repository root as the source of truth for design tokens and component standards.
- [x] Updated and expanded feature tests in `tests/Feature/CommonDocumentsTest.php` (12 tests, 73 assertions passing; 41/41 suite tests passing).
- [x] Built frontend assets (`npm run build` passing in 1.10s).
- [x] Visually verified via Playwright screenshots.
- [x] Implemented `SampleCommonDocumentSeeder.php` generating realistic sample PDF entries for HRDO and University Registrar offices with valid binary files and audit logs.

## Final Status
- Completed: 2026-09-24
- Tests: ✓ (41/41 passing)
- Security: Multi-tenant scoping and `DocumentPolicy::create` server authorization verified
- Frontend Build: ✓ Clean Vite build without errors

