# Modular Component Splitting — Task Plan & Implementation Log

## Plan
- **High-level goal:** Split monolithic Vue components (`AppShell.vue` and `Iqa/Index.vue`) into focused sub-components strictly adhering to the 150–200 line cap.
- **Scope:**
  - IN: Extract `navigation.js`, `AppSidebar.vue`, `AppTopbar.vue`, `AppUserMenu.vue` from `AppShell.vue`.
  - IN: Extract `IqaPendingBanner.vue`, `IqaMetricCards.vue`, `IqaSubmissionsTable.vue`, `IqaQuickActions.vue`, `IqaPerformanceLevels.vue` from `Iqa/Index.vue`.
  - IN: Maintain 100% visual parity, DaisyUI classes, and role-based reactivity.
  - OUT: Backend modifications or API route changes.
- **Key decisions:**
  - Standardize partials in `Partials/` subdirectories adjacent to parents.
  - Keep each extracted file under 150–200 lines.
- **Testing strategy:**
  - `npm run build` for template syntax and asset compilation.
  - `php artisan test` for backend regression.
  - Python line count script to prove compliance with the 150–200 line cap.
  - Headless browser verification via Playwright at desktop viewport.

## Implementation Progress
### [2026-09-20 / Session 1]
- [x] Subtask 1: Create Layouts navigation registry and partials (`AppSidebar`, `AppTopbar`, `AppUserMenu`).
- [x] Subtask 2: Refactor `AppShell.vue` down from 616 lines to 180 lines.
- [x] Subtask 3: Create IQA dashboard partials (`PendingBanner`, `MetricCards`, `SubmissionsTable`, `QuickActions`, `PerformanceLevels`).
- [x] Subtask 4: Refactor `Iqa/Index.vue` down from 430 lines to 89 lines.
- [x] Subtask 5: Ran `npm run build` — compiles cleanly in ~880ms.
- [x] Subtask 6: Ran `php artisan test` — all 25 tests passing (149 assertions).
- [x] Subtask 7: Verified via Playwright browser screenshot at `http://127.0.0.1:8000/iqa`.

## Final Status
- Completed: 2026-09-20
- Tests: ✓ (25/25 passing)
- Line Count Cap: ✓ (0 files in `resources/js` > 200 lines)
- Commits: Pending atomic commit

## Lessons & Notes
- Extracting static navigation registries to dedicated ES modules (`navigation.js`) drastically reduces layout file sizes while keeping role definitions easily testable.
- DaisyUI modular partials compose seamlessly with zero style drift when class scopes are preserved.
