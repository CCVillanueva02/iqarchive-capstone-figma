<!--
================================================================================
IQArchive v2 — Task Plan: 22-Table 3NF Database Migrations & Schema Setup
================================================================================
File: v2/tasks/database-schema-migrations.tasks
Purpose: Authoritative task plan and implementation log for creating and
         verifying all 22 database migrations matching v2/docs/db-design/database-design.md.
Related Docs:
  - Relational Database Design: v2/docs/db-design/database-design.md
  - Architecture Essentials: v2/docs/ARCHITECTURE-ESSENTIALS.md
  - Engineering Backlog: v2/TODOS.md
================================================================================
-->

# 22-Table 3NF Database Schema Migrations — Task Plan & Implementation Log

## Plan

### High-Level Goal
Implement all 22 database migrations for MySQL 8 in strict 3rd Normal Form (3NF) matching `v2/docs/db-design/database-design.md`, establishing foreign keys, multi-tenant `college_id` indexes, unique constraints, and JSON column metrics.

### Scope
- **In Scope:**
  1. Zone 1: Multi-Tenancy & Access Control (`colleges`, `programs`, `users` update/scoping, `roles`, `user_roles`, `audit_logs`, `notifications`).
  2. Zone 2: AACCUP Instrument Hierarchy (`instruments`, `instrument_areas`, `instrument_parameters`, `instrument_criteria`).
  3. Zone 3: Accreditation Pipeline & Task Forces (`task_forces`, `task_force_members`, `accreditations`, `accreditation_stage_histories`, `compliance_requirements`, `compliance_comments`).
  4. Zone 4: Documents & OCR Engine (`document_categories`, `documents`, `accreditation_document_links`, `ocr_results`, `document_reviews`).
  5. Alignment of Eloquent Models with exact table names, casts, and relationships.
  6. Automated migration and rollback testing (`php artisan migrate:fresh`).
- **Out of Scope:**
  - Mock seed data for all 10 BU colleges (will be handled in a dedicated seeder task).
  - Tesseract binary execution.

### Key Decisions & Architecture
- **Foreign Key Dependency Ordering:** Migrations must execute in strict topological order to prevent unresolved foreign key references.
- **Strict Multi-Tenant Indexing:** Index `college_id` on all tenant tables for instant scoping.
- **Immutable Audit Trail:** `audit_logs` has no updated_at column; append-only compliance logging.
- **MySQL 8 Native JSON:** `details`, `confidence_metrics`, and `pages_data` use native MySQL `JSON` column types.

### Edge Cases to Handle
- SQLite in-memory test compatibility vs MySQL 8 strict types (using standard Laravel schema blueprint methods that work seamlessly across MySQL and SQLite).
- Ensuring user table migrations update the default Laravel users table with `college_id`, `google_id`, `role`, and `status`.
- Foreign key cascade deletions vs restricted deletions on audit logs.

### Testing Strategy
- Automated migration verification: `php artisan migrate:fresh` runs cleanly with zero syntax or constraint errors.
- Schema assertion test: Feature test asserting that all 22 tables exist with expected columns.
- Rollback test: `php artisan migrate:rollback` rolls back cleanly without orphan dependencies.

---

## Implementation Progress

### Session 1 — Planning & Autoplan Review
- [x] Create task plan in `v2/tasks/database-schema-migrations.tasks`
- [x] Subtask 1: Create Zone 1 migrations (Multi-Tenancy & Access Control)
- [x] Subtask 2: Create Zone 2 migrations (AACCUP Instrument Hierarchy)
- [x] Subtask 3: Create Zone 3 migrations (Accreditation Pipeline & Task Forces)
- [x] Subtask 4: Create Zone 4 migrations (Documents, OCR Results & Reviews)
- [x] Subtask 5: Update and align Eloquent models with exact table column definitions
- [x] Subtask 6: Run automated migration verification (`php artisan migrate:fresh` and schema assertions)
- [x] Subtask 7: Update `v2/TODOS.md` backlog

## Final Status
- Completed: 2026-09-20
- Tests: ✓ (9 passed, 60 assertions, php artisan test)
- Migrations: ✓ (22 tables migrated and verified reversible via migrate:fresh and rollback)
- Security review: ✓ (Multi-tenant college_id indexed on tenant tables; strict FK cascades; immutable audit trail)
- PR/Commits:
  - `e7884f9`: feat(migrations): create Zone 1 multi-tenancy and access control tables
  - `76845fa`: feat(migrations): create Zone 2 AACCUP survey instrument hierarchy tables
  - `cbbd358`: feat(migrations): create Zone 3 accreditation pipeline and task force tables
  - `29c73fd`: fix(migrations): drop unique index before dropping column in users table down migration
  - `d352631`: feat(migrations): create Zone 4 document evidence and OCR results tables
  - (pending commit): feat(models): align 22 Eloquent models with 3NF schema and add schema tests
- Known limitations: None.

## Lessons & Notes
- SQLite down migration caveat: When dropping columns that hold unique constraints during a rollback, dropping the unique index explicitly avoids SQLite ALTER TABLE errors.
- Clean 1-to-1 model mapping: Having exactly 22 models matching 22 tables directly clarifies data relationships across all 4 zones.
