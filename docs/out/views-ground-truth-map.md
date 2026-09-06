<!--
    IQArchive Ground-Truth Audit: Views Directory Reference Map
    Architectural Role: Comprehensive reference mapping every Blade template under resources/views/ to its active references (routes, Livewire components, includes, layouts, and components).
    Security & Maintenance Context: Used as the foundational audit before conducting view restructuring or dead-code pruning.
-->

# Views Directory Ground-Truth Map

This document establishes the verified, ground-truth reference map of every Blade template (158 files total) within `resources/views/` in the IQArchive codebase. It records what actually calls or renders each file (routes, Livewire component `render()` methods, `@include` directives, `@extends` tags, `<livewire:...>` tags, and `<x-...>` component tags).

---

## 1. File-by-File Reference Table

| File Path | Status | Referenced By | Notes |
|---|---|---|---|
| `dev-components.blade.php` | **Orphan** | None | UI Component Kit Showcase page; no route or view references it. |
| `dev-login.blade.php` | **Live** | `routes/web.php:301` (`view('dev-login')`) | Interactive developer sandbox role-switcher login view, active in `local` and `testing` environments. |
| `welcome.blade.php` | **Live** | `routes/web.php:69` (`view('welcome', ...)`) | Main public landing page for IQArchive displaying live accreditation metrics, AACCUP overview, and FAQ. |
| `components/app-logo-icon.blade.php` | **Live** | `<x-app-logo-icon>` in `components/app-logo.blade.php`, `welcome.blade.php`, `pages/auth/login.blade.php`, `layouts/html.blade.php` | Brand SVG icon mark for Bicol University / IQArchive. |
| `components/app-logo.blade.php` | **Live** | `<x-app-logo>` in `layouts/app/header.blade.php`, `layouts/app/sidebar.blade.php`, `partials/header.blade.php` | Composite header/sidebar logo component. |
| `components/auth-header.blade.php` | **Orphan** | None | Starter-kit leftover component for auth headers; unused in custom login view. |
| `components/auth-session-status.blade.php` | **Live** | `<x-auth-session-status>` in `pages/auth/login.blade.php:30` | Session status message banner for authentication flows. |
| `components/desktop-user-menu.blade.php` | **Live** | `<x-desktop-user-menu>` in `layouts/app/header.blade.php:24` | Top desktop header user menu with role badge and logout dropdown. |
| `components/mobile-unsupported.blade.php` | **Live** | `<x-mobile-unsupported>` in `layouts/html.blade.php:12` | Full-screen workstation barrier enforcing desktop-only policy for screens `< 1024px`. |
| `components/placeholder-pattern.blade.php` | **Orphan** | None | Starter-kit SVG background mesh pattern; unused across the codebase. |
| `components/accreditation/⚡visits-index.blade.php` | **Orphan** | None | Unused boilerplate Livewire Volt stub (`<div />`). |
| `components/layouts/app.blade.php` | **Orphan** | None | Redundant wrapper stub leftover from scaffolding; views use `<x-layouts::app>` directly. |
| `components/monitoring/⚡schedule-accreditation.blade.php` | **Orphan** | None | Unused boilerplate Livewire Volt stub (`<div />`). |
| `components/ui/button.blade.php` | **Live** | `<x-ui.button>` across `features/admin/accounts.blade.php`, `features/verification/index.blade.php`, `features/visits/index.blade.php`, etc. | Canonical atomic UI button design token component. |
| `components/ui/document-chip.blade.php` | **Live** | `<x-ui.document-chip>` in `livewire/documents/partials/common-documents.blade.php`, `livewire/documents/partials/program/supporting-documents.blade.php` | Atomic UI chip displaying uploaded document metadata and preview triggers. |
| `components/ui/filter-bar.blade.php` | **Live** | `<x-ui.filter-bar>` in `dev-components.blade.php`, `features/verification/partials/checklist-review.blade.php` | Standardized filter and search bar component. |
| `components/ui/modal.blade.php` | **Orphan** | None | Generic `<flux:modal>` wrapper; views implement `<flux:modal>` directly. |
| `components/ui/page-header.blade.php` | **Live** | `<x-ui.page-header>` in `features/admin/accounts.blade.php`, `features/admin/audit-trail.blade.php`, `dev-components.blade.php` | Standardized page header with breadcrumbs and action slots. |
| `components/ui/stat-card.blade.php` | **Live** | `<x-ui.stat-card>` in `features/admin/accounts.blade.php`, `features/verification/partials/stats-bar.blade.php`, `features/visits/partials/stats-bar.blade.php` | Metric KPI card with change indicator. |
| `components/ui/status-badge.blade.php` | **Live** | `<x-ui.status-badge>` in `features/verification/partials/checklist-review.blade.php`, `features/visits/partials/table.blade.php` | Status pill badge component for compliance and accreditation states. |
| `components/ui/table-empty.blade.php` | **Live** | `<x-ui.table-empty>` in `features/visits/partials/table.blade.php:79` | Standardized empty state table row. |
| `components/ui/table.blade.php` | **Live** | `<x-ui.table>` in `features/verification/partials/checklist-review.blade.php`, `features/visits/partials/table.blade.php` | Standardized table container with header/body wrappers. |
| `features/admin/accounts.blade.php` | **Live** | `@include('features.admin.accounts')` in `livewire/admin/accounts.blade.php:5` | Implementation view for Accounts Management; includes 6 `livewire.admin.partials.*` files. |
| `features/admin/audit-trail.blade.php` | **Live** | `@include('features.admin.audit-trail')` in `livewire/iqa-admin/audit-trail.blade.php:5` | Implementation view for System Audit Trail and login activity logs. |
| `features/instruments/builder.blade.php` | **Live** | `@include('features.instruments.builder')` in `livewire/configuration/instruments.blade.php:5` | Master AACCUP Instruments Builder view; includes 5 `livewire.configuration.partials.instruments.*` files. |
| `features/task-force/teams.blade.php` | **Live** | `@include('features.task-force.teams')` in `livewire/task-force/task-force-overview.blade.php:5` | Task force roster, college assignments, and creation management UI. |
| `features/task-force/workspace.blade.php` | **Live** | `@include('features.task-force.workspace')` in `livewire/task-force/dashboard.blade.php:5` | Task force member area matrix workspace and revision review portal. |
| `features/verification/index.blade.php` | **Live** | `@include('features.verification.index')` in `livewire/college-head/dean-verification.blade.php:5` | Dean evidence verification & quality control portal root view. |
| `features/verification/partials/area-tabs.blade.php` | **Live** | `@include('features.verification.partials.area-tabs')` in `features/verification/index.blade.php:10` | Horizontal area tab selector for dean verification. |
| `features/verification/partials/checklist-review.blade.php` | **Live** | `@include('features.verification.partials.checklist-review')` in `features/verification/index.blade.php:13` | Parameter checklist review table with accept/flag controls. |
| `features/verification/partials/header.blade.php` | **Live** | `@include('features.verification.partials.header')` in `features/verification/index.blade.php:4` | Dean verification header banner and program context info. |
| `features/verification/partials/modals.blade.php` | **Live** | `@include('features.verification.partials.modals')` in `features/verification/index.blade.php:16` | Modals for evidence flagging, feedback review, and approval confirmation. |
| `features/verification/partials/stats-bar.blade.php` | **Live** | `@include('features.verification.partials.stats-bar')` in `features/verification/index.blade.php:7` | KPI stats bar for verified vs pending criteria count. |
| `features/visits/index.blade.php` | **Live** | `@include('features.visits.index')` in `livewire/accreditation/visits-index.blade.php:5` | Accreditation visits index page with visit history table and scheduling action. |
| `features/visits/schedule-modal.blade.php` | **Live** | `@include('features.visits.schedule-modal')` in `livewire/accreditation/schedule-accreditation.blade.php:5` | Modal dialog for scheduling a new accreditation visit. |
| `features/visits/partials/stats-bar.blade.php` | **Live** | `@include('features.visits.partials.stats-bar')` in `features/visits/index.blade.php:29` | Summary KPI cards for total visits, active evaluations, completed visits. |
| `features/visits/partials/table.blade.php` | **Live** | `@include('features.visits.partials.table')` in `features/visits/index.blade.php:52` | Accreditation visits data table with status badges and actions. |
| `features/visits/partials/timeline-modal.blade.php` | **Live** | `@include('features.visits.partials.timeline-modal')` in `features/visits/index.blade.php:55` | Detailed visit timeline and phase progress tracking modal. |
| `flux/icon/book-open-text.blade.php` | **Orphan** | None | Published Livewire Flux icon; unused. |
| `flux/icon/chevrons-up-down.blade.php` | **Uncertain** | Dynamically referenced via `icon:trailing="chevrons-up-down"` in `components/desktop-user-menu.blade.php:6` | Flux resolves icon blade components by name matching at runtime. |
| `flux/icon/folder-git-2.blade.php` | **Orphan** | None | Published Livewire Flux icon; unused. |
| `flux/icon/layout-grid.blade.php` | **Orphan** | None | Published Livewire Flux icon; unused. |
| `flux/navlist/group.blade.php` | **Orphan** | None | Published Livewire Flux navlist group component; navigation uses custom markup instead. |
| `layouts/app.blade.php` | **Live** | `#[Layout('layouts.app')]` in `DeanVerification.php`, `DocumentWorkspace.php`; `MonitoringOverview.php:219`; `<x-layouts::app>` in all role dashboards (`pages/roles/*`) | Master desktop application shell with persistent sidebar and top navigation. |
| `layouts/app/header.blade.php` | **Live** | `<x-layouts::app.header>` in `layouts/app.blade.php:97` | Desktop application header with user menu and search trigger. |
| `layouts/app/sidebar.blade.php` | **Live** | `<x-layouts::app.sidebar>` in `layouts/app.blade.php:14` | Persistent desktop sidebar wrapper enclosing `<livewire:sidebar />`. |
| `layouts/app/sidebar/administration-nav.blade.php` | **Live** | `@include('layouts.app.sidebar.administration-nav')` in `livewire/sidebar.blade.php:75` | Administration tier navigation links (Accounts, Audit Trail, Configuration). |
| `layouts/app/sidebar/operations-nav.blade.php` | **Live** | `@include('layouts.app.sidebar.operations-nav')` in `livewire/sidebar.blade.php:72` | Operations tier navigation links (Visits, Monitoring, Task Forces). |
| `layouts/app/sidebar/profile-footer.blade.php` | **Live** | `@include('layouts.app.sidebar.profile-footer')` in `livewire/sidebar.blade.php:80` | User profile footer at bottom of sidebar with role badge and logout action. |
| `layouts/app/sidebar/workspace-nav.blade.php` | **Live** | `@include('layouts.app.sidebar.workspace-nav')` in `livewire/sidebar.blade.php:69` | Workspace tier navigation links (Dashboard, Documents, Submissions). |
| `layouts/auth.blade.php` | **Orphan** | None | Starter-kit base auth layout; `pages/auth/login.blade.php` uses `<x-layouts::html>` directly. |
| `layouts/auth/card.blade.php` | **Orphan** | None | Starter-kit card-style auth layout; unused. |
| `layouts/auth/simple.blade.php` | **Orphan** | None | Starter-kit simple auth layout; unused. |
| `layouts/auth/split.blade.php` | **Orphan** | None | Starter-kit split-screen auth layout; unused. |
| `layouts/html.blade.php` | **Live** | `<x-layouts::html>` in `layouts/app.blade.php:7`, `welcome.blade.php:1`, `pages/auth/login.blade.php:1` | Foundational HTML root wrapper (`<html>`, `<head>`, `<body>`) with fonts, CSRF, and scripts. |
| `livewire/sidebar.blade.php` | **Live** | `<livewire:sidebar />` in `layouts/app/sidebar.blade.php:7`; `App\Livewire\Sidebar::render()` | Reactive SPA navigation shell for the desktop workstation sidebar. |
| `livewire/accreditation/schedule-accreditation.blade.php` | **Live** | `App\Livewire\Accreditation\ScheduleAccreditation::render()`; `@livewire('accreditation.schedule-accreditation')` in `features/visits/index.blade.php:58` | Livewire component view delegating to `features.visits.schedule-modal`. |
| `livewire/accreditation/visits-index.blade.php` | **Live** | `App\Livewire\Accreditation\VisitsIndex::render()`; `routes/web.php:253` (`visits.index`) | Livewire component view delegating to `features.visits.index`. |
| `livewire/admin/accounts.blade.php` | **Live** | `App\Livewire\IqaAdmin\Accounts::render()`; `App\Livewire\SystemAdministrator\Accounts::render()` | Livewire component view delegating to `features.admin.accounts`. |
| `livewire/admin/partials/accounts-filter.blade.php` | **Live** | `@include('livewire.admin.partials.accounts-filter')` in `features/admin/accounts.blade.php:43` | Search, role filter, and college filter controls for accounts management. |
| `livewire/admin/partials/accounts-header.blade.php` | **Orphan** | None | Superseded by inline `<x-ui.page-header>` in `features/admin/accounts.blade.php`. |
| `livewire/admin/partials/accounts-table.blade.php` | **Live** | `@include('livewire.admin.partials.accounts-table')` in `features/admin/accounts.blade.php:46` | Data table displaying institutional user accounts. |
| `livewire/admin/partials/create-modal.blade.php` | **Live** | `@include('livewire.admin.partials.create-modal')` in `features/admin/accounts.blade.php:52` | Modal dialog for registering a single institutional user. |
| `livewire/admin/partials/delete-modal.blade.php` | **Live** | `@include('livewire.admin.partials.delete-modal')` in `features/admin/accounts.blade.php:58` | Modal confirmation for deleting an account. |
| `livewire/admin/partials/edit-modal.blade.php` | **Live** | `@include('livewire.admin.partials.edit-modal')` in `features/admin/accounts.blade.php:55` | Modal dialog for updating user details and affiliations. |
| `livewire/admin/partials/quick-tf-modal.blade.php` | **Live** | `@include('livewire.admin.partials.quick-tf-modal')` in `features/admin/accounts.blade.php:49` | Modal for bulk pre-registering task force members. |
| `livewire/college-head/dashboard.blade.php` | **Live** | `App\Livewire\CollegeHead\Dashboard::render()`; `<livewire:college-head.dashboard>` in `pages/roles/college-head/dashboard.blade.php` | Dean's dashboard view hosting accreditation status tables and metrics. |
| `livewire/college-head/dean-verification.blade.php` | **Live** | `App\Livewire\CollegeHead\DeanVerification::render()`; `routes/web.php:273` (`accreditation.verify`) | Livewire component view delegating to `features.verification.index`. |
| `livewire/college-head/instrument-customization.blade.php` | **Live** | `App\Livewire\CollegeHead\InstrumentCustomization::render()`; `routes/web.php:269` (`accreditation.instrument`) | Master view for dean program-specific instrument customization (Stage 4). |
| `livewire/college-head/task-force-setup.blade.php` | **Uncertain** | `App\Livewire\CollegeHead\TaskForceSetup::render()` | Component class exists with full render logic, but is not bound to any route or parent template. |
| `livewire/college-head/partials/action-required.blade.php` | **Live** | `@include('livewire.college-head.partials.action-required')` in `livewire/college-head/dashboard.blade.php:20` | Action required notice card for pending task force setups on dean dashboard. |
| `livewire/college-head/partials/college-banner.blade.php` | **Live** | `@include('livewire.college-head.partials.college-banner')` in `livewire/college-head/dashboard.blade.php:14` | Dean dashboard college title banner with accreditation summary pill. |
| `livewire/college-head/partials/history-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.history-modal')` in `livewire/college-head/dashboard.blade.php:35` | Historical accreditation visits log modal for dean dashboard. |
| `livewire/college-head/partials/kpi-metrics.blade.php` | **Live** | `@include('livewire.college-head.partials.kpi-metrics')` in `livewire/college-head/dashboard.blade.php:17` | Summary KPI cards for dean's college programs. |
| `livewire/college-head/partials/monitoring-programs-table.blade.php` | **Live** | `@include('livewire.college-head.partials.monitoring-programs-table')` in `livewire/college-head/dashboard.blade.php:26` | Monitoring table for non-scheduled programs in college. |
| `livewire/college-head/partials/programs-table.blade.php` | **Live** | `@include('livewire.college-head.partials.programs-table')` in `livewire/college-head/dashboard.blade.php:23` | Active scheduled accreditation programs table on dean dashboard. |
| `livewire/college-head/partials/propose-tf-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.propose-tf-modal')` in `livewire/college-head/dashboard.blade.php:29` | Modal dialog for dean proposing task force members. |
| `livewire/college-head/partials/timeline-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.timeline-modal')` in `livewire/college-head/dashboard.blade.php:32` | Program accreditation lifecycle timeline modal. |
| `livewire/college-head/partials/instrument/area-accordion.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.area-accordion')` in `livewire/college-head/instrument-customization.blade.php:12` | Area accordion tree selector in dean instrument customization. |
| `livewire/college-head/partials/instrument/areas-tabs.blade.php` | **Orphan** | None | Superseded by `area-accordion.blade.php`. |
| `livewire/college-head/partials/instrument/header.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.header')` in `livewire/college-head/instrument-customization.blade.php:3` | Dean instrument customization header with breadcrumbs and finalize trigger. |
| `livewire/college-head/partials/instrument/modals.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.modals')` in `livewire/college-head/instrument-customization.blade.php:20` | Root modals wrapper for dean instrument customization. |
| `livewire/college-head/partials/instrument/parameter-editor.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.parameter-editor')` in `livewire/college-head/instrument-customization.blade.php:15` | Parameter and criteria editor pane in dean instrument customization. |
| `livewire/college-head/partials/instrument/parameter-view.blade.php` | **Orphan** | None | Superseded by `parameter-editor.blade.php`. |
| `livewire/college-head/partials/instrument/stats-bar.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.stats-bar')` in `livewire/college-head/instrument-customization.blade.php:6` | Total areas, parameters, criteria summary count bar. |
| `livewire/college-head/partials/instrument/modals/area-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.modals.area-modal')` in `livewire/college-head/partials/instrument/modals.blade.php:2` | Modal dialog for creating/editing an area. |
| `livewire/college-head/partials/instrument/modals/criterion-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.modals.criterion-modal')` in `livewire/college-head/partials/instrument/modals.blade.php:4` | Modal dialog for adding/editing a criterion requirement. |
| `livewire/college-head/partials/instrument/modals/delete-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.modals.delete-modal')` in `livewire/college-head/partials/instrument/modals.blade.php:6` | Modal confirmation for deleting an instrument node. |
| `livewire/college-head/partials/instrument/modals/finalize-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.modals.finalize-modal')` in `livewire/college-head/partials/instrument/modals.blade.php:5` | Confirmation dialog for locking and finalizing customized instrument. |
| `livewire/college-head/partials/instrument/modals/parameter-modal.blade.php` | **Live** | `@include('livewire.college-head.partials.instrument.modals.parameter-modal')` in `livewire/college-head/partials/instrument/modals.blade.php:3` | Modal dialog for adding/editing a parameter. |
| `livewire/configuration/colleges-programs.blade.php` | **Live** | `App\Livewire\Configuration\CollegesPrograms::render()`; `routes/web.php:261` (`configuration.colleges-programs`) | Master Colleges & Programs configuration management view. |
| `livewire/configuration/instruments.blade.php` | **Live** | `App\Livewire\Configuration\Instruments::render()`; `routes/web.php:265` (`configuration.instruments`) | Livewire component view delegating to `features.instruments.builder`. |
| `livewire/configuration/partials/detail-programs.blade.php` | **Live** | `@include('livewire.configuration.partials.detail-programs')` in `livewire/configuration/colleges-programs.blade.php:42` | Programs list pane for selected college in configuration. |
| `livewire/configuration/partials/filter-bar.blade.php` | **Live** | `@include('livewire.configuration.partials.filter-bar')` in `livewire/configuration/colleges-programs.blade.php:30` | Search and level filters for colleges configuration. |
| `livewire/configuration/partials/master-directory.blade.php` | **Live** | `@include('livewire.configuration.partials.master-directory')` in `livewire/configuration/colleges-programs.blade.php:37` | Colleges list directory pane in configuration. |
| `livewire/configuration/partials/modals.blade.php` | **Live** | `@include('livewire.configuration.partials.modals')` in `livewire/configuration/colleges-programs.blade.php:59` | College and program CRUD modals. |
| `livewire/configuration/partials/stats-bar.blade.php` | **Live** | `@include('livewire.configuration.partials.stats-bar')` in `livewire/configuration/colleges-programs.blade.php:27` | Total colleges and programs KPI cards. |
| `livewire/configuration/partials/instruments/area-accordion.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.area-accordion')` in `features/instruments/builder.blade.php:12` | Area accordion tree selector in master instruments builder. |
| `livewire/configuration/partials/instruments/header.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.header')` in `features/instruments/builder.blade.php:3` | Master instruments builder header and template selector. |
| `livewire/configuration/partials/instruments/modals.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.modals')` in `features/instruments/builder.blade.php:57` | Root modals wrapper for master instruments builder. |
| `livewire/configuration/partials/instruments/parameter-editor.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.parameter-editor')` in `features/instruments/builder.blade.php:15` | Parameter and criteria editor pane in master instruments builder. |
| `livewire/configuration/partials/instruments/stats-bar.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.stats-bar')` in `features/instruments/builder.blade.php:6` | Master instrument metric stats bar. |
| `livewire/configuration/partials/instruments/modals/area-modal.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.modals.area-modal')` in `livewire/configuration/partials/instruments/modals.blade.php:4` | Modal dialog for adding/editing areas in master builder. |
| `livewire/configuration/partials/instruments/modals/criterion-modal.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.modals.criterion-modal')` in `livewire/configuration/partials/instruments/modals.blade.php:6` | Modal dialog for adding/editing criteria in master builder. |
| `livewire/configuration/partials/instruments/modals/delete-modal.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.modals.delete-modal')` in `livewire/configuration/partials/instruments/modals.blade.php:7` | Confirmation modal for deleting instrument components in master builder. |
| `livewire/configuration/partials/instruments/modals/parameter-modal.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.modals.parameter-modal')` in `livewire/configuration/partials/instruments/modals.blade.php:5` | Modal dialog for adding/editing parameters in master builder. |
| `livewire/configuration/partials/instruments/modals/template-modal.blade.php` | **Live** | `@include('livewire.configuration.partials.instruments.modals.template-modal')` in `livewire/configuration/partials/instruments/modals.blade.php:3` | Modal dialog for creating new instrument template. |
| `livewire/documents/document-workspace.blade.php` | **Live** | `App\Livewire\Documents\DocumentWorkspace::render()`; `routes/web.php:207` (`documents.{role}`) | Root document repository workspace view. |
| `livewire/documents/partials/common-documents.blade.php` | **Live** | `@include('livewire.documents.partials.common-documents')` in `livewire/documents/document-workspace.blade.php:21` | Common university-wide documents panel. |
| `livewire/documents/partials/header.blade.php` | **Live** | `@include('livewire.documents.partials.header')` in `livewire/documents/document-workspace.blade.php:16` | Document workspace navigation header and tab switches. |
| `livewire/documents/partials/institutional-accreditation.blade.php` | **Live** | `@include('livewire.documents.partials.institutional-accreditation')` in `livewire/documents/document-workspace.blade.php:25` | Institutional accreditation documents repository panel. |
| `livewire/documents/partials/program-accreditation.blade.php` | **Live** | `@include('livewire.documents.partials.program-accreditation')` in `livewire/documents/document-workspace.blade.php:23` | Program-specific accreditation document workspace panel. |
| `livewire/documents/partials/modals/detail-drawer.blade.php` | **Live** | `@include('livewire.documents.partials.modals.detail-drawer')` in `livewire/documents/document-workspace.blade.php:32` | Slide-over drawer displaying document details, audit log, and file preview. |
| `livewire/documents/partials/modals/upload-common-modal.blade.php` | **Live** | `@include('livewire.documents.partials.modals.upload-common-modal')` in `livewire/documents/document-workspace.blade.php:30` | Modal dialog for uploading common institutional documents. |
| `livewire/documents/partials/modals/upload-evidence-modal.blade.php` | **Live** | `@include('livewire.documents.partials.modals.upload-evidence-modal')` in `livewire/documents/document-workspace.blade.php:31` | Modal dialog for uploading evidence linked to accreditation criteria. |
| `livewire/documents/partials/program/compliance-reports.blade.php` | **Live** | `@include('livewire.documents.partials.program.compliance-reports')` in `livewire/documents/partials/program-accreditation.blade.php:197` | Compliance reports sub-tab view in document workspace. |
| `livewire/documents/partials/program/narrative-profile.blade.php` | **Live** | `@include('livewire.documents.partials.program.narrative-profile')` in `livewire/documents/partials/program-accreditation.blade.php:199` | Narrative profile sub-tab view in document workspace. |
| `livewire/documents/partials/program/self-survey.blade.php` | **Live** | `@include('livewire.documents.partials.program.self-survey')` in `livewire/documents/partials/program-accreditation.blade.php:195` | Self-survey document sub-tab view in document workspace. |
| `livewire/documents/partials/program/supporting-documents.blade.php` | **Live** | `@include('livewire.documents.partials.program.supporting-documents')` in `livewire/documents/partials/program-accreditation.blade.php:193` | Supporting evidence documents grid with parameter selector. |
| `livewire/iqa-admin/audit-trail.blade.php` | **Live** | `App\Livewire\IqaAdmin\AuditTrail::render()`; `<livewire:iqa-admin.audit-trail />` in `pages/roles/iqa-staff/audit-trail.blade.php:10` | Livewire component view delegating to `features.admin.audit-trail`. |
| `livewire/monitoring/monitoring-overview.blade.php` | **Live** | `App\Livewire\Monitoring\MonitoringOverview::render()`; `routes/web.php:90` (`monitoring.index`) | Root monitoring overview view hosting tabs and college cards. |
| `livewire/monitoring/partials/dashboard-tab.blade.php` | **Live** | `@include('livewire.monitoring.partials.dashboard-tab')` in `livewire/monitoring/monitoring-overview.blade.php:17` | Summary dashboard tab displaying accreditation benchmarks and college rankings. |
| `livewire/monitoring/partials/history-modal.blade.php` | **Live** | `@include('livewire.monitoring.partials.history-modal')` in `livewire/monitoring/monitoring-overview.blade.php:25` | Historical accreditation visits log modal for monitoring view. |
| `livewire/monitoring/partials/monitoring-college-card.blade.php` | **Live** | `@include('livewire.monitoring.partials.monitoring-college-card', ...)` in `livewire/monitoring/partials/programs-tab.blade.php:47` | Individual college card with programs accreditation breakdown. |
| `livewire/monitoring/partials/programs-tab.blade.php` | **Live** | `@include('livewire.monitoring.partials.programs-tab')` in `livewire/monitoring/monitoring-overview.blade.php:21` | Programs monitoring tab displaying college cards list. |
| `livewire/monitoring/partials/summary-tab.blade.php` | **Live** | `@include('livewire.monitoring.partials.summary-tab')` in `livewire/monitoring/monitoring-overview.blade.php:19` | Summary table report with program accreditation status breakdown. |
| `livewire/task-force/dashboard.blade.php` | **Live** | `App\Livewire\TaskForce\TaskForceDashboard::render()`; `<livewire:task-force.task-force-dashboard>` in `pages/roles/task-force-member/dashboard.blade.php:4` | Livewire component view delegating to `features.task-force.workspace`. |
| `livewire/task-force/task-force-overview.blade.php` | **Live** | `App\Livewire\TaskForce\TaskForceOverview::render()`; `routes/web.php:257` (`task-forces.index`) | Livewire component view delegating to `features.task-force.teams`. |
| `livewire/task-force/partials/create-modal.blade.php` | **Live** | `@include('livewire.task-force.partials.create-modal')` in `features/task-force/teams.blade.php:22` | Modal dialog for creating a new task force team. |
| `livewire/task-force/partials/filter-toolbar.blade.php` | **Live** | `@include('livewire.task-force.partials.filter-toolbar')` in `features/task-force/teams.blade.php:9` | Search and filter toolbar for task force management. |
| `livewire/task-force/partials/header.blade.php` | **Live** | `@include('livewire.task-force.partials.header')` in `features/task-force/teams.blade.php:3` | Task force management page header. |
| `livewire/task-force/partials/roster-modal.blade.php` | **Live** | `@include('livewire.task-force.partials.roster-modal')` in `features/task-force/teams.blade.php:25` | Modal dialog showing members roster for a task force. |
| `livewire/task-force/partials/stats-row.blade.php` | **Live** | `@include('livewire.task-force.partials.stats-row')` in `features/task-force/teams.blade.php:6` | Task force team and member KPI cards. |
| `livewire/task-force/partials/task-force-cards.blade.php` | **Live** | `@include('livewire.task-force.partials.task-force-cards')` in `features/task-force/teams.blade.php:12` | Grid cards of all active task force teams. |
| `livewire/task-force/partials/dashboard/area-matrix.blade.php` | **Live** | `@include('livewire.task-force.partials.dashboard.area-matrix')` in `features/task-force/workspace.blade.php:26` | 10-Area accreditation progress matrix table on member dashboard. |
| `livewire/task-force/partials/dashboard/header.blade.php` | **Live** | `@include('livewire.task-force.partials.dashboard.header')` in `features/task-force/workspace.blade.php:14` | Task force member workspace header banner. |
| `livewire/task-force/partials/dashboard/recent-reviews.blade.php` | **Live** | `@include('livewire.task-force.partials.dashboard.recent-reviews')` in `features/task-force/workspace.blade.php:31` | Recent feedback and document reviews panel. |
| `livewire/task-force/partials/dashboard/revisions-banner.blade.php` | **Live** | `@include('livewire.task-force.partials.dashboard.revisions-banner')` in `features/task-force/workspace.blade.php:17` | Banner highlighting flagged items requiring revisions. |
| `livewire/task-force/partials/dashboard/stats-row.blade.php` | **Live** | `@include('livewire.task-force.partials.dashboard.stats-row')` in `features/task-force/workspace.blade.php:20` | Member workspace KPI cards (uploaded, approved, flagged). |
| `livewire/task-force/partials/dashboard/modals/submit-to-dean-modal.blade.php` | **Live** | `@include('livewire.task-force.partials.dashboard.modals.submit-to-dean-modal')` in `features/task-force/workspace.blade.php:36` | Confirmation modal for submitting completed area evidence to Dean. |
| `pages/auth/login.blade.php` | **Live** | `routes/web.php:82` (`view('pages.auth.login')`) | Custom authentication login view with Google SSO and password form. |
| `pages/documents/index.blade.php` | **Orphan** | None | Wrapper view containing `<livewire:documents.document-workspace />`; routes bind directly to the Livewire class instead. |
| `pages/roles/accreditor/submission.blade.php` | **Live** | `routes/web.php:126` (`view('pages.roles.accreditor.submission')`) | AACCUP Accreditor submission evaluation workbench view. |
| `pages/roles/college-head/dashboard.blade.php` | **Live** | `routes/web.php:200` (`view('pages.roles.college-head.dashboard')`) | Dean dashboard route view rendering `<livewire:college-head.dashboard>`. |
| `pages/roles/iqa-staff/audit-trail.blade.php` | **Live** | `routes/web.php:234` (`view('pages.roles.iqa-staff.audit-trail')`) | IQA staff audit trail route view rendering `<livewire:iqa-admin.audit-trail />`. |
| `pages/roles/iqa-staff/dashboard.blade.php` | **Live** | `routes/web.php:201` (`view('pages.roles.iqa-staff.dashboard')`) | IQA Staff & Admin executive dashboard view. |
| `pages/roles/system-administrator/dashboard.blade.php` | **Live** | `routes/web.php:198` (`view('pages.roles.system-administrator.dashboard')`) | System Administrator dashboard view with system health and accounts links. |
| `pages/roles/task-force-member/dashboard.blade.php` | **Live** | `routes/web.php:199` (`view('pages.roles.task-force-member.dashboard')`) | Task Force Member dashboard route view rendering `<livewire:task-force.task-force-dashboard>`. |
| `pages/roles/university-administrator/analytics.blade.php` | **Live** | `routes/web.php:146` (`view('pages.roles.university-administrator.analytics')`) | Executive University Administrator institutional analytics dashboard. |
| `pages/settings/⚡delete-user-form.blade.php` | **Live** | `<livewire:pages::settings.delete-user-form />` in `pages/settings/⚡profile.blade.php:380` | Livewire single-file component for delete user trigger button. |
| `pages/settings/⚡delete-user-modal.blade.php` | **Live** | `<livewire:pages::settings.delete-user-modal />` in `pages/settings/⚡delete-user-form.blade.php:19` | Livewire single-file component modal for account deletion confirmation. |
| `pages/settings/⚡profile.blade.php` | **Live** | `routes/settings.php:8` (`Route::livewire('settings/profile', 'pages::settings.profile')`) | User profile settings page managing name, email, profile photo, and password. |
| `pages/settings/layout.blade.php` | **Live** | `<x-pages::settings.layout>` in `pages/settings/⚡profile.blade.php:181` | Settings layout wrapper with settings navigation list. |
| `pages/workspace/placeholder.blade.php` | **Live** | `routes/web.php:120, 166, 210, 217, 224` | Reusable placeholder screen for in-progress role workspaces (Submissions, Reports, Settings). |
| `partials/footer.blade.php` | **Live** | `@include('partials.footer')` in `welcome.blade.php`, `pages/auth/login.blade.php`, `layouts/app.blade.php` | Global institutional copyright and accreditation footer. |
| `partials/head.blade.php` | **Live** | `@include('partials.head', ['title' => $title])` in `layouts/html.blade.php:9` | Shared HTML `<head>` block containing meta tags, title, and Vite asset directives. |
| `partials/header.blade.php` | **Live** | `@include('partials.header')` in `welcome.blade.php`, `pages/auth/login.blade.php` | Public and authentication top navigation bar with logo and portal links. |
| `partials/settings-heading.blade.php` | **Live** | `@include('partials.settings-heading')` in `pages/settings/⚡profile.blade.php:177` | Header title block for account settings pages. |

---

## 2. Ambiguous-Pair Resolutions

### 1. `features/admin/accounts.blade.php` vs `livewire/admin/accounts.blade.php`
**Resolution:** **Both files are LIVE** (Confidence: **100%**).  
This pair represents an intentional clean-architecture delegation refactor rather than duplicate code. `App\Livewire\IqaAdmin\Accounts` and `App\Livewire\SystemAdministrator\Accounts` both invoke `return view('livewire.admin.accounts')`. The `livewire/admin/accounts.blade.php` file acts as a thin wrapper that executes `@include('features.admin.accounts')`. In turn, `features/admin/accounts.blade.php` renders the primary page layout and pulls in the sub-partials (`livewire.admin.partials.accounts-filter`, `accounts-table`, `quick-tf-modal`, `create-modal`, `edit-modal`, and `delete-modal`). Neither file is dead; both form an active execution chain.

### 2. `features/admin/audit-trail.blade.php` vs `livewire/iqa-admin/audit-trail.blade.php`
**Resolution:** **Both files are LIVE** (Confidence: **100%**).  
Like Pair 1, this follows the identical delegation pattern. The route `audit-trail.iqa-staff` loads `pages.roles.iqa-staff.audit-trail`, which renders the component tag `<livewire:iqa-admin.audit-trail />`. The component class `App\Livewire\IqaAdmin\AuditTrail` returns `view('livewire.iqa-admin.audit-trail')`. Inside `livewire/iqa-admin/audit-trail.blade.php`, the only directive is `@include('features.admin.audit-trail')`. The file `features/admin/audit-trail.blade.php` contains the full UI for search filters, session activity logs, model mutation diffs, and pagination. Neither file is dead.

### 3. `features/instruments/builder.blade.php` vs `livewire/configuration/partials/instruments/*` vs `livewire/college-head/partials/instrument/*`
**Resolution:** **Distinct active features sharing similar domains, with two dead legacy partials** (Confidence: **100%**).  
These directories represent two completely different business workflows in the accreditation lifecycle:
1. `features/instruments/builder.blade.php` is the UI for the **Master AACCUP Instruments Builder** (Module 4, route `/configuration/instruments`), called via `livewire/configuration/instruments.blade.php`. It directly includes all five partials in `livewire/configuration/partials/instruments/*` (`area-accordion`, `header`, `modals`, `parameter-editor`, `stats-bar`, plus the 5 modal partials). Every file in this configuration group is **Live**.
2. `livewire/college-head/partials/instrument/*` belongs to the **Dean's Program-Specific Instrument Customization** (Dean Stage 4, route `/accreditation/{accreditation}/instrument`), loaded by `livewire/college-head/instrument-customization.blade.php`.
Within this Dean directory, two orphaned files exist: `areas-tabs.blade.php` and `parameter-view.blade.php` are **Dead/Orphans** (they were an earlier horizontal tabbed/pane prototype superseded by the accordion and parameter editor currently included on lines 12 and 15 of `instrument-customization.blade.php`). All other files in `livewire/college-head/partials/instrument/*` are **Live**.

### 4. `features/visits/*` (index, schedule-modal, partials) vs `livewire/accreditation/{schedule-accreditation,visits-index}.blade.php`
**Resolution:** **Both are LIVE** (Confidence: **100%**).  
There is no duplication; this is another intentional delegation pairing. `App\Livewire\Accreditation\VisitsIndex` renders `view('livewire.accreditation.visits-index')`, which runs `@include('features.visits.index')`. `features/visits/index.blade.php` then includes its three partials (`stats-bar`, `table`, and `timeline-modal`), and mounts `@livewire('accreditation.schedule-accreditation')`. That component's view `livewire/accreditation/schedule-accreditation.blade.php` delegates to `@include('features.visits.schedule-modal')`. Every file in `features/visits/*` and both files in `livewire/accreditation/*` are actively executing in production.

### 5. `features/verification/index.blade.php` (+ partials) vs `livewire/college-head/dean-verification.blade.php`
**Resolution:** **Both are LIVE** (Confidence: **100%**).  
The route `/accreditation/{accreditation}/verify` executes `App\Livewire\CollegeHead\DeanVerification`, which returns `view('livewire.college-head.dean-verification')`. That view delegates directly via `@include('features.verification.index')`. `features/verification/index.blade.php` serves as the root container, modularly including all five partials in `features/verification/partials/` (`header`, `stats-bar`, `area-tabs`, `checklist-review`, and `modals`). All files in this tree are **Live**.

### 6. Top-Level Loose Files: `dev-components.blade.php`, `dev-login.blade.php`, `welcome.blade.php`
**Resolution:** **Two Live, One Orphan** (Confidence: **100%**).  
- `welcome.blade.php` is **Live** (Confidence: 100%). It is not a stock Laravel leftover; it is a heavily customized, branded Bicol University IQArchive landing page displaying real-time program accreditation level distributions, FAQs, and institutional copy, served by `Route::get('/', ...)->name('home')`.
- `dev-login.blade.php` is **Live** (Confidence: 100%). It is served by `Route::get('/dev', ...)->name('dev.index')` in local/testing environments as the official sandbox role-switching console.
- `dev-components.blade.php` is an **Orphan** (Confidence: 100%). It contains a complete component showcase page for atomic UI tokens, but zero routes in `routes/web.php` point to it (presumably intended for an unrouted `/dev/components` developer view).

---

## 3. Organizing Conventions by Top-Level Folder

1. **`components/`** — **Atomic UI & Composite Component-first**: Houses reusable atomic design tokens (`ui/*` such as buttons, badges, tables) and shared global composites (`app-logo`, `desktop-user-menu`, `mobile-unsupported`).
2. **`features/`** — **Domain/Feature-first**: Organizes core business application domains (`admin/`, `instruments/`, `task-force/`, `verification/`, `visits/`) containing clean-architecture presentation views and their sub-partials.
3. **`flux/`** — **Vendor/UI Kit-override-first**: Vendor override directory published from the `livewire/flux` component library, containing published icon assets (`flux/icon/*`) and navlist group overrides.
4. **`layouts/`** — **Structural Shell-first**: Organizes application shell hierarchy (`html.blade.php` base wrapper, `app.blade.php` desktop shell with persistent sidebar/header, and starter-kit `auth/*` templates).
5. **`livewire/`** — **Role & Module-first**: Mirrors the Livewire component class hierarchy (`livewire/{domain-or-role}/*`), functioning as stateful view controllers and partial repositories that frequently delegate presentation to `features/`.
6. **`pages/`** — **Route & Role-first**: Mirrors the URI routing and user authorization tiers (`pages/auth/*`, `pages/roles/{role}/*`, `pages/settings/*`, `pages/workspace/*`), acting as route endpoints that embed layout shells and Livewire components.
7. **`partials/`** — **Global Shared Slice-first**: Houses top-level site layout partials (`head`, `header`, `footer`, `settings-heading`) shared between marketing, authentication, and layout shells.
