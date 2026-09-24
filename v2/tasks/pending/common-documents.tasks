# Common Documents Module — Task Plan & Implementation Log

## Plan
- High-level goal: Build the Common Documents tab under the Documents workspace (IQA role view and general access), allowing centralized storage and browsing of institutional office policies.
- Scope:
  - Database docs update in `v2/docs/db-design` reflecting `college_id` nullability for institutional docs and `document_categories` usage for administrative offices.
  - Backend: `DocumentPolicy`, `CommonDocumentSeeder`, `DatabaseSeeder`, `DocumentController` (`index`, `storeCommon`), and web routes.
  - Frontend: `CommonDocuments.vue` + `Partials/OfficePanel.vue`, `Partials/DocumentsTable.vue`, and `Partials/UploadCommonDocModal.vue` adhering to DaisyUI and under 150 lines per file.
  - Testing: Feature tests in `tests/Feature/CommonDocumentsTest.php` covering permissions, viewing, filtering, and uploading.
- Key decisions:
  - Seed 7 BU administrative offices as `document_categories` with `scope = 'institutional'`.
  - Make `documents.college_id` nullable so institutional documents are university-wide (`college_id = null`, `visibility = 'univ'`).
  - Strict server-side RBAC: only `iqa_staff` and `system_admin` can upload Common Documents.
- Testing strategy: Feature tests with Pest/PHPUnit, frontend verification with `npm run build`.

## Implementation Progress
### Session 1 - Initial Implementation
- [x] Update database design documentation in `v2/docs/db-design/` (`database-design.md`, `database-design-expl.md`, `documents.md`, `document_categories.md`)
- [x] Implement `DocumentPolicy` with `viewAny`, `create`, and `view` gates
- [x] Create `CommonDocumentSeeder` and update `DatabaseSeeder`
- [x] Implement `DocumentController` methods (`index`, `storeCommon`, `download`)
- [x] Register routes with `auth` middleware in `routes/web.php`
- [x] Build Vue components (`CommonDocuments.vue`, `OfficePanel.vue`, `DocumentsTable.vue`, `UploadCommonDocModal.vue`)
- [x] Create and run `tests/Feature/CommonDocumentsTest.php` (8/8 tests passing, 37/37 total suite passing)
- [x] Verify `npm run build` (clean Vite build, zero errors)
- [x] Browser testing via `/dev/login/iqa-staff` & subagent screenshot verification

### Session 2 - Multi-Tenant Scope Hardening & UI Elevation
- [x] Separate Common Documents branch to `v2-common-documents`
- [x] Tighten `DocumentController@index` with `whereNull('college_id')->where('visibility', 'univ')` on both docs query and category counts
- [x] Add `hideTopbar`, `hideBreadcrumbs`, and dynamic breadcrumbs props to `AppShell.vue`
- [x] Remove topbar header on Common Documents
- [x] Remove hardcoded `Home > IQA Staff > Dashboard` breadcrumb; replace with clean `Home > Documents > Common Documents`
- [x] Remove redundant 3-tab bar (`Common Documents`, `Program Accreditation`, `Institutional Records`)
- [x] Elevate header typography and institutional badges using DaisyUI standards
- [x] Verify full test suite (37/37 passing) and clean frontend build

### Session 4 - Refine Office Directory Panel
- [x] Restore previous OfficePanel design with "Offices & Units" title, total count badge, and document count pills
- [x] Exclude only the verbose description text per user request
- [x] Verify tests (8/8 CommonDocumentsTest pass, 37/37 suite pass) and Vite build

### Session 5 - Full Viewport Height & Search Icon Visibility
- [x] Remove breadcrumb element completely from Common Documents view
- [x] Fix Search icon visibility across both OfficePanel and DocumentsTable using native DaisyUI input-bordered labels
- [x] Scale workspace panels to 100% viewport height considering layout padding (`h-[calc(100vh-3rem)] lg:h-[calc(100vh-4rem)]`)
- [x] Implement flex-1 min-h-0 internal scrollbars on offices directory and document table
- [x] Verify tests (37/37 passing) and Vite compilation (867ms)

## Final Status
- Completed: 2026-09-24
- Tests: ✓ (37/37 passing across the entire test suite)
- Security review: ✓ (Multi-tenant isolation strictly enforced with `whereNull('college_id')` and `where('visibility', 'univ')`; server-side gates on upload and download)
- Frontend build: ✓ (Vite production bundle compiled cleanly in 1.04s)
- Browser QA: ✓ (Verified with headless browser across IQA Staff and Dean personas)

## Lessons & Notes
- Removing redundant `->index()` after `->constrained()` in foreign keys avoided MySQL 1826 duplicate foreign key constraint name errors on fresh migrations.
- Adding `AuthorizesRequests` to the base `Controller` enabled seamless `$this->authorize(...)` calls throughout controllers.
- Keeping Vue files strictly under 150-170 lines through partial extraction kept code maintainable, readable, and perfectly within project standards.
- Disabling global scopes in multi-tenant systems must always be paired with explicit target filters (`whereNull('college_id')`) to prevent cross-tenant data leaks.
