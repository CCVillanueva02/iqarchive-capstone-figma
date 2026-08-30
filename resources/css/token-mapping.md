# IQArchive Design System & Token Specification

This document serves as the single source of truth for design tokens, sizing scales, and Tailwind CSS v4 conventions across all Blade templates and stylesheets in the IQArchive project.

---

## 1. Color Token Mapping (`resources/css/app.css`)

All colors are centralized in `resources/css/app.css` under the `@theme` directive. Always use semantic token utility classes rather than raw hex or default Tailwind palette classes.

### 1.1 Brand Colors

| Role / Intent | Tailwind Utility Class | CSS Variable Reference | Raw Hex Equivalent | Usage Guidelines |
| :--- | :--- | :--- | :--- | :--- |
| **Primary Navy** | `bg-primary`, `text-primary`, `border-primary` | `var(--color-primary)` | `#1b355a` | Default brand buttons, primary headers, active tab indicators |
| **Primary Hover** | `bg-primary-hover`, `hover:bg-primary-hover` | `var(--color-primary-hover)` | `#004085` | Hover state for primary interactive elements |
| **Primary Dark** | `bg-primary-dark`, `text-primary-dark` | `var(--color-primary-dark)` | `#002b61` | Main sidebar, top navigation header, dark hero panels |
| **Primary Dark Hover**| `hover:bg-primary-dark-hover` | `var(--color-primary-dark-hover)` | `#112239` | Hover state on dark navy surfaces |
| **Primary Light** | `bg-primary-light`, `text-primary-light` | `var(--color-primary-light)` | `#0056b3` | Accent highlights, informational borders, secondary links |
| **Primary Muted** | `text-primary-muted` | `var(--color-primary-muted)` | `#586a85` | Subtitles, helper text under navy headings |
| **Brand Orange** | `bg-brand-orange`, `text-brand-orange`, `focus:ring-brand-orange` | `var(--color-brand-orange)` | `#f47920` | Primary action CTAs, highlight badges, selected indicators |
| **Brand Orange Hover**| `hover:bg-brand-orange-hover` | `var(--color-brand-orange-hover)` | `#d65f1a` | Hover state for orange CTAs |
| **Brand Orange Light**| `bg-brand-orange/10`, `bg-brand-orange/20` | N/A (Tailwind opacity) | Opacity scale | Badge backgrounds, subtle CTA pill accents |

### 1.2 Surface & Neutral Tokens

| Role / Intent | Tailwind Utility Class | CSS Variable Reference | Raw Hex Equivalent | Usage Guidelines |
| :--- | :--- | :--- | :--- | :--- |
| **Subtle Background** | `bg-surface-subtle` | `var(--color-surface-subtle)` | `#f4f6fa` | Main page background, subtle table rows, empty states |
| **Card / Surface** | `bg-surface-card` | `var(--color-surface-card)` | `#f8fafc` | Card backgrounds, dropdown select menus |
| **Zinc Neutral Scale**| `text-zinc-900`, `text-zinc-500`, `border-zinc-200` | `var(--color-zinc-*)` | `#0a0a0a` – `#fafafa` | Standard typography, neutral borders, separators |

### 1.3 Scrollbar Tokens

| Role / Intent | Tailwind / CSS Reference | CSS Variable Reference | Raw Hex Equivalent |
| :--- | :--- | :--- | :--- |
| **Scrollbar Thumb** | `* { scrollbar-color: var(--color-scrollbar-thumb) transparent; }` | `var(--color-scrollbar-thumb)` | `#c4c9d4` |
| **Scrollbar Thumb Hover** | `*::-webkit-scrollbar-thumb:hover` | `var(--color-scrollbar-thumb-hover)` | `#9ca3af` |

### 1.4 Status & Feedback UI (Exemption Rule)

Status and feedback badges use native Tailwind semantic colors directly to maintain universal conventions.

- **Verified / Approved**: `bg-green-100 text-green-700 border-green-200`
- **Pending / In Review**: `bg-amber-100 text-amber-800 border-amber-200`
- **Rejected / Action Required**: `bg-rose-100 text-rose-700 border-rose-200`

> **Rule — Status & Feedback UI Exemption:**
> Status/feedback UI (badges, inline informational/warning banners) uses native Tailwind semantic colors directly and is exempt from brand-token mapping. Brand tokens are reserved for interactive and navigational chrome.

---

## 2. Typography Token Scale (`resources/css/app.css`)

All font sizes are role-based and defined under the `@theme` block. **Never use arbitrary `text-[Npx]` classes.**

| Typography Role | Utility Class | Rem Value | Pixel Equivalent | Typical Usage |
| :--- | :--- | :--- | :--- | :--- |
| **Micro Label** | `text-label-xs` | `0.625rem` | `10px` | Active badges, tiny inline status pills, compact metadata |
| **Small Label** | `text-label` | `0.75rem` | `12px` | Table headers, uppercase category tags, form helper labels |
| **Body Small** | `text-body-sm` | `0.875rem` | `14px` | Secondary buttons, standard table cells, form inputs |
| **Body Standard** | `text-body` | `1rem` | `16px` | Main body paragraphs, navigation links, modal body text |
| **Heading Small** | `text-heading-sm` | `1.125rem` | `18px` | Section subheadings, card titles, drawer headings |
| **Heading Standard**| `text-heading` | `1.5rem` | `24px` | Main section headings, modal titles, instrument titles |
| **Heading Large** | `text-heading-lg` | `2rem` | `32px` | Page titles, primary dashboard hero headers |
| **Hero Title** | `text-hero` | `3rem` | `48px` | Landing page primary hero typography |

---

## 3. Tailwind CSS v4 Linear Spacing & Sizing Scale

Tailwind CSS v4 uses a **continuous linear spacing scale** where each integer unit equals `0.25rem` (`4px`):

$$\text{Scale Unit} = \frac{\text{Pixels}}{4}$$

### 3.1 Common Spacing & Dimension Equivalents

| Pixel Target | Canonical Utility Class | Calculation | Prohibited Arbitrary Pattern |
| :--- | :--- | :--- | :--- |
| **32px** | `min-h-8`, `h-8`, `w-8` | `32 / 4 = 8` | `min-h-[32px]` |
| **44px** | `min-h-11`, `h-11`, `w-11` | `44 / 4 = 11` | `min-h-[44px]` |
| **100px** | `w-25`, `min-w-25`, `max-w-25` | `100 / 4 = 25` | `w-[100px]`, `min-w-[100px]` |
| **120px** | `w-30`, `min-w-30`, `max-w-30` | `120 / 4 = 30` | `w-[120px]`, `max-w-[120px]` |
| **170px** | `w-42.5`, `min-w-42.5`, `max-w-42.5` | `170 / 4 = 42.5` | `w-[170px]`, `min-w-[170px]` |
| **200px** | `min-w-50`, `max-w-50`, `w-50` | `200 / 4 = 50` | `min-w-[200px]`, `max-w-[200px]` |
| **220px** | `w-55`, `md:w-55` | `220 / 4 = 55` | `md:w-[220px]` |
| **240px** | `min-h-60`, `h-60` | `240 / 4 = 60` | `min-h-[240px]`, `h-[240px]` |
| **260px** | `min-w-65` | `260 / 4 = 65` | `min-w-[260px]` |
| **280px** | `min-w-70`, `max-w-70` | `280 / 4 = 70` | `min-w-[280px]`, `max-w-[280px]` |
| **320px** | `max-w-xs`, `w-80` | Canonical 20rem / `320 / 4 = 80` | `max-w-[320px]` |
| **400px** | `min-h-100` | `400 / 4 = 100` | `min-h-[400px]` |
| **440px** | `max-w-110` | `440 / 4 = 110` | `max-w-[440px]` |
| **460px** | `max-w-115` | `460 / 4 = 115` | `max-w-[460px]` |
| **480px** | `max-w-120` | `480 / 4 = 120` | `max-w-[480px]` |
| **650px** | `h-162.5` | `650 / 4 = 162.5` | `h-[650px]` |

---

## 4. Standard Border Radius Scale

Never use arbitrary bracket pixels for standard border radii:

| Pixel Target | Rem Equivalent | Canonical Utility Class | Prohibited Arbitrary Pattern |
| :--- | :--- | :--- | :--- |
| **12px** | `0.75rem` | `rounded-xl` | `rounded-[12px]` |
| **16px** | `1rem` | `rounded-2xl` | `rounded-[16px]` |
| **24px** | `1.5rem` | `rounded-3xl` | `rounded-[24px]` |
| **Full / Capsule** | `9999px` | `rounded-full` | `rounded-[9999px]` |

---

## 5. Dynamic Z-Index Scale

Tailwind v4 supports dynamic integer z-indices natively without bracket notation:

- Use `z-9999` (NOT `z-[9999]`)
- Use `z-600` (NOT `z-[600]`)
- Use `z-310` (NOT `z-[310]`)
- Use `z-300` (NOT `z-[300]`)
- Use `z-250` (NOT `z-[250]`)
- Use `z-200` (NOT `z-[200]`)

---

## 6. Tailwind CSS v4 Modern Syntax Standards

Always use standard Tailwind v4 syntax:

| Legacy Tailwind v3 Syntax | Modern Tailwind v4 Standard | Context |
| :--- | :--- | :--- |
| `bg-gradient-to-r` | `bg-linear-to-r` | Linear gradient direction |
| `bg-gradient-to-br` | `bg-linear-to-br` | Linear gradient direction |
| `break-words` | `wrap-break-word` | Text wrapping utility |
| `!p-0`, `!hidden` | `p-0!`, `hidden!` | Important modifier placement |

---

## 7. Legitimate Arbitrary Value Exceptions

Arbitrary bracket notation `[...]` is ONLY permissible for values that have no exact canonical equivalent:

1. **Sub-Pixel & Fractional Line Widths:**
   - `border-[1.5px]`, `w-[1.5px]`, `h-[3px]`, `mb-[2px]` (custom sub-pixel borders, thin dividers, and Flux UI internal adjustments).
2. **Organic Hero Curves:**
   - `rounded-[2.5rem]`, `md:rounded-[4rem]` (landing hero card geometry exceeding standard `rounded-3xl`).
3. **Viewport Height Ratios & Custom Calc:**
   - `h-[95vh]`, `min-h-[75vh]`, `max-h-[85vh]` (modal and view constraints).
   - `min-h-[calc(100vh-64px)]` (layout height accounting for fixed navigation bar).
4. **One-Off Decorative Gradients:**
   - `bg-[#7c3a00]` in [welcome.blade.php:59](file:///c:/Users/janss/Herd/iqarchive/resources/views/welcome.blade.php#L59) (decorative landing page button hover).
   - `via-[#091E3A]`, `to-[#040D1A]` in [⚡profile.blade.php:192](file:///c:/Users/janss/Herd/iqarchive/resources/views/pages/settings/%E2%9A%A1profile.blade.php#L192) (decorative profile banner gradient).