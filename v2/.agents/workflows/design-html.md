---
description: Design finalization engine that converts plans, mockups, or ideas into production-grade HTML/CSS with realistic content and responsive layout.
---

// turbo-all
# /design-html: Production HTML/CSS Design Engine

Load identity: [persona-gstack-design-html.md](.antigravity/rules/persona-gstack-design-html.md)

## Phase 1: Input Detection & Scope
1. Detect existing design context (approved mockups from `/design-shotgun`, plans from `/plan-ceo-review`, or freeform description).
2. Read project design tokens (`DESIGN.md` or centralized theme classes).

## Phase 2: Design Analysis & Implementation Spec
1. Extract visual layout structure, color palette, typography hierarchy, and component list.
2. Ensure realistic, domain-specific copy (zero placeholder lorem ipsum).

## Phase 3: HTML/CSS Generation
1. Write a self-contained HTML/CSS file with modern CSS custom properties, semantic HTML5 tags, flexbox/grid layout, and responsive breakpoints (375px, 768px, 1024px, 1440px).
2. Ensure high-contrast ratios, clean typography, dark-mode support, and anti-AI-slop design rules.

## Phase 4: Preview & Refinement Loop
1. Open the preview file in the browser or capture viewport screenshots using Antigravity browser tools / Playwright.
2. Present the preview to the user and iterate on targeted adjustments until satisfied.

## Phase 5: Design Token Export & Integration
1. Extract reusable design tokens to `DESIGN.md` if not already present.
2. Offer to integrate the HTML markup or components into the project codebase.
