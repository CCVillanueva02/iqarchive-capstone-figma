---
description: Code quality dashboard that runs tests, linters, type checks, and dead-code audits to compute a weighted health score.
---

// turbo-all
# /health: Code Quality Dashboard

Load identity: [persona-gstack-health.md](.antigravity/rules/persona-gstack-health.md)

## Phase 1: Stack & Tooling Detection
1. Inspect project files to detect available quality tools:
   - **Tests:** `php artisan test`, `bun test`, `pytest`, `cargo test`, `npm test`
   - **Linter:** `php artisan pint --test`, `biome check`, `eslint`, `ruff`
   - **Type Checker:** `phpstan`, `tsc --noEmit`, `mypy`
   - **Dead Code / Hygiene:** `npx knip`, `shellcheck`, unused route/view audits
2. Confirm active check tools with user or proceed with detected defaults.

## Phase 2: Sequential Execution
1. Run each detected tool sequentially using `run_command`.
2. Capture exit codes, duration, and error/warning output snippets (tail 50 lines).

## Phase 3: Composite Scoring
1. Score each category on a 0-10 scale based on error/warning counts and exit codes.
2. Compute the weighted composite health score (redistributing weight for skipped tools).

## Phase 4: Dashboard & Recommendations
1. Display the formatted **Code Health Dashboard** table (Category, Tool, Score, Status, Duration, Details).
2. For categories scoring below 10, list concrete failure outputs and actionable fix commands ranked by impact.
3. Record score in health history for trend tracking.
