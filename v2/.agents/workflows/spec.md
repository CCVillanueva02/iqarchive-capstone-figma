---
description: Turn vague intent into a precise, executable spec in five phases (issue authoring & backlog preparation).
---

// turbo-all
# /spec: Author a Backlog-Ready Spec

Load identity: [persona-gstack-spec.md](.antigravity/rules/persona-gstack-spec.md)

## Phase 1: Understand the "Why" & Deduplication
1. Interrogate core intent across 5 fundamental questions: **Who** is affected, **What** is current behavior, **What** is target behavior, **Why now**, and **How** do we measure completion.
2. Run duplicate check (`gh issue list`) if `--dedupe` is enabled to prevent duplicate backlog items.

## Phase 2: Scope & Boundary Locking
1. Lock explicit non-goals ("Out of Scope") to prevent scope creep early.
2. Identify touched systems (files, schemas, endpoints, background workers).
3. Determine ordering constraints and define the crisp MVP cut.

## Phase 3: Technical Interrogation (Code-First)
1. Inspect codebase files, symbols, and dependencies using `view_file` or `grep_search` before asking questions.
2. Interrogate data models, API signatures, error paths, state management, and testing strategy.

## Phase 4: Draft Spec Review
1. Draft the complete specification using the appropriate template (Standard, Epic, or Audit/Cleanup).
2. Present draft to user and iterate until confirmed.

## Phase 5: Quality Gate, Archive & Filing
1. Conduct quality self-review (executability score, zero design ambiguity for implementer).
2. Ensure no live secrets/credentials exist in code blocks.
3. Save local spec archive and file GitHub issue (or output ready-to-paste markdown if CLI unauthenticated).
