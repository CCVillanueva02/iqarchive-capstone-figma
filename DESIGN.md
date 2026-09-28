# IQArchive Design System & Token Specification

**Authority:** Source of truth for all UI design, tokens, typography, colors, and layout components across IQArchive.

---

## 1. Brand Identity & Aesthetic Direction

- **Product:** IQArchive (Bicol University AACCUP Accreditation & Evidence Repository)
- **Design Philosophy:** Executive, calm authority, institutional dignity, clean contrast.
- **Tone:** Academic precision, zero visual clutter, desktop-first productivity (≥1024px).
- **Core Principle:** Always use DaisyUI component primitives (`btn`, `card`, `modal`, `badge`, `table`, `input`, `select`) powered by semantic design tokens defined in `resources/css/app.css`.

---

## 2. Color Palette & Token Reference

### A. Sidebar Blue / Deep Navy Palette (Primary System UI Tone)
*Directly matched to the persistent navigation sidebar background (`#0B1B3D`).*

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-sidebar-blue` | `#0B1B3D` | Navigation sidebar background, primary workstation action buttons ("Upload Document", "Save Office"), dark table header bars, and high-emphasis brand containers. |
| `--color-sidebar-blue-hover` | `#15264A` | Hover state for sidebar-blue buttons, active row selections, and interactive surface elevations. |
| `--color-sidebar-blue-surface` | `#0E214A` | Sub-panels within dark sidebar areas, floating flyout popovers, floating expand toggles, and card active states. |
| `--color-sidebar-blue-dark` | `#081530` | Deepest navy containers, university wordmark bar in sidebar header, and high-contrast terminal/footer strips. |

### B. Institutional Bicol University Blue Palette (`#0038A8`)
*Official university color signifying institutional credibility and academic governance.*

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-bu-blue-50` | `#EFF6FF` | Subtle tinted card backgrounds, active sidebar item backgrounds, info callout banners, and soft table row highlights. |
| `--color-bu-blue-100` | `#DBEAFE` | Light borders for selected office cards, active tab indicator lines, and secondary badge backgrounds. |
| `--color-bu-blue-200` | `#BFDBFE` | Focused form input borders, active checkbox outlines, and modal separator dividers. |
| `--color-bu-blue-300` | `#93C5FD` | Interactive hover rings, secondary tag badges, and subtle progress bars. |
| `--color-bu-blue-500` | `#1D4ED8` | Hyperlinks in content bodies, secondary interactive links, and breadcrumb navigation steps. |
| `--color-bu-blue-600` | `#1E40AF` | Hover states for text links, icons within info cards, and mid-tier blue buttons. |
| `--color-bu-blue-700` | `#0038A8` | Official Bicol University Seal blue, institutional branding badges, secondary headers, and authoritative verification marks. |
| `--color-bu-blue-800` | `#002D8A` | Active text within blue-tinted items (e.g. selected office title), pressed link states, and prominent status pills. |
| `--color-bu-blue-900` | `#002878` | Dark contrast text on light blue backgrounds and high-authority heading accents. |

### C. Institutional Bicol University Orange Palette (`#F26522`)
*Official university accent color signifying energy, high-priority actions, and status emphasis.*

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-bu-orange-50` | `#FFF7ED` | Warm alert banners, subtle warning backgrounds, soft active state cards, and pending notification highlights. |
| `--color-bu-orange-100` | `#FFEDD5` | Warning badge soft fills, draft document status pills, and attention-grabbing badge borders. |
| `--color-bu-orange-200` | `#FED7AA` | Subtle warm borders for pending submissions and attention callouts. |
| `--color-bu-orange-500` | `#F26522` | Official Bicol University Orange, vital call-to-action highlights, active navigation rail indicators, upload indicators, and key metric card accents. |
| `--color-bu-orange-600` | `#D95316` | Hover states on orange action buttons and primary alert icons. |
| `--color-bu-orange-700` | `#C2410C` | Dark orange text on warm light backgrounds, overdue alert copy, and emphasized warnings. |

### D. Neutral Slate Palette (Layout Grids, Content, and Hierarchy)

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-slate-50` | `#F8FAFC` | Workspace background canvas (`bg-base-200`), table header fills, and zebra striping. |
| `--color-slate-100` | `#F1F5F9` | Inner section dividers, card borders, and subtle field backdrops. |
| `--color-slate-200` | `#E2E8F0` | Standard card borders (`card-border`), table cell divider borders, and modal footers. |
| `--color-slate-300` | `#CBD5E1` | Inactive borders, placeholder icons, empty-state illustrations, and disabled element outlines. |
| `--color-slate-400` | `#94A3B8` | Input placeholder text, decorative icons, file metadata subtitles, and pagination controls. |
| `--color-slate-500` | `#64748B` | Secondary body text, table column headers (`th`), date stamps, and helper hints. |
| `--color-slate-600` | `#475569` | Uploader names, table cell content, secondary modal labels, and breadcrumb links. |
| `--color-slate-700` | `#334155` | Fieldset legends, form input labels, dropdown menu options, and active tab labels. |
| `--color-slate-800` | `#1E293B` | Section titles, card titles (`card-title`), modal dialog headings, and directory panel headers. |
| `--color-slate-900` | `#0F172A` | Primary page title (`h1`), high-contrast body text, and dark theme neutral base. |

### E. Semantic Status Color Tokens

| Status Name | Token | Hex | Applications |
| :--- | :--- | :--- | :--- |
| **Success** | `--color-status-success` | `#16A34A` | "IQA Approved" badges, upload success confirmations, and valid OCR validation marks. |
| **Warning** | `--color-status-warning` | `#D97706` | "Draft" document pills, pending review states, and impending deadline reminders. |
| **Error / Security** | `--color-status-error` | `#DC2626` | "Rejected" document badges, form validation errors, deficit indicators, and domain security alerts. |
| **Info** | `--color-status-info` | `#0284C7` | "Dean Approved" badges, informative system banners, and instructional tooltips. |

---

## 3. Typography Scale & Application Guide

Font Stack:
- **Primary Interface:** `'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif`
- **Technical & Tabular:** `'JetBrains Mono', ui-monospace, Menlo, Monaco, Consolas, monospace`

| Scale Token | Size | Line Height | Applications |
| :--- | :--- | :--- | :--- |
| `--text-display` | `2rem` (32px) | `2.25rem` | Major portal titles, hero accreditation statistics, and major scorecard numerals. |
| `--text-heading-xl` | `1.5rem` (24px) | `1.875rem` | Top-level page titles (`h1`, e.g. "Common Documents", "Audit Trail & Compliance Ledger"). |
| `--text-heading-lg` | `1.25rem` (20px) | `1.625rem` | Modal dialog titles, primary section headers, and major dashboard widget headers. |
| `--text-heading-md` | `1rem` (16px) | `1.375rem` | Office titles in document table header, card titles, and criteria section headings. |
| `--text-heading-sm` | `0.875rem` (14px) | `1.25rem` | Panel titles (e.g. "OFFICES"), sub-card headings, and form section group legends. |
| `--text-body-md` | `0.875rem` (14px) | `1.375rem` | Default body copy, modal descriptions, standard table text, and form inputs. |
| `--text-body-sm` | `0.8125rem` (13px) | `1.25rem` | Secondary directory listing items, compact table rows, and dropdown menus. |
| `--text-caption` | `0.75rem` (12px) | `1rem` | Office mandate descriptions, input field helper hints, table column headers (`th`), and status badges. |
| `--text-micro` | `0.6875rem` (11px) | `0.875rem` | File size/extension tags, tabular numeric timestamps, and small status pill text. |

---

## 4. Radii & Surface Elevation Standards

| Radius Token | Value | Applications |
| :--- | :--- | :--- |
| `--radius-selector` | `0.375rem` (6px) | Badges (`badge`), status pills, tags, checkboxes (`checkbox`), and toggles (`toggle`). |
| `--radius-field` | `0.5rem` (8px) | Buttons (`btn`), text inputs (`input`), select menus (`select`), and search fields. |
| `--radius-box` | `0.75rem` (12px) | Cards (`card`), modal boxes (`modal-box`), alerts (`alert`), and floating panels. |

---

## 5. Component Usage Standards

### A. Buttons & Actions
- **Primary Workstation Action:** Use `btn btn-sm bg-sidebar-blue hover:bg-sidebar-blue-hover text-white border-none gap-1.5` or `btn btn-sm btn-primary`.
- **Secondary / Outline Action:** Use `btn btn-sm btn-outline border-sidebar-blue text-sidebar-blue hover:bg-sidebar-blue hover:border-sidebar-blue hover:text-white gap-1.5`.
- **Cancel / Ghost Action:** Use `btn btn-sm btn-ghost text-slate-600 hover:text-slate-900`.
- **Inspect / Row Action:** Use `btn btn-xs btn-ghost text-slate-500 hover:text-primary gap-1`.

### B. Page Headers & Action Bars
- Primary page titles must lead directly as `h1` with an explanatory subtitle below. Never float kicker badges above titles.
- Action controls (export, upload, live pulse) align on the far right of the top page header (`flex items-center justify-between`).
- Keep subordinate table toolbars focused strictly on search queries, filters, and resets.

### C. Office Directory & Documents Table (Split View)
- Left column (2/12 or 3/12 width): Displays the office directory list with active item styled in `bg-bu-blue-50 border-bu-blue-200 text-bu-blue-800`.
- Right column (10/12 or 9/12 width): Displays selected office details, search/status filter bar, and tabular document records.

### D. Audit Trail & Compliance Ledger
- **Metric KPI Strip:** 4-card grid (`grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3`) displaying 24h event volume, document mutations, security alerts, and active colleges.
- **Pinned Data Table:** Uses `table table-zebra table-sm table-pin-rows` with monospace tabular numbers for timestamps and client IP addresses.
- **Slide-Over Detail Drawer:** Right-docked modal (`w-full max-w-lg shadow-2xl border-l border-slate-200`) providing actor context, target model reference, SHA-256 copy action, before/after diff comparison cards, and raw JSON viewer.
- **State Comparison Diffs:**
  - Previous State: `bg-rose-50/70 border border-rose-200 text-rose-900 rounded-lg p-2.5 font-mono text-xs`.
  - Updated State: `bg-emerald-50/70 border border-emerald-200 text-emerald-900 rounded-lg p-2.5 font-mono text-xs`.

### E. StatusBadges & Indicators
- Always use DaisyUI `badge-soft` semantic classes:
  - `badge-success badge-soft text-success-content`: Approved / Endorsed / Milestone Reached.
  - `badge-info badge-soft text-info-content`: Submitted / Dean Approved / Routine Event.
  - `badge-warning badge-soft text-warning-content`: Draft / Needs Revision / Warning Alert.
  - `badge-error badge-soft text-error-content`: Deficit / Rejected / Domain Security Alert.
  - `badge-neutral badge-soft text-base-content/70`: Draft / Unassigned / Univ-Wide Scope.

---

## 6. Motion & Micro-Interaction Standards

1. **Slide-Over Inspection Drawers:**
   - Smooth entrance using `animate-in slide-in-from-right duration-200`.
   - Backdrop dismissal with `bg-slate-900/40 backdrop-blur-[2px] transition-opacity`.
2. **Cryptographic Hash Verification:**
   - One-click copy interaction on SHA-256 strings and IP addresses.
   - Immediate feedback showing `Copied!` with a green checkmark (`Check` icon) for 2,000ms.
3. **Live Engine Heartbeat:**
   - Continuous background ingestion pulse indicator using `relative flex h-2 w-2` with `animate-ping bg-emerald-400` and solid center dot.
4. **Interactive Table Rows:**
   - Hover row highlight `hover:bg-slate-50/80 transition-colors cursor-pointer`.
   - Distinct selected row indicator: `bg-primary/5 font-medium`.

---

## 7. AI Slop Bans & Non-Negotiable Rules

- ❌ **No eyebrow/kicker badges** floating above main page headings (let headings lead).
- ❌ **No decorative gradient text** (use scale, font weight, and color tokens for emphasis).
- ❌ **No repetitive, identical-sized card grids** that fail to convey clear hierarchy.
- ❌ **No emoji or unicode symbols** masquerading as UI icons (use Lucide icons exclusively).
- ❌ **No fake statistics, progress rings, or sparklines** without backing database records.
- ❌ **No ad-hoc hand-coded buttons or inputs** (always use DaisyUI component primitives: `btn`, `input`, `select`, `table`, `card`).
