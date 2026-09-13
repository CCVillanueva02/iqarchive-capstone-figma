---
description: Design shotgun exploration engine that generates multiple distinct UI variants, creates comparison boards, and locks in approved directions.
---

// turbo-all
# /design-shotgun: Multi-Variant Design Exploration

Load identity: [persona-gstack-design-shotgun.md](.antigravity/rules/persona-gstack-design-shotgun.md)

## Phase 1: Context & Intent Gathering
1. Gather core context (audience, user goals, existing design system in `DESIGN.md`, key user flows, edge cases).
2. Read project taste memory or prior approved design directions.

## Phase 2: Distinct Concept Formulation
1. Formulate 3–5 distinct visual directions (e.g. Minimalist Data-Dense, Card-Based Modern, Editorial High-Contrast).
2. Enforce the **Anti-Convergence Directive**: each variant must use distinct font pairings, color palettes, and layout rhythms.
3. Present concept briefs to user for quick alignment.

## Phase 3: Multi-Variant Generation
1. Generate parallel visual directions (HTML mockups or UI artifacts using `generate_image` / static HTML).
2. Save variants to `docs/designs/<screen-name>/` or local preview paths.

## Phase 4: Comparison Board & Feedback Loop
1. Present the variants side-by-side or launch a comparison board in the browser.
2. Collect structured user ratings (1-5 stars, likes, dislikes, element remixing).
3. Confirm final feedback and save approved configuration to `approved.json`.

## Phase 5: Handoff to Production Implementation
1. Suggest next action (hand off approved design to `/design-html` for full production coding, or iterate on selected variant).
