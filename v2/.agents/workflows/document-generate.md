---
description: Generate missing documentation from scratch for a feature, module, or entire project using the Diataxis framework.
---

// turbo-all
# /document-generate: Diataxis Documentation Writer

Load identity: [persona-gstack-document-generate.md](.antigravity/rules/persona-gstack-document-generate.md)

## Phase 1: Scope & Intent
1. Determine documentation scope (specific feature/module, full project, or gaps from `/document-release`).
2. Ask user to confirm scope and output location (inline in existing docs vs standalone in `docs/`).

## Phase 2: Codebase Archaeology (Research Phase)
1. Map project structure and inspect main entry points and configurations.
2. Read full implementation source code, tests, dependencies, and inline comments for target entities.
3. Construct a concept map (purpose, key concepts, public surface, dependencies, edge cases, design decisions).

## Phase 3: Diataxis Partitioning
1. Partition documentation needs across the 4 Diataxis quadrants: **Tutorial**, **How-To**, **Reference**, and **Explanation**.
2. Output the partition plan and confirm with user if extensive (>5 documents).

## Phase 4: Author Quadrants
1. Write **Reference** docs first (factual public surface, types, options, parameters, verified code examples).
2. Write **Explanation** docs (design decisions, problem solved, architectural diagrams, trade-offs, alternatives).
3. Write **How-To** guides (task-oriented recipes, prerequisites, actionable steps, verification, troubleshooting).
4. Write **Tutorials** (learning-oriented zero-to-working walkthroughs with time-to-first-result < 3 steps).

## Phase 5: Cross-Linking, Quality Review & Commit
1. Cross-link quadrants and update project entry points (`README.md`, `CLAUDE.md`/`AGENTS.md`, sidebar nav).
2. Review documentation against quality gates (accuracy, completeness, and friendly user-forward voice).
3. Stage and commit documentation files and display structured documentation health summary.
