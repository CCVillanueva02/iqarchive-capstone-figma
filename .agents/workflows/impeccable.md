---
description: Master Impeccable frontend craft engine. Execute high-craft UI/UX commands: init, document, polish, critique, audit, typeset, layout, bolder, quieter, distill, and harden.
---

// turbo-all
# /impeccable: Design & Frontend Craft Suite

Load identity: [persona-impeccable.md](.agents/rules/persona-impeccable.md)
Enforce rules: [impeccable.md](.agents/rules/impeccable.md)

## Routing

When an argument is provided (e.g. `/impeccable init`, `/impeccable polish`, `/impeccable audit`):
Directly route to the matching phase below.

When no argument is provided:
Analyze current workspace state and present options:
1. **init:** Capture project truth in `PRODUCT.md`.
2. **document:** Extract existing design tokens into `DESIGN.md`.
3. **polish:** Final visual craft and alignment pass on current view.
4. **critique:** Heuristic UX review and scoring.
5. **audit:** Technical accessibility and responsive audit.

---

## Command Workflows

### 1. `init`
1. Check for existing `PRODUCT.md` in project root.
2. Interview for core audience, primary workflows, positioning, and hard constraints.
3. Formulate platform facts (`web`, `desktop-only >= 1024px`).
4. Write durable facts into `PRODUCT.md`.

### 2. `document`
1. Scan project design tokens (`v2/src/resources/css/app.css`, Tailwind v4 theme, fonts, components).
2. Generate or update `DESIGN.md` capturing typography, colors, spacing, and shell layouts.

### 3. `polish [target]`
1. Inspect the target view (`Login.vue`, `DevLogin.vue`, etc.) against the **Craft Floor**.
2. Fix micro-alignments, contrast ratios, and spacing hierarchy.
3. Run bounded verification (verify once in browser or test suite).

### 4. `critique [target]`
1. Review target UI across 10 UX dimensions (clarity, cognitive load, affordance, hierarchy).
2. Produce heuristic score card with actionable, atomic improvements.

### 5. `audit [target]`
1. Run WCAG AA contrast check on all foreground/background pairings.
2. Verify interactive touch/click target sizes and keyboard navigation focus states.
3. Confirm viewport behavior at target screen widths.

### 6. Specialized Refinements
- **`typeset`**: Elevate typographic scale, weight contrasts, and tabular numeral alignment.
- **`layout`**: Fix spacing rhythm, visual padding, and column alignment.
- **`bolder`**: Inject distinctive character and elevated visual contrast.
- **`quieter`**: Remove visual noise, excess borders, or decorative clutter.
- **`distill`**: Strip to core essentials, eliminating unnecessary cognitive load.
- **`harden`**: Complete error pathways, empty states, and validation edge cases.
