---
description: Discover and document durable product truth, user personas, workflows, and constraints in PRODUCT.md.
---

// turbo-all
# /impeccable-init: Product Truth & Durable Context

Load identity: [persona-impeccable.md](.agents/rules/persona-impeccable.md)
Enforce rules: [impeccable.md](.agents/rules/impeccable.md)

## Purpose
Capture durable product truth in `PRODUCT.md`. Focus purely on who uses the system, what jobs they perform, what constraints bind the solution, and what architectural boundaries exist. Do not invent aesthetic worlds or colors during init.

## Phase 1: Ingestion & Scan
1. Check if `PRODUCT.md` exists in project root. If already complete, ask which specific facts have become stale.
2. Scan codebase documentation:
   - `v2/docs/architecture.md`
   - `v2/docs/rbac/roles.md`
   - `v2/docs/MODULES.md`
   - `v2/docs/design-system.md`
3. Identify existing roles, college scoping constraints, and authentication requirements.

## Phase 2: Grounding Confirmation
Confirm core product facts:
1. **Primary Users & Roles:** System Administrators, IQA Staff, College Deans, Task Force Members, Internal/External Accreditors, BU Executives.
2. **Core Workflows:** AACCUP accreditation lifecycle, multi-tenant document repository, OCR text extraction, criteria compliance matrices.
3. **Platform Scope:** Web application, desktop-only workstation requirement ($\ge 1024\text{px}$).

## Phase 3: Deliverable
Write or update `PRODUCT.md` at repository root with confirmed facts, architectural bounds, and explicit open decisions.
