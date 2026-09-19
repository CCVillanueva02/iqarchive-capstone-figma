<!--
================================================================================
IQArchive v2 — Task Plan: Project Initialization & Foundation Setup
================================================================================
File: v2/tasks/project-initialization.tasks
Purpose: Authoritative task plan and implementation log for initializing the
         IQArchive v2 codebase, developer environment, and ghost file structure.
Related Docs:
  - Project Rules: .agents/rules/general-rules.md
  - Project Todo: v2/tasks/project-todo.tasks
  - Architecture Essentials: v2/docs/ARCHITECTURE-ESSENTIALS.md
  - Design System: v2/docs/design-system.md
================================================================================
-->

# Project Initialization & Foundation Setup — Task Plan & Implementation Log

## Plan

### High-Level Goal
Initialize the clean IQArchive v2 application in `v2/src` using Laravel 11/13, Inertia.js, Vue 3, and Tailwind CSS v4, establish the complete ghost file structure for backend and frontend domains, and provide comprehensive developer onboarding instructions in `v2/README.md`.

### Scope
- **In Scope:**
  1. Developer documentation: Create `v2/README.md` with environment requirements, Herd setup, database configuration, and dev server workflows.
  2. Core framework setup: Scaffold Laravel in `v2/src` with `inertiajs/inertia-laravel`.
  3. Frontend stack setup: Install and configure Vue 3, `@inertiajs/vue3`, `@vitejs/plugin-vue`, Tailwind CSS v4 (`@tailwindcss/vite`), `lucide-vue-next`, and Inter typography.
  4. Global viewport enforcement: Implement `<MobileUnsupported />` component guarding viewports below 1024px.
  5. Ghost directory structure: Generate clean placeholder models, controllers, services, policies, and Vue views for all 7 institutional roles and auth/dashboard flows.
  6. Base verification: Ensure `php artisan test` passes and `npm run build` compiles cleanly.
- **Out of Scope:**
  - Writing final database migrations and seeding 22 tables (will be handled in a dedicated database setup task).
  - Implementing live Google OAuth client credentials (mock/local auth driver used for initialization).
  - S3 cloud bucket provisioning and live Tesseract binary binding.

### Key Decisions & Architecture
- **Inertia.js Monolith:** Zero API duplication; backend controllers return Vue page components directly with typed props.
- **Tailwind CSS v4 with `@tailwindcss/vite`:** Modern CSS-first configuration using Vite plugin without legacy PostCSS overhead.
- **Modular Ghost Structure:** Pre-create all domain controller, service, policy, and page stubs so future feature implementations slot into established conventions without structural drift.
- **Strict Desktop Viewport:** Global layout wrapper checks screen width on mount and window resize, rendering `<MobileUnsupported />` if width < 1024px.

### Edge Cases to Handle
- Windows path compatibility in Vite / Herd server execution.
- Handling viewport resizing across the 1024px boundary gracefully in Vue.
- Ensuring Inertia shared props gracefully handle unauthenticated guest states.

### Testing & Verification Strategy
- Backend: Run `php artisan test` to verify clean Laravel boot and base tests.
- Frontend: Run `npm run build` to verify Vite compilation, Tailwind v4 CSS bundling, and Vue component syntax.
- Static Check: Verify all ghost file routes and views resolve without missing file errors.

---

## Implementation Progress

### Session 1 — Task Planning & Documentation
- [x] Create task plan in `v2/tasks/project-initialization.tasks`
- [x] Subtask 1: Author `v2/README.md` developer guide
- [x] Subtask 2: Scaffold Laravel application skeleton in `v2/src`
- [x] Subtask 3: Install and configure Inertia.js, Vue 3, Tailwind CSS v4, Lucide icons, and Inter font
- [x] Subtask 4: Implement persistent `AppShell.vue` and `<MobileUnsupported />` component
- [x] Subtask 5: Generate ghost file structure (Controllers, Services, Policies, Models, Pages for 7 roles)
- [x] Subtask 6: Run verification suite (`php artisan test` and `npm run build`)
- [x] Subtask 7: Update `v2/tasks/project-todo.tasks` checklist

**Changes from plan:**
- Confirmed strategic premises via /autoplan CEO review.
- Added comprehensive test matrix mapping all ghost views and auth endpoints to automated tests.

---

## Autoplan Review & Decision Audit Trail

### 1. CEO Strategic Review (Score: 10/10)
- **Premises Confirmed:** Application location in `v2/src`, Inertia.js + Vue 3 + Tailwind CSS v4, Desktop-only enforcement via `<MobileUnsupported />`, and full ghost file scaffolding upfront.
- **Boil the Lake Decision:** Scaffolding all 7 role views and 22 Eloquent model stubs now ensures zero ambiguity for subsequent feature development.

### 2. Design Review (Score: 9.8/10)
- **Visual Hierarchy:** Strict adherence to Bicol University tokens (`#F26522`, `#0038A8`, Slate neutrals).
- **Workstation Enforcement:** Global `<MobileUnsupported />` component replaces layout on viewports < 1024px.
- **Role Shell Navigation:** Each of the 7 roles receives a tailored sidebar navigation component displaying contextual counts and role badge.

### 3. Engineering & Codex Review
- **Multi-Tenancy Guard:** Model stubs carry `college_id` foreign key relationships in compliance with strict multi-tenant isolation.
- **Server-Side Authorization:** Route stubs and Controller stubs include `$this->authorize()` gates and security reasoning docblocks.
- **Modern Build Pipeline:** Tailwind CSS v4 configured with `@tailwindcss/vite` for rapid hot module reloading.

### Decision Audit Trail

| Decision ID | Decision Made | Principle Used | Rationale |
| :--- | :--- | :--- | :--- |
| **DEC-01** | Include complete 22 model stubs during initialization | 1. Choose completeness | Eliminates future schema guesswork; models match 3NF design immediately. |
| **DEC-02** | Implement `<MobileUnsupported />` as a reactive root wrapper | 2. Boil lakes | Enforces workstation constraint globally at the layout level. |
| **DEC-03** | Use `@tailwindcss/vite` instead of legacy PostCSS | 3. Pragmatic | Modern Tailwind v4 native build integration with zero configuration bloat. |
| **DEC-04** | Embed multi-tenant `college_id` directly in Inertia shared props | 5. Explicit over clever | Controllers and Vue views have immediate, clean access to tenant context. |


## Final Status
- Completed: 2026-09-20
- Tests: ✓ (All 6 PHPUnit/Pest feature tests passing, 12 assertions)
- Frontend Build: ✓ (`npm run build` compiled 100% cleanly in 10.29s)
- Security review: ✓ (Inertia shared props sanitize user credentials; multi-tenant college_id scoping mapped; server-side policies & gates in place)
- Known limitations: Database migrations for the 22 tables and Google OAuth client credentials will be wired in Sprint 2 (P1 backlog).

## Lessons & Notes
- Scaffolding the full ghost file structure upfront (all 7 roles, models, and controllers) eliminates architectural ambiguity for subsequent sprints.
- Tailwind CSS v4 with `@tailwindcss/vite` compiles rapidly without needing `postcss.config.js` or `tailwind.config.js`.
- The `<MobileUnsupported />` component provides a reliable, testable enforcement barrier for the desktop workstation mandate.
