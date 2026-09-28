# User Activation & Schema Cleanup — Task Plan & Implementation Log

## Plan
- **High-level goal:** Refine the `users` schema by eliminating legacy `password` and `email_verified_at` columns, default new Google OAuth provisioned users to `inactive` status, and implement an administrative approval gate before granting access to institutional accreditation archives.
- **Scope:**
  - Update `0001_01_01_000000_create_users_table.php` and `add_iqarchive_fields_to_users_table.php` (or create a dedicated cleanup migration).
  - Update `User.php` fillables and hidden attributes to remove `password` and `email_verified_at`.
  - Update `UserFactory.php` and test cases that instantiate mock users with dummy passwords.
  - Update `AuthController.php` to set `status: 'inactive'` on newly JIT-provisioned Google accounts and redirect with an informative pending approval message.
  - Add an IQA/Dean user activation action in `AdminController` or `AccreditationController` with audit logging.
- **Key decisions:**
  - Keep authentication strictly delegated to Google Workspace OAuth (@bicol-u.edu.ph).
  - Default status `'inactive'` prevents unauthorized access by non-faculty university account holders (e.g. students or alumni).
- **Edge cases:**
  - Automated feature tests need mock user factories that work without passwords.
  - Existing seeders or dev switcher accounts must be pre-activated (`status: 'active'`) for seamless local development.
- **Testing strategy:**
  - Run `php artisan test --filter=GoogleAuthTest`.
  - Verify JIT creation sets `inactive` status on new accounts.
  - Verify blocked access message on inactive login attempt.

## Implementation Progress
### [Sprint 2 Backlog Initialization]
- [x] Document refined schema in `compliance_step_1.md`
- [x] Register `SEC-05` in `v2/TODOS.md`
- [x] Subtask 1: Migration update for schema cleanup (`password`, `email_verified_at`, `status` default)
- [x] Subtask 2: Update `User.php` and `UserFactory.php`
- [x] Subtask 3: Update `AuthController.php` JIT provisioning logic and flash messages
- [x] Subtask 4: Update automated test suite (`php artisan test`)

## Final Status
- Completed: 2026-09-22
- Tests: ✓ (26/26 tests passing, 157 assertions)
- Security review: ✓ (Gated newly provisioned Google accounts to inactive status with registration audit logging)
- PR/Commits: Branch `v2-module-1`
