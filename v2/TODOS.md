<!--
================================================================================
IQArchive v2 — Engineering Backlog & Priorities
================================================================================
File: v2/TODOS.md
Purpose: Prioritized backlog of technical milestones and feature implementations.
Governance: Autoplan pipeline & .agents/rules/general-rules.md
================================================================================
-->

# IQArchive v2 — Engineering Backlog

## P0 — Immediate Foundation (Current Sprint)
- [x] **BOOT-01: Developer Onboarding Guide:** Create `v2/README.md` with complete instructions for PHP 8.4, Composer, Node, MySQL, and Herd setup.
- [x] **BOOT-02: Framework Scaffolding:** Initialize Laravel in `v2/src` with `inertiajs/inertia-laravel`.
- [x] **BOOT-03: Frontend Toolchain:** Install Vue 3, `@inertiajs/vue3`, `@vitejs/plugin-vue`, Tailwind CSS v4 (`@tailwindcss/vite`), `lucide-vue-next`, and `@fontsource/inter`.
- [x] **BOOT-04: Viewport Guard:** Implement `<MobileUnsupported />` component enforcing `>= 1024px` desktop requirement.
- [x] **BOOT-05: Ghost Architecture:** Scaffold 22 Eloquent models, core controllers, services, policies, and Vue views for 7 institutional roles.
- [x] **BOOT-06: Verification:** Ensure `php artisan test` passes and `npm run build` compiles cleanly.

## P1 — Core Infrastructure & Security (Sprint 2)
- [x] **SEC-01: Database Migrations:** Implement 22 tables matching the strict 3NF schema in `v2/docs/db-design/database-design.md`.
- [x] **SEC-02: Multi-Tenancy Scoping:** Create `CollegeScoped` global Eloquent scope enforcing `college_id` filtering on all tenant queries.
- [x] **SEC-03: Google Workspace OAuth:** Implement Socialite Google SSO restricted to `@bicol-u.edu.ph` email domain with JIT user provisioning.
- [ ] **SEC-04: RBAC & Policies:** Enforce the 7 institutional roles and Dean Lead contextual elevation across all controller actions.

## P2 — Accreditation Workflows & Features (Sprint 3)
- [ ] **DOC-01: Document Management (MOD-01):** Program, Institutional, and Common Document repositories with private S3 storage and 15-minute temporary pre-signed URLs.
- [ ] **DOC-02: Two-Tier Approval Engine:** College Dean endorsement gate $\rightarrow$ IQA consolidation gate.
- [ ] **OCR-01: Assistive OCR Pipeline:** Tesseract OCR text extraction from accreditation certificates with split-screen human-in-the-loop review.
- [ ] **PIPE-01: Accreditation State Machine:** 9-stage lifecycle management driven exclusively by IQA Staff.
- [ ] **NOTIF-01: Deadline & Notification Engine:** Milestone reminders, dean review alerts, and upcoming survey countdowns.
