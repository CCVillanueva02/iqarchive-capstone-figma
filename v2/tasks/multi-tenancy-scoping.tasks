<!--
================================================================================
IQArchive v2 — Task Plan: Multi-Tenancy Scoping (SEC-02)
================================================================================
File: v2/tasks/multi-tenancy-scoping.tasks
Purpose: Authoritative task plan and implementation log for creating and
         verifying the CollegeScoped global Eloquent scope, BelongsToCollege
         concern, MultiTenantScopeService, and multi-tenancy test matrix.
Related Docs:
  - Relational Database Design: v2/docs/db-design/database-design.md
  - Architecture Essentials: v2/docs/ARCHITECTURE-ESSENTIALS.md
  - Engineering Backlog: v2/TODOS.md
================================================================================
-->

# Multi-Tenancy Scoping (SEC-02) — Task Plan & Implementation Log

## Plan

### High-Level Goal
Implement strict multi-tenancy scoping via a global Eloquent scope (`CollegeScoped`), a reusable `BelongsToCollege` model trait, and a centralized `MultiTenantScopeService` aligned with the 7 institutional roles, ensuring zero cross-tenant data leakage.

### Scope
- **In Scope:**
  1. `App\Models\Scopes\CollegeScoped`: Global scope enforcing `college_id` filtering when a college-scoped user is authenticated.
  2. `App\Models\Concerns\BelongsToCollege`: Trait applying `CollegeScoped`, defining the `college()` relationship, and auto-populating `college_id` on creation.
  3. Apply `BelongsToCollege` to tenant entities: `Program`, `Document`, `AuditLog`.
  4. Refactor `MultiTenantScopeService` to evaluate user roles from the 3NF `roles` structure (`system_admin`, `iqa_staff`, `bu_executive` vs college-locked roles).
  5. Refactor policies (`ProgramPolicy`, `DocumentPolicy`, `AccreditationPolicy`) to leverage `MultiTenantScopeService` and `$user->hasRole()`.
  6. Automated feature test suite (`tests/Feature/MultiTenancyScopeTest.php`) verifying tenant isolation, role bypasses, and auto-population.
- **Out of Scope:**
  - Google OAuth Socialite handshake (deferred to `SEC-03`).
  - Full UI file preview (deferred to `DOC-01`).

### Key Decisions & Architecture
- **Global Scope vs Per-Query Where Clauses:** Global scope guarantees that queries on `Program`, `Document`, and `AuditLog` are automatically scoped to the user's `college_id` without requiring developer memory on every single Eloquent query.
- **Bypass for University-Wide Staff:** `system_admin`, `iqa_staff`, and `bu_executive` bypass the `college_id` filter because their regulatory mandate spans all 10 BU colleges.
- **Explicit Unscoped Access:** Standard Laravel `withoutGlobalScope(CollegeScoped::class)` is available for administrative consolidation routines when executed with explicit authorization.
- **Auto-Population on Creation:** If an authenticated college user creates a tenant record without specifying `college_id`, `BelongsToCollege` automatically stamps their `college_id`.

### Edge Cases to Handle
- Unauthenticated CLI / Seeder / Queue execution: When `auth()->check()` is false, do not filter by null `college_id` unless an explicit tenant context is set.
- Dual-role Dean (Dean + Task Force Lead): Remains locked to their own college.
- Attempted cross-tenant injection: If a college user passes `college_id = 99` in request input, `BelongsToCollege` overrides or policy aborts.

### Testing Strategy
- Feature test asserting that User in College A cannot see Documents or Programs of College B.
- Feature test asserting that IQA Staff / SysAdmin can see Documents and Programs across both College A and College B.
- Feature test asserting that creating a Document automatically sets `college_id`.
- Feature test asserting that `withoutGlobalScope(CollegeScoped::class)` retrieves all records.

---

## Implementation Progress

### Session 1 — Implementation & Verification
- [x] Subtask 1: Create `CollegeScoped` global Eloquent scope
- [x] Subtask 2: Create `BelongsToCollege` model trait and apply to tenant models
- [x] Subtask 3: Update `MultiTenantScopeService` to use 3NF roles
- [x] Subtask 4: Update authorization policies to use `MultiTenantScopeService`
- [x] Subtask 5: Create and run comprehensive `MultiTenancyScopeTest`
- [x] Subtask 6: Update `v2/TODOS.md` backlog

## Final Status
- Completed: 2026-09-20
- Tests: ✓ (17 passed, 94 assertions across test suite)
- Security review: ✓ (CollegeScoped global scope auto-scopes queries; BelongsToCollege auto-stamps tenant college_id; policies check boundaries; cross-tenant leakage blocked)
- PR/Commits: (pending commit) feat(security): implement CollegeScoped multi-tenancy global scope and isolation policies
- Known limitations: None.

## Lessons & Notes
- Global scope query qualification: Using `$model->qualifyColumn('college_id')` avoids column ambiguity in Eloquent queries with joins.
- Fail-safe deny: If an authenticated user lacks a university-wide role and has no assigned `college_id`, returning `1 = 0` guarantees fail-safe blocking.
