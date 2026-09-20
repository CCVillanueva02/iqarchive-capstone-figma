---
trigger: always_on
description: Impeccable frontend craft engine, design quality floor, and UI anti-pattern defenses.
---

# Impeccable: Design & Frontend Craft Rules

When performing any frontend UI/UX design, auditing, styling, or component refactoring, follow these **Impeccable** standards.

## 1. Setup & Design Context
- Check for existing design authorities: [`DESIGN.md`](file:///c:/Users/janss/Herd/iqarchive/DESIGN.md) and [`PRODUCT.md`](file:///c:/Users/janss/Herd/iqarchive/PRODUCT.md) in the project root.
- The launcher command is located at:
  ```powershell
  .\.agents\skills\impeccable\scripts\impeccable.cmd <command>
  ```
- If the launcher is ever unavailable, read `PRODUCT.md` and `DESIGN.md` directly without guessing or inventing facts.

## 2. Command Index

| Command | Action | Description |
| :--- | :--- | :--- |
| **`init`** | Build | Captures durable product truth into `PRODUCT.md` without inventing styles. |
| **`document`** | Build | Generates or updates `DESIGN.md` from the current active codebase. |
| **`polish`** | Refine | Final visual quality, hierarchy, rhythm, and alignment pass before shipping. |
| **`critique`** | Evaluate | Heuristic UX evaluation across 10 dimensions with actionable scoring. |
| **`audit`** | Evaluate | Technical accessibility (WCAG AA), responsiveness, and performance audit. |
| **`typeset`** | Enhance | Elevates typography hierarchy, scale steps, line heights, and letter spacing. |
| **`layout`** | Enhance | Refines whitespace, visual rhythm, alignment grids, and density. |
| **`bolder`** | Refine | Amplifies bland or overly timid interfaces with purposeful character. |
| **`quieter`** | Refine | Calms over-stimulating, noisy, or excessively decorated layouts. |
| **`distill`** | Refine | Strips non-essential elements, clarifying the interface to its core essence. |
| **`harden`** | Refine | Completes error pathways, empty states, loading skeletons, and edge cases. |
| **`animate`** | Enhance | Adds purposeful micro-animations with exponential ease-out curves. |
| **`colorize`** | Enhance | Introduces strategic, accessible color palettes that fit institutional branding. |
| **`shape`** | Plan | Plans UI structure, user journey, and information architecture before coding. |

## 3. The Craft Floor (Non-Negotiable)

1. **Contrast & Legibility:**
   - Body & placeholder text must maintain $\ge 4.5:1$ contrast ratio.
   - Large headings must maintain $\ge 3:1$ contrast ratio.
   - Secondary text on colored backgrounds must be tinted from the surface hue, never flat gray.

2. **Depth & Lighting:**
   - Elevation must be declared intentionally via subtle borders or soft, layered shadows.
   - Never use harsh zero-blur offset block shadows unless strictly neobrutalist.
   - Card border radii should stay restrained ($12\text{px}$ to $16\text{px}$).

3. **Typography & Rhythm:**
   - Body text width must stay between $65\text{ch}$ and $75\text{ch}$ for optimal reading comfort.
   - More vertical whitespace must exist **above** a heading than below it to ensure correct visual grouping.
   - Use `tabular-nums` for tables, numerical counters, and dates to avoid jagged columns.

4. **States & Feedback:**
   - Every interactive control must provide distinct `:hover`, `:focus-visible`, `:active`, and `:disabled` styles.
   - Always implement authentic empty states and loading skeletons instead of generic spinners.

5. **AI Slop Bans:**
   - ❌ **No eyebrow/kicker badges** floating above main headings (let headings lead).
   - ❌ **No decorative gradient text** (use scale and weight for emphasis).
   - ❌ **No repetitive, identical-sized card grids** (vary layout density to convey hierarchy).
   - ❌ **No emoji or unicode symbols** masquerading as UI icons (use Lucide / Heroicons).
   - ❌ **No fake statistics, progress rings, or sparklines** that don't represent real data.
