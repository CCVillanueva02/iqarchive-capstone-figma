---
description: Final visual craft, typography, contrast, rhythm, and alignment pass before shipping a frontend view.
---

// turbo-all
# /impeccable-polish: Final Visual Quality & Craft Pass

Load identity: [persona-impeccable.md](.agents/rules/persona-impeccable.md)
Enforce rules: [impeccable.md](.agents/rules/impeccable.md)

## Purpose
Perform a high-precision craft pass on a target UI view or component, eliminating visual inconsistencies, awkward padding, weak contrast, or AI slop patterns.

## Execution Steps

1. **Target Identification:**
   - Detect the target Vue component (e.g. `Login.vue`, `DevLogin.vue`, or active screen).
   - Read component template and styles.

2. **The Craft Floor Check:**
   - **Contrast:** Verify all text meets WCAG AA standards against its background.
   - **Typography:** Ensure proper hierarchy, line-heights, tracking (-0.02em to -0.04em), and `tabular-nums` for tables.
   - **Spacing & Rhythm:** Ensure visual groupings are tight and section spacing is generous.
   - **Depth:** Replace harsh borders or generic drop shadows with soft, layered elevation.
   - **Anti-Slop Audit:** Remove eyebrow labels, decorative text gradients, and redundant card wrappers.

3. **Atomic Modification:**
   - Apply edits cleanly to the target component.
   - Run `npm run build` in `v2/src` to ensure clean asset compilation.
   - Run bounded visual check in browser to verify layout stability.
